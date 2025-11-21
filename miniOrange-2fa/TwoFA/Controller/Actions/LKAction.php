<?php

namespace MiniOrange\TwoFA\Controller\Actions;

use MiniOrange\TwoFA\Helper\AESEncryption;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
use MiniOrange\TwoFA\Helper\Curl;
class LKAction extends BaseAdminAction
{
    private $REQUEST;
    public function removeAccount()
    {
        $this->twofautility->setStoreConfig(TwoFAConstants::REG_STATUS, TwoFAConstants::STATUS_VERIFY_LOGIN);
        if (!$this->twofautility->micr()) {
            goto MU5x5;
        }
        $NmH9l = TwoFAConstants::DEFAULT_TOKEN_VALUE;
        $V5XO2 = AESEncryption::decrypt_data($this->twofautility->getStoreConfig(TwoFAConstants::SAMLSP_LK), $NmH9l);
        $wZDA2 = json_decode($this->twofautility->update_status(trim($V5XO2)), true);
        if (!(strcasecmp($wZDA2["\x73\x74\141\x74\165\163"], "\x53\x55\103\103\x45\x53\x53") == 0)) {
            goto fm_Jl;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_EMAIL, '');
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_PASSWORD, '');
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_KEY, '');
        $this->twofautility->setStoreConfig(TwoFAConstants::API_KEY, '');
        $this->twofautility->setStoreConfig(TwoFAConstants::TOKEN, '');
        $this->twofautility->setStoreConfig(TwoFAConstants::PLAN_VERIFIED, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::SAMLSP_LK, '');
        $this->twofautility->setStoreConfig(TwoFAConstants::SAMLSP_CKL, '');
        $this->twofautility->setStoreConfig(TwoFAConstants::TRIAL_ACTIVATED, false);
        $this->twofautility->setStoreConfig(TwoFAConstants::LICENSE_PLAN, '');
        $this->twofautility->setStoreConfig(TwoFAConstants::REG_STATUS, TwoFAConstants::STATUS_VERIFY_LOGIN);
        $this->twofautility->removeSettingsAfterAccount();
        $this->twofautility->reinitconfig();
        fm_Jl:
        MU5x5:
        if (!$this->twofautility->mclv()) {
            goto afqP2;
        }
        $this->twofautility->mius();
        $this->twofautility->setStoreConfig(TwoFAConstants::SAMLSP_LK, '');
        $this->twofautility->setStoreConfig(TwoFAConstants::SAMLSP_CKL, '');
        afqP2:
        $this->twofautility->flushCache('');
    }
    public function setRequestParam($LC_Tw)
    {
        $this->REQUEST = $LC_Tw;
        return $this;
    }
    public function execute()
    {
        $jZo66 = ["\x6d\141\x67\145\x6e\x74\157\137\62\x66\141\137\160\x72\x65\x6d\151\165\x6d\x5f\x70\154\x61\x6e", "\x6d\141\x67\x65\156\x74\x6f\137\x32\x66\x61\x5f\x66\x72\x6f\156\x74\x65\156\x64\x5f\x70\154\x61\156", "\x6d\x61\x67\x65\156\x74\x6f\137\62\146\x61\137\142\x61\x63\153\145\x6e\144\x5f\160\154\141\156"];
        $this->checkIfRequiredFieldsEmpty(array("\154\153" => $this->REQUEST));
        $ljKCO = $this->REQUEST["\x6c\153"];
        foreach ($jZo66 as $fdVLP) {
            $SiZDF = $this->twofautility->ccl($fdVLP);
            if (is_null($SiZDF)) {
                goto ESLfE;
            }
            $Ne5yt = json_decode($SiZDF, true);
            if (!(isset($Ne5yt["\x73\164\x61\164\x75\x73"]) && $Ne5yt["\x73\x74\x61\x74\165\x73"] == "\x53\125\103\x43\x45\x53\123")) {
                goto DNldA;
            }
            $this->twofautility->setStoreConfig(TwoFAConstants::LICENSE_PLAN, $fdVLP);
            $eNNlZ = $this->twofautility->getStoreConfig(TwoFAConstants::TIMESTAMP);
            $QCLF1 = ["\x74\151\x6d\x65\x53\164\141\x6d\x70" => $eNNlZ, "\160\x6c\165\x67\x69\156\x50\x6c\141\x6e" => $fdVLP];
            Curl::sendUserDetailsToPortal($QCLF1);
            goto my_ZT;
            DNldA:
            ESLfE:
            ETjq0:
        }
        my_ZT:
        if (!(!isset($Ne5yt["\x73\x74\x61\x74\165\x73"]) || $Ne5yt["\163\164\141\164\165\x73"] != "\x53\125\103\103\x45\x53\x53")) {
            goto pRlmc;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::LICENSE_PLAN, "\155\x61\x67\145\156\164\157\137\62\146\141\137\x74\162\151\x61\x6c\x5f\x70\x6c\141\156");
        pRlmc:
        switch ($Ne5yt["\163\x74\x61\x74\165\x73"]) {
            case "\x53\x55\x43\x43\x45\x53\123":
                $this->_vlk_success($ljKCO);
                goto DNsau;
            default:
                $this->_vlk_fail();
                goto DNsau;
        }
        dMAwH:
        DNsau:
        $this->twofautility->reinitConfig();
        return;
    }
    public function _vlk_success($V5XO2)
    {
        $wZDA2 = json_decode($this->twofautility->vml(trim($V5XO2)), true);
        if (!(!is_array($wZDA2) || !isset($wZDA2["\163\x74\x61\164\x75\163"]) || empty($wZDA2["\x73\164\x61\164\x75\x73"]))) {
            goto IjeGt;
        }
        $this->messageManager->addErrorMessage(TwoFAMessages::ENTERED_INVALID_KEY);
        return;
        IjeGt:
        if (strcasecmp($wZDA2["\x73\164\x61\164\x75\163"], "\x53\125\103\103\x45\123\123") == 0) {
            goto V94d0;
        }
        if (strcasecmp($wZDA2["\163\164\141\x74\165\163"], "\x46\101\111\x4c\x45\x44") == 0) {
            goto QVy01;
        }
        $this->messageManager->addErrorMessage(TwoFAMessages::ERROR_OCCURRED);
        goto vscCr;
        V94d0:
        $this->twofautility->reinitConfig();
        $B1J86 = TwoFAConstants::DEFAULT_TOKEN_VALUE;
        $this->twofautility->setStoreConfig(TwoFAConstants::SAMLSP_LK, AESEncryption::encrypt_data($V5XO2, $B1J86));
        $this->twofautility->setStoreConfig(TwoFAConstants::SAMLSP_CKL, AESEncryption::encrypt_data("\164\162\165\x65", $B1J86));
        $this->twofautility->setStoreConfig(TwoFAConstants::PLAN_VERIFIED, 1);
        $this->messageManager->addSuccessMessage(TwoFAMessages::LICENSE_VERIFIED);
        goto vscCr;
        QVy01:
        if (strcasecmp($wZDA2["\155\x65\163\x73\x61\x67\x65"], "\x43\x6f\x64\x65\x20\x68\x61\x73\x20\x45\x78\x70\151\162\145\x64") == 0) {
            goto IFpM4;
        }
        $this->messageManager->addErrorMessage(TwoFAMessages::ENTERED_INVALID_KEY);
        goto RnT4M;
        IFpM4:
        $this->messageManager->addErrorMessage(TwoFAMessages::LICENSE_KEY_IN_USE);
        RnT4M:
        vscCr:
    }
    public function _vlk_fail()
    {
        $B1J86 = TwoFAConstants::DEFAULT_TOKEN_VALUE;
        $this->twofautility->setStoreConfig(TwoFAConstants::SAMLSP_CKL, AESEncryption::encrypt_data("\146\141\x6c\163\145", $B1J86));
        $this->messageManager->addErrorMessage(TwoFAMessages::NOT_UPGRADED_YET);
    }
    public function extendTrial()
    {
        $this->twofautility->extendTrial();
    }
    public function skipAndStartTrial()
    {
        $this->twofautility->setStoreConfig(TwoFAConstants::TRIAL_ACTIVATED, true);
    }
    public function activatePremiumPlan()
    {
        $this->twofautility->setStoreConfig(TwoFAConstants::TRIAL_ACTIVATED, false);
    }
}