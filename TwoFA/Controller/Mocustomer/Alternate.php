<?php

namespace MiniOrange\TwoFA\Controller\Mocustomer;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\CustomSMS;
use MiniOrange\TwoFA\Helper\MiniOrangeUser;
use MiniOrange\TwoFA\Helper\MiniOrangeInline;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Session;
class Alternate extends Action
{
    protected $_pageFactory;
    protected $request;
    protected $resultFactory;
    private $TwoFAUtility;
    protected $customEmail;
    protected $customSMS;
    protected $messageManager;
    private $miniOrangeInline;
    private $customerModel;
    private $customerSession;
    private $url;
    protected $storeManager;

    public function __construct(
        Context                                         $context,
        PageFactory                                     $pageFactory,
        RequestInterface                                 $request,
        TwoFAUtility                                     $TwoFAUtility,
        \Magento\Framework\Controller\ResultFactory     $resultFactory,
        CustomEmail                                     $customEmail,
        CustomSMS                                       $customSMS,
        \Magento\Framework\Message\ManagerInterface      $messageManager,
        MiniOrangeInline                                   $miniOrangeInline,
        Customer                                           $customerModel,
        \Magento\Framework\UrlInterface                    $url,
        Session                                            $customerSession,
        \Magento\Store\Model\StoreManagerInterface         $storeManager
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->request = $request;
        $this->TwoFAUtility = $TwoFAUtility;
        $this->resultFactory = $resultFactory;
        $this->customEmail = $customEmail;
        $this->customSMS = $customSMS;
        $this->messageManager = $messageManager;
        $this->miniOrangeInline = $miniOrangeInline;
        $this->customerSession = $customerSession;
        $this->customerModel = $customerModel;
        $this->url = $url;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->TwoFAUtility->log_debug("In Mocustomer/Alternate: execute");

        // Ensure the alternate page opens the method chooser by default
        $params = $this->request->getParams();

        if (!isset($params['mooption'])) {
            $params['mooption'] = 'invokeInline';
        }
        if (!isset($params['step'])) {
            $params['step'] = 'ChooseMFAMethod';
        }

        $current_username = $this->TwoFAUtility->getSessionValue('mousername');
        if (!$current_username && isset($params['email'])) {
            $current_username = $params['email'];
            $this->TwoFAUtility->setSessionValue('mousername', $current_username);
            $this->TwoFAUtility->log_debug("Alternate.php : email found in params, setting session username: " . $current_username);
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


        $postValue = $this->request->getPostValue();

        if (isset($postValue['mopostoption']) && $postValue['mopostoption'] == 'uservalotp'){

            $method = isset($postValue['savestep']) ? $postValue['savestep'] : 'OOS';
            $this->TwoFAUtility->log_debug("Alternate.php : customer selected method => " . $method);
            $email = isset($postValue['email']) ? $postValue['email'] : '';
            $this->TwoFAUtility->log_debug("Alternate.php : customer email => " . $email);

            return $this->validateReturningUserOtp($postValue, $email, $method);

        }


        $this->getRequest()->setParams($params);

        return $this->_pageFactory->create();
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
    public function validateReturningUserOtp($postValue, $current_username, $method)
    {

        $this->TwoFAUtility->log_debug("Validating 2FA for already configured customer.");
        $response = $this->validateOtpForReturningUser($postValue, $current_username);

        if ($response && $response['status'] == 'SUCCESS') {
            return $this->redirectToCustomerAccount($current_username);
        }

        // failed otp
        $redirect_url = $this->url->getUrl('motwofa/mocustomer/alternate') . "?mooption=invokeTFA&error=error";

        if(isset($method) && $method != '') {
            // otp is invalid , send to the alternate 2fa page with the method for error message
            $this->TwoFAUtility->log_debug("Alternate.php : otp is invalid , sending to the alternate 2fa page with the method for error message: " . $method);
            $redirect_url = $this->url->getUrl('motwofa/mocustomer/alternate') . "?mooption=invokeTFA&active_method=" . $method . "&error=error";
        }
        

        return $this->handleOtpFailure($response, $redirect_url);
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
        $this->TwoFAUtility->log_debug("Alternate.php : check if remember device is enabled: " . $rememberDevice);

        // get the method from the post value
        $method = '';
        if(isset($postValue['savestep']) && $postValue['savestep'] != '') {
            $this->TwoFAUtility->log_debug("Alternate.php : method passed from alternate 2fa page: " . $postValue['savestep']);
            $method = $postValue['savestep'];
        }else{
            $this->TwoFAUtility->log_debug("Alternate.php : no method passed from alternate 2fa page , using default method OOS");
            $method = 'OOS';
        }
        return $this->miniOrangeInline->TFAValidate($this->TwoFAUtility, $current_username, $rememberDevice, $method);
    }


}


