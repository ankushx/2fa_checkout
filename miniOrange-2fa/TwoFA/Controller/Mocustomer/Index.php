<?php


namespace MiniOrange\TwoFA\Controller\Mocustomer;


use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Session;
use Magento\Framework\App\RequestInterface;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\MiniOrangeInline;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use MiniOrange\TwoFA\Helper\TwoFAConstants;


class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $request;
    protected $resultFactory;
    protected $storeManager;
    protected $customEmail;
    protected $messageManager;
    protected $twofacustomerregistration;
    private $TwoFAUtility;
    private $miniOrangeInline;
    private $customerModel;
    private $customerSession;
    private $url;
    private $responseFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context              $context,
        \Magento\Framework\View\Result\PageFactory         $pageFactory,
        \Magento\Framework\Message\ManagerInterface        $messageManager,
        \Magento\Framework\App\ResponseFactory             $responseFactory,
        RequestInterface                                   $request,
        TwoFAUtility                                       $TwoFAUtility,
        MiniOrangeInline                                   $miniOrangeInline,
        CustomEmail                                        $customEmail,
        Customer                                           $customerModel,
        Session                                            $customerSession,
        \Magento\Framework\Controller\ResultFactory        $resultFactory,
        \Magento\Framework\UrlInterface                    $url,
        \Magento\Store\Model\StoreManagerInterface         $storeManager,
        \MiniOrange\TwoFA\Helper\TwoFACustomerRegistration $TwoFACustomerRegistration
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->messageManager = $messageManager;
        $this->responseFactory = $responseFactory;
        $this->request = $request;
        $this->customEmail = $customEmail;
        $this->TwoFAUtility = $TwoFAUtility;
        $this->customerModel = $customerModel;
        $this->miniOrangeInline = $miniOrangeInline;
        $this->customerSession = $customerSession;
        $this->resultFactory = $resultFactory;
        $this->url = $url;
        $this->storeManager = $storeManager;
        $this->twofacustomerregistration = $TwoFACustomerRegistration;
        parent::__construct($context);
    }

    public function execute()
    {

        // After redirection from LoginPost.php / CreatePost.php
        $this->TwoFAUtility->log_debug("In Mocustomer/Index: execute");
        $this->TwoFAUtility->log_debug("Current URL: mocustomer/index.php => params");
        $postValue = $this->request->getPostValue();
        $request = $this->request->getParams();

        $this->TwoFAUtility->log_debug("Step 1 in mocustomer");
        // Handle inline method selection
        if (isset($request['inline_one_method'])) {
            $postValue = $request;
        }

        $current_username = $this->TwoFAUtility->getSessionValue('mousername');
        if (!$current_username && isset($request['email'])) {
            $current_username = $request['email'];
        }

        // If no username found, return error and redirect
        if (!$current_username) {
            $this->messageManager->addErrorMessage(__('Something went wrong. Please try logging in again.'));
            $this->TwoFAUtility->log_debug("Email not found in session. Possible login session issue.");

            $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setPath('customer/account');
            $this->TwoFAUtility->log_debug("Redirecting to home page");
            return $resultRedirect;
        }

        // If Email method is selected, directly send OTP to customer (skip showing the dropdown)
        if (isset($postValue['mopostoption']) && $postValue['mopostoption'] == 'method' &&
            isset($postValue['miniorangetfa_method']) && $postValue['miniorangetfa_method'] == 'OOE') {

            $postValue['mopostoption'] = 'challenge';
            $this->TwoFAUtility->log_debug("Sending OTP directly to configured email for OOE method.");
            $postValue['redirect_to'] = $this->storeManager->getStore()->getBaseUrl() . 'motwofa/mocustomer/?mooption=invokeInline&step=OOEMethodValidation&savestep=OOE';

            $this->miniOrangeInline->thirdStepSubmit($this->TwoFAUtility, $current_username);
            $this->TwoFAUtility->log_debug("Response received from thirdStepSubmit function.");
        }


        // Handling skip KBA option
        if (isset($postValue['skip_kba_config'])) {
            return $this->handleSkipKBA($current_username);
        } elseif (isset($postValue['kba_method_set'])) {
            return $this->handleKBASet($postValue, $current_username);
        }

        // If two-factor authentication is skipped by customer
        if (isset($postValue['skiptwofa'])) {
            $is_inside_registration = $this->TwoFAUtility->getSessionValue('mocreate_customer_register');
            if ($is_inside_registration) {
                $this->twofacustomerregistration->createNewCustomerAtRegistration();
                $this->TwoFAUtility->setSessionValue('mocreate_customer_register', NULL);
            }
            $current_website_id = $this->storeManager->getStore()->getWebsiteId();
            return $this->TwoFAUtility->getSkipTwoFa($current_website_id);
        }

        // Handle mooption parameter for inline method selection
        if (isset($request['mooption']) && $request['mooption'] === 'invokeInline') {
            $step = $request['step'] ?? '';
            
            if ($step === 'ChooseMFAMethod') {
                // Get available methods for the current user
                $current_website_id = $this->TwoFAUtility->getWebsiteOrStoreBasedOnTrialStatus();
                $customer = $this->getCustomerFromAttributes($current_username);
                
                if ($customer) {
                    $customerData = $customer->getData();
                    $groupId = $customerData['group_id'] ?? null;
                    
                    if ($groupId) {
                        $groupRepository = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Customer\Api\GroupRepositoryInterface');
                        $customerGroup = $groupRepository->getById($groupId);
                        $customer_role_name = $customerGroup->getCode();
                        
                        $twofaMethods = $this->TwoFAUtility->getCustomer2FAMethodsFromRules($customer_role_name, $current_website_id);
                        
                        if ($twofaMethods['count'] > 0) {
                            // Decode the methods and store the array in session for the template to use
                            $decodedMethods = json_decode($twofaMethods['methods'], true);
                            
                            $this->TwoFAUtility->setSessionValue('available_2fa_methods', $decodedMethods);
                            $this->TwoFAUtility->setSessionValue('current_username', $current_username);
                            
                            // Render the method selection page
                            return $this->_pageFactory->create();
                        }
                    }
                }
            }
        }

        $redirect_url = '';
        // Further handling based on post option
        $this->TwoFAUtility->log_debug("Step 2 in mocustomer");

        if (isset($postValue['mopostoption'])) {
            $this->TwoFAUtility->log_debug("MoCustomer : postvalue - " . $postValue['mopostoption']);


            if ($postValue['mopostoption'] === 'uservalotp') {
                return $this->validateReturningUserOtp($postValue, $current_username);
            } elseif ($postValue['mopostoption'] === 'method') {
                return $this->handleInlineRegistration($current_username, $postValue);
            } elseif ($postValue['mopostoption'] === 'challenge') {
                return $this->sendOtpForChallengeStep($postValue, $current_username);
            } elseif ($postValue['mopostoption'] === 'movalotp') {
                $method = $postValue['savestep'] ?? '';
                // pass the `phone` and `countrycode` in the parameters
                $phone = '';
                $countrycode = '';

                if (isset($postValue['savestep']) && ($postValue['savestep'] == 'OOS' || $postValue['savestep'] == 'OOSE')) {
                    // Check the method and set phone and country code accordingly
                    $phone = isset($postValue['phone']) ? $postValue['phone'] : '';
                    $countrycode = isset($postValue['countrycode']) ? $postValue['countrycode'] : '';

                }
                return $this->validateOtpForFirstTimeUser($postValue, $current_username, $method, $phone, $countrycode);
            }

            $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);

            $redirect->setUrl($redirect_url);
            return $redirect;
        } else {
            return $this->_pageFactory->create();
        }

        // Default redirection if no other condition matches
        return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)
            ->setPath('customer/account');

    }

    /**
     * Handle the action to skip KBA setup.
     *
     * @param string $current_username The username or email of the current user.
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function handleSkipKBA($current_username)
    {
        $user = $this->getCustomerFromAttributes($current_username);
        if ($user) {
            $this->customerSession->setCustomerAsLoggedIn($user);
        } else {
            $this->messageManager->addErrorMessage(__('Something went wrong. Please try logging in again.'));
            $this->TwoFAUtility->log_debug("Email not found in session. Possible login session issue for KBA skip.");
            return $this->redirectToPath('customer/account');
        }
        return $this->redirectToPath('customer/account');
    }

    /**
     * Retrieve customer by email address
     *
     * @param string $user_email The email address of the customer.
     * @return \Magento\Customer\Model\Customer|bool Returns the customer object if found, otherwise false.
     */
    public function getCustomerFromAttributes($user_email)
    {
        $this->customerModel->setWebsiteId($this->storeManager->getStore()->getWebsiteId());
        $customer = $this->customerModel->loadByEmail($user_email);
        return !is_null($customer->getId()) ? $customer : false;
    }

    /**
     * Redirect to specified path
     */
    public function redirectToPath($path)
    {
        return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->setPath($path);
    }

    /**
     * Handle setting KBA questions and answers.
     *
     * @param array $postValue The form data containing KBA questions and answers.
     * @param string $current_username The username or email of the current user.
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function handleKBASet($postValue, $current_username)
    {
        $kbaData = [
            '1' => ["question" => $postValue['q1'], "answer" => $postValue['answer1']],
            '2' => ["question" => $postValue['q2'], "answer" => $postValue['answer2']],
            '3' => ["question" => $postValue['q3'], "answer" => $postValue['answer3']]
        ];

        $finalData = json_encode($kbaData);
        $current_website_id = $this->TwoFAUtility->getWebsiteOrStoreBasedOnTrialStatus();
        $this->TwoFAUtility->updateColumnInTable('miniorange_tfa_users', 'kba_method', $finalData, 'username', $current_username, $current_website_id);

        $user = $this->getCustomerFromAttributes($current_username);
        if ($user) {
            $this->customerSession->setCustomerAsLoggedIn($user);
        } else {
            $this->messageManager->addErrorMessage(__('Something went wrong. Please try logging in again.'));
            return $this->redirectToPath('customer/account');
        }
        return $this->redirectToPath('customer/account');
    }

    /**
     * Validate OTP for CASE 'uservalotp'
     *
     * Functionality:
     * - This function verifies the OTP for users who have already set up two-factor authentication (present in the `miniorange_tfa_users` table).
     * - It logs the user into their account if the OTP validation is successful or handles the failure otherwise.
     *
     * Usage:
     * - Upon receiving the OTP from the returning user, this function is called to authenticate the user based on the provided credentials.
     *
     * Returns:
     * - On success (`$response['status'] = 'SUCCESS'`):
     *   - Calls `redirectToCustomerAccount` to log the user in and redirects to the account page.
     * - On failure (`$response['status'] = 'FAILED'`):
     *   - Calls `handleOtpFailure` to process the failure and redirects back to the account page.
     *
     * @param string $postValue The OTP submitted by the user.
     * @param string $current_username The username of the current user.
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function validateReturningUserOtp($postValue, $current_username)
    {
        $this->TwoFAUtility->log_debug("Validating 2FA for already configured customer.");
        $response = $this->validateOtpForReturningUser($postValue, $current_username);

        if ($response && $response['status'] == 'SUCCESS') {
            return $this->redirectToCustomerAccount($current_username);
        }

        // failed otp
        $redirect_url = $this->url->getUrl('motwofa/mocustomer') . "?mooption=invokeTFA&error=error";

        if($response && isset($response['method'])) {
            $method = $response['method'];
            $this->TwoFAUtility->log_debug("Method found in response: " . $method);
            $redirect_url = $this->url->getUrl('motwofa/mocustomer') . "?mooption=invokeTFA&error=error&active_method=" . $method;
        }

        // Add the method to the URL for ALL methods
        if (isset($response['method']) && ($response['method'] == 'GoogleAuthenticator' || $response['method'] == 'MicrosoftAuthenticator')) {
            // Correctly add the method to the URL
            $redirect_url = $this->url->getUrl('motwofa/mocustomer') . "?mooption=invokeTFA&active_method=" . $response['method'] . "&error=error";
        }
        if (isset($response['active_method'])) {
            $redirect_url .= "&active_method=" . urlencode($response['active_method']);
        }


        return $this->handleOtpFailure($response, $redirect_url);
    }

    /**
     * Perform OTP validation for CASE 'uservalotp'
     *
     * Returns:
     * - The result of the OTP validation (`SUCCESS` or `FAILED`), managed by the `TFAValidate` method of the `miniOrangeInline` helper.
     *
     * @param array $postValue Array containing the OTP and additional parameters such as "Remember Device".
     * @param string $current_username The username of the current user.
     * @return array Validation response from `TFAValidate`, with status 'SUCCESS' or 'FAILED'.
     */
    public function validateOtpForReturningUser($postValue, $current_username)
    {
        $this->TwoFAUtility->log_debug("Initiating OTP validation for returning user.");

        // Check if "Remember Device" is enabled
        $rememberDevice = isset($postValue['rememberDevice']) && $postValue['rememberDevice'] == '1' ? 1 : 0;
        return $this->miniOrangeInline->TFAValidate($this->TwoFAUtility, $current_username, $rememberDevice);
    }

    /**
     * Redirect to customer account page after successful OTP validation.
     *
     * @param string $username The username or email of the customer.
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function redirectToCustomerAccount($username)
    {
        $user = $this->getCustomerFromAttributes($username);
        if ($user) {
            // Only set customer as logged in if not already logged in
            if (!$this->customerSession->isLoggedIn()) {
                $this->customerSession->setCustomerAsLoggedIn($user);
                $this->TwoFAUtility->log_debug("Redirecting to customer account after successful login.");
            } else {
                $this->TwoFAUtility->log_debug("Customer already logged in, skipping setCustomerAsLoggedIn.");
            }
        }

        $referrer_url = $this->TwoFAUtility->getSessionValue('referrer_url');
        $base_url = $this->TwoFAUtility->getBaseUrl();
        $base_url = rtrim($base_url, '/');  // Remove trailing slash
        $path= '/';
        
        // If there's a valid referrer URL in the session and it starts with the base URL
        if ($referrer_url && strpos($referrer_url, $base_url) == 0) {
            // Proceed with the referrer URL
            $path = $referrer_url;

            // set the cokkie 
            $this->TwoFAUtility->setSessionValue('2fa_verified', 1);

            // Clear the session value for referrer URL
            $this->TwoFAUtility->log_debug("path is =>" ,$referrer_url);
            $this->TwoFAUtility->setSessionValue('referrer_url', null);
        } 

        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($path);
        return $resultRedirect;
    }

    /**
     * Handle OTP failure scenarios
     */
    public function handleOtpFailure($response, $defaultPath)
    {

        if ($response && in_array($response['status'], ['FAILED_ATTEMPTS', 'FAILED_OTP_EXPIRED'])) {
            $this->TwoFAUtility->log_debug("OTP failure detected with status: " . $response['status']);
            $message = $response['status'] == 'FAILED_ATTEMPTS' ? "Maximum OTP attempts reached. Please login again." : "OTP expired. Please login again.";
            $this->messageManager->addErrorMessage(__($message));
            $this->TwoFAUtility->setSessionValue('failed_otp_attempts', NULL);
            $this->TwoFAUtility->setSessionValue('otp_expiry_time', NULL);
            $defaultPath = 'customer/account';

        }

        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($defaultPath);
        return $resultRedirect;
    }

    /**
     * Handle method selection for inline registration - CASE 'method'
     *
     * Functionality:
     * - Calls `thirdStepSubmit` first to set session values and get the redirect URL based on the selected method.
     * - if For methods OOSE,OOS (email+SMS, SMS) it further call `sendOtpForInlineRegistration` function.
     *
     * @param string $current_username The username of the current user.
     * @param array $postValue Contains the selected method and other form data.
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function handleInlineRegistration($current_username, $postValue)
    {
        $this->TwoFAUtility->log_debug("MoCustomer : Customer Inline registration ");

        $redirect_url = $this->miniOrangeInline->thirdStepSubmit($this->TwoFAUtility, $current_username);
        $redirect_url = $redirect_url . "&savestep=" . $postValue['miniorangetfa_method'];

        if ($postValue['miniorangetfa_method'] == 'OOS' || $postValue['miniorangetfa_method'] == 'OOSE' || $postValue['miniorangetfa_method'] == 'OOW') {
            return $this->sendOtpForInlineRegistration($current_username, $postValue['miniorangetfa_method'], $redirect_url);
        }

        $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);

        $redirect->setUrl($redirect_url);
        return $redirect;
    }

    /**
     * Send OTP for Inline Registration - CASE 'method'
     *
     * Functionality:
     * - For methods OOSE and OOS, if the user's shipping address has both country code and phone, send OTP directly using `pageFourChallenge`.
     * - If OTP sending is successful, redirect to OTP validation page.
     * - If OTP sending fails, redirect back to the account page with an error message.
     *
     * @param string $username The username of the current user.
     * @param string $method The selected 2FA method (e.g., OOSE or OOS).
     * @param string $redirect_url The URL to redirect the user upon OTP send success or failure.
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function sendOtpForInlineRegistration($username, $method, $redirect_url)
    {
        $this->TwoFAUtility->log_debug("MoCustomer : Customer Inline registration : current_username", $username);

        // updated changes
        $this->TwoFAUtility->log_debug("MoCustomer : Customer Inline registration : phone and country code not found ");
        $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($redirect_url);
        return $redirect;
        

    }

    /**
     * get countrycode by country id
     * @param mixed $code
     * @return bool|int|string
     */
    public function getPhoneID_from_ContryCode($code)
    {
        $countrycode = array(
            'AD' => '376',
            'AE' => '971',
            'AF' => '93',
            'AG' => '1268',
            'AI' => '1264',
            'AL' => '355',
            'AM' => '374',
            'AN' => '599',
            'AO' => '244',
            'AQ' => '672',
            'AR' => '54',
            'AS' => '1684',
            'AT' => '43',
            'AU' => '61',
            'AW' => '297',
            'AZ' => '994',
            'BA' => '387',
            'BB' => '1246',
            'BD' => '880',
            'BE' => '32',
            'BF' => '226',
            'BG' => '359',
            'BH' => '973',
            'BI' => '257',
            'BJ' => '229',
            'BL' => '590',
            'BM' => '1441',
            'BN' => '673',
            'BO' => '591',
            'BR' => '55',
            'BS' => '1242',
            'BT' => '975',
            'BW' => '267',
            'BY' => '375',
            'BZ' => '501',
            'CA' => '1',
            'CC' => '61',
            'CD' => '243',
            'CF' => '236',
            'CG' => '242',
            'CH' => '41',
            'CI' => '225',
            'CK' => '682',
            'CL' => '56',
            'CM' => '237',
            'CN' => '86',
            'CO' => '57',
            'CR' => '506',
            'CU' => '53',
            'CV' => '238',
            'CX' => '61',
            'CY' => '357',
            'CZ' => '420',
            'DE' => '49',
            'DJ' => '253',
            'DK' => '45',
            'DM' => '1767',
            'DO' => '1809',
            'DZ' => '213',
            'EC' => '593',
            'EE' => '372',
            'EG' => '20',
            'ER' => '291',
            'ES' => '34',
            'ET' => '251',
            'FI' => '358',
            'FJ' => '679',
            'FK' => '500',
            'FM' => '691',
            'FO' => '298',
            'FR' => '33',
            'GA' => '241',
            'GB' => '44',
            'GD' => '1473',
            'GE' => '995',
            'GH' => '233',
            'GI' => '350',
            'GL' => '299',
            'GM' => '220',
            'GN' => '224',
            'GQ' => '240',
            'GR' => '30',
            'GT' => '502',
            'GU' => '1671',
            'GW' => '245',
            'GY' => '592',
            'HK' => '852',
            'HN' => '504',
            'HR' => '385',
            'HT' => '509',
            'HU' => '36',
            'ID' => '62',
            'IE' => '353',
            'IL' => '972',
            'IM' => '44',
            'IN' => '91',
            'IQ' => '964',
            'IR' => '98',
            'IS' => '354',
            'IT' => '39',
            'JM' => '1876',
            'JO' => '962',
            'JP' => '81',
            'KE' => '254',
            'KG' => '996',
            'KH' => '855',
            'KI' => '686',
            'KM' => '269',
            'KN' => '1869',
            'KP' => '850',
            'KR' => '82',
            'KW' => '965',
            'KY' => '1345',
            'KZ' => '7',
            'LA' => '856',
            'LB' => '961',
            'LC' => '1758',
            'LI' => '423',
            'LK' => '94',
            'LR' => '231',
            'LS' => '266',
            'LT' => '370',
            'LU' => '352',
            'LV' => '371',
            'LY' => '218',
            'MA' => '212',
            'MC' => '377',
            'MD' => '373',
            'ME' => '382',
            'MF' => '1599',
            'MG' => '261',
            'MH' => '692',
            'MK' => '389',
            'ML' => '223',
            'MM' => '95',
            'MN' => '976',
            'MO' => '853',
            'MP' => '1670',
            'MR' => '222',
            'MS' => '1664',
            'MT' => '356',
            'MU' => '230',
            'MV' => '960',
            'MW' => '265',
            'MX' => '52',
            'MY' => '60',
            'MZ' => '258',
            'NA' => '264',
            'NC' => '687',
            'NE' => '227',
            'NG' => '234',
            'NI' => '505',
            'NL' => '31',
            'NO' => '47',
            'NP' => '977',
            'NR' => '674',
            'NU' => '683',
            'NZ' => '64',
            'OM' => '968',
            'PA' => '507',
            'PE' => '51',
            'PF' => '689',
            'PG' => '675',
            'PH' => '63',
            'PK' => '92',
            'PL' => '48',
            'PM' => '508',
            'PN' => '870',
            'PR' => '1',
            'PT' => '351',
            'PW' => '680',
            'PY' => '595',
            'QA' => '974',
            'RO' => '40',
            'RS' => '381',
            'RU' => '7',
            'RW' => '250',
            'SA' => '966',
            'SB' => '677',
            'SC' => '248',
            'SD' => '249',
            'SE' => '46',
            'SG' => '65',
            'SH' => '290',
            'SI' => '386',
            'SK' => '421',
            'SL' => '232',
            'SM' => '378',
            'SN' => '221',
            'SO' => '252',
            'SR' => '597',
            'ST' => '239',
            'SV' => '503',
            'SY' => '963',
            'SZ' => '268',
            'TC' => '1649',
            'TD' => '235',
            'TG' => '228',
            'TH' => '66',
            'TJ' => '992',
            'TK' => '690',
            'TL' => '670',
            'TM' => '993',
            'TN' => '216',
            'TO' => '676',
            'TR' => '90',
            'TT' => '1868',
            'TV' => '688',
            'TW' => '886',
            'TZ' => '255',
            'UA' => '380',
            'UG' => '256',
            'US' => '1',
            'UY' => '598',
            'UZ' => '998',
            'VA' => '39',
            'VC' => '1784',
            'VE' => '58',
            'VG' => '1284',
            'VI' => '1340',
            'VN' => '84',
            'VU' => '678',
            'WF' => '681',
            'WS' => '685',
            'XK' => '381',
            'YE' => '967',
            'YT' => '262',
            'ZA' => '27',
            'ZM' => '260',
            'ZW' => '263'
        );
        $flipped_conutryCode = array_flip($countrycode);
        $key = array_search($code, $flipped_conutryCode);
        return $key;
    }

    /**
     * Process OTP response and redirect - CASE 'method' and 'challenge'
     *
     * Functionality:
     * - Handles the OTP response status and redirects the user accordingly.
     * - If OTP send fails, redirects to the account page with an error message.
     * - If successful, redirects to the provided URL with additional parameters.
     *
     * @param array $response The OTP response array with status and message.
     * @param string $redirect_url The base URL for redirection after OTP processing.
     * @param string $phone The user's phone number.
     * @param string $countrycode The user's country code.
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function processOtpResponse($response, $redirect_url, $phone, $countrycode)
    {
        try{
            $status = is_array($response) && $response['status'] ? $response['status'] : 'FAILED';
            
            $message = is_array($response) && $response['message'] ? $response['message'] : "Quelque chose s'est mal passé. Veuillez réessayer de vous connecter.";
            
            // Translate the message from English to French
            $translatedMessage = $this->TwoFAUtility->translateOtpMessage($message);
            $message = $translatedMessage;
        
        }catch(\Exception $e)
        {
            $status = 'FAILED';
        }

        if ($status == 'FAILED') {
            $this->messageManager->addErrorMessage(__($message));
            $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setPath('customer/account');
            return $resultRedirect;
        }

        $this->TwoFAUtility->log_debug("OTP sent successfully for inline registration.");
        $this->TwoFAUtility->log_debug("redirect url. 1 => " . $redirect_url);
        $redirect_url = $redirect_url . "&message=" . $message . "&showdiv=showdiv";

        // Append countrycode and phone if both are not empty
        if ($phone && $countrycode && $countrycode != '' && $phone != '') {
            $redirect_url .= "&countrycode=" . urlencode($countrycode) . "&phone=" . urlencode($phone);
        }

        $this->TwoFAUtility->log_debug("redirect url. 2 => " . $redirect_url);

        $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);

        $redirect->setUrl($redirect_url);
        return $redirect;
    }

    /**
     * Send OTP for challenge step
     * case 'challenge':
     */
    public function sendOtpForChallengeStep($postValue, $current_username)
    {
        $method = '';

        // Check if redirect_to is set and not empty before parsing
        if (isset($postValue['redirect_to']) && ($queryString = parse_url($postValue['redirect_to'], PHP_URL_QUERY)) && $queryString !== '') {
            parse_str($queryString, $queryParams);
            $method = $queryParams['savestep'] ?? '';
        }

        $phone = '';
        $countrycode = '';
        // Check the method and set phone and country code accordingly
        if ($method == 'OOS' || $method == 'OOSE' || $method == 'OOW') {  // Adjusted condition to match 'OOS'
            $phone = isset($postValue['phone']) ? $postValue['phone'] : '';
            $countrycode = isset($postValue['countrycode']) ? $postValue['countrycode'] : '';

            $isBlockSpamPhoneNumberEnabled = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::CUSTOMER_ENABLE_BLOCK_SPAM_PHONE_NUMBER);
            if ($isBlockSpamPhoneNumberEnabled) {
                // check if the phone and countrycode is present in the blacklisted numbers
                $blacklisted = $this->TwoFAUtility->checkBlacklistedPhone($phone, $countrycode);

                if ($blacklisted) {
                    $message = "The phone number you have entered has been flagged and is currently blacklisted. Please use a different number to proceed.";
                    $message = $this->TwoFAUtility->translateOtpMessage($message);
                    $this->messageManager->addErrorMessage(__($message));
                    return $this->redirectToPath('customer/account');
                }
            }

            $this->TwoFAUtility->log_debug("MoCustomer : sendOtpForChallengeStep : phone and country code found ");
            if($phone && $countrycode)
            {
                $this->TwoFAUtility->log_debug("MoCustomer : sendOtpForChallengeStep : phone => " . $phone);
                $this->TwoFAUtility->log_debug("MoCustomer : sendOtpForChallengeStep : countrycode => " . $countrycode);
            }else{
                $this->TwoFAUtility->log_debug("MoCustomer : sendOtpForChallengeStep : phone or countrycode is not set");
            }

        }

        $send_otp_response = $this->miniOrangeInline->pageFourChallenge($this->TwoFAUtility, $current_username, $method, $phone, $countrycode);
        return $this->processOtpResponse($send_otp_response, $postValue['redirect_to'], $phone, $countrycode);
    }

    /**
     * Validate OTP for first-time users
     * case 'movalotp':
     */
    public function validateOtpForFirstTimeUser($postValue, $current_username, $method, $phone, $countrycode)
    {
        $this->TwoFAUtility->log_debug("Initiating OTP validation for first-time user with method: " . $method);

        // Check if "Remember Device" is enabled
        $rememberDevice = isset($postValue['rememberDevice']) && $postValue['rememberDevice'] == '1' ? 1 : 0;

        // $method=='OOS' || 'OOSE'; then send phone number as parameter as well in pagefourvaldiate.
        // todo
        // Validate OTP using the specified method and remember device option
        $response = $this->miniOrangeInline->pageFourValidate($this->TwoFAUtility, $current_username, $method, $rememberDevice, $phone, $countrycode);

        // If validation is successful
        if (isset($response['status']) && $response['status'] == 'SUCCESS') {
            $this->TwoFAUtility->log_debug("OTP validation successful for first-time user.");

            // Check if KBA is enabled
            $current_website_id = $this->storeManager->getStore()->getWebsiteId();
            $isset_kba = $this->TwoFAUtility->getStoreConfig('kba_method' . $current_website_id);
            $questionSet1 = $this->TwoFAUtility->getStoreConfig('question_set_string1' . $current_website_id);
            $questionSet2 = $this->TwoFAUtility->getStoreConfig('question_set_string2' . $current_website_id);

            // Redirect to KBA validation if enabled
            if ($isset_kba && $questionSet1 != NULL && $questionSet2 != NULL) {
                $redirect_url = $this->url->getUrl('motwofa/mocustomer') . "?mooption=invokeInline&step=KBA_Question";
                return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)
                    ->setUrl($redirect_url);
            } else {
                // Log in the user if no KBA is required
                $user = $this->getCustomerFromAttributes($current_username);
                if ($user) {
                    $this->customerSession->setCustomerAsLoggedIn($user);
                    $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
                    
                    $referrer_url = $this->TwoFAUtility->getSessionValue('referrer_url');
                    $base_url = $this->TwoFAUtility->getBaseUrl();
                    $base_url = rtrim($base_url, '/');  // Remove trailing slash
                    $path= '/';
                    
                    // If there's a valid referrer URL in the session and it starts with the base URL
                    if ($referrer_url && strpos($referrer_url, $base_url) == 0) {
                        // Proceed with the referrer URL
                        $path = $referrer_url;
                        $this->TwoFAUtility->setSessionValue('2fa_verified', 1);
                        // Clear the session value for referrer URL
                        $this->TwoFAUtility->log_debug("path is =>" ,$referrer_url);
                    } 

                    $resultRedirect->setPath($path);

                    return $resultRedirect;
                } else {
                    $this->messageManager->addErrorMessage(__('Something went wrong. Please try logging in again.'));
                    $this->TwoFAUtility->log_debug("Email not found in session. Possible login session issue in OTP validation.");
                    return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)
                        ->setPath('customer/account');
                }
            }
        } else {
            // Handle failed OTP validation
            $this->TwoFAUtility->log_debug("OTP validation failed for first-time user.");

            if (isset($response['status']) && ($response['status'] == 'FAILED_ATTEMPTS' || $response['status'] == 'FAILED_OTP_EXPIRED')) {
                if ($response['status'] == 'FAILED_ATTEMPTS') {
                    $this->TwoFAUtility->log_debug("Max failed OTP attempts reached.");
                    $this->messageManager->addErrorMessage(__("You have reached the maximum number of 10 OTP attempts. Please login again."));
                }

                if ($response['status'] == 'FAILED_OTP_EXPIRED') {
                    $this->TwoFAUtility->log_debug("OTP has expired.");
                    $this->messageManager->addErrorMessage(__("Your OTP has expired. Please login again."));
                }

                // Reset session values related to failed attempts and OTP expiry
                $this->TwoFAUtility->setSessionValue('failed_otp_attempts', NULL);
                $this->TwoFAUtility->setSessionValue('otp_expiry_time', NULL);

                // Redirect to customer account
                $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setPath('customer/account');
                return $resultRedirect;
            }

            // Determine redirection URL based on the saved step for specific errors
            if (!isset($postValue['savestep'])) {
                $redirect_url = $this->url->getCurrentUrl() . "?mooption=invokeTFA&error=error";
            } else {
                switch ($postValue['savestep']) {
                    case 'OOS':
                        $redirect_url = $this->url->getCurrentUrl() . "/?mooption=invokeInline&step=OOSMethodValidation&error=error&showdiv=showdiv";

                        // added phone,countrycode in params
                        $phone = isset($response['phone']) ? $response['phone'] : '';
                        $countrycode = isset($response['countrycode']) ? $response['countrycode'] : '';
                        if (!empty($phone) && !empty($countrycode)) {
                            $redirect_url .= "&countrycode=" . urlencode($countrycode) . "&phone=" . urlencode($phone);
                        }
                        break;
                    case 'OOW':
                        $redirect_url = $this->url->getCurrentUrl() . "/?mooption=invokeInline&step=OOWMethodValidation&error=error&showdiv=showdiv";
                        break;
                    case 'OOE':
                        $redirect_url = $this->url->getCurrentUrl() . "/?mooption=invokeInline&step=OOEMethodValidation&error=error";
                        break;
                    case 'OOSE':
                        $redirect_url = $this->url->getCurrentUrl() . "/?mooption=invokeInline&step=OOSEMethodValidation&error=error&showdiv=showdiv&useremail=" . $current_username;

                        // added phone,countrycode in params
                        $phone = isset($response['phone']) ? $response['phone'] : '';
                        $countrycode = isset($response['countrycode']) ? $response['countrycode'] : '';
                        if (!empty($phone) && !empty($countrycode)) {
                            $redirect_url .= "&countrycode=" . urlencode($countrycode) . "&phone=" . urlencode($phone);
                        }
                        break;
                    case 'GoogleAuthenticator':
                        $redirect_url = $this->url->getCurrentUrl() . "/?mooption=invokeInline&step=GAMethodValidation&addPasscode=true&error=error";
                        break;
                    case 'Authenticator':
                        $redirect_url = $this->url->getCurrentUrl() . "/?mooption=invokeInline&step=AMethodValidation&addPasscode=true&error=error";
                        break;
                    case 'MicrosoftAuthenticator':
                        $redirect_url = $this->url->getCurrentUrl() . "/?mooption=invokeInline&step=MicrosoftAuthenticator&addPasscode=true&error=error";
                        break;
                    default:
                        $redirect_url = $this->url->getCurrentUrl() . "?mooption=invokeTFA&error=error";
                        break;
                }
            }


            return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)
                ->setUrl($redirect_url);
        }
    }

    /**
     * Redirect to final destination
     */
    public function finalRedirect($url)
    {
        $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($url);
        return $redirect;

    }
}
