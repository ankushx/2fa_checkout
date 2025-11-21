<?php

namespace MiniOrange\TwoFA\Block;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResourceConnection;
use MiniOrange\TwoFA\Helper\Curl;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Model\ResourceModel\IpWhitelisted\Collection as IpWhitelistedCollection;
use MiniOrange\TwoFA\Model\ResourceModel\IpWhitelistedAdmin\Collection as IpWhitelistedAdminCollection;

/**
 * This class is used to denote our admin block for all our
 * backend templates. This class has certain commmon
 * functions which can be called from our admin template pages.
 */
class TwoFA extends Template
{


    protected $authSession;
    protected $ipWhitlistedCollection;
    protected $ipWhitlistedAdminCollection;
    protected $storeManager;
    protected $_websiteCollectionFactory;
    protected $scopeConfig;
    private $twofautility;
    private $adminRoleModel;
    private $userGroupModel;
    private $request;
    private $deploymentConfig;
    private $_resource;


    public function __construct(
        Context                                                      $context,
        \MiniOrange\TwoFA\Helper\TwoFAUtility                        $twofautility,
        \Magento\Authorization\Model\ResourceModel\Role\Collection   $adminRoleModel,
        \Magento\Customer\Model\ResourceModel\Group\Collection       $userGroupModel,
        \Magento\Backend\Model\Auth\Session                          $authSession,
        \Magento\Framework\App\DeploymentConfig                      $deploymentConfig,
        RequestInterface                                             $request,
        \Magento\Store\Model\ResourceModel\Website\CollectionFactory $websiteCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface                   $storeManager,
        IpWhitelistedCollection                                      $ipWhitlistedCollection,
        IpWhitelistedAdminCollection                                 $ipWhitlistedAdminCollection,
        \Magento\Framework\App\Config\ScopeConfigInterface           $scopeConfig,
        \Magento\Framework\App\ResourceConnection                    $resource,
        array                                                        $data = []
    )
    {
        $this->twofautility = $twofautility;
        $this->authSession = $authSession;
        $this->adminRoleModel = $adminRoleModel;
        $this->userGroupModel = $userGroupModel;
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->deploymentConfig = $deploymentConfig;
        $this->_websiteCollectionFactory = $websiteCollectionFactory;
        $this->ipWhitlistedCollection = $ipWhitlistedCollection;
        $this->ipWhitlistedAdminCollection = $ipWhitlistedAdminCollection;
        $this->scopeConfig = $scopeConfig;
        $this->_resource = $resource;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve websites collection of system
     *
     * @return Website Collection
     */

    /**
     * get ip whitelisted data for customer from database
     */
    public function getWhitelistedIpData()
    {
        return $this->ipWhitlistedCollection->getItems();
    }

    /**
     * get ip whitelisted data for admin from database
     */
    public function getWhitelistedIpDataAdmin()
    {
        return $this->ipWhitlistedAdminCollection->getItems();
    }

    public function getAdminSecret()
    {
        return $this->twofautility->getAdminSecret();
    }

    public function getCustomerSecret()
    {
        return $this->twofautility->getCustomerSecret();
    }

    /**
     * Get the user details for customer reset page
     * @return array
     */
    public function getUserDetailsforcustomerreset()
    {
        $current_username = $this->twofautility->getSessionValue('mousername');
        $row = $this->twofautility->getCustomerMoTfaUserDetails('miniorange_tfa_users', $current_username);
        return $row;

    }

    /**
     * Get the customer phone number configured
     * @param string $email
     * @return string
     */
    public function getCustomerPhoneConfigured($email)
    {
        $row = $this->twofautility->getCustomerMoTfaUserDetails('miniorange_tfa_users', $email);
        if (!empty($row) && isset($row[0]['phone']) && !empty($row[0]['phone'])) {
            $phone = $row[0]['phone'];
            $countrycode = $row[0]['countrycode'];
            return '+' . $countrycode . $phone;
        }
        return '';
    }

    public function totp_appname()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::TwoFA_AUTHENTICATOR_ISSUER);
    }

    public function getStoreConfig($customer_role, $current_website_id)
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::ACTIVE_METHOD . $customer_role . $current_website_id);
    }

    /**
     * Get customer 2FA methods
     */
    public function getCustomer2FAMethodsFromRules($customer_role_name, $current_website_id, $username = null)
    {
        return $this->twofautility->getCustomer2FAMethodsFromRules($customer_role_name, $current_website_id, $username);
    }

    public function getemailtemplatelist()
    {
        return $this->twofautility->getemailtemplatelist();
    }

    public function getselectedemailtemplateid()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::SELECTED_TEMPLATE_ID);
    }

    // This function returns list of stores if sandbox trial is enabled otherwise it returns list of websites
    public function getWebsiteCollection()
    {
        if($this->ifSandboxTrialEnabled())
        {
            return $this->storeManager->getStores();
        }
        else
        {
            $collection = $this->_websiteCollectionFactory->create();
            return $collection;
        }
    }

    public function getAllConfiguredUsers()
    {
        $connection = $this->_resource->getConnection();
        $tableName = $this->_resource->getTableName('miniorange_tfa_users');

        $query = "SELECT * FROM $tableName WHERE skip_twofa_premanent = 0";
        $result = $connection->fetchAll($query);

        return $result;
    }

    public function getSelectedWebsite()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::SELECTED_WEBSITE_FOR_SETTING);
    }

    // This function returns current store Id if sandbox trial is enabled, otherwise it returns current website Id
    public function get_customer_current_websiteID()
    {
        if($this->ifSandboxTrialEnabled())
        {
            return $this->storeManager->getStore()->getId();
        }
        else
        {
            return $this->storeManager->getStore()->getWebsiteId();
        }
    }

    public function get_admin_details()
    {
        //$this->twofautility->get_admin_role_name();
        $current_user = $this->getCurrentAdminUser();
        $current_email = $current_user->getEmail();
        $current_username = $current_user->getUsername();
        $admin_detail_array = array();
        $admin_detail_array['current_admin_username'] = $current_username;
        $admin_detail_array['current_admin_email'] = $current_email;
        return $admin_detail_array;
    }

    /**
     * Get the Current Admin user from session
     */
    public function getCurrentAdminUser()
    {
        return $this->twofautility->getCurrentAdminUser();
    }

    public function getEmail($selected_customer_role, $current_website_id)
    {

        $activeMethods = !is_null($this->twofautility->getStoreConfig(TwoFAConstants::ACTIVE_METHOD . $selected_customer_role . $current_website_id)) ? json_decode($this->twofautility->getStoreConfig(TwoFAConstants::ACTIVE_METHOD . $selected_customer_role . $current_website_id)) : " ";

        if (isset($activeMethods) && is_array($activeMethods) && in_array("OOE", $activeMethods)) {
            return "1";


        } else
            return "0";

    }

    public function get_customer_registration_twofa($website_id = null)
    {
        $currentRule = $this->getCurrentRuleFromRequest();
        if ($currentRule && isset($currentRule['registration_enabled'])) {
            $this->twofautility->log_debug("get_customer_registration_twofa: Reading from current rule - registration_enabled: " . $currentRule['registration_enabled']);
            return (bool)$currentRule['registration_enabled'];
        }

        if ($website_id === null) {
            $stored_selection = $this->twofautility->getStoreConfig('twofa/registration/selected_website');
            $this->twofautility->log_debug("get_customer_registration_twofa: Global stored selection: " . ($stored_selection ?: 'null'));
            
            if (!$stored_selection) {
                $this->twofautility->log_debug("get_customer_registration_twofa: No stored selection, returning false");
                return false;
            }
            
            $website_id = $stored_selection;
        }

        $this->twofautility->log_debug("get_customer_registration_twofa: Website ID: " . $website_id);

        $globalRules = $this->twofautility->getGlobalConfig(TwoFAConstants::CURRENT_CUSTOMER_RULE);
        if ($globalRules) {
            $rules = json_decode($globalRules, true);
            if (is_array($rules)) {
                foreach ($rules as $rule) {
                    if (isset($rule['site']) && $rule['site'] === $website_id && isset($rule['registration_enabled'])) {
                        $this->twofautility->log_debug("get_customer_registration_twofa: Found rule for website " . $website_id . " with registration_enabled: " . $rule['registration_enabled']);
                        return (bool)$rule['registration_enabled'];
                    }
                }
            }
        }

        $this->twofautility->log_debug("get_customer_registration_twofa: No rules found for website " . $website_id . " - 2FA not enabled");
        return false;
    }

    /**
     * Get the selected website for registration 2FA
     */
    public function get_selected_registration_website()
    {
        $stored_selection = $this->twofautility->getStoreConfig('twofa/registration/selected_website');
        return $stored_selection ?: 'all';
    }

    /**
     * Get the current rule being edited from request parameters
     */
    private function getCurrentRuleFromRequest()
    {
        if (!$this->request) {
            return null;
        }

        $currentUrl = $this->request->getUriString();
        $isRuleEditingPage = strpos($currentUrl, '/admin/') !== false && 
                             (strpos($currentUrl, 'customer2fa') !== false || 
                              strpos($currentUrl, 'tfasettingsconfigurationtable') !== false);
        
        if (!$isRuleEditingPage) {
            return null;
        }
        
        $siteParam = $this->request->getParam('site');
        $groupParam = $this->request->getParam('role');
        
        if (!$siteParam || !$groupParam) {
            return null;
        }

        $existingRules = $this->twofautility->getGlobalConfig(TwoFAConstants::CURRENT_CUSTOMER_RULE);
        if (!$existingRules) {
            return null;
        }
        
        $rules = json_decode($existingRules, true);
        if (!is_array($rules)) {
            return null;
        }

        foreach ($rules as $rule) {
            if (isset($rule['site']) && isset($rule['group']) && 
                $rule['site'] === $siteParam && $rule['group'] === $groupParam) {
                return $rule;
            }
        }
        return null;
    }

    public function get_number_of_activemethod_customer($customer_role, $current_website_id)
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::NUMBER_OF_CUSTOMER_METHOD . $customer_role . $current_website_id);
    }

    public function get_customer_details()
    {
        $user = $this->twofautility->get_customer_detailss();
        return $user;
    }

    public function get_admin_selected_role()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::ADMIN_SELECTED_ROLE);
    }

    public function get_customer_selected_role($current_website_id)
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_SELECTED_ROLE . $current_website_id);
    }

    public function get_string_set1($current_website_id)
    {
        $result1 = $this->twofautility->getStoreConfig(TwoFAConstants::QUESTION_SET_STRING1 . $current_website_id);
        if ($result1 == NULL || $result1 == '') {
            return NULL;
        } else {
            return $result1;
        }

    }

    public function get_string_set2($current_website_id)
    {
        $result2 = $this->twofautility->getStoreConfig(TwoFAConstants::QUESTION_SET_STRING2 . $current_website_id);
        if ($result2 == NULL || $result2 == '') {
            return NULL;
        } else {
            return $result2;
        }

    }

    public function show_kba_button($current_website_id)
    {
        $show_button = $this->twofautility->getStoreConfig(TwoFAConstants::KBA_METHOD . $current_website_id);
        if ($show_button == '0' || $show_button == NULL || $show_button == 0) {
            return NULL;
        } else {
            return 1;
        }
    }

    public function get_admin_append_name()
    {
        return $this->deploymentConfig->get('backend/frontName');
    }

    public function get_sms_email_detail()
    {
        $customer_key = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_KEY);
        $api_key = $this->twofautility->getStoreConfig(TwoFAConstants::API_KEY);
        $license_plan = $this->twofautility->getStoreConfig(TwoFAConstants::LICENSE_PLAN) ?? "";
        if ($customer_key == NULL || $api_key == NULL) {
            return false;
        }
        return Curl::get_email_sms_transactions($customer_key, $api_key, $license_plan);
    }

    public function get_kba_question()
    {
        $current_username = $this->twofautility->getSessionValue('mousername');
        $row = $this->twofautility->getCustomerMoTfaUserDetails('miniorange_tfa_users', $current_username);

        if (is_array($row) && sizeof($row) > 0) {
            $kba_method_data = $row[0]['kba_method'];
            $kba_method_data = json_decode($kba_method_data, true);
        }
        $random_keys = array_rand($kba_method_data, 2);

        $question_array = array($kba_method_data[$random_keys[0]], $kba_method_data[$random_keys[1]], $random_keys[0], $random_keys[1]);
        return $question_array;
    }

    public function get_admin_active_method($admin_email)
    {
        $admin_username = $this->twofautility->getUsernamefromEmail($admin_email);
        $admin_role = $this->twofautility->get_admin_role_name();
        $admin_active_method = $this->getAdminActiveMethodInline($admin_role, $admin_username);
        if ($admin_active_method == NULL) {
            return '';
        } else {
            return $admin_active_method;
        }

    }

    public function get_numberOf_admin_methods()
    {
        $admin_role = $this->twofautility->get_admin_role_name();
        $numberOF_admin_method = $this->twofautility->getStoreConfig(TwoFAConstants::NUMBER_OF_ADMIN_METHOD . $admin_role);
        return $numberOF_admin_method;
    }

    public function getRequestVariable()
    {
        return $this->request->getParams();
    }

    public function getSessionUsername()
    {
        // Get the email from the session
        $email = $this->twofautility->getSessionValue('mousername');
        $this->twofautility->log_debug("Block.php =>getsession username " . $email);
        if (!$email) {
            $request = $this->request->getParams();
            // Get the email/username from request parameters
            $email_params = isset($request['email']) ? $request['email'] : NULL;
            $this->twofautility->log_debug("Block.php =>getsession username email params " . $email_params);
        }

        // Determine the current user, prioritizing session email over request username
        $current_user = isset($email) ? $email : $email_params;

        if ($current_user) {
            return $current_user;
        } else {
            return false;
        }
    }

    public function emailerror()
    {
        // Redirect to a custom route for email verification
        $this->twofautility->log_debug("-----------Email not found in session. Possible login session issue.-------------");

    }

    /**
     * This function retrieves the miniOrange customer Email
     * from the database. To be used on our template pages.
     */
    public function getCustomerEmail()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_EMAIL);
    }

    public function isHeader()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::SEND_HEADER);
    }

    public function isBody()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::SEND_BODY);
    }

    /**
     * This function retrieves the miniOrange customer key from the
     * database. To be used on our template pages.
     */
    public function getCustomerKey()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_KEY);
    }

    /**
     * This function retrieves the miniOrange API key from the database.
     * To be used on our template pages.
     */
    public function getApiKey()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::API_KEY);
    }

    /**
     * This function retrieves the token key from the database.
     * To be used on our template pages.
     */
    public function getToken()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::TOKEN);
    }

    /**
     * This function checks if TwoFA has been configured or not.
     */
    public function isTwoFAConfigured()
    {
        return $this->twofautility->isTwoFAConfigured();
    }

    /**
     * This function fetches the TwoFA App name saved by the admin
     */
    public function getAppName()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::APP_NAME);
    }

    public function getAllTfaMethods()
    {
        $allTfas = $this->twofautility->tfaMethodArray();
        return $allTfas;
    }

    public function getUserDetails()
    {
        $current_user = $this->getCurrentAdminUser();
        $current_username = $current_user->getUsername();
        $tfaInfo = $this->twofautility->getAllMoTfaUserDetails('miniorange_tfa_users', $current_username, -1);
        return $tfaInfo;
    }

    public function getAdminEmailDetails()
    {
        $admin_email = $this->twofautility->getSessionValue('admin_inline_email_detail');
        if ($admin_email == NULL || $admin_email == '') {
            return NULL;
        } else {
            return $admin_email;
        }

    }

    /**
     * Is 2fa methods method configured for admin
     * Return: true or false
     */
    public function isTfaMethodConfiguredorActive($name)
    {
        $allTfaMethods = $this->twofautility->tfaMethodArray();
        $current_user = $this->getCurrentAdminUser();
        $current_username = $current_user->getUsername();
        $tfaInfo = $this->twofautility->getAllMoTfaUserDetails('miniorange_tfa_users', $current_username, -1);

        $isCustomerRegistered = $this->twofautility->isCustomerRegistered();
        $configureMethods = is_null($tfaInfo) || empty($tfaInfo) ? array() : explode(';', $tfaInfo[0]['configured_methods']);
        $activeMethod = is_null($tfaInfo) || empty($tfaInfo) ? '' : $tfaInfo[0]['active_method'];
        $response = [
            'is_active' => false,
            'is_configured' => false
        ];
        if ($name === $activeMethod) {
            $this->twofautility->log_debug("isTfaMethodConfiguredorActive - in active oos ,ooe,oose");
            $response['is_active'] = true;
        }
        if (in_array($name, $configureMethods)) {
            $this->twofautility->log_debug("isTfaMethodConfiguredorActive - in configured oos ,ooe,oose");
            $response['is_configured'] = true;
        }
        return $response;
    }

    /**
     * This function fetches the Client ID saved by the admin
     */
    public function getClientID()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CLIENT_ID);
    }

    /**
     * This function fetches the Client secret saved by the admin
     */
    public function getClientSecret()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CLIENT_SECRET);
    }

    /**
     * This function fetches the Scope saved by the admin
     */
    public function getScope()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::SCOPE);
    }

    /**
     * This function fetches the Authorize URL saved by the admin
     */
    public function getAuthorizeURL()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::AUTHORIZE_URL);
    }

    /**
     * This function fetches the AccessToken URL saved by the admin
     */
    public function getAccessTokenURL()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::ACCESSTOKEN_URL);
    }

    /**
     * This function fetches the GetUserInfo URL saved by the admin
     */
    public function getUserInfoURL()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::GETUSERINFO_URL);
    }

    public function AuthenticatorIssuer()
    {
        return $this->twofautility->AuthenticatorIssuer();
    }

    public function AuthenticatorUrl()
    {
        return $this->twofautility->AuthenticatorUrl();
    }

    public function AuthenticatorCustomerUrl($email)
    {
        return $this->twofautility->AuthenticatorCustomerUrl($email);
    }

    /**
     * This function gets the admin CSS URL to be appended to the
     * admin dashboard screen.
     */
    public function getAdminCssURL()
    {
        return $this->twofautility->getAdminCssUrl('adminSettings.css');
    }

    /**
     * This function gets the current version of the plugin
     * admin dashboard screen.
     */
    public function getCurrentVersion()
    {
        return TwoFAConstants::VERSION;
    }

    /**
     * This function gets the admin JS URL to be appended to the
     * admin dashboard pages for plugin functionality
     */
    public function getQrCodeJS()
    {
        return $this->twofautility->getAdminJSUrl('jquery-qrcode.js');
    }

    /**
     * This function gets the admin JS URL to be appended to the
     * admin dashboard pages for plugin functionality
     */
    public function getAdminJSURL()
    {
        return $this->twofautility->getAdminJSUrl('adminSettings.js');
    }

    /**
     * This function gets the IntelTelInput JS URL to be appended
     * to admin pages to show country code dropdown on phone number
     * fields.
     */
    public function getIntlTelInputJs()
    {
        return $this->twofautility->getAdminJSUrl('intlTelInput.min.js');
    }

    /**
     * This function fetches/creates the TEST Configuration URL of the
     * Plugin.
     */
    public function getTestUrl()
    {
        return $this->getSPInitiatedUrl(TwoFAConstants::TEST_RELAYSTATE);
    }

    /**
     * Create/Get the SP initiated URL for the site.
     */
    public function getSPInitiatedUrl($relayState = null)
    {
        return $this->twofautility->getSPInitiatedUrl($relayState);
    }

    /**
     * Get/Create Base URL of the site
     */
    public function getCallBackUrl()
    {
        return $this->twofautility->getBaseUrl() . TwoFAConstants::CALLBACK_URL;
    }

    /**
     * Get/Create Base URL of the site
     */
    public function getBaseUrl()
    {
        return $this->twofautility->getBaseUrl();
    }

    /**
     * Create the URL for one of the SAML SP plugin
     * sections to be shown as link on any of the
     * template files.
     */
    public function getExtensionPageUrl($page)
    {
        return $this->twofautility->getAdminUrl('motwofa/' . $page . '/index');
    }

    /**
     * Reads the Tab and retrieves the current active tab
     * if any.
     */
    public function getCurrentActiveTab()
    {
        $page = $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => false]);
        $start = strpos($page, '/motwofa') + 9;
        $end = strpos($page, '/index/key');
        $tab = substr($page, $start, $end - $start);

        return $tab;
    }

    /**
     * Just check and return if the user has verified his
     * license key to activate the plugin. Mostly used
     * on the account page to show the verify license key
     * screen.
     */
    public function isVerified()
    {
        return $this->twofautility->mclv();
    }

    public function isLicenseKeyVerified()
    {
        return $this->twofautility->isLicenseKeyVerified();
    }

    public function isTrialActivated()  {
        return $this->twofautility->isTrialActivated();
    }

    /**
     * Is the option to show SSO link on the Admin login page enabled
     * by the admin.
     */
    public function showAdminLink()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::SHOW_ADMIN_LINK);
    }

    /**
     * Is the option to show SSO link on the Customer login page enabled
     * by the admin.
     */
    public function showCustomerLink()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::SHOW_CUSTOMER_LINK);
    }

    /**
     * This fetches the setting saved by the admin which decides if the
     * account should be mapped to username or email in Magento.
     */
    public function getAccountMatcher()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::MAP_MAP_BY);
    }

    /**
     * This fetches the setting saved by the admin which doesn't allow
     * roles to be assigned to unlisted users.
     */
    public function getDisallowUnlistedUserRole()
    {
        $disallowUnlistedRole = $this->twofautility->getStoreConfig(TwoFAConstants::UNLISTED_ROLE);
        return !$this->twofautility->isBlank($disallowUnlistedRole) ? $disallowUnlistedRole : '';
    }

    /**
     * This fetches the setting saved by the admin which doesn't allow
     * users to be created if roles are not mapped based on the admin settings.
     */
    public function getDisallowUserCreationIfRoleNotMapped()
    {
        $disallowUserCreationIfRoleNotMapped = $this->twofautility->getStoreConfig(TwoFAConstants::CREATEIFNOTMAP);
        return !$this->twofautility->isBlank($disallowUserCreationIfRoleNotMapped) ? $disallowUserCreationIfRoleNotMapped : '';
    }

    /**
     * This fetches the setting saved by the admin which decides what
     * attribute in the SAML response should be mapped to the Magento
     * user's userName.
     */
    public function getUserNameMapping()
    {
        $amUserName = $this->twofautility->getStoreConfig(TwoFAConstants::MAP_USERNAME);
        return !$this->twofautility->isBlank($amUserName) ? $amUserName : '';
    }

    public function getGroupMapping()
    {
        $amGroupName = $this->twofautility->getStoreConfig(TwoFAConstants::MAP_GROUP);
        return !$this->twofautility->isBlank($amGroupName) ? $amGroupName : '';
    }

    /**
     * This fetches the setting saved by the admin which decides what
     * attribute in the SAML response should be mapped to the Magento
     * user's Email.
     */
    public function getUserEmailMapping()
    {
        $amEmail = $this->twofautility->getStoreConfig(TwoFAConstants::MAP_EMAIL);
        return !$this->twofautility->isBlank($amEmail) ? $amEmail : '';
    }

    /**
     * This fetches the setting saved by the admin which decides what
     * attribute in the SAML response should be mapped to the Magento
     * user's firstName.
     */
    public function getFirstNameMapping()
    {
        $amFirstName = $this->twofautility->getStoreConfig(TwoFAConstants::MAP_FIRSTNAME);
        return !$this->twofautility->isBlank($amFirstName) ? $amFirstName : '';
    }

    /**
     * This fetches the setting saved by the admin which decides what
     * attributein the SAML resposne should be mapped to the Magento
     * user's lastName
     */
    public function getLastNameMapping()
    {
        $amLastName = $this->twofautility->getStoreConfig(TwoFAConstants::MAP_LASTNAME);
        return !$this->twofautility->isBlank($amLastName) ? $amLastName : '';
    }

    /**
     * Get all admin roles set by the admin on his site.
     */
    public function getAllRoles()
    {
        //Apply a filter to only include roles of a certain type ('G' in this case)
        $rolesCollection = $this->adminRoleModel->addFieldToFilter('role_type', 'G');
        // Convert the filtered collection to an options array
        $rolesOptionsArray = $rolesCollection->toOptionArray();
        return $rolesOptionsArray;
    }

    /**
     * Get all admin roles set by the admin on his site.
     */
    public function get_existingRules()
    {
        $configValue = $this->twofautility->getStoreConfig(TwoFAConstants::CURRENT_ADMIN_RULE);
        // Check if the value is null, and if so, return an empty array or handle as needed
        return $configValue ? json_decode($configValue, true) : [];
    }

    /**
     * Get all customer roles set by the admin on his site.
     */
    public function get_customerexistingRules()
    {
        $configValue = $this->twofautility->getStoreConfig(TwoFAConstants::CURRENT_CUSTOMER_RULE);
        // Check if the value is null, and if so, return an empty array or handle as needed
        return $configValue ? json_decode($configValue, true) : [];
    }

    /**
     * This function fetches the X509 cert saved by the admin for the IDP
     * in the plugin settings.
     */
    public function getX509Cert()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::X509CERT);
    }

    /**
     * Get all customer groups set by the admin on his site.
     */
    public function getAllGroups()
    {
        return $this->userGroupModel->toOptionArray();
    }

    /**
     * Get the default role to be set for the user if it
     * doesn't match any of the role/group mappings
     */
    public function getDefaultRole()
    {
        $defaultRole = $this->twofautility->getStoreConfig(TwoFAConstants::MAP_DEFAULT_ROLE);
        return !$this->twofautility->isBlank($defaultRole) ? $defaultRole : TwoFAConstants::DEFAULT_ROLE;
    }

    /**
     * This fetches the registration status in the plugin.
     * Used to detect at what stage is the user at for
     * registration with miniOrange
     */
    public function getRegistrationStatus()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::REG_STATUS);
    }

    /**
     * Fetches/Creates the text of the button to be shown
     * for SP inititated login from the admin / customer
     * login pages.
     */
    public function getSSOButtonText()
    {
        $buttonText = $this->twofautility->getStoreConfig(TwoFAConstants::BUTTON_TEXT);
        $idpName = $this->twofautility->getStoreConfig(TwoFAConstants::APP_NAME);
        return !$this->twofautility->isBlank($buttonText) ? $buttonText : 'Login with ' . $idpName;
    }


    /**
     * Get base url of miniorange
     */
    public function getMiniOrangeUrl()
    {
        return $this->twofautility->getMiniOrangeUrl();
    }


    /**
     * Get Admin Logout URL for the site
     */
    public function getAdminLogoutUrl()
    {
        return $this->twofautility->getLogoutUrl();
    }

    public function getLogoutURL()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::TwoFA_LOGOUT_URL);
    }

    /**
     * Is Test Configuration clicked?
     */
    public function getIsTestConfigurationClicked()
    {
        return $this->twofautility->getIsTestConfigurationClicked();
    }

    /**
     * Is ip_admin Configuration clicked?
     */
    public function getIsIp_for_AdminClicked()
    {
        return $this->twofautility->getIsIp_for_AdminClicked();
    }

    /**
     * Is ip_customer Configuration clicked?
     */
    public function getIsIp_for_CustomerClicked()
    {
        return $this->twofautility->getIsIp_for_CustomerClicked();
    }

    /**
     * Is the option to show SSO link on the Customer login page enabled
     * by the admin.
     */
    public function invokeInline($current_website_id)
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::INVOKE_INLINE_REGISTERATION . $current_website_id);
    }

    /**
     * Is the option to show SSO link on the Admin login page enabled
     * by the admin.
     */
    public function TFAModule()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::MODULE_TFA);
    }

    public function kbaMethod($current_website_id)
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::KBA_METHOD . $current_website_id);
    }

    public function KBAQuestion_set1($current_website_id)
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::QUESTION_SET1 . $current_website_id);
    }

    public function KBAQuestion_set2($current_website_id)
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::QUESTION_SET2 . $current_website_id);
    }

    public function checkaccountVerified()
    {
        return $this->twofautility->micr()
            && $this->twofautility->mclv();
    }

    public function check2fa_backend_plan()
    {
        return $this->twofautility->check2fa_backend_plan();
    }

    // function to check if plan is Admin or both
    public function check2fa_backendPlan()
    {
        return $this->twofautility->check2fa_backendPlan();
    }

    public function get_license_plan()
    {
        return $this->twofautility->get_license_plan();
    }

    /*
    if otp is enabled for user
    */

    public function check2fa_frontend_plan()
    {
        return $this->twofautility->check2fa_frontend_plan();
    }

    /*
    if email is enabled for user */

    public function getOTP($selected_customer_role, $current_website_id)
    {

        $activeMethods = !is_null($this->twofautility->getStoreConfig(TwoFAConstants::ACTIVE_METHOD . $selected_customer_role . $current_website_id)) ? json_decode($this->twofautility->getStoreConfig(TwoFAConstants::ACTIVE_METHOD . $selected_customer_role . $current_website_id)) : " ";

        if (isset($activeMethods) && is_array($activeMethods) && in_array("OOS", $activeMethods))
            return "1";

        else
            return "0";

    }

    /*
    if oose is enabled for user */

    public function getOOSE($selected_customer_role, $current_website_id)
    {

        $activeMethods = !is_null($this->twofautility->getStoreConfig(TwoFAConstants::ACTIVE_METHOD . $selected_customer_role . $current_website_id)) ? json_decode($this->twofautility->getStoreConfig(TwoFAConstants::ACTIVE_METHOD . $selected_customer_role . $current_website_id)) : " ";

        if (isset($activeMethods) && is_array($activeMethods) && in_array("OOSE", $activeMethods))
            return "1";

        else
            return "0";

    }

    /*
    if oow is enabled for user
    */
    public function getOOW($selected_customer_role, $current_website_id)
    {

        $activeMethods = !is_null($this->twofautility->getStoreConfig(TwoFAConstants::ACTIVE_METHOD . $selected_customer_role . $current_website_id)) ? json_decode($this->twofautility->getStoreConfig(TwoFAConstants::ACTIVE_METHOD . $selected_customer_role . $current_website_id)) : " ";

        if (isset($activeMethods) && is_array($activeMethods) && in_array("OOW", $activeMethods))
            return "1";

        else
            return "0";

    }

    /*
    if google autenticator is enabled for user
    */
    public function getGA($selected_customer_role, $current_website_id)
    {

        $activeMethods = !is_null($this->twofautility->getStoreConfig(TwoFAConstants::ACTIVE_METHOD . $selected_customer_role . $current_website_id)) ? json_decode($this->twofautility->getStoreConfig(TwoFAConstants::ACTIVE_METHOD . $selected_customer_role . $current_website_id)) : " ";

        if (isset($activeMethods) && is_array($activeMethods) && in_array("GoogleAuthenticator", $activeMethods))
            return "1";

        else
            return "0";

    }

    /*
    if microsoft autenticator is enabled for user
    */
    public function getMA($selected_customer_role, $current_website_id)
    {

        $activeMethods = !is_null($this->twofautility->getStoreConfig(TwoFAConstants::ACTIVE_METHOD . $selected_customer_role . $current_website_id)) ? json_decode($this->twofautility->getStoreConfig(TwoFAConstants::ACTIVE_METHOD . $selected_customer_role . $current_website_id)) : " ";

        if (isset($activeMethods) && is_array($activeMethods) && in_array("MicrosoftAuthenticator", $activeMethods))
            return "1";

        else
            return "0";

    }

    /*
    active method for admins
    */
    public function admin_getOTP($selected_admin_role)
    {

        $activeMethods = $this->getAdminActiveMethodInline($selected_admin_role);

        if (isset($activeMethods) && is_array($activeMethods) && in_array("OOS", $activeMethods))
            return "1";

        else
            return "0";

    }

    /*
    if email is enabled for user */
    public function admin_getEmail($selected_admin_role)
    {

        $activeMethods = $this->getAdminActiveMethodInline($selected_admin_role);
        if (isset($activeMethods) && is_array($activeMethods) && in_array("OOE", $activeMethods)) {
            return "1";


        } else
            return "0";

    }

    /*
    if oose is enabled for user */
    public function admin_getOOSE($selected_admin_role)
    {

        $activeMethods = $this->getAdminActiveMethodInline($selected_admin_role);

        if (isset($activeMethods) && is_array($activeMethods) && in_array("OOSE", $activeMethods))
            return "1";

        else
            return "0";

    }

    /*
    if oow is enabled for user
     */
    public function admin_getOOW($selected_admin_role)
    {

        $activeMethods = $this->getAdminActiveMethodInline($selected_admin_role);

        if (isset($activeMethods) && is_array($activeMethods) && in_array("OOW", $activeMethods))
            return "1";

        else
            return "0";

    }

    public function admin_getGA($selected_admin_role)
    {
        $activeMethods = $this->getAdminActiveMethodInline($selected_admin_role);
        if (isset($activeMethods) && is_array($activeMethods) && in_array("GoogleAuthenticator", $activeMethods))
            return "1";

        else
            return "0";

    }

    public function admin_getMA($selected_admin_role)
    {

        $activeMethods = $this->getAdminActiveMethodInline($selected_admin_role);
        if (isset($activeMethods) && is_array($activeMethods) && in_array("MicrosoftAuthenticator", $activeMethods))
            return "1";

        else
            return "0";

    }

    /* ===================================================================================================
                THE FUNCTIONS BELOW ARE FREE PLUGIN SPECIFIC AND DIFFER IN THE PREMIUM VERSION
       ===================================================================================================
     */


    /**
     * This function checks if the user has completed the registration
     * and verification process. Returns TRUE or FALSE.
     */
    public function isEnabled()
    {
        return $this->twofautility->micr() && $this->twofautility->mclv();
    }

    public function getLkStatus()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::LK_VERIFY);
    }

    public function getLkCustomer()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::LK_NO_OF_USERS);
    }

    public function check_avaliable_customer()
    {

        return true;
    }


    public function check_lk()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::LK_VERIFY);
    }

    //custom gateway method function

    public function get_custom_protocol()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_PROTOCOL);
    }

    public function get_custom_authentication()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_AUTHENTICATION);
    }

    public function get_custom_sendFrom()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_SEND_FROM);
    }

    public function get_custom_sendTo()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_SEND_TO);
    }

    public function get_gatewayConfiguration_otplength()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_OTP_LENGTH);
    }

    public function get_smsConfiguration_message()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_SMS_MESSAGE);
    }

    public function get_enable_email_customgateway()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
    }


    /*
   get whatsaap access token,phoneid,template name,template language
   */

    public function get_enable_sms_customgateway()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
    }

    public function enable_whatsapp_customgateway()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
    }

    public function get_postMethod_phoneAttr()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_POST_PHONE_ATTR);
    }

    public function get_postMethod_messageAttr()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_POST_MESSAGE_ATTR);
    }

    public function get_postMethod_dynamicAttr()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_DYNAMIC_ATTRIBUTES);
    }
