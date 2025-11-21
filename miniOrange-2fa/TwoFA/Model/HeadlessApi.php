<?php

namespace MiniOrange\TwoFA\Model;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use MiniOrange\TwoFA\Helper\Curl;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\CustomSMS;
use MiniOrange\TwoFA\Helper\Exception\OtpSentFailureException;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
class HeadlessApi implements \MiniOrange\TwoFA\Api\HeadlessApiInterface
{
    protected $storeManager;
    protected $customEmail;
    protected $customSMS;
    private $accountManagement;
    private $twofautility;
    private $resourceConnection;
    private $customerSession;
    public function __construct(AccountManagementInterface $wo6IE, Session $OC_0y, \MiniOrange\TwoFA\Helper\TwoFAUtility $CpXJ0, ResourceConnection $YOhGT, \Magento\Store\Model\StoreManagerInterface $V1ZQA, CustomEmail $giZSS, CustomSMS $NJgoJ)
    {
        $this->accountManagement = $wo6IE;
        $this->customerSession = $OC_0y;
        $this->twofautility = $CpXJ0;
        $this->resourceConnection = $YOhGT;
        $this->storeManager = $V1ZQA;
        $this->customEmail = $giZSS;
        $this->customSMS = $NJgoJ;
    }
    public function authenticateApi(string $Jbo_K, string $kZdPd, string $FIoYw) : array
    {
        if (filter_var($Jbo_K, FILTER_VALIDATE_EMAIL)) {
            goto kH2T2;
        }
        return ["\163\x74\x61\x74\x75\x73" => "\105\122\122\117\122", "\155\145\163\x73\141\x67\145" => "\x49\156\166\x61\x6c\x69\144\x20\165\x73\x65\162\x6e\x61\x6d\x65\x2e\40\120\x6c\x65\x61\163\x65\x20\x70\x72\x6f\166\x69\x64\x65\x20\141\x20\166\x61\x6c\151\x64\x20\145\155\x61\151\x6c\40\x61\x64\144\x72\145\163\163\x2e"];
        kH2T2:
        try {
            $btn21 = $this->accountManagement->authenticate($Jbo_K, $kZdPd);
            $Q0tTV = $this->twofautility->getWebsiteOrStoreBasedOnTrialStatus();
            $kVBmm = $this->twofautility->getStoreConfig(TwoFAConstants::INVOKE_INLINE_REGISTERATION . $Q0tTV);
            if ($kVBmm) {
                goto Mz8t0;
            }
            $this->twofautility->log_debug("\105\170\x65\x63\165\x74\x65\x20\150\145\x61\144\141\x70\x69\72\x20\111\156\166\x6f\x6b\x65\40\x49\x6e\154\x69\x6e\x65\x20\x6f\146\x66");
            return ["\155\x65\x73\163\141\147\x65" => "\120\154\145\141\163\145\40\145\156\x61\x62\154\145\x20\x79\157\x75\x72\40\146\x72\x6f\x6e\164\x65\x6e\x64\40\x74\x77\x6f\x66\x61"];
            goto mFkbJ;
            Mz8t0:
            $Sp2NH = "\x4f\x4f\105";
            $WOcn3 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
            if ($Sp2NH == "\117\x4f\105" && $WOcn3) {
                goto BN1eg;
            }
            $DOXRb = $this->twofautility->getCustomerKeys(false);
            $eWrm2 = $DOXRb["\143\x75\x73\x74\x6f\155\145\162\x5f\x6b\x65\x79"];
            $Zbw2u = $DOXRb["\141\x70\x69\x4b\x65\x79"];
            $DfvQ9 = ["\117\117\x45" => "\105\115\x41\111\114", "\x4f\117\x53" => "\x53\x4d\123", "\117\117\123\105" => "\123\x4d\123\x20\101\x4e\104\40\105\115\x41\111\114", "\x4b\x42\101" => "\113\x42\x41"];
            $G517q = ["\x63\165\163\x74\157\155\145\162\113\145\x79" => $eWrm2, "\165\x73\145\162\156\x61\155\145" => '', "\x70\x68\157\x6e\145" => '', "\145\x6d\x61\151\154" => $Jbo_K, "\141\x75\164\x68\124\x79\160\145" => $DfvQ9[$Sp2NH], "\164\162\x61\x6e\x73\x61\x63\164\x69\157\156\116\141\x6d\145" => $this->twofautility->getTransactionName()];
            $mtzXE = $this->twofautility->getApiUrls();
            $M1G72 = $mtzXE["\x63\150\x61\154\x6c\x61\x6e\147\145"];
            $XpKM7 = Curl::challenge($eWrm2, $Zbw2u, $M1G72, $G517q);
            $XpKM7 = json_decode($XpKM7);
            $SJNnY = ["\163\164\141\x74\165\163" => $XpKM7->status, "\155\x65\x73\163\x61\x67\145" => $XpKM7->message, "\x74\170\111\x64" => $XpKM7->txId];
            return ['' => $SJNnY];
            goto z50hX;
            BN1eg:
            $UZ2ob = $this->twofautility->Customgateway_GenerateOTP();
            $H7g7W = $Jbo_K;
            $SY0r8 = $this->customEmail->sendCustomgatewayEmail($H7g7W, $UZ2ob);
            return ['' => $SY0r8];
            z50hX:
            mFkbJ:
        } catch (LocalizedException $ERQdy) {
            return ["\x73\x74\x61\x74\165\163" => "\x45\122\x52\117\122", "\x6d\145\x73\x73\141\x67\x65" => "\101\165\x74\x68\x65\156\x74\x69\143\141\164\151\157\x6e\40\146\141\x69\x6c\145\x64\56\40" . $ERQdy->getMessage()];
        }
    }
    public function loginApi(string $Jbo_K, string $FIoYw, string $Sp2NH, string $CwfZC, string $RFLqv) : array
    {
        return $this->validateOtp($Jbo_K, $FIoYw, $Sp2NH, $CwfZC, $RFLqv);
    }
    public function validateOtp(string $Jbo_K, string $FIoYw, string $Sp2NH, string $CwfZC, string $RFLqv) : array
    {
        $WOcn3 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
        $ZThKr = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
        $Tk871 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
        $bEbGc = false;
        if ($Sp2NH == "\x4f\x4f\x45" && $WOcn3) {
            goto LweCv;
        }
        if ($Sp2NH == "\x4f\x4f\x53" && $ZThKr) {
            goto kwRnN;
        }
        if ($Sp2NH == "\x4f\x4f\x53\x45") {
            goto FPnkT;
        }
        if ($Sp2NH == "\117\x4f\127" && $Tk871) {
            goto UNFS_;
        }
        goto Bz346;
        LweCv:
        $bEbGc = true;
        goto Bz346;
        kwRnN:
        $bEbGc = true;
        goto Bz346;
        FPnkT:
        $bEbGc = true;
        goto Bz346;
        UNFS_:
        $bEbGc = true;
        Bz346:
        if (($WOcn3 || $ZThKr) && $bEbGc) {
            goto TsOu4;
        }
        if ("\x4f\117\127" === $Sp2NH) {
            goto Luz3t;
        }
        $R71k7 = $this->twofautility->validateOtpRequest($Jbo_K, $FIoYw, $Sp2NH, $CwfZC, $RFLqv);
        return ["\163\165\143\x63\145\163\x73" => $R71k7["\163\x74\x61\164\x75\163"], "\x72\145\x73\160\x6f\156\163\x65" => $R71k7];
        goto vkb5o;
        Luz3t:
        if ($Sp2NH == "\117\x4f\127") {
            goto DiqCx;
        }
        $this->twofautility->log_debug("\110\145\141\144\154\x65\163\163\x2e\x70\x68\x70\x20\72\x20\145\170\x65\x63\165\x74\145\x3a\x20\103\x75\163\x74\157\155\40\x67\x61\x74\x65\167\x61\171");
        goto dEIj8;
        DiqCx:
        $this->twofautility->log_debug("\x48\x65\141\x64\154\x65\163\x73\56\x70\x68\160\x20\x3a\x20\x65\170\145\x63\165\164\x65\x3a\40\x6d\151\x6e\x69\117\x72\x61\x6e\147\x65\x20\167\x68\x61\x74\163\141\160\160\x20\147\x61\x74\145\167\141\171");
        dEIj8:
        $SY0r8 = $this->twofautility->customgateway_validateOTP($RFLqv);
        $R71k7 = array("\x73\164\x61\x74\165\163" => $SY0r8);
        return ["\x73\165\143\143\145\163\163" => $R71k7["\x73\164\x61\164\165\x73"], "\162\145\x73\x70\157\156\x73\145" => $R71k7];
        vkb5o:
        goto MNG7H;
        TsOu4:
        $this->twofautility->log_debug("\110\x65\141\144\x6c\x65\163\163\x2e\160\150\160\40\72\40\145\x78\145\x63\165\x74\145\x3a\x20\103\165\x73\x74\x6f\x6d\x20\x67\x61\164\x65\167\x61\171");
        $SY0r8 = $this->twofautility->customgateway_validateOTP($RFLqv);
        $R71k7 = array("\163\164\141\x74\165\x73" => $SY0r8);
        return ["\163\x75\143\143\x65\163\163" => $R71k7["\x73\164\x61\x74\165\163"], "\x72\145\x73\x70\x6f\x6e\163\x65" => $R71k7];
        MNG7H:
    }
    public function sendOtp(string $Jbo_K, string $QJ9dq, string $Sp2NH, string $FIoYw) : array
    {
        $Q0tTV = $this->twofautility->getWebsiteOrStoreBasedOnTrialStatus();
        $kVBmm = $this->twofautility->getStoreConfig(TwoFAConstants::INVOKE_INLINE_REGISTERATION . $Q0tTV);
        if ($kVBmm) {
            goto Oci7W;
        }
        $this->twofautility->log_debug("\x45\170\145\143\165\164\x65\x20\x68\x65\x61\144\x61\x70\x69\x3a\40\x49\156\x76\157\153\145\x20\111\x6e\x6c\x69\x6e\x65\40\157\146\146");
        return ["\x6d\145\163\163\141\x67\145" => "\120\154\x65\141\163\145\x20\x65\x6e\x61\142\154\145\x20\x79\157\165\x72\x20\146\x72\157\156\x74\x65\x6e\x64\40\164\x77\157\x66\141"];
        goto W0TL0;
        Oci7W:
        if (filter_var($Jbo_K, FILTER_VALIDATE_EMAIL)) {
            goto IDtkP;
        }
        return ["\163\164\x61\x74\x75\163" => "\x45\122\122\x4f\x52", "\155\145\x73\x73\141\x67\145" => "\111\x6e\x76\x61\154\x69\x64\40\165\x73\x65\162\x6e\141\155\145\x2e\40\120\154\x65\141\163\145\x20\x70\162\x6f\x76\x69\144\x65\40\x61\x20\x76\x61\x6c\x69\144\40\x65\155\x61\151\x6c\x20\x61\144\x64\162\x65\x73\163\56"];
        IDtkP:
        $JV07k = "\x2f\x5e\x5c\x2b\134\x64\x7b\x31\x2c\64\175\134\144\x7b\x31\x2c\61\64\x7d\44\57";
        if (!(($Sp2NH == "\x4f\x4f\123" || $Sp2NH == "\x4f\x4f\123\x45") && !preg_match($JV07k, $QJ9dq))) {
            goto XKg7X;
        }
        $r2Vs6 = "\111\x6e\x76\x61\x6c\151\144\x20\x70\x68\157\x6e\145\40\156\x75\x6d\142\145\x72\x2e\40\x50\154\145\x61\163\x65\x20\x70\162\x6f\166\x69\144\x65\40\141\40\166\x61\x6c\151\x64\x20\x70\150\157\156\145\x20\156\x75\x6d\x62\x65\x72\40\x77\x69\164\x68\40\143\157\x75\156\x74\x72\x79\40\x63\157\x64\145\x2e";
        $r2Vs6 = $this->twofautility->translateOtpMessage($r2Vs6);
        return ["\163\x74\141\x74\x75\163" => "\105\122\x52\x4f\122", "\x6d\x65\163\x73\141\147\x65" => $r2Vs6];
        XKg7X:
        $WOcn3 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
        $ZThKr = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
        $Tk871 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
        if ($WOcn3 || $ZThKr) {
            goto Dodeg;
        }
        if ($Sp2NH == "\x4f\117\x57") {
            goto QKy83;
        }
        $Sp2NH = trim($Sp2NH);
        $DOXRb = $this->twofautility->getCustomerKeys(false);
        $eWrm2 = $DOXRb["\143\165\163\x74\x6f\155\x65\x72\x5f\153\145\171"];
        $Zbw2u = $DOXRb["\x61\160\x69\113\145\171"];
        $DfvQ9 = ["\x4f\117\105" => "\105\x4d\x41\x49\114", "\117\x4f\123" => "\x53\x4d\123", "\117\117\123\x45" => "\x53\x4d\x53\40\101\116\104\40\105\x4d\101\x49\114", "\x4b\102\x41" => "\113\102\101"];
        if (!($Sp2NH == "\x4f\x4f\x53")) {
            goto vfrHF;
        }
        $IHvg0 = $QJ9dq;
        $UcRcc = '';
        $this->twofautility->log_debug("\x48\x65\x61\144\x6c\145\163\163\101\x70\151\x2e\x70\x68\x70\40\72\40\x61\165\164\150\40\x74\x79\160\145\x20\123\115\123");
        vfrHF:
        if (!($Sp2NH == "\x4f\x4f\x45")) {
            goto GPjqP;
        }
        $IHvg0 = '';
        $UcRcc = $Jbo_K;
        $this->twofautility->log_debug("\x48\145\x61\x64\x6c\x65\x73\163\x41\x70\x69\56\x70\150\x70\x20\x3a\40\x61\x75\164\150\40\x74\x79\x70\x65\x20\105\155\141\x69\x6c");
        GPjqP:
        if (!($Sp2NH == "\117\x4f\x53\x45")) {
            goto Hj9mb;
        }
        $IHvg0 = $QJ9dq;
        $UcRcc = $Jbo_K;
        $this->twofautility->log_debug("\x48\x65\141\x64\x6c\145\x73\163\x41\x70\151\x2e\x70\150\160\40\x3a\141\x75\164\150\40\x74\171\x70\x65\40\123\115\123\x20\101\x4e\x44\40\105\x4d\101\x49\x4c");
        Hj9mb:
        $G517q = ["\x63\165\x73\x74\x6f\x6d\145\162\113\x65\171" => $eWrm2, "\x75\x73\x65\x72\x6e\141\155\x65" => '', "\160\150\157\156\145" => $QJ9dq, "\145\x6d\141\x69\154" => $Jbo_K, "\141\165\x74\x68\124\x79\160\x65" => $DfvQ9[$Sp2NH], "\164\162\141\x6e\163\x61\x63\164\x69\x6f\156\x4e\141\155\145" => $this->twofautility->getTransactionName()];
        $mtzXE = $this->twofautility->getApiUrls();
        $M1G72 = $mtzXE["\143\x68\141\154\154\141\156\x67\x65"];
        $XpKM7 = Curl::challenge($eWrm2, $Zbw2u, $M1G72, $G517q);
        $XpKM7 = json_decode($XpKM7);
        $SJNnY = ["\163\164\x61\x74\165\163" => $XpKM7->status, "\x6d\x65\x73\163\x61\147\x65" => $XpKM7->message, "\164\x78\x49\144" => $XpKM7->txId];
        return ['' => $SJNnY];
        goto DZG_X;
        QKy83:
        if ($Sp2NH == "\x4f\x4f\x57" && $Tk871) {
            goto R1Lml;
        }
        if ($Sp2NH == "\x4f\117\x57") {
            goto yplKT;
        }
        goto MOj16;
        R1Lml:
        $wiIOz = $this->twofautility->Customgateway_GenerateOTP();
        $QJ9dq = $QJ9dq;
        $SY0r8 = $this->twofautility->send_customgateway_whatsapp($QJ9dq, $wiIOz);
        return ['' => $SY0r8];
        goto MOj16;
        yplKT:
        $wiIOz = $this->twofautility->Customgateway_GenerateOTP();
        $QJ9dq = $QJ9dq;
        $SY0r8 = $this->twofautility->send_whatsapp($QJ9dq, $wiIOz);
        return ['' => $SY0r8];
        MOj16:
        DZG_X:
        goto P4BA5;
        Dodeg:
        if ($Sp2NH == "\117\117\x45" && $WOcn3) {
            goto RQJEz;
        }
        if ($Sp2NH == "\117\117\x53" && $ZThKr) {
            goto bE2K3;
        }
        if (!(($ZThKr || $WOcn3) && $Sp2NH == "\117\x4f\x53\105")) {
            goto qHF3W;
        }
        $UZ2ob = $this->twofautility->Customgateway_GenerateOTP();
        $H7g7W = $Jbo_K;
        $QJ9dq = $QJ9dq;
        if ($WOcn3) {
            goto QSe7N;
        }
        $B4Ekm["\163\x74\141\164\x75\163"] = "\106\101\x49\114\x45\104";
        goto j3guY;
        QSe7N:
        $B4Ekm = $this->customEmail->sendCustomgatewayEmail($H7g7W, $UZ2ob);
        j3guY:
        if ($ZThKr) {
            goto hTgpZ;
        }
        $kgo61["\x73\164\141\x74\165\163"] = "\106\x41\x49\x4c\105\x44";
        goto NYwZX;
        hTgpZ:
        $kgo61 = $this->customSMS->send_customgateway_sms($QJ9dq, $UZ2ob);
        NYwZX:
        $r2Vs6 = $this->twofautility->OTP_over_SMSandEMAIL_Message($H7g7W, $QJ9dq, $B4Ekm["\x73\164\x61\164\x75\163"], $kgo61["\163\x74\141\x74\165\x73"]);
        if ($B4Ekm["\163\x74\x61\164\x75\163"] == "\x53\x55\x43\x43\105\123\123" || $kgo61["\x73\x74\x61\164\165\x73"] == "\x53\125\103\x43\105\x53\x53") {
            goto Bg55W;
        }
        $SY0r8 = array("\x73\x74\x61\x74\165\x73" => "\x46\101\x49\114\105\104", "\x6d\145\x73\x73\x61\147\145" => $r2Vs6, "\x74\170\x49\144" => "\x31");
        goto zhZXQ;
        Bg55W:
        $SY0r8 = array("\163\x74\141\164\165\x73" => "\x53\x55\103\x43\105\123\123", "\155\145\163\x73\x61\147\145" => $r2Vs6, "\x74\170\111\x64" => "\x31");
        zhZXQ:
        return ['' => $SY0r8];
        qHF3W:
        goto t03Sw;
        bE2K3:
        $wiIOz = $this->twofautility->Customgateway_GenerateOTP();
        $QJ9dq = $QJ9dq;
        $SY0r8 = $this->customSMS->send_customgateway_sms($QJ9dq, $wiIOz);
        return ['' => $SY0r8];
        t03Sw:
        goto M2sjH;
        RQJEz:
        $UZ2ob = $this->twofautility->Customgateway_GenerateOTP();
        $H7g7W = $Jbo_K;
        $SY0r8 = $this->customEmail->sendCustomgatewayEmail($H7g7W, $UZ2ob);
        return ['' => $SY0r8];
        M2sjH:
        P4BA5:
        W0TL0:
    }
    public function sendOtpApi(string $Jbo_K, string $QJ9dq, string $Sp2NH) : array
    {
        if (filter_var($Jbo_K, FILTER_VALIDATE_EMAIL)) {
            goto lRnwR;
        }
        $this->twofautility->log_debug("\x48\145\x61\144\x6c\x65\x73\163\101\160\151\x2e\160\150\x70\x20\72\x69\x6e\x76\141\x6c\151\x64\40\145\155\141\151\154");
        return ["\163\x74\x61\x74\x75\163" => "\105\x52\122\x4f\x52", "\x6d\x65\x73\163\x61\x67\145" => "\111\x6e\x76\141\154\151\144\x20\x75\163\x65\162\156\141\155\145\x2e\40\120\x6c\145\x61\x73\145\x20\x70\x72\x6f\x76\x69\144\x65\x20\x61\x20\x76\141\x6c\x69\144\x20\x65\155\x61\x69\x6c\40\141\144\144\162\145\x73\x73\x2e"];
        lRnwR:
        $V1HHz = $this->twofautility->getSessionValue("\154\141\x73\164\x5f\157\164\x70\x5f\163\x65\x6e\164\x5f\164\151\x6d\x65");
        $FqfJ6 = time();
        if (!($V1HHz != null && $FqfJ6 - $V1HHz < 60)) {
            goto lHSXo;
        }
        $DwExU = 60 - ($FqfJ6 - $V1HHz);
        $this->twofautility->log_debug("\x43\165\163\x74\x6f\x6d\x45\x4d\101\x49\x4c\72\x20\125\x73\x65\162\x20\x6e\145\145\x64\163\40\x74\x6f\x20\x77\x61\151\164\x2e\40\122\x65\155\141\151\156\x69\156\147\x20\x74\x69\x6d\145\72\x20{$DwExU}\40\x73\145\x63\x6f\x6e\144\163");
        $SY0r8 = ["\163\x74\141\164\165\163" => "\x45\x52\x52\x4f\122", "\x6d\x65\x73\x73\141\x67\x65" => "\x4f\x54\x50\40\x65\x6e\x76\157\171\xc3\xa9\40\151\154\x20\171\x20\x61\40\x71\165\145\154\x71\165\x65\163\x20\163\145\143\157\x6e\144\x65\163\x2e\40\126\x65\165\151\154\154\x65\172\x20\162\303\xa9\x65\x73\x73\141\x79\x65\162\40\141\160\162\xc3\250\163\x20{$DwExU}\x20\x73\x65\143\157\x6e\144\x65\163\x20", "\x6d\145\164\150\x6f\144" => $Sp2NH];
        return ['' => $SY0r8];
        lHSXo:
        $this->twofautility->log_debug("\150\x65\x61\x64\154\x65\163\x73\x2e\x20\141\x75\164\x68\x74\x79\x70\x65\x20\151\x73\40{$Sp2NH}");
        $this->twofautility->log_debug("\150\145\141\x64\x6c\145\163\x73\x2e\x20\x65\x6d\x61\151\154\40\x69\x73\x20\40\151\x73\40{$Jbo_K}");
        $this->twofautility->log_debug("\x68\x65\x61\x64\154\145\x73\x73\x2e\x20\x70\150\157\156\x65\x20\x69\x73\40\x20\x69\163\40{$QJ9dq}");
        $SxDln = $this->twofautility->getCustomerMoTfaUserDetails("\x6d\x69\x6e\151\x6f\162\141\156\147\x65\137\164\146\x61\137\165\x73\x65\x72\163", $Jbo_K);
        if (!(is_array($SxDln) && count($SxDln) > 0)) {
            goto ojzP9;
        }
        $this->twofautility->log_debug("\x48\145\x61\x64\154\x65\x73\163\101\160\x69\56\160\150\160\72\40\165\163\x65\x72\x20\151\163\40\x61\x6c\x72\x65\141\144\x79\40\x63\157\x6e\x66\151\x67\165\x72\x65\144\40\62\x66\141\x20");
        if (($Sp2NH == "\x4f\117\123" || $Sp2NH == "\x4f\x4f\123\105") && (empty($QJ9dq) || $QJ9dq == "\x2b" || $QJ9dq == "\53\156\165\154\154" || $QJ9dq == null)) {
            goto nmknr;
        }
        if (!($Sp2NH == '')) {
            goto FQgtR;
        }
        $gRopV = $SxDln[0]["\x61\143\164\151\x76\x65\137\x6d\x65\x74\150\x6f\x64"];
        if (!empty($gRopV)) {
            goto XmD4Y;
        }
        $ly6WT = $SxDln[0]["\x69\144"];
        $this->twofautility->deleteRowInTable("\155\151\156\151\x6f\x72\x61\156\x67\145\x5f\164\x66\x61\137\165\163\145\162\x73", "\151\x64", $ly6WT);
        XmD4Y:
        if (!($QJ9dq == '')) {
            goto L0Hjp;
        }
        $QJ9dq = $SxDln[0]["\x70\x68\157\x6e\145"];
        $bQnF0 = $SxDln[0]["\x63\x6f\x75\156\164\162\x79\x63\157\x64\145"];
        $QJ9dq = "\x2b" . $bQnF0 . $QJ9dq;
        if (!empty($QJ9dq)) {
            goto b8DOs;
        }
        $this->twofautility->deleteRowInTable("\155\151\x6e\151\157\x72\141\x6e\x67\145\x5f\x74\146\x61\137\165\163\145\x72\x73", "\x69\x64", $ly6WT);
        b8DOs:
        L0Hjp:
        $Sp2NH = $gRopV;
        FQgtR:
        goto N8sOQ;
        nmknr:
        $SxDln = $this->twofautility->getCustomerMoTfaUserDetails("\155\x69\156\x69\157\x72\141\156\x67\145\x5f\164\x66\141\x5f\165\163\x65\x72\163", $Jbo_K);
        if (is_array($SxDln) && count($SxDln) > 0) {
            goto HKMLR;
        }
        if (!$QJ9dq) {
            goto LKd4t;
        }
        $QJ9dq = $this->twofautility->getSessionValue(TwoFAConstants::CUSTOMER_PHONE);
        $bQnF0 = $this->twofautility->getSessionValue(TwoFAConstants::CUSTOMER_COUNTRY_CODE);
        $QJ9dq = "\53" . $bQnF0 . $QJ9dq;
        LKd4t:
        goto AaDs9;
        HKMLR:
        $QJ9dq = "\x2b" . $SxDln[0]["\143\x6f\x75\156\x74\162\x79\143\157\x64\x65"] . $SxDln[0]["\x70\150\157\156\x65"];
        $this->twofautility->log_debug("\x48\x65\141\144\154\145\x73\163\x41\160\x69\56\160\150\160\72\x20\x46\145\164\143\150\x69\x6e\147\x20\160\x68\x6f\x6e\x65\40\156\165\155\x62\x65\162\40\157\x66\40\141\154\162\145\x61\x64\171\x20\143\157\x6e\146\151\147\x75\162\145\144\x20\165\163\x65\x72\x73\40\146\162\x6f\x6d\40\x74\x68\x65\x20\x64\141\x74\x61\x62\x61\x73\145\x2e");
        AaDs9:
        N8sOQ:
        ojzP9:
        $this->twofautility->log_debug("\150\x65\x61\x64\x6c\145\x73\x73\x2e\40\141\165\x74\x68\x74\171\160\145\x20\151\163\x20\72\40{$Sp2NH}");
        $this->twofautility->log_debug("\x68\x65\x61\144\154\145\x73\163\x2e\x20\145\x6d\x61\151\x6c\x20\151\163\40\72\40{$Jbo_K}");
        $this->twofautility->log_debug("\x68\x65\141\x64\154\x65\163\163\x2e\x20\x70\x68\x6f\156\x65\x20\x69\163\40\72\x20{$QJ9dq}");
        $JV07k = "\x2f\x5e\x5c\53\x5c\144\173\x31\54\x34\x7d\134\144\x7b\x31\x2c\61\64\x7d\x24\57";
        if (!($Sp2NH == "\117\x4f\x53" || $Sp2NH == "\x4f\x4f\x53\105")) {
            goto WtueN;
        }
        if (!preg_match($JV07k, $QJ9dq)) {
            goto bzIcG;
        }
        $zglrZ = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_ENABLE_BLOCK_SPAM_PHONE_NUMBER);
        if (!$zglrZ) {
            goto uLHlv;
        }
        $fZwgI = $this->twofautility->checkBlacklistedPhone($QJ9dq, $SxDln[0]["\x63\157\165\x6e\164\x72\x79\143\157\144\x65"]);
        if (!$fZwgI) {
            goto WjzV8;
        }
        $this->twofautility->log_debug("\110\x65\x61\x64\x6c\x65\163\163\x41\x70\x69\56\x70\150\x70\40\x3a\x20\x70\x68\157\156\x65\40\x6e\165\x6d\x62\145\162\x20\x69\163\x20\x62\x6c\141\143\x6b\154\x69\163\x74\x65\x64");
        $r2Vs6 = "\x54\x68\145\x20\160\x68\157\x6e\x65\40\x6e\165\x6d\142\x65\162\40\171\x6f\x75\40\150\x61\166\x65\x20\145\x6e\164\x65\x72\145\x64\40\x68\x61\163\40\x62\145\x65\156\40\x66\x6c\141\147\147\x65\144\40\141\x6e\x64\40\x69\x73\40\143\165\162\x72\145\156\x74\x6c\x79\40\x62\x6c\x61\x63\153\154\x69\163\x74\145\144\x2e\x20\x50\x6c\145\141\163\145\40\x75\163\x65\x20\x61\x20\x64\x69\146\146\x65\x72\x65\156\x74\x20\156\165\x6d\x62\x65\x72\40\x74\x6f\x20\160\162\x6f\143\x65\145\144\56";
        $r2Vs6 = $this->twofautility->translateOtpMessage($r2Vs6);
        $this->twofautility->log_debug("\x48\145\x61\144\x6c\x65\x73\163\101\160\151\x2e\x70\x68\x70\x20\x3a\x20\155\145\163\163\141\x67\x65\x3a\x20" . $r2Vs6);
        $SY0r8 = ["\163\x74\141\164\x75\x73" => "\105\122\x52\117\x52", "\155\145\163\x73\141\147\145" => $r2Vs6, "\x6d\x65\164\150\157\144" => $Sp2NH];
        return ['' => $SY0r8];
        WjzV8:
        uLHlv:
        goto XCBPD;
        bzIcG:
        $this->twofautility->log_debug("\110\x65\x61\144\x6c\x65\x73\163\101\160\151\56\x70\x68\160\x20\72\151\x6e\166\x61\x6c\151\144\40\160\x68\157\x6e\x65\x20\x6e\x75\155\142\x65\x72");
        $r2Vs6 = "\111\156\x76\141\154\x69\x64\x20\160\150\157\156\x65\x20\156\x75\x6d\x62\x65\162\x2e\x20\x50\x6c\145\141\x73\145\40\160\x72\x6f\166\x69\x64\x65\40\141\40\x76\x61\x6c\151\144\x20\160\x68\x6f\156\145\x20\x6e\x75\155\x62\x65\162\40\167\151\x74\150\40\x63\157\x75\156\x74\x72\x79\x20\x63\x6f\144\x65\x2e";
        $r2Vs6 = $this->twofautility->translateOtpMessage($r2Vs6);
        $SY0r8 = ["\x73\x74\141\164\x75\163" => "\105\x52\x52\x4f\x52", "\155\145\x73\x73\x61\x67\x65" => $r2Vs6, "\155\145\164\x68\157\144" => $Sp2NH];
        return ['' => $SY0r8];
        XCBPD:
        WtueN:
        $this->twofautility->log_debug("\x68\x65\x61\x64\x6c\x65\163\x73\x2e\40\163\145\x6e\x64\151\x6e\x67\40\x6f\x74\160\x20\61");
        $WOcn3 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
        $ZThKr = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
        $Tk871 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
        if ($WOcn3 || $ZThKr) {
            goto Igt8O;
        }
        if ($Sp2NH == "\x4f\x4f\x57") {
            goto qCDX4;
        }
        $this->twofautility->log_debug("\x68\145\141\x64\154\145\x73\163\56\40\163\x65\156\x64\x69\156\x67\40\157\164\160\x20\166\x69\x61\x20\x6d\x69\156\151\117\x72\141\x6e\147\145\40\147\141\x74\x65\167\141\x79");
        $Sp2NH = trim($Sp2NH);
        $this->twofautility->log_debug("\110\145\x61\x64\x6c\145\x73\x73\101\x70\x69\56\160\150\x70\x20\72\x6d\x69\156\x69\117\x72\141\x6e\147\x65\x20\147\x61\164\145\x77\x61\171\x20\141\165\164\x68\124\171\160\145\x2d" . $Sp2NH);
        $SJNnY = $this->twofautility->send_otp_using_miniOrange_gateway_usingApicall($Sp2NH, $Jbo_K, $QJ9dq);
        if (is_array($SJNnY) && isset($SJNnY["\x73\164\x61\164\165\163"]) && $SJNnY["\163\164\141\164\x75\x73"] == "\x53\x55\103\103\105\x53\123") {
            goto BZk8J;
        }
        if (is_array($SJNnY) && isset($SJNnY["\x73\x74\x61\164\165\163"]) && $SJNnY["\163\164\141\164\165\163"] == "\106\x41\111\x4c\105\x44") {
            goto vziVI;
        }
        throw new OtpSentFailureException();
        goto wu0Pp;
        BZk8J:
        $this->twofautility->log_debug("\x48\x65\141\144\154\145\163\163\101\x70\x69\56\x70\x68\x70\40\72\40\145\170\145\x63\165\x74\x65\72\x20\x3a\162\x65\x73\x70\x6f\156\x73\145\x20\163\165\143\x63\x65\x73\x73\x3a\x20" . json_encode($SJNnY));
        $this->twofautility->setSessionValue("\x6c\x61\x73\x74\137\x6f\164\x70\137\163\x65\156\164\137\x74\x69\155\145", $FqfJ6);
        $this->twofautility->setSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID, $SJNnY["\164\x78\111\x64"]);
        $SJNnY["\x6d\145\163\x73\x61\x67\145"] = $this->twofautility->translateOtpMessage($SJNnY["\x6d\145\163\163\141\x67\145"]);
        goto wu0Pp;
        vziVI:
        $this->twofautility->log_debug("\150\145\141\x64\x6c\x65\x73\x73\56\160\150\160\x20\x3a\x20\x65\170\x65\x63\x75\164\x65\72\40\162\x65\x73\160\157\x6e\x73\x65\x20\146\x61\x69\x6c\x65\144");
        $SJNnY["\155\145\x74\150\x6f\x64"] = $Sp2NH;
        wu0Pp:
        return ['' => $SJNnY];
        goto uWH5V;
        Igt8O:
        $this->twofautility->log_debug("\110\145\141\144\154\x65\163\163\101\160\151\56\160\x68\x70\40\72\x63\x75\x73\164\x6f\x6d\x20\x67\x61\164\145\x77\x61\171\x20\145\156\141\142\x6c\145\x64");
        if ($Sp2NH == "\117\x4f\x45" && $WOcn3) {
            goto dadi5;
        }
        if (!($Sp2NH == "\117\x4f\105")) {
            goto qoJfe;
        }
        $SJNnY = $this->twofautility->send_otp_using_miniOrange_gateway_usingApicall($Sp2NH, $Jbo_K, $QJ9dq);
        if (is_array($SJNnY) && isset($SJNnY["\x73\x74\141\164\x75\163"]) && $SJNnY["\163\x74\141\x74\x75\x73"] == "\x53\125\103\x43\x45\123\x53") {
            goto hXbLM;
        }
        if (is_array($SJNnY) && isset($SJNnY["\x73\164\141\x74\165\163"]) && $SJNnY["\163\164\x61\164\x75\163"] == "\106\101\x49\x4c\105\x44") {
            goto Datpk;
        }
        throw new OtpSentFailureException();
        goto JFEk7;
        hXbLM:
        $this->twofautility->log_debug("\110\145\x61\x64\x6c\x65\x73\163\x41\x70\x69\56\160\150\160\x20\72\x20\145\170\145\143\x75\164\145\x3a\40\72\162\145\x73\160\x6f\x6e\x73\145\x20\163\x75\x63\143\145\163\x73");
        $this->twofautility->setSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID, $SJNnY["\164\x78\111\x64"]);
        $this->twofautility->setSessionValue("\x6c\x61\x73\164\x5f\157\x74\160\137\x73\145\x6e\164\x5f\x74\x69\x6d\145", $FqfJ6);
        goto JFEk7;
        Datpk:
        $this->twofautility->log_debug("\150\145\x61\x64\154\145\163\x73\56\160\x68\x70\40\72\x20\145\x78\145\x63\x75\164\x65\x3a\40\x72\x65\163\160\x6f\156\x73\145\40\146\141\x69\154\145\x64");
        JFEk7:
        return ['' => $SJNnY];
        qoJfe:
        goto S8VrF;
        dadi5:
        $H7g7W = $Jbo_K;
        $UZ2ob = $this->twofautility->Customgateway_GenerateOTP();
        $SY0r8 = $this->customEmail->sendCustomgatewayEmail($H7g7W, $UZ2ob);
        S8VrF:
        if ($Sp2NH == "\117\x4f\x53" && $ZThKr) {
            goto L0izk;
        }
        if (!($Sp2NH == "\x4f\117\x53")) {
            goto TMzkq;
        }
        $SJNnY = $this->twofautility->send_otp_using_miniOrange_gateway_usingApicall($Sp2NH, $Jbo_K, $QJ9dq);
        if (is_array($SJNnY) && isset($SJNnY["\163\164\141\164\165\x73"]) && $SJNnY["\163\164\x61\x74\x75\163"] == "\x53\x55\x43\x43\105\123\123") {
            goto Cudhv;
        }
        if (is_array($SJNnY) && isset($SJNnY["\163\164\141\x74\165\x73"]) && $SJNnY["\x73\x74\x61\x74\165\163"] == "\x46\x41\111\x4c\x45\x44") {
            goto X7Hhw;
        }
        throw new OtpSentFailureException();
        goto Htcui;
        Cudhv:
        $this->twofautility->log_debug("\110\145\141\144\154\x65\x73\163\101\160\x69\x2e\160\x68\x70\x20\72\x20\145\170\145\143\165\x74\145\x3a\x20\x3a\x72\x65\163\x70\x6f\x6e\163\x65\40\x73\x75\143\x63\145\163\163");
        $this->twofautility->setSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID, $SJNnY["\164\170\111\144"]);
        $this->twofautility->setSessionValue("\154\141\163\164\x5f\x6f\164\x70\x5f\x73\x65\x6e\164\x5f\x74\151\x6d\145", $FqfJ6);
        goto Htcui;
        X7Hhw:
        $this->twofautility->log_debug("\150\x65\141\x64\154\145\x73\163\56\160\x68\x70\x20\x3a\x20\145\170\145\x63\165\x74\x65\72\x20\x72\145\163\x70\x6f\x6e\163\x65\40\x66\x61\x69\x6c\145\x64");
        Htcui:
        return ['' => $SJNnY];
        TMzkq:
        goto iTcRE;
        L0izk:
        $this->twofautility->log_debug("\x48\145\x61\144\x6c\x65\163\x73\x41\160\151\x2e\x70\x68\160\40\72\143\165\x73\164\x6f\155\40\x67\x61\x74\x65\x77\141\171\x20\x61\x75\164\150\124\171\x70\x65\40\117\x4f\123");
        $wiIOz = $this->twofautility->Customgateway_GenerateOTP();
        $SY0r8 = $this->customSMS->send_customgateway_sms($QJ9dq, $wiIOz);
        iTcRE:
        if (($ZThKr || $WOcn3) && $Sp2NH == "\x4f\x4f\123\x45") {
            goto A8IRL;
        }
        if (!($Sp2NH == "\x4f\117\123\105")) {
            goto KK524;
        }
        $SJNnY = $this->twofautility->send_otp_using_miniOrange_gateway_usingApicall($Sp2NH, $Jbo_K, $QJ9dq);
        if (is_array($SJNnY) && isset($SJNnY["\163\164\x61\164\x75\163"]) && $SJNnY["\163\164\141\x74\x75\x73"] == "\123\x55\103\103\x45\123\x53") {
            goto NxMXy;
        }
        if (is_array($SJNnY) && isset($SJNnY["\x73\164\x61\x74\165\163"]) && $SJNnY["\x73\x74\141\x74\165\x73"] == "\106\x41\111\114\x45\104") {
            goto SXBnN;
        }
        throw new OtpSentFailureException();
        goto wemP_;
        NxMXy:
        $this->twofautility->log_debug("\110\x65\x61\x64\154\145\163\163\101\x70\151\x2e\x70\150\160\x20\x3a\40\x65\170\x65\x63\x75\x74\x65\x3a\x20\x3a\x72\x65\x73\160\157\156\x73\145\40\x73\165\143\x63\x65\163\x73");
        $this->twofautility->setSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID, $SJNnY["\x74\x78\x49\x64"]);
        $this->twofautility->setSessionValue("\x6c\141\x73\164\x5f\x6f\x74\160\137\163\x65\x6e\164\137\164\x69\155\145", $FqfJ6);
        $this->twofautility->setSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID, $SJNnY["\x74\170\111\x64"]);
        goto wemP_;
        SXBnN:
        $this->twofautility->log_debug("\150\145\141\144\154\x65\163\163\56\x70\x68\160\40\72\40\145\x78\x65\x63\165\x74\x65\72\40\162\145\x73\x70\x6f\156\x73\x65\40\146\x61\151\154\x65\x64");
        wemP_:
        return ['' => $SJNnY];
        KK524:
        goto wxRP9;
        A8IRL:
        $UZ2ob = $this->twofautility->Customgateway_GenerateOTP();
        $H7g7W = $Jbo_K;
        if ($WOcn3) {
            goto Lwek1;
        }
        $B4Ekm["\x73\x74\x61\x74\165\163"] = "\106\x41\x49\x4c\105\x44";
        goto imrRX;
        Lwek1:
        $B4Ekm = $this->customEmail->sendCustomgatewayEmail($H7g7W, $UZ2ob);
        imrRX:
        if ($ZThKr) {
            goto bpO_O;
        }
        $kgo61["\163\x74\141\164\x75\x73"] = "\x46\101\x49\x4c\105\x44";
        goto T3Joz;
        bpO_O:
        $kgo61 = $this->customSMS->send_customgateway_sms($QJ9dq, $UZ2ob);
        T3Joz:
        $r2Vs6 = $this->twofautility->OTP_over_SMSandEMAIL_Message($H7g7W, $QJ9dq, $B4Ekm["\163\164\x61\164\x75\x73"], $kgo61["\163\164\x61\x74\165\x73"]);
        if ($B4Ekm["\163\164\x61\164\165\x73"] == "\123\x55\103\103\105\123\123" || $kgo61["\x73\164\x61\164\165\x73"] == "\x53\125\103\x43\105\x53\x53") {
            goto VGZvi;
        }
        $SY0r8 = ["\163\164\141\x74\165\x73" => "\x46\101\x49\x4c\105\x44", "\x6d\x65\163\163\x61\147\145" => $r2Vs6, "\164\170\111\144" => "\61"];
        goto WTj_j;
        VGZvi:
        $SY0r8 = ["\163\164\141\x74\x75\x73" => "\x53\x55\103\103\x45\123\x53", "\155\x65\163\x73\x61\147\x65" => $r2Vs6, "\164\x78\x49\144" => "\61"];
        WTj_j:
        wxRP9:
        if (!(isset($SY0r8) && is_array($SY0r8) && isset($SY0r8["\x73\x74\x61\x74\165\163"]) && $SY0r8["\x73\164\141\x74\x75\x73"] == "\123\125\x43\x43\105\x53\123")) {
            goto KmMYI;
        }
        $this->twofautility->setSessionValue("\x6c\x61\163\x74\137\157\x74\x70\x5f\x73\x65\156\x74\x5f\x74\x69\x6d\x65", $FqfJ6);
        KmMYI:
        return ['' => $SY0r8];
        goto uWH5V;
        qCDX4:
        if ($Sp2NH == "\117\x4f\127" && $Tk871) {
            goto a5JrL;
        }
        if ($Sp2NH == "\117\117\x57") {
            goto Cj0DQ;
        }
        goto SmOi6;
        a5JrL:
        $wiIOz = $this->twofautility->Customgateway_GenerateOTP();
        $SY0r8 = $this->twofautility->send_customgateway_whatsapp($QJ9dq, $wiIOz);
        return ['' => $SY0r8];
        goto SmOi6;
        Cj0DQ:
        $wiIOz = $this->twofautility->Customgateway_GenerateOTP();
        $SY0r8 = $this->twofautility->send_whatsapp($QJ9dq, $wiIOz);
        return ['' => $SY0r8];
        SmOi6:
        uWH5V:
    }
    public function validateOtpApi(string $Jbo_K, string $Sp2NH, string $RFLqv) : array
    {
        $WOcn3 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
        $ZThKr = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
        $Tk871 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
        $this->twofautility->log_debug("\150\145\141\144\154\145\x73\x73\56\160\x68\x70\x20\x3a\40\145\170\145\143\x75\x74\x65\x3a\166\141\x6c\151\x64\141\x74\x65\40\x6f\x74\160");
        $bEbGc = false;
        if ($Sp2NH == "\117\117\x45" && $WOcn3) {
            goto CW0ot;
        }
        if ($Sp2NH == "\x4f\117\123" && $ZThKr) {
            goto XUgvF;
        }
        if ($Sp2NH == "\117\x4f\x53\105") {
            goto xLL0B;
        }
        if ($Sp2NH == "\x4f\117\x57" && $Tk871) {
            goto RuIPg;
        }
        goto KeeUQ;
        CW0ot:
        $bEbGc = true;
        goto KeeUQ;
        XUgvF:
        $bEbGc = true;
        goto KeeUQ;
        xLL0B:
        $bEbGc = true;
        goto KeeUQ;
        RuIPg:
        $bEbGc = true;
        KeeUQ:
        if (($WOcn3 || $ZThKr) && $bEbGc) {
            goto RIT2c;
        }
        if ("\x4f\117\x57" === $Sp2NH) {
            goto M3kuh;
        }
        $this->twofautility->log_debug("\x48\x65\141\144\154\x69\145\163\x73\x41\160\x69\x2e\x70\x68\x70\40\x3a\40\x65\x78\145\143\x75\164\x65\72\x20\155\x69\156\x69\x4f\x72\141\156\x67\x65\x20\147\141\x74\145\x77\x61\x79");
        $Q0tTV = $this->twofautility->getWebsiteOrStoreBasedOnTrialStatus();
        $CwfZC = $this->twofautility->getSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID);
        if ($CwfZC) {
            goto biofH;
        }
        $this->twofautility->log_debug("\x45\x78\x65\143\165\164\x65\x20\150\145\x61\x64\141\x70\x69\72\40\x65\155\x70\x74\171\x20\164\x72\x61\156\163\163\141\143\x74\151\x6f\156\40\151\144");
        return ["\x6d\x65\163\x73\x61\x67\x65" => "\145\155\x70\164\171\x20\x74\x72\141\156\x73\x61\143\164\x69\157\156\40\x69\x64\54\40\x65\156\141\142\x6c\x65\40\171\157\x75\162\40\x68\145\x61\x64\x6c\x65\x73\163\x20\x74\x77\x6f\x66\141\40"];
        biofH:
        $R71k7 = $this->twofautility->validateOtpRequest($Jbo_K, $Sp2NH, $CwfZC, $RFLqv);
        $sWQ0q = $R71k7[0]["\x73\164\x61\164\x75\163"];
        $r2Vs6 = $R71k7[0]["\155\x65\163\163\141\x67\x65"];
        $QjWtq = ["\x73\x74\141\164\x75\x73" => $sWQ0q];
        if (!($QjWtq["\163\x74\141\164\x75\163"] == "\123\125\103\x43\105\x53\x53")) {
            goto u8RK6;
        }
        $this->twofautility->log_debug("\110\x65\x61\144\154\151\x65\163\x73\x41\x70\151\56\160\150\160\40\72\x20\145\170\x65\143\165\164\x65\72\40\x76\x61\x6c\x69\x64\x61\x74\x65\40\x73\x75\143\x63\x65\x73\x73\146\165\x6c");
        $CwfZC = $this->twofautility->getSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID);
        $this->twofautility->setSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID, null);
        u8RK6:
        return [$R71k7];
        goto wJ8MK;
        RIT2c:
        $this->twofautility->log_debug("\110\x65\x61\144\x6c\145\x73\x73\x2e\x70\150\x70\x20\x3a\x20\x65\x78\x65\143\x75\164\145\72\x20\103\x75\163\164\157\155\x20\147\141\x74\x65\x77\x61\171");
        $SY0r8 = $this->twofautility->customgateway_validateOTP($RFLqv);
        $R71k7 = ["\163\164\x61\164\x75\x73" => $SY0r8];
        return ["\163\x75\x63\143\x65\163\x73" => $R71k7["\x73\164\x61\x74\x75\x73"], "\162\145\163\x70\x6f\x6e\163\x65" => $R71k7];
        goto wJ8MK;
        M3kuh:
        $this->twofautility->log_debug("\110\x65\141\x64\154\x65\163\x73\56\x70\x68\160\x20\72\x20\145\170\x65\143\x75\164\x65\x3a\40\x6d\151\x6e\x69\x4f\162\x61\156\147\145\40\167\x68\141\x74\163\141\160\160\40\x67\x61\164\145\167\141\x79");
        $SY0r8 = $this->twofautility->customgateway_validateOTP($RFLqv);
        $R71k7 = ["\163\164\141\164\x75\163" => $SY0r8];
        return ["\163\165\143\x63\145\x73\x73" => $R71k7["\163\x74\x61\x74\x75\x73"], "\x72\x65\x73\x70\157\156\x73\145" => $R71k7];
        wJ8MK:
    }
    public function validateSMSOtpApi(string $gJyyG, string $J8G57, string $kHjKy, string $QJ9dq, string $bQnF0, string $jTeRZ) : array
    {
        $this->twofautility->log_debug("\x48\x65\141\x64\154\x65\163\163\x41\160\151\56\x70\150\x70\40\x3a\x20\166\141\154\x69\x64\141\x74\x65\123\x4d\123\x4f\x74\x70\101\x70\x69\x20\143\141\x6c\x6c\x65\144");
        $this->twofautility->log_debug("\x48\x65\141\x64\154\145\163\x73\101\160\151\56\x70\x68\160\x20\72\40\x65\x6d\141\151\x6c\72\x20{$gJyyG}\54\x20\x61\143\x74\x69\x6f\x6e\137\x6d\x65\x74\x68\157\144\72\40{$J8G57}\x2c\40\160\150\157\x6e\145\72\x20{$QJ9dq}\x2c\x20\143\x6f\x75\156\164\162\x79\143\x6f\x64\145\72\40{$bQnF0}");
        $bN9oz = '';
        if ($bQnF0 && $QJ9dq) {
            goto wAdHk;
        }
        if ($QJ9dq) {
            goto rbS1N;
        }
        if ($bQnF0) {
            goto R4LQm;
        }
        goto QuKFD;
        wAdHk:
        $bQnF0 = ltrim($bQnF0, "\x2b");
        $bN9oz = "\53" . $bQnF0 . $QJ9dq;
        goto QuKFD;
        rbS1N:
        $bN9oz = $QJ9dq;
        goto QuKFD;
        R4LQm:
        $bQnF0 = ltrim($bQnF0, "\x2b");
        $bN9oz = "\53" . $bQnF0;
        QuKFD:
        if (!($bN9oz && ($J8G57 == "\x4f\117\123" || $J8G57 == "\117\x4f\x53\105"))) {
            goto OIGCy;
        }
        $JV07k = "\57\136\134\53\134\144\x7b\x31\x2c\64\x7d\134\144\x7b\x31\x2c\61\64\175\x24\57";
        if (preg_match($JV07k, $bN9oz)) {
            goto hldlE;
        }
        $this->twofautility->log_debug("\110\x65\x61\144\x6c\x65\163\x73\101\160\151\x2e\x70\150\160\x20\72\x20\x69\x6e\x76\141\x6c\151\144\40\x70\x68\157\156\x65\40\x6e\165\x6d\142\x65\162\40\x66\157\162\155\x61\164");
        $r2Vs6 = "\111\x6e\x76\x61\x6c\x69\x64\40\160\150\157\x6e\145\40\x6e\x75\155\x62\145\x72\56\40\120\x6c\145\141\x73\x65\40\160\x72\x6f\166\x69\x64\145\x20\141\x20\x76\x61\154\151\144\40\x70\150\157\156\x65\40\156\165\155\x62\145\x72\40\x77\x69\164\150\40\143\x6f\165\156\x74\x72\171\40\143\157\144\x65\56";
        $r2Vs6 = $this->twofautility->translateOtpMessage($r2Vs6);
        return ["\x73\164\141\x74\x75\x73" => "\x45\x52\x52\117\122", "\x6d\145\x73\163\141\x67\x65" => $r2Vs6];
        hldlE:
        OIGCy:
        $Sp2NH = $J8G57;
        $WOcn3 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
        $ZThKr = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
        $Tk871 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
        $this->twofautility->log_debug("\110\145\141\144\x6c\x65\x73\163\101\x70\151\x2e\160\150\x70\40\x3a\40\145\x78\x65\143\165\x74\145\x3a\x76\x61\x6c\x69\144\141\164\x65\x20\x73\x6d\x73\x20\157\164\160");
        $bEbGc = false;
        if ($Sp2NH == "\117\117\105" && $WOcn3) {
            goto C3Fs5;
        }
        if ($Sp2NH == "\117\117\x53" && $ZThKr) {
            goto H7Z3l;
        }
        if ($Sp2NH == "\117\117\123\105") {
            goto ack9_;
        }
        if ($Sp2NH == "\117\x4f\127" && $Tk871) {
            goto fx6Te;
        }
        goto gPK6q;
        C3Fs5:
        $bEbGc = true;
        goto gPK6q;
        H7Z3l:
        $bEbGc = true;
        goto gPK6q;
        ack9_:
        $bEbGc = true;
        goto gPK6q;
        fx6Te:
        $bEbGc = true;
        gPK6q:
        if (($WOcn3 || $ZThKr) && $bEbGc) {
            goto rtBi4;
        }
        $this->twofautility->log_debug("\110\145\141\x64\x6c\145\163\163\101\x70\151\56\160\x68\160\40\72\x20\145\170\145\x63\165\164\145\x3a\x20\x6d\151\x6e\151\117\162\141\156\147\145\x20\147\141\164\145\x77\141\171");
        $Q0tTV = $this->twofautility->getWebsiteOrStoreBasedOnTrialStatus();
        $CwfZC = $this->twofautility->getSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID);
        if ($CwfZC) {
            goto j5P9e;
        }
        $this->twofautility->log_debug("\x48\145\x61\144\154\145\x73\x73\101\160\x69\x2e\160\x68\x70\40\72\x20\x65\155\x70\x74\x79\40\164\x72\141\156\163\x61\x63\164\151\x6f\156\40\x69\x64");
        return ["\x73\x74\141\x74\x75\x73" => "\x45\122\x52\117\122", "\x6d\x65\163\x73\x61\147\145" => "\105\x6d\x70\x74\171\40\164\x72\141\156\163\141\143\x74\151\157\156\40\151\x64\x2c\x20\160\154\145\141\x73\145\x20\x65\x6e\141\x62\154\x65\40\x79\157\165\x72\40\x68\x65\141\x64\x6c\145\x73\163\x20\164\167\x6f\146\x61\x20\141\x6e\144\x20\x73\x65\156\144\40\117\x54\120\x20\x66\x69\x72\163\164\56"];
        j5P9e:
        $R71k7 = $this->twofautility->validateOtpRequest($gJyyG, $this->twofautility->getCustomerKeys(false)["\141\160\151\x4b\x65\171"], $Sp2NH, $CwfZC, $jTeRZ);
        $sWQ0q = $R71k7[0]["\163\x74\141\x74\x75\163"];
        $r2Vs6 = $R71k7[0]["\x6d\145\163\163\141\x67\x65"];
        $QjWtq = ["\163\x74\x61\x74\165\163" => $sWQ0q];
        $this->twofautility->log_debug("\110\x65\x61\x64\154\145\163\163\101\160\x69\56\x70\150\x70\x20\72\40\x65\x78\145\x63\165\x74\x65\72\40\x76\x61\154\151\x64\x61\164\145\40\163\x6d\x73\40\157\x74\x70\x20\x72\145\x73\x70\x6f\156\163\x65\72\x20" . json_encode($R71k7));
        if ($QjWtq["\163\x74\x61\x74\165\163"] == "\x53\125\x43\x43\105\123\123") {
            goto p6pH2;
        }
        if (!($QjWtq["\x73\164\141\x74\x75\x73"] == "\x46\101\x49\x4c\105\104")) {
            goto o12UI;
        }
        $R71k7[0]["\155\145\x73\163\x61\x67\145"] = $this->twofautility->translateOtpMessage($R71k7[0]["\155\145\163\x73\x61\147\x65"]);
        o12UI:
        goto TYRLB;
        p6pH2:
        $this->twofautility->log_debug("\110\145\x61\144\x6c\145\x73\163\x41\x70\x69\56\160\150\x70\40\x3a\40\145\x78\145\143\165\x74\x65\72\40\166\x61\154\x69\x64\141\x74\x65\40\x73\x75\x63\143\x65\163\x73\146\165\154");
        $R71k7[0]["\x6d\145\163\x73\x61\147\x65"] = $this->twofautility->translateOtpMessage($R71k7[0]["\155\145\163\163\141\147\x65"]);
        $this->twofautility->updateColumnInTable("\x6d\151\x6e\x69\x6f\162\x61\x6e\x67\x65\x5f\164\x66\141\x5f\x75\x73\x65\162\x73", "\x70\x68\x6f\x6e\x65", $QJ9dq, "\x75\x73\145\162\156\x61\x6d\145", $gJyyG, $Q0tTV);
        $this->twofautility->updateColumnInTable("\x6d\151\x6e\151\157\x72\141\x6e\147\x65\x5f\164\146\x61\x5f\165\163\145\x72\163", "\x63\157\165\x6e\x74\x72\x79\143\x6f\x64\x65", $bQnF0, "\x75\x73\145\x72\x6e\141\155\145", $gJyyG, $Q0tTV);
        $this->twofautility->flushCache();
        $CwfZC = $this->twofautility->getSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID);
        $this->twofautility->setSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID, NULL);
        TYRLB:
        return $R71k7;
        goto cccCL;
        rtBi4:
        $this->twofautility->log_debug("\110\145\x61\144\x6c\145\163\163\101\160\x69\56\160\150\160\x20\72\x20\145\170\x65\143\165\164\145\x3a\x20\103\165\163\x74\157\155\40\x67\141\164\145\167\141\x79");
        $SY0r8 = $this->twofautility->customgateway_validateOTP($jTeRZ);
        $R71k7 = ["\x73\x74\141\x74\165\163" => $SY0r8];
        return ["\x73\x75\x63\143\145\163\163" => $R71k7["\x73\x74\141\164\x75\163"], "\162\145\163\x70\157\156\x73\145" => $R71k7];
        cccCL:
    }
}