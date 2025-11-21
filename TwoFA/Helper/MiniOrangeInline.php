<?php

namespace MiniOrange\TwoFA\Helper;

use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreManagerInterface;
use MiniOrange\TwoFA\Controller\Actions\BaseAdminAction;
use MiniOrange\TwoFA\Helper\MiniOrangeUser;

/**
 * @package     Magento.Site
 * @subpackage  com_miniorange_twofa
 *
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
class MiniOrangeInline extends BaseAdminAction
{


    protected $_customer;
    protected $_customerSession;
    protected $customEmail;
    protected $customSMS;
    protected $_resultPage;
    protected $TwoFACustomerRegistration;
    protected $storeManager;
    protected $twofacustomerregistration;
    private $relayState;
    private $user;
    private $adminSession;
    private $cookieManager;
    private $adminConfig;
    private $cookieMetadataFactory;
    private $customerModel;
    private $adminSessionManager;
    private $urlInterface;
    private $userFactory;
    private $request;
    private $postValue;
    private $customerFactory;
    private $url;
    protected $resultFactory;
    protected $messageManager;

    public function __construct(
        \Magento\Framework\App\Action\Context              $context,
        \MiniOrange\TwoFA\Helper\TwoFAUtility              $TwoFAUtility,
        \Magento\Customer\Model\Customer                   $customer,
        \Magento\Customer\Model\Session                    $customerSession,
        StoreManagerInterface                              $storeManager,
        \Magento\Framework\Stdlib\CookieManagerInterface   $cookieManager,
        \Magento\Customer\Model\Customer                   $customerModel,
        RequestInterface                                   $request,
        \Magento\Framework\UrlInterface                    $url,
        CustomEmail                                        $customEmail,
        CustomSMS                                          $customSMS,
        \MiniOrange\TwoFA\Helper\TwoFACustomerRegistration $TwoFACustomerRegistration,
        \Magento\Framework\Controller\ResultFactory            $resultFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        CustomerFactory                                    $customerFactory
    )
    {
        //You can use dependency injection to get any class this observer may need.
        $this->_customer = $customer;
        $this->storeManager = $storeManager;
        $this->customerModel = $customerModel;
        $this->_customerSession = $customerSession;
        $this->request = $request;
        $this->cookieManager = $cookieManager;
        $this->url = $url;
        $this->customEmail = $customEmail;
        $this->customSMS = $customSMS;
        $this->customerFactory = $customerFactory;
        $this->twofacustomerregistration = $TwoFACustomerRegistration;
        $this->postValue = $this->request->getPostValue();
        $this->resultFactory = $resultFactory;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
    }

    public function thirdStepSubmit($TwoFAUtility, $current_username)
    {

        $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: thirdsetpSubmit");
        // current user who started the flow

        $email = $TwoFAUtility->getSessionValue('mousername');
        $current_user = isset($email) ? $email : $current_username;

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $request = $this->request->getParams();

        if (isset($this->postValue['miniorangetfa_method'])) {
            $method = $this->postValue['miniorangetfa_method'];
        } elseif (isset($request['inline_one_method'])) {
            $method = $request['miniorangetfa_method'];
        }

        //set data in session
        $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: thirdsetpSubmit: setting data into session");
        $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_INLINE, 1);
        $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_USERNAME, $current_username);
        $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_ACTIVE_METHOD, $method);
        $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_CONFIG_METHOD, $method);

        if ($method == 'GoogleAuthenticator' || $method == 'MicrosoftAuthenticator') {
            $temp_secret = $TwoFAUtility->generateRandomString();
            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_SECRET, $temp_secret);
        }

        $redirect_url = '';
        if (isset($method) && !empty($method)) {

            $TwoFAUtility->setSessionValue('step3method', $method);

            if ($method == 'OOE') {
                $redirect_url = $this->url->getUrl('motwofa/mocustomer') . "?mooption=invokeInline&step=OOEMethodValidation";
            } else if ($method == 'OOS') {
                $redirect_url = $this->url->getUrl('motwofa/mocustomer') . "?mooption=invokeInline&step=OOSMethodValidation";
            } else if ($method == 'OOW') {
                $redirect_url = $this->url->getUrl('motwofa/mocustomer') . "?mooption=invokeInline&step=OOWMethodValidation";
            } else if ($method == 'OOSE') {
                $redirect_url = $this->url->getUrl('motwofa/mocustomer') . "?mooption=invokeInline&step=OOSEMethodValidation&useremail=" . $current_user;
            } elseif ($method == 'GoogleAuthenticator') {
                $redirect_url = $this->url->getUrl('motwofa/mocustomer') . "?mooption=invokeInline&step=GAMethodValidation";
            } elseif ($method == 'Authenticator') {
                $redirect_url = $this->url->getUrl('motwofa/mocustomer') . "?mooption=invokeInline&step=AMethodValidation";
            } elseif ($method == 'MicrosoftAuthenticator') {                
                $redirect_url = $this->url->getUrl('motwofa/mocustomer') . "?mooption=invokeInline&step=MicrosoftAuthenticator";
            }
        }
        $TwoFAUtility->flushCache();
        $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: thirdsetpSubmit :sending URL");
        return $redirect_url;
    }

    public function pageFourChallenge($TwoFAUtility, $current_username, $method, $phone, $countrycode)
    {
        //This function is use to send OTP for frontend customer
        $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: PageFourChallenge :send otp");
        $current_website = $this->storeManager->getStore()->getWebsiteId();
        $user = new miniOrangeUser();

        $email = $TwoFAUtility->getSessionValue('mousername');
        $email = NULL;
        $current_user = isset($email) ? $email : $current_username;
        $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: PageFourChallenge :email=> " . $current_user);

        $method_name = $TwoFAUtility->getSessionValue('step3method');
        $method = isset($method_name) ? $method_name : $method;
        $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: PageFourChallenge :method=> " . $method);

        $request = $this->request->getParams();
        if (isset($request['inline_one_method'])) {
            $this->postValue = $request;
        }
        if (isset($this->postValue['phone'])) {
            $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: PageFourChallenge:phone set");
            $phone = $this->postValue['phone'];
            $countrycode = $this->postValue['countrycode'];

            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER__PHONE, $phone);
            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_COUNTRY_CODE, $countrycode);
        }

        //----------------------fix----------------------------
        if (isset($this->postValue['email']) && $this->postValue['email'] != NULL) {
            $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: PageFourChallenge:email set");
            $email = $this->postValue['email'];
            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER__EMAIL, $email);

            //  updated changes
            $TwoFAUtility->setSessionValue('mousername', $email);


        } elseif (isset($this->postValue['miniorangetfa_method']) && $this->postValue['miniorangetfa_method'] == 'OOE') {
            $email = $current_user;
            $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: PageFourChallenge else if:email set");
            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER__EMAIL, $email);

            //  updated changes
            $TwoFAUtility->setSessionValue('mousername', $email);
        }

        // ---------------------------fix-------------------------

        $custom_gateway_email = $TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
        $custom_gateway_sms = $TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
        $custom_gateway_whatsapp = $TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);

        if ($custom_gateway_email || $custom_gateway_sms) {
            $TwoFAUtility->log_debug("miniOrange.php : execute: Custom gateway");
            //custom gateway is enabled
            if (((isset($this->postValue['miniorangetfa_method']) && $this->postValue['miniorangetfa_method'] == 'OOE') || $method == 'OOE') && $custom_gateway_email) {
                $custom_gateway_otp = $TwoFAUtility->Customgateway_GenerateOTP();
                $to = $current_user;
                $return_response = $this->customEmail->sendCustomgatewayEmail($to, $custom_gateway_otp);
            } elseif ($method == 'OOE') {
                $send_otp_response = json_decode($user->challenge($current_user, $TwoFAUtility, $method, true, $current_website));
                // Check if response is null or indicates error
                if ($send_otp_response === null) {
                    $TwoFAUtility->log_debug("MiniOrange gateway returned null response for user: " . $current_user);
                    $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
                    $resultRedirect->setPath('customer/account/login');
                    return $resultRedirect;
                }

                if (isset($send_otp_response) && $send_otp_response->status === 'error') {
                    $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
                    $TwoFAUtility->log_debug("MiniOrange gateway returned error response for user");
                    $resultRedirect->setPath('customer/account/login');
                    return $resultRedirect;
                }
                $return_response = array(
                    'status' => $send_otp_response->status,
                    'message' => $send_otp_response->message,
                    'txId' => $send_otp_response->txId ?? '1'
                );
            }
            if (((isset($this->postValue['miniorangetfa_method']) && $this->postValue['miniorangetfa_method'] == 'OOS') || $method == 'OOS') && $custom_gateway_sms) {
                $sms_otp = $TwoFAUtility->Customgateway_GenerateOTP();

                //
                $phone = '+' . $countrycode . $phone;
                $return_response = $this->customSMS->send_customgateway_sms($phone, $sms_otp);
            } elseif ($method == 'OOS') {

                $send_otp_response = json_decode($user->challenge($current_user, $TwoFAUtility, $method, true, $current_website));
                // Check if response is null or indicates error
                if ($send_otp_response === null) {
                    $TwoFAUtility->log_debug("MiniOrange gateway returned null response for user: " . $current_user);
                    $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
                    $resultRedirect->setPath('customer/account/login');
                    return $resultRedirect;
                }

                if (isset($send_otp_response) && $send_otp_response->status === 'error') {
                    $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
                    $TwoFAUtility->log_debug("Execute LoginPost: Username or password null");
                    $resultRedirect->setPath('customer/account/login');
                    return $resultRedirect;
                }
                $return_response = array(
                    'status' => $send_otp_response->status,
                    'message' => $send_otp_response->message,
                    'txId' => $send_otp_response->txId ?? '1'
                );
            }

            // OOW
            if (((isset($this->postValue['miniorangetfa_method']) && $this->postValue['miniorangetfa_method'] == 'OOW') || $method == 'OOW') && $custom_gateway_whatsapp) {
                $sms_otp = $TwoFAUtility->Customgateway_GenerateOTP();

                $phone = $countrycode . $phone;

                $return_response = $TwoFAUtility->send_customgateway_whatsapp($phone, $sms_otp);
            } elseif ($method == 'OOW') {

                $sms_otp = $TwoFAUtility->Customgateway_GenerateOTP();

                $phone = $countrycode . $phone;
                $return_response = $TwoFAUtility->send_whatsapp($phone, $sms_otp);
            }

            if ((isset($this->postValue['miniorangetfa_method']) && $this->postValue['miniorangetfa_method'] == 'OOSE') || $method == 'OOSE') {

                $custom_gateway_otp = $TwoFAUtility->Customgateway_GenerateOTP();
                $to = $current_user;
                $phone = '+' . $countrycode . $phone;
                if ($custom_gateway_email) {
                    $result_email = $this->customEmail->sendCustomgatewayEmail($to, $custom_gateway_otp);
                } else {
                    $result_email['status'] = 'FAILED';
                }
                if ($custom_gateway_sms) {
                    $result_sms = $this->customSMS->send_customgateway_sms($phone, $custom_gateway_otp);
                } else {
                    $result_sms['status'] = 'FAILED';
                }


                $message = $TwoFAUtility->OTP_over_SMSandEMAIL_Message($to, $phone, $result_email['status'], $result_sms['status']);
                if ($result_email['status'] == 'SUCCESS' || $result_sms['status'] == 'SUCCESS') {
                    $return_response = array(
                        'status' => 'SUCCESS',
                        'message' => $message,
                        'txId' => '1'
                    );
                } else {
                    $return_response = array(
                        'status' => 'FAILED',
                        'message' => $message,
                        'txId' => '1'
                    );
                }
            }

            //   otp expiry set
            $is_otp_expiry_time_set = 600;
            if ($return_response['status'] == 'SUCCESS') {
                // Get current timestamp
                $currentTime = time();

                // Calculate OTP expiry time
                $otpExpiryTime = $currentTime + $is_otp_expiry_time_set;
                $expiry_seconds = $is_otp_expiry_time_set % 60;
                // Log the expiry time in minutes:seconds format
                $TwoFAUtility->log_debug("MiniOrangeInline.php : OTP expiry set for " . $expiry_seconds . " seconds");

                // Store OTP expiry time in session
                $TwoFAUtility->setSessionValue('otp_expiry_time', $otpExpiryTime);
            }


        } else if ($method == 'OOW') {
            if (((isset($this->postValue['miniorangetfa_method']) && $this->postValue['miniorangetfa_method'] == 'OOW') || $method == 'OOW') && $custom_gateway_whatsapp) {
                $sms_otp = $TwoFAUtility->Customgateway_GenerateOTP();

                $phone = $countrycode . $phone;

                $return_response = $TwoFAUtility->send_customgateway_whatsapp($phone, $sms_otp);
            } elseif ($method == 'OOW') {
                $sms_otp = $TwoFAUtility->Customgateway_GenerateOTP();

                $phone = $countrycode . $phone;
                $return_response = $TwoFAUtility->send_whatsapp($phone, $sms_otp);
            }
        } else {
            $send_otp_response = json_decode($user->challenge($current_user, $TwoFAUtility, $method, true, $current_website));
            // Check if response is null
            if ($send_otp_response === null) {
                $TwoFAUtility->log_debug("MiniOrange gateway returned null response for user: " . $current_user . " method: " . $method);
                $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setPath('customer/account/login');
                return $resultRedirect;
            }
            
            if(isset($send_otp_response) && $send_otp_response->status ==='error')
            {
                $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
                $TwoFAUtility->log_debug("Execute LoginPost: Username or password null");
                $resultRedirect->setPath('customer/account/login');
                return $resultRedirect;
            }
            $return_response = array(
                'status' => $send_otp_response->status,
                'message' => $send_otp_response->message,
                'txId' => $send_otp_response->txId
            );
        }

        if ($return_response['status'] == 'SUCCESS') {
            $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: PageFourChallenge:response success");
            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID, $return_response['txId']);

        } elseif ($return_response['status'] == 'FAILED') {
            $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: PageFourChallenge: response failed");
        } else {
            $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: PageFourChallenge: response failed ,something went wrong");
            $return_response['status'] == 'FAILED';
        }

        return $return_response;
    }

    public function pageFourValidate($TwoFAUtility, $current_username, $method, $customer_device_enabled, $phone, $countrycode)
    {
        //This function validate OTP of frontend Customers

        $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: PageFourValidate");
        $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: passcode", $this->postValue['Passcode']);

        $current_website = $this->storeManager->getStore()->getWebsiteId();
        $user = new miniOrangeUser();

        $email = $TwoFAUtility->getSessionValue('mousername');
        $current_user = isset($email) ? $email : $current_username;
        $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: pageFourValidate :current_user => " . $current_user);
        $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: passcode", $this->postValue['Passcode']);


        $method_name = $TwoFAUtility->getSessionValue('step3method');
        $method = isset($method_name) ? $method_name : $method;
        $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: pageFourValidate :method=> " . $method);

        $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: passcode", $this->postValue['Passcode']);

        $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: PageFourValidate method name" . $method);

        if ("GoogleAuthenticator" == $method || "MicrosoftAuthenticator" == $method) {

            $response = json_decode($TwoFAUtility->verifyGauthCode($this->postValue['Passcode'], $current_user));
            $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: PageFourValidate: totp method auth response");
            $response = array('status' => $response->status);
        } else {

            $custom_gateway_email = $TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
            $custom_gateway_sms = $TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
            $custom_gateway_whatsapp = $TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
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
                $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: Custom gateway");
                //custom gateway is enabled. validate otp for set customer
                $result = $TwoFAUtility->customgateway_validateOTP($this->postValue['Passcode']);
                $response = array('status' => $result);


            } else if ($method == 'OOW') {
                if ($method == 'OOW')
                    $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: miniOrange whatsapp gateway");
                else
                    $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: Custom gateway");
                //custom gateway is enabled. validate otp for set customer
                $result = $TwoFAUtility->customgateway_validateOTP($this->postValue['Passcode']);
                $response = array('status' => $result);
            } else {

                $customerUser = $TwoFAUtility->getCurrentUser();
                $response = $user->validate($current_user, $this->postValue['Passcode'], $method, $TwoFAUtility, NULL, true, $current_website);
                $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: PageFourValidate: method response");
                $response = json_decode($response);
                $response = array('status' => $response->status);
            }
        }

        //save data after succesful inline process.
        if ($response['status'] == 'SUCCESS') {
            $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: page four validate succesfull > saving data into db");

            $email = $TwoFAUtility->getSessionValue('mousername');
            $current_username = isset($email) ? $email : $current_username;

            // --------------------------fix-----------------------------------

            // $TwoFAUtility->getSessionValue(TwoFAConstants::CUSTOMER_INLINE);
            // todo => testing of phone,countrycode and secret use
            $email = $current_username;
            // for authenticator secret
            $secret = $TwoFAUtility->getSessionValue(TwoFAConstants::CUSTOMER_SECRET);
            if (!$secret) {
                $secret = $TwoFAUtility->generateRandomString();
            }

            $transactionID = $TwoFAUtility->getSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID);
            $transactionID = isset($transactionID) ? $transactionID : '1';

            $active_method_step = $TwoFAUtility->getSessionValue(TwoFAConstants::CUSTOMER_ACTIVE_METHOD);
            $active_method = isset($active_method_step) ? $active_method_step : $method;

            $config_method_step = $TwoFAUtility->getSessionValue(TwoFAConstants::CUSTOMER_CONFIG_METHOD);
            $config_method = isset($config_method_step) ? $config_method_step : $method;


            // updated 1.1.2.7
            $website_id = $this->storeManager->getStore()->getWebsiteId();

            $data = [
                [
                    'username' => $current_username,
                    'configured_methods' => $config_method,
                    'active_method' => $active_method,
                    'secret' => $secret,
                    'website_id' => $website_id
                ]
            ];


            $row = $TwoFAUtility->getCustomerMoTfaUserDetails('miniorange_tfa_users', $current_username);
            if ((is_array($row) && sizeof($row) > 0)) {
                $TwoFAUtility->updateColumnInTable('miniorange_tfa_users', 'configured_methods', $config_method, 'username', $current_username, $website_id);
                $TwoFAUtility->updateColumnInTable('miniorange_tfa_users', 'active_method', $active_method, 'username', $current_username, $website_id);
                $TwoFAUtility->updateColumnInTable('miniorange_tfa_users', 'secret', $secret, 'username', $current_username, $website_id);
            } else {
                //insert row for new customer
                $TwoFAUtility->insertRowInTable('miniorange_tfa_users', $data);
            }

            // remember my device settings
            $is_enabled_device_info = $TwoFAUtility->getStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE);

            if ($customer_device_enabled && $customer_device_enabled != 0) {

                $TwoFAUtility->log_debug("MiniOrangeInline.php :saving customer device ");
                $TwoFAUtility->check_and_save_device_data($is_enabled_device_info, $current_username, $website_id, $row);
            }

            //skip-twofa get nullified
            $TwoFAUtility->updateColumnInTable('miniorange_tfa_users', 'skip_twofa', NULL, 'username', $current_username, $website_id);
            $TwoFAUtility->updateColumnInTable('miniorange_tfa_users', 'skip_twofa_configured_date', NULL, 'username', $current_username, $website_id);


            if ($active_method == 'OOS' || $active_method == 'OOSE' || $active_method == 'OOW') {
                if ($phone != NULL) {
                    $TwoFAUtility->updateColumnInTable('miniorange_tfa_users', 'phone', $phone, 'username', $current_username, $website_id);
                    $TwoFAUtility->updateColumnInTable('miniorange_tfa_users', 'countrycode', $countrycode, 'username', $current_username, $website_id);
                }
            }
            if ($active_method == 'OOE' || $active_method == 'OOSE') {
                if ($email != NULL) {
                    $TwoFAUtility->updateColumnInTable('miniorange_tfa_users', 'email', $email, 'username', $current_username, $website_id);
                }
            }

            if ($transactionID != NULL) {
                $TwoFAUtility->updateColumnInTable('miniorange_tfa_users', 'transactionId', $transactionID, 'username', $current_username, $website_id);
            }
            $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: page four validate :clearing session value ");
            //create new customer if going through registration process
            $is_inside_registration = $TwoFAUtility->getSessionValue('mocreate_customer_register');
            if ($is_inside_registration) {
                $this->twofacustomerregistration->createNewCustomerAtRegistration();
                $TwoFAUtility->setSessionValue('mocreate_customer_register', NULL);
            }

            //remove data from session
            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_INLINE, NULL);
            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_SECRET, NULL);
            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID, NULL);
            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_USERNAME, NULL);
            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_ACTIVE_METHOD, NULL);
            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_CONFIG_METHOD, NULL);
            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER__PHONE, NULL);
            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_COUNTRY_CODE, NULL);
            $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER__EMAIL, NULL);

        }
        if ($response['status'] == 'FAILED') {
            $response = array('phone' => $phone, 'countrycode' => $countrycode);
        }

        return $response;
    }


    public function TFAValidate($TwoFAUtility, $current_username, $customer_device_enabled,$method = '')
    {

        //2nd time validation here
        $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: TFAValidate");
        $current_website = $this->storeManager->getStore()->getWebsiteId();

        $email = $TwoFAUtility->getSessionValue('mousername');
        $email = NULL;

        $current_username = isset($email) ? $email : $current_username;

        $row = $TwoFAUtility->getCustomerMoTfaUserDetails('miniorange_tfa_users', $current_username);

        if(isset($method) && $method != '') {
            $TwoFAUtility->log_debug("MiniOrangeInline.php : TFAValidate method passed from alternate 2fa page controller: " . $method);
        } else {
            if ((is_array($row) && sizeof($row) > 0) && isset($row[0]['active_method'])) {
                $method = $row[0]['active_method'];
                $TwoFAUtility->log_debug("MiniOrangeInline.php : TFAValidate checking user in miniorange_tfa_users method=>: " . ($method));
            } else {
                $TwoFAUtility->log_debug("MiniOrangeInline.php : TFAValidate no method found, setting default method to OOE");
                $method = 'OOE';
            }
        }

        $TwoFAUtility->log_debug("MiniOrangeInline.php : TFAValidate method: " . $method);

        if ("GoogleAuthenticator" == $method || "MicrosoftAuthenticator" == $method) {

            $response = json_decode($TwoFAUtility->verifyGauthCode($this->postValue['Passcode'], $current_username));
            $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: TFAValidate: google auth response");
            $response = array('status' => $response->status,
                'method' => $method);
        } else {

            $custom_gateway_email = $TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
            $custom_gateway_sms = $TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
            $custom_gateway_whatsapp = $TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);


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
                $TwoFAUtility->log_debug("MiniOrangeInline.php : TFAValidate: Custom gateway");

                $result = $TwoFAUtility->customgateway_validateOTP($this->postValue['Passcode']);
                $response = array('status' => $result);

            } else if (($method == 'OOW')) {
                if ("OOW" == $method)
                    $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: whatsapp miniOrange gateway ");
                else
                    $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: Custom gateway ");
                //custom gateway is enabled. validate otp for set customer
                $result = $TwoFAUtility->customgateway_validateOTP($this->postValue['Passcode']);
                $response = array('status' => $result);
            } else {
                $user = new miniOrangeUser();
                $response = $user->validate($current_username, $this->postValue['Passcode'], $method, $TwoFAUtility, NULL, true, $current_website);
                $response = json_decode($response);
                $response = array('status' => $response->status);
                $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: TFAValidate: Method response");
            }
        }


        if ($response['status'] == 'SUCCESS') {

            $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: TFAValidate: otp is valid");
            if ((is_array($row) && sizeof($row) <= 0)) {
                $TwoFAUtility->log_debug("MiniOrangeInline.php :customer not found in database for 2nd time otp validation {something is missing}, insertion new row");

                $email = $TwoFAUtility->getSessionValue('mousername');
                $current_username = isset($email) ? $email : $current_username;

                $active_method = $method;
                $config_method = $method;
                $temp_secret = $TwoFAUtility->generateRandomString();
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
                $TwoFAUtility->insertRowInTable('miniorange_tfa_users', $data);

                $transactionID = '1';
                $TwoFAUtility->updateColumnInTable('miniorange_tfa_users', 'transactionId', $transactionID, 'username', $current_username, $website_id);

                //remove data from session
                $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_SECRET, NULL);
                $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_USERNAME, NULL);
                $TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER__EMAIL, NULL);
                $TwoFAUtility->setSessionValue('last_otp_sent_time', NULL);


            }


            // remember my device settings
            $is_enabled_device_info = $TwoFAUtility->getStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE);
            if ($customer_device_enabled && $customer_device_enabled != 0) {
                $TwoFAUtility->log_debug("MiniOrangeInline.php :customer has enabled device information ");
                $TwoFAUtility->check_and_save_device_data($is_enabled_device_info, $current_username, $current_website, $row);
            }
        }
        else if ($response['status'] == 'FAILED') {
            $TwoFAUtility->log_debug("MiniOrangeInline.php : execute: TFAValidate: otp is invalid");
        }

        if(isset($method) && $method != '') {
            $response['method'] = $method;
        }

        return $response;

    }


}



