<?php

namespace MiniOrange\TwoFA\Controller\Account;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Api\Data\AddressInterfaceFactory;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Customer\Api\Data\RegionInterfaceFactory;
use Magento\Customer\Controller\AbstractAccount;
use Magento\Customer\Helper\Address;
use Magento\Customer\Model\Account\Redirect as AccountRedirect;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerExtractor;
use Magento\Customer\Model\Metadata\FormFactory;
use Magento\Customer\Model\Registration;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Phrase;
use Magento\Framework\UrlFactory;
use Magento\Newsletter\Model\SubscriberFactory;
use Magento\Store\Model\StoreManagerInterface;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\CustomSMS;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
class CreatePost extends \Magento\Customer\Controller\Account\CreatePost
{
    public $customerSession;
    protected $accountManagement;
    protected $addressHelper;
    protected $formFactory;
    protected $subscriberFactory;
    protected $regionDataFactory;
    protected $addressDataFactory;
    protected $registration;
    protected $customerDataFactory;
    protected $customerUrl;
    protected $escaper;
    protected $customerExtractor;
    protected $urlModel;
    protected $dataObjectHelper;
    protected $session;
    protected $TwoFAUtility;
    protected $customerModel;
    protected $storeManager;
    protected $scopeConfig;
    protected $twofacustomerregistration;
    protected $customEmail;
    protected $resultFactory;
    protected $response;
    protected $customSMS;
    protected $TwoFACustomerRegistration;
    private $accountRedirect;
    private $cookieMetadataFactory;
    private $cookieMetadataManager;
    private $formKeyValidator;
    private $customerRepository;
    private $cookieManager;
    private $url;
    private $moduleManager;
    public function __construct(Context $N0G0z, Session $I22nL, ScopeConfigInterface $nxj3s, StoreManagerInterface $Qr60R, AccountManagementInterface $HFgTE, Address $e7cNd, UrlFactory $EuyOs, FormFactory $RpiCB, SubscriberFactory $kmWt_, RegionInterfaceFactory $LgcYK, AddressInterfaceFactory $QIWw3, CustomerInterfaceFactory $B6ddu, CustomerUrl $XnhAt, Registration $ISpcb, Escaper $YvJZk, CustomerExtractor $hNhWr, DataObjectHelper $rYzOK, AccountRedirect $vLa4L, CustomEmail $GnDCN, CustomSMS $EmGef, TwoFAUtility $SfKWn, \Magento\Framework\Controller\ResultFactory $tAMcm, \Magento\Framework\Stdlib\CookieManagerInterface $x2cqG, \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $mi8WU, \Magento\Framework\Module\Manager $NtMG_, \Magento\Framework\UrlInterface $aW41i, CustomerRepository $APQXN, Customer $Z7VTn, \MiniOrange\TwoFA\Helper\TwoFACustomerRegistration $fm3hk, ?Validator $b6LYR = null)
    {
        $this->customerSession = $I22nL;
        $this->customEmail = $GnDCN;
        $this->customSMS = $EmGef;
        $this->TwoFAUtility = $SfKWn;
        $this->storeManager = $Qr60R;
        $this->scopeConfig = $nxj3s;
        $this->cookieManager = $x2cqG;
        $this->cookieMetadataFactory = $mi8WU;
        $this->moduleManager = $NtMG_;
        $this->url = $aW41i;
        $this->resultFactory = $tAMcm;
        $this->customerModel = $Z7VTn;
        $this->twofacustomerregistration = $fm3hk;
        parent::__construct($N0G0z, $I22nL, $nxj3s, $Qr60R, $HFgTE, $e7cNd, $EuyOs, $RpiCB, $kmWt_, $LgcYK, $QIWw3, $B6ddu, $XnhAt, $ISpcb, $YvJZk, $hNhWr, $rYzOK, $vLa4L, $APQXN, $b6LYR ?: ObjectManager::getInstance()->get(Validator::class));
    }
    public function execute()
    {
        $MQaoL = $this->getRequest()->getParams();
        $RniEM = $this->TwoFAUtility->getWebsiteOrStoreBasedOnTrialStatus();
        $this->customerModel->setWebsiteId($RniEM);
        $VwZBR = $this->customerModel->loadByEmail($MQaoL["\145\155\141\x69\x6c"]);
        if (is_null($VwZBR->getId())) {
            goto Sdwea;
        }
        parent::execute();
        $Mw1oh = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $Mw1oh->setPath("\143\x75\163\164\157\155\145\x72\x2f\141\x63\x63\157\x75\x6e\164");
        return $Mw1oh;
        Sdwea:
        $Mw1oh = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $dsa9Z = "\107\x65\x6e\145\162\x61\154";
        $ayhDF = $this->TwoFAUtility->getGlobalConfig(TwoFAConstants::CURRENT_CUSTOMER_RULE);
        $FFqMg = $this->checkRegistration2FAEnabled($ayhDF, $RniEM, $dsa9Z);
        $xO5Cq = $this->checkIfRuleApplies($ayhDF, $RniEM, $dsa9Z);
        $cZQer = $this->TwoFAUtility->check2fa_backend_plan();
        if ($FFqMg && $xO5Cq && $cZQer && !$this->TwoFAUtility->checkIPs("\143\165\x73\164\157\155\145\x72")) {
            goto PDTSH;
        }
        parent::execute();
        $Mw1oh->setPath("\x63\165\x73\x74\x6f\x6d\145\162\x2f\141\143\x63\157\165\x6e\x74");
        return $Mw1oh;
        goto JYLuC;
        PDTSH:
        $eisuI = $MQaoL["\x65\x6d\141\151\154"];
        $OmKHU = json_encode($MQaoL, true);
        $this->TwoFAUtility->setSessionValue("\x6d\157\x5f\143\165\x73\x74\x6f\155\x65\x72\137\160\141\x67\x65\137\x70\141\162\x61\155\x65\164\145\x72\163", $OmKHU);
        $this->TwoFAUtility->setSessionValue("\155\157\x75\x73\x65\x72\x6e\141\x6d\145", $MQaoL["\145\155\141\x69\154"]);
        $this->TwoFAUtility->setSessionValue("\155\157\143\x72\x65\x61\164\x65\x5f\x63\x75\163\x74\157\155\x65\x72\137\x72\x65\147\x69\163\x74\145\x72", 1);
        $this->TwoFAUtility->setSessionValue(TwoFAConstants::CUSTOMER_WEBSITE_ID, $RniEM);
        $qP_bZ = $this->cookieMetadataFactory->createPublicCookieMetadata();
        $qP_bZ->setDurationOneYear();
        $qP_bZ->setPath("\x2f");
        $qP_bZ->setHttpOnly(false);
        $this->cookieManager->setPublicCookie("\155\157\x75\163\145\x72\156\141\155\145", $eisuI, $qP_bZ);
        $b7fOr = '';
        $this->TwoFAUtility->log_debug("\x45\170\145\143\x75\164\x65\40\x4c\x6f\147\x69\156\x50\x6f\x73\x74\x3a\40\103\x75\x73\x74\x6f\x6d\x65\x72\x20\x67\x6f\x69\x6e\x67\40\164\x68\162\x6f\165\x67\x68\40\111\x6e\154\151\156\x65\x20\x69\156\40\143\x72\x65\141\x74\145\160\x6f\x73\164");
        $yBs_M = $this->getActiveMethodsInfo($ayhDF, $RniEM, $dsa9Z);
        $bCY69 = $yBs_M["\x63\x6f\165\156\x74"];
        $uH5vD = $yBs_M["\146\x69\162\x73\164\x5f\x6d\x65\x74\x68\x6f\x64"];
        if ($bCY69 == 1) {
            goto Ys1XH;
        }
        if ($bCY69 > 1) {
            goto CeAUE;
        }
        goto jktqV;
        Ys1XH:
        $MQaoL = array("\155\x6f\160\157\x73\164\157\160\164\x69\157\156" => "\155\x65\164\x68\x6f\x64", "\x6d\151\156\151\157\x72\141\x6e\147\x65\x74\146\x61\137\155\145\x74\x68\157\x64" => $uH5vD, "\151\x6e\x6c\x69\156\x65\x5f\157\x6e\145\x5f\x6d\x65\x74\150\157\144" => "\x31");
        $Mw1oh->setPath("\x6d\x6f\164\x77\x6f\146\141\x2f\155\157\x63\165\163\164\x6f\x6d\145\162", $MQaoL);
        $Ck7jM = $this->url->getCurrentUrl();
        $this->TwoFAUtility->log_debug("\x43\x75\x72\162\145\156\164\x20\x55\x52\114\x3a\x20" . $Ck7jM);
        goto jktqV;
        CeAUE:
        $MQaoL = array("\x6d\x6f\157\160\164\x69\157\156" => "\151\156\166\157\153\145\x49\156\154\x69\x6e\x65", "\x73\164\x65\x70" => "\103\x68\157\x6f\x73\145\x4d\106\x41\115\x65\x74\150\x6f\144");
        $Mw1oh->setPath("\155\157\x74\167\157\x66\141\x2f\155\157\143\x75\x73\164\157\x6d\145\x72\x2f\151\x6e\x64\145\x78", $MQaoL);
        $Ck7jM = $this->url->getCurrentUrl();
        $this->TwoFAUtility->log_debug("\x43\165\x72\162\x65\156\x74\40\x55\x52\x4c\x3a\40" . $Ck7jM);
        jktqV:
        return $Mw1oh;
        JYLuC:
    }
    private function getWebsiteName($Z900Q)
    {
        try {
            $widqB = $this->storeManager->getWebsite($Z900Q);
            return $widqB->getName();
        } catch (\Exception $VhuPK) {
            $this->TwoFAUtility->log_debug("\103\x72\x65\141\164\x65\120\x6f\163\164\72\40\x43\x6f\x75\x6c\144\40\x6e\x6f\x74\x20\147\145\x74\x20\167\145\142\163\151\x74\x65\40\x6e\141\155\145\x20\x66\157\x72\x20\x49\x44\40" . $Z900Q . "\x3a\x20" . $VhuPK->getMessage());
            return null;
        }
    }
    private function doesRuleApply($HrUwy, $zG_1m, $dsa9Z)
    {
        return ($HrUwy["\x73\151\x74\x65"] === "\x41\154\x6c\x20\123\x69\x74\145\163" || $HrUwy["\x73\151\164\145"] === $zG_1m) && ($HrUwy["\x67\162\157\165\160"] === "\101\x6c\154\40\x47\162\x6f\x75\160\163" || $HrUwy["\147\162\157\x75\160"] === $dsa9Z);
    }
    private function checkIfRuleApplies($ayhDF, $RniEM, $dsa9Z)
    {
        if ($ayhDF) {
            goto r6vcq;
        }
        return false;
        r6vcq:
        $xrXk8 = json_decode($ayhDF, true);
        if (is_array($xrXk8)) {
            goto Vetvf;
        }
        return false;
        Vetvf:
        $zG_1m = $this->getWebsiteName($RniEM);
        if ($zG_1m) {
            goto tCKzV;
        }
        return false;
        tCKzV:
        $nNbU0 = null;
        $L7Eqs = null;
        foreach ($xrXk8 as $HrUwy) {
            if (!($this->doesRuleApply($HrUwy, $zG_1m, $dsa9Z) && isset($HrUwy["\x6d\x65\164\x68\x6f\x64\x73"]) && !empty($HrUwy["\x6d\145\x74\150\x6f\144\x73"]))) {
                goto YqdWX;
            }
            if ($HrUwy["\163\151\x74\x65"] === $zG_1m) {
                goto SJqCS;
            }
            if ($HrUwy["\163\151\164\145"] === "\101\154\154\40\x53\x69\164\145\163") {
                goto PyMU5;
            }
            goto aWN12;
            SJqCS:
            $nNbU0 = $HrUwy;
            goto aWN12;
            PyMU5:
            $L7Eqs = $HrUwy;
            aWN12:
            YqdWX:
            PoEYj:
        }
        nievn:
        $ELGi5 = $nNbU0 ?: $L7Eqs;
        return $ELGi5 !== null;
    }
    private function getActiveMethodsInfo($ayhDF, $RniEM, $dsa9Z)
    {
        $Sg2nI = ["\143\157\165\x6e\x74" => 0, "\146\x69\162\x73\x74\x5f\x6d\145\x74\150\157\x64" => null];
        if ($ayhDF) {
            goto V3r1b;
        }
        return $Sg2nI;
        V3r1b:
        $xrXk8 = json_decode($ayhDF, true);
        if (is_array($xrXk8)) {
            goto ur2FI;
        }
        return $Sg2nI;
        ur2FI:
        $zG_1m = $this->getWebsiteName($RniEM);
        if ($zG_1m) {
            goto cnPfm;
        }
        return $Sg2nI;
        cnPfm:
        $nNbU0 = null;
        $L7Eqs = null;
        foreach ($xrXk8 as $HrUwy) {
            if (!($this->doesRuleApply($HrUwy, $zG_1m, $dsa9Z) && isset($HrUwy["\155\145\x74\x68\x6f\144\163"]) && !empty($HrUwy["\x6d\145\164\150\157\x64\163"]))) {
                goto Dk5Hv;
            }
            if ($HrUwy["\163\x69\164\145"] === $zG_1m) {
                goto pP_QJ;
            }
            if ($HrUwy["\x73\x69\164\x65"] === "\x41\x6c\154\x20\123\x69\x74\145\x73") {
                goto Ry1UE;
            }
            goto gNwab;
            pP_QJ:
            $nNbU0 = $HrUwy;
            goto gNwab;
            Ry1UE:
            $L7Eqs = $HrUwy;
            gNwab:
            Dk5Hv:
            iTnev:
        }
        qtl6E:
        $ELGi5 = $nNbU0 ?: $L7Eqs;
        if (!$ELGi5) {
            goto BhKq6;
        }
        $Sg2nI["\143\x6f\x75\x6e\164"] = count($ELGi5["\x6d\x65\x74\150\x6f\x64\163"]);
        if (!($Sg2nI["\x63\157\165\156\164"] == 1)) {
            goto OVY9s;
        }
        $Sg2nI["\x66\151\162\163\x74\137\155\x65\164\150\x6f\x64"] = $ELGi5["\x6d\145\x74\x68\157\144\x73"][0]["\153\x65\171"];
        OVY9s:
        BhKq6:
        return $Sg2nI;
    }
    private function checkRegistration2FAEnabled($ayhDF, $RniEM, $dsa9Z)
    {
        if ($ayhDF) {
            goto Offye;
        }
        return false;
        Offye:
        $xrXk8 = json_decode($ayhDF, true);
        if (is_array($xrXk8)) {
            goto dmc5N;
        }
        return false;
        dmc5N:
        $zG_1m = $this->getWebsiteName($RniEM);
        if ($zG_1m) {
            goto exUjh;
        }
        return false;
        exUjh:
        $nNbU0 = null;
        $L7Eqs = null;
        foreach ($xrXk8 as $HrUwy) {
            if (!($this->doesRuleApply($HrUwy, $zG_1m, $dsa9Z) && isset($HrUwy["\162\x65\147\151\163\x74\162\x61\x74\151\x6f\156\x5f\145\x6e\141\x62\154\145\144"]) && $HrUwy["\162\x65\147\x69\x73\164\x72\x61\x74\151\157\x6e\137\x65\x6e\x61\x62\154\x65\x64"])) {
                goto yVdtM;
            }
            if ($HrUwy["\x73\x69\x74\x65"] === $zG_1m) {
                goto A_f6f;
            }
            if ($HrUwy["\163\x69\164\145"] === "\101\x6c\154\x20\123\151\164\x65\x73") {
                goto Juim1;
            }
            goto UnjiG;
            A_f6f:
            $nNbU0 = $HrUwy;
            goto UnjiG;
            Juim1:
            $L7Eqs = $HrUwy;
            UnjiG:
            yVdtM:
            Q35kw:
        }
        LOLCG:
        $ELGi5 = $nNbU0 ?: $L7Eqs;
        return $ELGi5 !== null;
    }
}