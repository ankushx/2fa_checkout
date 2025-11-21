<?php

namespace MiniOrange\TwoFA\Helper;

class MiniOrangeUser
{
    private $userInfoData;

    /**
     * This function use to send otp from miniorange gateway for customer
    */
    public function challenge($username, $TwoFAUtility, $authType = NULL, $isConfigure = false, $website_id = -1)
    {
        //This function use to send otp from miniorange gateway
        $TwoFAUtility->log_debug("MiniOrangeUser.php : execute: Challenge");
        if ($authType == "MICROSOFT AUTHENTICATOR" || $authType == "AUTHY AUTHENTICATOR" || $authType == "LASTPASS AUTHENTICATOR" || $authType == "DUO AUTHENTICATOR") {
            $authType = "GOOGLE AUTHENTICATOR";
        }
        $row = $TwoFAUtility->getAllMoTfaUserDetails('miniorange_tfa_users', $username, $website_id);
        $userdata = $this->userInfoData;
        $customerKeys = $TwoFAUtility->getCustomerKeys(false);
        $customerKey = $customerKeys['customer_key'];
        $apiKey = $customerKeys['apiKey'];
        $authCodes = array('OOE' => 'EMAIL', 'OOS' => 'SMS', 'OOSE' => 'SMS AND EMAIL', 'KBA' => 'KBA', 'OOW' => 'SMS');
        $phone = isset($row[0]['phone']) ? str_replace(" ", "", $row[0]['phone']) : "";
        $email = isset($row[0]['email']) ? str_replace(" ", "", $row[0]['email']) : "";
        $countrycode = isset($row[0]['countrycode']) ? str_replace(" ", "", $row[0]['countrycode']) : "";
        $user_name = $username;
        if ($userdata != NULL) {
            $phone = isset($userdata['phone']) ? str_replace(" ", "", $userdata['phone']) : "";
            $email = isset($userdata['email']) ? str_replace(" ", "", $userdata['email']) : "";
            $countrycode = isset($userdata['countrycode']) ? str_replace(" ", "", $userdata['countrycode']) : "";
            $user_name = isset($userdata['username']) ? $userdata['username'] : '';
        }
        $email = $username;
        $customer_inline = $TwoFAUtility->getSessionValue(TwoFAConstants::CUSTOMER_INLINE);
        if ($customer_inline) {
            $phone = $TwoFAUtility->getSessionValue(TwoFAConstants::CUSTOMER__PHONE);
            // $email=$TwoFAUtility->getSessionValue(TwoFAConstants::CUSTOMER_USERNAME);
            $countrycode = $TwoFAUtility->getSessionValue(TwoFAConstants::CUSTOMER_COUNTRY_CODE);
        }
        $admin_inline = $TwoFAUtility->getSessionValue(TwoFAConstants::ADMIN_IS_INLINE);
        if ($admin_inline) {
            $phone = $TwoFAUtility->getSessionValue(TwoFAConstants::ADMIN__PHONE);
            //    $email=$TwoFAUtility->getSessionValue(TwoFAConstants::ADMIN__EMAIL);
            $countrycode = $TwoFAUtility->getSessionValue(TwoFAConstants::ADMIN_COUNTRY_CODE);
        }


        //customization : fixes and testing
        if ($countrycode && strpos($countrycode, '+') !== 0) {
            $countrycode = '+' . $countrycode;
        }
        $phone = $countrycode . $phone;

        if ($authType == 'OOS') {
            $phone_set = $phone;
            $email_set = '';
            $TwoFAUtility->log_debug("MiniOrangeUser.php : execute: Challenge:phone set");
            if($phone)
            {
                $TwoFAUtility->log_debug("MiniOrangeUser.php : execute: Challenge:phone is set => " . $phone);
            }else{
                $TwoFAUtility->log_debug("MiniOrangeUser.php : execute: Challenge:phone is not set");
            }
        }
        if ($authType == 'OOW') {
            $phone_set = $phone;
            $email_set = '';
            $TwoFAUtility->log_debug("MiniOrangeUser.php : execute: Challenge:phone set for whatsapp");
        }
        if ($authType == 'OOE') {
            $phone_set = '';
            $email_set = $email;
            $TwoFAUtility->log_debug("MiniOrangeUser.php : execute: Challenge:email set");
        }
        if ($authType == 'OOSE') {
            $phone_set = $phone;
            $email_set = $email;
            $TwoFAUtility->log_debug("MiniOrangeUser.php : execute: Challenge:email and phone set");
        }

        if ($isConfigure) {

            $fields = array(
                'customerKey' => $customerKey,
                'username' => '',
                'phone' => $phone_set,
                'email' => $email_set,
                'authType' => $authCodes[$authType],
                'transactionName' => $TwoFAUtility->getTransactionName()
            );
        } else {
            $fields = array(
                'customerKey' => $customerKey,
                'username' => $user_name,
                'transactionName' => $TwoFAUtility->getTransactionName(),
                'authType' => $authType
            );
        }

        $urls = $TwoFAUtility->getApiUrls();
        $url = $urls['challange'];
        return Curl::challenge($customerKey, $apiKey, $url, $fields);

    }

