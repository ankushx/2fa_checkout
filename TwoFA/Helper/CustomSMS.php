<?php

namespace MiniOrange\TwoFA\Helper;

use Exception;
use Magento\Framework\App\Area;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\Store;
class CustomSMS extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $logger;
    private $twofautility;
    private $clientFactory;
    public function __construct(Context $FhF0S, \MiniOrange\TwoFA\Helper\TwoFAUtility $Hf_g0, StateInterface $sZAQ6)
    {
        parent::__construct($FhF0S);
        $this->twofautility = $Hf_g0;
        $this->inlineTranslation = $sZAQ6;
        $this->logger = $FhF0S->getLogger();
    }
    public function send_customgateway_sms($aXyPJ, $t4gX2)
    {
        $T2WKq = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_API_PROVIDER);
        $this->twofautility->log_debug("\x43\x75\163\x74\x6f\155\123\115\x53\72\101\120\111\40\160\162\157\166\x69\144\145\162\72" . $T2WKq);
        $GBKTQ = array("\163\164\x61\164\x75\163" => "\x46\101\111\x4c\x45\104", "\155\x65\x73\x73\x61\x67\145" => "\x4e\x6f\40\x63\x75\x73\x74\x6f\155\40\147\x61\164\145\x77\141\x79\40\155\145\x74\150\x6f\x64\x20\x63\x6f\x6e\x66\151\x67\165\x72\x65\x64\x20\x66\x6f\x72\x20\x53\115\x53\56", "\x74\170\111\x64" => "\x31", "\x74\145\143\150\137\155\145\163\163\x61\x67\x65" => "\x4e\x6f\x20\x63\x75\x73\x74\157\155\x20\x67\141\x74\x65\x77\x61\171\x20\x6d\145\164\150\x6f\x64\40\143\157\156\x66\x69\x67\x75\162\145\x64\40\x66\x6f\162\40\x53\115\123\56");
        if (!($T2WKq == "\x74\167\x69\x6c\151\157")) {
            goto H0I0F;
        }
        $GBKTQ = $this->send_Twilio_CustomGateway_SMS($aXyPJ, $t4gX2);
        H0I0F:
        if (!($T2WKq == "\147\145\164\115\145\164\x68\x6f\x64")) {
            goto oPPaA;
        }
        $GBKTQ = $this->send_GetMethod_CustomGateway_SMS($aXyPJ, $t4gX2);
        oPPaA:
        if (!($T2WKq == "\x70\x6f\x73\164\x4d\x65\164\x68\157\x64")) {
            goto GsZPO;
        }
        $GBKTQ = $this->send_PostMethod_CustomGateway_SMS($aXyPJ, $t4gX2);
        GsZPO:
        return $GBKTQ;
    }
    public function send_Twilio_CustomGateway_SMS($aXyPJ, $t4gX2)
    {
        $t9sJH = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TWILIO_SID);
        $u6tG5 = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TWILIO_TOKEN);
        $eEO3O = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_TWILIO_NUMBER);
        $dKBTt = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_SMS_MESSAGE);
        if (!is_null($dKBTt)) {
            goto ARDzj;
        }
        $GBKTQ = array("\163\x74\141\164\165\163" => "\106\x41\111\114\105\104", "\x6d\x65\x73\163\141\147\145" => "\x52\145\x63\x69\160\x69\145\156\164\x27\163\x20\x6d\145\163\163\141\147\145\40\x69\163\40\x6e\157\164\40\x73\x65\x74\x2e", "\164\170\111\x64" => "\x31", "\164\x65\143\150\137\x6d\145\163\x73\141\x67\145" => "\x52\145\x63\151\x70\151\x65\156\164\x27\x73\40\x6f\x66\x20\x74\x68\x65\x20\x6d\x65\163\x73\x61\x67\x65\x20\151\x73\x20\x6e\x6f\x74\40\163\x65\164\x2e");
        return $GBKTQ;
        ARDzj:
        $dKBTt = str_replace("\43\x23\117\124\120\x23\x23", $t4gX2, $dKBTt);
        $kcJv8 = "\x78\170\170\x78\x78\170\x78\170" . substr($aXyPJ, -2);
        try {
            $B5ghY = dirname(__DIR__, 5) . "\x2f\x76\145\x6e\144\x6f\162\x2f\164\x77\151\x6c\x69\157\57\x73\x64\153\x2f\163\x72\x63";
            if (is_dir($B5ghY)) {
                goto oyL8r;
            }
            throw new Exception("\x50\154\x65\141\x73\145\40\x69\156\163\164\141\154\x6c\40\x54\x77\x69\x6c\x69\x6f\x20\x73\165\x70\160\157\x72\164\151\x6e\x67\40\146\x69\154\x65\40\x75\x73\151\156\147\x20\146\157\154\x6c\157\167\151\x6e\147\x20\143\x6f\x6d\x6d\x61\156\144\x3a\40\143\x6f\x6d\160\x6f\x73\x65\x72\x20\162\145\x71\x75\x69\162\145\x20\x74\167\151\x6c\x69\157\57\163\x64\x6b");
            goto SPD6u;
            oyL8r:
            $ZvsfF = new \Twilio\Rest\Client($t9sJH, $u6tG5);
            SPD6u:
            $Qmxuq = ["\x66\x72\157\x6d" => $eEO3O, "\x62\x6f\x64\x79" => $dKBTt];
            $ZvsfF->messages->create($aXyPJ, $Qmxuq);
            $GBKTQ = array("\x73\164\x61\164\165\163" => "\123\x55\x43\103\x45\x53\x53", "\155\x65\x73\163\x61\147\145" => "\x54\x68\x65\x20\117\x54\x50\x20\150\141\163\x20\142\x65\145\156\40\x73\x65\156\164\40\164\x6f\x20\171\157\165\162\40\x50\150\x6f\156\x65\72\40" . $kcJv8 . "\56\40\x50\x6c\145\x61\163\145\x20\145\x6e\x74\x65\x72\x20\x74\150\x65\x20\x4f\x54\x50\40\x79\x6f\165\x20\x72\x65\x63\x65\x69\166\145\144\40\164\157\x20\x76\141\154\x69\144\x61\164\x65\x2e", "\x74\170\111\x64" => "\x31");
            return $GBKTQ;
        } catch (\Exception $nk52X) {
            if ($nk52X->getCode() != NULL) {
                goto j1DRU;
            }
            $this->twofautility->log_debug("\103\165\163\x74\157\155\123\115\123\72\124\167\x69\154\151\157\40\163\x75\160\160\x6f\x72\164\x69\x6e\x67\40\146\x69\x6c\x65\40\x69\x73\40\x6e\157\164\x20\x69\156\x73\x74\141\154\154\145\x64\40\165\163\x69\x6e\147\40\143\157\x6d\x70\x6f\163\x65\x72");
            $GBKTQ = array("\x73\164\141\x74\165\163" => "\106\101\x49\x4c\x45\x44", "\x6d\x65\163\163\x61\x67\145" => "\x46\141\154\x69\x65\144\x20\x74\x6f\40\x73\145\x6e\144\x20\117\x54\120\40\164\x6f\x20\171\x6f\x75\x72\40\x50\150\x6f\x6e\x65\x3a\40" . $kcJv8 . "\56\x20\x50\x6c\x65\141\163\145\x20\x43\x6f\x6e\164\141\143\164\x20\131\157\x75\x72\x20\x41\x64\155\151\x6e\151\163\x74\x72\x61\x74\x6f\162\x2e", "\164\170\x49\144" => "\61", "\164\x65\143\150\x5f\155\145\x73\x73\x61\147\x65" => $nk52X->getMessage());
            return $GBKTQ;
            goto lNJAl;
            j1DRU:
            $this->twofautility->log_debug("\x43\165\163\x74\157\x6d\x53\x4d\123\72\x54\x77\x69\154\151\x6f\x20\72\x66\x61\x69\x6c\145\144\x20\164\157\x20\163\x65\x6e\x64\40\x73\x6d\x73");
            $GBKTQ = array("\x73\164\x61\x74\165\163" => "\106\101\x49\114\105\104", "\155\145\x73\163\x61\147\x65" => "\106\141\154\x69\145\x64\x20\164\157\x20\x73\145\156\144\x20\x4f\x54\120\x20\164\157\40\x79\157\x75\x72\40\x50\x68\157\156\145\x3a\40" . $kcJv8 . "\56\40\x50\154\145\141\x73\145\x20\103\157\x6e\x74\x61\x63\164\x20\131\157\x75\162\x20\x41\x64\x6d\x69\156\x69\163\164\162\x61\x74\157\x72\56", "\164\170\x49\144" => "\x31", "\x74\145\x63\150\x5f\155\145\163\x73\x61\x67\145" => "\105\162\162\x6f\x72\40\143\x6f\144\x65\40\146\157\x72\40\x54\167\151\154\x69\x6f\72" . $nk52X->getCode());
            return $GBKTQ;
            lNJAl:
        }
    }
    public function send_GetMethod_CustomGateway_SMS($aXyPJ, $t4gX2)
    {
        $TNxg1 = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_GETMETHOD_URL);
        $dKBTt = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_SMS_MESSAGE);
        if (!(is_null($TNxg1) || is_null($dKBTt))) {
            goto tRDLa;
        }
        $GBKTQ = array("\163\x74\x61\x74\x75\163" => "\106\x41\111\114\105\104", "\x6d\145\163\x73\141\147\x65" => "\x53\x4d\123\x20\103\157\x6e\x66\x69\147\165\x72\141\164\x69\x6f\x6e\x20\151\x73\40\156\x6f\x74\x20\x73\145\x74\40\160\x72\x6f\x70\145\162\154\x79\56", "\x74\170\x49\144" => "\x31", "\x74\145\x63\x68\137\155\x65\163\x73\141\147\145" => "\123\115\x53\40\103\157\156\146\151\147\165\162\141\164\151\x6f\x6e\40\x69\x73\x20\x6e\157\164\x20\163\x65\164\x20\160\162\x6f\x70\x65\162\x6c\171\56");
        return $GBKTQ;
        tRDLa:
        $dKBTt = str_replace("\x23\43\117\x54\x50\43\x23", $t4gX2, $dKBTt);
        $kcJv8 = "\170\170\170\x78\x78\x78\170\x78" . substr($aXyPJ, -2);
        $dKBTt = str_replace("\40", "\x2b", $dKBTt);
        $TNxg1 = str_replace("\43\43\155\145\163\x73\x61\147\x65\43\43", $dKBTt, $TNxg1);
        $TNxg1 = str_replace("\43\x23\160\x68\157\x6e\145\x23\43", $aXyPJ, $TNxg1);
        $om2P3 = [];
        $yfwBl = ["\103\157\156\x74\x65\156\x74\55\124\x79\160\145\x3a\x20\x61\160\x70\x6c\151\x63\141\x74\x69\157\156\x2f\x6a\x73\157\156"];
        $SlvjY = Curl::CustomGateway_SMS_callAPI($TNxg1, $om2P3, $yfwBl);
        $SlvjY = json_decode($SlvjY, true);
        if (isset($SlvjY["\155\145\163\x73\141\147\x65\163"][0]["\163\x74\141\164\x75\163"]) && $SlvjY["\x6d\x65\x73\x73\x61\x67\145\x73"][0]["\163\x74\141\164\165\163"] == "\60") {
            goto GaA_j;
        }
        if (isset($SlvjY["\x6d\x65\163\x73\x61\x67\145\x73"][0]["\x65\x72\x72\x6f\162\55\164\145\170\164"])) {
            goto wdbb_;
        }
        $GBKTQ = array("\x73\164\141\x74\x75\x73" => "\x46\101\x49\x4c\105\x44", "\155\x65\163\x73\141\x67\x65" => "\106\141\x6c\151\x65\144\40\x74\x6f\40\163\x65\156\x64\40\x4f\x54\x50\x20\x74\x6f\40\171\x6f\165\162\x20\x50\x68\x6f\x6e\x65\72\x20" . $kcJv8 . "\x2e\40\120\154\x65\x61\x73\145\40\103\157\x6e\164\x61\143\x74\x20\131\157\165\x72\x20\101\144\155\x69\156\x69\163\164\162\141\x74\157\x72\x2e", "\164\170\x49\x64" => "\x31", "\x74\x65\143\150\137\155\x65\163\163\141\147\145" => "\106\141\x69\154\x65\144\40\x74\x6f\x20\163\x65\x6e\x64\40\117\124\x50");
        goto jepsu;
        GaA_j:
        $GBKTQ = array("\x73\x74\x61\164\165\x73" => "\x53\125\103\x43\x45\x53\123", "\155\145\163\163\x61\147\x65" => "\x54\x68\x65\x20\x4f\x54\x50\x20\150\141\x73\40\142\145\x65\156\x20\163\145\x6e\164\x20\164\x6f\40\x79\157\x75\x72\x20\x50\x68\157\156\145\72\40" . $kcJv8 . "\56\x20\120\154\145\141\x73\x65\x20\145\156\x74\145\162\x20\x74\x68\145\x20\117\124\120\x20\171\x6f\x75\x20\x72\x65\x63\x65\151\166\x65\144\x20\164\157\x20\166\141\x6c\151\x64\x61\164\145\56", "\x74\170\111\144" => "\61");
        goto jepsu;
        wdbb_:
        $this->twofautility->log_debug("\103\165\x73\164\157\x6d\123\115\x53\72\x53\x4d\x53\40\120\x6f\x73\x74\115\145\x74\x68\157\x64\x20\145\x72\162\x6f\x72\x20\143\x6f\144\x65\x3a");
        $GBKTQ = array("\163\x74\x61\x74\165\x73" => "\106\x41\111\114\x45\x44", "\155\x65\163\163\141\x67\145" => "\106\x61\x6c\x69\145\x64\40\164\157\x20\x73\x65\156\144\x20\x4f\124\120\x20\164\x6f\x20\171\157\x75\x72\x20\x50\x68\157\x6e\145\72\40" . $kcJv8 . "\56\x20\x50\x6c\145\141\x73\x65\x20\x43\x6f\156\x74\x61\143\164\x20\x59\x6f\165\162\x20\x41\x64\x6d\151\x6e\151\x73\164\162\x61\164\x6f\162\56", "\164\x78\111\144" => "\x31", "\164\x65\143\x68\137\x6d\145\163\x73\141\x67\x65" => $SlvjY["\155\x65\x73\x73\x61\x67\x65\163"][0]["\145\162\162\x6f\x72\x2d\164\x65\170\164"]);
        jepsu:
        return $GBKTQ;
    }
    public function send_PostMethod_CustomGateway_SMS($aXyPJ, $t4gX2)
    {
        $TNxg1 = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_POSTMETHOD_URL);
        $RShQ6 = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_POST_FIELD);
        $Rw1xr = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_POST_PHONE_ATTR);
        $lP8Nz = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_POST_MESSAGE_ATTR);
        $dKBTt = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_SMS_MESSAGE);
        if (!(is_null($TNxg1) || is_null($dKBTt) || is_null($RShQ6) || is_null($Rw1xr) || is_null($lP8Nz))) {
            goto DHJl_;
        }
        $GBKTQ = array("\163\164\x61\x74\165\x73" => "\x46\101\111\114\x45\104", "\x6d\x65\x73\163\x61\x67\x65" => "\123\115\123\40\103\x6f\x6e\x66\x69\x67\x75\162\141\164\151\157\156\40\x69\163\x20\x6e\157\x74\x20\163\145\164\x20\x70\162\x6f\x70\145\162\x6c\x79\56", "\x74\x78\111\144" => "\x31", "\164\x65\143\150\137\155\145\x73\x73\x61\x67\145" => "\x53\115\123\40\x43\157\156\x66\151\x67\x75\162\x61\x74\x69\157\x6e\x20\151\163\40\156\x6f\x74\x20\x73\x65\x74\x20\x70\162\x6f\x70\x65\x72\154\x79\x2e");
        return $GBKTQ;
        DHJl_:
        $om2P3 = json_decode($RShQ6, true);
        $dKBTt = str_replace("\43\x23\117\x54\x50\x23\x23", $t4gX2, $dKBTt);
        $kcJv8 = "\170\x78\170\x78\x78\170\x78\x78" . substr($aXyPJ, -2);
        $om2P3[$Rw1xr] = $aXyPJ;
        $om2P3[$lP8Nz] = $dKBTt;
        $yfwBl = ["\103\157\x6e\164\145\156\x74\55\124\171\x70\145\72\x20\x61\x70\160\154\151\x63\141\x74\151\157\156\x2f\152\163\x6f\156"];
        $SlvjY = Curl::CustomGateway_SMS_callAPI($TNxg1, $om2P3, $yfwBl);
        $SlvjY = json_decode($SlvjY, true);
        if (isset($SlvjY["\155\145\163\163\141\x67\145\x73"][0]["\x73\x74\x61\x74\165\x73"]) && $SlvjY["\155\145\x73\x73\141\x67\145\x73"][0]["\x73\164\141\164\165\x73"] == "\60") {
            goto KsPmt;
        }
        if (isset($SlvjY["\x6d\x65\x73\163\141\x67\145\163"][0]["\145\x72\x72\x6f\162\55\x74\145\x78\x74"])) {
            goto yIrHM;
        }
        $GBKTQ = array("\x73\x74\141\x74\x75\x73" => "\106\x41\111\114\x45\104", "\155\145\x73\163\x61\x67\x65" => "\x46\x61\154\x69\x65\x64\40\164\x6f\40\x73\145\156\144\x20\117\x54\x50\x20\164\157\x20\x79\x6f\165\162\40\120\x68\x6f\x6e\145\72\40" . $kcJv8 . "\x2e\40\x50\154\145\141\x73\145\x20\x43\157\x6e\x74\x61\x63\164\x20\x59\157\x75\x72\40\101\x64\x6d\151\156\x69\163\164\162\x61\164\157\x72\x2e", "\x74\170\111\144" => "\x31", "\164\x65\x63\150\x5f\x6d\x65\163\163\x61\147\x65" => "\x46\x61\x69\x6c\x65\144\x20\x74\157\40\163\x65\156\x64\40\x4f\124\x50");
        goto gjWF2;
        KsPmt:
        $this->twofautility->log_debug("\103\165\x73\x74\157\155\123\x4d\123\x3a\x53\115\x53\x20\120\157\163\x74\x4d\x65\x74\x68\x6f\144\40\x73\165\x63\143\x65\163\163\40\x63\157\x64\145\x3a");
        $GBKTQ = array("\x73\164\141\164\165\x73" => "\123\x55\x43\103\105\x53\123", "\x6d\145\x73\163\141\147\145" => "\124\150\x65\40\117\x54\x50\40\x68\141\163\40\x62\145\145\x6e\40\163\x65\x6e\164\40\x74\x6f\x20\x79\x6f\165\162\40\120\x68\x6f\156\145\72\40" . $kcJv8 . "\x2e\40\120\154\x65\x61\x73\145\x20\145\156\164\145\162\x20\164\150\145\40\117\x54\x50\40\171\x6f\x75\x20\x72\x65\x63\x65\x69\x76\x65\x64\40\x74\157\40\x76\141\154\x69\144\x61\x74\x65\x2e", "\x74\170\111\x64" => "\61");
        goto gjWF2;
        yIrHM:
        $this->twofautility->log_debug("\103\165\x73\x74\157\x6d\123\x4d\x53\72\x53\x4d\x53\40\x50\x6f\x73\x74\x4d\145\x74\x68\x6f\x64\x20\145\x72\162\x6f\x72\40\143\x6f\x64\x65\x3a");
        $GBKTQ = array("\x73\x74\x61\x74\x75\x73" => "\x46\x41\111\x4c\x45\x44", "\x6d\x65\x73\163\141\147\145" => "\106\x61\154\151\x65\x64\40\164\x6f\x20\x73\x65\x6e\x64\40\x4f\124\x50\x20\164\157\x20\x79\x6f\165\x72\40\x50\x68\157\x6e\x65\x3a\40" . $kcJv8 . "\x2e\x20\x50\154\x65\141\163\x65\40\103\x6f\156\x74\x61\143\164\x20\x59\157\165\x72\40\x41\144\155\x69\156\151\x73\164\162\x61\x74\x6f\162\x2e", "\164\170\111\x64" => "\x31", "\x74\x65\x63\x68\x5f\x6d\x65\163\163\x61\147\145" => $SlvjY["\155\145\x73\163\x61\x67\145\x73"][0]["\x65\x72\x72\x6f\162\x2d\x74\145\x78\x74"]);
        gjWF2:
        return $GBKTQ;
    }
}