// public function get_enable_customgateway(){
//     return $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY);
// }

    public function getCustomMapping()
    {
        $amCustomName = array();
        $amCustomName = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_POST_FIELD);
        return !$this->twofautility->isBlank($amCustomName) ? json_decode($amCustomName) : '';
    }

    public function getUserManagementDetails()
    {
        $save_method_name = array(
            'OOSE' => "OTP Over SMS and Email",
            'OOS' => "OTP Over SMS",
            'OOE' => "OTP Over Email",
            'OOW' => "OTP Over Whatsapp",
            'GoogleAuthenticator' => 'Google Authenticator',
            'MicrosoftAuthenticator' => "Microsoft Authenticator"
        );
        $username = $this->twofautility->getStoreConfig(TwoFAConstants::USER_MANAGEMENT_USERNAME);
        $useremail = $this->twofautility->getStoreConfig(TwoFAConstants::USER_MANAGEMENT_EMAIL);
        $usercountrycode = $this->twofautility->getStoreConfig(TwoFAConstants::USER_MANAGEMENT_COUNTRYCODE);
        $userphone = $this->twofautility->getStoreConfig(TwoFAConstants::USER_MANAGEMENT_PHONE);
        $userActiveMethod = $this->twofautility->getStoreConfig(TwoFAConstants::USER_MANAGEMENT_ACTIVEMETHOD);
        $userConfiguredmethod = $this->twofautility->getStoreConfig(TwoFAConstants::USER_MANAGEMENT_CONFIGUREDMETHOD);
        $userDeviceInfo = $this->twofautility->getStoreConfig(TwoFAConstants::USER_MANAGEMENT_DEVICE_INFORMATION);

        //Active method shortcut method name with complete name.
        if ($userActiveMethod != NULL && $userActiveMethod != '') {
            foreach ($save_method_name as $method => $name) {
                $userActiveMethod = str_replace($method, $name, $userActiveMethod);
            }
        }
        //Configured method shortcut method name with complete name.
        if ($userConfiguredmethod != NULL && $userConfiguredmethod != '') {
            foreach ($save_method_name as $method => $name) {
                $userConfiguredmethod = str_replace($method, $name, $userConfiguredmethod);
            }
        }
        //Add '+' sign in front of countrycode
        if ($usercountrycode != NULL && $usercountrycode != '') {
            $usercountrycode = '+' . $usercountrycode;
        }

        $userDetails = array(
            'user_management_username' => $username,
            'user_management_email' => $useremail,
            'user_management_countrycode' => $usercountrycode,
            'user_management_phone' => $userphone,
            'user_management_activemethod' => $userActiveMethod,
            'user_management_configuredmethod' => $userConfiguredmethod,
            'user_management_deviceinfo' => $userDeviceInfo
        );
        return $userDetails;
    }

     /**
     * Retrieve the role of the current customer based on their email.
     * If inside registration, defaults to 'General'.
     */
    public function getCurrentCustomerRole($email)
    {
        $is_inside_registration = $this->twofautility->getSessionValue('mocreate_customer_register');
        if ($is_inside_registration) {
            return 'General';
        }
        $customer_info = $this->twofautility->getCustomerFromAttributes($email);
        if ($customer_info) {
            $customer_role_name = $this->twofautility->getGroupNameById($customer_info['group_id']);
            return $customer_role_name;
        } else {
            //    need to redirect to login page again
            return false;
        }
    }

    /**
     * Get popup UI configuration values.
     *
     */

    public function getPopupUI_values()
    {
        $popup_encoded_values = $this->twofautility->getStoreConfig(TwoFAConstants::POP_UI_VALUES);

        if ($popup_encoded_values != NULL) {
            return json_decode($popup_encoded_values);
        } else {
            return array();
        }
    }

    /**
     * Check if customers can skip Two-Factor Authentication.
     *
     */
    public function do_customer_skip_twofa()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::SKIP_TWOFA);
    }

    /**
     * Check if customers have set a minimum cart amount for 2FA trigger.
     */
    public function customer_minimum_cart_amount()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_MINIMUM_CART_AMOUNT);
    }

    /**
     * Check if customers have enabled alternate 2FA method.
     *
     */
    public function customer_enable_alternate_2fa_method()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_ENABLE_ALTERNATE_2FA_METHOD);
    }

    /**
     * Check if customers have enabled block spam phone number.
     *
     */
    public function customer_enable_block_spam_phone_number()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_ENABLE_BLOCK_SPAM_PHONE_NUMBER);
    }

    /**
     * Get the block spam phone number for customers.
     *
     */
    public function customer_block_spam_phone_number()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_BLOCK_SPAM_PHONE_NUMBER);
    }

    /**
     * Get the alternate 2FA method for customers.
     *
     */
    public function customer_alternate_2fa_method()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_ALTERNATE_2FA_METHOD);
    }

    /**
     * Check if customers can enable the minimum cart amount for 2FA trigger.
     *
     */
    public function customer_enable_cartAmount()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_ENABLE_CART_AMOUNT);
    }

    /**
     * Get customization settings for the customer popup.
     *
     */
    public function customer_popup_customization()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_POPUP_CUSTOMIZATION);
    }

    /**
     * Get the IP listing configuration for customers.
     *
     */
    public function customer_ip_listing()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::IP_LISTING);
    }

        /**
     * Check if all IPs are blacklisted.
     *
     */
    public function blacklistIPs()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::ALL_IP_BLACKLISTED);
    }

    /**
     * Check if all IPs are whitelisted.
     *
     */
    public function whitelistIPs()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::ALL_IP_WHITLISTED);
    }


    /**
     * Get the number of days customers can skip 2FA.
     *
     */
    public function customer_skip_days()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::SKIP_TWOFA_DAYS);
    }


    /**
     * Check if a specific admin role can skip 2FA.
     */
    public function do_admin_skip_twofa($selected_admin_role)
    {
        if ($selected_admin_role == '')
            $selected_admin_role = $this->twofautility->get_admin_role_name();
        return $this->twofautility->getStoreConfig(TwoFAConstants::SKIP_TWOFA_ADMIN . $selected_admin_role);
    }

        /**
     * Get the number of days a specific admin role can skip 2FA.
     */
    public function admin_skip_days($selected_admin_role)
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::SKIP_TWOFA_DAYS_ADMIN . $selected_admin_role);
    }

    /**
     * Check if the customer has enabled the 'Remember Device' feature.
     */
    public function get_customer_remember_device()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE);
    }

    /**
     * Get the number of days the 'Remember Device' feature is valid for customers.
     */
    public function get_customer_remember_device_days()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE_LIMIT);
    }

    /**
     * Get the maximum number of devices a customer can remember.
     */
    public function get_customer_remember_device_count()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE_COUNT);
    }

    /**
     * Check if the customer's device limit has been exceeded for 2FA.
     * 
     * @param int $website_id The ID of the website.
     * @param string $email The email of the customer.
     */
    public function is_device_limit_exceeded($website_id, $email)
    {
        return $this->twofautility->check_device_limit($website_id, $email);
    }

    /**
     * Check if the 'Remember Device' feature is enabled for a specific admin role.
     * 
     * @param string $selected_admin_role The admin role to check.
     */
    public function get_admin_remember_device($selected_admin_role)
    {
        if ($selected_admin_role == '')
            $selected_admin_role = $this->twofautility->get_admin_role_name();
        return $this->twofautility->getStoreConfig(TwoFAConstants::ADMIN_REMEMBER_DEVICE . $selected_admin_role);
    }

    /**
     * Get the number of days the 'Remember Device' feature is valid for a specific admin role.
     * 
     * @param string $selected_admin_role The admin role to check.
     */
    public function get_admin_remember_device_days($selected_admin_role)
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::ADMIN_REMEMBER_DEVICE_LIMIT . $selected_admin_role);
    }

    /**
     * Get the maximum number of devices an admin with a specific role can remember.
     * 
     * @param string $selected_admin_role The admin role to check.
     */
    public function get_admin_remember_device_count($selected_admin_role)
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::ADMIN_REMEMBER_DEVICE_COUNT . $selected_admin_role);
    }

    /**
     * Check if the admin's device limit has been exceeded for 2FA.
     * 
     * @param string $selected_admin_role The admin role to check.
     */
    public function is_device_limit_exceeded_admin($selected_admin_role)
    {
        if ($selected_admin_role == '')
            $selected_admin_role = $this->twofautility->get_admin_role_name();
        return $this->twofautility->check_device_limit_admin($selected_admin_role);
    }

    /**
     * Check if debug log is enabled.
     */
    public function isDebugLogEnable()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_DEBUG_LOG);
    }


    /*
    get customer skip twofa enabled/disabled
    */

    public function get_OTP_length($method)
    {
        return $this->twofautility->get_OTP_length($method);
    }

    /*
    get customer skip twofa enabled/disabled
    */

    public function getAdminEmail()
    {
        return $this->scopeConfig->getValue(
            'trans_email/ident_general/email', // This is the default path for the general admin email
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    // check if email gateway is enabled or not
    public function isEmailGatewayEnabled()
    {
    
        return $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
    }

    // Retrieves the email gateway - hostname from core_config_data table configuration
    public function get_custom_hostname()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_HOSTNAME);
    }

    // Retrieves the email gateway - port number from core_config_data table configuration

    public function get_custom_port()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_PORT);
    }


    /*
    get customer skip days
    */

    public function get_custom_username()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_USERNAME);
    }

    /*
    get admin skip twofa enabled/disabled
    */

    public function get_custom_password()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_PASSWORD);
    }

    /*
    get admin skip days
    */

    public function get_emailConfiguration_from()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_EMAIL_FROM);
    }

    /*
    get customer chooses remember my device
    */

    public function get_emailConfiguration_name()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_EMAIL_NAME);
    }

    /*
    get customer chooses device limit
    */

    public function isWhatsApp_GatewayEnabled()
    {
        $get_whatsapp_temlate_name = $this->get_whatsapp_temlate_name();
        $get_whatsapp_temlate_language = $this->get_whatsapp_temlate_language();
        $get_whatsapp_phoneid = $this->get_whatsapp_phoneid();
        $get_whatsapp_access_token = $this->get_whatsapp_access_token();

        // Check if all required values are not empty
        return (
            !empty($get_whatsapp_temlate_name) &&
            !empty($get_whatsapp_temlate_language) &&
            !empty($get_whatsapp_phoneid) &&
            !empty($get_whatsapp_access_token)
        );
    }

    /*
    get customer chooses remember my device
    */

    public function get_whatsapp_temlate_name()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::WhATSAPP_TEMPLATE_NAME);
    }

    /*
    get customer chooses remember my device
    */

    public function get_whatsapp_temlate_language()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::WhATSAPP_TEMPLATE_LANGUAGE);
    }


    /*
    get admin chooses remember my device
    */

    public function get_whatsapp_phoneid()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::WhATSAPP_PHONE_ID);
    }

    /*
    get admin chooses device limit
    */

    public function get_whatsapp_access_token()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::WhATSAPP_ACCESS_TOKEN);
    }

    /*
    get admin chooses remember my device
    */

    public function isSMS_GatewayEnabled()
    {
        $sms_provider = $this->get_customgateway_provider();
        if ($sms_provider == 'postMethod') {
            return (!empty($this->get_postMethod_url()));

        } else if ($sms_provider == 'getMethod') {

            return (!empty($this->get_getMethod_url()));

        } else {
            return (!empty($this->get_twilio_sid()) && !empty($this->get_twilio_token()) && !empty($this->get_twilio_number()));
        }

    }


    /*
    get admin chooses remember my device
    */

    public function get_customgateway_provider()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_API_PROVIDER);
    }

    // Retrieves the post method url from core_config_data table configuration
    public function get_postMethod_url()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_POSTMETHOD_URL);
    }

    public function get_getMethod_url()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_GETMETHOD_URL);
    }

    // Retrieves the Twilio sid from core_config_data table configuration
    public function get_twilio_sid()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TWILIO_SID);
    }


    // Retrieves the Twilio token from core_config_data table configuration
    public function get_twilio_token()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants:: CUSTOM_GATEWAY_TWILIO_TOKEN);
    }

    public function get_twilio_number()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TWILIO_NUMBER);
    }

    /**
     * get test pgone
     */
    public function get_test_phone_no()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TEST_PHONE_NO);
    }


    // trial plan implementaion

    /**
     * get license remaining days to show in the navbar
     */
    public function getDays()
    {
        $key = TwoFAConstants::DEFAULT_TOKEN_VALUE;
        $date = AESEncryption::decrypt_data($this->twofautility->getStoreConfig(TwoFAConstants::LICENSE_EXPIRY_DATE), $key);
        $expiryDate = new \DateTime("@$date");
        $now = new \DateTime();
        $daysTillExpiry = $now->diff($expiryDate)->format("%r%a");
        return $daysTillExpiry;
    }

    /* Function to fetch the days left for Trial Plan Expiry */
    public function daysTillTrialExpiry()
    {
        return $this->twofautility->daysTillTrialExpiry();
    }

    /**
     * Check if the trial has expired or not.
     */
    public function isTrialExpired()
    {
        return $this->twofautility->isTrialExpired();
    }


    /**
     * Check the current plan.
     */
    public function check_license_plan($lvl)
    {
        return $this->twofautility->check_license_plan($lvl);
    }

    /**
     * Check if the Sandbox trial is enabled
     */
    public function ifSandboxTrialEnabled()
    {
        return $this->twofautility->ifSandboxTrialEnabled();
    }

    public function getAdminActiveMethodInline($selected_admin_role, $admin_username)
    {
        return $this->twofautility->getAdminActiveMethodInline($selected_admin_role, $admin_username);
    }

    /**
     * Get the admin page URL for the plugin settings.
     */
    public function getAdminPageUrl()
    {
        return $this->twofautility->getAdminPageUrl();
    }

    /**
     * Get the OTP length
     */
    public function getOtpLength()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::ADVANCED_OTP_LENGTH) ?: 6;
    }

    /**
     * Check if authenticator app name customization is enabled
     */
    public function isAuthenticatorAppNameEnabled()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::AUTHENTICATOR_APP_NAME_ENABLED) ?: 0;
    }

    /**
     * Get the custom authenticator app name
     */
    public function getAuthenticatorAppName()
    {
        return $this->twofautility->getStoreConfig(TwoFAConstants::AUTHENTICATOR_APP_NAME) ?: 'miniOrange';
    }

    /**
     * Get the OTP length for a specific method, considering custom gateway settings
     */
    public function getOtpLengthForMethod($method = null)
    {
        return $this->twofautility->get_OTP_length($method);
    }

    /**
     * Get the customer Alternate 2FA method
     */
    public function getCustomerAlternate2faMethod()
    {
        if($this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_ENABLE_ALTERNATE_2FA_METHOD) ?: 0) {
            $methods = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_ALTERNATE_2FA_METHOD);
            return $methods;
        }
        return [];
    }

    /**
     * Get customer all active methods
     */
    public function getCustomerAllActiveMethods($email, $twofaMethods)
    {
        $row = $this->twofautility->getCustomerMoTfaUserDetails('miniorange_tfa_users', $email);

        $all_active_methods = isset($row[0]['all_active_methods']) ? $row[0]['all_active_methods'] : '[]';
        
        // Parse JSON strings from both sources
        $methodsFromTwoFA = json_decode($twofaMethods['methods'], true);
        $methodsFromDB = json_decode($all_active_methods, true);
        
        // Ensure both are arrays
        if (!is_array($methodsFromTwoFA)) {
            $methodsFromTwoFA = [];
        }
        if (!is_array($methodsFromDB)) {
            $methodsFromDB = [];
        }
        
        // Merge and remove duplicates
        $mergedMethods = array_unique(array_merge($methodsFromTwoFA, $methodsFromDB));
        // Re-index array to ensure proper JSON encoding
        $mergedMethods = array_values($mergedMethods);
        
        // Create result array
        $result = [
            'methods' => json_encode($mergedMethods),
            'count' => count($mergedMethods)
        ];
        
        return $result;
    }
}