    /**
     * This function use to send otp from miniorange gateway for admin user
    */
    public function challenge_admin($username, $TwoFAUtility, $authType = NULL, $isConfigure = false, $website_id = -1)
    {
        //This function use to send otp from miniorange gateway
        $TwoFAUtility->log_debug("MiniOrangeUser.php : execute: Challenge");
        if ($authType == "MICROSOFT AUTHENTICATOR" || $authType == "AUTHY AUTHENTICATOR" || $authType == "LASTPASS AUTHENTICATOR" || $authType == "DUO AUTHENTICATOR") {
            $authType = "GOOGLE AUTHENTICATOR";
        }
        $row = $TwoFAUtility->getAllMoTfaUserDetails('miniorange_tfa_users', $username, $website_id);
        $userdata = $this->userInfoData;
        $customerKeys = $TwoFAUtility->getCustomerKeys(false);
        $customerKey = $customerKeys['customer_key'];
        $apiKey = $customerKeys['apiKey'];
        $authCodes = array('OOE' => 'EMAIL', 'OOS' => 'SMS', 'OOSE' => 'SMS AND EMAIL', 'KBA' => 'KBA', 'OOW' => 'SMS');
        $phone = isset($row[0]['phone']) ? str_replace(" ", "", $row[0]['phone']) : "";
        $email = isset($row[0]['email']) ? str_replace(" ", "", $row[0]['email']) : "";
        $countrycode = isset($row[0]['countrycode']) ? str_replace(" ", "", $row[0]['countrycode']) : "";
        $user_name = $username;
        if ($userdata != NULL) {
            $phone = isset($userdata['phone']) ? str_replace(" ", "", $userdata['phone']) : "";
            $email = isset($userdata['email']) ? str_replace(" ", "", $userdata['email']) : "";
            $countrycode = isset($userdata['countrycode']) ? str_replace(" ", "", $userdata['countrycode']) : "";
            $user_name = isset($userdata['username']) ? $userdata['username'] : '';
        }
        if($row && $row[0]['email']){
            $TwoFAUtility->log_debug("MiniOrangeUser.php : user already exists in miniorange_tfa_users table");
            $TwoFAUtility->log_debug("MiniOrangeUser.php : execute: Challenge:email set from miniorange_tfa_users table for email: ".$row[0]['email']);
            
            $email = $row[0]['email'];
        }else{
            $TwoFAUtility->log_debug("MiniOrangeUser.php : user not exists in miniorange_tfa_users table, using username as email ".$username);
            $email = $username;
        }
        $customer_inline = $TwoFAUtility->getSessionValue(TwoFAConstants::CUSTOMER_INLINE);
        if ($customer_inline) {
            $phone = $TwoFAUtility->getSessionValue(TwoFAConstants::CUSTOMER__PHONE);
            // $email=$TwoFAUtility->getSessionValue(TwoFAConstants::CUSTOMER_USERNAME);
            $countrycode = $TwoFAUtility->getSessionValue(TwoFAConstants::CUSTOMER_COUNTRY_CODE);
        }
        $admin_inline = $TwoFAUtility->getSessionValue(TwoFAConstants::ADMIN_IS_INLINE);
        if ($admin_inline) {
            $phone = $TwoFAUtility->getSessionValue(TwoFAConstants::ADMIN__PHONE);
            //    $email=$TwoFAUtility->getSessionValue(TwoFAConstants::ADMIN__EMAIL);
            $countrycode = $TwoFAUtility->getSessionValue(TwoFAConstants::ADMIN_COUNTRY_CODE);
        }
        //customization : fixes and testing
        if ($countrycode && strpos($countrycode, '+') !== 0) {
            $countrycode = '+' . $countrycode;
        }
        $phone = $countrycode . $phone;
        if ($authType == 'OOS') {
            $phone_set = $phone;
            $email_set = '';
            $TwoFAUtility->log_debug("MiniOrangeUser.php : execute: Challenge:phone set");
        }
        if ($authType == 'OOW') {
            $phone_set = $phone;
            $email_set = '';
            $TwoFAUtility->log_debug("MiniOrangeUser.php : execute: Challenge:phone set for whatsapp");
        }
        if ($authType == 'OOE') {
            $phone_set = '';
            $email_set = $email;
            $TwoFAUtility->log_debug("MiniOrangeUser.php : execute: Challenge:email set");
        }
        if ($authType == 'OOSE') {
            $phone_set = $phone;
            $email_set = $email;
            $TwoFAUtility->log_debug("MiniOrangeUser.php : execute: Challenge:email and phone set");
        }
        if ($isConfigure) {
            $fields = array(
                'customerKey' => $customerKey,
                'username' => '',
                'phone' => $phone_set,
                'email' => $email_set,
                'authType' => $authCodes[$authType],
                'transactionName' => $TwoFAUtility->getTransactionName()
            );
        } else {
            $fields = array(
                'customerKey' => $customerKey,
                'username' => $user_name,
                'transactionName' => $TwoFAUtility->getTransactionName(),
                'authType' => $authType
            );
        }
        $urls = $TwoFAUtility->getApiUrls();
        $url = $urls['challange'];
        return Curl::challenge($customerKey, $apiKey, $url, $fields);
    }

