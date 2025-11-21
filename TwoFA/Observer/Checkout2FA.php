<?php
namespace MiniOrange\TwoFA\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Customer\Model\Session;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\CustomSMS;
use MiniOrange\TwoFA\Helper\MiniOrangeUser;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use Magento\Checkout\Model\Session as CheckoutSession;

class Checkout2FA implements ObserverInterface
{
    /**
     * @var TwoFAUtility
     */
    protected $TwoFAUtility;
    protected $storeManager;
    protected $customerSession;
    protected $customSMS;
    protected $customEmail;
    protected $redirect;
    protected $resultFactory;
    protected $messageManager;
    protected $cookieManager;
    protected $cookieMetadataFactory;

    protected $checkoutSession;

    public function __construct(
        TwoFAUtility $TwoFAUtility,
        StoreManagerInterface $storeManager,
        Session $customerSession,
        CustomEmail $customEmail,
        CustomSMS $customSMS,
        RedirectInterface $redirect,
        ResultFactory $resultFactory,
        ManagerInterface $messageManager,
        CookieManagerInterface $cookieManager,
        CookieMetadataFactory $cookieMetadataFactory,
        CheckoutSession $checkoutSession
    ) {
        $this->TwoFAUtility = $TwoFAUtility;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
        $this->customEmail = $customEmail;
        $this->customSMS = $customSMS;
        $this->redirect = $redirect;
        $this->resultFactory = $resultFactory;
        $this->messageManager = $messageManager;
        $this->cookieManager = $cookieManager;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $controller = $observer->getControllerAction();
        
        // set the cookie to null
        $twofa_verified = $this->TwoFAUtility->getSessionValue('2fa_verified');
        
        if ($twofa_verified) {
            $this->TwoFAUtility->setSessionValue('2fa_verified', null);
            return;
        }

        // Get quote from checkout session
        $quote = $this->checkoutSession->getQuote();
                
        $subtotal = (float)$quote->getSubtotal();
        $minimumCartAmount = (float)$this->TwoFAUtility->getStoreConfig(TwoFAConstants::CUSTOMER_MINIMUM_CART_AMOUNT);
        $enableCartAmount = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::CUSTOMER_ENABLE_CART_AMOUNT);
        
        if ($enableCartAmount) {

            if ($subtotal < $minimumCartAmount) {
                $this->TwoFAUtility->log_debug("Checkout2FA: Cart amount below minimum threshold, skipping 2FA");
                return;
            }
        }

        // Function:Call the remember device check
        $row = $this->TwoFAUtility->getCustomerMoTfaUserDetails('miniorange_tfa_users', $this->customerSession->getCustomer()->getEmail());
        
        $current_website_id = $this->TwoFAUtility->getWebsiteOrStoreBasedOnTrialStatus();
        if ($this->handleRememberDeviceCheck($this->customerSession->getCustomer()->getEmail(), $current_website_id, $row)) {
            $this->TwoFAUtility->log_debug('Checkout2FA.php -> default checkout flow in remember my device');
            return;
        }

        $this->TwoFAUtility->log_debug("--------------------------------------------------Execute Checkout2FA:------------------------------------------------");
        
        $current_website_id = $this->TwoFAUtility->getWebsiteOrStoreBasedOnTrialStatus();
        $customer_role_name = $this->TwoFAUtility->getGroupNameById($this->customerSession->getCustomer()->getGroupId());
        $this->TwoFAUtility->log_debug("Checkout2FA.php : execute: getGroupNameById customer_role_name", $customer_role_name);

        $customer_rules = $this->TwoFAUtility->getGlobalConfig(TwoFAConstants::CURRENT_CUSTOMER_RULE);
        $this->TwoFAUtility->log_debug("Checkout2FA.php : execute: getGlobalConfig customer_rules", $customer_rules);
        
        $twofaMethods = $this->TwoFAUtility->getCustomer2FAMethodsFromRules($customer_role_name, $current_website_id);
        $active_method = $twofaMethods['methods'];
        $active_method_status = ($twofaMethods['count'] > 0);

