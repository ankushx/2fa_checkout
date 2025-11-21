<?php

namespace MiniOrange\TwoFA\Controller\Actions;

use MiniOrange\TwoFA\Helper\AESEncryption;
use MiniOrange\TwoFA\Helper\Curl;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class LoginExistingUserAction extends BaseAdminAction
{
    private $REQUEST;
    public function execute()
    {
        if (!$this->twofautility->isTrialExpired()) {
            goto KEFGa;
        }
        $this->twofautility->log_debug("\120\162\x6f\143\x65\163\163\125\x73\145\162\x41\143\164\x69\157\156\x3a\40\145\x78\x65\143\x75\164\145\x20\x3a\x20\x59\x6f\165\x72\x20\144\145\x6d\157\x20\141\x63\x63\157\165\156\x74\40\x68\141\x73\40\145\x78\160\151\x72\145\144\x2e");
        KEFGa:
        $this->checkIfRequiredFieldsEmpty(["\x65\155\x61\x69\154" => $this->REQUEST, "\x70\141\163\163\167\x6f\162\x64" => $this->REQUEST, "\163\x75\142\155\x69\164" => $this->REQUEST]);
        $jpi2O = $this->REQUEST["\145\x6d\141\151\154"];
        $wguNs = $this->REQUEST["\x70\x61\x73\x73\x77\157\x72\x64"];
        $OdHPi = $this->REQUEST["\x73\x75\x62\x6d\151\x74"];
        $this->getCurrentCustomer($jpi2O, $wguNs);
        $this->twofautility->flushCache("\114\157\147\x69\156\x45\170\x69\x73\x74\x69\156\x67\x55\163\x65\x72\101\143\164\151\x6f\156\x20");
        return;
    }
    protected function getCurrentCustomer($jpi2O, $wguNs)
    {
        $JNwr9 = Curl::get_customer_key($jpi2O, $wguNs);
        $S9ftw = json_decode($JNwr9, true);
        $this->twofautility->log_debug("\x4c\x6f\x67\105\170\151\x73\x74\x69\156\147\125\163\145\x72\x41\x63\x74\x69\x6f\156\x3a\x20\x67\x65\164\103\x75\x72\162\x65\x6e\x74\103\165\x73\x74\157\155\145\x72");
        if (json_last_error() == JSON_ERROR_NONE && $S9ftw != NULL) {
            goto FefJB;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::REG_STATUS, TwoFAConstants::STATUS_VERIFY_LOGIN);
        $this->messageManager->addErrorMessage(TwoFAMessages::INVALID_CRED);
        goto XU2Xb;
        FefJB:
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_EMAIL, $jpi2O);
        $as_ST = TwoFAConstants::DEFAULT_TOKEN_VALUE;
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_PASSWORD, AESEncryption::encrypt_data($wguNs, $as_ST));
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_KEY, $S9ftw["\x69\x64"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::API_KEY, $S9ftw["\x61\160\x69\113\x65\171"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::TOKEN, $S9ftw["\164\157\153\x65\156"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::TXT_ID, '');
        $this->twofautility->setStoreConfig(TwoFAConstants::REG_STATUS, TwoFAConstants::STATUS_COMPLETE_LOGIN);
        $F20HK = $this->twofautility->getStoreConfig(TwoFAConstants::TIMESTAMP);
        if (!isset($F20HK)) {
            goto Dieoy;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::TIMESTAMP, $F20HK);
        $DQXgX = ["\x74\151\155\145\123\164\141\155\x70" => $F20HK, "\x6d\x69\x6e\151\157\162\141\156\147\x65\x41\x63\143\157\x75\x6e\164\x45\155\141\x69\x6c" => $jpi2O, "\160\154\x75\147\x69\x6e\x56\x65\x72\163\x69\x6f\x6e" => TwoFAConstants::VERSION];
        Curl::sendUserDetailsToPortal($DQXgX);
        Dieoy:
        $this->messageManager->addSuccessMessage(TwoFAMessages::REG_SUCCESS);
        XU2Xb:
    }
    public function setRequestParam($uT97U)
    {
        $this->REQUEST = $uT97U;
        return $this;
    }
}