    function mo2f_update_userinfo($TwoFAUtility, $email, $authType, $phone = '')
    {
        $TwoFAUtility->log_debug("MiniOrangeUser.php : execute:mo2f_update_userinfo");
        $customerKeys = $TwoFAUtility->getCustomerKeys();
        $customerKey = $customerKeys['customer_key'];
        $apiKey = $customerKeys['apiKey'];
        $authCodes = array('OOE' => 'EMAIL', 'OOS' => 'SMS', 'OOW' => 'SMS', 'OOSE' => 'SMS AND EMAIL', 'KBA' => 'KBA', 'google' => 'GOOGLE AUTHENTICATOR', 'MA' => 'MICROSOFT AUTHENTICATOR', 'AA' => 'AUTHY AUTHENTICATOR', 'LPA' => 'LASTPASS AUTHENTICATOR', 'DUO' => 'Duo AUTHENTICATOR');
        $fields = array(
            'customerKey' => $customerKey,
            'username' => $email,
            'transactionName' => $TwoFAUtility->getTransactionName(),
        );
        if ($authType != '') {
            if ($authType === "GoogleAuthenticator") {
                $fields['authType'] = "Google Authenticator";
            } elseif ($authType === "MicrosoftAuthenticator") {
                $fields['authType'] = "Microsoft Authenticator";
            } else {
                $fields['authType'] = $authCodes[$authType];
            }
        }
        if ($phone != '') {
            $fields['phone'] = $phone;
        }

        $urls = $TwoFAUtility->getApiUrls();
        $url = $urls['update'];
        return Curl::update($customerKey, $apiKey, $url, $fields);
    }

    function mo_create_user($TwoFAUtility, $email, $authType, $phone = '')
    {
        $TwoFAUtility->log_debug("MiniOrangeUser.php : execute:mo_create_user");
        $customerKeys = $TwoFAUtility->getCustomerKeys();
        $customerKey = $customerKeys['customer_key'];
        $apiKey = $customerKeys['apiKey'];
        $authCodes = array('OOE' => 'EMAIL', 'OOS' => 'SMS', 'OOW' => 'SMS', 'OOSE' => 'SMS AND EMAIL', 'KBA' => 'KBA', 'google' => 'GOOGLE AUTHENTICATOR', 'MA' => 'MICROSOFT AUTHENTICATOR', 'AA' => 'AUTHY AUTHENTICATOR', 'LPA' => 'LASTPASS AUTHENTICATOR', 'DUO' => 'Duo AUTHENTICATOR');
        $fields = array(
            'customerKey' => $customerKey,
            'username' => $email,
            'transactionName' => $TwoFAUtility->getTransactionName(),
        );
        if ($authType != '') {
            if ($authType === "GoogleAuthenticator") {
                $fields['authType'] = "Google Authenticator";
            } else {
                $fields['authType'] = $authCodes[$authType];
            }
        }
        if ($phone != '') {
            $fields['phone'] = $phone;
        }

        $urls = $TwoFAUtility->getApiUrls();
        $url = $urls['createUser'];
        return Curl::update($customerKey, $apiKey, $url, $fields);
    }

    public function validate($username, $token, $authType, $TwoFAUtility, $answers = NULL, $isConfiguring = false, $website_id = -1)
    {
        //This function use to validate otp from miniOrange Gateway
        $TwoFAUtility->log_debug("MiniOrangeUser.php : execute: validate");
        $customerKeys = $TwoFAUtility->getCustomerKeys(true);
        $customerKey = $customerKeys['customer_key'];
        $apiKey = $customerKeys['apiKey'];
        $row = $TwoFAUtility->getAllMoTfaUserDetails('miniorange_tfa_users', $username, $website_id);
        
        $userdata = $this->userInfoData;
        if ($userdata != NULL) {
            $transactionID = $userdata['transactionId'];
            $user_name = $userdata['username'];

        } elseif (is_array($row) && sizeof($row) > 0) {
            $transactionID = $row[0]['transactionId'];
        }

        //updated changes
        $customer_inline = isset($customer_inline) ? $customer_inline : '1';

        if ($customer_inline) {
            $customerTransactionID = $TwoFAUtility->getSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID);
            if ($customerTransactionID != null) {
                $transactionID = $customerTransactionID;
            }
        }

        $admin_inline = $TwoFAUtility->getSessionValue(TwoFAConstants::ADMIN_IS_INLINE);
        if ($admin_inline) {
            $adminTransactionID = $TwoFAUtility->getSessionValue(TwoFAConstants::ADMIN_TRANSACTIONID);
            if ($adminTransactionID !== null) {
                $transactionID = $adminTransactionID;
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

        $urls = $TwoFAUtility->getApiUrls();
        $url = $urls['validate'];
        return Curl::validate($customerKey, $apiKey, $url, $fields);

    }

    public function setUserInfoData($userInfoData)
    {
        $this->userInfoData = $userInfoData;
        return $this;
    }
}