        // Check if there are any applicable rules
        $invokeInline = false;
        if ($customer_rules) {
            $rules = json_decode($customer_rules, true);
            if (is_array($rules)) {
                // First, try to find website-specific rules (highest priority)
                $websiteSpecificRule = null;
                $globalRule = null;
                
                foreach ($rules as $rule) {
                    if (isset($rule['site']) && isset($rule['group'])) {
                        // Check if rule applies to current website and customer group
                        $siteMatches = ($rule['site'] === 'All Sites' || $rule['site'] === $this->TwoFAUtility->getWebsiteNameById($current_website_id));
                        $groupMatches = ($rule['group'] === 'All Groups' || $rule['group'] === $customer_role_name);
                        
                        if ($siteMatches && $groupMatches) {
                            // Check if this is a website-specific rule
                            if ($rule['site'] === $this->TwoFAUtility->getWebsiteNameById($current_website_id)) {
                                $websiteSpecificRule = $rule;
                            } elseif ($rule['site'] === 'All Sites') {
                                $globalRule = $rule;
                            }
                        }
                    }
                }
                
                $selectedRule = $websiteSpecificRule ?: $globalRule;
                
                if ($selectedRule) {
                    $invokeInline = true;
                    $ruleType = $websiteSpecificRule ? 'website-specific' : 'global';
                }
            }
        }

        // If no rule found but active methods exist, still invoke inline
        if (!$invokeInline && $active_method_status) {
            $invokeInline = true;
        }

        $twofa_backend_plan = $this->TwoFAUtility->check2fa_backend_plan();
        $this->TwoFAUtility->log_debug("Checkout2FA.php : execute: check2fa_backend_plan", $twofa_backend_plan);

        if ($this->TwoFAUtility->isTrialExpired()) {
            $this->TwoFAUtility->log_debug("Checkout2FA: Trial expired, allowing checkout access");
            return;
        }

