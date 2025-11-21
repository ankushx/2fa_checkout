<?php

namespace MiniOrange\TwoFA\Controller\Adminhtml\Customgateway;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use MiniOrange\TwoFA\Controller\Actions\BaseAdminAction;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\CustomSMS;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class Index extends BaseAdminAction implements HttpPostActionInterface, HttpGetActionInterface
{
    protected $request;
    protected $data_array;
    protected $resultFactory;
    protected $customEmail;
    protected $logger;
    protected $customSMS;
    public function __construct(\Magento\Framework\App\RequestInterface $gwdvO, \Magento\Backend\App\Action\Context $FAYCo, \Magento\Framework\View\Result\PageFactory $Y4pqs, \MiniOrange\TwoFA\Helper\TwoFAUtility $IoUED, \Magento\Framework\Message\ManagerInterface $pqe_v, \Psr\Log\LoggerInterface $RDUre, \Magento\Framework\Controller\ResultFactory $VNZUj, CustomEmail $jA23X, CustomSMS $KKycH)
    {
        $this->resultFactory = $VNZUj;
        $this->customEmail = $jA23X;
        $this->logger = $RDUre;
        $this->customSMS = $KKycH;
        $this->request = $gwdvO;
        parent::__construct($FAYCo, $Y4pqs, $IoUED, $pqe_v, $RDUre);
    }
    public function execute()
    {
        $WVWJv = $this->request->getPostValue();
        $E_0F9 = $this->twofautility->getCurrentAdminUser()->getEmail();
        $this->twofautility->isFirstPageVisit($E_0F9, "\x43\x75\x73\x74\157\155\x20\107\141\164\145\x77\141\171");
        if (!$this->isFormOptionBeingSaved($WVWJv)) {
            goto Pn9vM;
        }
        $this->processValuesAndSaveData($WVWJv);
        Pn9vM:
        $JEP50 = $this->resultPageFactory->create();
        $JEP50->getConfig()->getTitle()->prepend(__(TwoFAConstants::MODULE_TITLE));
        return $JEP50;
    }
    private function processValuesAndSaveData($WVWJv)
    {
        $NWXu1 = $this->twofautility->isCustomerRegistered();
        if ($NWXu1) {
            goto X2AUn;
        }
        $this->messageManager->addErrorMessage(TwoFAMessages::NOT_REGISTERED);
        $No1oV = $this->resultRedirectFactory->create();
        $No1oV->setPath("\x6d\x6f\x74\x77\157\x66\141\57\141\143\x63\157\x75\156\x74\57\x69\156\x64\145\x78");
        return $No1oV;
        X2AUn:
        if (!isset($WVWJv["\145\156\x61\142\x6c\145\x5f\105\155\x61\151\154\143\x75\x73\164\157\x6d\x67\141\x74\145\x77\141\x79"])) {
            goto HdoPM;
        }
        $cZ4eE = isset($WVWJv["\145\156\141\142\154\145\x5f\x63\165\x73\x74\157\155\147\x61\164\145\167\x61\171\x5f\146\157\162\x45\155\x61\x69\x6c"]) ? 1 : 0;
        $this->twofautility->setStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, $cZ4eE);
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
        HdoPM:
        if (!isset($WVWJv["\145\x6e\141\x62\x6c\145\x5f\x57\x68\x61\x74\x73\x61\160\x70\x63\x75\x73\164\157\x6d\147\x61\164\x65\x77\x61\171"])) {
            goto Mb8JN;
        }
        $lj9KV = isset($WVWJv["\x63\x75\163\x74\157\x6d\107\x61\164\x65\x77\141\x79\137\167\x68\141\x74\x73\141\160\160"]) ? 1 : 0;
        $this->twofautility->setStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, $lj9KV);
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
        Mb8JN:
        if (!isset($WVWJv["\x65\x6e\141\x62\x6c\145\137\x53\115\123\x63\x75\163\164\x6f\x6d\147\141\164\x65\167\x61\171"])) {
            goto SaD3E;
        }
        $EAX_l = isset($WVWJv["\x65\x6e\x61\x62\x6c\145\x5f\x63\x75\x73\164\157\155\x67\x61\x74\145\167\141\171\137\x66\157\x72\123\115\x53"]) ? 1 : 0;
        $this->twofautility->setStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, $EAX_l);
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
        SaD3E:
        if (!isset($WVWJv["\167\x68\141\164\163\141\160\x70\137\x73\x75\142\x6d\x69\164"])) {
            goto LT2GK;
        }
        $pgaS2 = trim($WVWJv["\160\x68\x6f\156\145\x5f\156\x75\x6d\142\x65\x72\x5f\x69\x64"]);
        $VslQA = trim($WVWJv["\164\145\x6d\160\154\x61\164\145\137\156\141\155\145"]);
        $U4D2h = trim($WVWJv["\141\143\x63\x65\163\163\x5f\164\x6f\x6b\145\156"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::WhATSAPP_PHONE_ID, $pgaS2);
        $this->twofautility->setStoreConfig(TwoFAConstants::WhATSAPP_TEMPLATE_NAME, $VslQA);
        $this->twofautility->setStoreConfig(TwoFAConstants::WhATSAPP_TEMPLATE_LANGUAGE, $WVWJv["\164\145\x6d\160\154\141\x74\145\137\x6c\x61\156\147\x75\141\147\x65"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::WhATSAPP_ACCESS_TOKEN, $U4D2h);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_OTP_LENGTH, $WVWJv["\x6f\164\160\x5f\154\x65\156\147\164\x68"]);
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
        $this->messageManager->addSuccessMessage("\127\x68\x61\164\163\141\x70\x70\x20\x42\x75\163\x69\156\x65\163\x73\x20\x61\x63\143\157\165\x6e\164\x20\163\x61\166\145\40\163\x75\x63\143\145\x73\x66\x75\154\154\x79");
        LT2GK:
        if (!isset($WVWJv["\167\x68\141\164\163\141\x70\x70\137\163\x75\x62\155\151\164\x5f\x64\145\154\x65\x74\145"])) {
            goto zX9g_;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::WhATSAPP_PHONE_ID, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::WhATSAPP_TEMPLATE_NAME, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::WhATSAPP_TEMPLATE_LANGUAGE, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::WhATSAPP_ACCESS_TOKEN, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, NULL);
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
        $this->messageManager->addSuccessMessage("\103\x75\162\162\x65\156\164\40\x57\x68\x61\164\163\141\x70\x70\x20\x42\165\163\x69\x6e\145\x73\163\40\141\x63\x63\x6f\x75\x6e\x74\40\144\145\154\x65\164\145\x64\x20\163\165\x63\x63\x65\x73\146\165\x6c\154\171");
        zX9g_:
        if (!isset($WVWJv["\x74\x65\x73\x74\x5f\163\x6d\163\137\167\150\141\164\163\141\x70\x70"])) {
            goto bCsZ4;
        }
        $JwQC5 = trim($WVWJv["\x63\165\163\164\157\x6d\137\x67\x61\164\x65\167\141\x79\137\x74\145\163\164\137\x6d\157\142\151\154\x65\x4e\x75\x6d\142\145\162\x5f\167\x68\x61\x74\163\141\x70\160"]);
        $zJpPI = $this->twofautility->Customgateway_GenerateOTP();
        $KT5VP = $this->twofautility->send_customgateway_whatsapp($JwQC5, $zJpPI);
        if ($KT5VP !== null) {
            goto OG2jL;
        }
        $this->messageManager->addErrorMessage("\105\162\x72\157\x72\40\157\x63\143\165\162\x72\145\x64\x20\167\x68\x69\x6c\145\x20\x73\145\156\x64\x69\x6e\147\x20\117\x54\x50");
        goto v3kzV;
        OG2jL:
        if ($KT5VP["\163\x74\141\164\x75\x73"] == "\x53\x55\x43\x43\x45\x53\123") {
            goto EoA22;
        }
        if ($KT5VP["\163\164\x61\x74\165\163"] == "\x46\x41\x49\x4c\x45\104" && isset($KT5VP["\x6d\145\163\163\141\x67\x65"])) {
            goto mReTE;
        }
        $this->messageManager->addErrorMessage("\x55\x6e\153\x6e\x6f\x77\156\40\145\162\162\x6f\x72\x20\x6f\x63\143\x75\x72\x72\145\144");
        goto I0TMS;
        EoA22:
        $this->messageManager->addSuccessMessage("\x4f\124\120\40\x73\145\156\x74\40\x73\x75\x63\x63\145\x73\163\146\x75\x6c\x6c\x79");
        goto I0TMS;
        mReTE:
        $T8Dqe = $KT5VP["\x6d\145\x73\163\141\147\145"];
        $this->messageManager->addErrorMessage($T8Dqe);
        I0TMS:
        v3kzV:
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TEST_PHONE_NO, $WVWJv["\143\165\x73\x74\157\x6d\137\x67\x61\164\145\x77\141\171\x5f\x74\145\163\x74\137\155\157\142\x69\154\x65\x4e\x75\155\142\145\x72\x5f\167\150\141\x74\163\141\160\160"]);
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
        bCsZ4:
        if (!isset($WVWJv["\x65\155\141\x69\x6c\137\x73\165\x62\155\x69\164"])) {
            goto VEZic;
        }
        $this->twofautility->flushCache();
        $this->messageManager->addSuccessMessage(TwoFAMessages::SETTINGS_SAVED);
        $this->twofautility->reinitConfig();
        VEZic:
        if (!isset($WVWJv["\x74\145\163\x74\137\x65\155\141\151\154"])) {
            goto D8TEq;
        }
        $FmVbC = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_EMAIL_FROM);
        $GukdS = trim($WVWJv["\x63\165\163\x74\157\155\x5f\x67\x61\x74\x65\167\x61\x79\x5f\x73\145\x6e\144\x5f\x74\157"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_SEND_TO, $GukdS);
        $this->twofautility->flushCache();
        $F7rIo = $GukdS;
        $zJpPI = $this->twofautility->Customgateway_GenerateOTP();
        $KT5VP = $this->customEmail->sendCustomgatewayEmail($F7rIo, $zJpPI);
        if ($KT5VP["\163\x74\x61\x74\165\163"] == "\123\x55\103\x43\x45\123\123") {
            goto m6x3z;
        }
        if (isset($KT5VP["\x74\145\x63\x68\x5f\155\145\163\x73\x61\147\x65"])) {
            goto LWm1u;
        }
        $this->messageManager->addErrorMessage($KT5VP["\106\141\151\x6c\145\x64\40\x74\157\40\163\x65\156\144\x20\x4f\x54\120"]);
        goto ZQr1z;
        LWm1u:
        $this->messageManager->addErrorMessage($KT5VP["\164\145\143\150\x5f\x6d\145\163\163\141\x67\145"]);
        ZQr1z:
        goto dbpPq;
        m6x3z:
        $this->messageManager->addSuccessMessage("\157\164\x70\40\163\145\156\164\x20\163\x75\143\143\145\163\x73\146\165\154\154\x79");
        dbpPq:
        D8TEq:
        if (isset($WVWJv["\163\x6d\163\x5f\x73\x75\x62\x6d\x69\x74"])) {
            goto hNY0x;
        }
        if (isset($WVWJv["\163\x6d\x73\x5f\x73\165\x62\x6d\151\x74\137\144\x65\154\145\x74\145"])) {
            goto ZA8dy;
        }
        if (isset($WVWJv["\143\154\x65\x61\x72\x5f\x70\x6f\x73\x74\x53\115\123\120\141\x72\x61\x6d\137\x66\151\145\x6c\144"])) {
            goto ZPTSG;
        }
        if (isset($WVWJv["\164\145\163\164\137\x73\x6d\163"])) {
            goto OFUA2;
        }
        goto MTPs1;
        hNY0x:
        $L_nmO = $this->request->getParams();
        $RjbRl = isset($WVWJv["\143\165\x73\164\x6f\x6d\137\x67\141\164\145\x77\141\x79\x5f\141\160\x69\x50\x72\x6f\166\151\144\x65\162\137\163\155\163"]) ? trim($WVWJv["\143\x75\163\x74\x6f\155\x5f\x67\x61\164\x65\167\x61\x79\x5f\141\160\151\120\x72\157\x76\x69\144\145\x72\137\x73\155\163"]) : '';
        if (!($RjbRl === "\x74\x77\151\154\x69\157")) {
            goto EYIdo;
        }
        $AADzz = isset($WVWJv["\x63\x75\x73\164\157\x6d\x5f\147\141\x74\x65\167\x61\x79\137\x74\x77\151\x6c\x69\157\137\x73\x69\x64"]) ? trim($WVWJv["\143\x75\163\x74\157\x6d\137\x67\x61\x74\145\x77\x61\x79\137\164\167\x69\x6c\x69\x6f\137\x73\x69\x64"]) : '';
        $HV2EW = isset($WVWJv["\143\x75\x73\x74\x6f\155\x5f\147\x61\x74\145\x77\141\171\x5f\164\167\x69\x6c\x69\157\137\x74\157\153\x65\156"]) ? trim($WVWJv["\x63\x75\163\164\x6f\155\137\x67\x61\164\x65\x77\x61\x79\137\x74\x77\151\154\x69\x6f\137\x74\x6f\x6b\145\x6e"]) : '';
        $I6c6e = isset($WVWJv["\x63\x75\x73\164\157\x6d\x5f\x67\141\164\145\x77\x61\x79\x5f\164\167\151\x6c\151\157\x5f\160\150\137\x6e\x75\x6d\142\x65\162"]) ? trim($WVWJv["\x63\165\163\x74\x6f\x6d\x5f\x67\141\164\145\x77\141\171\x5f\164\x77\x69\154\151\x6f\137\x70\150\137\156\x75\x6d\142\145\x72"]) : '';
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TWILIO_SID, $AADzz);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TWILIO_TOKEN, $HV2EW);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TWILIO_NUMBER, $I6c6e);
        EYIdo:
        if (!($RjbRl === "\x67\x65\164\115\x65\x74\x68\157\144")) {
            goto NyBXC;
        }
        $ULUs4 = isset($WVWJv["\x63\165\163\164\x6f\155\137\x67\141\164\145\167\x61\171\x5f\147\x65\x74\x6d\145\164\150\157\144\x55\x52\x4c"]) ? trim($WVWJv["\143\x75\x73\164\x6f\x6d\137\x67\x61\x74\145\x77\x61\171\x5f\147\x65\x74\x6d\x65\164\x68\157\x64\x55\122\x4c"]) : '';
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_GETMETHOD_URL, $ULUs4);
        NyBXC:
        if (!($RjbRl === "\160\157\163\x74\115\145\164\150\157\x64")) {
            goto ON0W2;
        }
        $tlmXI = isset($WVWJv["\x63\165\x73\x74\x6f\155\137\x67\x61\x74\145\x77\141\171\137\x70\x6f\163\x74\155\145\x74\x68\157\x64\x55\x52\x4c"]) ? trim($WVWJv["\143\x75\x73\x74\157\x6d\137\x67\x61\x74\x65\167\x61\171\x5f\x70\x6f\163\164\x6d\x65\x74\150\x6f\144\x55\122\114"]) : '';
        $Znwu5 = isset($WVWJv["\160\157\163\x74\137\x6d\145\x74\150\157\144\x5f\x70\x68\157\156\145\137\x61\164\x74\x72"]) ? trim($WVWJv["\160\157\x73\164\137\155\145\164\x68\157\144\x5f\160\x68\x6f\x6e\x65\x5f\141\164\164\162"]) : '';
        $Cck1r = isset($WVWJv["\x70\157\x73\x74\137\155\145\164\150\157\x64\137\155\x65\163\163\141\147\x65\137\141\x74\x74\x72"]) ? trim($WVWJv["\160\157\163\x74\137\155\x65\x74\150\x6f\144\x5f\155\145\163\163\x61\x67\145\137\141\x74\x74\162"]) : '';
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_POSTMETHOD_URL, $tlmXI);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_POST_PHONE_ATTR, $Znwu5);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_POST_MESSAGE_ATTR, $Cck1r);
        $aZZ0J = isset($WVWJv["\x64\171\156\x61\x6d\x69\143\x5f\141\164\x74\162\151\142\x75\164\x65\163"]) ? $WVWJv["\144\x79\x6e\141\155\151\x63\137\141\164\164\162\x69\x62\165\164\x65\x73"] : [];
        $Q5jIC = array_filter(array_map(function ($mR1Ux) {
            return !empty($mR1Ux["\156\141\155\x65"]) && !empty($mR1Ux["\166\141\154\165\145"]) ? ["\156\x61\x6d\145" => trim($mR1Ux["\156\x61\x6d\145"]), "\x76\x61\x6c\165\x65" => trim($mR1Ux["\x76\141\154\165\x65"])] : null;
        }, $aZZ0J));
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_DYNAMIC_ATTRIBUTES, json_encode($Q5jIC));
        ON0W2:
        $this->twofautility->setStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, true);
        $C51ux = isset($WVWJv["\x63\x75\163\x74\x6f\155\107\x61\164\145\x77\x61\x79\x5f\x6d\145\163\x73\141\147\145\137\123\115\123\x63\157\x6e\x66\x69\x67\x75\162\x61\164\x69\x6f\156"]) ? trim($WVWJv["\143\x75\x73\x74\x6f\155\107\141\164\145\x77\141\171\137\155\145\163\163\141\x67\145\137\123\115\123\143\x6f\x6e\146\x69\147\x75\x72\141\x74\151\x6f\x6e"]) : '';
        $QKLk3 = isset($WVWJv["\143\x75\163\x74\157\x6d\107\x61\x74\145\x77\x61\x79\x5f\157\x74\160\x4c\x65\156\147\164\x68\137\x63\157\156\146\x69\x67\165\x72\x61\164\151\157\x6e"]) ? trim($WVWJv["\x63\x75\x73\x74\x6f\155\107\141\164\x65\167\x61\x79\137\x6f\x74\x70\x4c\145\x6e\147\164\x68\x5f\x63\x6f\156\x66\x69\147\x75\x72\x61\x74\x69\x6f\156"]) : '';
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_SMS_MESSAGE, $C51ux);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_OTP_LENGTH, $QKLk3);
        $edsKz = ["\x66\157\162\155\137\x6b\145\171", "\x63\165\x73\x74\x6f\x6d\x5f\x67\141\164\x65\167\141\171\137\x61\x70\151\120\x72\x6f\x76\151\x64\145\x72\x5f\163\x6d\x73", "\x63\x75\x73\164\x6f\x6d\x5f\x67\141\x74\145\x77\x61\x79\x5f\164\x77\x69\154\151\x6f\x5f\163\x69\x64", "\x63\x75\x73\x74\x6f\155\137\147\141\164\145\167\141\x79\x5f\x74\x77\x69\154\x69\x6f\x5f\x74\x6f\153\145\156", "\143\165\163\164\157\155\137\147\x61\x74\x65\167\x61\x79\137\x74\x77\151\154\151\157\137\x70\150\137\x6e\165\x6d\x62\145\162", "\143\165\163\164\x6f\x6d\x5f\147\x61\164\145\x77\141\x79\137\147\145\x74\155\145\x74\x68\x6f\144\x55\x52\x4c", "\143\165\163\x74\x6f\155\x5f\x67\x61\x74\145\167\x61\x79\x5f\x70\x6f\x73\x74\155\x65\x74\150\157\144\125\x52\114", "\160\x6f\x73\x74\x5f\155\145\164\150\157\144\137\160\150\x6f\x6e\145\x5f\x61\x74\x74\x72", "\160\x6f\163\x74\137\155\145\164\150\x6f\x64\137\155\145\163\x73\x61\147\145\137\141\164\x74\x72", "\163\155\x73\x5f\x73\x75\x62\x6d\x69\164", "\x6b\145\x79"];
        $W_AVg = $L_nmO;
        foreach ($edsKz as $twtyr) {
            unset($W_AVg[$twtyr]);
            fsZyl:
        }
        GSooV:
        $Aywrw = json_encode($W_AVg, true);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_POST_FIELD, $Aywrw);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_API_PROVIDER, $RjbRl);
        $this->twofautility->flushCache();
        $this->messageManager->addSuccessMessage(TwoFAMessages::SETTINGS_SAVED);
        $this->twofautility->reinitConfig();
        goto MTPs1;
        ZA8dy:
        $L_nmO = $this->request->getParams();
        $RjbRl = isset($WVWJv["\143\165\163\164\157\155\x5f\147\x61\164\145\167\x61\x79\137\x61\x70\151\120\162\x6f\x76\x69\x64\x65\162\137\x73\x6d\x73"]) ? trim($WVWJv["\x63\x75\163\x74\157\x6d\x5f\147\141\164\145\x77\141\171\x5f\141\160\x69\120\162\x6f\166\x69\x64\x65\x72\137\163\155\x73"]) : '';
        $this->twofautility->setStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, NULL);
        if (!($RjbRl === "\164\x77\x69\154\x69\x6f")) {
            goto oN8iV;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TWILIO_SID, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TWILIO_TOKEN, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TWILIO_NUMBER, NULL);
        oN8iV:
        if (!($RjbRl === "\x67\x65\164\115\x65\164\x68\157\144")) {
            goto VPsoX;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_GETMETHOD_URL, NULL);
        VPsoX:
        if (!($RjbRl === "\160\157\163\164\x4d\145\x74\x68\157\144")) {
            goto TCX_F;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_POSTMETHOD_URL, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_POST_PHONE_ATTR, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_POST_MESSAGE_ATTR, NULL);
        $aZZ0J = isset($WVWJv["\144\x79\x6e\141\x6d\151\143\137\x61\x74\x74\x72\151\x62\165\164\x65\x73"]) ? $WVWJv["\144\171\156\141\x6d\x69\143\x5f\x61\x74\164\162\151\x62\165\x74\x65\163"] : [];
        $Q5jIC = array_filter(array_map(function ($mR1Ux) {
            return !empty($mR1Ux["\x6e\141\155\145"]) && !empty($mR1Ux["\x76\x61\x6c\165\145"]) ? ["\156\141\155\x65" => trim($mR1Ux["\x6e\x61\155\x65"]), "\x76\141\154\x75\x65" => trim($mR1Ux["\x76\141\x6c\165\x65"])] : null;
        }, $aZZ0J));
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_DYNAMIC_ATTRIBUTES, json_encode(NULL));
        TCX_F:
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TEST_PHONE_NO, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_SMS_MESSAGE, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_OTP_LENGTH, NULL);
        $edsKz = ["\146\x6f\162\x6d\137\x6b\x65\x79", "\x63\x75\x73\x74\x6f\x6d\x5f\x67\x61\x74\145\x77\141\x79\x5f\x61\160\x69\120\x72\x6f\166\x69\x64\145\x72\137\163\x6d\x73", "\x63\165\x73\164\157\x6d\137\x67\141\164\145\x77\141\x79\x5f\164\x77\151\154\x69\157\137\x73\151\x64", "\143\165\163\x74\157\155\x5f\147\x61\164\145\x77\141\171\x5f\164\x77\151\x6c\151\x6f\x5f\164\x6f\153\145\x6e", "\143\165\163\x74\157\x6d\137\147\141\x74\x65\x77\141\x79\137\164\167\x69\x6c\x69\x6f\137\160\x68\x5f\156\x75\x6d\x62\145\162", "\143\165\163\164\157\155\137\147\141\164\x65\x77\141\171\x5f\147\145\x74\x6d\x65\x74\x68\x6f\x64\x55\x52\x4c", "\x63\x75\x73\x74\x6f\155\x5f\x67\x61\x74\145\x77\141\x79\x5f\160\x6f\x73\164\155\145\x74\150\157\x64\x55\x52\114", "\160\x6f\x73\164\137\155\145\x74\150\157\x64\137\x70\150\x6f\156\145\137\x61\x74\164\162", "\x70\x6f\x73\164\x5f\x6d\145\164\x68\x6f\x64\x5f\x6d\145\163\x73\141\147\x65\x5f\x61\x74\x74\162", "\x73\x6d\163\x5f\x73\x75\x62\155\x69\x74", "\x6b\145\x79"];
        $W_AVg = $L_nmO;
        foreach ($edsKz as $twtyr) {
            unset($W_AVg[$twtyr]);
            azKTR:
        }
        q0vSH:
        $Aywrw = json_encode($W_AVg, true);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_POST_FIELD, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_API_PROVIDER, $RjbRl);
        $this->twofautility->flushCache();
        $this->messageManager->addSuccessMessage("\x53\145\164\164\151\x6e\147\x73\40\x64\x65\x6c\145\164\x65\144\40\x73\x75\x63\x63\x65\163\163\x66\x75\x6c\154\171\56");
        $this->twofautility->reinitConfig();
        goto MTPs1;
        ZPTSG:
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_POST_FIELD, NULL);
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
        goto MTPs1;
        OFUA2:
        $JwQC5 = trim($WVWJv["\x63\165\x73\164\157\x6d\137\147\x61\x74\145\x77\x61\171\x5f\164\145\x73\164\x5f\155\x6f\x62\151\154\145\x4e\x75\x6d\x62\x65\162"]);
        $zJpPI = $this->twofautility->Customgateway_GenerateOTP();
        $KT5VP = $this->customSMS->send_customgateway_sms($JwQC5, $zJpPI);
        if ($KT5VP["\163\164\x61\164\x75\x73"] == "\123\125\x43\x43\105\123\x53") {
            goto AEm20;
        }
        if (isset($KT5VP["\164\145\x63\x68\x5f\155\x65\x73\163\x61\x67\145"])) {
            goto F071x;
        }
        $this->messageManager->addErrorMessage($KT5VP["\x46\x61\151\154\145\x64\40\164\x6f\40\x73\x65\x6e\x64\40\x4f\x54\x50"]);
        goto k_wm4;
        F071x:
        $this->messageManager->addErrorMessage($KT5VP["\x74\x65\x63\150\137\x6d\x65\163\x73\x61\x67\x65"]);
        k_wm4:
        goto yqdSg;
        AEm20:
        $this->messageManager->addSuccessMessage("\157\164\160\40\x73\x65\x6e\164\40\x73\165\143\143\145\x73\x73\x66\x75\154\x6c\171");
        yqdSg:
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TEST_PHONE_NO, $WVWJv["\x63\165\x73\164\157\x6d\137\147\x61\x74\x65\167\141\x79\x5f\164\x65\163\x74\x5f\x6d\x6f\x62\151\154\x65\x4e\x75\x6d\142\x65\162"]);
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
        MTPs1:
        if (!isset($WVWJv["\143\x75\163\x74\157\x6d\x67\x61\164\x65\167\x61\171\x5f\x65\x6d\x61\x69\x6c\103\x6f\x6e\146\151\x67\x75\162\141\x74\x69\x6f\156"])) {
            goto Xn17I;
        }
        $sPo7I = trim($WVWJv["\143\165\x73\164\157\155\137\x67\141\164\x65\x77\x61\171\x5f\x68\x6f\x73\164\x6e\141\x6d\145"]);
        $Jfbx9 = trim($WVWJv["\143\165\163\164\x6f\155\137\x67\141\x74\x65\x77\141\x79\137\160\157\162\x74"]);
        $GcJJh = trim($WVWJv["\143\165\163\x74\157\x6d\x5f\147\x61\x74\x65\167\x61\171\137\x75\x73\145\x72\156\141\155\x65"]);
        $OgEAt = trim($WVWJv["\143\165\x73\x74\157\x6d\x5f\x67\141\164\x65\x77\141\171\x5f\x70\x61\x73\x73\167\x6f\162\x64"]);
        $kVPO6 = trim($WVWJv["\143\x75\x73\x74\x6f\155\x47\x61\x74\145\167\x61\171\x5f\146\162\157\x6d\x5f\x63\x6f\x6e\x66\151\x67\165\162\x61\164\151\157\156"]);
        $OKe3L = trim($WVWJv["\143\x75\x73\x74\157\155\107\141\x74\145\167\x61\171\x5f\156\141\155\x65\137\x63\157\x6e\x66\x69\x67\165\162\141\164\x69\157\156"]);
        $KZ8rm = isset($WVWJv["\x65\155\x61\x69\x6c\x5f\164\145\x6d\x70\x6c\141\164\x65"]) ? $WVWJv["\145\x6d\x61\151\154\137\164\145\155\160\x6c\x61\x74\x65"] : NULL;
        $this->twofautility->setStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_HOSTNAME, $sPo7I);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_PORT, $Jfbx9);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_PROTOCOL, $WVWJv["\x63\165\x73\164\x6f\x6d\x5f\x67\141\x74\x65\167\141\171\137\160\162\x6f\x74\x6f\143\x6f\x6c"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_AUTHENTICATION, $WVWJv["\x63\165\x73\164\x6f\x6d\137\147\141\x74\145\x77\x61\171\137\x61\165\x74\x68\x65\x6e\x74\151\x63\141\x74\x69\x6f\156"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_USERNAME, $GcJJh);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_PASSWORD, $OgEAt);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_EMAIL_FROM, $kVPO6);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_EMAIL_NAME, $OKe3L);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_OTP_LENGTH, $WVWJv["\x63\165\x73\x74\157\x6d\107\141\x74\145\167\x61\171\x5f\x6f\x74\x70\114\145\x6e\x67\x74\x68\137\143\x6f\156\x66\151\147\165\162\141\164\151\x6f\x6e"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::SELECTED_TEMPLATE_ID, $KZ8rm);
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
        $this->messageManager->addSuccessMessage(TwoFAMessages::SETTINGS_SAVED);
        Xn17I:
        if (!isset($WVWJv["\x63\165\163\164\x6f\x6d\147\141\x74\x65\167\141\x79\x5f\145\x6d\141\151\x6c\103\x6f\x6e\x66\151\147\x75\162\141\164\x69\x6f\156\137\x64\145\154\x65\x74\x65"])) {
            goto DmGNY;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_HOSTNAME, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_PORT, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_PROTOCOL, $WVWJv["\x63\x75\163\x74\157\155\137\x67\x61\164\145\167\141\171\x5f\x70\162\157\x74\x6f\143\157\x6c"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_AUTHENTICATION, $WVWJv["\x63\165\x73\x74\x6f\155\x5f\147\x61\164\x65\x77\x61\x79\x5f\141\165\164\150\145\156\x74\x69\143\x61\x74\x69\x6f\x6e"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_USERNAME, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_PASSWORD, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_EMAIL_FROM, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_EMAIL_NAME, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_OTP_LENGTH, $WVWJv["\143\x75\163\164\x6f\155\x47\141\x74\x65\167\x61\171\x5f\x6f\x74\x70\x4c\x65\x6e\147\x74\x68\x5f\x63\157\x6e\146\151\147\x75\162\x61\164\151\x6f\156"]);
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
        $this->messageManager->addSuccessMessage("\123\x65\x74\x74\151\156\147\163\x20\x64\145\154\145\164\x65\x64\40\163\x75\x63\x63\145\x73\163\146\x75\154\x6c\x79\56");
        DmGNY:
        if (!isset($WVWJv["\143\x75\163\164\x6f\155\147\141\x74\x65\x77\141\x79\137\163\155\163\x43\157\x6e\x66\151\147\x75\162\141\164\x69\x6f\x6e"])) {
            goto sqGR8;
        }
        $BvYjL = trim($WVWJv["\143\165\163\164\157\155\107\141\164\145\167\141\171\137\155\145\x73\163\141\147\145\137\123\x4d\x53\x63\157\156\146\x69\147\x75\x72\x61\164\x69\157\156"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_SMS_MESSAGE, $BvYjL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMGATEWAY_OTP_LENGTH, $WVWJv["\x63\165\x73\164\157\155\107\141\x74\145\x77\x61\x79\x5f\x6f\164\160\x4c\145\x6e\147\x74\150\x5f\x63\157\156\x66\x69\x67\x75\x72\x61\164\x69\157\x6e"]);
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
        sqGR8:
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_CUSTOM_GATEWAY);
    }
}