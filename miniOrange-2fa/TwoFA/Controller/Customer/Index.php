<?php

namespace MiniOrange\TwoFA\Controller\Customer;

use Magento\Framework\App\RequestInterface;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use MiniOrange\TwoFA\Helper\MiniOrangeUser;
use MiniOrange\TwoFA\Helper\Curl;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $request;
    protected $twofautility;
    protected $resultFactory;
    protected $storeManager;
    protected $messageManager;
    private $url;
    private $cookieMetadataFactory;
    private $cookieManager;
    private $customerSession;
    private $groupRepository;

    public function __construct(
        \Magento\Framework\App\Action\Context                  $context,
        RequestInterface                                       $request,
        TwoFAUtility                                           $twofautility,
        \Magento\Framework\Controller\ResultFactory            $resultFactory,
        \Magento\Framework\UrlInterface                        $url,
        \Magento\Store\Model\StoreManagerInterface             $storeManager,
        \Magento\Framework\Message\ManagerInterface            $messageManager,
        \Magento\Framework\Stdlib\CookieManagerInterface       $cookieManager,
        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory,
        \Magento\Customer\Model\Session                       $customerSession,
        \Magento\Customer\Api\GroupRepositoryInterface        $groupRepository

    )
    {
        $this->request = $request;
        $this->twofautility = $twofautility;
        $this->resultFactory = $resultFactory;
        $this->url = $url;
        $this->messageManager = $messageManager;
        $this->storeManager = $storeManager;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->cookieManager = $cookieManager;
        $this->customerSession = $customerSession;
        $this->groupRepository = $groupRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->twofautility->log_debug("Customer/Index.php : execute");
        $postValue = $this->request->getPostValue();
        $customerData = $this->customerSession->getCustomer()->getData();

        //todo: If user is not logged in, redirect to login page
        if(!$customerData) {
            $this->messageManager->addErrorMessage("Something went wrong. Please try logging in again.");
            $redirect_url = $this->url->getUrl('customer/account/login');
            $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
            $redirect->setUrl($redirect_url);
            return $redirect;
        }else{
            // fetch customer email from session
            $customerEmail =$customerData['email'];
            $this->twofautility->setSessionValue('mousername', $customerEmail);
            $this->twofautility->flushCache();
            $this->twofautility->reinitConfig();
        }

        $username = $customerData['email'];
        $groupId = $customerData['group_id'];
        $current_website_id = $this->twofautility->getWebsiteOrStoreBasedOnTrialStatus();
        $row = $this->twofautility->getAllMoTfaUserDetails('miniorange_tfa_users', $username, $current_website_id);
        $this->twofautility->setSessionValue('mousername', $username);

        // reset 2FA
        if (isset($postValue['reset_twofa'])) {
            $publicCookieMetadata = $this->cookieMetadataFactory->createPublicCookieMetadata();
            $publicCookieMetadata->setDurationOneYear();
            $publicCookieMetadata->setPath('/');
            $publicCookieMetadata->setHttpOnly(false);
            $this->cookieManager->setPublicCookie('mousername', $username, $publicCookieMetadata);

            if (is_array($row) && sizeof($row) > 0) {
                $idvalue = $row[0]['id'];
                $this->twofautility->deleteRowInTable('miniorange_tfa_users', 'id', $idvalue);
            }
            $customerGroup = $this->groupRepository->getById($groupId);
            $customer_role_name = $customerGroup->getCode();
            $this->twofautility->setSessionValue(TwoFAConstants::CUSTOMER_WEBSITE_ID, $current_website_id);

            $twofaMethods = $this->twofautility->getCustomer2FAMethodsFromRules($customer_role_name, $current_website_id);
            $number_of_activeMethod = $twofaMethods['count'];

            if ($number_of_activeMethod == NULL || $number_of_activeMethod == 0) {
                $this->messageManager->addErrorMessage("You cannot configure Two Factor Authentication method.");
                $redirect_url = $this->url->getUrl('motwofa/customer');
            } elseif ($number_of_activeMethod == 1) {
                $customer_active_method = trim($twofaMethods['methods'], '[""]');
                $redirect_url = $this->url->getUrl('motwofa/mocustomer') . "?mopostoption=method&inline_one_method=1&miniorangetfa_method=" . $customer_active_method;
            } elseif ($number_of_activeMethod > 1) {
                $redirect_url = $this->url->getUrl('motwofa/mocustomer') . "?mooption=invokeInline&step=ChooseMFAMethod";
            }

            $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
            $redirect->setUrl($redirect_url);
            $this->twofautility->flushCache();
            $this->twofautility->reinitConfig();
            return $redirect;
        }

        // reset KBA
        if (isset($postValue['reset_kba'])) {
            $isset_kba = $this->twofautility->getStoreConfig('kba_method' . $current_website_id);
            $questionSet1 = $this->twofautility->getStoreConfig('question_set_string1' . $current_website_id);
            $questionSet2 = $this->twofautility->getStoreConfig('question_set_string2' . $current_website_id);

            if (!is_array($row) || sizeof($row) <= 0) {
                $this->messageManager->addErrorMessage("Please configure Two Factor Authentication method first.");
                $redirect_url = $this->url->getUrl('motwofa/customer');
            } elseif ($isset_kba == NULL || $isset_kba == 0 || $questionSet1 == NULL || $questionSet2 == NULL) {
                $this->messageManager->addErrorMessage("You cannot configure KBA Backup method.");
                $redirect_url = $this->url->getUrl('motwofa/customer');
            } else {
                $redirect_url = $this->url->getUrl('motwofa/mocustomer') . "?mooption=invokeInline&step=KBA_Question";
            }

            $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
            $redirect->setUrl($redirect_url);
            $this->twofautility->flushCache();
            $this->twofautility->reinitConfig();
            return $redirect;
        }

        // toggle authenticator
        if(isset($postValue['toggle_authenticator']) || isset($postValue['action']) == 'toggle_authenticator') {
            $is_active = $postValue['is_active'];
            

            // method
            $method = $postValue['authenticator_method'];

            // Fetch current "all_active_methods" array from existing user row.
            // Note: $row should be the array of the current tfa user (from db), as in surrounding code.
            $current_all_active_methods = isset($postValue['all_active_methods']) ? $postValue['all_active_methods'] : '[]';
            // Decode it safely
            $all_active_methods_array = [];
            if(is_string($current_all_active_methods)) {
                $decoded = json_decode($current_all_active_methods, true);
                if(is_array($decoded)) {
                    $all_active_methods_array = $decoded;
                }
            }

            // Add or remove the method from the all_active_methods as per $is_active
            if ($is_active) {
                // Add the method if not present
                if (!in_array($method, $all_active_methods_array)) {
                    $all_active_methods_array[] = $method;
                }
            } else {
                // Remove the method if present
                $all_active_methods_array = array_values(array_filter($all_active_methods_array, function($value) use ($method) {
                    return $value !== $method;
                }));
            }

            // Optionally: remove duplicates just in case
            $all_active_methods_array = array_unique($all_active_methods_array);

            // Encode it back for storing
            $all_active_methods = json_encode($all_active_methods_array);

            $website_id = $this->storeManager->getStore()->getWebsiteId();
            $email = $postValue['customerEmail'];

            $this->twofautility->updateColumnInTable('miniorange_tfa_users', 'all_active_methods', $all_active_methods, 'username', $email, $website_id);

            $redirect_url = $this->url->getUrl('motwofa/customer/?method='.$method);
            $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
            $redirect->setUrl($redirect_url);
            return $redirect;
        }

        // save authenticator
        if(isset($postValue['save_authenticator'])) {
            $passcode = $postValue['passcode'];
            $secret = $postValue['secret'];
            $email = $postValue['customerEmail'];
            $response = $this->twofautility->verifyGauthCodeViaConfigurationPage($passcode, $secret);
            $response = json_decode($response, true);
           
        // verify response status
           if($response['status'] == 'SUCCESS') {
            $this->messageManager->addSuccessMessage("Authentificateur enregistré avec succès.");
            $website_id = $this->storeManager->getStore()->getWebsiteId();
            // save value in database with verification flag
            $dataToSave = json_encode(['verified', $secret]);

            $method = $postValue['authenticator_method'];
            if($method == 'GoogleAuthenticator') {
                $this->twofautility->updateColumnInTable('miniorange_tfa_users', 'google_authenticator_secret', $dataToSave, 'username', $email, $website_id);
                $this->twofautility->updateColumnInTable('miniorange_tfa_users', 'secret', $secret, 'username', $email, $website_id);

            } else if($method == 'MicrosoftAuthenticator') {
                $this->twofautility->updateColumnInTable('miniorange_tfa_users', 'microsoft_authenticator_secret', $dataToSave, 'username', $email, $website_id);
                $this->twofautility->updateColumnInTable('miniorange_tfa_users', 'secret', $secret, 'username', $email, $website_id);
            }


            $redirect_url = $this->url->getUrl('motwofa/customer?authenticator=verified');
            $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
            $redirect->setUrl($redirect_url);
            return $redirect;
           }
           else {
            $this->messageManager->addErrorMessage("Code OTP invalide.");
            $redirect_url = $this->url->getUrl('motwofa/customer');
            $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
            $redirect->setUrl($redirect_url);
            return $redirect;
           }
        }

        // validate OTP
        if(isset($postValue['mopostoption']) && $postValue['mopostoption'] == 'uservalotp') {

            $email = $postValue['email'];

            $method = $postValue['active_method'];

            if(isset($postValue['Passcode'])) {
                // verify the passcode

                $passcode = $postValue['Passcode'];
                $phone = $postValue['phone'];
                $countryCode = $postValue['countrycode'];

                $response = $this->TFAValidate($passcode, $email, $phone, $method);
                if($response['status'] == 'SUCCESS') {

                    // update the phone number and country code in the database
                    $phone = $postValue['phone'];
                    $countryCode = $postValue['countrycode'];
                    $this->twofautility->updateColumnInTable('miniorange_tfa_users', 'phone', $phone, 'username', $email, $current_website_id);
                    $this->twofautility->updateColumnInTable('miniorange_tfa_users', 'countrycode', $countryCode, 'username', $email, $current_website_id);

                    $this->messageManager->addSuccessMessage("Code OTP vérifié avec succès.");
                    $redirect_url = $this->url->getUrl('motwofa/customer');
                    $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
                    $redirect->setUrl($redirect_url);
                    return $redirect;
                }
                else {
                    $this->messageManager->addErrorMessage("Code OTP invalide.");
                    $redirect_url = $this->url->getUrl('motwofa/customer');
                    $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
                    $redirect->setUrl($redirect_url);
                    return $redirect;
                }
            }
            
        }

        // Ensure a result is returned when no form is posted
        $this->_view->loadLayout();
        $this->_view->renderLayout();

    }

    /**
     * Function to validate the otp for the user
     */
    public function TFAValidate($passcode, $current_username,$phone, $customer_device_enabled,$method = '')
    {

            //2nd time validation here
            $this->twofautility->log_debug("Customer/Index.php : execute: TFAValidate");
            $current_website = $this->storeManager->getStore()->getWebsiteId();

            $row = $this->twofautility->getCustomerMoTfaUserDetails('miniorange_tfa_users', $current_username);

            if(isset($method) && $method != '') {
                $this->twofautility->log_debug("Customer/Index.php : TFAValidate method passed from alternate 2fa page controller: " . $method);
            } else {
                if ((is_array($row) && sizeof($row) > 0) && isset($row[0]['active_method'])) {
                    $method = $row[0]['active_method'];
                    $this->twofautility->log_debug("Customer/Index.php : TFAValidate checking user in miniorange_tfa_users method=>: " . ($method));
                } else {
                    $method = 'OOS';
                }
            }

            $this->twofautility->log_debug("Customer/Index.php : TFAValidate method: " . $method);

            $custom_gateway_email = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
            $custom_gateway_sms = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
            $custom_gateway_whatsapp = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);


            $send_via_customgateway = false;
            if ($method == 'OOE' && $custom_gateway_email) {
                $send_via_customgateway = true;
            } elseif ($method == 'OOS' && $custom_gateway_sms) {
                $send_via_customgateway = true;
            } elseif ($method == 'OOSE') {
                $send_via_customgateway = true;
            } elseif ($method == 'OOW' && $custom_gateway_whatsapp) {
                $send_via_customgateway = true;
            }
            if ((($custom_gateway_email || $custom_gateway_sms) && $send_via_customgateway)) {

                //custom gateway is enabled. validate otp for set customer
                $this->twofautility->log_debug("Customer/Index.php : TFAValidate: Custom gateway");

                $result = $this->twofautility->customgateway_validateOTP($passcode);
                $response = array('status' => $result);

            } else {
                $response = $this->validate($current_username, $passcode, $method, NULL, true);
                $response = json_decode($response);
                $response = array('status' => $response->status);
                $this->twofautility->log_debug("Customer/Index.php : execute: TFAValidate: Method response");
            }
        


        if ($response['status'] == 'SUCCESS') {

            $this->twofautility->log_debug("Customer/Index.php : execute: TFAValidate: otp is valid");
            if ((is_array($row) && sizeof($row) <= 0)) {
                $this->twofautility->log_debug("Customer/Index.php :customer not found in database for 2nd time otp validation {something is missing}, insertion new row");

                $email = $this->twofautility->getSessionValue('mousername');
                $current_username = isset($email) ? $email : $current_username;

                $active_method = $method;
                $config_method = $method;
                $temp_secret = $this->twofautility->generateRandomString();
                $website_id = $current_website;
                $data = [
                    [
                        'username' => $current_username,
                        'configured_methods' => $config_method,
                        'active_method' => $active_method,
                        'secret' => $temp_secret,
                        'website_id' => $website_id
                    ]
                ];
                $this->twofautility->insertRowInTable('miniorange_tfa_users', $data);

                $transactionID = '1';
                $this->twofautility->updateColumnInTable('miniorange_tfa_users', 'transactionId', $transactionID, 'username', $current_username, $website_id);

                //remove data from session
                $this->twofautility->setSessionValue(TwoFAConstants::CUSTOMER_SECRET, NULL);
                $this->twofautility->setSessionValue(TwoFAConstants::CUSTOMER_USERNAME, NULL);
                $this->twofautility->setSessionValue(TwoFAConstants::CUSTOMER__EMAIL, NULL);
                $this->twofautility->setSessionValue('last_otp_sent_time', NULL);


            }
        }
        return $response;

    }

    /**
     * Function to validate the otp from miniOrange Gateway
     */
    public function validate($username, $token, $authType, $answers = NULL, $isConfiguring = false)
    {
        //This function use to validate otp from miniOrange Gateway
        $this->twofautility->log_debug("Customer/Index.php : execute: validate");
        $customerKeys = $this->twofautility->getCustomerKeys(true);
        $customerKey = $customerKeys['customer_key'];
        $apiKey = $customerKeys['apiKey'];

        //updated changes
        $customer_inline = isset($customer_inline) ? $customer_inline : '1';

        if ($customer_inline) {
            $customerTransactionID = $this->twofautility->getSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID);
            if ($customerTransactionID != null) {
                $transactionID = $customerTransactionID;
            }
        }

        //$transactionID=isset($transactionID) ? $transactionID : '1';

        $authCodes = array('OOE' => 'EMAIL', 'OOS' => 'SMS', 'OOW' => 'SMS', 'OOSE' => 'SMS AND EMAIL');


        if ($isConfiguring) {
            $fields = array(
                'customerKey' => $customerKey,
                'txId' => $transactionID,
                'token' => str_replace(" ", "", $token),
            );
        } else {
            $fields = array(
                'customerKey' => $customerKey,
                'username' => $username,
                'txId' => $transactionID,
                'token' => str_replace(" ", "", $token),
                'authType' => array_key_exists($authType, $authCodes) ? $authCodes[$authType] : $authType,
                'answers' => $answers
            );
        }


        $urls = $this->twofautility->getApiUrls();
        $url = $urls['validate'];
        return Curl::validate($customerKey, $apiKey, $url, $fields);

    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_CUSTOMER_2FA);
    }
}