        if ($invokeInline && $active_method_status && $twofa_backend_plan && !$this->TwoFAUtility->checkIPs('customer')) {

            $this->TwoFAUtility->log_debug("Checkout2FA: Inline Invoked and found active method");
            // Initiate MFA flow
            $current_username = $this->customerSession->getCustomer()->getEmail();

            $this->TwoFAUtility->setSessionValue('mousername', $current_username);
            // function: to set username in cookie
            $this->setCookie('mousername', $current_username);

            //get user detail from 'miniorange_tfa_users' database
            $row = $this->TwoFAUtility->getCustomerMoTfaUserDetails('miniorange_tfa_users', $current_username);
            
            $redirectionUrl = '';
            
            // Check if user has multiple methods available and needs to choose
            $twofaMethods = $this->TwoFAUtility->getCustomer2FAMethodsFromRules($customer_role_name, $current_website_id);
            $number_of_activeMethod = $twofaMethods['count'];
            
            $this->TwoFAUtility->log_debug("Execute Checkout2FA: Checking user flow - methods count: " . $number_of_activeMethod);
            $this->TwoFAUtility->log_debug("Execute Checkout2FA: User row exists: " . (is_array($row) && sizeof($row) > 0 ? 'yes' : 'no'));
            if (is_array($row) && sizeof($row) > 0) {
                $this->TwoFAUtility->log_debug("Execute Checkout2FA: User skip_twofa value: " . ($row[0]['skip_twofa'] ?? 'null'));
            }
            
            // Check if 2FA is disabled for this user (for all paths)
            if (is_array($row) && sizeof($row) > 0 && $this->check_2fa_disable($row)) {
                $this->TwoFAUtility->log_debug("Execute Checkout2FA: 2FA is disabled for this user, proceeding with default checkout");
                return;
            }

            // Store checkout page URL for redirect after 2FA completion
            $previous_url = $this->TwoFAUtility->getBaseUrl() . 'checkout';
            $this->TwoFAUtility->setSessionValue('referrer_url', $previous_url);
            $this->TwoFAUtility->log_debug("Checkout2FA: Stored referrer URL: " . $previous_url);

            if ((is_array($row) && sizeof($row) > 0) && (isset($row[0]['skip_twofa']) && ($row[0]['skip_twofa'] == NULL || $row[0]['skip_twofa'] == ''))) {

                $this->TwoFAUtility->log_debug("Execute Checkout2FA: User is existing 2FA user, calling handleExisting2FAUser");
                
                // Call function to handle existing 2FA users
                $this->handleExisting2FAUser($current_username, $row, $current_website_id, $controller);
            } elseif ($number_of_activeMethod > 1) {
                // Multiple methods available, show method selection page
                $this->TwoFAUtility->log_debug("Execute Checkout2FA: Multiple methods available, showing method selection");
                $this->handleNew2FAUser($current_username, $customer_role_name, $current_website_id, $controller);
            } else {
                // Call function to handle new 2FA users
                $this->TwoFAUtility->log_debug("Execute Checkout2FA: User is new or has no active method, calling handleNew2FAUser");
                $this->handleNew2FAUser($current_username, $customer_role_name, $current_website_id, $controller);
            }
        } else {
            //inline 2fa is disable.
            $this->TwoFAUtility->log_debug("Execute Checkout2FA: Invoke Inline off");
        }
    }

    /**
     * Sets a cookie with the given name and value
     */
    private function setCookie($name, $value)
    {
        $metadata = $this->cookieMetadataFactory->createPublicCookieMetadata()
            ->setDuration(3600)
            ->setPath('/');
        $this->cookieManager->setPublicCookie($name, $value, $metadata);
    }

    /**
     * Handle the "Remember Device" check for 2FA.
     *
     * This function validates if the user's current device matches any saved devices
     * and is within the configured day limit for bypassing 2FA.
     *
     * @param string $username The username of the current user.
     * @param int $websiteId The website ID for multi-store configurations.
     * @param array $row The saved device information for the user.
     * @return bool              Returns true if 2FA can be skipped, false otherwise.
     */
    public function handleRememberDeviceCheck($username, $websiteId, $row)
    {
        // Retrieve device restriction settings and saved device information
        $isDeviceBasedRestrictionEnabled = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE);

        // Validate if device restriction is enabled and devices are saved for the user
        if ($isDeviceBasedRestrictionEnabled && isset($row) && !empty($row) && isset($row[0]['device_info']) && $row[0]['device_info'] != '') {
            $this->TwoFAUtility->log_debug("LoginPost.php : Inside device-based restriction check.");

            $savedDevices = json_decode($row[0]['device_info'], true);
            $currentDevice = json_decode($this->TwoFAUtility->getCurrentDeviceInfo(), true);

            // If no current device info is found, log and return false
            if (!$currentDevice) {
                $this->TwoFAUtility->log_debug("LoginPost.php : No current device information found.");
                return false;
            }

            $deviceDayLimit = (int)$this->TwoFAUtility->getStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE_LIMIT);
            $currentDay = date('Y-m-d');
            $this->TwoFAUtility->log_debug("LoginPost.php : Device day limit: " . $deviceDayLimit);

            // Iterate through saved devices to check for a match
            foreach ($savedDevices as $savedDevice) {
                $areDevicesSame = true;
                $fieldsToCompare = ['Fingerprint'];

                // Check if the current device matches on required fields
                foreach ($fieldsToCompare as $field) {
                    if (!isset($savedDevice[$field]) || !isset($currentDevice[$field]) || $savedDevice[$field] !== $currentDevice[$field]) {
                        $areDevicesSame = false;
                        break;
                    }
                }

                // Check cookie validity if devices match
                if ($areDevicesSame) {
                    $cookieName = 'device_info_' . hash('sha256', $username);
                    $deviceCookieInfo = $_COOKIE[$cookieName] ?? null;
                    if ($deviceCookieInfo !== $savedDevice['Random_string']) {
                        $this->TwoFAUtility->log_debug("LoginPost.php : Cookies do not match with fingerprint.");
                        $areDevicesSame = false;
                    }
                }

                // If devices match, check the configured date against the day limit
                if ($areDevicesSame) {
                    $this->TwoFAUtility->log_debug("LoginPost.php : Device matches: " . $areDevicesSame);
                    $configuredDate = $savedDevice['configured_date'];
                    $remainingDays = (strtotime($currentDay) - strtotime($configuredDate)) / (60 * 60 * 24);

                    if ($remainingDays < $deviceDayLimit) {
                        $this->TwoFAUtility->log_debug("LoginPost.php : Device matches and remaining days < device day limit. Remaining Days: " . $remainingDays);
                        $this->TwoFAUtility->log_debug("LoginPost.php : Logging in without 2FA due to matching device.");

                        // Log the successful login and redirect to home page
                        // Return true for successful login without 2FA
                        return true;
                    }

                    // If outside the day limit, break and prompt 2FA
                    $this->TwoFAUtility->log_debug("LoginPost.php : Matching device found but outside the allowed day limit.");
                    break;
                }
            }
        }

        // If no matching device found or outside the limit, return false for further 2FA checks
        $this->TwoFAUtility->log_debug("LoginPost.php : No matching device found within allowed day limit for user: " . $username);
        return false;
    }

    /**
     * Handles the logic for skipping two-factor authentication (2FA) based on user settings.
     */
    private function handleSkipTwoFA($row, $current_website_id)
    {
        $this->TwoFAUtility->log_debug("Checkout2FA =>handleSkipTwoFA: Entering function.");

        $isCustomerSkipEnabled = (int)$this->TwoFAUtility->getStoreConfig(TwoFAConstants::SKIP_TWOFA);
        if ($isCustomerSkipEnabled != 1) {
            $this->TwoFAUtility->log_debug("Checkout2FA =>handleSkipTwoFA: Skip 2FA is not enabled.");
            return false;
        }

        $days = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::SKIP_TWOFA_DAYS);
        $this->TwoFAUtility->log_debug("Checkout2FA =>handleSkipTwoFA: Skip 2FA days configuration: " . $days);

        // Check for permanently skipped 2FA users
        if (!empty($row) && isset($row[0]['skip_twofa_premanent']) && $row[0]['skip_twofa_premanent'] == true && $days == 'permanent') {
            $this->TwoFAUtility->log_debug("Checkout2FA =>handleSkipTwoFA: User has permanently skipped 2FA.");
            return true;
        }

        // Check skip date for users with temporary skip 2FA
        if (!empty($row) && isset($row[0]['skip_twofa_configured_date']) && $row[0]['skip_twofa_configured_date'] != NULL) {
            $skipTwofaData = json_decode($row[0]['skip_twofa_configured_date'], true);
            if (isset($skipTwofaData['configured_date'])) {
                $configuredDate = $skipTwofaData['configured_date'];
                $currentDay = date('Y-m-d');
                $remainingDays = (strtotime($currentDay) - strtotime($configuredDate)) / (60 * 60 * 24);

                if ($days == 'permanent' || $remainingDays < (int)$days) {
                    $this->TwoFAUtility->log_debug("Checkout2FA =>handleSkipTwoFA: User is within the allowed skip period.");
                    return true;
                }
            }
        }

        $this->TwoFAUtility->log_debug("Checkout2FA =>handleSkipTwoFA: Skip 2FA conditions not met, proceeding with normal flow.");
        return false;
    }

    /**
     * Handles existing 2FA users and their 2FA method during checkout.
     */
    private function handleExisting2FAUser($current_username, $row, $current_website_id, $controller)
    {
        $this->TwoFAUtility->log_debug("Execute Checkout2FA: Customer has already registered in TwoFA method");
        $twoFAMethod = $row[0]['active_method'];

        $params = array(
            'mooption' => 'invokeInline', 
            'step' => 'ChooseMFAMethod', 
            'email' => $current_username,
            'checkout_redirect' => '1'
        );

 
        $check_if_user_configured_Alternate2FAMethod = false;
        if (isset($row[0]['all_active_methods']) && $row[0]['all_active_methods'] !== NULL && $row[0]['all_active_methods'] !== '[]') {
            $check_if_user_configured_Alternate2FAMethod = true;
        }

        if($check_if_user_configured_Alternate2FAMethod){

            $this->TwoFAUtility->log_debug("Execute Checkout2FA: User has configured alternate 2FA method, redirecting to alternate method page");
            $redirectUrl = $this->TwoFAUtility->getBaseUrl() . 'motwofa/mocustomer/alternate?' . http_build_query($params);
            $this->redirect->redirect($controller->getResponse(), $redirectUrl);
            return;
        }

        $this->TwoFAUtility->log_debug("Execute Checkout2FA: User has not configured alternate 2FA method, redirecting to validate page");

        // Handle case where twoFAMethod is empty: delete the user entry in miniorange_tfa_users and restart 2FA setup
        if (!isset($twoFAMethod) || empty($twoFAMethod) || $twoFAMethod == NULL) {
            $this->TwoFAUtility->log_debug("Execute Checkout2FA: TwoFA method is empty, deleting user entry and redirecting to login page");
            $idvalue = $row[0]['id'];
            $this->TwoFAUtility->deleteRowInTable('miniorange_tfa_users', 'id', $idvalue);
            $this->messageManager->addError(__('Something went wrong.Please login again'));
            $this->redirect->redirect($controller->getResponse(), 'customer/account/login');
            return;
        }

        $result = $this->process2FAMethod($row, $current_username, $twoFAMethod, $current_website_id, $controller);
    }

    /**
     * Processes the (2FA) method for a customer login for Existing 2fa users and redirect to validate page
     */
    private function process2FAMethod($row, $current_username, $twoFAMethod, $current_website_id, $controller)
    {
        if ("GoogleAuthenticator" != $twoFAMethod && "MicrosoftAuthenticator" != $twoFAMethod) {
            $custom_gateway_email = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
            $custom_gateway_sms = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
            $custom_gateway_whatsapp = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);

            // Fetch the last OTP sent time and attempt count
            $lastOtpSentTime = $this->TwoFAUtility->getSessionValue('last_otp_sent_time');
            $currentTime = time();

            // Check if the user needs to wait for 60 seconds
            if ($lastOtpSentTime !== null && ($currentTime - $lastOtpSentTime) < 60) {
                $remainingTime = 60 - ($currentTime - $lastOtpSentTime);

                // Log the response with the remaining time
                $this->TwoFAUtility->log_debug(
                    "Checkout2FA: User needs to wait. Remaining time: $remainingTime seconds"
                );

                $result = [
                    'status'  => 'ERROR',
                    'message' => "OTP envoyé il y a quelques secondes. Veuillez réessayer après $remainingTime secondes ",
                ];

                $params = [
                    'mooption'         => 'invokeTFA',
                    'r_status'         => 'ERROR',
                    'active_method'    => $twoFAMethod,
                    'email'            => $current_username,
                    'message'          => "OTP envoyé il y a quelques secondes. Veuillez réessayer après $remainingTime secondes ",
                    'checkout_redirect'=> '1',
                    'error=1' => '1'
                ];

                if ($twoFAMethod === 'OOS' || $twoFAMethod === 'OOSE') {
                    $params['phone']        = $row[0]['phone'];
                    $params['countrycode']  = $row[0]['countrycode'];
                }

                $redirectUrl = $this->TwoFAUtility->getBaseUrl() . 'motwofa/mocustomer/index?' . http_build_query($params);
                $this->redirect->redirect($controller->getResponse(), $redirectUrl);
                return;
            }

            // check if the phone and countrycode is present in the blacklisted numbers
            if($twoFAMethod === 'OOS' || $twoFAMethod === 'OOSE') {
                if(isset($row[0]['phone']) && isset($row[0]['countrycode'])) {
                    $isBlockSpamPhoneNumberEnabled = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::CUSTOMER_ENABLE_BLOCK_SPAM_PHONE_NUMBER);
                    if ($isBlockSpamPhoneNumberEnabled) {
                    $blacklisted = $this->TwoFAUtility->checkBlacklistedPhone($row[0]['phone'], $row[0]['countrycode']);
                    $message = "The phone number you have entered has been flagged and is currently blacklisted. Please use a different number to proceed.";
                    $message = $this->TwoFAUtility->translateOtpMessage($message);
                        if ($blacklisted) {
                            $this->messageManager->addErrorMessage(__($message));
                            $this->redirect->redirect($controller->getResponse(), 'customer/account');
                            return;
                        }
                    }
                }
            }

            try {
                if ($custom_gateway_email || $custom_gateway_sms) {
                    $result = $this->handleCustomGateway($row, $current_username, $twoFAMethod, $current_website_id);
                } else if ($twoFAMethod === 'OOW') {
                    $result = $this->handleWhatsApp2FAMethod($twoFAMethod, $custom_gateway_whatsapp, $row);
                } else {
                    $result = $this->handleMiniOrangeGateway($current_username, $twoFAMethod, $current_website_id);
                }
            } catch (\Exception $e) {
                $this->TwoFAUtility->log_debug("2FA method processing error: " . $e->getMessage());
                $result = [
                    'status' => 'FAILED',
                    'message' => 'Something went wrong. Please contact your administrator.',
                    'txId' => '1'
                ];
            }

            if ($result['status'] === 'SUCCESS') {
                $this->TwoFAUtility->updateColumnInTable('miniorange_tfa_users', 'transactionId', $result['txId'], 'username', $current_username, $current_website_id);
                
                // Translate the message from English to French
                $translatedMessage = $this->TwoFAUtility->translateOtpMessage($result['message']);
                
                $params = [
                    'mooption' => 'invokeTFA',
                    'r_status' => $result['status'],
                    'active_method' => $twoFAMethod,
                    'email' => $current_username,
                    'message' => $translatedMessage,
                    'checkout_redirect' => '1'
                ];

                if ($twoFAMethod === 'OOS' || $twoFAMethod === 'OOSE') {
                    $params['phone'] = $row[0]['phone'];
                    $params['countrycode'] = $row[0]['countrycode'];
                }

                $redirectUrl = $this->TwoFAUtility->getBaseUrl() . 'motwofa/mocustomer/index?' . http_build_query($params);
                $this->TwoFAUtility->setSessionValue('last_otp_sent_time', $currentTime);
                $this->redirect->redirect($controller->getResponse(), $redirectUrl);
            } else {
                $this->TwoFAUtility->log_debug("Checkout2FA: Unable to send OTP. Please contact your Administrator.");
                $this->messageManager->addError(__('Something went wrong. Please contact your administrator.'));
                $this->redirect->redirect($controller->getResponse(), 'customer/account');
            }
        } else {
            // google authenticator
            $params = [
                'mooption' => 'invokeTFA',
                'active_method' => $twoFAMethod,
                'checkout_redirect' => '1'
            ];
            $this->TwoFAUtility->flushCache();
            $redirectUrl = $this->TwoFAUtility->getBaseUrl() . 'motwofa/mocustomer/index?' . http_build_query($params);
            $this->redirect->redirect($controller->getResponse(), $redirectUrl);
        }
    }

    /**
     * Handles custom 2FA methods (Email, SMS, WhatsApp) for OTP generation and sending.
     */
    private function handleCustomGateway($row, $current_username, $twoFAMethod, $current_website_id)
    {
        $result = [];
        $custom_gateway_email = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
        $custom_gateway_sms = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
        $custom_gateway_whatsapp = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);

        $this->TwoFAUtility->log_debug("Checkout2FA: Custom gateway");

        if ($twoFAMethod === 'OOE' && $custom_gateway_email) {
            $custom_gateway_otp = $this->TwoFAUtility->Customgateway_GenerateOTP();
            $to = $current_username;
            $result = $this->customEmail->sendCustomgatewayEmail($to, $custom_gateway_otp);
        } elseif ($twoFAMethod === 'OOE') {
            $result = $this->handleMiniOrangeGateway($current_username, $twoFAMethod, $current_website_id);
        }

        if ($twoFAMethod === 'OOS' && $custom_gateway_sms) {
            $sms_otp = $this->TwoFAUtility->Customgateway_GenerateOTP();
            $phone = '+' . $row[0]['countrycode'] . $row[0]['phone'];
            $result = $this->customSMS->send_customgateway_sms($phone, $sms_otp);
        } elseif ($twoFAMethod === 'OOS') {
            $result = $this->handleMiniOrangeGateway($current_username, $twoFAMethod, $current_website_id);
        }

        if ($twoFAMethod === 'OOW' && $custom_gateway_whatsapp) {
            $otp = $this->TwoFAUtility->Customgateway_GenerateOTP();
            $phone = '+' . $row[0]['countrycode'] . $row[0]['phone'];
            $result = $this->TwoFAUtility->send_customgateway_whatsapp($phone, $otp);
        } elseif ($twoFAMethod === 'OOW') {
            $otp = $this->TwoFAUtility->Customgateway_GenerateOTP();
            $result = $this->TwoFAUtility->send_whatsapp($phone, $otp);
        }

        if ($twoFAMethod == 'OOSE') {
            $custom_gateway_otp = $this->TwoFAUtility->Customgateway_GenerateOTP();
            $to = $current_username;
            $phone = $row[0]['phone'];
            $countrycode = $row[0]['countrycode'];
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

            $message = $this->TwoFAUtility->OTP_over_SMSandEMAIL_Message($to, $phone, $result_email['status'], $result_sms['status']);
            if ($result_email['status'] == 'SUCCESS' || $result_sms['status'] == 'SUCCESS') {
                $result = array(
                    'status' => 'SUCCESS',
                    'message' => $message,
                    'txId' => '1'
                );
            } else {
                $result = array(
                    'status' => 'FAILED',
                    'message' => $message,
                    'txId' => '1'
                );
            }
        }

        if ($result['status'] === 'SUCCESS') {
            $this->setOtpExpiryTime();
        }

        return $result;
    }

    /**
     * Triggers the OTP challenge via the MiniOrange gateway for the selected 2FA method.
     */
    private function handleMiniOrangeGateway($username, $twoFAMethod, $websiteId)
    {
        try {
            $mouser = new MiniOrangeUser();
            $response = json_decode($mouser->challenge($username, $this->TwoFAUtility, $twoFAMethod, true, $websiteId));
            return [
                'status' => $response->status,
                'message' => $response->message,
                'txId' => $response->txId
            ];
        } catch (\Exception $e) {
            $this->TwoFAUtility->log_debug("MiniOrange gateway error: " . $e->getMessage());
            return [
                'status' => 'FAILED',
                'message' => 'Something went wrong. Please contact your administrator.',
                'txId' => '1'
            ];
        }
    }

    /**
     * Sets the OTP expiry time in the session.
     */
    private function setOtpExpiryTime()
    {
        $expiry_time = 600;
        $current_time = time();
        $otp_expiry_time = $current_time + $expiry_time;
        $expiry_seconds = $expiry_time % 60;
        $this->TwoFAUtility->log_debug("Checkout2FA: OTP expiry set for $expiry_seconds seconds");
        $this->TwoFAUtility->setSessionValue('otp_expiry_time', $otp_expiry_time);
    }

    /**
     * Handles sending the OTP via WhatsApp for 2FA.
     */
    private function handleWhatsApp2FAMethod($twoFAMethod, $custom_gateway_whatsapp, $row)
    {
        $otp = $this->TwoFAUtility->Customgateway_GenerateOTP();
        $phone = $row[0]['countrycode'] . $row[0]['phone'];
        if ($custom_gateway_whatsapp) {
            return $this->TwoFAUtility->send_customgateway_whatsapp($phone, $otp);
        } else {
            return $this->TwoFAUtility->send_whatsapp($phone, $otp);
        }
    }

    /**
     * Handles new 2FA users
     */
    private function handleNew2FAUser($current_username, $customer_role_name, $current_website_id, $controller)
    {
        $this->TwoFAUtility->log_debug("Execute Checkout2FA: Customer going through Inline for 2FA setup");

        $twofaMethods = $this->TwoFAUtility->getCustomer2FAMethodsFromRules($customer_role_name, $current_website_id);
        $number_of_activeMethod = $twofaMethods['count'];
        $customer_active_method = null;
        
        if ($number_of_activeMethod == 1) {
            $customer_active_method = trim($twofaMethods['methods'], '[""]');
        }

        if ($number_of_activeMethod == 1 && $customer_active_method) {
            $params = array(
                'mopostoption' => 'method',
                'miniorangetfa_method' => $customer_active_method,
                'inline_one_method' => '1',
                'email' => $current_username,
                'checkout_redirect' => '1'
            );
            $redirectUrl = $this->TwoFAUtility->getBaseUrl() . 'motwofa/mocustomer?' . http_build_query($params);
            $this->redirect->redirect($controller->getResponse(), $redirectUrl);
        } elseif ($number_of_activeMethod > 1) {
            $params = array(
                'mooption' => 'invokeInline', 
                'step' => 'ChooseMFAMethod', 
                'email' => $current_username,
                'checkout_redirect' => '1'
            );
            $redirectUrl = $this->TwoFAUtility->getBaseUrl() . 'motwofa/mocustomer/index?' . http_build_query($params);
            $this->redirect->redirect($controller->getResponse(), $redirectUrl);
        } else {
            $this->redirect->redirect($controller->getResponse(), 'customer/account');
        }
    }

    /**
     * Checks if 2FA is disabled for the user.
     * Returns true if 2FA is disabled, false otherwise.
     */
    public function check_2fa_disable($row)
    {
        if (isset($row[0]['disable_2fa']) && $row[0]['disable_2fa'] == 1) {
            $this->TwoFAUtility->log_debug("Checkout2FA: 2FA is disabled for this user");
            return true;
        }
        return false;
    }
}

