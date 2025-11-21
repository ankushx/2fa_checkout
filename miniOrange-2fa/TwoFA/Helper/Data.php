<?php

namespace MiniOrange\TwoFA\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Stdlib\DateTime\DateTime;
use MiniOrange\TwoFA\Helper\Saml2\Lib\AESEncryption;
class Data extends AbstractHelper
{
    protected $scopeConfig;
    protected $adminFactory;
    protected $customerFactory;
    protected $urlInterface;
    protected $configWriter;
    protected $assetRepo;
    protected $helperBackend;
    protected $frontendUrl;
    protected $dateTime;
    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $hFobB, \Magento\User\Model\UserFactory $Ktxag, \Magento\Customer\Model\CustomerFactory $k10qp, \Magento\Framework\UrlInterface $WJFb3, \Magento\Framework\App\Config\Storage\WriterInterface $L2naY, \Magento\Framework\View\Asset\Repository $mz0wg, \Magento\Backend\Helper\Data $M2VeR, \Magento\Framework\Url $lykY0, DateTime $dkhns)
    {
        $this->scopeConfig = $hFobB;
        $this->adminFactory = $Ktxag;
        $this->customerFactory = $k10qp;
        $this->urlInterface = $WJFb3;
        $this->configWriter = $L2naY;
        $this->assetRepo = $mz0wg;
        $this->helperBackend = $M2VeR;
        $this->frontendUrl = $lykY0;
        $this->dateTime = $dkhns;
    }
    public function getMiniOrangeUrl()
    {
        return TwoFAConstants::HOSTNAME;
    }
    public function getStoreCustomConfig($meZh8)
    {
        $zxeXv = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue($meZh8, $zxeXv);
    }
    public function saveConfig($HFwR4, $jM3aI, $lPLmn, $A42Gt)
    {
        $A42Gt ? $this->saveAdminStoreConfig($HFwR4, $jM3aI, $lPLmn) : $this->saveCustomerStoreConfig($HFwR4, $jM3aI, $lPLmn);
    }
    private function saveAdminStoreConfig($HFwR4, $jM3aI, $lPLmn)
    {
        $kyQ1q = [$HFwR4 => $jM3aI];
        $Ruxhl = $this->adminFactory->create()->load($lPLmn)->addData($kyQ1q);
        $Ruxhl->setId($lPLmn)->save();
    }
    private function saveCustomerStoreConfig($HFwR4, $jM3aI, $lPLmn)
    {
        $kyQ1q = [$HFwR4 => $jM3aI];
        $Ruxhl = $this->customerFactory->create()->load($lPLmn)->addData($kyQ1q);
        $Ruxhl->setId($lPLmn)->save();
    }
    public function getAdminStoreConfig($meZh8, $lPLmn)
    {
        return $this->adminFactory->create()->load($lPLmn)->getData($meZh8);
    }
    public function getCustomerStoreConfig($meZh8, $lPLmn)
    {
        return $this->customerFactory->create()->load($lPLmn)->getData($meZh8);
    }
    public function getImageUrl($lk3ZX)
    {
        return $this->assetRepo->getUrl(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_IMAGES . $lk3ZX);
    }
    public function getUrl($HFwR4, $PtuWe = array())
    {
        return $this->urlInterface->getUrl($HFwR4, ["\x5f\161\x75\145\162\x79" => $PtuWe]);
    }
    public function getAdminCssUrl($K7dhi)
    {
        return $this->assetRepo->getUrl(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_CSS . $K7dhi, ["\x61\162\145\141" => "\x61\x64\x6d\x69\156\x68\x74\155\154"]);
    }
    public function getAdminJSUrl($eFy5_)
    {
        return $this->assetRepo->getUrl(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_JS . $eFy5_, ["\x61\162\x65\x61" => "\x61\x64\155\x69\x6e\x68\164\x6d\x6c"]);
    }
    public function getResourcePath($A_tnX)
    {
        return $this->assetRepo->createAsset(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_CERTS . $A_tnX, ["\141\x72\145\x61" => "\x61\144\155\x69\156\x68\x74\155\154"])->getSourceFile();
    }
    public function getAdminBaseUrl()
    {
        return $this->helperBackend->getHomePageUrl();
    }
    public function getAdminUrl($HFwR4, $PtuWe = array())
    {
        return $this->helperBackend->getUrl($HFwR4, ["\137\x71\165\145\x72\x79" => $PtuWe]);
    }
    public function getAdminSecureUrl($HFwR4, $PtuWe = array())
    {
        return $this->helperBackend->getUrl($HFwR4, ["\137\x73\145\x63\165\162\x65" => true, "\x5f\161\165\145\162\x79" => $PtuWe]);
    }
    public function getSPInitiatedUrl($OMh6r = null)
    {
        $OMh6r = is_null($OMh6r) ? $this->getCurrentUrl() : $OMh6r;
        return $this->getFrontendUrl(TwoFAConstants::TwoFA_LOGIN_URL, ["\162\145\154\141\171\123\x74\x61\x74\x65" => $OMh6r]);
    }
    public function getCurrentUrl()
    {
        return $this->urlInterface->getCurrentUrl();
    }
    public function getFrontendUrl($HFwR4, $PtuWe = array())
    {
        return $this->frontendUrl->getUrl($HFwR4, ["\x5f\x71\165\145\162\171" => $PtuWe]);
    }
    public function extendTrial()
    {
        if (!$this->check_license_plan(4)) {
            goto qiEdX;
        }
        $CDKOD = $this->getCurrentAdminUser()->getData();
        $vMZul = $CDKOD["\x65\x6d\x61\151\154"];
        $IeYhy = $CDKOD["\146\x69\162\x73\164\156\x61\x6d\x65"];
        $VBkj_ = $this->getBaseUrl();
        $cSTDO = $this->getMagnetoVersion();
        $gWf73 = $this->getStoreConfig(TwoFAConstants::IS_TRIAL_EXTENDED);
        $dkhns = new \DateTime();
        $o7HWG = $dkhns->format("\131\x2d\x6d\x2d\144\40\110\72\151\72\163");
        $lS4d_ = $this->getStoreConfig(TwoFAConstants::TIMESTAMP) ?? $dkhns->getTimestamp();
        if (!$gWf73) {
            goto lOCIe;
        }
        $sag0_ = ["\124\162\x69\x61\154\x45\x78\x74\x65\x6e\144\x4c\151\x6d\151\164\122\145\141\143\x68\x65\144" => "\131\145\163"];
        $kyQ1q = ["\x74\x69\155\x65\x53\164\141\155\x70" => $lS4d_, "\141\x64\x6d\151\x6e\x45\155\141\151\154" => $vMZul, "\144\x6f\x6d\x61\x69\156" => $VBkj_, "\160\x6c\x75\x67\x69\x6e\x56\x65\162\x73\x69\x6f\156" => TwoFAConstants::VERSION, "\x6f\x74\150\x65\x72" => json_encode($sag0_)];
        Curl::sendUserDetailsToPortal($kyQ1q);
        $this->messageManager->addErrorMessage(TwoFAMessages::EXTEND_TRIAL_LIMIT_REACHED);
        goto atM6V;
        lOCIe:
        $this->setStoreConfig(TwoFAConstants::IS_TRIAL_EXTENDED, true);
        $this->setStoreConfig(TwoFAConstants::INSTALLATION_DATE, AESEncryption::encrypt_data($o7HWG, TwoFAConstants::DEFAULT_TOKEN_VALUE));
        $cBllJ = array($IeYhy, $cSTDO, $VBkj_);
        $kyQ1q = ["\x74\151\x6d\145\x53\164\141\155\x70" => $lS4d_, "\x61\x64\155\151\x6e\105\x6d\141\151\x6c" => $vMZul, "\x64\157\x6d\x61\x69\156" => $VBkj_, "\x70\154\165\147\x69\156\126\x65\x72\163\151\x6f\x6e" => TwoFAConstants::VERSION, "\111\163\124\162\x69\x61\154\x45\170\164\145\x6e\144\x65\x64" => "\x59\145\x73"];
        Curl::sendUserDetailsToPortal($kyQ1q);
        $this->messageManager->addSuccessMessage(TwoFAMessages::TRIAL_EXTENDED);
        atM6V:
        qiEdX:
    }
    public function getBaseUrl()
    {
        return $this->urlInterface->getBaseUrl();
    }
    public function getStoreConfig($meZh8, $Qtrpk = "\144\x65\146\x61\165\x6c\x74", $LCb9c = null)
    {
        $pa2Gn = "\155\x69\156\x69\x6f\162\x61\156\x67\145\57\124\167\157\x46\x41\x2f" . $meZh8;
        if ($Qtrpk === "\x64\x65\146\141\x75\x6c\x74" || $LCb9c === null) {
            goto WvICI;
        }
        return $this->scopeConfig->getValue($pa2Gn, $Qtrpk, $LCb9c);
        goto tmhTf;
        WvICI:
        return $this->scopeConfig->getValue($pa2Gn);
        tmhTf:
    }
    public function setStoreConfig($meZh8, $jM3aI, $Qtrpk = "\144\x65\146\x61\x75\x6c\x74", $LCb9c = null)
    {
        $pa2Gn = "\x6d\151\x6e\x69\157\162\141\x6e\147\145\x2f\x54\167\x6f\x46\x41\x2f" . $meZh8;
        if ($Qtrpk === "\x64\x65\146\141\x75\x6c\164" || $LCb9c === null) {
            goto OWdHq;
        }
        $this->configWriter->save($pa2Gn, $jM3aI, $Qtrpk, $LCb9c);
        goto F2iq7;
        OWdHq:
        $this->configWriter->save($pa2Gn, $jM3aI);
        F2iq7:
    }
    public function isTrialExpired()
    {
        if (!$this->check_license_plan(4)) {
            goto WSOEm;
        }
        $V2PKC = AESEncryption::decrypt_data($this->getStoreConfig(TwoFAConstants::INSTALLATION_DATE), TwoFAConstants::DEFAULT_TOKEN_VALUE);
        if (!$V2PKC) {
            goto aqglC;
        }
        $ELgXZ = date("\131\55\x6d\55\x64\x20\x48\x3a\151\72\x73", strtotime($V2PKC . "\x20\x2b\40" . 7 . "\40\144\141\x79\163"));
        $o7HWG = $this->dateTime->gmtDate("\131\55\155\x2d\x64\x20\110\x3a\151\72\163");
        if (!($o7HWG > $ELgXZ)) {
            goto rL_a1;
        }
        $vMZul = null;
        $IeYhy = null;
        if (!$this->getCurrentAdminUser()) {
            goto SMCWW;
        }
        $CDKOD = $this->getCurrentAdminUser()->getData();
        $vMZul = $CDKOD["\145\x6d\x61\x69\x6c"];
        $IeYhy = $CDKOD["\x66\x69\162\163\164\x6e\141\x6d\145"];
        SMCWW:
        $VBkj_ = $this->getBaseUrl();
        $cSTDO = $this->getMagnetoVersion();
        $cBllJ = array($IeYhy, $cSTDO, $VBkj_);
        $b5ArN = $this->getStoreConfig(TwoFAConstants::SEND_EXPIRED_EMAIL);
        if (!($b5ArN == null)) {
            goto lK_yQ;
        }
        $this->setStoreConfig(TwoFAConstants::SEND_EXPIRED_EMAIL, 1);
        $lS4d_ = $this->getStoreConfig(TwoFAConstants::TIMESTAMP);
        $kyQ1q = ["\164\x69\155\145\123\x74\141\155\x70" => $lS4d_, "\111\163\x54\x72\x69\x61\154\105\170\160\x69\162\145\x64" => "\x59\145\x73"];
        Curl::sendUserDetailsToPortal($kyQ1q);
        $this->flushCache();
        lK_yQ:
        return true;
        rL_a1:
        goto DqyW1;
        aqglC:
        $o7HWG = $this->dateTime->gmtDate("\131\x2d\155\55\x64\x20\110\x3a\x69\72\163");
        $this->setStoreConfig(TwoFAConstants::INSTALLATION_DATE, AESEncryption::encrypt_data($o7HWG, TwoFAConstants::DEFAULT_TOKEN_VALUE));
        DqyW1:
        return false;
        WSOEm:
        return false;
    }
    public function daysTillTrialExpiry()
    {
        $this->flushCache();
        $this->reinitConfig();
        $V2PKC = AESEncryption::decrypt_data($this->getStoreConfig(TwoFAConstants::INSTALLATION_DATE), TwoFAConstants::DEFAULT_TOKEN_VALUE);
        $ELgXZ = date("\131\x2d\x6d\55\144\40\110\x3a\x69\x3a\163", strtotime($V2PKC . "\40\53\40" . 7 . "\x20\x64\141\x79\x73"));
        $o7HWG = $this->dateTime->gmtDate("\x59\x2d\155\x2d\144\40\110\x3a\x69\x3a\x73");
        $McG18 = ceil((strtotime($ELgXZ) - strtotime($o7HWG)) / 86400);
        return $McG18;
    }
}