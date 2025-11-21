<?php

namespace MiniOrange\TwoFA\Controller\Adminhtml\Customer2fa;

use Magento\Backend\App\Action\Context;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Store\Api\WebsiteRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use MiniOrange\TwoFA\Controller\Actions\BaseAdminAction;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use MiniOrange\TwoFA\Helper\Curl;
class Index extends BaseAdminAction implements HttpPostActionInterface, HttpGetActionInterface
{
    protected $fileFactory;
    private $websiteRepository;
    private $groupRepository;
    private $searchCriteriaBuilder;
    private $storeManager;
    public function __construct(Context $utcs6, TwoFAUtility $K1YLb, \Magento\Framework\View\Result\PageFactory $hqs6h, \Magento\Framework\Message\ManagerInterface $jef0J, \Psr\Log\LoggerInterface $uRDWF, FileFactory $SUwKE, WebsiteRepositoryInterface $L3xxA, GroupRepositoryInterface $IuChn, SearchCriteriaBuilder $XA9wI, StoreManagerInterface $y2Dme)
    {
        parent::__construct($utcs6, $hqs6h, $K1YLb, $jef0J, $uRDWF);
        $this->fileFactory = $SUwKE;
        $this->websiteRepository = $L3xxA;
        $this->groupRepository = $IuChn;
        $this->searchCriteriaBuilder = $XA9wI;
        $this->storeManager = $y2Dme;
    }
    public function execute()
    {
        try {
            $Qi_Aa = $this->getRequest()->getParams();
            if (!$this->isFormOptionBeingSaved($Qi_Aa)) {
                goto sCAiy;
            }
            $this->processValuesAndSaveData($Qi_Aa);
            $this->twofautility->flushCache();
            $this->messageManager->addSuccessMessage(TwoFAMessages::SETTINGS_SAVED);
            $this->twofautility->reinitConfig();
            $YMq5m = $this->twofautility->getAdminUrl("\155\x6f\164\x77\x6f\146\x61\x2f\x74\x66\x61\163\x65\x74\164\151\156\x67\x73\143\x6f\x6e\146\x69\x67\x75\162\x61\164\x69\x6f\156\164\141\142\x6c\145\x2f\151\156\x64\145\170");
            return $this->resultRedirectFactory->create()->setUrl($YMq5m);
            sCAiy:
        } catch (\Exception $qW8E0) {
            $this->messageManager->addErrorMessage($qW8E0->getMessage());
            $this->logger->debug($qW8E0->getMessage());
        }
        $IpYLs = $this->resultPageFactory->create();
        $IpYLs->getConfig()->getTitle()->prepend(__(TwoFAConstants::MODULE_TITLE));
        return $IpYLs;
    }
    private function processValuesAndSaveData($Qi_Aa)
    {
        $OsZIk = $this->twofautility->isCustomerRegistered();
        if (!(!$OsZIk and $this->twofautility->check2fa_backend_plan() == "\60")) {
            goto bzPQt;
        }
        $this->messageManager->addErrorMessage(TwoFAMessages::NOT_REGISTERED);
        $UNYIh = $this->resultRedirectFactory->create();
        $UNYIh->setPath("\155\157\x74\167\157\146\x61\x2f\x61\143\x63\157\165\156\x74\57\x69\156\x64\x65\x78");
        return $UNYIh;
        bzPQt:
        if (!isset($Qi_Aa["\x6f\x70\164\x69\157\156"])) {
            goto HLORe;
        }
        if ($Qi_Aa["\x6f\160\164\x69\x6f\x6e"] === "\163\141\166\145\x53\x69\156\147\x49\156\x53\145\x74\164\151\x6e\147\163\x5f\x63\x75\x73\x74\157\155\x65\x72") {
            goto xrFPk;
        }
        if ($Qi_Aa["\x6f\160\164\x69\x6f\156"] === "\144\145\154\x65\164\145\x5f\145\170\x69\x73\x74\151\x6e\x67\137\162\x75\154\145") {
            goto LAfsc;
        }
        goto cKYXd;
        xrFPk:
        if (isset($Qi_Aa["\x63\165\163\x74\157\x6d\x65\162\137\162\145\x67\x69\163\x74\162\141\x74\x69\157\156\x5f\151\156\154\151\156\x65"])) {
            goto JLXnH;
        }
        $Gc0aj = 0;
        goto bUeSd;
        JLXnH:
        $Gc0aj = 1;
        bUeSd:
        $uFsPy = isset($Qi_Aa[TwoFAConstants::REGISTRATION_WEBSITE]) ? $Qi_Aa[TwoFAConstants::REGISTRATION_WEBSITE] : "\x61\154\154";
        $this->twofautility->setStoreConfig("\x74\167\x6f\x66\x61\x2f\x72\145\x67\151\x73\164\x72\141\x74\151\157\156\57\x73\x65\154\145\143\164\145\144\137\x77\145\142\163\151\x74\145", $uFsPy);
        if (!(isset($Qi_Aa["\162\165\154\145\x73"]) and !empty($Qi_Aa["\162\165\154\145\x73"]))) {
            goto PPUmZ;
        }
        $ZfA3Y = json_decode($Qi_Aa["\162\x75\154\x65\x73"], true);
        $RLwU1 = $this->twofautility->ifSandboxTrialEnabled();
        foreach ($ZfA3Y as &$BJ3kP) {
            $BJ3kP["\x73\151\164\x65"] = preg_replace("\x2f\x5c\156\57", '', trim($BJ3kP["\x73\x69\164\x65"]));
            $BJ3kP["\x67\x72\157\x75\x70"] = preg_replace("\x2f\134\x6e\x2f", '', trim($BJ3kP["\147\x72\x6f\x75\160"]));
            Qc6Kn:
        }
        LplDT:
        unset($BJ3kP);
        $pk8j2 = $this->twofautility->getStoreConfig(TwoFAConstants::CURRENT_CUSTOMER_RULE);
        $tP8D1 = $pk8j2 ? json_decode($pk8j2, true) : [];
        $NYP0X = [];
        $jXh64 = [];
        foreach ($ZfA3Y as $BJ3kP) {
            $VaPCo = $BJ3kP["\x73\151\164\145"] . "\x7c" . $BJ3kP["\x67\162\157\x75\x70"];
            if (in_array($VaPCo, $jXh64)) {
                goto Jrz6w;
            }
            $jXh64[] = $VaPCo;
            $NYP0X[] = $BJ3kP;
            Jrz6w:
            al_5K:
        }
        dW6VI:
        if (!empty($tP8D1)) {
            goto Ue9s6;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::CURRENT_CUSTOMER_RULE, json_encode($NYP0X));
        $this->processRules($NYP0X, $Qi_Aa);
        goto Y_8OF;
        Ue9s6:
        $Ggtdz = array_filter($tP8D1, function ($fjU3P) use($NYP0X) {
            foreach ($NYP0X as $uqpcc) {
                if (!($fjU3P["\163\151\164\x65"] === $uqpcc["\163\151\x74\x65"] && $fjU3P["\x67\x72\157\x75\160"] === $uqpcc["\147\162\157\x75\x70"])) {
                    goto Qg1Zs;
                }
                return false;
                Qg1Zs:
                fXFa_:
            }
            Zfn7r:
            return true;
        });
        $rW3bM = array_merge($Ggtdz, $NYP0X);
        $this->twofautility->setStoreConfig(TwoFAConstants::CURRENT_CUSTOMER_RULE, json_encode($rW3bM));
        $this->processRules($NYP0X, $Qi_Aa);
        Y_8OF:
        PPUmZ:
        goto cKYXd;
        LAfsc:
        if (!(isset($Qi_Aa["\144\145\154\x65\x74\145\x5f\x72\157\154\145"]) && isset($Qi_Aa["\144\145\x6c\145\x74\x65\137\162\157\154\145\137\163\151\164\145"]))) {
            goto leYiL;
        }
        $C1YHN = $Qi_Aa["\144\x65\154\x65\x74\145\137\162\157\x6c\x65"];
        $QYxer = $Qi_Aa["\x64\x65\x6c\145\164\x65\137\x72\157\x6c\x65\137\163\x69\164\x65"];
        $pk8j2 = $this->twofautility->getStoreConfig(TwoFAConstants::CURRENT_CUSTOMER_RULE);
        $tP8D1 = $pk8j2 ? json_decode($pk8j2, true) : [];
        $puRCw = array_filter($tP8D1, function ($BJ3kP) use($C1YHN, $QYxer) {
            return !($BJ3kP["\163\x69\164\x65"] === $QYxer && $BJ3kP["\x67\162\x6f\165\160"] === $C1YHN);
        });
        $this->twofautility->setStoreConfig(TwoFAConstants::CURRENT_CUSTOMER_RULE, json_encode(array_values($puRCw)));
        $KLKQM = $this->getAllCustomerGroups();
        $this->processRoleDeletion(["\x64\x65\x6c\x65\x74\x65\x5f\x72\x6f\154\145" => $C1YHN, "\144\145\154\145\x74\x65\137\162\157\x6c\x65\137\163\151\164\x65" => $QYxer], $KLKQM);
        leYiL:
        cKYXd:
        HLORe:
    }
    private function getAllCustomerGroups()
    {
        $w9TnK = $this->searchCriteriaBuilder->create();
        $BLuDw = $this->groupRepository->getList($w9TnK);
        $o_YAo = [];
        foreach ($BLuDw->getItems() as $eOTh3) {
            $o_YAo[$eOTh3->getId()] = $eOTh3->getCode();
            jflHz:
        }
        miSTj:
        return $o_YAo;
    }
    private function processRoleDeletion(array $Qi_Aa, array $KLKQM)
    {
        $C1YHN = $Qi_Aa["\x64\145\x6c\x65\164\145\137\162\157\154\x65"];
        $QYxer = $Qi_Aa["\x64\145\154\x65\x74\145\137\x72\157\154\145\137\163\151\164\145"];
    }
    private function getAllWebsites()
    {
        $FVKsg = $this->websiteRepository->getList();
        return array_map(function ($yaNjb) {
            return $yaNjb->getCode();
        }, $FVKsg);
    }
    private function processRules($ZfA3Y, $Qi_Aa)
    {
        $RLwU1 = $this->twofautility->ifSandboxTrialEnabled();
        $it3Fw = $this->twofautility->check_license_plan(4);
        if ($RLwU1) {
            goto oUt2O;
        }
        if ($it3Fw) {
            goto G6O2Q;
        }
        goto pq4ph;
        oUt2O:
        $Kwb_t = $this->twofautility->getCurrentAdminUser();
        $sSdFL = $Kwb_t->getStoreName();
        $A4uvQ = $Kwb_t->getEmail();
        $CHZdi = $this->twofautility->getSandBoxUserDataUsingEmail($A4uvQ);
        $SNpyp = isset($CHZdi[0]["\x74\x69\x6d\145\163\x74\x61\x6d\x70"]) ? $CHZdi[0]["\x74\x69\x6d\x65\x73\x74\x61\155\160"] : null;
        $v3cK4 = array_filter($ZfA3Y, fn($BJ3kP) => $BJ3kP["\163\151\x74\x65"] === $sSdFL);
        if (!empty($v3cK4)) {
            goto gi23A;
        }
        $UkeZ9 = [];
        gi23A:
        $vzXDc = array_merge(...array_column($v3cK4, "\155\x65\x74\x68\157\144\163"));
        $UkeZ9 = array_values(array_unique(array_column($vzXDc, "\x6b\145\x79")));
        $Qd88Q = is_array($UkeZ9) ? json_encode($UkeZ9) : '';
        goto pq4ph;
        G6O2Q:
        $SNpyp = $this->twofautility->getStoreConfig(TwoFAConstants::TIMESTAMP);
        $vzXDc = array_merge(...array_column($ZfA3Y, "\155\145\x74\150\157\x64\163"));
        $UkeZ9 = array_values(array_unique(array_column($vzXDc, "\153\145\171")));
        $Qd88Q = is_array($UkeZ9) ? json_encode($UkeZ9) : '';
        pq4ph:
        if (!($RLwU1 || $it3Fw && !is_null($SNpyp))) {
            goto YJovY;
        }
        $AY5ld = ["\x74\151\155\x65\123\x74\141\x6d\160" => $SNpyp, "\x66\162\157\156\164\x65\x6e\x64\115\x65\x74\150\x6f\144" => $Qd88Q];
        Curl::sendUserDetailsToPortal($AY5ld);
        YJovY:
        if (!(isset($Qi_Aa["\x64\145\154\145\x74\x65\137\162\x6f\x6c\x65\x5f\163\x69\164\x65"]) && isset($Qi_Aa["\144\145\154\x65\164\145\x5f\162\x6f\154\x65"]))) {
            goto m7L5z;
        }
        $this->processRoleDeletion($Qi_Aa, $this->getAllCustomerGroups());
        m7L5z:
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_CUSTOMER_2FA);
    }
}