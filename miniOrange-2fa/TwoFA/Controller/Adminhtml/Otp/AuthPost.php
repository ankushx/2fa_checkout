<?php

namespace MiniOrange\TwoFA\Controller\Adminhtml\Otp;

use Exception;
use Google\Authenticator\GoogleAuthenticator;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\Session\SessionManager;
use Magento\Framework\UrlInterface;
use Magento\Security\Model\AdminSessionsManager;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\CustomSMS;
use MiniOrange\TwoFA\Helper\MiniOrangeUser;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use Psr\Cache\InvalidArgumentException;
class AuthPost extends Action
{
    protected $_googleAuthenticator;
    protected $_storageSession;
    protected $_url;
    protected $_sessionsManager;
    protected $_remoteAddress;
    protected $_trustedFactory;
    protected $twofautility;
    protected $_response;
    protected $customEmail;
    protected $customSMS;
    protected $context;
    public function __construct(Context $eMkHJ, SessionManager $sqShI, AdminSessionsManager $p3ua9, RemoteAddress $cK7JO, UrlInterface $Enhkv, ResponseInterface $YfnRH, twofautility $PyYkx, CustomEmail $h2cVE, CustomSMS $H4Sze)
    {
        $this->context = $eMkHJ;
        $this->_storageSession = $sqShI;
        $this->_sessionsManager = $p3ua9;
        $this->_remoteAddress = $cK7JO;
        $this->twofautility = $PyYkx;
        $this->_url = $Enhkv;
        $this->_response = $YfnRH;
        $this->customEmail = $h2cVE;
        $this->customSMS = $H4Sze;
        parent::__construct($eMkHJ);
    }
    public function execute()
    {
        $HPmfv = $this->_request->getParams();
        if (!($user = $this->_storageSession->getData("\x75\x73\x65\x72"))) {
            goto ZI2Od;
        }
        try {
            if (!isset($HPmfv["\x73\x6b\151\160\x74\x77\157\x66\x61"])) {
                goto BlmuZ;
            }
            $this->twofautility->getSkipTwoFa_Admin();
            $this->_auth->getAuthStorage()->setUser($user);
            $this->_auth->getAuthStorage()->processLogin();
            $this->_sessionsManager->processLogin();
            if (!$this->_sessionsManager->getCurrentSession()->isOtherSessionsTerminated()) {
                goto iFZrp;
            }
            $this->messageManager->addWarning(__("\101\154\x6c\40\157\x74\x68\x65\162\40\157\x70\x65\x6e\x20\x73\145\x73\163\151\x6f\x6e\163\40\x66\157\162\40\x74\x68\x69\x73\40\x61\x63\x63\157\x75\x6e\164\40\167\145\162\145\40\x74\x65\162\155\151\x6e\x61\x74\x65\x64\x2e"));
            iFZrp:
            return $this->_getRedirect($this->_backendUrl->getStartupPageUrl());
            BlmuZ:
            $this->twofautility->log_debug("\x41\x75\164\x68\120\x6f\x73\x74\x20\x3a\x20\145\x78\x65\x63\165\164\x65");
            $petbM = $user->getUsername();
            $rrj0h = $user->getEmail();
            $lwuFa = new MiniOrangeUser();
            if (!isset($HPmfv["\x63\150\x6f\157\x73\x65\137\155\x65\x74\150\x6f\x64"])) {
                goto eEMUm;
            }
            $this->twofautility->log_debug("\x41\165\x74\x68\120\157\x73\164\40\72\x20\x61\144\155\151\156\40\151\156\x6c\151\x6e\x65\x20\x65\x6d\141\x69\154\40\x6d\145\x74\x68\157\144");
            if ($HPmfv["\163\x74\x65\160\163"] != "\x4f\x4f\105") {
                goto Xt2rU;
            }
            $pxQt3 = $this->twofautility->getSessionValue("\x61\144\x6d\151\x6e\x5f\151\156\154\x69\156\x65\x5f\145\155\141\x69\x6c\x5f\x64\x65\x74\x61\x69\154");
            if ($pxQt3 == NULL || $pxQt3 == '') {
                goto JhKcH;
            }
            $this->twofautility->log_debug("\101\x75\x74\150\120\x6f\x73\x74\40\72\x20\141\x64\155\x69\156\x20\151\156\x6c\x69\x6e\145\x20\x65\155\141\151\154\x20\x66\x6f\165\156\144");
            $HPmfv["\x61\x75\x74\150\x74\x79\160\145"] = "\117\x4f\105";
            $HPmfv["\x65\155\141\151\154"] = $pxQt3;
            goto zJVxr;
            JhKcH:
            $Enhkv = $this->_url->getUrl("\x6d\x6f\x74\167\x6f\146\141\57\157\164\160\x2f\x61\165\x74\150\151\x6e\144\x65\170") . "\77\x26\x73\164\145\x70\x73\75\117\x4f\105\46\156\x6f\137\x61\x64\x6d\x69\x6e\137\x65\x6d\x61\x69\x6c\x3d\61";
            return $this->_response->setRedirect($Enhkv);
            zJVxr:
            goto rJJyu;
            Xt2rU:
            $Enhkv = $this->_url->getUrl("\155\x6f\x74\167\157\146\x61\x2f\157\164\160\57\x61\165\164\150\151\x6e\144\x65\x78") . "\x3f\x26\x53\141\x76\x65\x3d\x53\x61\x76\x65\46\163\x74\145\x70\163\75" . $HPmfv["\163\164\145\160\163"];
            return $this->_response->setRedirect($Enhkv);
            rJJyu:
            eEMUm:
            if (!isset($HPmfv["\x61\165\164\150\x74\171\x70\x65"])) {
                goto JGkrE;
            }
            if (!("\107\157\x6f\147\x6c\145\x41\x75\x74\150\x65\x6e\x74\151\143\141\164\x6f\x72" != $HPmfv["\141\165\164\150\164\x79\160\145"] && "\115\x69\x63\162\157\163\x6f\x66\164\x41\x75\164\x68\145\x6e\x74\151\x63\x61\164\157\x72" != $HPmfv["\141\165\x74\150\x74\171\160\x65"])) {
                goto bPjpg;
            }
            if (isset($HPmfv["\160\150\157\156\x65"])) {
                goto wuVmd;
            }
            $azQYt = NULL;
            goto LWsE0;
            wuVmd:
            $azQYt = $HPmfv["\x70\150\x6f\156\x65"];
            LWsE0:
            if (isset($HPmfv["\x63\x6f\165\156\x74\162\x79\143\157\144\145"])) {
                goto mY4pg;
            }
            $Ywmr6 = NULL;
            goto pVbMc;
            mY4pg:
            $Ywmr6 = $HPmfv["\143\157\x75\x6e\164\x72\171\143\157\144\x65"];
            pVbMc:
            if (isset($HPmfv["\x65\155\x61\151\x6c"])) {
                goto gaGI8;
            }
            $yzFXV = NULL;
            goto wPtf7;
            gaGI8:
            $yzFXV = $HPmfv["\x65\155\x61\151\154"];
            wPtf7:
            if (isset($HPmfv["\163\x65\143\162\145\164"])) {
                goto XVYqO;
            }
            $GqqMh = $this->twofautility->generateRandomString();
            goto F2ndc;
            XVYqO:
            $GqqMh = $HPmfv["\163\145\143\162\x65\164"];
            F2ndc:
            $this->twofautility->log_debug("\x41\165\x74\150\120\157\x73\x74\40\72\40\163\145\x74\x20\141\x64\155\151\x6e\40\x69\x6e\154\x69\x6e\x65\40\x64\x61\x74\141\40\x69\156\40\163\x65\164\163\145\163\163\x69\157\x6e\166\x61\154\165\x65");
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN__EMAIL, $yzFXV);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN__PHONE, $azQYt);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_COUNTRY_CODE, $Ywmr6);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_IS_INLINE, 1);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_USERNAME, $petbM);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_SECRET, $GqqMh);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_ACTIVE_METHOD, $HPmfv["\x61\165\164\150\164\x79\x70\x65"]);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_CONFIG_METHOD, $HPmfv["\141\165\x74\150\x74\x79\160\x65"]);
            $BR3hv = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
            $jVncH = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
            $kT4eJ = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
            if ($BR3hv || $jVncH) {
                goto WD0yx;
            }
            if ($HPmfv["\141\x75\164\x68\164\171\160\x65"] == "\x4f\117\x57") {
                goto VB_HW;
            }
            $YfnRH = json_decode($lwuFa->challenge_admin($rrj0h, $this->twofautility, $HPmfv["\x61\165\164\150\x74\171\x70\145"], true, -1));
            $v281x = array("\x73\x74\141\x74\165\163" => $YfnRH->status, "\x6d\x65\163\x73\141\x67\145" => $YfnRH->message, "\164\x78\111\144" => $YfnRH->txId ?? '');
            goto mjgHA;
            VB_HW:
            if ($HPmfv["\141\165\164\150\164\171\160\145"] == "\117\x4f\127" && $kT4eJ) {
                goto KJ9Yr;
            }
            if ($HPmfv["\x61\x75\x74\x68\164\171\160\145"] == "\x4f\117\127") {
                goto ZmtpO;
            }
            goto lmIRR;
            KJ9Yr:
            $UdFOI = $this->twofautility->Customgateway_GenerateOTP();
            $azQYt = "\x2b" . $Ywmr6 . $azQYt;
            $v281x = $this->twofautility->send_customgateway_whatsapp($azQYt, $UdFOI);
            goto lmIRR;
            ZmtpO:
            $UdFOI = $this->twofautility->Customgateway_GenerateOTP();
            $azQYt = "\53" . $Ywmr6 . $azQYt;
            $v281x = $this->twofautility->send_whatsapp($azQYt, $UdFOI);
            lmIRR:
            mjgHA:
            goto jpKq_;
            WD0yx:
            $this->twofautility->log_debug("\101\165\164\x68\x70\x6f\163\164\56\x70\150\160\40\72\x20\x65\x78\145\x63\165\x74\x65\72\40\103\165\163\x74\x6f\155\40\x67\141\164\x65\x77\x61\x79");
            if ($HPmfv["\x61\x75\x74\150\164\x79\x70\145"] == "\x4f\117\x45" && $BR3hv) {
                goto BGCKY;
            }
            if ($HPmfv["\x61\165\164\150\x74\x79\x70\x65"] == "\117\x4f\x45") {
                goto DwRky;
            }
            goto SwMyM;
            BGCKY:
            $SBW32 = $this->twofautility->Customgateway_GenerateOTP();
            $f7uA1 = $yzFXV;
            $v281x = $this->customEmail->sendCustomgatewayEmail($f7uA1, $SBW32);
            $athjW = $v281x;
            goto SwMyM;
            DwRky:
            $YfnRH = json_decode($lwuFa->challenge_admin($rrj0h, $this->twofautility, $HPmfv["\141\x75\164\x68\164\171\x70\145"], true, -1));
            $v281x = array("\163\x74\141\x74\x75\163" => $YfnRH->status, "\x6d\145\163\x73\141\x67\x65" => $YfnRH->message, "\x74\170\111\144" => $YfnRH->txId ?? '');
            SwMyM:
            if ($HPmfv["\141\x75\x74\x68\164\x79\x70\x65"] == "\117\x4f\123" && $jVncH) {
                goto p7X54;
            }
            if ($HPmfv["\141\165\x74\150\x74\x79\x70\x65"] == "\117\x4f\123") {
                goto JH_Ac;
            }
            goto usstb;
            p7X54:
            $UdFOI = $this->twofautility->Customgateway_GenerateOTP();
            $azQYt = "\53" . $Ywmr6 . $azQYt;
            $v281x = $this->customSMS->send_customgateway_sms($azQYt, $UdFOI);
            goto usstb;
            JH_Ac:
            $YfnRH = json_decode($lwuFa->challenge_admin($rrj0h, $this->twofautility, $HPmfv["\x61\165\164\x68\x74\171\x70\x65"], true, -1));
            $v281x = array("\x73\x74\x61\164\165\x73" => $YfnRH->status, "\155\145\x73\163\x61\x67\x65" => $YfnRH->message, "\x74\170\x49\144" => $YfnRH->txId ?? '');
            usstb:
            if (!($HPmfv["\x61\x75\x74\150\x74\x79\x70\145"] == "\x4f\x4f\123\x45")) {
                goto F5aRP;
            }
            $SBW32 = $this->twofautility->Customgateway_GenerateOTP();
            $f7uA1 = $yzFXV;
            $azQYt = "\x2b" . $Ywmr6 . $azQYt;
            if ($BR3hv) {
                goto WxSnS;
            }
            $athjW["\163\x74\x61\164\165\x73"] = "\106\101\111\x4c\x45\x44";
            goto bSZKz;
            WxSnS:
            $athjW = $this->customEmail->sendCustomgatewayEmail($f7uA1, $SBW32);
            bSZKz:
            if ($jVncH) {
                goto BsVNq;
            }
            $UaGh1["\x73\164\141\x74\165\x73"] = "\106\x41\111\x4c\105\x44";
            goto ecb7T;
            BsVNq:
            $UaGh1 = $this->customSMS->send_customgateway_sms($azQYt, $SBW32);
            ecb7T:
            $FsksE = $this->twofautility->OTP_over_SMSandEMAIL_Message($f7uA1, $azQYt, $athjW["\163\164\141\164\165\163"], $UaGh1["\x73\164\141\164\165\163"]);
            if ($athjW["\x73\x74\x61\x74\x75\x73"] == "\x53\125\x43\x43\x45\x53\123" || $UaGh1["\x73\x74\141\x74\x75\x73"] == "\123\x55\x43\103\105\123\x53") {
                goto JZZAK;
            }
            $v281x = array("\x73\164\141\x74\165\x73" => "\x46\x41\x49\x4c\x45\104", "\155\x65\x73\163\141\147\x65" => $FsksE, "\x74\170\111\144" => "\x31");
            goto zePqw;
            JZZAK:
            $v281x = array("\163\x74\x61\164\x75\163" => "\123\x55\103\x43\105\x53\123", "\x6d\145\x73\x73\141\147\x65" => $FsksE, "\164\170\111\x64" => "\x31");
            zePqw:
            F5aRP:
            jpKq_:
            if ($v281x["\x73\x74\x61\x74\x75\x73"] === "\x53\x55\x43\103\105\x53\x53") {
                goto AytAG;
            }
            if ($v281x["\x73\164\x61\x74\x75\x73"] === "\x46\101\x49\x4c\x45\104") {
                goto rdAlm;
            }
            goto zUFw5;
            AytAG:
            $this->twofautility->log_debug("\101\x75\164\x68\x50\x6f\x73\x74\40\72\40\x72\x65\163\x70\157\156\163\x65\x20\x73\164\141\x74\165\x73\40\x73\165\143\143\145\163\163");
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_TRANSACTIONID, $v281x["\x74\170\x49\144"] ?? '');
            $Enhkv = $this->_url->getUrl("\x6d\157\164\167\157\x66\x61\57\x6f\x74\x70\x2f\x61\165\164\150\151\x6e\144\145\170") . "\77\x26\163\164\x65\x70\163\x3d\111\x6e\x76\157\153\x65\101\144\155\151\156\124\x66\141\46\155\x65\164\150\157\144\75" . $HPmfv["\141\x75\164\x68\x74\171\160\145"] . "\46\163\164\x61\164\165\x73\x3d\x53\125\x43\103\x45\x53\x53\x26\x6d\x65\163\163\x61\147\145\x3d" . $v281x["\x6d\x65\x73\163\x61\147\145"];
            return $this->_response->setRedirect($Enhkv);
            goto zUFw5;
            rdAlm:
            $this->twofautility->log_debug("\x41\x75\164\150\120\x6f\163\164\40\72\40\162\x65\x73\160\x6f\156\163\145\x20\163\164\141\x74\165\x73\40\146\x61\154\151\145\x64");
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_TRANSACTIONID, $v281x["\x74\x78\x49\144"] ?? '');
            $Enhkv = $this->_url->getUrl("\x6d\157\164\x77\x6f\146\141\x2f\157\x74\160\x2f\x61\165\164\150\151\156\144\x65\x78") . "\77\46\163\x74\x65\160\163\x3d\111\x6e\166\x6f\153\x65\101\144\155\151\156\124\146\x61\x26\x6d\x65\164\150\157\144\75" . $HPmfv["\141\165\164\x68\x74\x79\160\145"] . "\x26\163\164\x61\x74\x75\x73\x3d\106\101\111\x4c\105\104\x26\155\x65\x73\163\x61\147\x65\75" . $v281x["\155\x65\163\163\x61\x67\x65"];
            return $this->_response->setRedirect($Enhkv);
            zUFw5:
            bPjpg:
            JGkrE:
            if (!isset($HPmfv["\126\x61\x6c\151\x64\x61\x74\145"])) {
                goto Ye4_9;
            }
            $this->twofautility->log_debug("\x41\165\x74\150\x50\x6f\163\164\x20\72\40\x61\x64\x6d\151\x6e\x20\x76\141\x6c\x69\x64\141\164\x65\40\157\x74\160");
            $wShgA = $this->twofautility->getAllMoTfaUserDetails("\155\151\156\x69\x6f\x72\x61\x6e\x67\145\137\x74\x66\141\x5f\165\x73\145\162\x73", $petbM, -1);
            if (is_array($wShgA) && sizeof($wShgA) > 0) {
                goto d1RyH;
            }
            $EEDy8 = $this->twofautility->getSessionValue("\x61\x64\x6d\151\156\x5f\141\143\164\x69\x76\x65\137\x6d\x65\164\x68\157\x64");
            goto fSbl2;
            d1RyH:
            $EEDy8 = $wShgA[0]["\x61\x63\164\x69\166\x65\x5f\155\x65\x74\150\x6f\x64"];
            fSbl2:
            if (isset($HPmfv["\107\x6f\x6f\147\x6c\145\101\x75\164\x68\x65\156\x74\151\x63\x61\164\157\162"])) {
                goto ljOHw;
            }
            if (isset($HPmfv["\115\151\143\x72\157\163\157\146\x74\101\165\164\x68\145\156\x74\x69\x63\141\164\x6f\x72"])) {
                goto eZGcL;
            }
            goto kPN1P;
            ljOHw:
            $EEDy8 = $HPmfv["\107\157\157\x67\154\145\x41\x75\164\x68\x65\x6e\x74\x69\x63\141\x74\157\162"];
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_ACTIVE_METHOD, $EEDy8);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_CONFIG_METHOD, $EEDy8);
            goto kPN1P;
            eZGcL:
            $EEDy8 = $HPmfv["\x4d\x69\143\x72\x6f\x73\157\x66\x74\101\x75\164\150\145\156\164\x69\143\x61\x74\x6f\162"];
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_ACTIVE_METHOD, $EEDy8);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_CONFIG_METHOD, $EEDy8);
            kPN1P:
            if ("\x47\x6f\157\147\x6c\x65\101\x75\164\x68\145\x6e\164\151\143\x61\x74\157\x72" === $EEDy8 || "\x4d\x69\x63\x72\x6f\163\x6f\146\164\x41\x75\164\x68\x65\x6e\x74\x69\143\141\x74\157\x72" === $EEDy8) {
                goto vXGTQ;
            }
            $this->twofautility->log_debug("\x41\165\x74\150\120\x6f\x73\x74\40\72\40\x76\141\154\x69\x64\x61\x74\145\x20\141\x64\x6d\151\x6e\x20\141\x6e\171\x20\157\x66\40\63\40\x6d\145\x74\150\x6f\144");
            $BR3hv = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
            $jVncH = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
            $kT4eJ = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
            $b6p0f = false;
            if ($EEDy8 == "\117\x4f\x45" && $BR3hv) {
                goto zColh;
            }
            if ($EEDy8 == "\117\x4f\x53" && $jVncH) {
                goto gg3o2;
            }
            if ($EEDy8 == "\117\x4f\123\105") {
                goto JVz71;
            }
            if ($EEDy8 == "\x4f\x4f\127" && $kT4eJ) {
                goto rLFhZ;
            }
            goto zxnxp;
            zColh:
            $b6p0f = true;
            goto zxnxp;
            gg3o2:
            $b6p0f = true;
            goto zxnxp;
            JVz71:
            $b6p0f = true;
            goto zxnxp;
            rLFhZ:
            $b6p0f = true;
            zxnxp:
            if (($BR3hv || $jVncH) && $b6p0f) {
                goto B9Tmi;
            }
            if ($EEDy8 == "\x4f\x4f\x57") {
                goto xlQsF;
            }
            $YfnRH = json_decode($lwuFa->validate($petbM, $HPmfv["\x61\165\x74\150\x2d\x63\157\144\x65"], $EEDy8, $this->twofautility, NULL, true, -1), true);
            goto fpCMt;
            xlQsF:
            if ("\117\117\x57" === $EEDy8) {
                goto onZlR;
            }
            $this->twofautility->log_debug("\101\x75\x74\x68\x2e\x70\x68\160\40\x3a\x20\x65\x78\145\143\x75\164\145\72\x20\103\165\x73\164\x6f\x6d\40\x67\141\x74\145\167\x61\171\40");
            goto pXU5j;
            onZlR:
            $this->twofautility->log_debug("\101\x75\164\150\x2e\160\150\x70\40\72\40\145\170\145\x63\x75\164\145\72\x20\x77\x68\x61\x74\163\x61\x70\x70\40\155\151\156\x69\117\162\141\x6e\147\145\40\147\x61\164\x65\167\x61\171\40");
            pXU5j:
            $v281x = $this->twofautility->customgateway_validateOTP($HPmfv["\x61\x75\x74\x68\x2d\x63\157\x64\x65"]);
            $YfnRH = array("\x73\x74\x61\x74\165\x73" => $v281x);
            fpCMt:
            goto OkxVR;
            B9Tmi:
            $this->twofautility->log_debug("\101\x75\x74\150\x2e\160\x68\160\40\72\x20\x65\170\x65\143\165\x74\x65\72\x20\103\x75\163\164\x6f\x6d\x20\x67\x61\x74\x65\167\x61\171\40");
            $v281x = $this->twofautility->customgateway_validateOTP($HPmfv["\x61\x75\164\150\x2d\x63\x6f\144\145"]);
            $YfnRH = array("\x73\164\x61\164\165\163" => $v281x);
            OkxVR:
            goto nFcIB;
            vXGTQ:
            $this->twofautility->log_debug("\101\x75\x74\x68\120\157\163\x74\x20\x3a\x20\x76\141\154\151\144\141\164\145\x20\141\x64\x6d\x69\x6e\40\147\157\157\147\x6c\x65\40\x61\165\164\x68\145\x6e\x74\x69\143\x61\x74\x6f\162");
            $YfnRH = json_decode($this->twofautility->verifyGauthCode($HPmfv["\x61\x75\164\x68\55\143\157\144\145"], $petbM), true);
            nFcIB:
            $this->twofautility->log_debug("\x41\x75\164\x68\120\x6f\163\164\x20\72\x20\145\170\145\x63\x75\164\x65\x20\x3a\x76\141\154\x69\x64\141\164\151\157\x6e\40\x63\x6f\155\x70\x6c\145\164\145");
            if ($YfnRH["\x73\164\x61\x74\x75\163"] === "\123\125\x43\103\x45\123\123") {
                goto m5i7a;
            }
            if ($YfnRH["\x73\164\141\164\x75\163"] === "\x46\x41\x49\x4c\105\104") {
                goto XF29R;
            }
            if ($YfnRH["\163\x74\141\x74\165\163"] == "\x46\x41\114\x53\105") {
                goto AIhUc;
            }
            $this->twofautility->log_debug("\x41\x75\x74\150\120\157\163\x74\x20\x3a\40\x72\x65\163\160\x6f\156\x63\x65\40\x66\141\151\154\x65\144");
            $this->messageManager->addError(__("\111\156\x76\x61\x6c\x69\x64\x20\164\x6f\x6b\145\x6e\56"));
            return $this->_getRedirect("\x6d\x6f\164\167\x6f\x66\141\57\x6f\164\160\57\141\165\164\x68\151\x6e\144\x65\170");
            goto AZEd_;
            XF29R:
            $this->twofautility->log_debug("\x41\x75\164\150\x50\x6f\x73\x74\x20\x3a\x20\162\x65\x73\x70\157\156\143\x65\x20\146\141\151\x6c\x65\144");
            $Enhkv = $this->_url->getUrl("\155\x6f\164\167\x6f\146\141\x2f\x6f\164\x70\57\x61\x75\164\x68\x69\x6e\144\x65\x78") . "\77\46\x73\x74\145\160\163\75\111\x6e\166\x6f\153\x65\101\144\155\151\x6e\x54\x66\x61\x26\146\141\151\154\145\x64\137\155\145\x73\163\x61\147\x65\x3d\120\154\x65\141\x73\x65\x20\105\156\x74\x65\x72\40\x43\x6f\x72\x72\x65\143\164\40\x4f\x54\120\56\46\x73\145\x6c\145\x63\x74\x65\x64\137\x6d\x65\x74\150\x6f\x64\x3d" . $EEDy8;
            return $this->_response->setRedirect($Enhkv);
            goto AZEd_;
            AIhUc:
            $this->twofautility->log_debug("\101\165\164\150\120\x6f\x73\x74\40\x3a\40\162\x65\163\160\x6f\156\143\145\40\146\141\151\154\x65\144");
            $YdqVh = $this->twofautility->getSessionValue("\141\x64\155\x69\156\x5f\x69\163\x69\156\x6c\151\156\145");
            if ($YdqVh == 1) {
                goto i7AM8;
            }
            $Enhkv = $this->_url->getUrl("\155\x6f\164\167\157\x66\141\57\x6f\x74\x70\x2f\x61\x75\164\150\151\x6e\x64\x65\x78") . "\77\x26\x73\x74\145\x70\163\x3d\x49\156\x76\x6f\153\x65\x41\x64\x6d\x69\156\124\x66\x61\46\146\x61\x69\x6c\145\x64\x5f\x6d\x65\163\x73\141\x67\145\x3d\120\x6c\145\x61\x73\145\x20\x45\x6e\x74\x65\x72\x20\x43\x6f\162\x72\145\x63\x74\40\117\124\120\x2e\x26\163\x65\154\145\x63\x74\145\144\x5f\155\x65\x74\150\157\x64\75" . $EEDy8;
            goto lakKA;
            i7AM8:
            $Enhkv = $this->_url->getUrl("\155\x6f\x74\167\157\x66\141\x2f\157\164\160\x2f\x61\x75\164\150\x69\156\x64\x65\170") . "\x3f\46\x73\164\145\x70\163\75" . $EEDy8 . "\x26\146\141\x69\154\145\x64\137\155\x65\163\x73\141\147\x65\75\x50\x6c\x65\x61\163\145\x20\105\156\164\145\x72\40\103\x6f\x72\x72\145\x63\164\x20\117\x54\120\x2e\46\x73\145\154\145\x63\164\145\x64\x5f\155\145\x74\x68\157\144\x3d" . $EEDy8;
            lakKA:
            return $this->_response->setRedirect($Enhkv);
            AZEd_:
            goto dIMbV;
            m5i7a:
            $this->twofautility->log_debug("\x41\165\164\150\x50\157\163\164\40\x3a\x20\x6f\164\x70\40\166\141\154\151\144\141\164\145\x64\x20\x73\x75\143\x63\145\x73\146\x75\x6c\154\x79");
            $yzFXV = $this->twofautility->getSessionValue(TwoFAConstants::ADMIN__EMAIL);
            $azQYt = $this->twofautility->getSessionValue(TwoFAConstants::ADMIN__PHONE);
            $Ywmr6 = $this->twofautility->getSessionValue(TwoFAConstants::ADMIN_COUNTRY_CODE);
            $V19Jj = $this->twofautility->getSessionValue(TwoFAConstants::ADMIN_TRANSACTIONID);
            $PuV2k = $this->twofautility->getSessionValue(TwoFAConstants::ADMIN_ACTIVE_METHOD);
            $xJmy0 = $this->twofautility->getSessionValue(TwoFAConstants::ADMIN_CONFIG_METHOD);
            $GqqMh = $this->twofautility->getSessionValue(TwoFAConstants::ADMIN_SECRET);
            if (!($GqqMh == NULL)) {
                goto vMr2y;
            }
            $GqqMh = $this->twofautility->generateRandomString();
            vMr2y:
            $kpEk7 = [["\x75\163\145\162\156\x61\155\145" => $petbM, "\x61\143\164\x69\x76\x65\137\x6d\145\164\x68\157\144" => $EEDy8, "\x63\x6f\x6e\146\151\x67\x75\162\145\144\x5f\x6d\x65\164\x68\157\x64\x73" => $xJmy0, "\163\x65\x63\162\145\x74" => $GqqMh, "\167\x65\142\163\x69\164\145\x5f\151\x64" => -1]];
            if (!is_array($wShgA) || sizeof($wShgA) <= 0) {
                goto GMQEB;
            }
            if (!(isset($wShgA[0]["\x73\153\151\x70\137\164\167\x6f\146\x61"]) && $wShgA[0]["\x73\153\x69\x70\137\164\167\157\146\141"] > 0)) {
                goto Fz_0m;
            }
            $this->twofautility->updateColumnInTable("\155\x69\156\151\157\162\141\x6e\147\x65\137\x74\146\141\x5f\165\163\145\162\x73", "\163\x6b\x69\x70\x5f\x74\x77\157\x66\x61", NULL, "\x75\163\x65\162\x6e\x61\x6d\x65", $petbM, -1);
            $this->twofautility->updateColumnInTable("\x6d\x69\156\x69\157\x72\x61\156\x67\x65\x5f\x74\x66\141\x5f\x75\x73\x65\x72\x73", "\x73\153\x69\160\137\x74\167\x6f\x66\x61\137\x63\157\156\x66\151\147\x75\162\x65\144\x5f\x64\141\164\145", NULL, "\x75\163\145\x72\156\141\x6d\145", $petbM, -1);
            $this->twofautility->updateColumnInTable("\x6d\151\x6e\151\x6f\x72\x61\x6e\147\x65\x5f\x74\x66\x61\x5f\165\x73\x65\162\163", "\143\x6f\156\x66\x69\x67\x75\162\x65\x64\x5f\x6d\x65\x74\x68\157\x64\x73", $xJmy0, "\x75\163\x65\162\x6e\x61\x6d\145", $petbM, -1);
            $this->twofautility->updateColumnInTable("\155\151\x6e\151\x6f\x72\141\x6e\147\145\x5f\x74\146\x61\137\x75\x73\145\x72\163", "\141\143\x74\x69\166\x65\137\x6d\145\x74\x68\x6f\144", $PuV2k, "\165\x73\x65\x72\156\141\155\x65", $petbM, -1);
            $this->twofautility->updateColumnInTable("\155\x69\156\x69\157\162\x61\x6e\147\x65\137\x74\146\x61\x5f\165\x73\145\x72\163", "\x73\145\143\x72\x65\164", $GqqMh, "\165\x73\x65\x72\156\x61\155\x65", $petbM, -1);
            Fz_0m:
            goto qFwR0;
            GMQEB:
            $this->twofautility->log_debug("\x41\x75\164\150\x50\x6f\x73\164\x20\72\40\x73\141\166\x65\40\141\144\155\151\156\40\144\x61\x74\x61\40\x64\x75\162\x69\156\x67\x20\151\156\154\151\x6e\145");
            $this->twofautility->insertRowInTable("\x6d\x69\156\151\157\x72\141\156\147\x65\x5f\x74\x66\141\137\165\163\x65\x72\163", $kpEk7);
            qFwR0:
            if (!($yzFXV != NULL)) {
                goto TYs66;
            }
            $this->twofautility->updateColumnInTable("\155\x69\x6e\151\x6f\162\141\x6e\147\x65\x5f\164\146\x61\137\x75\163\x65\162\x73", "\145\x6d\141\151\154", $yzFXV, "\165\163\x65\x72\x6e\x61\155\x65", $petbM, -1);
            TYs66:
            if (!($azQYt != NULL)) {
                goto hv_ug;
            }
            $this->twofautility->updateColumnInTable("\x6d\151\x6e\x69\x6f\x72\141\156\147\x65\x5f\164\x66\x61\x5f\165\163\x65\x72\163", "\x70\150\157\156\x65", $azQYt, "\x75\x73\x65\x72\156\141\155\x65", $petbM, -1);
            $this->twofautility->updateColumnInTable("\x6d\151\156\151\157\162\x61\x6e\147\x65\x5f\x74\146\x61\137\165\x73\x65\x72\163", "\143\157\165\156\x74\162\171\x63\x6f\144\145", $Ywmr6, "\165\x73\x65\x72\x6e\x61\155\x65", $petbM, -1);
            hv_ug:
            if (!($V19Jj != NULL)) {
                goto y3bSf;
            }
            $this->twofautility->updateColumnInTable("\155\151\x6e\151\157\x72\x61\156\147\x65\137\164\146\141\137\165\x73\x65\x72\x73", "\x74\x72\x61\x6e\163\141\143\164\151\157\156\111\144", $V19Jj, "\x75\163\145\162\x6e\x61\x6d\x65", $petbM, -1);
            y3bSf:
            if (!(isset($HPmfv["\162\145\155\145\155\142\x65\x72\104\x65\x76\151\143\145"]) && $HPmfv["\162\145\x6d\x65\x6d\x62\x65\x72\104\x65\166\x69\143\x65"] == "\x31")) {
                goto ygYxL;
            }
            $this->twofautility->check_and_save_device_data('', $petbM, -1, $wShgA);
            ygYxL:
            $this->twofautility->log_debug("\x41\x75\164\150\x50\157\163\x74\40\x3a\x20\x43\x6c\145\x61\162\x20\163\145\163\163\x69\157\156\x20\x64\x61\164\x61\40\x73\145\x74\40\151\x6e\x20\141\x64\155\x69\x6e\40\151\156\154\151\x6e\145");
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN__EMAIL, NULL);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN__PHONE, NULL);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_COUNTRY_CODE, NULL);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_IS_INLINE, NULL);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_SECRET, NULL);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_ACTIVE_METHOD, NULL);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_CONFIG_METHOD, NULL);
            $this->twofautility->setSessionValue(TwoFAConstants::ADMIN_TRANSACTIONID, NULL);
            $this->twofautility->setSessionValue("\x61\144\x6d\x69\156\137\x69\163\x69\156\x6c\151\156\145", NULL);
            $this->_auth->getAuthStorage()->setUser($user);
            $this->_auth->getAuthStorage()->processLogin();
            $this->_sessionsManager->processLogin();
            if (!$this->_sessionsManager->getCurrentSession()->isOtherSessionsTerminated()) {
                goto F2jbo;
            }
            $this->messageManager->addWarning(__("\x41\x6c\x6c\40\x6f\x74\x68\x65\162\40\x6f\x70\x65\x6e\x20\163\145\163\163\x69\x6f\156\163\x20\x66\x6f\162\40\x74\150\x69\x73\40\141\x63\143\x6f\165\x6e\164\40\x77\x65\x72\145\40\x74\145\x72\155\x69\x6e\141\164\145\144\x2e"));
            F2jbo:
            return $this->_getRedirect($this->_backendUrl->getStartupPageUrl());
            dIMbV:
            Ye4_9:
        } catch (Exception $E3Xjl) {
            $this->messageManager->addError($E3Xjl->getMessage());
            return $this->_getRedirect("\x6d\157\x74\167\157\146\x61\57\157\x74\x70\x2f\141\165\x74\150\151\x6e\144\145\170");
        }
        ZI2Od:
        return $this->_getRedirect("\x6d\157\164\x77\x6f\146\x61\57\157\x74\160\57\141\x75\x74\x68\x69\156\144\x65\170");
    }
    private function _getRedirect($nK25o)
    {
        $F_yDq = $this->resultRedirectFactory->create();
        $F_yDq->setPath($nK25o);
        return $F_yDq;
    }
    protected function _isAllowed()
    {
        return true;
    }
}