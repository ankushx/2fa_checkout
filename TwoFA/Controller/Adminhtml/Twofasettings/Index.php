<?php

namespace MiniOrange\TwoFA\Controller\Adminhtml\Twofasettings;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use MiniOrange\TwoFA\Controller\Actions\BaseAdminAction;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\CustomSMS;
use MiniOrange\TwoFA\Helper\MiniOrangeUser;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class Index extends BaseAdminAction implements HttpPostActionInterface, HttpGetActionInterface
{
    public static $var1;
    public static $uname;
    public static $uemail;
    public static $uphone;
    public static $uActive;
    public static $uConfig;
    public static $utID;
    public static $uSecret;
    public static $uid;
    protected $request;
    protected $data_array;
    protected $resultFactory;
    protected $customEmail;
    protected $customSMS;
    public function __construct(\Magento\Framework\App\RequestInterface $gpUal, \Magento\Backend\App\Action\Context $P_2B1, \Magento\Framework\View\Result\PageFactory $KUwvk, \MiniOrange\TwoFA\Helper\TwoFAUtility $MF1G4, \Magento\Framework\Message\ManagerInterface $j9TYW, \Psr\Log\LoggerInterface $FaFe5, \Magento\Framework\Controller\ResultFactory $qA9Qb, CustomEmail $xZWu7, CustomSMS $mkJJm)
    {
        $this->resultFactory = $qA9Qb;
        $this->customEmail = $xZWu7;
        $this->customSMS = $mkJJm;
        parent::__construct($P_2B1, $KUwvk, $MF1G4, $j9TYW, $FaFe5);
        $this->request = $gpUal;
    }
    public function execute()
    {
        $rgOgP = $this->request->getPostValue();
        $E7rHv = $this->getRequest()->getParams();
        if (isset($rgOgP["\157\160\x74\151\x6f\156"])) {
            goto mN8o4;
        }
        if (isset($E7rHv["\143\x6f\156\x66\x69\x67\x75\162\x65"])) {
            goto DqkcC;
        }
        goto uQPbT;
        mN8o4:
        $tQqCg = $this->twofautility->isCustomerRegistered();
        if (!$tQqCg) {
            goto yMlMw;
        }
        $zgYr1 = '';
        if ("\124\x66\x61\x4d\145\x74\x68\x6f\144\x43\x6f\156\146\x69\147\165\x72\145" === $rgOgP["\157\160\164\151\x6f\x6e"]) {
            goto x9gm9;
        }
        if ("\x54\x66\141\115\145\164\x68\157\x64\103\x6f\156\x66\x69\x67\165\x72\145\126\x61\x6c\x69\x64\x61\x74\x65" === $rgOgP["\x6f\x70\164\x69\x6f\156"]) {
            goto q4cQO;
        }
        if ("\x54\146\141\x4d\x65\164\x68\157\144\x54\145\163\x74\x43\x6f\x6e\146\x69\147\x75\x72\141\x74\151\157\x6e" === $rgOgP["\x6f\160\x74\151\x6f\x6e"]) {
            goto lZ2nB;
        }
        if (!("\x54\x66\x61\x4d\145\x74\x68\x6f\144\101\x63\x74\151\166\141\164\x65" === $rgOgP["\157\160\164\151\157\156"])) {
            goto CsHFN;
        }
        $zgYr1 = $this->activate_method();
        CsHFN:
        goto HOnd8;
        lZ2nB:
        $zgYr1 = $this->test_configuration();
        HOnd8:
        goto N7pWY;
        q4cQO:
        $zgYr1 = $this->configure_step_two();
        N7pWY:
        goto cNv6E;
        x9gm9:
        $zgYr1 = $this->configure();
        cNv6E:
        $r168H = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $r168H->setUrl($zgYr1);
        return $r168H;
        goto siHCj;
        yMlMw:
        $this->messageManager->addErrorMessage(TwoFAMessages::NOT_REGISTERED);
        $do8hc = $this->resultRedirectFactory->create();
        $do8hc->setPath("\155\x6f\x74\x77\x6f\146\x61\x2f\x61\143\x63\x6f\165\x6e\164\57\x69\x6e\144\x65\x78");
        return $do8hc;
        siHCj:
        goto uQPbT;
        DqkcC:
        $ZdiAs = $this->twofautility->get_admin_role_name();
        $NyEmU = $E7rHv["\143\157\156\146\151\147\165\162\145"];
        $NyEmU = "\x22" . $NyEmU . "\42";
        $a2Dpv = $this->twofautility->getAdminActiveMethodInline($ZdiAs);
        if (str_contains($a2Dpv, $NyEmU)) {
            goto max7q;
        }
        $zgYr1 = strtok($_SERVER["\122\105\x51\125\x45\123\x54\x5f\125\x52\111"], "\77") . "\77\x26\x6d\x65\164\x68\157\144\137\163\x65\x74\x66\141\151\154\145\x64\x3d\x46\101\x49\114\x45\104";
        $r168H = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $r168H->setUrl($zgYr1);
        return $r168H;
        max7q:
        uQPbT:
        $hyoir = $this->resultPageFactory->create();
        $hyoir->getConfig()->getTitle()->prepend(__(TwoFAConstants::MODULE_TITLE));
        return $hyoir;
    }
    public function configure()
    {
        $this->twofautility->log_debug("\x54\x77\x6f\106\x41\x73\145\x74\x74\x69\x6e\147\x73\72\x20\x43\x6f\156\146\151\x67\x75\162\x61\164\x69\x6f\156\x3a\40\145\170\145\143\x75\x74\x65");
        $tQqCg = $this->twofautility->isCustomerRegistered();
        if ($tQqCg) {
            goto PIyjs;
        }
        $this->messageManager->addSuccessMessage(TwoFAMessages::NOT_REGISTERED);
        return;
        PIyjs:
        $E7rHv = $this->getRequest()->getParams();
        $current_user = $this->twofautility->getCurrentAdminUser();
        $eO5PP = $current_user->getUsername();
        $eJ8ct = $eO5PP;
        $pltyN = isset($E7rHv["\x65\155\141\151\x6c"]) ? $E7rHv["\x65\x6d\141\151\154"] : '';
        $GCz1G = isset($E7rHv["\160\x68\x6f\x6e\145"]) ? $E7rHv["\x70\150\157\156\x65"] : '';
        $pY8sz = isset($E7rHv["\143\x6f\165\x6e\x74\x72\171\143\157\144\x65"]) ? $E7rHv["\x63\157\165\156\164\x72\171\x63\157\144\145"] : '';
        $bS_K6 = isset($E7rHv["\x61\x75\164\150\124\171\x70\x65"]) ? $E7rHv["\141\165\x74\150\124\x79\x70\x65"] : '';
        $kAe2k = new MiniOrangeUser();
        $AUDbg = 0;
        $CPSBM = $this->twofautility->getAllMoTfaUserDetails("\x6d\x69\x6e\x69\x6f\162\x61\x6e\x67\145\x5f\x74\x66\141\x5f\x75\163\x65\x72\163", $eO5PP, -1);
        if (is_array($CPSBM) && sizeof($CPSBM) > 0) {
            goto nrtnc;
        }
        $current_user = $this->twofautility->getCurrentAdminUser();
        $eO5PP = $current_user->getUsername();
        $AUDbg = 1;
        $this->twofautility->log_debug("\x54\167\157\106\x41\x73\145\x74\x74\x69\156\147\163\x3a\x20\x43\x6f\x6e\x66\151\x67\x75\162\141\164\x69\157\x6e\72\x20\165\163\x65\162\40\156\157\x74\x20\146\x6f\165\156\x64\x20\x3a\40\163\x65\164\x20\x70\x72\x65\x76\x69\157\165\163\x20\x64\141\164\141\x20\151\156\40\x73\x65\163\163\151\157\156");
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_USERNAME, $eJ8ct);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_EMAIL, $pltyN);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_PHONE, $GCz1G);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_COUNTRY_CODE, $pY8sz);
        $Wwk_l = $this->twofautility->getSessionValue(TwoFAConstants::PRE_SECRET);
        if ($Wwk_l != NULL) {
            goto ZvPS_;
        }
        $uxSSU = $this->twofautility->generateRandomString();
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_SECRET, $uxSSU);
        goto lekuw;
        ZvPS_:
        $uxSSU = $Wwk_l;
        lekuw:
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_ACTIVE_METHOD, $bS_K6);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_CONFIG_METHOD, $bS_K6);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_IS_INLINE, 1);
        $this->twofautility->flushCache();
        $this->twofautility->log_debug("\x54\167\x6f\106\101\163\x65\164\164\x69\156\x67\x73\x3a\x20\x43\157\156\x66\151\147\165\162\141\x74\x69\x6f\x6e\x3a\40\x61\x64\x64\x69\156\x67\40\156\x65\167\40\x72\157\167");
        $edTYi = array("\x75\x73\x65\162\x6e\141\155\145" => $eJ8ct, "\x61\x63\x74\151\x76\x65\x5f\x6d\x65\164\x68\157\144" => $bS_K6, "\143\157\x6e\146\x69\x67\x75\162\x65\144\137\155\145\164\150\x6f\x64\163" => $bS_K6, "\145\155\x61\151\x6c" => $pltyN, "\x70\x68\157\x6e\145" => $GCz1G, "\x63\157\x75\x6e\x74\162\171\143\x6f\144\145" => $pY8sz, "\163\x65\143\162\145\164" => $uxSSU, "\167\x65\x62\x73\x69\164\x65\x5f\x69\x64" => -1);
        goto opJdM;
        nrtnc:
        $current_user = $this->twofautility->getCurrentAdminUser();
        $eO5PP = $current_user->getUsername();
        $aBFfK = $this->twofautility->getAllMoTfaUserDetails("\155\151\x6e\151\x6f\x72\141\x6e\147\x65\137\x74\x66\141\x5f\x75\x73\x65\162\x73", $eO5PP, -1);
        $this->twofautility->log_debug("\124\x77\x6f\106\101\163\145\x74\164\151\156\x67\163\72\x20\x43\157\x6e\146\x69\147\x75\162\x61\164\x69\x6f\156\x3a\x20\165\x73\x65\x72\x66\x6f\165\x6e\x64\72\x20\x73\145\164\40\160\x72\x65\166\157\x69\165\163\40\x63\x6f\156\x66\151\147\165\x72\141\x74\151\x6f\156\x20\x69\156\x20\x73\x65\163\x73\151\x6f\156");
        $NtdWr = $CPSBM[0]["\x63\x6f\x6e\x66\151\147\x75\162\145\x64\137\x6d\x65\164\150\157\x64\163"];
        $pltyN = empty($pltyN) ? empty($CPSBM[0]["\145\x6d\141\x69\154"]) ? '' : $CPSBM[0]["\x65\155\x61\x69\x6c"] : $pltyN;
        $GCz1G = empty($GCz1G) ? empty($CPSBM[0]["\160\x68\157\x6e\145"]) ? '' : $CPSBM[0]["\160\150\157\x6e\x65"] : $GCz1G;
        $pY8sz = empty($pY8sz) ? empty($CPSBM[0]["\143\157\x75\156\164\162\171\x63\157\x64\145"]) ? '' : $CPSBM[0]["\143\x6f\x75\x6e\164\x72\171\143\157\144\x65"] : $pY8sz;
        if (str_contains($CPSBM[0]["\x63\x6f\x6e\146\151\x67\x75\162\145\144\137\155\145\x74\x68\x6f\x64\x73"], $bS_K6)) {
            goto Jf8cM;
        }
        $NtdWr = $NtdWr . "\73" . $bS_K6;
        Jf8cM:
        $edTYi = array("\141\143\164\151\x76\145\x5f\x6d\145\164\150\157\x64" => $bS_K6, "\x63\157\x6e\x66\151\147\165\162\145\144\137\155\x65\x74\150\x6f\144\x73" => $NtdWr, "\145\155\141\151\x6c" => $pltyN, "\x70\150\157\156\x65" => $GCz1G, "\x63\157\165\156\x74\x72\171\143\157\x64\145" => $pY8sz);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_USERNAME, $eO5PP);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_EMAIL, $pltyN);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_PHONE, $GCz1G);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_COUNTRY_CODE, $pY8sz);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_ACTIVE_METHOD, $bS_K6);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_CONFIG_METHOD, $NtdWr);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_IS_INLINE, 1);
        opJdM:
        $C7s8O = NULL;
        if (!($bS_K6 !== "\107\x6f\x6f\x67\x6c\x65\101\165\164\x68\145\156\164\151\143\141\x74\x6f\162" && $bS_K6 !== "\115\x69\x63\x72\157\163\157\146\164\x41\165\x74\150\x65\156\x74\151\143\141\164\157\x72")) {
            goto h02eC;
        }
        $y30fP = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
        $Kwf52 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
        $OEI53 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
        if ($y30fP || $Kwf52) {
            goto i6ehA;
        }
        if ($bS_K6 == "\x4f\117\x57") {
            goto wsp_A;
        }
        $SoVFo = json_decode($kAe2k->setUserInfoData($edTYi)->challenge($eJ8ct, $this->twofautility, $bS_K6, true, -1), true);
        goto sKNr8;
        wsp_A:
        if ($bS_K6 == "\117\x4f\127" && $OEI53) {
            goto zYGVM;
        }
        if (!($bS_K6 == "\117\117\127")) {
            goto ma3A2;
        }
        $this->twofautility->log_debug("\101\x75\164\x68\56\160\x68\160\x20\x3a\x20\x65\170\145\143\165\x74\x65\x3a\x20\x6d\x69\x6e\x69\x4f\162\141\x6e\x67\x65\x20\167\150\x61\x74\163\x61\160\x70\x20\147\141\164\x65\x77\141\x79");
        $p_ovu = $this->twofautility->Customgateway_GenerateOTP();
        $GCz1G = "\53" . $pY8sz . $GCz1G;
        $SoVFo = $this->twofautility->send_customgateway_whatsapp($GCz1G, $p_ovu);
        ma3A2:
        goto IIjZn;
        zYGVM:
        $this->twofautility->log_debug("\x41\165\x74\x68\x2e\x70\x68\160\40\x3a\40\145\170\145\143\165\x74\x65\72\40\103\165\163\164\157\155\40\167\x68\x61\164\163\141\160\160\40\147\141\x74\x65\167\x61\171");
        $p_ovu = $this->twofautility->Customgateway_GenerateOTP();
        $GCz1G = "\53" . $pY8sz . $GCz1G;
        $SoVFo = $this->twofautility->send_customgateway_whatsapp($GCz1G, $p_ovu);
        IIjZn:
        sKNr8:
        goto UET_t;
        i6ehA:
        if ($bS_K6 == "\x4f\x4f\127") {
            goto gY7yR;
        }
        $this->twofautility->log_debug("\101\x75\x74\150\56\x70\x68\x70\40\x3a\x20\145\x78\145\x63\165\164\x65\x3a\x20\x43\x75\163\164\x6f\x6d\40\147\141\164\145\167\x61\171");
        goto p2zAp;
        gY7yR:
        $this->twofautility->log_debug("\x41\x75\164\x68\56\160\150\x70\40\72\40\x65\170\x65\143\x75\164\145\72\x20\x6d\151\156\151\x4f\162\141\156\147\145\40\x77\x68\141\164\163\x61\x70\160\x20\147\141\x74\x65\167\141\x79");
        p2zAp:
        if ($bS_K6 == "\x4f\x4f\105" && $y30fP) {
            goto tcpjp;
        }
        if ($bS_K6 == "\117\117\105") {
            goto tDV8E;
        }
        goto vfA1w;
        tcpjp:
        $Ox44O = $this->twofautility->Customgateway_GenerateOTP();
        $kC4Q5 = $pltyN;
        $SoVFo = $this->customEmail->sendCustomgatewayEmail($kC4Q5, $Ox44O);
        goto vfA1w;
        tDV8E:
        $SoVFo = json_decode($kAe2k->setUserInfoData($edTYi)->challenge($eJ8ct, $this->twofautility, $bS_K6, true, -1), true);
        vfA1w:
        if ($bS_K6 == "\x4f\x4f\x53" && $Kwf52) {
            goto NrSrh;
        }
        if ($bS_K6 == "\x4f\x4f\123") {
            goto ZMYpf;
        }
        goto PO9Q0;
        NrSrh:
        $p_ovu = $this->twofautility->Customgateway_GenerateOTP();
        $GCz1G = "\x2b" . $pY8sz . $GCz1G;
        $SoVFo = $this->customSMS->send_customgateway_sms($GCz1G, $p_ovu);
        goto PO9Q0;
        ZMYpf:
        $SoVFo = json_decode($kAe2k->setUserInfoData($edTYi)->challenge($eJ8ct, $this->twofautility, $bS_K6, true, -1), true);
        PO9Q0:
        if (!($bS_K6 == "\117\117\x53\105")) {
            goto kimvN;
        }
        $Ox44O = $this->twofautility->Customgateway_GenerateOTP();
        $kC4Q5 = $pltyN;
        $GCz1G = "\53" . $pY8sz . $GCz1G;
        if ($y30fP) {
            goto DaxDj;
        }
        $sfFoF["\x73\164\x61\x74\165\163"] = "\106\x41\x49\x4c\x45\104";
        goto O_vkP;
        DaxDj:
        $sfFoF = $this->customEmail->sendCustomgatewayEmail($kC4Q5, $Ox44O);
        O_vkP:
        if ($Kwf52) {
            goto FU9Mz;
        }
        $NDIFM["\x73\164\141\x74\x75\163"] = "\x46\101\111\114\105\104";
        goto eYOBT;
        FU9Mz:
        $NDIFM = $this->customSMS->send_customgateway_sms($GCz1G, $Ox44O);
        eYOBT:
        $gxMLC = $this->twofautility->OTP_over_SMSandEMAIL_Message($kC4Q5, $GCz1G, $sfFoF["\x73\x74\141\164\165\x73"], $NDIFM["\163\x74\x61\164\165\x73"]);
        if ($sfFoF["\163\164\x61\x74\165\x73"] == "\123\x55\x43\x43\x45\123\x53" || $NDIFM["\163\164\141\x74\x75\163"] == "\123\x55\103\x43\x45\123\x53") {
            goto wYCcI;
        }
        $SoVFo = array("\163\164\141\x74\165\x73" => "\106\x41\x49\x4c\x45\104", "\x6d\145\163\163\141\x67\145" => $gxMLC, "\164\170\111\144" => "\61");
        goto tj2zO;
        wYCcI:
        $SoVFo = array("\163\164\x61\164\165\163" => "\x53\x55\103\103\105\x53\x53", "\x6d\x65\x73\x73\x61\x67\x65" => $gxMLC, "\x74\170\111\x64" => "\61");
        tj2zO:
        kimvN:
        UET_t:
        if (!isset($SoVFo["\x6d\x65\163\x73\x61\147\145"])) {
            goto zWhzf;
        }
        $C7s8O = $SoVFo["\155\x65\163\163\x61\x67\145"];
        zWhzf:
        if (!(isset($SoVFo["\163\x74\x61\x74\x75\x73"]) && $SoVFo["\x73\164\x61\164\x75\163"] === "\123\125\103\x43\x45\x53\123")) {
            goto r00PE;
        }
        $edTYi["\164\162\141\x6e\163\141\143\x74\x69\x6f\x6e\x49\144"] = $SoVFo["\164\170\111\144"];
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_TRANSACTIONID, $SoVFo["\x74\x78\111\144"]);
        r00PE:
        h02eC:
        if (isset($SoVFo["\x73\164\141\x74\x75\x73"]) && $SoVFo["\163\164\x61\x74\x75\x73"] === "\106\101\x49\114\105\x44") {
            goto oCx22;
        }
        $zgYr1 = strtok($_SERVER["\122\x45\121\125\105\x53\x54\x5f\125\122\x49"], "\77") . "\x3f\x63\157\x6e\x66\x69\x67\165\x72\x65\x3d" . $bS_K6 . "\46\141\x63\x74\151\x6f\x6e\x3d\x76\141\x6c\151\x64\141\x74\x65\x6f\164\160\46\x6d\x65\x73\163\x61\147\x65\75" . $C7s8O . "\x26\162\x5f\x73\164\141\x74\165\163\75\x53\x55\103\103\105\x53\123";
        goto sqLMA;
        oCx22:
        $this->twofautility->flushCache();
        $zgYr1 = strtok($_SERVER["\x52\105\121\125\x45\x53\x54\137\125\x52\x49"], "\x3f") . "\x3f\155\x65\x73\x73\141\x67\145\x3d" . $C7s8O . "\x26\x72\137\x73\x74\x61\164\165\x73\75\x46\101\x49\114\x45\x44";
        sqLMA:
        return $zgYr1;
    }
    public function configure_step_two()
    {
        $this->twofautility->log_debug("\124\167\x6f\x46\x41\163\145\164\x74\x69\x6e\x67\163\72\40\103\157\x6e\146\151\147\165\162\x61\x74\151\157\x6e\x20\x73\x65\x74\x70\x5f\164\167\x6f\x3a\x20\x65\x78\145\143\165\164\x65");
        $edTYi = $this->goBack_to_PreviousConfig();
        $tQqCg = $this->twofautility->isCustomerRegistered();
        if ($tQqCg) {
            goto HzI8s;
        }
        $this->messageManager->addSuccessMessage(TwoFAMessages::NOT_REGISTERED);
        return;
        HzI8s:
        $E7rHv = $this->getRequest()->getParams();
        $kAe2k = new miniOrangeUser();
        $current_user = $this->twofautility->getCurrentAdminUser();
        $eO5PP = $current_user->getUsername();
        if ("\x47\x6f\157\147\154\x65\101\165\164\x68\145\x6e\164\151\143\x61\x74\x6f\x72" === $E7rHv["\x61\165\164\x68\x54\171\x70\145"] || "\115\151\143\162\157\163\157\x66\164\x41\165\x74\150\x65\156\x74\x69\143\x61\164\157\x72" === $E7rHv["\x61\165\x74\x68\124\171\160\x65"]) {
            goto m0Mql;
        }
        $y30fP = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
        $Kwf52 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
        $OEI53 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
        $wVUQo = false;
        if ($E7rHv["\x61\x75\x74\150\x54\171\x70\x65"] == "\117\117\x45" && $y30fP) {
            goto GqFuR;
        }
        if ($E7rHv["\141\x75\x74\x68\x54\171\160\145"] == "\117\x4f\x53" && $Kwf52) {
            goto PTJxi;
        }
        if ($E7rHv["\141\165\x74\x68\124\171\160\145"] == "\117\117\123\105") {
            goto Hfoib;
        }
        if ($E7rHv["\141\165\x74\150\124\171\160\x65"] == "\x4f\x4f\127" && $OEI53) {
            goto OIewJ;
        }
        goto JSusA;
        GqFuR:
        $wVUQo = true;
        goto JSusA;
        PTJxi:
        $wVUQo = true;
        goto JSusA;
        Hfoib:
        $wVUQo = true;
        goto JSusA;
        OIewJ:
        $wVUQo = true;
        JSusA:
        if (($y30fP || $Kwf52) && $wVUQo) {
            goto ASlNK;
        }
        if ($E7rHv["\141\165\164\150\x54\x79\x70\145"] == "\117\117\127") {
            goto BfGis;
        }
        $SoVFo = $kAe2k->setUserInfoData($edTYi)->validate($eO5PP, $E7rHv["\157\156\x65\x2d\164\x69\155\x65\55\157\164\160\x2d\x74\157\153\145\156"], $E7rHv["\x61\x75\x74\150\x54\x79\x70\145"], $this->twofautility, NULL, true, -1);
        $SoVFo = json_decode($SoVFo, true);
        goto CKroP;
        BfGis:
        if ($E7rHv["\x61\x75\x74\150\x54\x79\x70\145"] == "\x4f\117\x57") {
            goto V_OK9;
        }
        $this->twofautility->log_debug("\x41\x75\164\x68\x2e\160\x68\160\40\x3a\x20\145\170\145\143\x75\x74\x65\72\40\x43\165\163\x74\157\x6d\x20\147\141\x74\145\167\141\171");
        goto psTEk;
        V_OK9:
        $this->twofautility->log_debug("\101\165\x74\150\56\x70\x68\160\x20\x3a\x20\x65\170\x65\x63\165\x74\x65\72\x20\x6d\151\x6e\151\117\x72\141\156\x67\x65\40\x77\150\141\164\163\141\160\160\x20\x67\141\x74\145\x77\x61\171");
        psTEk:
        $ebw5W = $this->twofautility->customgateway_validateOTP($E7rHv["\x6f\x6e\145\55\164\151\155\145\x2d\x6f\x74\160\x2d\x74\x6f\153\x65\x6e"]);
        $SoVFo = array("\x73\x74\x61\x74\x75\163" => $ebw5W);
        CKroP:
        goto gNTrr;
        ASlNK:
        $this->twofautility->log_debug("\x41\x75\164\150\56\x70\150\160\x20\x3a\x20\145\x78\x65\143\x75\x74\x65\72\40\x43\x75\163\164\x6f\x6d\40\x67\141\164\145\167\141\171");
        $ebw5W = $this->twofautility->customgateway_validateOTP($E7rHv["\x6f\x6e\145\55\164\x69\155\x65\x2d\x6f\164\160\55\164\x6f\153\145\x6e"]);
        $SoVFo = array("\163\x74\141\164\165\x73" => $ebw5W);
        gNTrr:
        $this->twofautility->log_debug("\x54\167\157\106\101\163\145\164\164\151\156\147\x73\x3a\x20\103\157\x6e\x66\151\x67\x75\x72\x61\164\x69\157\x6e\72\40\x76\x61\154\151\x64\x61\x74\x69\x6e\147\40\162\x65\x73\160\157\156\163\x65");
        goto S_3xS;
        m0Mql:
        $SoVFo = $this->twofautility->verifyGauthCode($E7rHv["\x6f\x6e\x65\x2d\164\x69\155\x65\x2d\x6f\x74\x70\55\164\x6f\153\145\x6e"], $eO5PP);
        $this->twofautility->log_debug("\x54\x77\157\x46\101\163\x65\x74\x74\151\x6e\147\x73\x3a\40\x43\157\156\146\x69\147\x75\162\141\x74\x69\157\156\72\x20\145\x78\x65\x63\x75\x74\145\x3a\40\147\x6f\157\x67\154\145\40\141\x75\164\150\x20\x72\x65\163\x70\157\x6e\163\x65\40\x66\145\x74\x63\150\145\x64");
        $SoVFo = json_decode($SoVFo, true);
        S_3xS:
        $zgYr1 = '';
        $AUDbg = $this->twofautility->getSessionValue(TwoFAConstants::PRE_IS_INLINE);
        if (isset($SoVFo["\163\164\x61\164\165\163"]) && $SoVFo["\x73\164\x61\x74\x75\163"] == "\x53\x55\103\x43\105\123\x53") {
            goto L48Sx;
        }
        $this->twofautility->flushCache();
        $zgYr1 = strtok($_SERVER["\122\105\121\125\x45\123\x54\x5f\125\x52\x49"], "\x3f") . "\x3f\x73\x74\x61\x74\165\163\75\145\x72\x72\157\162";
        goto DZHCV;
        L48Sx:
        $CPSBM = $this->twofautility->getAllMoTfaUserDetails("\155\151\x6e\x69\157\x72\x61\156\147\x65\x5f\x74\x66\141\137\165\x73\x65\162\163", $eO5PP, -1);
        if (isset($E7rHv["\164\145\163\x74\143\x6f\x6e\146\151\147"])) {
            goto oAxmn;
        }
        if (is_array($CPSBM) && sizeof($CPSBM) > 0) {
            goto mBev2;
        }
        if (!($edTYi["\164\x72\141\156\163\x61\x63\164\x69\157\156\111\144"] == NULL)) {
            goto E4ByE;
        }
        $edTYi["\x74\162\x61\x6e\x73\x61\143\x74\x69\157\156\x49\144"] = 1;
        E4ByE:
        $edTYi["\x77\145\142\163\x69\x74\145\137\151\x64"] = -1;
        $this->twofautility->insertRowInTable("\155\151\x6e\x69\157\x72\141\x6e\x67\145\x5f\x74\x66\141\137\165\x73\145\162\163", $edTYi);
        goto KqoSo;
        mBev2:
        $bS_K6 = '';
        $pltyN = '';
        $GCz1G = '';
        $pY8sz = '';
        if ($edTYi["\141\x63\164\151\x76\x65\x5f\x6d\145\164\x68\157\144"] != NULL) {
            goto S_fNV;
        }
        $bS_K6 = empty($bS_K6) ? empty($CPSBM[0]["\141\143\164\x69\x76\x65\137\155\x65\164\150\157\x64"]) ? '' : $CPSBM[0]["\x61\x63\x74\x69\166\145\x5f\x6d\145\164\150\x6f\144"] : $bS_K6;
        goto TlYGf;
        S_fNV:
        $bS_K6 = $edTYi["\141\143\164\x69\x76\x65\137\x6d\145\x74\150\157\144"];
        TlYGf:
        $NtdWr = $CPSBM[0]["\x63\x6f\156\x66\x69\x67\165\x72\x65\x64\x5f\155\x65\x74\150\157\x64\163"];
        if (str_contains($CPSBM[0]["\143\157\x6e\x66\x69\x67\165\x72\145\144\x5f\x6d\145\164\150\x6f\x64\163"], $bS_K6)) {
            goto MCfcD;
        }
        $NtdWr = $NtdWr . "\x3b" . $bS_K6;
        MCfcD:
        if ($edTYi["\145\x6d\x61\x69\154"] != NULL) {
            goto R8dKX;
        }
        $pltyN = empty($pltyN) ? empty($CPSBM[0]["\145\x6d\x61\151\x6c"]) ? '' : $CPSBM[0]["\145\155\x61\x69\x6c"] : $pltyN;
        goto eOPhi;
        R8dKX:
        $pltyN = $edTYi["\145\x6d\141\151\154"];
        eOPhi:
        if ($edTYi["\160\150\157\156\x65"] != NULL) {
            goto PD0ZC;
        }
        $GCz1G = empty($GCz1G) ? empty($CPSBM[0]["\160\150\157\x6e\x65"]) ? '' : $CPSBM[0]["\x70\x68\157\x6e\x65"] : $GCz1G;
        goto X5BWL;
        PD0ZC:
        $GCz1G = $edTYi["\160\x68\157\156\145"];
        X5BWL:
        if ($edTYi["\x63\x6f\165\156\164\x72\x79\143\x6f\144\x65"] != NULL) {
            goto R3ZPS;
        }
        $pY8sz = empty($pY8sz) ? empty($CPSBM[0]["\143\157\165\x6e\164\x72\x79\143\x6f\x64\145"]) ? '' : $CPSBM[0]["\x63\157\x75\156\x74\162\x79\143\157\144\145"] : $pY8sz;
        goto l0T5k;
        R3ZPS:
        $pY8sz = $edTYi["\143\x6f\165\x6e\x74\x72\x79\143\157\x64\145"];
        l0T5k:
        if ($edTYi["\164\162\141\156\x73\x61\143\164\151\157\x6e\x49\x64"] != NULL) {
            goto QScya;
        }
        if ($CPSBM[0]["\164\162\x61\x6e\x73\x61\x63\x74\x69\x6f\x6e\111\x64"] != NULL) {
            goto u07ka;
        }
        $dAWiM = 1;
        goto lIM0P;
        QScya:
        $dAWiM = $edTYi["\x74\x72\x61\156\163\141\143\x74\x69\157\156\111\144"];
        goto lIM0P;
        u07ka:
        $dAWiM = $CPSBM[0]["\164\162\x61\x6e\163\x61\x63\164\x69\157\156\111\x64"];
        lIM0P:
        $t1Co6 = ["\141\143\x74\x69\166\x65\x5f\x6d\145\x74\x68\x6f\x64" => $bS_K6, "\143\157\156\x66\x69\x67\165\x72\145\x64\137\x6d\x65\x74\x68\x6f\x64\163" => $NtdWr, "\x65\155\x61\151\154" => $pltyN, "\160\150\157\x6e\145" => $GCz1G, "\143\x6f\x75\x6e\164\x72\x79\143\x6f\x64\145" => $pY8sz, "\164\162\x61\156\x73\x61\143\164\151\157\156\111\x64" => $dAWiM];
        $this->twofautility->updateRowInTable("\155\151\x6e\151\x6f\162\x61\156\x67\x65\137\164\146\141\x5f\165\163\145\x72\163", $t1Co6, "\x75\163\x65\x72\156\141\x6d\145", $edTYi["\x75\x73\145\x72\156\x61\x6d\x65"]);
        if (!($edTYi["\x73\x65\x63\x72\145\164"] != NULL)) {
            goto oIxIQ;
        }
        $this->twofautility->updateColumnInTable("\x6d\x69\x6e\151\157\162\x61\x6e\x67\145\x5f\164\146\x61\137\165\x73\145\162\x73", "\163\x65\x63\162\x65\x74", $edTYi["\x73\x65\143\162\x65\164"], "\165\x73\145\162\156\x61\155\x65", $edTYi["\x75\x73\x65\162\x6e\141\x6d\145"], -1);
        oIxIQ:
        KqoSo:
        oAxmn:
        $SoVFo = json_decode($kAe2k->mo2f_update_userinfo($this->twofautility, $edTYi["\145\x6d\141\x69\154"], $E7rHv["\141\x75\x74\x68\124\171\160\x65"], $edTYi["\x70\150\x6f\156\x65"], $edTYi["\143\157\165\156\x74\162\171\143\x6f\144\x65"]));
        if (!is_null($SoVFo)) {
            goto x5jSP;
        }
        $SoVFo = json_decode($kAe2k->mo_create_user($this->twofautility, $edTYi["\x65\155\x61\x69\154"], $E7rHv["\141\x75\164\150\x54\x79\160\145"], $edTYi["\160\150\157\156\145"], $edTYi["\143\x6f\x75\156\x74\x72\171\x63\x6f\144\x65"]));
        x5jSP:
        $zgYr1 = strtok($_SERVER["\122\x45\121\125\105\123\x54\x5f\x55\122\x49"], "\x3f") . "\x3f\163\164\141\x74\x75\x73\75\x73\165\143\x63\145\x73\x73";
        DZHCV:
        unset($edTYi);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_IS_INLINE, 0);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_USERNAME, NULL);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_EMAIL, NULL);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_PHONE, NULL);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_COUNTRY_CODE, NULL);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_ACTIVE_METHOD, NULL);
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_CONFIG_METHOD, NULL);
        return $zgYr1;
    }
    public function goBack_to_PreviousConfig()
    {
        $current_user = $this->twofautility->getCurrentAdminUser();
        $eO5PP = $current_user->getUsername();
        $sdIXk = $this->twofautility->getSessionValue(TwoFAConstants::PRE_USERNAME);
        $V4a8t = $this->twofautility->getSessionValue(TwoFAConstants::PRE_EMAIL);
        $AnOXT = $this->twofautility->getSessionValue(TwoFAConstants::PRE_PHONE);
        $nMBGx = $this->twofautility->getSessionValue(TwoFAConstants::PRE_TRANSACTIONID);
        $fo66z = $this->twofautility->getSessionValue(TwoFAConstants::PRE_SECRET);
        $Qc_pH = $this->twofautility->getSessionValue(TwoFAConstants::PRE_ACTIVE_METHOD);
        $rL6Dn = $this->twofautility->getSessionValue(TwoFAConstants::PRE_CONFIG_METHOD);
        $EnhXk = $this->twofautility->getSessionValue(TwoFAConstants::PRE_COUNTRY_CODE);
        $t1Co6 = ["\x75\x73\x65\162\156\141\155\x65" => $sdIXk, "\x61\x63\164\x69\x76\145\x5f\x6d\x65\164\150\157\x64" => $Qc_pH, "\143\157\x6e\x66\x69\x67\x75\162\x65\x64\x5f\x6d\145\x74\x68\157\144\x73" => $rL6Dn, "\145\155\141\x69\x6c" => $V4a8t, "\160\150\x6f\156\145" => $AnOXT, "\x63\x6f\x75\x6e\164\162\171\x63\x6f\144\145" => $EnhXk, "\164\162\x61\x6e\x73\141\143\164\151\157\156\111\144" => $nMBGx, "\x73\145\143\162\x65\x74" => $fo66z];
        return $t1Co6;
    }
    public function test_configuration()
    {
        $this->twofautility->log_debug("\124\x77\157\106\x41\163\145\x74\164\x69\x6e\x67\163\72\40\x74\145\163\x74\40\143\157\156\146\x69\x67\165\162\141\x74\x69\157\x6e\x3a\40\145\x78\145\143\165\164\x65");
        $tQqCg = $this->twofautility->isCustomerRegistered();
        if ($tQqCg) {
            goto Oe5CO;
        }
        $this->messageManager->addSuccessMessage(TwoFAMessages::NOT_REGISTERED);
        return;
        Oe5CO:
        $E7rHv = $this->getRequest()->getParams();
        $current_user = $this->twofautility->getCurrentAdminUser();
        $eO5PP = $current_user->getUsername();
        $eJ8ct = $eO5PP;
        $NyEmU = $E7rHv["\124\x65\163\164\103\157\156\x66\151\x67\115\145\164\x68\157\x64\x4e\x61\155\145"];
        $CPSBM = $this->twofautility->getAllMoTfaUserDetails("\x6d\151\x6e\x69\x6f\x72\x61\156\147\x65\x5f\164\x66\141\137\x75\163\x65\162\163", $eO5PP, -1);
        $zgYr1 = '';
        if (is_array($CPSBM) && sizeof($CPSBM) > 0) {
            goto s8lVn;
        }
        $this->twofautility->log_debug("\x54\x77\x6f\106\101\x73\x65\164\164\x69\156\x67\x73\x3a\x20\164\x65\163\164\x20\x63\157\156\x66\x69\147\165\162\141\x74\151\x6f\156\72\x20\162\x6f\x77\40\x6e\x6f\164\x20\x72\x65\x67\x69\x73\164\x65\162");
        $zgYr1 = strtok($_SERVER["\x52\x45\x51\x55\x45\x53\x54\137\125\122\111"], "\x3f") . "\x3f\163\164\x61\164\165\163\75\x65\x72\x72\157\162\46\x74\145\x73\x74\143\x6f\x6e\146\x69\x67\x3d\164\x65\x73\x74\143\157\156\x66\151\x67";
        goto d3bOq;
        s8lVn:
        $NtdWr = $CPSBM[0]["\x63\157\x6e\146\151\x67\x75\162\145\144\137\x6d\x65\164\150\x6f\144\163"];
        if (!str_contains($CPSBM[0]["\143\157\156\146\151\147\165\x72\145\x64\x5f\x6d\x65\x74\x68\157\x64\163"], $NyEmU)) {
            goto ZOYgN;
        }
        if ("\x47\x6f\x6f\x67\154\145\x41\x75\164\150\x65\x6e\x74\151\143\x61\x74\x6f\x72" !== $NyEmU && "\115\151\x63\x72\157\163\157\146\164\101\x75\x74\x68\x65\x6e\164\151\143\x61\164\157\162" !== $NyEmU) {
            goto VJrJM;
        }
        $zgYr1 = strtok($_SERVER["\x52\105\121\125\x45\123\124\137\x55\122\x49"], "\x3f") . "\x3f\x63\x6f\x6e\x66\x69\147\x75\162\x65\x3d" . $NyEmU . "\x26\x61\x63\x74\x69\x6f\156\x3d\166\141\154\151\x64\141\164\x65\x6f\164\x70\x26\x74\x65\x73\x74\143\157\156\x66\151\147\75\164\x65\163\x74\143\x6f\x6e\146\x69\147";
        goto Q9uxh;
        VJrJM:
        $this->twofautility->log_debug("\x54\x77\157\106\x41\x73\x65\x74\164\x69\x6e\x67\163\x3a\x20\164\145\x73\164\x20\x63\157\x6e\x66\151\x67\x75\162\x61\164\151\x6f\x6e\x3a\40\145\x78\x65\x63\165\164\145\x3a\40\155\145\x74\150\157\x64\72\40" . $NyEmU);
        $y30fP = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
        $Kwf52 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
        $OEI53 = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
        if ($y30fP || $Kwf52) {
            goto z6YnO;
        }
        if ($NyEmU == "\x4f\117\x57") {
            goto q1_F_;
        }
        $kAe2k = new MiniOrangeUser();
        $SoVFo = json_decode($kAe2k->challenge($eJ8ct, $this->twofautility, $NyEmU, true . -1), true);
        goto usVjA;
        q1_F_:
        if ($NyEmU == "\117\117\x57" && $OEI53) {
            goto gEv2N;
        }
        if ($NyEmU == "\117\x4f\127") {
            goto IU8yR;
        }
        goto cbqVQ;
        gEv2N:
        $p_ovu = $this->twofautility->Customgateway_GenerateOTP();
        $GCz1G = $CPSBM[0]["\x70\x68\157\x6e\x65"];
        $pY8sz = $CPSBM[0]["\143\157\165\x6e\x74\x72\x79\143\x6f\144\145"];
        $GCz1G = "\53" . $pY8sz . $GCz1G;
        $SoVFo = $this->twofautility->send_customgateway_whatsapp($GCz1G, $p_ovu);
        goto cbqVQ;
        IU8yR:
        $p_ovu = $this->twofautility->Customgateway_GenerateOTP();
        $GCz1G = $CPSBM[0]["\x70\x68\x6f\156\145"];
        $pY8sz = $CPSBM[0]["\x63\x6f\x75\x6e\x74\162\x79\143\157\144\145"];
        $GCz1G = "\x2b" . $pY8sz . $GCz1G;
        $SoVFo = $this->twofautility->send_whatsapp($GCz1G, $p_ovu);
        cbqVQ:
        usVjA:
        goto sZRYF;
        z6YnO:
        $this->twofautility->log_debug("\124\x77\157\x46\x41\x73\x65\164\x74\x69\x6e\147\x73\72\x20\x3a\40\145\170\x65\x63\x75\164\145\72\40\103\165\163\x74\x6f\155\40\x67\x61\164\x65\167\141\171");
        if ($NyEmU == "\117\x4f\x45" && $y30fP) {
            goto C6IkY;
        }
        if ($NyEmU == "\117\x4f\105") {
            goto FeT8E;
        }
        goto Y4qpb;
        C6IkY:
        $Ox44O = $this->twofautility->Customgateway_GenerateOTP();
        $kC4Q5 = $CPSBM[0]["\x65\155\141\x69\x6c"];
        $SoVFo = $this->customEmail->sendCustomgatewayEmail($kC4Q5, $Ox44O);
        goto Y4qpb;
        FeT8E:
        $kAe2k = new MiniOrangeUser();
        $SoVFo = json_decode($kAe2k->challenge($eJ8ct, $this->twofautility, $NyEmU, true, -1), true);
        Y4qpb:
        if ($NyEmU == "\x4f\117\x53" && $Kwf52) {
            goto w6V9s;
        }
        if ($NyEmU == "\x4f\x4f\x53") {
            goto MEzjq;
        }
        goto jYsqv;
        w6V9s:
        $p_ovu = $this->twofautility->Customgateway_GenerateOTP();
        $GCz1G = $CPSBM[0]["\160\x68\157\x6e\x65"];
        $pY8sz = $CPSBM[0]["\x63\x6f\165\x6e\x74\162\171\143\x6f\144\x65"];
        $GCz1G = "\x2b" . $pY8sz . $GCz1G;
        $SoVFo = $this->customSMS->send_customgateway_sms($GCz1G, $p_ovu);
        goto jYsqv;
        MEzjq:
        $kAe2k = new MiniOrangeUser();
        $SoVFo = json_decode($kAe2k->challenge($eJ8ct, $this->twofautility, $NyEmU, true, -1), true);
        jYsqv:
        if (!($NyEmU == "\x4f\x4f\123\x45")) {
            goto JZxcz;
        }
        $Ox44O = $this->twofautility->Customgateway_GenerateOTP();
        $kC4Q5 = $CPSBM[0]["\x65\155\141\151\x6c"];
        $GCz1G = $CPSBM[0]["\160\x68\x6f\x6e\x65"];
        $pY8sz = $CPSBM[0]["\x63\x6f\165\156\164\x72\171\143\157\144\x65"];
        $GCz1G = "\53" . $pY8sz . $GCz1G;
        if ($y30fP) {
            goto ctRYm;
        }
        $sfFoF["\163\164\x61\x74\x75\x73"] = "\x46\101\111\114\x45\104";
        goto Rqtu9;
        ctRYm:
        $sfFoF = $this->customEmail->sendCustomgatewayEmail($kC4Q5, $Ox44O);
        Rqtu9:
        if ($Kwf52) {
            goto CJhXf;
        }
        $NDIFM["\163\164\141\164\165\x73"] = "\x46\101\111\114\x45\104";
        goto oDJDt;
        CJhXf:
        $NDIFM = $this->customSMS->send_customgateway_sms($GCz1G, $Ox44O);
        oDJDt:
        $gxMLC = $this->twofautility->OTP_over_SMSandEMAIL_Message($kC4Q5, $GCz1G, $sfFoF["\x73\x74\x61\164\165\x73"], $NDIFM["\x73\164\141\x74\x75\163"]);
        if ($sfFoF["\163\x74\x61\164\165\x73"] == "\123\x55\x43\103\105\123\123" || $NDIFM["\x73\x74\x61\x74\x75\x73"] == "\x53\x55\x43\103\105\x53\123") {
            goto War8s;
        }
        $SoVFo = array("\163\x74\x61\x74\x75\x73" => "\x46\x41\111\x4c\105\104", "\x6d\145\163\x73\x61\147\x65" => $gxMLC, "\x74\x78\x49\144" => "\x31");
        goto jZdrB;
        War8s:
        $SoVFo = array("\x73\164\x61\164\165\x73" => "\123\x55\103\x43\105\x53\123", "\x6d\x65\x73\x73\141\x67\145" => $gxMLC, "\164\170\x49\x64" => "\61");
        jZdrB:
        JZxcz:
        sZRYF:
        $this->twofautility->setSessionValue(TwoFAConstants::PRE_TRANSACTIONID, $SoVFo["\x74\x78\111\144"]);
        if (isset($SoVFo["\x6d\x65\163\163\141\x67\x65"])) {
            goto p8ioN;
        }
        $C7s8O = NULL;
        goto LKvtR;
        p8ioN:
        $C7s8O = $SoVFo["\x6d\145\x73\163\141\147\145"];
        LKvtR:
        if (!(isset($SoVFo["\163\x74\x61\164\165\163"]) && $SoVFo["\x73\164\x61\164\x75\x73"] === "\x53\x55\x43\103\105\x53\x53")) {
            goto wuUgO;
        }
        $this->twofautility->updateColumnInTable("\155\x69\x6e\x69\157\x72\141\156\x67\x65\x5f\164\146\141\x5f\x75\x73\145\162\x73", "\164\162\x61\x6e\163\141\143\x74\151\157\x6e\111\144", $SoVFo["\x74\x78\x49\x64"], "\x75\163\x65\x72\156\x61\x6d\145", $eO5PP, -1);
        wuUgO:
        Q9uxh:
        if (!(isset($SoVFo["\x73\164\x61\164\x75\163"]) && $SoVFo["\x73\x74\x61\x74\x75\x73"] === "\x46\101\x49\x4c\105\104")) {
            goto VZY52;
        }
        $this->twofautility->log_debug("\x54\x77\157\x46\x41\163\145\x74\164\x69\x6e\147\163\x3a\40\164\x65\x73\x74\40\143\157\x6e\146\151\147\165\162\x61\x74\x69\157\156\x3a\40\x46\x61\151\x6c\145\144");
        $zgYr1 = strtok($_SERVER["\x52\x45\121\x55\x45\123\x54\x5f\125\122\111"], "\x3f") . "\77\155\145\163\163\x61\147\145\75" . $C7s8O . "\x26\162\137\163\164\x61\x74\165\x73\75\x46\101\x49\114\105\104\x26\x74\x65\163\x74\143\x6f\156\x66\x69\x67\75\x74\145\163\x74\143\x6f\x6e\146\x69\147";
        VZY52:
        if (!(isset($SoVFo["\x73\x74\x61\164\165\163"]) && $SoVFo["\163\164\x61\x74\165\x73"] === "\x53\x55\x43\103\x45\123\123")) {
            goto prxb4;
        }
        $this->twofautility->log_debug("\124\167\x6f\106\101\x73\x65\164\x74\x69\156\147\163\72\x20\164\145\x73\164\x20\x63\x6f\x6e\146\x69\147\165\x72\141\x74\151\157\156\x3a\x20\163\x75\x63\x63\145\x73\163");
        $zgYr1 = strtok($_SERVER["\x52\x45\121\x55\x45\x53\x54\137\x55\x52\111"], "\x3f") . "\x3f\143\157\156\146\151\x67\165\x72\145\75" . $NyEmU . "\x26\141\x63\x74\151\x6f\x6e\75\x76\141\x6c\151\x64\x61\x74\145\157\164\x70\46\x74\145\163\164\143\157\156\x66\x69\147\x3d\x74\x65\x73\164\x63\x6f\156\146\x69\147\x26\x6d\x65\x73\x73\141\147\x65\75" . $C7s8O . "\46\162\x5f\163\x74\x61\x74\165\x73\75\123\x55\x43\x43\x45\x53\123";
        prxb4:
        goto KNHLq;
        ZOYgN:
        $zgYr1 = strtok($_SERVER["\x52\x45\121\x55\105\x53\124\137\125\122\111"], "\77") . "\x3f\x73\164\141\x74\x75\163\x3d\145\162\162\x6f\x72";
        KNHLq:
        d3bOq:
        return $zgYr1;
    }
    public function activate_method()
    {
        $tQqCg = $this->twofautility->isCustomerRegistered();
        if ($tQqCg) {
            goto pH1lo;
        }
        $this->messageManager->addSuccessMessage(TwoFAMessages::NOT_REGISTERED);
        return;
        pH1lo:
        $E7rHv = $this->getRequest()->getParams();
        $current_user = $this->twofautility->getCurrentAdminUser();
        $eO5PP = $current_user->getUsername();
        $eJ8ct = $eO5PP;
        $NyEmU = $E7rHv["\101\x63\x74\151\x76\141\164\145\x4d\145\164\x68\157\144\x4e\x61\x6d\145"];
        $CPSBM = $this->twofautility->getAllMoTfaUserDetails("\x6d\151\x6e\x69\x6f\162\x61\156\147\145\137\164\x66\141\137\x75\x73\x65\162\x73", $eO5PP, -1);
        $zgYr1 = '';
        if (is_array($CPSBM) && sizeof($CPSBM) > 0) {
            goto juhE9;
        }
        $zgYr1 = strtok($_SERVER["\122\105\x51\x55\105\123\124\x5f\x55\122\111"], "\77") . "\x3f\x73\164\x61\164\x75\x73\x3d\x65\162\x72\x6f\162";
        goto jUwCm;
        juhE9:
        $NtdWr = $CPSBM[0]["\x63\157\x6e\146\151\147\x75\x72\145\144\x5f\x6d\145\164\x68\x6f\x64\163"];
        if (!str_contains($CPSBM[0]["\143\x6f\x6e\x66\x69\147\165\x72\x65\x64\x5f\155\x65\x74\x68\157\x64\x73"], $NyEmU)) {
            goto nu4pa;
        }
        $t1Co6 = ["\141\x63\x74\151\166\145\137\x6d\145\164\x68\157\x64" => $NyEmU];
        $this->twofautility->updateRowInTable("\155\x69\x6e\x69\x6f\162\x61\x6e\x67\145\x5f\164\x66\x61\137\x75\163\x65\162\163", $t1Co6, "\x75\163\145\162\156\141\155\145", $eJ8ct);
        $zgYr1 = strtok($_SERVER["\122\105\121\125\x45\123\x54\x5f\x55\122\111"], "\77") . "\77\x73\164\x61\x74\x75\x73\x3d\x73\x75\x63\143\145\x73\163";
        goto piDpW;
        nu4pa:
        $zgYr1 = strtok($_SERVER["\x52\105\121\x55\105\x53\x54\137\x55\x52\x49"], "\x3f") . "\77\163\164\141\x74\165\163\x3d\x65\162\x72\x6f\162";
        piDpW:
        jUwCm:
        return $zgYr1;
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_TWOFASETTINGS);
    }
}