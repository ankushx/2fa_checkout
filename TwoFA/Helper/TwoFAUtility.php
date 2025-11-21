<?php

namespace MiniOrange\TwoFA\Helper;

use Magento\Authorization\Model\UserContextInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Cache\Frontend\Pool;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Url;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\User\Model\ResourceModel\User\CollectionFactory as UserCollectionFactory;
use Magento\User\Model\UserFactory;
use MiniOrange\TwoFA\Model\ResourceModel\IpWhitelisted\CollectionFactory as IpWhitelistedCollectionFactory;
use MiniOrange\TwoFA\Model\ResourceModel\IpWhitelistedAdmin\CollectionFactory as IpWhitelistedAdminCollectionFactory;
use Magento\Framework\Module\Manager as ModuleManager;
use Magento\Store\Api\WebsiteRepositoryInterface;
use Magento\Customer\Api\Data\CustomerExtensionFactory;
class TwoFAUtility extends Data
{
    public $messageManager;
    protected $adminSession;
    protected $customerSession;
    protected $authSession;
    protected $cacheTypeList;
    protected $resource;
    protected $cacheFrontendPool;
    protected $fileSystem;
    protected $logger;
    protected $reinitableConfig;
    protected $coreSession;
    protected $userContext;
    protected $dir;
    protected $data = array();
    protected $storeManager;
    protected $groupRepository;
    protected $ipWhitelistedCollectionFactory;
    protected $ipWhitelistedAdminCollectionFactory;
    protected $_websiteCollectionFactory;
    protected $_logger;
    protected $productMetadata;
    private $userCollectionFactory;
    private $userFactory;
    private $customerModel;
    private $url;
    private $resultFactory;
    private $cookieManager;
    private $cookieMetadataFactory;
    protected $moduleManager;
    protected $websiteRepository;
    private $customerExtensionFactory;
    protected $companyCustomerFactory = null;
    private $companyUserRepository = null;
    private $companyRepository = null;
    private $companyManagement = null;
    private $objectManager;
    private $customerRepository;
    public function __construct(ScopeConfigInterface $t2suv, UserFactory $N9Lzo, CustomerFactory $BIHPx, UrlInterface $KwMdk, WriterInterface $UT_XN, \Magento\Framework\App\ResourceConnection $rvDYs, Repository $CZthx, \Magento\Backend\Helper\Data $JCW9s, Url $pfeC5, \Magento\Backend\Model\Session $RCLDw, Session $WrUW4, \Magento\Backend\Model\Auth\Session $wd_9B, \Magento\Framework\App\Config\ReinitableConfigInterface $Bzn80, \Magento\Framework\Session\SessionManagerInterface $DDEbR, TypeListInterface $cl1gb, Pool $v5KJs, \Psr\Log\LoggerInterface $A8z1G, File $Z1ScI, UserContextInterface $f0euJ, UserCollectionFactory $GL2tl, \Magento\User\Model\UserFactory $HIdrW, \Magento\Framework\Filesystem\DirectoryList $knkEN, \Magento\Store\Model\StoreManagerInterface $KQp5D, Customer $z_MYO, \Magento\Customer\Api\GroupRepositoryInterface $zgEY9, \Magento\Store\Model\ResourceModel\Website\CollectionFactory $wgarJ, IpWhitelistedCollectionFactory $LAP7L, IpWhitelistedAdminCollectionFactory $M_blm, \Magento\Framework\UrlInterface $bH5GR, \Magento\Framework\Controller\ResultFactory $PkdPP, \Magento\Framework\Stdlib\CookieManagerInterface $ZxkwQ, \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $Tp5xy, \MiniOrange\TwoFA\Logger\Logger $GhTxV, \Magento\Framework\App\ProductMetadataInterface $iRUVN, DateTime $jZBU6, ManagerInterface $W4ola, WebsiteRepositoryInterface $BRht9, ModuleManager $AFMlx, \Magento\Framework\ObjectManagerInterface $Td1qi, \Magento\Customer\Api\CustomerRepositoryInterface $SV1G8, CustomerExtensionFactory $q7HnS)
    {
        $this->adminSession = $RCLDw;
        $this->customerSession = $WrUW4;
        $this->authSession = $wd_9B;
        $this->cacheTypeList = $cl1gb;
        $this->resource = $rvDYs;
        $this->cacheFrontendPool = $v5KJs;
        $this->fileSystem = $Z1ScI;
        $this->logger = $A8z1G;
        $this->dir = $knkEN;
        $this->reinitableConfig = $Bzn80;
        $this->coreSession = $DDEbR;
        $this->userContext = $f0euJ;
        $this->userFactory = $HIdrW;
        $this->userCollectionFactory = $GL2tl;
        $this->storeManager = $KQp5D;
        $this->customerModel = $z_MYO;
        $this->groupRepository = $zgEY9;
        $this->_websiteCollectionFactory = $wgarJ;
        $this->ipWhitelistedCollectionFactory = $LAP7L;
        $this->ipWhitelistedAdminCollectionFactory = $M_blm;
        $this->url = $bH5GR;
        $this->resultFactory = $PkdPP;
        $this->cookieManager = $ZxkwQ;
        $this->cookieMetadataFactory = $Tp5xy;
        $this->_logger = $GhTxV;
        $this->productMetadata = $iRUVN;
        $this->messageManager = $W4ola;
        $this->moduleManager = $AFMlx;
        $this->websiteRepository = $BRht9;
        $this->objectManager = $Td1qi;
        $this->customerRepository = $SV1G8;
        $this->customerExtensionFactory = $q7HnS;
        $this->initializeB2B();
        parent::__construct($t2suv, $N9Lzo, $BIHPx, $KwMdk, $UT_XN, $CZthx, $JCW9s, $pfeC5, $jZBU6);
    }
    private function initializeB2B()
    {
        try {
            if ($this->moduleManager->isEnabled("\x4d\141\147\x65\x6e\164\x6f\x5f\103\157\x6d\160\x61\x6e\x79")) {
                goto jLVNT;
            }
            return;
            jLVNT:
            if (!class_exists("\x4d\x61\147\x65\156\x74\x6f\134\103\157\155\160\x61\156\171\134\x41\160\151\134\104\141\x74\x61\134\103\x6f\155\160\x61\156\x79\103\165\163\x74\x6f\x6d\x65\162\111\x6e\164\x65\162\146\x61\143\x65\x46\x61\143\x74\x6f\x72\171")) {
                goto eZP2p;
            }
            $this->companyCustomerFactory = $this->objectManager->get(\Magento\Company\Api\Data\CompanyCustomerInterfaceFactory::class);
            eZP2p:
            if (!interface_exists("\115\x61\x67\145\x6e\164\x6f\134\103\157\155\x70\141\156\171\x5c\101\160\x69\134\x43\157\155\x70\x61\x6e\x79\x55\x73\145\162\x52\145\160\157\x73\151\x74\157\x72\x79\111\156\164\145\162\x66\141\x63\x65")) {
                goto b33Du;
            }
            $this->companyUserRepository = $this->objectManager->get(\Magento\Company\Api\CompanyUserRepositoryInterface::class);
            b33Du:
            if (!interface_exists("\115\x61\147\145\x6e\x74\x6f\134\x43\157\155\160\141\x6e\x79\134\101\160\x69\x5c\x43\x6f\155\x70\141\156\x79\x52\145\x70\157\163\x69\x74\x6f\x72\x79\111\156\x74\145\x72\146\141\143\145")) {
                goto rpgLT;
            }
            $this->companyRepository = $this->objectManager->get(\Magento\Company\Api\CompanyRepositoryInterface::class);
            rpgLT:
            if (!interface_exists("\115\141\147\x65\156\x74\x6f\x5c\103\157\155\160\x61\156\x79\x5c\x41\x70\x69\x5c\103\157\155\x70\141\x6e\x79\115\141\156\141\147\145\x6d\x65\156\x74\x49\156\164\145\162\x66\x61\143\145")) {
                goto MYd4M;
            }
            $this->companyManagement = $this->objectManager->get(\Magento\Company\Api\CompanyManagementInterface::class);
            MYd4M:
            if (!$this->moduleManager->isEnabled("\115\x61\147\145\156\x74\157\x5f\103\x75\x73\164\157\155\145\x72")) {
                goto BCLmG;
            }
            if (!class_exists("\115\141\147\145\x6e\164\157\x5c\x43\x75\163\x74\x6f\155\x65\162\x5c\x41\160\151\x5c\x44\x61\x74\141\134\103\x75\163\x74\157\x6d\x65\x72\105\170\164\145\156\163\x69\157\156\x49\156\x74\x65\162\146\141\x63\145\x46\141\143\x74\157\x72\171")) {
                goto WkKNJ;
            }
            $this->customerExtensionFactory = $this->objectManager->get(\Magento\Customer\Api\Data\CustomerExtensionInterfaceFactory::class);
            WkKNJ:
            BCLmG:
        } catch (\Exception $Lq40h) {
            $this->companyCustomerFactory = null;
            $this->companyUserRepository = null;
            $this->companyRepository = null;
            $this->companyManagement = null;
            $this->customerExtensionFactory = null;
        }
    }
    public function get_customer_detailss()
    {
        $M1pJH = $this->customerSession;
        $bn5mx = $M1pJH->getName();
        $CAytN = $M1pJH->getId();
        return $bn5mx;
    }
    public function getCustomer2FAMethodsFromRules($pisyB, $YunnG, $OQ92p = null)
    {
        $e9zNK = $this->getGlobalConfig(TwoFAConstants::CURRENT_CUSTOMER_RULE);
        if ($e9zNK) {
            goto TLfyf;
        }
        return ["\155\145\x74\x68\157\x64\x73" => "\x5b\135", "\143\x6f\x75\x6e\x74" => 0];
        TLfyf:
        $XbM_5 = json_decode($e9zNK, true);
        if (is_array($XbM_5)) {
            goto LkbEZ;
        }
        return ["\155\x65\164\150\x6f\144\163" => "\x5b\x5d", "\143\x6f\165\x6e\164" => 0];
        LkbEZ:
        $wqo9J = $this->getWebsiteNameById($YunnG);
        $yrE8I = null;
        $lIJVf = null;
        foreach ($XbM_5 as $WgbPM) {
            if (!(isset($WgbPM["\163\x69\x74\145"]) && isset($WgbPM["\x67\x72\157\x75\160"]) && isset($WgbPM["\x6d\x65\164\x68\157\x64\163"]) && !empty($WgbPM["\x6d\x65\164\x68\157\x64\163"]))) {
                goto CJ9Ls;
            }
            $tU7Q8 = $WgbPM["\163\151\x74\x65"] === "\101\x6c\x6c\x20\123\151\x74\145\163" || $wqo9J && $WgbPM["\x73\151\164\x65"] === $wqo9J;
            $s48R0 = $WgbPM["\147\162\157\x75\160"] === "\x41\154\154\x20\x47\162\157\x75\160\163" || $WgbPM["\x67\162\157\x75\x70"] === $pisyB;
            if (!($tU7Q8 && $s48R0)) {
                goto H4GFx;
            }
            if ($wqo9J && $WgbPM["\x73\151\164\145"] === $wqo9J) {
                goto z7L7Y;
            }
            if ($WgbPM["\x73\x69\x74\x65"] === "\101\154\x6c\40\123\151\x74\145\163") {
                goto kg5mH;
            }
            goto s9d5Y;
            z7L7Y:
            $yrE8I = $WgbPM;
            goto s9d5Y;
            kg5mH:
            $lIJVf = $WgbPM;
            s9d5Y:
            H4GFx:
            CJ9Ls:
            vFwas:
        }
        fbvu2:
        $GYa6m = $yrE8I ?: $lIJVf;
        if (!$GYa6m) {
            goto gv9Ku;
        }
        $xx1hX = [];
        foreach ($GYa6m["\155\x65\164\150\x6f\144\x73"] as $nHtHV) {
            if (!isset($nHtHV["\153\x65\171"])) {
                goto c3CgT;
            }
            $xx1hX[] = $nHtHV["\153\145\x79"];
            c3CgT:
            bWBlC:
        }
        IB70V:
        $fLQ1B = $yrE8I ? "\x77\x65\x62\x73\x69\x74\x65\55\163\x70\145\143\151\x66\151\x63" : "\147\x6c\x6f\x62\141\154";
        return ["\x6d\145\x74\150\157\x64\x73" => json_encode($xx1hX), "\143\x6f\x75\156\x74" => count($xx1hX)];
        gv9Ku:
        return ["\x6d\x65\x74\x68\157\x64\x73" => "\x5b\x5d", "\143\157\x75\156\x74" => 0];
    }
    public function get_all_websites()
    {
        $d9jv6 = $this->_websiteCollectionFactory->create();
        return $d9jv6;
    }
    public function getHiddenPhone($T2SYt)
    {
        $eGWrP = "\x78\x78\x78\170\x78\170\x78" . substr($T2SYt, strlen($T2SYt) - 3);
        return $eGWrP;
    }
    public function isCustomerRegistered()
    {
        if (!($this->check_license_plan(4) and !$this->isTrialExpired())) {
            goto bpoB_;
        }
        return true;
        bpoB_:
        $r8O7V = $this->getCustomerDetails();
        return !isset($r8O7V["\x65\155\x61\151\154"]) && ($r8O7V["\x65\x6d\141\x69\x6c"] === NULL || empty($r8O7V["\x65\x6d\x61\151\x6c"])) ? false : true;
    }
    public function check_license_plan($FwtYw)
    {
        return $this->get_license_plan() >= $FwtYw;
    }
    public function get_license_plan()
    {
        $mR1pN = $this->getStoreConfig(TwoFAConstants::LICENSE_PLAN);
        is_null($mR1pN) || empty($mR1pN) ? $mR1pN = "\155\x61\147\x65\156\x74\x6f\x5f\x32\x66\x61\137\164\162\151\x61\x6c\x5f\160\154\x61\156" : $mR1pN;
        return $mR1pN == "\x6d\141\x67\x65\156\x74\157\137\62\146\x61\x5f\164\162\151\x61\154\x5f\160\154\x61\156" ? 4 : ($mR1pN == "\x6d\141\147\x65\156\x74\157\x5f\x32\x66\141\137\x66\162\x6f\x6e\164\x65\156\144\137\160\154\x61\x6e" ? 3 : ($mR1pN == "\x6d\141\147\145\156\164\x6f\137\x32\146\141\137\142\x61\x63\x6b\x65\x6e\144\137\160\154\141\156" ? 2 : ($mR1pN == "\155\x61\x67\x65\x6e\x74\x6f\x5f\x32\x66\141\x5f\x70\x72\145\155\x69\x75\155\x5f\x70\x6c\141\156" ? 1 : 0)));
    }
    public function getCustomerDetails()
    {
        $aaEqu = $this->getStoreConfig(TwoFAConstants::CUSTOMER_EMAIL);
        $LvIx3 = $this->getStoreConfig(TwoFAConstants::CUSTOMER_KEY);
        $Vl5US = $this->getStoreConfig(TwoFAConstants::API_KEY);
        $UEsgv = $this->getStoreConfig(TwoFAConstants::TOKEN);
        $r8O7V = array("\x65\155\x61\151\x6c" => $aaEqu, "\x63\x75\x73\164\157\x6d\x65\x72\x5f\x4b\x65\171" => $LvIx3, "\141\x70\151\137\x4b\145\x79" => $Vl5US, "\164\157\x6b\x65\x6e" => $UEsgv);
        return $r8O7V;
    }
    public function isCurlInstalled()
    {
        if (in_array("\143\x75\162\154", get_loaded_extensions())) {
            goto v9kyn;
        }
        return 0;
        goto BcoQY;
        v9kyn:
        return 1;
        BcoQY:
    }
    public function getHiddenEmail($aaEqu)
    {
        if (!(!isset($aaEqu) || trim($aaEqu) === '')) {
            goto H_A4G;
        }
        return '';
        H_A4G:
        $AGfS1 = strlen($aaEqu);
        $YfR7x = substr($aaEqu, 0, 1);
        $dvUuy = strrpos($aaEqu, "\100");
        $aVxFJ = substr($aaEqu, $dvUuy - 1, $AGfS1);
        $sH3Jn = 1;
        gP6R1:
        if (!($sH3Jn < $dvUuy)) {
            goto t_XK3;
        }
        $YfR7x = $YfR7x . "\x78";
        Ku0ol:
        $sH3Jn++;
        goto gP6R1;
        t_XK3:
        $Uqksg = $YfR7x . $aVxFJ;
        return $Uqksg;
    }
    public function getAdminSession()
    {
        return $this->adminSession;
    }
    public function getImageUrl($a03lx)
    {
        return $this->assetRepo->getUrl(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_IMAGES . $a03lx);
    }
    public function tfaMethodArray()
    {
        return array("\x4f\x4f\123" => array("\x6e\141\x6d\145" => "\x4f\124\120\x20\117\166\145\x72\40\x53\x4d\123", "\x64\145\163\x63\162\x69\x70\164\x69\x6f\156" => "\x45\x6e\164\x65\162\40\164\x68\x65\40\117\x6e\145\x20\x54\x69\155\145\x20\120\x61\x73\163\143\x6f\x64\x65\x20\x73\x65\156\164\40\164\157\40\171\x6f\165\x72\x20\x70\150\x6f\156\x65\40\x74\157\40\154\157\x67\x69\x6e\56"), "\x4f\x4f\x57" => array("\x6e\x61\155\x65" => "\x4f\x54\x50\x20\117\166\x65\x72\40\x57\150\141\x74\x73\x61\160\160", "\x64\x65\x73\x63\162\x69\x70\164\151\157\x6e" => "\105\x6e\164\x65\162\x20\164\x68\x65\x20\117\156\x65\40\x54\x69\x6d\145\40\120\141\163\x73\143\157\144\145\40\163\x65\x6e\164\40\x74\x6f\x20\x79\157\x75\x72\x20\x77\150\x61\x74\163\x61\x70\160\40\x70\150\157\x6e\x65\40\164\x6f\x20\x6c\157\147\x69\156\56"), "\x4f\117\105" => array("\156\141\x6d\145" => "\117\x54\120\40\x4f\166\145\x72\x20\105\155\141\151\154", "\144\145\163\x63\x72\x69\x70\x74\x69\x6f\156" => "\105\156\x74\x65\162\x20\164\x68\145\40\x4f\x6e\x65\40\x54\151\x6d\145\x20\x50\141\163\x73\143\x6f\x64\145\x20\163\145\156\x74\40\164\157\x20\171\x6f\x75\x72\x20\145\155\x61\151\154\40\164\157\40\x6c\x6f\x67\151\156\56"), "\117\x4f\x53\105" => array("\156\x61\x6d\x65" => "\117\124\120\x20\x4f\166\145\x72\40\123\115\x53\40\x61\x6e\x64\40\105\x6d\x61\151\154", "\144\145\163\143\x72\151\x70\x74\x69\157\x6e" => "\105\156\164\x65\x72\x20\x74\150\145\40\117\x6e\x65\40\x54\151\155\x65\40\x50\141\x73\163\x63\x6f\144\x65\x20\x73\145\156\164\40\x74\157\40\171\x6f\165\x72\40\x70\150\157\x6e\145\40\141\x6e\144\x20\145\x6d\x61\x69\x6c\x20\x74\157\x20\154\x6f\x67\151\156\x2e"), "\107\157\157\147\x6c\x65\x41\x75\x74\x68\145\156\x74\x69\143\141\x74\157\162" => array("\156\x61\155\145" => "\x47\157\157\x67\x6c\x65\x20\x41\x75\164\x68\145\x6e\164\x69\143\141\164\157\162", "\x64\x65\163\143\x72\151\x70\164\x69\157\156" => "\105\x6e\164\145\162\x20\164\150\145\x20\163\157\146\x74\40\x74\157\153\x65\156\40\146\162\157\x6d\40\164\150\145\40\141\x63\143\x6f\165\156\164\40\x69\156\x20\x79\x6f\165\162\x20\x47\157\157\x67\x6c\x65\x20\101\165\164\150\x65\x6e\164\151\x63\x61\x74\x6f\x72\40\101\x70\160\x20\x74\x6f\x20\x6c\x6f\x67\151\x6e\x2e"), "\x4d\x69\143\x72\157\x73\x6f\x66\x74\x41\x75\x74\150\145\x6e\164\x69\143\141\x74\x6f\162" => array("\156\141\155\x65" => "\x4d\x69\143\x72\157\x73\157\146\164\40\x41\x75\164\x68\x65\x6e\x74\x69\x63\x61\x74\x6f\162", "\144\x65\x73\x63\162\x69\x70\164\151\157\156" => "\x45\156\164\145\162\40\x74\150\x65\x20\163\x6f\146\x74\40\x74\x6f\153\x65\x6e\40\x66\162\157\155\40\164\x68\x65\x20\x61\143\143\157\x75\156\x74\40\151\156\x20\171\x6f\165\162\x20\115\x69\x63\x72\x6f\163\157\146\164\x20\101\x75\164\150\145\156\x74\x69\143\x61\164\x6f\x72\40\101\x70\160\40\x74\x6f\40\154\157\x67\151\156\56"), "\117\153\164\141\126\145\x72\x69\146\171" => array("\x6e\141\x6d\145" => "\x4f\153\x74\x61\x20\x56\x65\162\x69\146\x79", "\x64\x65\163\143\x72\151\160\164\x69\157\x6e" => "\x59\x6f\x75\40\150\x61\166\145\40\x74\157\x20\163\143\141\156\40\x74\x68\x65\40\121\122\40\x63\x6f\x64\145\x20\146\x72\157\x6d\x20\x4f\153\164\x61\x20\126\145\x72\x69\146\x79\40\x41\x70\160\40\x61\156\144\x20\145\x6e\164\145\162\40\x63\x6f\x64\145\x20\x67\x65\x6e\145\x72\x61\x74\x65\x64\40\x62\171\x20\x61\160\x70\40\164\x6f\x20\154\x6f\147\151\156\56\40\123\x75\x70\x70\157\x72\x74\145\x64\x20\x69\156\40\x53\155\141\162\x74\x70\150\157\x6e\145\163\x20\x6f\156\154\171\56"), "\104\x75\x6f\x41\x75\x74\x68\x65\x6e\x74\151\143\x61\164\x6f\x72" => array("\x6e\x61\155\x65" => "\x44\x75\157\x20\x41\165\164\150\145\x6e\164\151\143\x61\164\157\162", "\144\x65\163\143\162\x69\x70\x74\151\x6f\x6e" => "\x59\x6f\165\x20\150\141\x76\x65\x20\x74\x6f\x20\163\x63\x61\x6e\40\164\150\x65\x20\x51\122\x20\x63\157\x64\145\40\x66\x72\157\x6d\40\x44\165\157\x20\x41\165\164\150\145\x6e\x74\x69\x63\141\x74\x6f\162\40\101\160\160\x20\141\x6e\x64\40\x65\156\x74\x65\x72\x20\x63\157\x64\145\40\147\145\x6e\x65\x72\x61\x74\145\144\x20\x62\171\x20\x61\x70\160\40\164\157\40\154\x6f\x67\x69\x6e\56\40\123\165\x70\160\157\x72\x74\x65\x64\x20\x69\x6e\x20\123\155\x61\x72\164\x70\150\157\156\x65\163\x20\157\x6e\x6c\171\x2e"), "\101\x75\164\x68\171\x41\x75\164\x68\145\x6e\x74\151\143\141\164\x6f\162" => array("\x6e\141\x6d\x65" => "\101\x75\164\150\171\x20\x41\x75\x74\x68\145\x6e\164\151\x63\141\x74\x6f\162", "\144\x65\163\143\162\x69\x70\164\x69\x6f\x6e" => "\131\157\x75\x20\150\x61\x76\145\x20\164\x6f\x20\163\x63\x61\156\40\x74\150\145\x20\121\122\x20\x63\157\144\x65\x20\146\162\x6f\155\x20\x41\165\x74\x68\x79\x20\x41\165\x74\150\x65\156\164\151\143\x61\x74\x6f\x72\40\101\160\x70\x20\x61\156\x64\40\145\x6e\164\x65\162\x20\x63\157\144\x65\x20\147\x65\156\145\162\141\164\145\x64\40\142\171\x20\x61\160\x70\x20\x74\x6f\40\x6c\157\x67\x69\x6e\56\40\x53\165\x70\160\157\162\x74\x65\144\40\151\156\x20\x53\x6d\x61\x72\164\160\x68\x6f\156\145\163\x20\x6f\x6e\x6c\x79\56"), "\114\x61\x73\164\x50\141\163\163\x41\x75\164\x68\x65\156\x74\x69\143\x61\164\157\x72" => array("\x6e\141\155\145" => "\x4c\141\163\164\120\x61\x73\x73\x20\x41\x75\x74\x68\145\156\164\151\143\x61\164\157\162", "\144\x65\x73\x63\162\151\x70\x74\x69\x6f\x6e" => "\x59\157\165\x20\x68\x61\x76\145\x20\x74\x6f\40\x73\x63\x61\156\x20\164\150\x65\40\x51\122\x20\143\157\x64\x65\x20\146\162\x6f\155\x20\x4c\x61\163\164\x50\x61\x73\x73\x20\101\165\164\150\x65\x6e\164\151\x63\x61\164\157\x72\40\x41\160\x70\x20\141\156\144\x20\x65\156\x74\145\x72\40\143\157\144\x65\x20\x67\x65\156\x65\x72\x61\x74\145\144\x20\x62\171\40\x61\x70\x70\x20\164\157\x20\154\x6f\x67\x69\x6e\x2e\x20\123\x75\x70\x70\x6f\x72\x74\x65\144\x20\x69\156\x20\123\155\141\x72\164\x70\150\x6f\x6e\x65\163\40\157\x6e\x6c\x79\56"), "\x51\122\103\157\x64\145\x41\x75\x74\x68\145\x6e\164\x69\x63\x61\x74\x6f\162" => array("\156\141\x6d\145" => "\121\x52\x20\103\x6f\144\145\40\101\165\164\x68\145\156\164\x69\x63\141\x74\x69\x6f\156", "\144\145\163\x63\x72\x69\160\x74\151\157\x6e" => "\131\157\x75\40\x68\141\166\145\40\x74\x6f\x20\x73\143\x61\x6e\40\164\150\145\40\x51\122\x20\103\157\x64\145\x20\x66\162\x6f\x6d\40\x79\157\x75\x72\x20\x70\150\x6f\156\x65\40\x75\163\x69\156\147\x20\155\151\156\x69\117\x72\141\156\x67\x65\x20\101\x75\x74\150\145\x6e\x74\151\143\141\164\157\162\40\x41\x70\160\40\x74\x6f\x20\154\x6f\147\151\x6e\x2e\x20\123\x75\x70\160\x6f\x72\x74\145\x64\40\x69\x6e\x20\123\155\x61\162\164\x70\x68\157\x6e\145\163\x20\157\156\154\x79\56"), "\113\102\101" => array("\156\141\155\x65" => "\x53\x65\x63\165\x72\x69\164\x79\x20\121\x75\145\163\164\151\157\x6e\x73\40\x28\x4b\102\x41\51", "\144\x65\163\x63\x72\x69\160\x74\x69\157\156" => "\x59\157\165\40\150\x61\166\x65\x20\164\157\x20\x61\x6e\x73\x77\145\x72\x73\40\163\157\155\x65\x20\x6b\x6e\x6f\x77\x6c\145\x64\x67\145\x20\x62\x61\x73\145\x64\x20\x73\145\143\x75\x72\x69\x74\171\x20\161\x75\x65\163\164\151\157\x6e\x73\x20\x77\x68\151\x63\150\40\x61\x72\x65\40\x6f\156\154\x79\x20\x6b\x6e\157\167\x6e\40\x74\x6f\x20\171\x6f\x75\x20\x74\157\40\141\165\164\150\145\x6e\164\151\x63\x61\164\x65\x20\171\157\x75\x72\163\x65\x6c\x66\56"), "\117\x4f\120" => array("\156\141\x6d\x65" => "\x4f\x54\x50\40\117\166\x65\x72\x20\x50\x68\157\x6e\145", "\x64\x65\x73\143\162\151\x70\x74\x69\157\x6e" => "\x59\x6f\165\40\x77\151\x6c\x6c\x20\162\145\x63\145\151\166\x65\40\x61\x20\157\x6e\x65\40\164\x69\155\145\x20\160\141\x73\163\x63\157\x64\145\x20\x76\151\x61\x20\160\150\x6f\156\145\40\143\x61\x6c\x6c\x2e\x20\131\157\x75\x20\150\141\x76\x65\x20\164\157\40\145\x6e\164\145\x72\40\164\x68\145\40\x6f\164\160\40\x6f\156\x20\171\x6f\165\162\40\x73\x63\x72\145\x65\x6e\40\164\x6f\x20\x6c\x6f\147\x69\156\x2e\40\123\x75\x70\x70\x6f\162\164\x65\144\x20\151\156\x20\x53\155\141\x72\x74\160\x68\x6f\156\x65\163\54\40\106\145\141\164\x75\x72\x65\40\x50\150\x6f\156\x65\x73\56"), "\131\x75\142\x69\153\145\x79\x48\141\x72\144\167\141\x72\145\x54\157\x6b\x65\156" => array("\156\141\155\145" => "\131\165\x62\151\x6b\145\x79\40\x48\x61\x72\144\167\141\162\x65\x20\x54\x6f\153\145\156", "\x64\145\x73\x63\x72\x69\x70\x74\151\x6f\x6e" => "\x59\x6f\165\x20\143\x61\156\40\x70\x72\145\x73\x73\40\x74\x68\x65\40\x62\x75\164\x74\157\156\40\157\156\x20\x79\157\x75\x72\40\171\x75\142\151\x6b\x65\171\x20\110\x61\x72\144\167\141\x72\145\x20\164\x6f\153\x65\156\x20\167\150\x69\143\150\x20\x67\145\156\x65\162\141\x74\x65\x20\x61\x20\x72\141\x6e\x64\157\x6d\x20\153\x65\171\56\x20\x59\157\165\x20\143\x61\x6e\x20\x75\163\145\40\164\150\141\164\x20\x6b\x65\171\x20\x74\x6f\40\141\x75\164\x68\x65\156\164\151\143\141\x74\x65\40\x79\x6f\x75\162\x73\145\x6c\146\x2e"), "\x50\165\x73\x68\x4e\157\x74\151\146\x69\143\141\164\x69\x6f\x6e\163\x72" => array("\x6e\x61\x6d\145" => "\120\165\x73\150\x20\x4e\157\x74\x69\x66\x69\x63\141\x74\151\x6f\x6e\x73", "\144\145\163\143\x72\x69\x70\164\151\x6f\x6e" => "\131\157\x75\x20\x77\151\154\x6c\x20\x72\145\143\x65\151\166\x65\x20\141\x20\x70\x75\x73\150\x20\x6e\x6f\x74\151\x66\151\x63\x61\x74\151\x6f\x6e\40\157\156\x20\x79\157\165\162\x20\160\150\x6f\x6e\145\x2e\40\131\x6f\165\40\150\141\x76\x65\x20\x74\157\40\101\x43\x43\105\120\124\x20\157\x72\40\104\x45\x4e\x59\40\151\164\x20\x74\157\40\x6c\157\x67\x69\156\x2e\40\123\x75\160\160\x6f\x72\164\145\x64\x20\x69\x6e\40\x53\x6d\x61\162\164\x70\x68\x6f\x6e\x65\x73\x20\157\156\x6c\171\56"), "\123\157\x66\164\124\x6f\x6b\145\156" => array("\156\x61\x6d\x65" => "\123\157\146\164\x20\124\157\x6b\x65\x6e", "\x64\x65\x73\x63\162\x69\160\164\151\x6f\x6e" => "\x59\157\165\40\x68\141\x76\x65\x20\x74\x6f\40\x65\x6e\x74\145\x72\40\160\141\163\163\x63\157\x64\145\x20\x67\145\156\145\162\141\x74\145\x64\40\x62\x79\40\x6d\151\156\x69\x4f\x72\141\x6e\x67\145\x20\x41\x75\x74\150\x65\x6e\164\151\143\141\164\157\x72\x20\x41\x70\160\40\164\157\x20\x6c\x6f\x67\151\156\56\40\x53\165\160\160\157\x72\x74\145\x64\40\x69\156\40\123\x6d\141\162\164\x70\150\157\156\x65\x73\x20\157\156\154\171\x2e"), "\x45\x6d\x61\x69\x6c\x56\x65\x72\x69\x66\x69\x63\141\x74\151\x6f\x6e" => array("\x6e\x61\x6d\x65" => "\x45\x6d\141\x69\154\40\126\145\162\x69\x66\x69\143\141\x74\x69\x6f\156", "\144\x65\163\143\x72\x69\160\x74\x69\157\156" => "\x59\x6f\x75\x20\x77\x69\x6c\x6c\x20\x72\x65\143\145\x69\166\x65\40\x61\x6e\40\x65\x6d\x61\151\154\x20\x77\x69\x74\150\x20\x6c\151\x6e\153\56\x20\131\157\165\x20\x68\x61\x76\145\40\x74\x6f\x20\x63\x6c\151\143\x6b\x20\164\150\145\x20\x41\103\103\105\x50\x54\40\x6f\x72\40\104\x45\x4e\x59\40\154\x69\156\153\x20\x74\157\x20\x76\x65\162\x69\146\x79\x20\x79\x6f\x75\162\40\x65\155\x61\x69\154\x2e\40\x53\165\x70\x70\157\162\x74\x65\x64\40\151\x6e\40\104\145\x73\x6b\x74\x6f\x70\163\54\x20\114\141\x70\164\157\x70\x73\54\x20\x53\x6d\141\x72\x74\160\x68\157\x6e\145\163\56"));
    }
    public function AuthenticatorUrl()
    {
        $this->log_debug("\111\x6e\x73\x69\x64\145\40\x61\165\x74\x68\145\x6e\164\x69\143\x61\164\x6f\162\x20\x75\x72\154");
        if ($this->getSessionValue(TwoFAConstants::ADMIN_IS_INLINE)) {
            goto v76xJ;
        }
        $OQ92p = $this->getCurrentAdminUser()->getUsername();
        goto o_i_E;
        v76xJ:
        $OQ92p = $this->getSessionValue(TwoFAConstants::ADMIN_USERNAME);
        o_i_E:
        $BzcBX = $this->helperBackend->getAreaFrontName();
        $Xa9JE = $this->urlInterface->getCurrentUrl();
        if (strpos($Xa9JE, $BzcBX) !== false) {
            goto s3c9z;
        }
        $TFqWY = $this->getCustomerMoTfaUserDetails("\x6d\151\156\151\157\x72\x61\156\147\145\137\164\146\141\x5f\165\163\x65\162\x73", $OQ92p);
        goto W37GR;
        s3c9z:
        $TFqWY = $this->getAllMoTfaUserDetails("\155\151\x6e\x69\157\x72\141\156\147\x65\x5f\164\146\141\137\165\x73\x65\162\163", $OQ92p, -1);
        W37GR:
        $ZXtEF = $this->getAuthenticatorSecret($OQ92p);
        $Cv7a8 = $this->getSessionValue(TwoFAConstants::PRE_SECRET);
        if (!$this->getSessionValue(TwoFAConstants::ADMIN_IS_INLINE)) {
            goto bCOiR;
        }
        $Cv7a8 = $this->getSessionValue(TwoFAConstants::ADMIN_SECRET);
        bCOiR:
        if (!is_array($TFqWY) || sizeof($TFqWY) <= 0) {
            goto iaBix;
        }
        if (!(isset($TFqWY[0]["\x73\153\x69\x70\137\x74\x77\x6f\x66\141"]) && $TFqWY[0]["\x73\153\x69\x70\137\x74\167\x6f\146\x61"] > 0)) {
            goto ZAayX;
        }
        if ($Cv7a8 != NULL) {
            goto EBBkL;
        }
        $ZXtEF = $this->generateRandomString();
        $this->setSessionValue(TwoFAConstants::PRE_SECRET, $ZXtEF);
        goto i3mVM;
        EBBkL:
        $ZXtEF = $Cv7a8;
        i3mVM:
        ZAayX:
        goto vsmvr;
        iaBix:
        if ($Cv7a8 == NULL) {
            goto FjiZP;
        }
        $ZXtEF = $Cv7a8;
        goto U_N3M;
        FjiZP:
        $ZXtEF = $this->generateRandomString();
        $this->setSessionValue(TwoFAConstants::PRE_SECRET, $ZXtEF);
        U_N3M:
        vsmvr:
        $rt0Sg = $this->AuthenticatorIssuer();
        $bH5GR = "\157\x74\160\x61\165\x74\x68\72\57\57\164\157\164\x70\57";
        $bH5GR .= $OQ92p . "\x3f\163\x65\143\162\145\164\x3d" . $ZXtEF . "\x26\x69\x73\163\x75\x65\x72\75" . $rt0Sg;
        return $bH5GR;
    }
    public function log_debug($U60fw = '', $gA7xQ = null)
    {
        if (is_object($U60fw)) {
            goto GIfTg;
        }
        $this->customlog("\115\117\x20\124\167\x6f\x46\101\x20\x70\x72\145\x6d\151\165\155\x3a\x20" . $U60fw);
        goto uw3VA;
        GIfTg:
        $this->customlog("\115\x4f\40\124\167\x6f\106\101\x20\x70\x72\145\x6d\x69\x75\x6d\x3a\40" . print_r($gA7xQ, true));
        uw3VA:
        if (!($gA7xQ != null)) {
            goto AQFgN;
        }
        $this->customlog("\x4d\117\x20\x54\167\x6f\106\x41\40\160\162\145\155\x69\x75\x6d\40\72\x20" . var_export($gA7xQ, true));
        AQFgN:
    }
    public function customlog($wEcOW)
    {
        $this->isLogEnable() ? $this->_logger->debug($wEcOW) : null;
    }
    public function isLogEnable()
    {
        return $this->getStoreConfig(TwoFAConstants::ENABLE_DEBUG_LOG);
    }
    public function getSessionValue($ivT_a)
    {
        $nLALl = $this->getCompleteSession();
        return isset($nLALl[$ivT_a]) ? $nLALl[$ivT_a] : null;
    }
    public function getCompleteSession()
    {
        $this->coreSession->start();
        $i4YYt = $this->coreSession->getMyTestValue();
        return $i4YYt !== null ? $i4YYt : array();
    }
    public function getCurrentAdminUser()
    {
        return $this->authSession->getUser();
    }
    public function getAllMoTfaUserDetails($Rsl0O, $OQ92p = false, $FCDQy = false)
    {
        if ($this->ifSandboxTrialEnabled()) {
            goto nSYBe;
        }
        $ArCvF = $this->resource->getConnection()->select()->from($Rsl0O, ["\x75\x73\145\x72\x6e\141\x6d\x65", "\x61\143\164\x69\x76\145\x5f\155\x65\x74\150\157\144", "\143\x6f\x6e\x66\x69\147\165\162\145\x64\x5f\155\x65\x74\x68\x6f\144\163", "\x65\x6d\141\x69\x6c", "\160\150\157\x6e\145", "\164\x72\x61\156\x73\141\x63\x74\x69\157\x6e\x49\144", "\163\145\143\162\x65\x74", "\x69\x64", "\143\157\x75\x6e\x74\162\x79\143\157\x64\x65", "\x6b\142\x61\137\155\145\164\x68\157\x64", "\x77\145\142\x73\x69\x74\x65\x5f\x69\x64", "\x73\153\x69\160\x5f\164\167\157\146\x61", "\x73\153\x69\x70\x5f\x74\167\157\x66\x61\137\x63\x6f\156\x66\151\x67\165\162\145\x64\137\x64\141\x74\x65", "\163\153\151\160\137\164\167\x6f\146\x61\137\x70\x72\x65\155\141\156\145\156\164", "\144\x65\x76\151\x63\x65\x5f\x69\156\146\x6f", "\144\151\163\141\142\x6c\145\x5f\62\x66\x61"])->where("\165\x73\x65\x72\156\x61\x6d\x65\x3d\x27" . $OQ92p . "\47\40\x61\x6e\x64\x20\x77\145\x62\163\x69\164\145\137\x69\x64\75\47" . $FCDQy . "\47");
        goto GBjMZ;
        nSYBe:
        $ArCvF = $this->resource->getConnection()->select()->from($Rsl0O, ["\165\163\145\x72\156\x61\x6d\145", "\x61\x63\x74\x69\166\145\137\155\145\x74\x68\157\144", "\x63\157\x6e\146\x69\147\165\162\145\x64\x5f\x6d\x65\x74\150\x6f\144\163", "\x65\x6d\141\x69\x6c", "\160\x68\157\156\x65", "\164\x72\141\x6e\x73\x61\x63\164\x69\157\156\111\144", "\163\x65\x63\162\145\164", "\x69\144", "\x63\x6f\x75\x6e\164\162\171\143\157\x64\145", "\x6b\142\141\137\155\145\x74\150\157\144", "\167\x65\142\x73\x69\x74\x65\x5f\x69\144", "\163\153\151\x70\x5f\x74\167\x6f\146\141", "\x73\x6b\151\160\137\164\167\x6f\x66\x61\x5f\143\x6f\156\x66\151\x67\165\162\145\x64\137\144\x61\x74\x65", "\163\x6b\151\160\x5f\164\167\x6f\x66\141\x5f\x70\162\145\x6d\141\x6e\145\x6e\x74", "\144\145\x76\x69\143\x65\137\x69\x6e\x66\x6f", "\x64\151\x73\141\x62\x6c\x65\x5f\62\x66\x61"])->where("\x75\163\x65\x72\x6e\141\x6d\x65\x3d\47" . $OQ92p . "\x27");
        GBjMZ:
        $EGw0a = $this->resource->getConnection()->fetchAll($ArCvF);
        return $EGw0a;
    }
    public function getCustomerMoTfaUserDetails($Rsl0O, $OQ92p = false)
    {
        $YunnG = $this->getWebsiteOrStoreBasedOnTrialStatus();
        if ($this->ifSandboxTrialEnabled()) {
            goto pE3uS;
        }
        $ArCvF = $this->resource->getConnection()->select()->from($Rsl0O, ["\165\163\x65\x72\156\x61\155\x65", "\141\143\164\x69\x76\x65\x5f\155\145\164\x68\157\x64", "\x63\x6f\x6e\x66\151\147\x75\x72\x65\x64\x5f\155\x65\x74\150\157\x64\x73", "\x65\x6d\141\x69\154", "\x70\150\x6f\156\145", "\x74\162\x61\156\163\x61\x63\x74\151\x6f\156\111\x64", "\x73\x65\143\x72\145\164", "\151\x64", "\143\x6f\165\x6e\164\x72\171\x63\157\144\145", "\x6b\x62\141\137\x6d\x65\164\150\x6f\144", "\167\x65\x62\x73\151\164\x65\137\151\144", "\163\153\x69\160\x5f\164\167\157\x66\141", "\x73\153\x69\x70\x5f\x74\167\x6f\x66\141\137\143\x6f\156\146\151\x67\x75\162\145\144\137\x64\141\x74\145", "\x73\153\x69\x70\x5f\x74\x77\x6f\x66\141\137\160\x72\x65\x6d\x61\156\x65\156\164", "\144\x65\x76\x69\143\x65\x5f\151\156\x66\157", "\144\x69\x73\141\x62\154\145\x5f\x32\x66\x61", "\x67\x6f\x6f\x67\154\x65\x5f\x61\165\164\x68\145\x6e\x74\x69\143\141\164\157\x72\x5f\163\x65\143\162\145\164", "\x6d\151\x63\162\x6f\x73\x6f\146\x74\137\141\x75\164\x68\x65\x6e\164\x69\143\x61\x74\x6f\x72\x5f\163\145\143\162\145\164", "\x73\155\x73\x5f\141\154\x74\145\x72\x6e\x61\x74\145\x5f\x32\146\141\x5f\155\145\x74\150\x6f\144", "\x61\154\154\x5f\141\143\164\151\x76\145\x5f\x6d\145\164\x68\x6f\144\x73"])->where("\165\x73\145\x72\156\x61\x6d\145\75\47" . $OQ92p . "\47\40\141\156\x64\x20\x77\x65\142\163\151\x74\145\x5f\x69\x64\75\x27" . $YunnG . "\x27");
        goto jc2so;
        pE3uS:
        $ArCvF = $this->resource->getConnection()->select()->from($Rsl0O, ["\x75\163\x65\x72\x6e\141\155\x65", "\x61\x63\x74\151\166\x65\137\155\145\x74\150\157\144", "\x63\157\156\x66\x69\147\165\x72\x65\144\137\155\145\x74\150\157\x64\163", "\145\x6d\x61\x69\x6c", "\160\x68\x6f\x6e\145", "\164\x72\x61\x6e\x73\x61\x63\x74\151\x6f\x6e\x49\x64", "\x73\145\x63\162\145\164", "\151\x64", "\143\x6f\x75\x6e\164\x72\x79\x63\157\x64\x65", "\x6b\142\141\x5f\x6d\x65\164\x68\x6f\144", "\x77\x65\142\163\x69\x74\145\137\151\x64", "\163\x6b\151\160\x5f\x74\167\157\x66\141", "\163\153\x69\x70\137\x74\167\x6f\146\141\x5f\x63\157\x6e\x66\x69\x67\165\x72\145\x64\x5f\144\141\x74\145", "\163\x6b\x69\160\137\x74\167\x6f\x66\x61\137\160\x72\145\155\x61\x6e\x65\x6e\x74", "\x64\x65\166\151\x63\x65\137\x69\156\x66\157", "\x64\151\163\141\142\154\145\x5f\62\x66\141", "\147\x6f\x6f\x67\x6c\145\x5f\x61\x75\164\x68\x65\156\x74\151\x63\x61\164\x6f\162\x5f\x73\145\x63\162\145\x74", "\155\x69\x63\162\x6f\163\x6f\146\x74\x5f\x61\x75\164\x68\x65\x6e\164\151\x63\x61\x74\157\x72\137\x73\x65\x63\162\x65\x74", "\x73\155\163\137\x61\154\x74\145\x72\x6e\141\x74\145\x5f\62\x66\x61\x5f\155\x65\x74\150\157\144", "\141\154\x6c\137\x61\x63\x74\151\x76\x65\x5f\155\145\x74\150\x6f\x64\163"])->where("\x75\x73\145\x72\156\141\155\145\x3d\x27" . $OQ92p . "\x27");
        jc2so:
        $EGw0a = $this->resource->getConnection()->fetchAll($ArCvF);
        return $EGw0a;
    }
    public function getAuthenticatorSecret($iwHG8)
    {
        $this->log_debug("\111\156\163\151\x64\145\40\147\x65\164\x41\165\x74\x68\145\156\x74\151\143\x61\x74\157\162\123\x65\143\x72\145\x74\56\40\147\x65\x6e\x65\x72\141\x74\x69\x6e\x67\x20\x73\x65\143\162\145\x74");
        $BzcBX = $this->helperBackend->getAreaFrontName();
        $Xa9JE = $this->urlInterface->getCurrentUrl();
        if (strpos($Xa9JE, $BzcBX) !== false) {
            goto PVhWj;
        }
        $TFqWY = $this->getCustomerMoTfaUserDetails("\x6d\x69\x6e\x69\x6f\x72\x61\x6e\x67\x65\137\164\x66\x61\x5f\x75\163\x65\x72\163", $iwHG8);
        goto TZHlo;
        PVhWj:
        $TFqWY = $this->getAllMoTfaUserDetails("\x6d\x69\156\151\157\162\141\156\x67\145\x5f\164\x66\141\x5f\x75\163\x65\162\163", $iwHG8, -1);
        TZHlo:
        if (is_array($TFqWY) && sizeof($TFqWY) > 0 && (isset($TFqWY[0]["\163\153\151\160\137\x74\167\x6f\x66\141"]) && ($TFqWY[0]["\163\153\x69\160\x5f\164\x77\157\x66\x61"] == NULL || $TFqWY[0]["\x73\x6b\x69\160\x5f\x74\x77\x6f\146\x61"] == ''))) {
            goto et2U4;
        }
        return false;
        goto ZqY9w;
        et2U4:
        return isset($TFqWY[0]["\x73\x65\143\x72\145\x74"]) ? $TFqWY[0]["\163\x65\x63\162\x65\x74"] : false;
        ZqY9w:
    }
    function generateRandomString($OOLsm = 16)
    {
        $idEiz = "\x41\x42\103\x44\105\106\107\110\111\x4a\x4b\x4c\115\x4e\117\x50\121\x52\123\x54\125\126\127\x58\x59\132";
        $OWcUq = strlen($idEiz);
        $lVWuy = '';
        $sH3Jn = 0;
        s6Z7I:
        if (!($sH3Jn < $OOLsm)) {
            goto JaMPR;
        }
        $lVWuy .= $idEiz[rand(0, $OWcUq - 1)];
        kCiAH:
        $sH3Jn++;
        goto s6Z7I;
        JaMPR:
        return $lVWuy;
    }
    public function setSessionValue($ivT_a, $J9bAi)
    {
        $nLALl = $this->getCompleteSession();
        $nLALl[$ivT_a] = $J9bAi;
        $this->coreSession->setMyTestValue($nLALl);
    }
    public function AuthenticatorIssuer()
    {
        $GlHtf = $this->getStoreConfig(TwoFAConstants::AUTHENTICATOR_APP_NAME_ENABLED);
        if (!$GlHtf) {
            goto ka_3R;
        }
        $qAuOF = $this->getStoreConfig(TwoFAConstants::AUTHENTICATOR_APP_NAME);
        if (empty(trim($qAuOF))) {
            goto FULUq;
        }
        return trim($qAuOF);
        FULUq:
        ka_3R:
        $pjz9n = $this->getStoreConfig(TwoFAConstants::TwoFA_AUTHENTICATOR_ISSUER);
        return $pjz9n != NULL && $pjz9n != '' ? $pjz9n : "\x6d\151\x6e\x69\117\x72\x61\156\147\145";
    }
    public function AuthenticatorCustomerUrl($aaEqu)
    {
        $this->log_debug("\151\x6e\x73\x69\144\x65\40\141\165\164\x68\x65\156\164\x69\x63\141\x74\157\x72\40\x63\165\x73\x74\157\155\x65\162\40\165\162\154");
        $Cv7a8 = $this->getSessionValue("\143\165\x73\x74\x6f\x6d\x65\x72\137\151\x6e\x6c\x69\x6e\x65\x5f\163\145\x63\x72\145\x74");
        if ($Cv7a8 == NULL) {
            goto NW_Sr;
        }
        $this->log_debug("\x41\165\164\150\x65\x6e\164\151\x63\141\x74\157\162\103\x75\x73\x74\x6f\155\x65\x72\x55\162\154\72\40\x73\x65\143\162\145\164\x5f\x61\x6c\162\x65\141\x64\171\x5f\163\x65\x74\x3a\x20");
        $ZXtEF = $Cv7a8;
        goto aGHhs;
        NW_Sr:
        $this->log_debug("\101\165\x74\x68\145\x6e\x74\x69\x63\141\164\x6f\162\103\x75\x73\164\157\155\145\x72\x55\162\x6c\72\x20\163\x65\143\162\x65\x74\x5f\141\x6c\x72\x65\x61\x64\x79\137\x73\145\x74\x20\x69\163\x20\x4e\125\114\x4c");
        $ZXtEF = $this->generateRandomString();
        $this->setSessionValue("\143\165\163\164\x6f\155\x65\162\x5f\151\156\x6c\151\156\145\137\x73\x65\x63\x72\145\x74", $ZXtEF);
        aGHhs:
        $rt0Sg = $this->AuthenticatorIssuer();
        $bH5GR = "\157\x74\160\141\x75\164\x68\72\x2f\57\x74\x6f\x74\x70\x2f";
        $bH5GR .= $aaEqu . "\x3f\x73\x65\x63\162\x65\x74\75" . $ZXtEF . "\46\x69\x73\x73\165\x65\x72\75" . $rt0Sg;
        $this->log_debug("\x51\122\40\x55\x72\154\72\x20", $bH5GR);
        return $bH5GR;
    }
    public function getCustomerSecret()
    {
        return $this->getSessionValue("\x63\165\x73\164\x6f\155\x65\x72\x5f\x69\x6e\x6c\151\156\145\x5f\163\x65\143\162\x65\164");
    }
    public function getAdminSecret()
    {
        $Cv7a8 = $this->getSessionValue(TwoFAConstants::PRE_SECRET);
        if (!$this->getSessionValue(TwoFAConstants::ADMIN_IS_INLINE)) {
            goto xM42u;
        }
        $Cv7a8 = $this->getSessionValue(TwoFAConstants::ADMIN_SECRET);
        xM42u:
        return $Cv7a8;
    }
    public function getAdminSessionData($ivT_a, $jo43Z = false)
    {
        return $this->adminSession->getData($ivT_a, $jo43Z);
    }
    public function setSessionData($ivT_a, $J9bAi)
    {
        return $this->customerSession->setData($ivT_a, $J9bAi);
    }
    public function getSessionData($ivT_a, $jo43Z = false)
    {
        return $this->customerSession->getData($ivT_a, $jo43Z);
    }
    public function setSessionValueForCurrentUser($ivT_a, $J9bAi)
    {
        if ($this->customerSession->isLoggedIn()) {
            goto dJgj1;
        }
        if ($this->authSession->isLoggedIn()) {
            goto a2m2r;
        }
        goto W9r0F;
        dJgj1:
        $this->setSessionValue($ivT_a, $J9bAi);
        goto W9r0F;
        a2m2r:
        $this->setAdminSessionData($ivT_a, $J9bAi);
        W9r0F:
    }
    public function setAdminSessionData($ivT_a, $J9bAi)
    {
        return $this->adminSession->setData($ivT_a, $J9bAi);
    }
    public function isTwoFAConfigured()
    {
        $Ni2nW = $this->getStoreConfig(TwoFAConstants::AUTHORIZE_URL);
        return $this->isBlank($Ni2nW) ? false : true;
    }
    public function isBlank($J9bAi)
    {
        if (!(!isset($J9bAi) || empty($J9bAi))) {
            goto OdXxc;
        }
        return true;
        OdXxc:
        return false;
    }
    public function removeSettingsAfterAccount()
    {
        $this->setStoreConfig(TwoFAConstants::CUSTOMER_EMAIL, NULL);
        $this->setStoreConfig(TwoFAConstants::CUSTOMER_PASSWORD, NULL);
        $this->setStoreConfig(TwoFAConstants::CUSTOMER_KEY, NULL);
        $this->setStoreConfig(TwoFAConstants::API_KEY, NULL);
        $this->setStoreConfig(TwoFAConstants::PLAN_VERIFIED, NULL);
        $this->setStoreConfig(TwoFAConstants::INVOKE_INLINE_REGISTERATION, NULL);
        $this->setStoreConfig(TwoFAConstants::TOKEN, NULL);
        $this->setStoreConfig(TwoFAConstants::CUSTOMER_PHONE, NULL);
        $this->setStoreConfig(TwoFAConstants::REG_STATUS, NULL);
        $this->setStoreConfig(TwoFAConstants::TXT_ID, NULL);
        $this->setStoreConfig(TwoFAConstants::MODULE_TFA, NULL);
        $this->setStoreConfig(TwoFAConstants::LK_NO_OF_USERS, NULL);
        $this->setStoreConfig(TwoFAConstants::LK_VERIFY, NULL);
        $this->setStoreConfig(TwoFAConstants::KBA_METHOD, NULL);
        $this->setStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, NULL);
        $this->setStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, NULL);
    }
    public function isUserLoggedIn()
    {
        return $this->customerSession->isLoggedIn() || $this->authSession->isLoggedIn();
    }
    public function getCurrentUser()
    {
        return $this->customerSession->getCustomer();
    }
    public function getAdminLoginUrl()
    {
        return $this->getAdminUrl("\141\x64\155\151\156\150\164\x6d\x6c\x2f\x61\x75\x74\150\57\154\x6f\147\151\156");
    }
    public function getAdminPageUrl()
    {
        return $this->getAdminBaseUrl();
    }
    public function getCustomerLoginUrl()
    {
        return $this->getUrl("\143\x75\x73\x74\157\155\145\162\x2f\x61\143\x63\157\165\156\164\x2f\x6c\157\x67\x69\x6e");
    }
    public function getIsTestConfigurationClicked()
    {
        return $this->getStoreConfig(TwoFAConstants::IS_TEST);
    }
    public function getIsIp_for_CustomerClicked()
    {
        return $this->getStoreConfig(TwoFAConstants::IP_CUSTOMER);
    }
    public function getIsIp_for_AdminClicked()
    {
        return $this->getStoreConfig(TwoFAConstants::IP_ADMIN);
    }
    public function flushCache($FGlYL = '')
    {
        $cmyep = ["\144\x62\137\x64\x64\154"];
        foreach ($cmyep as $nfRj3) {
            $this->cacheTypeList->cleanType($nfRj3);
            HlTZ5:
        }
        bq4eM:
        foreach ($this->cacheFrontendPool as $Pm2Zc) {
            $Pm2Zc->getBackend()->clean();
            IsduV:
        }
        zPoB9:
    }
    public function getFileContents($cxFzs)
    {
        return $this->fileSystem->fileGetContents($cxFzs);
    }
    public function getRootDirectory()
    {
        return $this->dir->getRoot();
    }
    public function putFileContents($cxFzs, $CHYZg)
    {
        $this->fileSystem->filePutContents($cxFzs, $CHYZg);
    }
    public function getLogoutUrl()
    {
        if (!$this->customerSession->isLoggedIn()) {
            goto E4sCa;
        }
        return $this->getUrl("\x63\x75\x73\x74\157\155\145\x72\57\x61\143\x63\x6f\x75\x6e\164\x2f\154\x6f\x67\x6f\x75\164");
        E4sCa:
        if (!$this->authSession->isLoggedIn()) {
            goto m3bjf;
        }
        return $this->getAdminUrl("\141\x64\x6d\x69\x6e\x68\164\155\154\x2f\141\x75\164\150\x2f\x6c\x6f\x67\x6f\x75\164");
        m3bjf:
        return "\57";
    }
    public function getCallBackUrl()
    {
        return $this->getBaseUrl() . TwoFAConstants::CALLBACK_URL;
    }
    public function removeSignInSettFings()
    {
        $this->setStoreConfig(TwoFAConstants::SHOW_CUSTOMER_LINK, 0);
        $this->setStoreConfig(TwoFAConstants::SHOW_ADMIN_LINK, 0);
    }
    public function reinitConfig()
    {
        $this->reinitableConfig->reinit();
    }
    public function micr()
    {
        if (!$this->check_license_plan(4)) {
            goto rE0QI;
        }
        return true;
        rE0QI:
        $aaEqu = $this->getStoreConfig(TwoFAConstants::CUSTOMER_EMAIL);
        $ivT_a = $this->getStoreConfig(TwoFAConstants::CUSTOMER_KEY);
        return !$this->isBlank($aaEqu) && !$this->isBlank($ivT_a) ? true : false;
    }
    public function mclv()
    {
        if (!$this->check_license_plan(4)) {
            goto vxLzt;
        }
        return true;
        vxLzt:
        $QHenx = TwoFAConstants::DEFAULT_TOKEN_VALUE;
        $c93JQ = AESEncryption::decrypt_data($this->getStoreConfig(TwoFAConstants::SAMLSP_CKL), $QHenx);
        return $c93JQ == "\164\x72\165\x65" ? TRUE : FALSE;
    }
    public function isLicenseKeyVerified()
    {
        $QHenx = TwoFAConstants::DEFAULT_TOKEN_VALUE;
        $c93JQ = AESEncryption::decrypt_data($this->getStoreConfig(TwoFAConstants::SAMLSP_CKL), $QHenx);
        return $c93JQ == "\164\x72\x75\145" ? TRUE : FALSE;
    }
    public function mius()
    {
        $FEKCL = $this->getStoreConfig(TwoFAConstants::CUSTOMER_KEY);
        $kg91G = $this->getStoreConfig(TwoFAConstants::API_KEY);
        $QHenx = TwoFAConstants::DEFAULT_TOKEN_VALUE;
        $ba2Bu = AESEncryption::decrypt_data($this->getStoreConfig(TwoFAConstants::SAMLSP_LK), $QHenx);
        $Rg0A3 = Curl::mius($FEKCL, $kg91G, $ba2Bu);
        return $Rg0A3;
    }
    public function vml($ba2Bu)
    {
        $FEKCL = $this->getStoreConfig(TwoFAConstants::CUSTOMER_KEY);
        $kg91G = $this->getStoreConfig(TwoFAConstants::API_KEY);
        $Rg0A3 = Curl::vml($FEKCL, $kg91G, $ba2Bu, $this->getBaseUrl());
        return $Rg0A3;
    }
    public function ccl($dvVn6)
    {
        $FEKCL = $this->getStoreConfig(TwoFAConstants::CUSTOMER_KEY);
        $kg91G = $this->getStoreConfig(TwoFAConstants::API_KEY);
        $Rg0A3 = Curl::ccl($FEKCL, $kg91G, $dvVn6);
        return $Rg0A3;
    }
    public function updateRowInTable($Rsl0O, $qwG3n, $gQDIn, $XwJLZ)
    {
        $this->log_debug("\165\x70\x64\x61\x74\x65\122\x6f\x77\x49\156\x54\x61\x62\x6c\145");
        $this->resource->getConnection()->update($Rsl0O, $qwG3n, [$gQDIn . "\40\x3d\x20\77" => $XwJLZ]);
    }
    public function deleteRowInTable($Rsl0O, $gQDIn, $XwJLZ)
    {
        $t2qLw = $this->resource->getConnection();
        $TUh54 = "\x44\x45\x4c\x45\x54\105\40\106\122\x4f\x4d\40" . $Rsl0O . "\40\127\110\105\122\105\x20" . $gQDIn . "\75" . $XwJLZ;
        $t2qLw->exec($TUh54);
    }
    public function deleteRowInTableWithWebsiteID($Rsl0O, $gQDIn, $XwJLZ, $FCDQy)
    {
        $this->log_debug("\144\x65\x6c\145\164\145\x52\x6f\167\x49\x6e\x74\141\142\154\145");
        $t2qLw = $this->resource->getConnection();
        $TUh54 = "\104\105\x4c\x45\124\105\x20\x46\122\x4f\x4d\40" . $Rsl0O . "\x20\x57\x48\x45\122\x45\40" . $gQDIn . "\x3d\x27" . $XwJLZ . "\47\40\141\x6e\x64\40\x77\145\x62\x73\151\164\145\137\151\144\x3d\47" . $FCDQy . "\47";
        $t2qLw->exec($TUh54);
    }
    public function getValueFromTableSQL($Rsl0O, $MQduJ, $gQDIn, $XwJLZ)
    {
        $TMEpy = $this->resource->getConnection();
        $qR00G = "\x53\105\x4c\x45\x43\x54\x20" . $MQduJ . "\40\106\122\x4f\115\x20" . $Rsl0O . "\x20\127\110\105\122\x45\40" . $gQDIn . "\40\x3d\40" . $XwJLZ;
        $this->log_debug("\123\121\114\72\40" . $qR00G);
        $RNGvP = $TMEpy->fetchOne($qR00G);
        $this->log_debug("\x72\145\163\x75\x6c\164\40\x73\x71\x6c\x3a\40" . $RNGvP);
        return $RNGvP;
    }
    public function verifyGauthCode($ba2Bu, $iwHG8, $fGZ8L = 3, $rJoTk = null)
    {
        $this->log_debug("\x54\x77\157\106\101\x55\164\x6c\x69\x74\x79\72\x20\x76\145\162\151\x66\171\x47\141\x75\x74\x68\x43\x6f\x64\x65\x3a\x20\x65\x78\x65\143\x75\x74\x65");
        $ZXtEF = $this->getAuthenticatorSecret($iwHG8);
        if (!($ZXtEF == false)) {
            goto n2tXp;
        }
        $ZXtEF = $this->getSessionValue(TwoFAConstants::PRE_SECRET);
        n2tXp:
        $E5sU6 = $this->getSessionValue(TwoFAConstants::CUSTOMER_INLINE);
        if (!$E5sU6) {
            goto EPSA1;
        }
        $ZXtEF = $this->getSessionValue("\143\x75\163\x74\157\x6d\x65\x72\x5f\x69\x6e\154\x69\156\x65\x5f\163\x65\x63\x72\145\x74");
        $this->setSessionValue(TwoFAConstants::CUSTOMER_SECRET, $ZXtEF);
        EPSA1:
        $uMRoY = $this->getSessionValue(TwoFAConstants::ADMIN_IS_INLINE);
        if (!$uMRoY) {
            goto O9ZUI;
        }
        $ZXtEF = $this->getSessionValue(TwoFAConstants::ADMIN_SECRET);
        O9ZUI:
        $I1RcT = array("\163\164\x61\164\x75\163" => "\106\101\x4c\123\x45");
        if (!($rJoTk === null)) {
            goto FG13M;
        }
        $rJoTk = floor(time() / 30);
        FG13M:
        if (!(strlen($ba2Bu) != 6)) {
            goto EVwGX;
        }
        return json_encode($I1RcT);
        EVwGX:
        $sH3Jn = -$fGZ8L;
        cDe7D:
        if (!($sH3Jn <= $fGZ8L)) {
            goto dfa66;
        }
        $JxExl = $this->getCode($ZXtEF, $rJoTk + $sH3Jn);
        if (!$this->timingSafeEquals($JxExl, $ba2Bu)) {
            goto qwhPD;
        }
        $I1RcT["\163\x74\141\x74\165\163"] = "\123\125\x43\x43\105\123\123";
        return json_encode($I1RcT);
        qwhPD:
        sQbz8:
        ++$sH3Jn;
        goto cDe7D;
        dfa66:
        return json_encode($I1RcT);
    }
    public function verifyGauthCodeViaConfigurationPage($ba2Bu, $ZXtEF, $fGZ8L = 3, $rJoTk = null)
    {
        $this->log_debug("\124\x77\x6f\x46\x41\x55\164\x6c\151\164\171\x3a\40\166\x65\x72\151\146\x79\107\141\165\164\x68\x43\x6f\144\145\126\x69\x61\103\157\156\146\151\147\165\162\x61\x74\151\157\156\x50\x61\x67\x65\x3a\40\x65\170\145\x63\165\x74\x65");
        $I1RcT = array("\x73\x74\x61\x74\x75\163" => "\106\x41\x4c\x53\105");
        if (!($rJoTk === null)) {
            goto aERiW;
        }
        $rJoTk = floor(time() / 30);
        aERiW:
        if (!(strlen($ba2Bu) != 6)) {
            goto GL4Gj;
        }
        return json_encode($I1RcT);
        GL4Gj:
        $sH3Jn = -$fGZ8L;
        WdQnT:
        if (!($sH3Jn <= $fGZ8L)) {
            goto XdN40;
        }
        $JxExl = $this->getCode($ZXtEF, $rJoTk + $sH3Jn);
        if (!$this->timingSafeEquals($JxExl, $ba2Bu)) {
            goto u_mLr;
        }
        $I1RcT["\x73\x74\141\164\165\x73"] = "\123\125\103\x43\105\x53\123";
        return json_encode($I1RcT);
        u_mLr:
        Y8bhx:
        ++$sH3Jn;
        goto WdQnT;
        XdN40:
        return json_encode($I1RcT);
    }
    function getCode($ZXtEF, $ustO1 = null)
    {
        if (!($ustO1 === null)) {
            goto xDjUC;
        }
        $ustO1 = floor(time() / 30);
        xDjUC:
        $EcmKM = $this->_base32Decode($ZXtEF);
        $pvMHT = chr(0) . chr(0) . chr(0) . chr(0) . pack("\x4e\52", $ustO1);
        $SuJST = hash_hmac("\123\110\101\x31", $pvMHT, $EcmKM, true);
        $yT8E1 = ord(substr($SuJST, -1)) & 0xf;
        $SN3yN = substr($SuJST, $yT8E1, 4);
        $J9bAi = unpack("\x4e", $SN3yN);
        $J9bAi = $J9bAi[1];
        $J9bAi = $J9bAi & 0x7fffffff;
        $YB1rb = pow(10, 6);
        return str_pad($J9bAi % $YB1rb, 6, "\x30", STR_PAD_LEFT);
    }
    function _base32Decode($ZXtEF)
    {
        if (!empty($ZXtEF)) {
            goto nJg5Q;
        }
        return '';
        nJg5Q:
        $k62IP = $this->_getBase32LookupTable();
        $X5_9J = array_flip($k62IP);
        $rh5Vq = substr_count($ZXtEF, $k62IP[32]);
        $J62Jx = array(6, 4, 3, 1, 0);
        if (in_array($rh5Vq, $J62Jx)) {
            goto yQgfm;
        }
        return false;
        yQgfm:
        $sH3Jn = 0;
        FnbeN:
        if (!($sH3Jn < 4)) {
            goto lmKvB;
        }
        if (!($rh5Vq == $J62Jx[$sH3Jn] && substr($ZXtEF, -$J62Jx[$sH3Jn]) != str_repeat($k62IP[32], $J62Jx[$sH3Jn]))) {
            goto NDfpv;
        }
        return false;
        NDfpv:
        tVJ2O:
        ++$sH3Jn;
        goto FnbeN;
        lmKvB:
        $ZXtEF = str_replace("\x3d", '', $ZXtEF);
        $ZXtEF = str_split($ZXtEF);
        $WecK1 = '';
        $sH3Jn = 0;
        pnNHW:
        if (!($sH3Jn < count($ZXtEF))) {
            goto Al1Vm;
        }
        $zp_j7 = '';
        if (in_array($ZXtEF[$sH3Jn], $k62IP)) {
            goto dyfLf;
        }
        return false;
        dyfLf:
        $b9ygk = 0;
        G2jrU:
        if (!($b9ygk < 8)) {
            goto AEKI9;
        }
        $zp_j7 .= str_pad(base_convert($X5_9J[$ZXtEF[$sH3Jn + $b9ygk]], 10, 2), 5, "\60", STR_PAD_LEFT);
        XpBu2:
        ++$b9ygk;
        goto G2jrU;
        AEKI9:
        $Ohlt_ = str_split($zp_j7, 8);
        $jMb0V = 0;
        iJEAB:
        if (!($jMb0V < count($Ohlt_))) {
            goto ArVns;
        }
        $WecK1 .= ($s3ryq = chr(base_convert($Ohlt_[$jMb0V], 2, 10))) || ord($s3ryq) == 48 ? $s3ryq : '';
        Jga35:
        ++$jMb0V;
        goto iJEAB;
        ArVns:
        tV73s:
        $sH3Jn = $sH3Jn + 8;
        goto pnNHW;
        Al1Vm:
        return $WecK1;
    }
    function _getBase32LookupTable()
    {
        return array("\101", "\102", "\103", "\104", "\105", "\x46", "\x47", "\110", "\x49", "\112", "\x4b", "\114", "\x4d", "\116", "\x4f", "\120", "\121", "\x52", "\123", "\x54", "\125", "\x56", "\x57", "\130", "\131", "\x5a", "\x32", "\x33", "\x34", "\65", "\x36", "\x37", "\75");
    }
    function timingSafeEquals($CeMPY, $LRI7X)
    {
        if (!function_exists("\x68\141\x73\150\137\x65\161\x75\141\x6c\x73")) {
            goto Hbabv;
        }
        return hash_equals($CeMPY, $LRI7X);
        Hbabv:
        $lXT34 = strlen($CeMPY);
        $vOaPN = strlen($LRI7X);
        if (!($vOaPN != $lXT34)) {
            goto TR24Y;
        }
        return false;
        TR24Y:
        $RNGvP = 0;
        $sH3Jn = 0;
        T1ZKT:
        if (!($sH3Jn < $vOaPN)) {
            goto RMYWZ;
        }
        $RNGvP |= ord($CeMPY[$sH3Jn]) ^ ord($LRI7X[$sH3Jn]);
        FzlBm:
        ++$sH3Jn;
        goto T1ZKT;
        RMYWZ:
        return $RNGvP === 0;
    }
    public function getCustomerPhoneFromEmail($aaEqu = false)
    {
        $this->customerModel->setWebsiteId($this->storeManager->getStore()->getWebsiteId());
        $M1pJH = $this->customerModel->loadByEmail($aaEqu);
        if (!($M1pJH->getId() && $M1pJH->getDefaultBillingAddress())) {
            goto FSAA1;
        }
        $rdLz7 = $M1pJH->getDefaultBillingAddress();
        if (!$rdLz7->getTelephone()) {
            goto MNSDb;
        }
        return $rdLz7->getTelephone();
        MNSDb:
        FSAA1:
        return null;
    }
    public function getCustomerCountryFromEmail($aaEqu = false)
    {
        $this->customerModel->setWebsiteId($this->storeManager->getStore()->getWebsiteId());
        $M1pJH = $this->customerModel->loadByEmail($aaEqu);
        if (!($M1pJH->getId() && $M1pJH->getDefaultBillingAddress())) {
            goto FFVEu;
        }
        $rdLz7 = $M1pJH->getDefaultBillingAddress();
        if (!$rdLz7->getCountryId()) {
            goto u_FsS;
        }
        return $rdLz7->getCountryId();
        u_FsS:
        FFVEu:
        return null;
    }
    public function Customgateway_GenerateOTP()
    {
        $euDwA = $this->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_OTP_LENGTH);
        if (!($euDwA == NULL)) {
            goto g8foI;
        }
        $euDwA = 4;
        g8foI:
        $idEiz = "\60\61\62\x33\64\65\66\67\x38\71";
        $OWcUq = strlen($idEiz);
        $lVWuy = '';
        $sH3Jn = 0;
        cxMm1:
        if (!($sH3Jn < $euDwA)) {
            goto St0ee;
        }
        $lVWuy .= $idEiz[rand(0, $OWcUq - 1)];
        mM2fw:
        $sH3Jn++;
        goto cxMm1;
        St0ee:
        $this->setSessionValue("\x63\165\x73\164\157\x6d\x67\141\x74\145\167\141\171\x5f\157\164\x70", $lVWuy);
        return $lVWuy;
    }
    public function get_OTP_length($nHtHV)
    {
        $this->log_debug("\105\156\164\x65\x72\151\x6e\147\x20\x67\x65\x74\137\117\x54\120\x5f\x6c\x65\156\147\x74\150\40\167\151\x74\x68\x20\x6d\145\164\150\157\x64\x3a\x20", $nHtHV);
        if (!$nHtHV) {
            goto MZBOn;
        }
        $nHtHV = trim($nHtHV, "\x5b\x22\x22\135");
        $this->log_debug("\124\x72\151\155\x6d\x65\x64\40\x6d\x65\x74\150\x6f\144\x20\166\x61\x6c\x75\x65\x3a\x20", $nHtHV);
        MZBOn:
        if (!($nHtHV == "\107\x6f\x6f\x67\x6c\145\x41\x75\164\x68\x65\x6e\x74\x69\x63\141\x74\157\162")) {
            goto n9vVf;
        }
        $this->log_debug("\107\x6f\x6f\x67\154\145\101\165\x74\150\145\156\164\151\143\x61\164\x6f\162\x20\155\145\x74\150\157\144\40\x64\x65\x74\145\143\164\x65\144\56\x20\x4f\124\x50\x20\x6c\145\x6e\147\164\x68\72\40\66");
        return 6;
        n9vVf:
        $GiLI9 = $this->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
        $bCZZ4 = $this->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
        $Bgn6Y = $this->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
        $this->log_debug("\x43\x75\x73\164\157\x6d\40\147\x61\x74\145\x77\x61\171\40\143\x6f\x6e\146\x69\x67\x75\162\141\164\151\x6f\156\x73\72\x20\105\155\x61\151\x6c\x20\55\x20{$GiLI9}\x2c\40\x53\x4d\x53\x20\55\40{$bCZZ4}\x2c\x20\127\x68\141\x74\163\101\160\160\40\55\40{$Bgn6Y}");
        $pLfuM = false;
        if ($nHtHV == "\x4f\117\105" && $GiLI9) {
            goto CLSI3;
        }
        if ($nHtHV == "\117\117\123" && $bCZZ4) {
            goto c1yyt;
        }
        if ($nHtHV == "\x57\110\101\124\x53\101\x50\x50" && $Bgn6Y) {
            goto dnr6q;
        }
        goto v3kxS;
        CLSI3:
        $pLfuM = true;
        $this->log_debug("\x55\163\151\x6e\x67\40\143\x75\x73\x74\x6f\x6d\x20\x65\155\141\x69\154\40\x67\141\164\x65\167\141\171\40\x66\157\x72\x20\117\117\105\40\x6d\145\x74\x68\157\x64");
        goto v3kxS;
        c1yyt:
        $pLfuM = true;
        $this->log_debug("\125\163\151\156\147\40\x63\165\x73\x74\157\155\40\123\115\x53\40\x67\x61\x74\x65\167\x61\x79\40\146\x6f\162\40\x4f\117\123\40\x6d\145\x74\150\157\x64");
        goto v3kxS;
        dnr6q:
        $pLfuM = true;
        $this->log_debug("\x55\x73\151\x6e\147\x20\x63\165\163\x74\x6f\155\40\x57\x68\141\x74\x73\101\160\160\40\x67\x61\164\x65\x77\141\x79\40\x66\157\x72\x20\x57\110\x41\124\x53\x41\x50\x50\x20\x6d\x65\x74\x68\157\144");
        v3kxS:
        if (!$pLfuM) {
            goto Mq5L1;
        }
        $euDwA = $this->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_OTP_LENGTH);
        $this->log_debug("\103\x75\x73\164\157\x6d\x20\x67\141\164\145\167\x61\171\40\x4f\124\x50\40\154\x65\156\x67\164\150\x20\x66\x65\x74\143\150\145\144\40\146\x6f\162\40\x6d\145\164\x68\x6f\144\40{$nHtHV}\x3a\x20", $euDwA);
        if (!($euDwA == NULL)) {
            goto v9UX0;
        }
        $this->log_debug("\x43\x75\x73\164\157\x6d\x20\x67\x61\164\x65\x77\x61\171\40\x4f\x54\x50\40\154\x65\156\147\164\x68\x20\151\x73\x20\x4e\125\x4c\x4c\54\x20\144\145\x66\x61\165\x6c\164\151\156\x67\40\x74\x6f\40\66\56");
        return 6;
        v9UX0:
        $this->log_debug("\122\x65\x74\165\162\156\151\156\x67\40\x63\165\163\x74\157\155\x20\147\141\x74\x65\x77\141\x79\x20\x4f\124\x50\40\154\x65\x6e\147\x74\x68\72\40{$euDwA}");
        return $euDwA;
        Mq5L1:
        $kdnAg = $this->getStoreConfig(TwoFAConstants::ADVANCED_OTP_LENGTH);
        $this->log_debug("\115\151\156\x69\117\162\x61\x6e\147\x65\x20\147\x61\164\x65\167\141\171\40\x4f\124\x50\x20\x6c\145\x6e\x67\x74\150\40\x66\x65\164\143\x68\145\x64\72\40", $kdnAg);
        if (!($kdnAg == NULL)) {
            goto KkQBl;
        }
        $this->log_debug("\x4d\151\x6e\x69\117\162\141\156\x67\x65\40\x4f\124\x50\x20\x6c\145\x6e\147\164\150\x20\151\x73\x20\116\125\x4c\114\x2c\40\144\145\146\x61\165\154\164\151\x6e\147\40\164\157\40\66\56");
        return 6;
        KkQBl:
        $this->log_debug("\x52\x65\x74\165\162\156\151\156\147\x20\115\151\x6e\x69\117\x72\141\156\147\x65\40\x67\141\164\x65\167\141\171\x20\117\124\x50\x20\154\x65\x6e\x67\x74\150\x3a\40{$kdnAg}");
        return $kdnAg;
    }
    public function customgateway_validateOTP($P7RHD)
    {
        $VKR0m = 10;
        $lv890 = $this->sanitize_otp($P7RHD);
        $l7gAN = $this->getSessionValue("\x63\165\163\164\157\155\x67\x61\164\x65\167\x61\171\137\157\x74\160");
        $Jl6vU = $this->getSessionValue("\x6f\160\x74\x5f\x65\170\x70\x69\162\x79\x5f\x74\x69\x6d\145");
        $UF_8d = time();
        $wJOG1 = $Jl6vU - $UF_8d;
        $TtNtK = $this->getSessionValue("\x66\x61\x69\x6c\145\x64\137\157\x74\160\137\x61\x74\164\x65\155\160\164\x73") ?? 0;
        if (!($TtNtK && $TtNtK != 0)) {
            goto jptyq;
        }
        if (!($TtNtK >= $VKR0m)) {
            goto xcJeV;
        }
        $this->log_debug("\164\x77\157\146\x61\x75\x74\154\151\x74\151\x65\x73\x20\x69\156\x20\143\165\163\x74\157\155\147\141\164\145\x77\141\171\x5f\x76\141\154\151\x64\141\x74\145\x4f\x54\x50\x20\75\x3e\40\x4d\x61\x78\x20\146\x61\x69\x6c\145\144\40\141\x74\164\145\x6d\160\164\163\x20\162\x65\141\x63\150\x65\144");
        return "\106\x41\x49\x4c\105\104\x5f\101\124\x54\x45\115\x50\124\123";
        xcJeV:
        jptyq:
        if (!($l7gAN == NULL)) {
            goto Gc1yg;
        }
        return "\106\x41\111\114\105\104";
        Gc1yg:
        if ($l7gAN == $lv890) {
            goto xy_2d;
        }
        $TtNtK++;
        $this->setSessionValue("\146\x61\151\x6c\145\144\x5f\x6f\164\160\x5f\141\164\164\x65\155\160\164\x73", $TtNtK);
        $this->log_debug("\x74\x77\x6f\146\141\x75\x74\154\x69\x74\x69\x65\x73\40\151\156\x20\143\165\163\164\157\x6d\147\x61\164\145\x77\x61\x79\137\166\141\x6c\x69\x64\x61\x74\145\x4f\x54\120\x20\75\76\40\x6f\164\x70\x20\x66\141\151\154\145\144\40\x61\164\164\145\155\160\164\x20{$TtNtK}");
        return "\106\x41\x49\x4c\x45\x44";
        goto i87eA;
        xy_2d:
        if (!$Jl6vU) {
            goto YozDr;
        }
        $UF_8d = time();
        if (!($UF_8d > $Jl6vU)) {
            goto QgoXO;
        }
        $this->log_debug("\x74\167\x6f\x66\141\x75\x74\x6c\151\164\x69\x65\x73\x20\x69\156\x20\143\165\x73\x74\157\x6d\x67\141\164\x65\x77\x61\x79\137\x76\x61\154\151\144\141\x74\145\117\x54\x50\x20\x3d\x3e\40\157\x74\160\40\x68\141\163\40\x65\x78\x70\x69\162\145\x64");
        return "\x46\x41\111\114\x45\x44\137\117\124\x50\137\105\130\120\x49\x52\x45\104";
        QgoXO:
        $this->log_debug("\164\167\x6f\146\141\165\x74\154\x69\x74\x69\145\x73\40\x69\x6e\40\x63\x75\163\x74\157\155\x67\x61\x74\145\167\141\171\137\x76\141\154\x69\144\x61\164\145\117\x54\x50\x20\75\76\x20\x6f\x74\x70\x20\151\x73\x20\x6e\157\164\40\145\170\160\151\x72\145\x64");
        $this->setSessionValue("\157\160\x74\137\145\170\x70\x69\162\x79\137\x74\x69\155\145", NULL);
        $this->setSessionValue("\x66\x61\151\x6c\x65\144\137\157\164\160\137\141\164\164\x65\x6d\160\x74\x73", NULL);
        return "\x53\x55\x43\103\105\x53\123";
        YozDr:
        $this->setSessionValue("\146\141\x69\x6c\x65\144\x5f\x6f\164\x70\x5f\x61\164\x74\145\155\160\164\x73", NULL);
        return "\x53\x55\x43\x43\105\x53\x53";
        i87eA:
    }
    public function sanitize_otp($ARQ0P)
    {
        return preg_replace("\x2f\x5b\136\x30\x2d\x39\x5d\57", '', $ARQ0P);
    }
    public function check_otp_expiry()
    {
        $this->log_debug("\164\167\x6f\146\x61\165\x74\x6c\x69\164\x69\x65\x73\x3a\x20\x66\165\x6e\x63\x74\151\157\156\40\143\150\145\x63\153\x5f\157\x74\160\137\145\x78\x70\x69\x72\171\40\x3d\x3e\40\143\150\145\x63\153\40\157\164\x70\40\145\170\x70\151\162\x79");
        $Jl6vU = $this->getSessionValue("\x6f\x70\164\x5f\145\170\160\x69\162\171\x5f\164\151\155\145");
        if (!$Jl6vU) {
            goto J1J15;
        }
        $UF_8d = time();
        if (!($UF_8d > $Jl6vU)) {
            goto fq5ZA;
        }
        $this->log_debug("\x74\x77\x6f\x66\141\165\164\154\151\164\151\145\163\72\x20\143\150\x65\143\x6b\x5f\x6f\164\160\x5f\x65\x78\160\151\162\171\75\76\x20\157\164\x70\x20\x68\x61\163\40\x65\170\160\x69\162\x65\x64");
        return true;
        fq5ZA:
        return false;
        J1J15:
        return false;
    }
    public function OTP_over_SMSandEMAIL_Message($aaEqu, $T2SYt, $BUXS2, $xEV4t)
    {
        $OAHRr = explode("\x40", $aaEqu);
        $RXAmT = $OAHRr[0][0] . "\170\170\170\170\x78\x78\x78\170\x78\x78\x40" . $OAHRr[1];
        $bnVrO = "\x78\x78\x78\x78\170\x78\170\x78" . substr($T2SYt, -2);
        if ($BUXS2 == "\123\125\x43\103\x45\x53\123" && $xEV4t == "\x53\125\x43\x43\x45\123\123") {
            goto jCHau;
        }
        if ($BUXS2 == "\123\x55\103\103\x45\x53\123" && $xEV4t == "\x46\101\111\114\105\104") {
            goto AneZG;
        }
        if ($BUXS2 == "\106\101\111\114\x45\x44" && $xEV4t == "\x53\125\103\x43\x45\123\x53") {
            goto jutxl;
        }
        return __("\x46\141\151\x6c\x65\x64\x20\164\x6f\x20\x73\x65\x6e\x64\x20\117\124\x50\40\x74\157\x20\x65\155\141\x69\x6c\x20\x61\x6e\144\x20\x70\x68\157\156\x65\x2e\40\x50\x6c\145\141\x73\145\40\x43\157\x6e\x74\141\x63\x74\x20\131\x6f\165\x72\x20\101\x64\x6d\151\156\x69\163\x74\x72\141\x74\157\x72\x2e");
        goto QIzOd;
        jCHau:
        return __("\124\x68\x65\40\x4f\124\120\x20\150\141\x73\40\x62\145\145\x6e\40\163\x65\x6e\164\40\x74\x6f\40\171\x6f\x75\162\40\x50\150\x6f\x6e\x65\x3a\40" . $bnVrO . "\x20\141\156\144\x20\x45\x6d\141\151\154\x3a" . $RXAmT . "\56\x20\120\154\145\x61\x73\145\x20\145\x6e\164\145\x72\40\164\150\145\x20\117\x54\120\x20\x79\157\165\x20\162\145\x63\x65\151\x76\145\144\40\164\157\40\x76\x61\x6c\x69\144\141\x74\x65\x2e");
        goto QIzOd;
        AneZG:
        return __("\x54\150\145\x20\117\124\x50\40\150\141\x73\40\x62\145\145\x6e\40\163\x65\x6e\164\x20\164\x6f\40\171\157\165\x72\40\x45\155\x61\x69\x6c\72" . $RXAmT . "\x20\x61\x6e\144\x20\x46\141\x69\154\145\144\x20\164\157\40\163\x65\x6e\x64\40\117\x54\x50\x20\164\x6f\x20\x50\150\x6f\156\145\56\40\x50\154\145\x61\x73\x65\40\145\x6e\164\x65\162\x20\164\150\x65\40\117\x54\120\x20\x79\157\165\x20\x72\x65\143\x65\151\x76\145\x64\x20\164\157\x20\x76\x61\x6c\x69\x64\141\164\145\56");
        goto QIzOd;
        jutxl:
        return __("\124\x68\145\40\117\x54\x50\x20\x68\x61\163\40\142\145\x65\156\40\163\x65\x6e\164\x20\x74\157\40\171\157\x75\162\x20\120\x68\x6f\x6e\x65\x3a\40" . $bnVrO . "\x20\x61\156\144\40\106\141\151\154\145\144\40\164\157\40\163\145\x6e\144\x20\117\x54\120\40\x74\157\x20\x65\155\x61\151\x6c\x2e\40\x50\x6c\145\x61\163\145\x20\x65\156\x74\x65\x72\x20\x74\x68\x65\40\x4f\124\120\x20\171\157\165\x20\x72\145\143\145\151\166\x65\144\x20\164\x6f\40\166\x61\154\151\x64\141\x74\x65\x2e");
        QIzOd:
    }
    public function check_customGateway_methodConfigured()
    {
        $FGlYL = $this->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_EMAIL_FROM);
        $MumV1 = $this->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_EMAIL_NAME);
        $G3fTN = $this->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_HOSTNAME);
        $Jw_b4 = $this->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_PORT);
        $cEI3m = $this->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_AUTHENTICATION);
        $FzlSK = $this->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_USERNAME);
        $yVrEZ = $this->getStoreConfig(TwoFAConstants::CUSTOM_GATEWAY_PASSWORD);
        $euDwA = $this->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_OTP_LENGTH);
        if (is_null($FGlYL) || is_null($MumV1) || is_null($G3fTN) || is_null($Jw_b4) || is_null($cEI3m) || is_null($FzlSK) || is_null($yVrEZ) || is_null($euDwA)) {
            goto ODPfI;
        }
        return false;
        goto qFAy9;
        ODPfI:
        return true;
        qFAy9:
    }
    public function update_status($ba2Bu)
    {
        $FEKCL = $this->getStoreConfig(TwoFAConstants::CUSTOMER_KEY);
        $kg91G = $this->getStoreConfig(TwoFAConstants::API_KEY);
        $Rg0A3 = Curl::update_status($FEKCL, $kg91G, $ba2Bu, $this->getBaseUrl());
        return $Rg0A3;
    }
    public function getGroupNameById($QyriB)
    {
        $laUlM = $this->groupRepository->getById($QyriB);
        return $laUlM->getCode();
    }
    public function check2fa_backend_plan()
    {
        if (!($this->check_license_plan(4) and !$this->isTrialExpired())) {
            goto xQpjK;
        }
        return 1;
        xQpjK:
        $V0Wj9 = $this->getStoreConfig(TwoFAConstants::PLAN_VERIFIED);
        $UseVp = $this->getStoreConfig(TwoFAConstants::LICENSE_PLAN);
        $BTt60 = ($UseVp == "\x6d\141\x67\145\156\164\x6f\x5f\x32\x66\141\137\160\x72\145\155\151\165\155\137\x70\x6c\x61\x6e" || $UseVp == "\x6d\x61\x67\x65\156\x74\157\137\x32\x66\141\x5f\x66\162\x6f\156\x74\x65\156\x64\x5f\160\x6c\141\x6e") && $V0Wj9 ? 1 : 0;
        return $BTt60;
    }
    public function check2fa_backendPlan()
    {
        if (!($this->check_license_plan(4) and !$this->isTrialExpired())) {
            goto CVhKF;
        }
        return 1;
        CVhKF:
        $V0Wj9 = $this->getStoreConfig(TwoFAConstants::PLAN_VERIFIED);
        $UseVp = $this->getStoreConfig(TwoFAConstants::LICENSE_PLAN);
        $BTt60 = ($UseVp == "\x6d\x61\147\x65\x6e\x74\157\137\62\x66\x61\137\160\x72\x65\x6d\x69\x75\x6d\x5f\160\x6c\x61\x6e" || $UseVp == "\155\141\147\x65\156\164\157\137\62\146\141\137\142\141\143\x6b\x65\x6e\144\137\160\x6c\141\x6e") && $V0Wj9 ? 1 : 0;
        return $BTt60;
    }
    public function check2fa_frontend_plan()
    {
        $V0Wj9 = $this->getStoreConfig(TwoFAConstants::PLAN_VERIFIED);
        $UseVp = $this->getStoreConfig(TwoFAConstants::LICENSE_PLAN);
        $BTt60 = $UseVp == "\155\141\x67\x65\x6e\164\x6f\137\x32\x66\x61\137\146\162\157\156\164\x65\x6e\x64\x5f\160\x6c\x61\156" && $V0Wj9 ? 1 : 0;
        return $BTt60;
    }
    public function getemailtemplatelist()
    {
        $ArCvF = $this->resource->getConnection()->select()->from("\145\155\141\151\x6c\137\x74\x65\x6d\160\154\141\164\x65", ["\164\145\155\x70\x6c\141\x74\145\137\143\157\144\145", "\164\x65\155\160\x6c\141\x74\145\x5f\x69\144"]);
        $EGw0a = $this->resource->getConnection()->fetchAll($ArCvF);
        return $EGw0a;
    }
    public function checkBlacklistedIP()
    {
        $c8sB4 = $this->getStoreConfig(TwoFAConstants::IP_LISTING);
        if (!$c8sB4) {
            goto waZjE;
        }
        $mFmNo = $this->getStoreConfig(TwoFAConstants::ALL_IP_BLACKLISTED);
        $B2Vgp = $this->get_client_ip();
        $mFmNo = $this->getStoreConfig(TwoFAConstants::ALL_IP_BLACKLISTED);
        if ($mFmNo) {
            goto AuOFV;
        }
        return false;
        AuOFV:
        $TSsSq = json_decode($mFmNo, true);
        if (is_array($TSsSq)) {
            goto p2IUx;
        }
        return false;
        p2IUx:
        $s1chX = false;
        foreach ($TSsSq as $J9bAi) {
            if (str_contains($J9bAi, "\x2d")) {
                goto EDJ0K;
            }
            if (!(trim($B2Vgp) == trim($J9bAi))) {
                goto awXlp;
            }
            $s1chX = true;
            goto dv_fl;
            awXlp:
            goto xPx9s;
            EDJ0K:
            list($EoSI1, $ZtDdG) = explode("\x2d", $J9bAi, 2);
            $qZqEg = ip2long(trim($EoSI1));
            $QaHwc = ip2long(trim($ZtDdG));
            $nUAgt = ip2long($B2Vgp);
            if (!($qZqEg !== false && $QaHwc !== false && $nUAgt !== false && $nUAgt >= $qZqEg && $nUAgt <= $QaHwc)) {
                goto E2qDI;
            }
            $s1chX = true;
            goto dv_fl;
            E2qDI:
            xPx9s:
            gO5xk:
        }
        dv_fl:
        return $s1chX;
        waZjE:
    }
    public function get_client_ip()
    {
        $this->log_debug("\x54\x77\157\106\101\125\x74\x69\x6c\151\x74\x79\x2e\160\150\160\40\72\40\x69\156\163\151\144\145\x20\147\x65\164\x5f\143\154\151\x65\x6e\164\137\151\160");
        if (getenv("\110\124\x54\120\137\103\x4c\111\x45\x4e\x54\x5f\x49\x50")) {
            goto lnWLh;
        }
        if (getenv("\122\105\115\117\124\x45\137\x41\x44\104\122")) {
            goto qMP0x;
        }
        if (getenv("\x48\x54\x54\120\137\130\137\x46\117\x52\x57\x41\122\104\105\x44\137\106\x4f\x52")) {
            goto y36Qu;
        }
        if (getenv("\x48\x54\x54\120\137\130\137\106\x4f\x52\x57\101\x52\x44\x45\104")) {
            goto zRPx9;
        }
        if (getenv("\110\x54\124\120\x5f\106\x4f\x52\127\101\x52\104\105\104\x5f\106\117\x52")) {
            goto QC0ec;
        }
        if (getenv("\x48\124\124\x50\137\x46\x4f\x52\x57\101\122\104\105\104")) {
            goto kDBZb;
        }
        $c23yI = "\125\x4e\113\x4e\117\127\x4e";
        goto d8h83;
        kDBZb:
        $c23yI = getenv("\110\124\x54\x50\x5f\106\117\x52\127\x41\x52\x44\x45\104");
        d8h83:
        goto PRIaM;
        QC0ec:
        $c23yI = getenv("\x48\x54\x54\120\x5f\x46\x4f\122\x57\x41\122\x44\x45\104\x5f\106\117\122");
        PRIaM:
        goto YswsZ;
        zRPx9:
        $c23yI = getenv("\x48\x54\124\x50\x5f\x58\137\106\117\x52\x57\101\x52\x44\105\104");
        YswsZ:
        goto c0vdT;
        y36Qu:
        $c23yI = getenv("\110\x54\124\120\137\x58\x5f\106\x4f\x52\127\101\122\x44\x45\x44\x5f\106\x4f\x52");
        c0vdT:
        goto TAPW0;
        qMP0x:
        $c23yI = getenv("\122\105\x4d\117\124\x45\x5f\x41\x44\x44\x52");
        TAPW0:
        goto xszjn;
        lnWLh:
        $c23yI = getenv("\x48\124\124\x50\x5f\103\114\111\x45\x4e\124\137\x49\120");
        xszjn:
        return $c23yI;
    }
    public function checkIPs($yB8c0)
    {
        $this->log_debug("\x54\x77\157\106\x41\125\x74\151\154\x69\x74\171\56\160\x68\x70\40\72\x20\x69\156\163\151\x64\x65\40\x63\150\x65\x63\x6b\124\x72\x75\163\x74\x65\x64\111\x50\x73");
        $B2Vgp = $this->get_client_ip();
        if (!($yB8c0 == "\x63\x75\163\x74\x6f\x6d\x65\x72")) {
            goto VWj19;
        }
        if (!($this->getStoreConfig(TwoFAConstants::IP_LISTING) != 1)) {
            goto e9JTG;
        }
        return false;
        e9JTG:
        VWj19:
        if (!($yB8c0 == "\x61\144\x6d\151\x6e")) {
            goto GEB7j;
        }
        if (!($this->getStoreConfig(TwoFAConstants::IP_LISTING) != 1)) {
            goto I6F8A;
        }
        return false;
        I6F8A:
        GEB7j:
        $mAf_n = $this->getStoreConfig(TwoFAConstants::ALL_IP_WHITLISTED);
        if ($mAf_n) {
            goto MMfUU;
        }
        return false;
        MMfUU:
        $g630U = json_decode($mAf_n, true);
        if (is_array($g630U)) {
            goto Uq5Yk;
        }
        $this->log_debug("\111\156\166\141\x6c\151\x64\x20\x49\x50\x20\144\x61\164\141\x20\x66\x6f\x72\x6d\x61\164\56");
        return false;
        Uq5Yk:
        $s1chX = false;
        foreach ($g630U as $J9bAi) {
            if (str_contains($J9bAi, "\55")) {
                goto BzooB;
            }
            if (!(trim($B2Vgp) == trim($J9bAi))) {
                goto KKevh;
            }
            $s1chX = true;
            goto jX6t1;
            KKevh:
            goto mu08I;
            BzooB:
            list($EoSI1, $ZtDdG) = explode("\55", $J9bAi, 2);
            $qZqEg = ip2long(trim($EoSI1));
            $QaHwc = ip2long(trim($ZtDdG));
            $nUAgt = ip2long($B2Vgp);
            if (!($qZqEg !== false && $QaHwc !== false && $nUAgt !== false && $nUAgt >= $qZqEg && $nUAgt <= $QaHwc)) {
                goto I4q9y;
            }
            $s1chX = true;
            goto jX6t1;
            I4q9y:
            mu08I:
            F5KFb:
        }
        jX6t1:
        return $s1chX;
    }
    public function checkTrustedIPs($yB8c0)
    {
        $this->log_debug("\124\167\157\106\x41\125\164\151\x6c\151\164\171\x2e\x70\150\160\40\x3a\40\x69\x6e\x73\151\144\x65\40\143\150\x65\143\x6b\x54\x72\x75\x73\164\x65\144\x49\120\x73");
        $B2Vgp = $this->get_client_ip();
        if (!($yB8c0 == "\143\x75\x73\x74\157\155\x65\162")) {
            goto jCcot;
        }
        if (!($this->getStoreConfig(TwoFAConstants::IP_CUSTOMER) != 1)) {
            goto naSKf;
        }
        return false;
        naSKf:
        jCcot:
        if (!($yB8c0 == "\141\x64\155\x69\x6e")) {
            goto hb0i6;
        }
        if (!($this->getStoreConfig(TwoFAConstants::IP_ADMIN) != 1)) {
            goto n4Jhd;
        }
        return false;
        n4Jhd:
        hb0i6:
        $mAf_n = $this->getIpWhitelistedIpAddresses($yB8c0);
        if (!empty($mAf_n)) {
            goto L3SIY;
        }
        return false;
        L3SIY:
        $s1chX = false;
        foreach ($mAf_n as $J9bAi) {
            if (stristr($J9bAi, "\55")) {
                goto ilw2e;
            }
            if (!($B2Vgp == $J9bAi)) {
                goto uNRv6;
            }
            $s1chX = true;
            goto zHpvb;
            uNRv6:
            goto rbuE6;
            ilw2e:
            list($EoSI1, $ZtDdG) = explode("\55", $J9bAi, 2);
            $qZqEg = ip2long($EoSI1);
            $QaHwc = ip2long($ZtDdG);
            $nUAgt = ip2long($B2Vgp);
            if (!($qZqEg !== false && $QaHwc !== false && $nUAgt !== false && $nUAgt >= $qZqEg && $nUAgt <= $QaHwc)) {
                goto EHNZZ;
            }
            $s1chX = true;
            goto zHpvb;
            EHNZZ:
            rbuE6:
            MZQRh:
        }
        zHpvb:
        return $s1chX;
    }
    public function getIpWhitelistedIpAddresses($yB8c0)
    {
        try {
            $this->log_debug("\124\167\157\x46\x41\125\164\151\154\x69\164\171\56\160\150\160\x3a\40\111\156\163\151\x64\x65\40\147\x65\x74\111\x70\x41\144\x64\x72\145\163\x73\x65\x73\x42\x79\x54\171\x70\x65\x20\x77\151\x74\150\40\111\x50\x20\124\x79\160\145\x3a\x20" . $yB8c0);
            if ($yB8c0 == "\x63\165\x73\164\x6f\x6d\145\x72") {
                goto S2A9h;
            }
            if ($yB8c0 == "\141\144\x6d\151\156") {
                goto ZKN3s;
            }
            return [];
            goto WU0Zd;
            S2A9h:
            $d9jv6 = $this->ipWhitelistedCollectionFactory->create();
            goto WU0Zd;
            ZKN3s:
            $d9jv6 = $this->ipWhitelistedAdminCollectionFactory->create();
            WU0Zd:
            $I4WF5 = $d9jv6->getColumnValues("\x69\x70\137\141\144\144\x72\145\x73\163");
            return $I4WF5;
        } catch (\Exception $Lq40h) {
            return [];
        }
    }
    public function validateOtpRequest(string $OQ92p, string $kg91G, string $ktI0S, string $Mjbsa, string $ARQ0P) : array
    {
        $H9HzL = $this->getCustomerKeys(false);
        $FEKCL = $H9HzL["\x63\165\x73\x74\157\x6d\145\x72\x5f\x6b\145\171"];
        $kg91G = $H9HzL["\x61\x70\x69\x4b\x65\171"];
        $raMDi = array("\117\x4f\105" => "\105\x4d\101\111\x4c", "\117\x4f\123" => "\123\x4d\123", "\x4f\117\x57" => "\x53\115\x53", "\117\x4f\x53\105" => "\x53\115\123\40\101\x4e\x44\x20\x45\115\x41\x49\114", "\x4b\x42\x41" => "\113\102\x41");
        $QHenx = intval($ARQ0P);
        $H1Dbe = array("\143\165\x73\x74\157\x6d\x65\x72\113\145\171" => $FEKCL, "\164\x78\111\x64" => $Mjbsa, "\x74\x6f\x6b\x65\x6e" => str_replace("\x20", '', $QHenx));
        $rKEsd = $this->getApiUrls();
        $bH5GR = $rKEsd["\166\141\x6c\x69\x64\141\x74\x65"];
        $NNWpE = json_decode(Curl::validate($FEKCL, $kg91G, $bH5GR, $H1Dbe));
        return [$SQTuC = array("\x73\164\141\x74\165\x73" => $NNWpE->status, "\155\145\163\x73\x61\147\145" => $NNWpE->message, "\164\x78\111\144" => $NNWpE->txId)];
    }
    public function getCustomerKeys($hFRsc = false)
    {
        $glHHm = array();
        if ($hFRsc) {
            goto X8SSt;
        }
        $r8O7V = self::getCustomerDetails();
        $glHHm["\143\165\x73\164\157\155\x65\162\x5f\153\145\x79"] = $this->getStoreConfig(TwoFAConstants::CUSTOMER_KEY);
        $glHHm["\141\x70\151\x4b\145\171"] = $Vl5US = $this->getStoreConfig(TwoFAConstants::API_KEY);
        goto GKlCC;
        X8SSt:
        $glHHm["\143\165\163\x74\x6f\155\x65\x72\x5f\153\145\x79"] = "\x31\66\65\65\x35";
        $glHHm["\x61\x70\151\113\x65\x79"] = "\x66\106\x64\x32\130\143\x76\x54\107\104\145\155\x5a\166\142\167\61\x62\143\x55\x65\163\116\x4a\127\105\x71\113\x62\x62\125\x71";
        GKlCC:
        return $glHHm;
    }
    static function getApiUrls()
    {
        $HNFSz = TwoFAConstants::HOSTNAME;
        return array("\x63\150\x61\x6c\x6c\141\156\x67\x65" => $HNFSz . "\x2f\155\157\141\x73\x2f\x61\x70\151\x2f\141\x75\x74\x68\x2f\x63\x68\141\x6c\x6c\x65\156\x67\x65", "\165\x70\x64\141\x74\x65" => $HNFSz . "\x2f\155\157\x61\163\x2f\141\160\x69\x2f\x61\x64\x6d\151\156\x2f\x75\x73\145\x72\x73\x2f\165\160\x64\x61\164\145", "\x76\x61\x6c\x69\x64\x61\x74\145" => $HNFSz . "\57\155\157\141\x73\x2f\x61\x70\x69\57\141\x75\164\150\x2f\166\141\154\151\x64\141\164\145", "\x67\157\x6f\147\154\145\x41\165\x74\150\123\145\x72\x76\151\x63\145" => $HNFSz . "\x2f\155\157\141\x73\57\x61\x70\x69\x2f\141\165\x74\150\57\147\157\x6f\x67\x6c\x65\55\x61\x75\x74\x68\x2d\163\145\x63\x72\145\164", "\x67\157\x6f\x67\x6c\145\166\141\x6c\x69\144\x61\164\x65" => $HNFSz . "\x2f\x6d\157\x61\x73\x2f\x61\x70\x69\57\141\x75\x74\x68\x2f\x76\x61\x6c\151\x64\x61\164\145\x2d\x67\157\157\x67\154\x65\x2d\x61\x75\x74\x68\55\x73\145\x63\162\x65\x74", "\143\162\145\141\x74\x65\x55\163\145\162" => $HNFSz . "\x2f\155\157\141\x73\x2f\141\160\151\57\141\144\x6d\151\x6e\57\x75\163\145\162\x73\x2f\x63\x72\145\141\164\145", "\153\142\141\x52\145\x67\151\x73\164\145\x72" => $HNFSz . "\57\155\157\141\163\57\141\160\151\x2f\141\x75\164\150\57\162\x65\147\151\163\164\x65\x72", "\147\x65\164\x55\x73\x65\x72\x49\x6e\x66\x6f" => $HNFSz . "\x2f\x6d\x6f\x61\163\57\141\x70\x69\57\x61\x64\x6d\151\x6e\57\x75\x73\145\x72\x73\57\x67\x65\x74", "\146\145\x65\144\142\x61\143\x6b" => $HNFSz . "\57\155\157\141\x73\x2f\x61\160\x69\57\x6e\157\x74\x69\x66\171\x2f\x73\x65\156\144");
    }
    public function send_customgateway_whatsapp($zhPS7, $ARQ0P)
    {
        $this->log_debug("\x49\x6e\x73\x69\x64\145\40\163\145\156\144\137\143\165\163\x74\157\155\147\141\x74\145\167\x61\171\x5f\167\x68\x61\x74\x73\x61\160\x70\x20" . $zhPS7);
        $rhvQp = $this->getStoreConfig(TwoFAConstants::WhATSAPP_PHONE_ID);
        $this->log_debug("\111\156\x73\151\x64\145\40\163\145\156\144\137\x63\x75\x73\x74\157\x6d\x67\x61\164\145\x77\x61\x79\x5f\167\x68\x61\164\163\141\160\160\x3a\40\127\x68\x61\x74\163\101\160\x70\x20\160\x68\157\156\x65\x20\x69\144\x20" . $rhvQp);
        $bKLuZ = $this->getStoreConfig(TwoFAConstants::WhATSAPP_ACCESS_TOKEN);
        $this->log_debug("\111\156\163\151\144\x65\40\x73\x65\x6e\144\137\x63\165\163\x74\x6f\x6d\147\x61\x74\145\x77\141\171\x5f\167\150\141\164\x73\x61\160\x70\x3a\x20\x57\x68\141\164\163\x41\x70\160\40\141\143\143\x65\x73\163\x20\164\x6f\x6b\145\x6e\x20" . $bKLuZ);
        $tAWb7 = $this->getStoreConfig(TwoFAConstants::WhATSAPP_TEMPLATE_NAME);
        $RWe6C = $this->getStoreConfig(TwoFAConstants::WhATSAPP_TEMPLATE_LANGUAGE);
        $this->log_debug("\x49\156\x73\x69\x64\145\x20\x73\145\x6e\144\137\143\x75\163\164\157\155\147\x61\164\145\x77\x61\x79\x5f\167\x68\x61\164\x73\141\160\160\72\x20\x57\x68\141\x74\x73\101\x70\x70\x20\x74\x65\x6d\x70\x6c\141\x74\x65\40\x6e\141\155\145\40" . $tAWb7);
        $this->log_debug("\x49\156\x73\x69\x64\x65\40\163\x65\x6e\144\x5f\x63\165\163\x74\157\155\147\141\164\x65\167\141\x79\x5f\x77\x68\x61\164\x73\141\160\160\x3a\x20\x57\x68\141\x74\x73\x41\160\160\x20\x74\x65\155\x70\x6c\x61\x74\145\x20\x6e\141\x6d\x65\x20" . $RWe6C);
        $FEKCL = $this->getStoreConfig(TwoFAConstants::CUSTOMER_KEY);
        $kg91G = $this->getStoreConfig(TwoFAConstants::API_KEY);
        $Rg0A3 = Curl::send_using_whatsapp_api($tAWb7, $zhPS7, $ARQ0P, $bKLuZ, $rhvQp, $FEKCL, $RWe6C);
        if (!$Rg0A3 and !empty($Rg0A3)) {
            goto Ft4ZH;
        }
        $RNGvP = array("\x73\164\141\x74\x75\x73" => "\106\x41\111\x4c\105\x44", "\155\x65\x73\163\141\147\145" => "\x45\155\160\x74\171\x20\x72\145\163\160\157\x6e\x73\x65\40\x72\145\143\x65\x69\x76\x65\x64\x20\146\162\157\x6d\40\x57\150\141\164\x73\x41\160\160\x20\x41\x50\111", "\164\170\111\x64" => "\61");
        goto sAphp;
        Ft4ZH:
        $ZCRMZ = json_decode($Rg0A3, true);
        if (isset($ZCRMZ["\x6d\x65\163\163\x61\x67\145\163"][0]["\x6d\145\163\x73\x61\x67\x65\x5f\x73\x74\x61\x74\165\x73"]) && $ZCRMZ["\155\145\163\163\x61\x67\x65\163"][0]["\x6d\145\x73\163\141\147\x65\137\x73\x74\x61\164\165\163"] === "\141\143\143\x65\x70\164\x65\x64") {
            goto yDBgy;
        }
        $RNGvP = array("\163\164\x61\x74\x75\x73" => "\x46\x41\x49\x4c\105\x44", "\155\x65\x73\x73\x61\x67\x65" => isset($ZCRMZ["\x65\x72\x72\157\162"]["\x6d\x65\163\x73\x61\x67\145"]) ? $ZCRMZ["\x65\x72\x72\157\162"]["\x6d\145\163\x73\x61\147\145"] : "\x55\156\153\156\157\x77\156\x20\x65\162\x72\157\162\40\157\x63\143\165\x72\x72\x65\x64\x2e", "\x74\x78\111\144" => "\61");
        goto EebLh;
        yDBgy:
        $bnVrO = "\x78\x78\170\170\x78\170\x78\170" . substr($zhPS7, -2);
        $RNGvP = array("\x73\164\x61\164\165\163" => "\x53\x55\103\103\105\123\123", "\155\145\x73\x73\x61\147\x65" => "\x54\150\x65\x20\127\150\x61\164\x73\x41\x70\160\40\117\124\120\x20\x68\141\x73\x20\x62\x65\x65\x6e\40\x73\x65\x6e\164\40\x74\157\x20\x79\157\165\x72\40\x50\150\x6f\x6e\x65\72\x20" . $bnVrO . "\x2e\40\120\x6c\x65\x61\163\145\40\x65\156\x74\x65\162\40\x74\x68\x65\40\x4f\124\120\40\171\157\x75\40\162\145\x63\145\151\166\x65\144\40\x74\x6f\40\x56\141\x6c\x69\x64\x61\x74\145\56", "\164\x78\x49\x64" => "\61");
        EebLh:
        sAphp:
        return $RNGvP;
    }
    public function send_whatsapp($zhPS7, $ARQ0P)
    {
        $this->log_debug("\x49\156\163\x69\144\x65\x20\x6d\x69\156\x69\157\x72\141\156\147\x65\x20\167\x68\x61\x74\163\141\x70\x70\40\x67\x61\164\x65\x77\x61\x79\40" . $zhPS7);
        $FEKCL = $this->getStoreConfig(TwoFAConstants::CUSTOMER_KEY);
        $kg91G = $this->getStoreConfig(TwoFAConstants::API_KEY);
        $w1Dx3 = $this->getStoreConfig(TwoFAConstants::CUSTOMER_EMAIL);
        $jKfcc = AESEncryption::decrypt_data($this->getStoreConfig(TwoFAConstants::CUSTOMER_PASSWORD), $kg91G);
        $Rg0A3 = Curl::challenge_whatsapp($zhPS7, $ARQ0P, $w1Dx3, $jKfcc, $FEKCL);
        if (!empty($Rg0A3)) {
            goto BtKmq;
        }
        $RNGvP = array("\163\164\x61\x74\165\163" => "\x46\x41\x49\114\105\104", "\155\x65\163\163\x61\147\145" => "\105\x6d\160\164\171\x20\162\x65\x73\x70\157\156\x73\145\40\162\x65\x63\145\x69\x76\x65\144\40\146\x72\157\x6d\40\x57\x68\x61\x74\163\x41\160\160\40\x41\120\x49", "\164\170\111\144" => "\61");
        goto dfIZ6;
        BtKmq:
        $ZCRMZ = json_decode($Rg0A3, true);
        if (isset($ZCRMZ["\x73\x74\x61\164\x75\x73"]) && $ZCRMZ["\163\164\141\164\x75\x73"] === "\123\125\103\x43\x45\x53\x53") {
            goto HizJp;
        }
        if (isset($ZCRMZ["\163\x74\x61\x74\165\163"]) && $ZCRMZ["\x73\x74\x61\x74\x75\163"] === "\x46\101\111\x4c\x45\x44") {
            goto QGOpz;
        }
        $RNGvP = array("\x73\164\141\164\165\x73" => "\106\101\x49\x4c\105\104", "\155\x65\x73\163\x61\x67\145" => "\125\156\145\170\x70\x65\x63\x74\x65\x64\x20\x72\x65\x73\160\x6f\x6e\163\x65\x20\x72\145\x63\x65\x69\166\x65\x64\x20\x66\x72\x6f\155\40\x57\150\x61\x74\163\101\x70\160\x20\x41\120\x49", "\x74\170\111\144" => "\61");
        goto AHiEF;
        HizJp:
        $bnVrO = "\x78\x78\170\x78\170\170\x78\x78" . substr($zhPS7, -2);
        $RNGvP = array("\163\164\x61\x74\x75\x73" => "\123\125\x43\x43\x45\123\x53", "\155\x65\163\x73\141\x67\x65" => "\124\x68\145\40\x57\x68\x61\164\163\x41\160\x70\x20\x4f\x54\x50\40\x68\141\163\40\x62\145\x65\156\40\x73\x65\x6e\164\x20\164\157\40\x79\x6f\165\162\x20\x50\150\x6f\x6e\145\x3a\40" . $bnVrO . "\56\x20\x50\154\145\x61\163\145\x20\x65\156\164\145\x72\40\x74\x68\145\x20\x4f\124\x50\x20\171\157\x75\x20\162\145\143\145\x69\x76\145\144\40\164\x6f\40\166\x61\154\151\x64\141\x74\145\x2e", "\164\x78\x49\144" => "\61");
        goto AHiEF;
        QGOpz:
        $RNGvP = array("\x73\164\x61\x74\165\163" => "\106\101\x49\114\105\104", "\155\x65\x73\x73\141\x67\x65" => isset($ZCRMZ["\155\x65\163\163\141\147\145"]) ? $ZCRMZ["\155\x65\163\163\x61\x67\x65"] : "\125\156\153\156\x6f\167\156\40\145\x72\162\157\x72\40\x6f\143\x63\165\x72\x72\145\144\x2e", "\164\170\x49\x64" => "\61");
        AHiEF:
        dfIZ6:
        return $RNGvP;
    }
    public function getSkipTwoFa()
    {
        $this->log_debug("\124\167\x6f\106\x41\125\x74\151\154\x69\x74\171\56\x70\150\x70\x20\x3a\40\x69\x6e\163\x69\144\x65\x20\x67\145\x74\123\153\151\160\124\x77\157\x46\141");
        $BKQVm = $this->getStoreConfig(TwoFAConstants::SKIP_TWOFA_DAYS);
        if ($BKQVm == "\x70\x65\162\x6d\141\x6e\145\x6e\x74") {
            goto C7e63;
        }
        $this->whitelistCustomerThroughSession(true);
        goto LxS6r;
        C7e63:
        $this->whitelistCustomerThroughSession(false);
        LxS6r:
        $this->getClearSessionForSkipTwoFA();
        return $this->loginAndRedirectCustomer();
    }
    public function whitelistCustomerThroughSession($rVsze = false)
    {
        $iwHG8 = $this->getSessionValue("\155\x6f\165\x73\x65\162\156\141\155\x65");
        $TFqWY = $this->getCustomerMoTfaUserDetails("\155\151\156\x69\157\x72\141\x6e\147\145\137\x74\146\x61\137\x75\163\x65\x72\163", $iwHG8);
        $FCDQy = $this->storeManager->getStore()->getWebsiteId();
        if (is_array($TFqWY) && sizeof($TFqWY) > 0) {
            goto yRGWL;
        }
        $this->getSessionValue(TwoFAConstants::CUSTOMER_INLINE);
        $T2SYt = $this->getSessionValue(TwoFAConstants::CUSTOMER__PHONE);
        $aaEqu = $this->getSessionValue(TwoFAConstants::CUSTOMER__EMAIL);
        $jeGDv = $this->getSessionValue(TwoFAConstants::CUSTOMER_COUNTRY_CODE);
        $Mjbsa = $this->getSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID);
        if ($rVsze) {
            goto nuXqw;
        }
        $tCjDh = "\x55\x73\145\162\x5f\163\153\151\160\124\167\157\x66\x61\137\160\145\162\155\141\156\x65\156\164\154\x79";
        $Fd8kh = "\125\163\x65\162\x5f\163\x6b\151\x70\x54\167\x6f\146\141\137\160\x65\162\155\x61\x6e\x65\x6e\164\x6c\x79";
        $ZXtEF = "\125\163\145\162\x5f\163\153\151\160\124\x77\157\146\141\x5f\x70\x65\162\155\x61\x6e\x65\x6e\x74\154\171";
        $CHYZg = [["\x75\163\x65\x72\x6e\141\155\145" => $iwHG8, "\x63\157\156\x66\151\147\165\162\145\144\137\155\x65\164\150\x6f\x64\163" => $Fd8kh, "\x61\143\164\x69\166\145\137\x6d\145\164\150\x6f\144" => $tCjDh, "\x73\145\143\162\145\164" => $ZXtEF, "\x77\x65\x62\x73\151\x74\x65\137\151\144" => $FCDQy, "\163\153\x69\160\137\x74\167\157\x66\x61\137\x70\x72\x65\x6d\141\x6e\145\x6e\x74" => true]];
        goto arzkY;
        nuXqw:
        $tCjDh = "\125\x73\x65\162\x5f\163\153\x69\160\124\x77\157\146\141";
        $Fd8kh = "\125\163\145\x72\x5f\163\x6b\151\x70\x54\167\x6f\146\141";
        $ZXtEF = "\125\163\x65\162\137\163\x6b\x69\160\x54\167\157\146\x61";
        $CHYZg = [["\x75\x73\x65\162\156\x61\155\x65" => $iwHG8, "\143\157\x6e\146\151\x67\165\x72\145\144\x5f\155\x65\164\150\157\x64\163" => $Fd8kh, "\141\x63\164\x69\166\x65\x5f\x6d\145\x74\x68\157\x64" => $tCjDh, "\163\145\143\x72\145\164" => $ZXtEF, "\x77\x65\142\x73\x69\x74\x65\x5f\151\144" => $FCDQy, "\163\x6b\x69\160\x5f\164\167\157\x66\x61\x5f\x70\162\x65\x6d\x61\x6e\145\156\164" => false]];
        arzkY:
        $this->insertRowInTable("\x6d\151\156\151\157\x72\141\156\147\145\137\164\x66\141\137\x75\x73\x65\162\x73", $CHYZg);
        if (!$rVsze) {
            goto gff7o;
        }
        $this->updateColumnInTable("\x6d\x69\156\151\x6f\x72\141\x6e\147\145\x5f\164\x66\x61\137\x75\x73\145\x72\163", "\163\x6b\x69\x70\x5f\x74\167\157\x66\141", (int) 1, "\x75\x73\145\162\156\141\x6d\145", $iwHG8, $FCDQy);
        gff7o:
        $S9S20 = json_encode(array("\143\157\156\146\151\x67\x75\162\x65\x64\x5f\x64\x61\x74\x65" => date("\131\x2d\155\55\x64")));
        $this->updateColumnInTable("\155\151\156\x69\157\x72\141\156\147\x65\x5f\164\146\x61\x5f\165\x73\x65\x72\x73", "\x73\x6b\x69\x70\x5f\x74\x77\x6f\x66\x61\137\143\157\156\x66\x69\x67\x75\162\x65\144\x5f\144\141\x74\145", $S9S20, "\165\163\145\162\x6e\x61\155\145", $iwHG8, $FCDQy);
        if (!($tCjDh == "\x4f\x4f\123" || $tCjDh == "\x4f\117\x53\x45")) {
            goto S6MSC;
        }
        if (!($T2SYt != NULL)) {
            goto jzXGT;
        }
        $this->updateColumnInTable("\155\x69\156\x69\157\162\x61\x6e\147\x65\x5f\164\146\x61\137\x75\x73\x65\162\x73", "\160\150\x6f\156\145", $T2SYt, "\165\x73\145\162\x6e\x61\x6d\x65", $iwHG8, $FCDQy);
        $this->updateColumnInTable("\x6d\151\x6e\151\x6f\x72\x61\x6e\147\x65\137\x74\x66\141\137\x75\163\145\x72\x73", "\x63\157\165\x6e\164\x72\x79\143\x6f\x64\145", $jeGDv, "\x75\x73\145\162\x6e\141\155\x65", $iwHG8, $FCDQy);
        jzXGT:
        S6MSC:
        if (!($tCjDh == "\x4f\x4f\105" || $tCjDh == "\117\117\123\105")) {
            goto d362F;
        }
        if (!($aaEqu != NULL)) {
            goto tpDNF;
        }
        $this->updateColumnInTable("\x6d\151\x6e\x69\x6f\162\x61\156\147\x65\x5f\x74\146\x61\x5f\x75\x73\145\162\163", "\x65\155\x61\151\x6c", $aaEqu, "\165\163\x65\162\x6e\x61\x6d\x65", $iwHG8, $FCDQy);
        tpDNF:
        d362F:
        goto uxAO6;
        yRGWL:
        if ($rVsze) {
            goto Jt_VB;
        }
        $this->updateColumnInTable("\x6d\151\x6e\151\157\162\x61\x6e\x67\x65\x5f\x74\146\x61\137\165\x73\x65\x72\x73", "\x73\153\151\x70\x5f\x74\x77\157\x66\x61\x5f\160\162\x65\x6d\141\x6e\145\156\x74", true, "\x75\163\145\x72\156\x61\x6d\x65", $iwHG8, $FCDQy);
        $this->updateColumnInTable("\x6d\151\156\151\157\162\x61\x6e\x67\145\x5f\x74\x66\x61\x5f\165\x73\x65\162\x73", "\141\x63\164\151\x76\x65\x5f\155\145\x74\150\x6f\x64", "\x55\163\145\162\x5f\163\153\151\x70\124\x77\x6f\x66\x61\137\x70\x65\x72\155\x61\156\145\x6e\164\x6c\171", "\165\x73\x65\x72\156\x61\155\145", $iwHG8, $FCDQy);
        $this->updateColumnInTable("\155\151\156\151\x6f\162\141\156\x67\x65\137\164\146\x61\x5f\x75\163\145\x72\x73", "\163\x65\143\162\x65\164", "\125\163\x65\162\x5f\x73\x6b\x69\x70\x54\167\157\146\x61\x5f\160\x65\x72\155\141\x6e\145\156\x74\x6c\x79", "\x75\163\x65\x72\x6e\141\155\145", $iwHG8, $FCDQy);
        $this->updateColumnInTable("\155\x69\156\151\157\x72\141\x6e\147\x65\137\164\146\141\137\165\x73\145\162\x73", "\143\x6f\x6e\146\x69\147\x75\x72\x65\144\137\155\x65\x74\x68\157\x64\163", "\125\163\145\162\x5f\163\x6b\151\x70\124\x77\x6f\146\x61\x5f\x70\145\162\x6d\x61\x6e\x65\156\164\154\x79", "\x75\163\145\x72\156\141\x6d\x65", $iwHG8, $FCDQy);
        goto UKusx;
        Jt_VB:
        $TFqWY = $this->getCustomerMoTfaUserDetails("\x6d\151\x6e\151\x6f\x72\x61\x6e\x67\145\137\164\146\141\137\x75\x73\x65\x72\x73", $iwHG8);
        if (!empty($TFqWY) && isset($TFqWY[0]["\163\x6b\151\x70\x5f\x74\167\x6f\x66\141"])) {
            goto g8rZ4;
        }
        $O9XU8 = 1;
        goto hgp63;
        g8rZ4:
        $szl59 = $TFqWY[0]["\163\x6b\151\x70\137\164\x77\157\x66\141"];
        $O9XU8 = (int) $szl59 + 1;
        hgp63:
        $this->updateColumnInTable("\155\151\156\x69\157\x72\x61\156\x67\x65\x5f\164\146\x61\x5f\x75\163\145\x72\163", "\163\x6b\x69\160\137\x74\x77\157\146\141", $O9XU8, "\x75\163\x65\162\x6e\141\155\x65", $iwHG8, $FCDQy);
        UKusx:
        $S9S20 = json_encode(array("\x63\x6f\156\x66\x69\147\x75\x72\145\x64\137\144\141\164\145" => date("\x59\x2d\x6d\55\144")));
        $this->updateColumnInTable("\x6d\151\156\x69\x6f\162\141\x6e\x67\x65\137\164\146\141\x5f\x75\x73\145\x72\163", "\x73\153\x69\160\x5f\x74\x77\x6f\x66\x61\x5f\x63\x6f\156\146\x69\147\165\x72\x65\x64\x5f\144\141\x74\145", $S9S20, "\x75\x73\145\x72\156\x61\x6d\x65", $iwHG8, $FCDQy);
        uxAO6:
    }
    public function updateColumnInTable($Rsl0O, $B9FOg, $WE3Ng, $gQDIn, $XwJLZ, $FCDQy)
    {
        $this->log_debug("\x75\x70\144\x61\x74\x65\x43\157\x6c\x75\x6d\156\111\x6e\x54\x61\142\154\145");
        $XmE47 = [$gQDIn . "\40\x3d\x20\x3f" => $XwJLZ, "\x77\x65\142\x73\151\164\145\x5f\x69\x64\x20\x3d\40\x3f" => $FCDQy];
        $this->resource->getConnection()->update($Rsl0O, [$B9FOg => $WE3Ng], $XmE47);
    }
    public function insertRowInTable($Rsl0O, $CHYZg)
    {
        $this->log_debug("\151\x6e\163\x65\162\164\40\162\x6f\167\40");
        $this->resource->getConnection()->insertMultiple($Rsl0O, $CHYZg);
    }
    public function getClearSessionForSkipTwoFA()
    {
        $this->setSessionValue(TwoFAConstants::CUSTOMER_INLINE, NULL);
        $this->setSessionValue(TwoFAConstants::CUSTOMER_SECRET, NULL);
        $this->setSessionValue(TwoFAConstants::CUSTOMER_TRANSACTIONID, NULL);
        $this->setSessionValue(TwoFAConstants::CUSTOMER_USERNAME, NULL);
        $this->setSessionValue(TwoFAConstants::CUSTOMER_ACTIVE_METHOD, NULL);
        $this->setSessionValue(TwoFAConstants::CUSTOMER_CONFIG_METHOD, NULL);
        $this->setSessionValue(TwoFAConstants::CUSTOMER__PHONE, NULL);
        $this->setSessionValue(TwoFAConstants::CUSTOMER_COUNTRY_CODE, NULL);
        $this->setSessionValue(TwoFAConstants::CUSTOMER__EMAIL, NULL);
    }
    public function loginAndRedirectCustomer()
    {
        $wL5TT = $this->getSessionValue("\x6d\x6f\x75\x73\x65\x72\x6e\x61\155\x65");
        $user = $this->getCustomerFromAttributes($wL5TT);
        $this->customerSession->setCustomerAsLoggedIn($user);
        $VOVsK = $this->url->getUrl("\x63\x75\x73\164\x6f\x6d\x65\x72\x2f\x61\143\x63\157\165\156\x74");
        $z4geL = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $z4geL->setUrl($VOVsK);
        return $z4geL;
    }
    public function getCustomerFromAttributes($Og5s3)
    {
        $this->log_debug("\x54\167\x6f\x46\141\125\164\x69\x6c\151\164\171\72\x20\x67\145\164\x43\165\x73\164\157\155\145\162\106\x72\157\155\101\164\x74\162\x69\x62\x75\x74\x65\163\x20");
        $this->customerModel->setWebsiteId($this->storeManager->getStore()->getWebsiteId());
        $M1pJH = $this->customerModel->loadByEmail($Og5s3);
        return !is_null($M1pJH->getId()) ? $M1pJH : false;
    }
    public function getSkipTwoFa_Admin()
    {
        $this->log_debug("\124\167\157\106\x41\125\x74\151\x6c\x69\164\x79\x2e\x70\150\160\x20\x3a\40\151\x6e\x73\x69\x64\x65\40\x67\x65\164\123\153\151\x70\124\167\157\106\x61");
        $cJmxW = $this->get_admin_role_name();
        $BKQVm = $this->getStoreConfig(TwoFAConstants::SKIP_TWOFA_DAYS_ADMIN . $cJmxW);
        if ($BKQVm == "\160\145\x72\x6d\141\156\x65\156\164") {
            goto Xm_ab;
        }
        $this->whitelistAdminThroughSession(true);
        goto yshaW;
        Xm_ab:
        $this->whitelistAdminThroughSession(false);
        yshaW:
        $this->getClearAdminSessionForSkipTwoFA();
        return;
    }
    public function get_admin_role_name()
    {
        $d9jv6 = $this->userCollectionFactory->create();
        $SZG11 = $this->getSessionValue("\141\144\155\151\156\137\165\x73\145\x72\137\151\144");
        if (!($SZG11 == NULL && $this->authSession->isLoggedIn())) {
            goto np0cP;
        }
        $RH1A6 = $this->authSession->getUser();
        $SZG11 = $RH1A6->getId();
        np0cP:
        $d9jv6->addFieldToFilter("\155\141\x69\x6e\137\164\141\142\x6c\x65\x2e\x75\x73\x65\x72\x5f\151\144", $SZG11);
        $sPJmJ = $d9jv6->getFirstItem();
        $ER_5c = $sPJmJ->getData();
        $zsKMC = $ER_5c["\162\x6f\x6c\145\137\x6e\141\155\x65"];
        return $zsKMC;
    }
    public function whitelistAdminThroughSession($rVsze = false)
    {
        $iwHG8 = $this->getSessionValue(TwoFAConstants::ADMIN_USERNAME);
        $TFqWY = $this->getAllMoTfaUserDetails("\x6d\151\x6e\x69\157\162\141\156\147\x65\x5f\164\146\141\137\x75\x73\145\162\x73", $iwHG8, -1);
        $FCDQy = -1;
        if (is_array($TFqWY) && sizeof($TFqWY) > 0) {
            goto SbtB0;
        }
        $this->getSessionValue(TwoFAConstants::ADMIN_IS_INLINE);
        $T2SYt = $this->getSessionValue(TwoFAConstants::ADMIN__PHONE);
        $aaEqu = $this->getSessionValue(TwoFAConstants::ADMIN__EMAIL);
        $jeGDv = $this->getSessionValue(TwoFAConstants::ADMIN_COUNTRY_CODE);
        $Mjbsa = $this->getSessionValue(TwoFAConstants::ADMIN_TRANSACTIONID);
        if ($rVsze) {
            goto hRg7Q;
        }
        $tCjDh = "\x55\163\145\162\x5f\x73\153\x69\160\x54\x77\x6f\x66\141\137\x70\x65\x72\x6d\141\x6e\145\156\164\154\171";
        $Fd8kh = "\125\163\x65\x72\137\x73\x6b\151\160\124\x77\157\x66\x61\x5f\160\x65\x72\155\x61\x6e\145\x6e\164\154\x79";
        $ZXtEF = "\x55\x73\145\162\x5f\x73\x6b\x69\x70\x54\x77\x6f\x66\141\137\x70\x65\162\x6d\x61\x6e\145\156\x74\x6c\171";
        $CHYZg = [["\x75\163\x65\162\x6e\x61\x6d\x65" => $iwHG8, "\143\157\x6e\146\151\147\x75\x72\145\144\x5f\x6d\x65\x74\150\x6f\x64\x73" => $Fd8kh, "\x61\143\x74\x69\166\x65\x5f\x6d\x65\x74\x68\x6f\144" => $tCjDh, "\x73\145\143\x72\x65\x74" => $ZXtEF, "\167\145\x62\x73\151\164\x65\137\151\x64" => $FCDQy, "\163\153\x69\x70\137\x74\x77\157\146\141\137\160\x72\x65\x6d\141\156\145\156\x74" => true]];
        goto bP7aE;
        hRg7Q:
        $tCjDh = "\125\x73\x65\x72\x5f\x73\x6b\x69\x70\124\167\x6f\146\x61";
        $Fd8kh = "\125\x73\145\x72\x5f\x73\153\151\160\x54\x77\157\x66\x61";
        $ZXtEF = "\125\x73\x65\x72\x5f\x73\153\x69\160\124\x77\157\x66\x61";
        $CHYZg = [["\x75\163\x65\162\156\x61\155\145" => $iwHG8, "\x63\157\x6e\x66\x69\x67\165\162\145\x64\137\155\x65\x74\x68\x6f\144\163" => $Fd8kh, "\x61\143\x74\x69\x76\x65\137\x6d\x65\x74\x68\157\144" => $tCjDh, "\163\145\x63\162\x65\x74" => $ZXtEF, "\x77\x65\x62\x73\151\x74\x65\137\151\144" => $FCDQy, "\x73\153\151\160\x5f\164\x77\157\x66\x61\137\x70\162\145\155\141\x6e\145\x6e\x74" => false]];
        bP7aE:
        $this->insertRowInTable("\155\x69\x6e\151\x6f\162\141\156\147\x65\x5f\164\x66\x61\x5f\165\x73\145\x72\163", $CHYZg);
        if (!$rVsze) {
            goto hMAgr;
        }
        $this->updateColumnInTable("\155\151\156\x69\x6f\162\141\x6e\x67\x65\x5f\164\x66\x61\137\165\163\x65\162\x73", "\x73\153\x69\160\137\x74\167\157\146\x61", (int) 1, "\165\x73\145\x72\156\x61\x6d\x65", $iwHG8, $FCDQy);
        hMAgr:
        $S9S20 = json_encode(array("\x63\x6f\156\146\151\x67\165\162\x65\x64\x5f\144\x61\164\145" => date("\x59\x2d\155\55\x64")));
        $this->updateColumnInTable("\x6d\x69\x6e\x69\x6f\162\x61\156\147\145\137\x74\x66\141\x5f\x75\163\145\x72\163", "\163\153\x69\160\137\x74\167\157\146\x61\137\143\x6f\156\x66\151\x67\165\162\x65\144\x5f\x64\141\x74\145", $S9S20, "\x75\163\x65\x72\x6e\141\x6d\145", $iwHG8, $FCDQy);
        if (!($tCjDh == "\117\117\123" || $tCjDh == "\117\117\x53\105")) {
            goto UrL7o;
        }
        if (!($T2SYt != NULL)) {
            goto rkEbS;
        }
        $this->updateColumnInTable("\x6d\151\156\151\157\162\141\156\147\x65\x5f\164\x66\x61\x5f\x75\x73\x65\162\x73", "\160\x68\x6f\x6e\145", $T2SYt, "\165\x73\x65\x72\156\x61\155\145", $iwHG8, $FCDQy);
        $this->updateColumnInTable("\x6d\151\x6e\x69\x6f\x72\x61\156\x67\145\137\x74\146\141\x5f\x75\163\145\162\x73", "\x63\x6f\x75\156\164\x72\x79\x63\x6f\x64\x65", $jeGDv, "\x75\x73\x65\x72\x6e\x61\x6d\145", $iwHG8, $FCDQy);
        rkEbS:
        UrL7o:
        if (!($tCjDh == "\117\x4f\105" || $tCjDh == "\x4f\x4f\x53\105")) {
            goto qSOQO;
        }
        if (!($aaEqu != NULL)) {
            goto Dg4bR;
        }
        $this->updateColumnInTable("\x6d\x69\x6e\x69\x6f\162\141\156\147\145\x5f\x74\146\141\137\x75\163\x65\x72\x73", "\x65\155\x61\151\x6c", $aaEqu, "\165\163\145\x72\x6e\141\155\145", $iwHG8, $FCDQy);
        Dg4bR:
        qSOQO:
        goto Ac04J;
        SbtB0:
        if ($rVsze) {
            goto LgtLt;
        }
        $this->updateColumnInTable("\x6d\x69\x6e\x69\157\x72\x61\x6e\147\x65\137\x74\146\x61\x5f\165\x73\x65\162\163", "\163\x6b\x69\x70\137\164\x77\x6f\x66\141\137\x70\x72\145\x6d\x61\x6e\145\x6e\x74", true, "\165\163\x65\x72\x6e\141\155\x65", $iwHG8, $FCDQy);
        $this->updateColumnInTable("\155\x69\156\x69\x6f\162\141\x6e\147\x65\137\x74\146\141\137\165\x73\x65\162\163", "\141\x63\164\x69\x76\145\x5f\155\145\x74\x68\157\x64", "\x55\x73\145\162\x5f\x73\x6b\x69\x70\x54\x77\x6f\x66\x61\x5f\160\145\x72\155\x61\x6e\x65\x6e\x74\x6c\x79", "\x75\163\145\x72\156\x61\155\x65", $iwHG8, $FCDQy);
        $this->updateColumnInTable("\155\x69\156\x69\157\162\141\x6e\147\145\x5f\x74\146\141\x5f\x75\163\145\x72\163", "\x73\145\x63\162\x65\164", "\x55\163\x65\162\x5f\x73\x6b\151\160\x54\167\x6f\x66\141\x5f\160\145\x72\x6d\x61\156\x65\x6e\x74\x6c\x79", "\x75\x73\145\x72\156\141\x6d\145", $iwHG8, $FCDQy);
        $this->updateColumnInTable("\155\151\156\151\x6f\x72\x61\156\147\145\137\x74\146\x61\x5f\x75\x73\x65\x72\x73", "\x63\x6f\156\146\x69\147\165\x72\145\x64\x5f\155\145\x74\150\157\x64\163", "\125\163\x65\162\137\163\x6b\x69\x70\x54\x77\157\x66\141\137\x70\145\x72\x6d\x61\x6e\x65\156\164\154\171", "\x75\163\145\162\156\141\x6d\x65", $iwHG8, $FCDQy);
        goto XieM2;
        LgtLt:
        if (!empty($TFqWY) && isset($TFqWY[0]["\163\x6b\151\x70\137\164\x77\157\146\x61"])) {
            goto IHv7g;
        }
        $O9XU8 = 1;
        goto tA4vX;
        IHv7g:
        $szl59 = $TFqWY[0]["\x73\x6b\x69\160\137\x74\167\x6f\146\141"];
        $O9XU8 = (int) $szl59 + 1;
        tA4vX:
        $this->updateColumnInTable("\x6d\x69\156\x69\x6f\x72\x61\156\147\x65\137\x74\x66\x61\x5f\165\x73\x65\162\163", "\x73\153\x69\160\x5f\164\x77\157\146\x61", $O9XU8, "\x75\163\145\162\156\141\x6d\x65", $iwHG8, -1);
        $S9S20 = json_encode(array("\x63\157\156\146\x69\x67\165\x72\145\x64\137\144\141\164\145" => date("\x59\x2d\x6d\55\144")));
        $this->updateColumnInTable("\155\x69\x6e\151\157\x72\141\156\147\145\137\x74\146\141\137\x75\163\x65\x72\163", "\x73\x6b\x69\x70\137\164\167\157\x66\141\137\x63\x6f\x6e\x66\x69\x67\165\162\145\x64\137\x64\x61\164\x65", $S9S20, "\165\163\145\x72\156\141\155\x65", $iwHG8, $FCDQy);
        XieM2:
        Ac04J:
    }
    public function getClearAdminSessionForSkipTwoFA()
    {
        $this->log_debug("\124\x77\157\x46\101\x55\x74\x69\x6c\151\164\x79\56\160\x68\160\x20\x3a\x20\x63\x6c\x65\141\x72\x69\156\147\40\163\145\x73\x73\151\157\x6e\40\x66\157\162\40\x61\144\155\x69\156");
        $this->setSessionValue(TwoFAConstants::ADMIN_IS_INLINE, NULL);
        $this->setSessionValue(TwoFAConstants::ADMIN_SECRET, NULL);
        $this->setSessionValue(TwoFAConstants::ADMIN_TRANSACTIONID, NULL);
        $this->setSessionValue(TwoFAConstants::ADMIN_USERNAME, NULL);
        $this->setSessionValue(TwoFAConstants::ADMIN_ACTIVE_METHOD, NULL);
        $this->setSessionValue(TwoFAConstants::ADMIN_CONFIG_METHOD, NULL);
        $this->setSessionValue(TwoFAConstants::ADMIN__PHONE, NULL);
        $this->setSessionValue(TwoFAConstants::ADMIN_COUNTRY_CODE, NULL);
        $this->setSessionValue(TwoFAConstants::ADMIN__EMAIL, NULL);
    }
    public function check_and_save_device_data($wFHPq, $iwHG8, $FCDQy, $TFqWY)
    {
        if ($FCDQy == -1) {
            goto xn2Z9;
        }
        $this->log_debug("\124\167\x6f\106\101\x75\164\151\x6c\x69\x74\171\x3a\x3a\40\146\165\x6e\x63\164\151\157\156\x20\143\x68\x65\143\153\x5f\x61\x6e\x64\x5f\163\141\166\x65\137\144\x65\x76\151\143\145\x5f\144\141\164\141\x20\75\x3e\x20\x66\154\x6f\x77\x20\x73\164\x61\162\164\145\x64\40\x66\162\157\x6d\40\143\x75\x73\x74\x6f\x6d\145\162\56\x20");
        goto fvXQn;
        xn2Z9:
        $this->log_debug("\x54\167\x6f\x46\101\x75\164\x69\154\151\164\171\x3a\72\40\146\x75\x6e\143\164\151\157\156\40\143\150\x65\143\x6b\137\141\156\x64\x5f\x73\141\166\145\x5f\x64\145\166\151\143\145\x5f\144\x61\x74\x61\x20\x3d\x3e\40\x66\154\157\x77\x20\163\x74\141\x72\x74\x65\x64\40\146\x72\x6f\155\x20\141\x64\155\x69\156\56\x20");
        fvXQn:
        $DisAc = $_SERVER["\110\124\x54\120\x5f\125\123\105\122\137\101\107\105\x4e\x54"];
        $Lk9qX = $_SERVER["\122\x45\x4d\117\x54\x45\x5f\x41\104\104\x52"];
        list($kBQ07, $gWOaT) = $this->getBrowserAndOS($DisAc);
        $Ip4kM = $this->isMobileDevice($DisAc) ? "\x4d\x6f\142\x69\154\x65" : "\120\x43";
        $LF0Gt = $this->generateFingerprint($DisAc);
        $lVWuy = $this->generateRandomString();
        $vPfFo = ["\125\x73\x65\x72\x5f\102\162\157\x77\x73\x65\x72" => $kBQ07, "\125\x73\145\x72\x5f\x4f\x53" => $gWOaT, "\104\145\166\151\x63\x65\137\x54\171\x70\x65" => $Ip4kM, "\125\x73\145\162\40\111\x50" => $Lk9qX, "\106\151\x6e\147\145\x72\160\x72\151\156\164" => $LF0Gt, "\143\x6f\x6e\x66\151\147\165\x72\x65\x64\137\144\141\x74\145" => date("\x59\x2d\x6d\55\x64"), "\122\x61\x6e\144\x6f\x6d\137\x73\x74\162\x69\156\x67" => $lVWuy];
        $vx4wb = $vPfFo;
        $kYcQW = [];
        if (!(isset($TFqWY[0]["\144\x65\166\151\143\145\x5f\x69\x6e\x66\157"]) && !empty($TFqWY[0]["\144\145\x76\151\143\x65\x5f\151\156\146\157"]))) {
            goto xFORo;
        }
        $Z9eQs = $TFqWY[0]["\x64\x65\x76\x69\x63\145\x5f\x69\x6e\x66\x6f"];
        $kYcQW = json_decode($Z9eQs, true);
        xFORo:
        if ($FCDQy == -1) {
            goto xurcM;
        }
        $U2Cr4 = (int) $this->getStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE_COUNT);
        goto rzzcC;
        xurcM:
        $cJmxW = $this->get_admin_role_name();
        $U2Cr4 = (int) $this->getStoreConfig(TwoFAConstants::ADMIN_REMEMBER_DEVICE_COUNT . $cJmxW);
        rzzcC:
        $q_qp6 = count($kYcQW);
        $kh76A = false;
        foreach ($kYcQW as &$BmEVx) {
            $RGKXc = true;
            $po1em = ["\106\151\156\147\x65\x72\x70\162\151\x6e\x74"];
            foreach ($po1em as $ExI8o) {
                if (!(!isset($BmEVx[$ExI8o]) || !isset($vPfFo[$ExI8o]) || $BmEVx[$ExI8o] !== $vPfFo[$ExI8o])) {
                    goto EK1LL;
                }
                $RGKXc = false;
                goto y6J7K;
                EK1LL:
                YdfQO:
            }
            y6J7K:
            if (!$RGKXc) {
                goto TmYhT;
            }
            if ($FCDQy == -1) {
                goto ZiRWk;
            }
            $ghrE1 = "\144\145\x76\x69\x63\x65\137\x69\156\146\157\x5f" . hash("\x73\150\141\x32\65\66", $iwHG8);
            $Sa03H = $_COOKIE[$ghrE1] ?? null;
            goto pp6f0;
            ZiRWk:
            $ghrE1 = "\144\x65\166\151\143\145\137\151\x6e\146\x6f\137\x61\x64\x6d\x69\156\137" . hash("\163\150\x61\x32\x35\x36", $iwHG8);
            $Sa03H = $_COOKIE[$ghrE1] ?? null;
            pp6f0:
            if (!($Sa03H !== $BmEVx["\x52\141\x6e\x64\157\x6d\x5f\163\164\x72\151\156\x67"])) {
                goto LWHh5;
            }
            $this->log_debug("\124\167\x6f\x46\101\165\164\x69\x6c\151\x74\x79\x3a\x3a\x20\x66\x75\x6e\143\x74\151\157\156\40\x63\150\145\x63\153\137\x61\156\x64\x5f\163\141\x76\x65\x5f\x64\x65\166\151\x63\145\x5f\x64\x61\x74\141\x20\75\x3e\x63\157\x6f\153\151\145\163\x20\x64\x6f\x65\163\x6e\157\x74\40\x6d\x61\x74\143\x68\x20\x77\x69\164\150\40\x66\x69\156\147\145\162\x70\x72\151\x6e\164");
            $RGKXc = false;
            LWHh5:
            TmYhT:
            if (!$RGKXc) {
                goto jF8ic;
            }
            $BmEVx["\143\x6f\x6e\x66\x69\x67\165\162\x65\x64\137\x64\x61\x74\x65"] = date("\x59\55\155\x2d\x64");
            $BmEVx["\x52\x61\156\x64\x6f\x6d\137\163\x74\x72\151\x6e\x67"] = $lVWuy;
            $oX1co = $this->cookieMetadataFactory->createPublicCookieMetadata();
            $oX1co->setPath("\57");
            $oX1co->setHttpOnly(false);
            if ($FCDQy == -1) {
                goto c_tW4;
            }
            $VVoRY = (int) $this->getStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE_LIMIT);
            $oX1co->setDuration($VVoRY * 24 * 60 * 60);
            $ghrE1 = "\144\x65\166\x69\x63\x65\137\x69\156\146\x6f\x5f" . hash("\163\x68\141\62\x35\x36", $iwHG8);
            $this->cookieManager->setPublicCookie($ghrE1, $lVWuy, $oX1co);
            goto wjJYN;
            c_tW4:
            $cJmxW = $this->get_admin_role_name();
            $VVoRY = (int) $this->getStoreConfig(TwoFAConstants::ADMIN_REMEMBER_DEVICE_LIMIT . $cJmxW);
            $oX1co->setDuration($VVoRY * 24 * 60 * 60);
            $ghrE1 = "\x64\x65\x76\151\143\145\137\x69\156\x66\x6f\137\x61\144\155\151\156\x5f" . hash("\x73\x68\x61\62\x35\66", $iwHG8);
            $this->cookieManager->setPublicCookie($ghrE1, $lVWuy, $oX1co);
            wjJYN:
            $this->log_debug("\124\x77\157\106\101\165\x74\151\x6c\x69\164\171\x3a\72\x20\146\x75\156\143\164\x69\x6f\156\40\143\x68\145\x63\153\137\141\x6e\144\x5f\163\141\166\145\137\x64\145\166\x69\143\145\137\144\141\164\141\40\75\76\x20\x75\160\144\x61\164\x65\x64\40\x64\x61\164\x65\54\x72\x61\156\144\157\x6d\x20\163\164\x72\x69\156\x67\x20\x61\156\x64\x20\143\157\157\153\x69\x65\40\x76\141\x6c\165\145");
            $kh76A = true;
            goto Y2kOM;
            jF8ic:
            gmtmx:
        }
        Y2kOM:
        $this->log_debug("\124\167\x6f\106\101\x75\164\151\154\151\164\x79\x3a\72\x20\146\165\156\x63\164\x69\157\x6e\x20\143\x68\145\143\153\x5f\141\x6e\144\x5f\163\141\166\x65\x5f\x64\145\x76\x69\x63\x65\x5f\144\141\x74\x61\x20\x3d\76\40\x63\150\145\x63\153\x20\x69\x66\x20\144\x65\x76\151\143\x65\x20\x61\x6c\x72\x65\141\x64\171\x20\160\162\145\x73\x65\x6e\x74\40\x6f\x72\40\156\x6f\x74\56\x20" . $kh76A);
        if ($U2Cr4 == 1 && $q_qp6 == 1 && !$kh76A) {
            goto re9qe;
        }
        if ($kh76A) {
            goto cwHe1;
        }
        if (!($q_qp6 >= $U2Cr4)) {
            goto jcZYP;
        }
        $this->log_debug("\124\x77\x6f\106\101\165\x74\x69\154\x69\x74\x79\x3a\72\x20\x66\x75\x6e\143\164\x69\157\156\40\x63\150\x65\x63\153\137\141\x6e\x64\137\163\x61\166\145\137\144\x65\x76\151\x63\145\137\x64\141\x74\141\40\75\x3e\40\x44\x65\166\151\143\x65\40\154\151\x6d\151\164\40\162\x65\x61\143\x68\145\x64\x2e\40\x4e\145\x77\40\144\x65\166\x69\x63\x65\40\x69\156\x66\x6f\x20\x6e\157\x74\x20\163\164\157\x72\x65\x64\56");
        return;
        jcZYP:
        $kYcQW[] = $vPfFo;
        $this->log_debug("\124\167\157\106\101\x75\x74\151\154\151\x74\171\x3a\x3a\x20\146\x75\156\143\164\x69\x6f\156\40\x63\150\x65\143\153\x5f\x61\x6e\x64\137\163\x61\166\x65\x5f\144\145\x76\x69\x63\145\x5f\x64\141\x74\x61\40\x3d\76\40\116\145\167\40\144\145\166\x69\x63\x65\40\x69\x6e\x66\157\40\x61\x64\144\x65\x64\x20\164\x6f\40\163\x61\166\x65\x64\x20\144\x65\166\x69\x63\145\163\56");
        $oX1co = $this->cookieMetadataFactory->createPublicCookieMetadata();
        $oX1co->setPath("\x2f");
        $oX1co->setHttpOnly(false);
        if ($FCDQy == -1) {
            goto T3dQ_;
        }
        $VVoRY = (int) $this->getStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE_LIMIT);
        $oX1co->setDuration($VVoRY * 24 * 60 * 60);
        $ghrE1 = "\144\x65\166\x69\x63\145\137\x69\156\x66\157\137" . hash("\163\150\x61\62\x35\x36", $iwHG8);
        $this->cookieManager->setPublicCookie($ghrE1, $lVWuy, $oX1co);
        goto zQ23A;
        T3dQ_:
        $cJmxW = $this->get_admin_role_name();
        $VVoRY = (int) $this->getStoreConfig(TwoFAConstants::ADMIN_REMEMBER_DEVICE_LIMIT . $cJmxW);
        $oX1co->setDuration($VVoRY * 24 * 60 * 60);
        $ghrE1 = "\144\x65\x76\x69\143\x65\137\x69\156\146\157\x5f\x61\x64\155\151\156\x5f" . hash("\163\150\x61\x32\65\66", $iwHG8);
        $this->cookieManager->setPublicCookie($ghrE1, $lVWuy, $oX1co);
        zQ23A:
        $this->log_debug("\124\167\157\x46\x41\x75\x74\x69\154\151\x74\171\72\x3a\40\x66\x75\156\143\164\151\x6f\x6e\40\x63\x68\x65\x63\x6b\137\141\156\144\137\163\x61\166\145\x5f\144\x65\166\x69\x63\145\137\x64\x61\x74\141\x20\75\76\x20\x73\164\157\162\145\163\x20\x66\151\x6e\x67\145\162\160\x72\x69\156\x74\x20\151\x6e\40\143\x6f\x6f\153\x69\145\163\40\146\x6f\x72\x20\x64\x61\x79\x73\x2d" . $VVoRY);
        cwHe1:
        goto fTFD7;
        re9qe:
        $kYcQW = [$vPfFo];
        $this->log_debug("\x54\167\x6f\x46\101\x75\x74\151\154\151\x74\x79\x3a\x3a\40\146\165\x6e\x63\x74\151\x6f\156\40\x63\150\145\143\153\137\141\x6e\144\x5f\163\x61\166\145\x5f\144\145\x76\151\143\145\137\144\x61\164\x61\x20\75\76\x20\104\145\166\151\x63\x65\40\x6c\151\155\x69\164\x20\151\x73\40\x31\54\x20\x72\145\x70\x6c\x61\x63\151\156\147\40\164\x68\x65\40\157\x6c\144\x20\x64\x65\x76\151\143\x65\40\167\x69\x74\x68\x20\156\x65\167\40\144\145\166\x69\x63\x65\x20\151\x6e\146\157\x2e");
        $oX1co = $this->cookieMetadataFactory->createPublicCookieMetadata();
        $oX1co->setPath("\57");
        $oX1co->setHttpOnly(false);
        if ($FCDQy == -1) {
            goto qSq41;
        }
        $VVoRY = (int) $this->getStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE_LIMIT);
        $oX1co->setDuration($VVoRY * 24 * 60 * 60);
        $ghrE1 = "\x64\x65\x76\151\x63\x65\x5f\151\x6e\146\x6f\137" . hash("\x73\x68\x61\62\65\66", $iwHG8);
        $this->cookieManager->setPublicCookie($ghrE1, $lVWuy, $oX1co);
        goto r3oPZ;
        qSq41:
        $cJmxW = $this->get_admin_role_name();
        $VVoRY = (int) $this->getStoreConfig(TwoFAConstants::ADMIN_REMEMBER_DEVICE_LIMIT . $cJmxW);
        $oX1co->setDuration($VVoRY * 24 * 60 * 60);
        $ghrE1 = "\144\x65\166\x69\x63\x65\137\x69\156\x66\x6f\x5f\x61\x64\155\151\156\x5f" . hash("\x73\x68\x61\x32\65\66", $iwHG8);
        $this->cookieManager->setPublicCookie($ghrE1, $lVWuy, $oX1co);
        r3oPZ:
        fTFD7:
        $this->updateColumnInTable("\x6d\x69\156\x69\157\162\x61\x6e\x67\x65\x5f\x74\146\141\x5f\165\163\x65\162\163", "\x64\x65\x76\x69\143\145\137\x69\156\146\157", json_encode($kYcQW), "\x75\x73\x65\x72\x6e\141\155\x65", $iwHG8, $FCDQy);
    }
    public function getBrowserAndOS($DisAc)
    {
        if (strpos($DisAc, "\105\x64\147") !== false) {
            goto RSkPf;
        }
        if (strpos($DisAc, "\117\120\x52") !== false || strpos($DisAc, "\x4f\x70\x65\162\x61") !== false) {
            goto lSiDY;
        }
        if (strpos($DisAc, "\103\x68\162\157\155\x65") !== false) {
            goto GRbwo;
        }
        if (strpos($DisAc, "\106\151\x72\x65\146\x6f\170") !== false) {
            goto Cw7H0;
        }
        if (strpos($DisAc, "\x53\x61\146\x61\x72\151") !== false && strpos($DisAc, "\103\x68\x72\157\x6d\145") === false && strpos($DisAc, "\x45\144\147") === false) {
            goto JNO2S;
        }
        if ((strpos($DisAc, "\115\x53\x49\x45") !== false || strpos($DisAc, "\124\x72\x69\x64\145\x6e\164") !== false) && !strpos($DisAc, "\x4f\x70\x65\162\x61") !== false) {
            goto oIgow;
        }
        if (strpos($DisAc, "\x4e\145\x74\163\143\141\160\x65") !== false) {
            goto xTv_5;
        }
        return array("\x55\x6e\153\156\x6f\167\156", $this->getOS($DisAc));
        goto aVQ7U;
        RSkPf:
        return array("\115\151\143\162\157\x73\x6f\146\164\40\x45\x64\147\145", $this->getOS($DisAc));
        goto aVQ7U;
        lSiDY:
        return array("\x4f\160\145\162\x61", $this->getOS($DisAc));
        goto aVQ7U;
        GRbwo:
        return array("\103\x68\x72\x6f\x6d\145", $this->getOS($DisAc));
        goto aVQ7U;
        Cw7H0:
        return array("\106\x69\162\145\x66\157\x78", $this->getOS($DisAc));
        goto aVQ7U;
        JNO2S:
        return array("\x53\x61\x66\141\x72\x69", $this->getOS($DisAc));
        goto aVQ7U;
        oIgow:
        return array("\x49\x6e\x74\145\162\x6e\x65\x74\x20\x45\170\x70\154\x6f\162\x65\162", $this->getOS($DisAc));
        goto aVQ7U;
        xTv_5:
        return array("\x4e\x65\x74\x73\143\x61\160\x65", $this->getOS($DisAc));
        aVQ7U:
        return array("\x55\x6e\x6b\156\157\167\156\40\x42\x72\157\x77\x73\145\162", $this->getOS($DisAc));
    }
    public function getOS($DisAc)
    {
        if (strpos($DisAc, "\x57\x69\x6e\x64\x6f\167\163") !== false) {
            goto BdZR4;
        }
        if (strpos($DisAc, "\x4d\x61\x63\x69\x6e\164\x6f\163\x68") !== false || strpos($DisAc, "\x4d\141\143\40\117\123\x20\x58") !== false) {
            goto p7oPY;
        }
        if (strpos($DisAc, "\x4c\151\156\x75\x78") !== false) {
            goto akeRd;
        }
        if (strpos($DisAc, "\101\x6e\144\x72\x6f\x69\144") !== false) {
            goto q2fPg;
        }
        if (strpos($DisAc, "\x69\120\x68\157\x6e\x65") !== false || strpos($DisAc, "\151\x50\141\144") !== false || strpos($DisAc, "\151\x50\157\144") !== false) {
            goto q_69Q;
        }
        goto bzZi8;
        BdZR4:
        return "\127\151\x6e\x64\157\167\163";
        goto bzZi8;
        p7oPY:
        return "\115\x61\x63";
        goto bzZi8;
        akeRd:
        return "\114\151\x6e\165\170";
        goto bzZi8;
        q2fPg:
        return "\x41\156\144\x72\157\x69\x64";
        goto bzZi8;
        q_69Q:
        return "\x69\x4f\x53";
        bzZi8:
        return "\x55\156\x6b\x6e\157\167\156\x20\x4f\123";
    }
    public function isMobileDevice($DisAc)
    {
        $HHILH = array("\101\x6e\144\x72\x6f\151\x64", "\x69\x50\150\x6f\x6e\145", "\151\x50\x61\x64", "\x69\120\x6f\x64", "\102\x6c\x61\x63\x6b\102\145\x72\162\x79", "\x57\151\x6e\x64\x6f\x77\163\x20\x50\x68\x6f\x6e\145");
        foreach ($HHILH as $xbGd3) {
            if (!(stripos($DisAc, $xbGd3) !== false)) {
                goto wABxn;
            }
            return true;
            wABxn:
            VzQEJ:
        }
        PN8o5:
        return false;
    }
    public function generateFingerprint($DisAc)
    {
        return hash("\x73\x68\141\x32\65\x36", $DisAc);
    }
    public function check_device_limit($FCDQy, $iwHG8)
    {
        $this->log_debug("\124\167\x6f\x66\141\x55\x74\151\x6c\151\164\171\x3a\x20\146\x75\x6e\x63\164\x69\x6f\156\40\143\x68\x65\x63\x6b\137\144\x65\166\x69\143\145\x5f\x6c\151\x6d\151\x74\40\x3d\x3e\40\123\x74\x61\x72\x74\40\143\x68\145\143\153\151\156\147\40\x64\145\x76\151\143\145\x20\x6c\x69\x6d\151\164\40\146\157\162\40\167\x65\142\163\151\x74\145\x5f\151\x64\x3a\x20" . $FCDQy);
        $U2Cr4 = (int) $this->getStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE_COUNT);
        $this->log_debug("\x54\x77\157\146\x61\x55\x74\x69\154\x69\164\171\72\40\x66\165\x6e\143\x74\151\157\156\40\143\x68\x65\x63\x6b\137\144\145\x76\x69\143\x65\x5f\154\x69\x6d\151\x74\40\x3d\76\x20\x44\x65\166\151\143\x65\x20\154\151\x6d\151\x74\40\x63\x6f\156\x66\151\x67\x75\162\145\x64\40\146\157\162\x20\167\x65\x62\x73\151\164\x65\x5f\x69\x64\x3a\x20" . $U2Cr4);
        $aaEqu = $this->getSessionValue("\155\157\165\x73\145\x72\156\x61\155\x65");
        $wL5TT = isset($aaEqu) ? $aaEqu : $iwHG8;
        $this->log_debug("\124\167\157\x66\x61\125\164\151\x6c\x69\164\x79\x3a\40\x66\x75\156\x63\x74\151\x6f\x6e\40\x63\x68\x65\x63\153\137\x64\x65\166\151\x63\145\137\x6c\x69\155\151\164\x20\75\76\x20\x43\165\x72\x72\145\x6e\164\x20\165\163\x65\x72\x6e\141\155\145\72\x20" . $wL5TT);
        $TFqWY = $this->getAllMoTfaUserDetails("\155\x69\156\x69\x6f\162\141\156\x67\x65\137\x74\x66\x61\137\x75\x73\145\162\163", $wL5TT, $FCDQy);
        if (!(is_array($TFqWY) && sizeof($TFqWY) > 0 && isset($TFqWY[0]["\x64\145\166\x69\x63\x65\137\x69\156\x66\x6f"]) && !empty($TFqWY[0]["\x64\145\x76\x69\x63\x65\137\151\156\146\x6f"]))) {
            goto ZlgJv;
        }
        $this->log_debug("\x54\167\x6f\146\x61\125\x74\x69\154\151\x74\171\x3a\40\146\165\x6e\143\x74\151\x6f\156\40\x63\150\145\x63\x6b\x5f\x64\145\x76\x69\143\x65\137\x6c\x69\155\151\164\x20\x3d\x3e\40\x55\163\145\162\40\x68\141\x73\x20\x64\x65\166\151\143\145\x20\x69\156\146\157\x2e\x20\104\145\x63\157\x64\x69\156\x67\40\144\x65\166\x69\143\x65\40\151\x6e\x66\157\x2e");
        $Z9eQs = $TFqWY[0]["\x64\145\166\151\143\145\x5f\x69\x6e\146\x6f"];
        $kYcQW = json_decode($Z9eQs, true);
        $vx4wb = json_decode($this->getCurrentDeviceInfo(), true);
        foreach ($kYcQW as $BmEVx) {
            $RGKXc = true;
            $po1em = ["\106\x69\x6e\x67\145\x72\160\x72\x69\156\x74"];
            foreach ($po1em as $ExI8o) {
                if (!(!isset($BmEVx[$ExI8o]) || !isset($vx4wb[$ExI8o]) || $BmEVx[$ExI8o] !== $vx4wb[$ExI8o])) {
                    goto RxcVX;
                }
                $this->log_debug("\124\167\x6f\x66\141\125\164\x69\x6c\151\164\x79\72\40\146\x75\x6e\x63\164\x69\x6f\156\x20\x63\x68\x65\x63\153\x5f\x64\x65\166\x69\x63\145\x5f\x6c\151\x6d\x69\x74\x20\x3d\x3e\x20\x46\151\145\154\144\40\x6d\151\x73\155\141\164\143\x68\40\x66\x6f\x72\40\146\x69\x65\x6c\x64\x3a\40");
                $RGKXc = false;
                goto zzUpW;
                RxcVX:
                uGarf:
            }
            zzUpW:
            if (!$RGKXc) {
                goto GPIsM;
            }
            $ghrE1 = "\144\x65\x76\151\x63\x65\137\x69\x6e\146\157\137" . hash("\163\x68\141\x32\x35\x36", $wL5TT);
            $Sa03H = $_COOKIE[$ghrE1] ?? null;
            if (!(!isset($BmEVx["\x52\x61\x6e\x64\157\x6d\x5f\163\164\x72\151\156\147"]) || $Sa03H !== $BmEVx["\x52\x61\156\144\x6f\155\137\x73\164\162\x69\156\x67"])) {
                goto gbcwr;
            }
            $this->log_debug("\124\167\x6f\x66\141\x55\164\151\x6c\151\x74\x79\x3a\x63\157\x6f\153\151\x65\163\x20\x64\157\40\x6e\157\164\40\155\141\164\143\150\x20\167\151\164\x68\x20\146\151\x6e\147\145\x72\x70\x72\151\x6e\164");
            $RGKXc = false;
            gbcwr:
            GPIsM:
            if (!$RGKXc) {
                goto Aesfn;
            }
            $this->log_debug("\x54\167\157\x66\x61\x55\164\x69\154\151\x74\x79\56\160\150\x70\72\x20\x63\x68\145\143\153\137\144\145\x76\151\143\145\137\154\x69\155\x69\164\72\40\x43\x75\162\162\x65\156\x74\40\x64\145\x76\151\x63\x65\40\151\x73\40\141\154\x72\x65\141\x64\x79\40\163\x61\x76\145\x64\56\x20\101\x6c\154\x6f\x77\40\x72\x65\155\x65\155\142\x65\x72\x69\x6e\147\x20\x74\150\x65\x20\144\145\x76\151\143\x65\x2e");
            return true;
            Aesfn:
            anl2B:
        }
        OPL24:
        $q_qp6 = count($kYcQW);
        $this->log_debug("\x54\x77\x6f\146\141\x55\164\151\x6c\151\164\x79\x3a\40\146\x75\156\x63\164\151\x6f\156\40\x63\x68\x65\143\x6b\137\x64\145\x76\x69\143\145\137\154\151\x6d\x69\164\40\x3d\x3e\40\116\165\155\142\145\162\40\157\146\x20\163\141\x76\x65\x64\40\144\x65\x76\151\143\145\163\72\x20" . $q_qp6);
        if (!($U2Cr4 <= $q_qp6)) {
            goto cH_4Q;
        }
        $this->log_debug("\x54\x77\x6f\146\x61\125\x74\x69\x6c\151\x74\171\72\40\x66\165\x6e\143\164\x69\x6f\156\x20\143\150\x65\143\153\x5f\x64\x65\x76\151\x63\145\x5f\154\x69\x6d\151\x74\x20\75\x3e\40\104\145\166\151\143\145\40\154\151\155\151\x74\40\x72\145\x61\143\x68\x65\144\72\40" . $U2Cr4);
        if (!($U2Cr4 == 1 && $q_qp6 == 1)) {
            goto GSJOA;
        }
        $this->log_debug("\x54\167\157\x66\x61\125\164\151\x6c\151\x74\x79\x3a\40\x66\x75\156\143\164\x69\157\156\40\143\x68\145\x63\x6b\x5f\x64\x65\x76\151\x63\x65\x5f\x6c\x69\155\x69\164\40\75\76\x20\x43\165\x73\x74\157\x6d\x69\x7a\x61\164\151\x6f\x6e\72\40\x41\x6c\154\x6f\x77\40\x72\145\x6d\145\x6d\142\x65\162\151\x6e\147\x20\x74\150\x65\x20\x64\145\166\151\143\x65\x20\x61\163\x20\x6c\x69\x6d\151\164\x20\151\x73\x20\61\x20\141\x6e\x64\40\144\145\166\151\x63\145\x20\143\157\x75\156\x74\x20\x69\x73\x20\61\x2e");
        return true;
        GSJOA:
        $this->log_debug("\124\x77\x6f\146\141\x55\164\151\x6c\151\164\x79\56\160\x68\160\x3a\x20\143\x68\145\x63\153\137\144\145\166\x69\x63\145\x5f\x6c\151\155\x69\164\72\x20\x44\145\166\151\x63\145\40\154\x69\x6d\x69\164\40\162\x65\x61\x63\x68\145\144\x2e\40\104\145\x6e\171\x20\x72\x65\155\145\155\142\x65\162\151\x6e\x67\x20\164\150\x65\x20\144\145\166\x69\143\145\x2e");
        return false;
        cH_4Q:
        ZlgJv:
        $this->log_debug("\124\x77\x6f\146\x61\125\x74\151\x6c\x69\164\171\56\160\150\160\72\40\143\150\145\143\x6b\x5f\x64\145\166\151\143\145\137\154\x69\155\x69\x74\x3a\x20\x44\x65\166\151\143\x65\x20\154\151\x6d\x69\x74\40\x6e\x6f\x74\40\162\145\x61\143\x68\x65\x64\40\x6f\x72\40\156\x6f\40\x64\145\x76\151\143\x65\x20\151\156\146\x6f\x20\x66\157\x75\156\x64\56\40\101\x6c\154\x6f\167\40\162\x65\155\x65\155\x62\x65\x72\151\156\147\x20\164\x68\x65\40\144\x65\166\151\x63\x65\56");
        return true;
    }
    public function getCurrentDeviceInfo()
    {
        $DisAc = $_SERVER["\x48\x54\124\x50\x5f\x55\123\x45\x52\x5f\x41\x47\x45\116\x54"];
        $Lk9qX = $_SERVER["\122\105\115\117\x54\105\x5f\101\104\104\122"];
        list($kBQ07, $gWOaT) = $this->getBrowserAndOS($DisAc);
        $Ip4kM = $this->isMobileDevice($DisAc) ? "\x4d\x6f\142\151\x6c\145" : "\x50\103";
        $LF0Gt = $this->generateFingerprint($DisAc);
        $j4v76 = json_encode(array("\125\163\x65\x72\137\x42\162\157\167\163\x65\162" => $kBQ07, "\125\163\x65\162\x5f\x4f\123" => $gWOaT, "\x44\145\166\151\x63\145\137\x54\171\x70\x65" => $Ip4kM, "\125\x73\x65\162\40\x49\120" => $Lk9qX, "\x46\x69\156\147\145\162\x70\x72\151\156\164" => $LF0Gt));
        return $j4v76;
    }
    public function check_device_limit_admin($SxFl_)
    {
        $U2Cr4 = (int) $this->getStoreConfig(TwoFAConstants::ADMIN_REMEMBER_DEVICE_COUNT . $SxFl_);
        $iwHG8 = $this->getSessionValue(TwoFAConstants::ADMIN_USERNAME);
        if (!($iwHG8 == NULL)) {
            goto W2iTs;
        }
        $SZG11 = $this->getSessionValue("\141\x64\x6d\151\x6e\x5f\165\163\x65\162\x5f\151\x64");
        $d9jv6 = $this->userCollectionFactory->create();
        $d9jv6->addFieldToFilter("\155\x61\x69\156\x5f\164\x61\142\154\145\56\x75\163\x65\162\137\151\144", $SZG11);
        $sPJmJ = $d9jv6->getFirstItem();
        $iwHG8 = $sPJmJ->getUsername();
        W2iTs:
        $TFqWY = $this->getAllMoTfaUserDetails("\155\x69\156\151\x6f\162\x61\x6e\x67\x65\137\x74\146\x61\137\165\x73\145\x72\x73", $iwHG8, -1);
        $FCDQy = -1;
        if (!(is_array($TFqWY) && sizeof($TFqWY) > 0 && !empty($TFqWY[0]["\144\145\166\151\143\145\137\151\156\146\x6f"]))) {
            goto j5LX5;
        }
        $Z9eQs = $TFqWY[0]["\144\x65\x76\x69\x63\x65\137\x69\156\146\x6f"];
        $kYcQW = json_decode($Z9eQs, true);
        if (!is_array($kYcQW)) {
            goto XDrVZ;
        }
        $vx4wb = json_decode($this->getCurrentDeviceInfo(), true);
        foreach ($kYcQW as $BmEVx) {
            $RGKXc = true;
            $po1em = ["\x46\x69\156\x67\145\162\160\x72\x69\156\x74"];
            foreach ($po1em as $ExI8o) {
                if (!(!isset($BmEVx[$ExI8o]) || !isset($vx4wb[$ExI8o]) || $BmEVx[$ExI8o] !== $vx4wb[$ExI8o])) {
                    goto Q3neJ;
                }
                $RGKXc = false;
                goto LS1fK;
                Q3neJ:
                aUkCe:
            }
            LS1fK:
            if (!$RGKXc) {
                goto LoB0n;
            }
            $ghrE1 = "\144\x65\166\151\143\145\137\x69\x6e\x66\157\137\x61\144\155\x69\156\137" . hash("\x73\150\x61\x32\x35\x36", $iwHG8);
            $Sa03H = $_COOKIE[$ghrE1] ?? null;
            if (!($Sa03H !== $BmEVx["\122\x61\156\x64\x6f\155\x5f\x73\164\162\x69\x6e\147"])) {
                goto GWDmT;
            }
            $this->log_debug("\124\167\157\146\x61\125\x74\x69\x6c\x69\164\171\72\143\x6f\157\153\151\x65\163\x20\144\157\40\x6e\x6f\x74\40\x6d\x61\164\143\x68\x20\167\x69\x74\150\40\x66\151\156\147\x65\162\x70\x72\151\x6e\164");
            $RGKXc = false;
            GWDmT:
            LoB0n:
            if (!$RGKXc) {
                goto wCwki;
            }
            $this->log_debug("\x54\x77\157\146\x61\x55\x74\151\x6c\x69\x74\171\56\x70\150\160\x3a\40\x63\x68\145\x63\153\x5f\144\145\x76\151\x63\x65\137\154\x69\155\151\x74\x20\146\157\x72\x20\x61\x64\x6d\151\x6e\72\x20\103\165\x72\x72\x65\156\x74\x20\144\x65\166\x69\x63\145\40\151\x73\x20\x61\x6c\x72\x65\x61\144\x79\x20\x73\x61\x76\145\144\x2e\40\101\x6c\154\x6f\x77\x20\162\145\x6d\x65\155\x62\145\x72\x69\156\x67\40\x74\150\x65\x20\x64\145\x76\151\x63\145\56");
            return true;
            wCwki:
            E2v8k:
        }
        DXOdi:
        $q_qp6 = count($kYcQW);
        if (!($U2Cr4 <= $q_qp6)) {
            goto lkftJ;
        }
        $this->log_debug("\124\x77\x6f\146\x61\x55\164\151\154\x69\x74\171\56\x70\x68\160\72\40\143\150\145\143\153\x5f\144\x65\166\x69\143\x65\137\154\151\x6d\x69\x74\x20\146\157\162\x20\141\144\155\151\x6e\x3a\40\104\145\x76\x69\143\145\x20\154\151\155\151\164\x20\x72\145\x61\x63\150\145\144\x2e\40\104\x65\x6e\171\x20\x72\x65\x6d\145\155\x62\x65\162\x69\156\147\40\164\150\x65\40\x64\145\x76\151\143\x65\x2e");
        return false;
        lkftJ:
        XDrVZ:
        j5LX5:
        $this->log_debug("\124\167\157\146\x61\x55\x74\x69\154\x69\x74\x79\x2e\160\150\x70\72\x20\x63\x68\145\x63\153\x5f\x64\145\166\x69\143\145\137\154\151\x6d\x69\164\40\146\157\x72\40\x61\144\x6d\x69\156\72\x20\104\x65\x76\x69\143\x65\40\x6c\151\x6d\151\164\x20\156\157\164\40\x72\x65\141\x63\x68\145\144\x20\157\x72\x20\x6e\157\x20\144\x65\166\x69\x63\145\40\151\156\x66\157\40\146\x6f\x75\x6e\x64\56\40\101\154\x6c\x6f\x77\x20\x72\x65\x6d\145\155\x62\145\162\151\x6e\147\40\x74\150\x65\40\x64\x65\166\151\143\145\56");
        return true;
    }
    public function isCustomLogExist()
    {
        if ($this->fileSystem->isExists("\x2e\56\57\x76\x61\x72\x2f\x6c\x6f\x67\57\x6d\x6f\137\x74\x77\157\146\141\x2e\x6c\157\147")) {
            goto COnUZ;
        }
        if ($this->fileSystem->isExists("\166\x61\x72\57\x6c\157\x67\57\155\157\137\x74\167\157\x66\x61\x2e\154\157\147")) {
            goto Ng3CP;
        }
        goto VdWIy;
        COnUZ:
        return 1;
        goto VdWIy;
        Ng3CP:
        return 1;
        VdWIy:
        return 0;
    }
    public function deleteCustomLogFile()
    {
        if ($this->fileSystem->isExists("\x2e\x2e\57\x76\x61\x72\x2f\154\x6f\147\57\155\157\x5f\x74\167\x6f\146\x61\56\154\157\x67")) {
            goto NuzMk;
        }
        if ($this->fileSystem->isExists("\166\x61\x72\x2f\x6c\x6f\147\x2f\x6d\x6f\x5f\164\167\x6f\146\x61\56\x6c\157\147")) {
            goto eBVj_;
        }
        goto FdvHN;
        NuzMk:
        $this->fileSystem->deleteFile("\x2e\56\x2f\x76\x61\162\57\154\157\x67\x2f\x6d\x6f\137\x74\x77\157\x66\141\x2e\154\157\147");
        goto FdvHN;
        eBVj_:
        $this->fileSystem->deleteFile("\166\141\x72\x2f\154\x6f\x67\57\x6d\x6f\137\x74\x77\x6f\146\141\x2e\154\x6f\147");
        FdvHN:
    }
    public function get_magento_version()
    {
        return $this->productMetadata->getVersion();
    }
    public function send_otp_using_miniOrange_gateway_usingApicall($ktI0S, $OQ92p, $T2SYt)
    {
        $H9HzL = $this->getCustomerKeys(false);
        if ($H9HzL) {
            goto xMjki;
        }
        $this->log_debug("\x45\x78\x65\x63\165\164\x65\40\x68\145\141\x64\x61\x70\151\72\40\x6c\x6f\x67\151\156\40\x77\151\164\150\40\x6d\x69\x6e\151\x6f\x72\141\156\147\x65\x20\x41\x63\143\x6f\165\x6e\164\40\146\x69\x72\163\x74");
        return ["\155\x65\163\x73\x61\x67\145" => "\x50\x6c\x65\x61\x73\145\40\x6c\x6f\x67\x69\x6e\40\x77\x69\164\x68\40\155\151\x6e\151\x6f\162\141\156\147\145\40\101\143\x63\157\x75\x6e\164\40\146\x69\x72\163\x74"];
        xMjki:
        $FEKCL = $H9HzL["\143\x75\x73\164\x6f\x6d\145\162\x5f\x6b\145\171"];
        $kg91G = $H9HzL["\x61\x70\x69\113\x65\x79"];
        $raMDi = ["\x4f\x4f\105" => "\x45\115\x41\x49\x4c", "\x4f\117\x53" => "\x53\115\x53", "\x4f\x4f\123\x45" => "\x53\115\x53\40\101\x4e\104\x20\105\115\x41\111\114", "\x4b\x42\x41" => "\x4b\x42\x41"];
        if (!($ktI0S == "\117\117\x53")) {
            goto tpl4W;
        }
        $YODhH = $T2SYt;
        $xQHYL = '';
        $this->log_debug("\110\x65\x61\144\x6c\x65\x73\163\101\160\x69\56\x70\150\160\40\72\x20\141\x75\164\150\x20\x74\x79\160\x65\x20\x53\x4d\x53");
        tpl4W:
        if (!($ktI0S == "\x4f\117\x45")) {
            goto icu4i;
        }
        $YODhH = '';
        $xQHYL = $OQ92p;
        $this->log_debug("\110\145\141\x64\x6c\x65\x73\x73\x41\x70\x69\56\x70\150\x70\x20\x3a\x20\141\x75\x74\x68\x20\164\x79\160\145\x20\x45\x6d\x61\151\x6c");
        icu4i:
        if (!($ktI0S == "\117\x4f\123\105")) {
            goto joP34;
        }
        $YODhH = $T2SYt;
        $xQHYL = $OQ92p;
        $this->log_debug("\x48\x65\141\x64\x6c\145\163\163\101\x70\151\56\x70\150\x70\x20\x3a\141\165\x74\x68\40\x74\171\160\x65\40\x53\x4d\x53\x20\101\116\104\40\x45\115\101\111\x4c");
        joP34:
        $H1Dbe = ["\x63\x75\x73\x74\157\x6d\x65\162\x4b\145\x79" => $FEKCL, "\165\x73\145\162\x6e\x61\x6d\145" => '', "\x70\x68\x6f\156\145" => $T2SYt, "\x65\x6d\141\151\x6c" => $xQHYL, "\141\x75\164\x68\124\171\160\x65" => $raMDi[$ktI0S], "\164\162\x61\156\163\x61\143\164\x69\157\x6e\116\x61\x6d\x65" => $this->getTransactionName()];
        $rKEsd = $this->getApiUrls();
        $bH5GR = $rKEsd["\x63\x68\141\154\x6c\141\156\147\x65"];
        $UC8Rp = Curl::challenge($FEKCL, $kg91G, $bH5GR, $H1Dbe);
        $UC8Rp = json_decode($UC8Rp);
        $k5Lb_ = ["\163\164\x61\164\165\163" => $UC8Rp->status, "\x6d\145\x73\x73\x61\147\x65" => $UC8Rp->message, "\164\x78\111\x64" => $UC8Rp->txId];
        return $k5Lb_;
    }
    static function getTransactionName()
    {
        return "\x4d\141\147\x65\156\x74\157\x20\62\x46\101\40\x50\154\165\x67\151\x6e";
    }
    public function getMagnetoVersion()
    {
        return $this->productMetadata->getVersion();
    }
    public function getWebsiteByCodeOrName($lisk8)
    {
        if ($this->ifSandboxTrialEnabled()) {
            goto pN5Uu;
        }
        $hmvFj = $this->websiteRepository->getList();
        foreach ($hmvFj as $KA5CH) {
            if (!(strcasecmp($KA5CH->getCode(), $lisk8) === 0 || strcasecmp($KA5CH->getName(), $lisk8) === 0)) {
                goto fQ8NH;
            }
            return $KA5CH;
            fQ8NH:
            mvQ6o:
        }
        TdjRS:
        goto yhBUM;
        pN5Uu:
        $NpsOf = $this->storeManager->getStores();
        foreach ($NpsOf as $Y9xyO) {
            if (!(strcasecmp($Y9xyO->getCode(), $lisk8) === 0 || strcasecmp($Y9xyO->getName(), $lisk8) === 0)) {
                goto asqh5;
            }
            return $Y9xyO;
            asqh5:
            QpqfY:
        }
        Rvvew:
        yhBUM:
        return null;
    }
    public function ifSandboxTrialEnabled()
    {
        return $this->moduleManager->isEnabled("\115\151\x6e\151\x4f\162\141\156\x67\145\137\123\141\156\144\102\x6f\x78");
    }
    public function getWebsiteOrStoreBasedOnTrialStatus()
    {
        if ($this->ifSandboxTrialEnabled()) {
            goto VRSmy;
        }
        return $this->storeManager->getStore()->getWebsiteId();
        goto H6W1V;
        VRSmy:
        return $this->storeManager->getStore()->getId();
        H6W1V:
    }
    public function getAdminActiveMethodInline($SxFl_, $rOAXZ = null)
    {
        $D7gJA = $this->ifSandboxTrialEnabled();
        $rOAXZ = is_null($rOAXZ) ? $this->getCurrentAdminUser()->getUsername() : $rOAXZ;
        $PQChU = $D7gJA ? TwoFAConstants::ADMIN_ACTIVE_METHOD_INLINE . $SxFl_ . "\x5f" . $rOAXZ : TwoFAConstants::ADMIN_ACTIVE_METHOD_INLINE . $SxFl_;
        $ZDTo1 = !is_null($this->getStoreConfig($PQChU)) ? json_decode($this->getStoreConfig($PQChU)) : [];
        return $ZDTo1;
    }
    public function getUsernamefromEmail($SIs7j)
    {
        $PgUwS = $this->userCollectionFactory->create();
        $PgUwS->addFieldToFilter("\x65\155\141\151\x6c", $SIs7j);
        $RH1A6 = $PgUwS->getFirstItem();
        if (!($RH1A6 && $RH1A6->getId())) {
            goto rp2NV;
        }
        return $RH1A6->getUserName();
        rp2NV:
        return null;
    }
    public function isFirstPageVisit($aaEqu, $GMjhI)
    {
        try {
            $XrXZg = $this->ifSandboxTrialEnabled();
            $eThEx = $this->check_license_plan(4);
            $RtJ1w = "\x4d\x61\147\x65\156\x74\x6f\x20\x32\x20\106\141\x63\x74\x6f\x72\40\x41\165\164\x68\x65\x6e\x74\151\143\x61\x74\x69\x6f\x6e";
            $eqFp_ = $this->getBaseUrl();
            $YvqbN = $this->productMetadata->getEdition();
            $y4dqn = $this->get_magento_version();
            $CHYZg = null;
            if ($XrXZg) {
                goto Q7DAF;
            }
            if (!$eThEx) {
                goto DeE85;
            }
            $xrDEI = $this->getStoreConfig(TwoFAConstants::TIMESTAMP);
            if (isset($xrDEI)) {
                goto nyVxS;
            }
            $jZBU6 = new \DateTime();
            $J7_ep = $jZBU6->format("\x59\55\155\55\144\x20\x48\72\x69\x3a\x73");
            $xrDEI = $jZBU6->getTimestamp();
            $this->setStoreConfig(TwoFAConstants::TIMESTAMP, $xrDEI);
            $CHYZg = ["\x74\x69\155\x65\x53\164\x61\x6d\160" => $xrDEI, "\x61\144\x6d\x69\x6e\105\x6d\x61\151\154" => $aaEqu, "\x64\157\155\x61\x69\x6e" => $eqFp_, "\x70\x6c\165\x67\151\x6e\116\141\155\x65" => $RtJ1w, "\160\154\x75\x67\151\156\126\x65\x72\x73\x69\157\156" => TwoFAConstants::VERSION, "\160\154\165\x67\x69\156\x46\x69\x72\163\x74\x50\141\147\x65\x56\151\x73\x69\164" => $GMjhI, "\x65\156\x76\151\162\x6f\x6e\155\145\x6e\164\116\141\x6d\x65" => $YvqbN, "\x65\156\x76\151\162\157\156\x6d\145\x6e\164\126\x65\x72\163\151\157\156" => $y4dqn, "\x49\x73\124\162\x69\141\x6c\111\156\x73\x74\141\154\x6c\145\x64" => "\131\x65\x73", "\x54\x72\151\141\x6c\x49\x6e\163\164\141\154\154\145\x64\104\141\164\145" => $J7_ep];
            nyVxS:
            DeE85:
            goto Sj2_o;
            Q7DAF:
            $j8Dzx = $this->getSandBoxUserDataUsingEmail($aaEqu);
            if (empty($j8Dzx)) {
                goto rndnf;
            }
            $MgfpB = $j8Dzx[0];
            $xrDEI = $MgfpB["\164\151\x6d\x65\163\164\x61\155\160"];
            if (!($MgfpB["\141\154\x72\x65\x61\x64\x79\137\166\151\163\151\x74\145\144"] === "\x30")) {
                goto PAWL1;
            }
            $CHYZg = ["\164\151\x6d\x65\x53\164\141\x6d\160" => $xrDEI, "\141\x64\x6d\151\x6e\x45\155\141\x69\x6c" => $aaEqu, "\x64\x6f\155\141\151\156" => $eqFp_, "\155\x69\156\151\157\162\141\156\147\145\x41\x63\143\x6f\x75\x6e\x74\105\x6d\141\151\154" => '', "\160\x6c\x75\x67\x69\x6e\x4e\141\155\x65" => $RtJ1w, "\160\x6c\165\147\151\x6e\126\x65\x72\x73\151\x6f\156" => TwoFAConstants::VERSION, "\160\x6c\x75\147\151\156\106\151\162\163\x74\120\141\x67\x65\x56\151\163\151\164" => $GMjhI, "\145\156\x76\151\x72\157\x6e\155\145\x6e\x74\116\x61\155\145" => $YvqbN, "\x65\x6e\x76\x69\162\x6f\x6e\155\x65\x6e\164\x56\145\162\163\151\x6f\x6e" => $y4dqn];
            $TMEpy = $this->resource->getConnection();
            $Vqjx3 = $this->resource->getTableName("\155\151\x6e\x69\157\x72\141\156\147\145\137\163\141\156\144\x62\157\170\x5f\x74\x72\x69\x61\154\137\x75\x73\x65\x72\x73");
            $WtkYA = ["\x61\x6c\x72\145\141\x64\171\x5f\x76\151\x73\151\164\145\144" => "\x31"];
            $hKfkn = ["\x65\155\141\151\x6c\x20\75\x20\x3f" => $aaEqu, "\x70\x6c\141\x6e\x5f\156\141\x6d\145\x20\75\x20\x3f" => "\x4d\141\147\145\156\164\x6f\x20\62\x20\106\141\143\x74\x6f\x72\40\x41\x75\x74\x68\145\156\164\x69\143\141\164\x69\157\x6e"];
            $TMEpy->update($Vqjx3, $WtkYA, $hKfkn);
            PAWL1:
            rndnf:
            Sj2_o:
            if (is_null($CHYZg)) {
                goto eRM3B;
            }
            Curl::sendUserDetailsToPortal($CHYZg);
            eRM3B:
        } catch (Exception $Lq40h) {
            $this->log_debug("\x53\157\x6d\x65\x74\150\151\x6e\x67\40\167\x65\x6e\x74\40\167\162\x6f\156\x67\40\167\150\151\154\145\x20\x73\x65\156\x64\151\156\147\x20\x75\x73\x65\162\x20\144\x65\x74\x61\151\154\x73\x20\164\157\40\x6d\x69\x6e\x69\x6f\162\141\156\x67\x65\40\x74\162\x61\x63\x6b\x69\x6e\x67\x20\x70\157\162\x74\x61\x6c");
        }
        $this->flushCache();
    }
    public function getSandBoxUserDataUsingEmail($aaEqu)
    {
        $TMEpy = $this->resource->getConnection();
        $Vqjx3 = $this->resource->getTableName("\x6d\x69\156\151\x6f\162\x61\x6e\x67\x65\137\x73\x61\x6e\x64\x62\x6f\x78\137\164\162\x69\141\154\x5f\x75\x73\145\162\x73");
        $D9Xt_ = $TMEpy->select()->from($Vqjx3)->where("\x65\x6d\x61\151\154\40\x3d\40\x3f", $aaEqu)->where("\160\154\141\156\x5f\x6e\141\x6d\x65\x20\75\40\x3f", "\x4d\141\147\x65\x6e\164\x6f\40\x32\40\106\x61\143\164\x6f\162\40\101\x75\x74\x68\x65\156\x74\x69\x63\141\x74\151\x6f\x6e");
        $j8Dzx = $TMEpy->fetchAll($D9Xt_);
        return $j8Dzx;
    }
    public function isTrialActivated()
    {
        $kyE6o = $this->getStoreConfig(TwoFAConstants::TRIAL_ACTIVATED);
        return $kyE6o ? true : false;
    }
    public function isCommerceEdition()
    {
        return $this->companyCustomerFactory !== null && $this->companyUserRepository !== null;
    }
    public function saveCustomerAsB2CUser($ricT2, $CAytN)
    {
        if ($this->isCommerceEdition()) {
            goto EUksU;
        }
        return $ricT2;
        EUksU:
        try {
            $UYKrt = $this->companyCustomerFactory->create();
            $UYKrt->setCustomerId($CAytN);
            $UYKrt->setCompanyId(TwoFAConstants::NO_COMPANY_ID);
            $UYKrt->setIsCompanyAdmin(false);
            $UYKrt->setStatus(TwoFAConstants::COMPANY_ACTIVE);
            $bnGj0 = $ricT2->getExtensionAttributes();
            if (!($bnGj0 === null)) {
                goto SXDYB;
            }
            $bnGj0 = $this->customerExtensionFactory->create();
            SXDYB:
            $bnGj0->setCompanyAttributes($UYKrt);
            $ricT2->setExtensionAttributes($bnGj0);
            return $ricT2;
        } catch (\Exception $Lq40h) {
            $this->log_debug("\x45\x72\162\x6f\162\40\x69\x6e\40\163\141\166\x65\x43\165\163\164\x6f\x6d\145\162\x41\x73\102\62\x43\125\163\x65\162\x3a\40" . $Lq40h->getMessage());
            return $ricT2;
        }
    }
    public function isRegistration2FAEnabledForWebsite($UVStn = null)
    {
        if (!($UVStn === null)) {
            goto TSZPo;
        }
        $UVStn = $this->getWebsiteOrStoreBasedOnTrialStatus();
        TSZPo:
        $M8tvQ = $this->getStoreConfig("\164\x77\157\146\x61\57\162\x65\147\151\x73\x74\x72\x61\x74\x69\x6f\156\57\163\x65\154\145\143\164\145\144\137\x77\145\x62\163\151\x74\145");
        if ($M8tvQ) {
            goto MNotG;
        }
        return false;
        MNotG:
        if (!($M8tvQ === "\x61\154\154")) {
            goto bJMMQ;
        }
        return true;
        bJMMQ:
        if (!($M8tvQ == $UVStn)) {
            goto A5_wE;
        }
        return true;
        A5_wE:
        return false;
    }
    public function setGlobalConfig($VHbxc, $J9bAi)
    {
        $this->configWriter->save("\x6d\151\x6e\151\157\x72\x61\156\x67\145\57\124\167\x6f\106\101\57" . $VHbxc, $J9bAi);
    }
    public function getGlobalConfig($VHbxc)
    {
        return $this->scopeConfig->getValue("\x6d\x69\x6e\151\x6f\162\x61\x6e\147\145\57\x54\x77\157\106\101\x2f" . $VHbxc);
    }
    public function getWebsiteNameById($UVStn)
    {
        try {
            if (!$this->storeManager) {
                goto T6pyF;
            }
            $KA5CH = $this->storeManager->getWebsite($UVStn);
            return $KA5CH ? $KA5CH->getName() : null;
            T6pyF:
            return null;
        } catch (\Exception $Lq40h) {
            $this->log_debug("\x45\162\x72\x6f\162\x20\147\145\164\164\x69\156\147\40\x77\x65\x62\x73\x69\164\145\x20\156\141\x6d\145\x20\142\171\40\111\x44\72\40" . $Lq40h->getMessage());
            return null;
        }
    }
    public function translateOtpMessage($MoR7N)
    {
        $this->log_debug("\164\162\141\x6e\163\154\x61\164\x65\x4f\x74\x70\115\145\163\x73\141\x67\x65\72\40\x6d\x65\163\x73\141\147\145\72\40" . $MoR7N);
        if (preg_match("\57\124\x68\145\x20\117\124\x50\x20\x68\x61\x73\40\x62\x65\145\156\40\163\x65\156\x74\40\164\157\x20\50\134\x53\x2b\51\x5c\56\x20\x50\x6c\145\141\163\x65\x20\x65\x6e\164\145\162\40\x74\150\145\40\117\124\120\40\171\x6f\165\40\162\x65\x63\x65\151\166\x65\144\40\164\x6f\x20\x76\x61\x6c\x69\x64\141\164\x65\x5c\56\57\x69", $MoR7N, $MxLr1)) {
            goto rNDji;
        }
        if (preg_match("\57\x49\x6e\166\141\154\x69\x64\x20\117\124\x50\x20\160\x72\x6f\x76\x69\x64\145\144\134\56\x20\120\x6c\x65\141\163\145\40\164\x72\x79\x20\141\x67\x61\x69\156\134\x2e\57\151", $MoR7N, $MxLr1)) {
            goto rsMwb;
        }
        if (preg_match("\x2f\x53\x75\x63\143\x65\163\163\146\x75\x6c\x6c\x79\x20\x76\141\x6c\x69\144\x61\x74\145\x64\x2f", $MoR7N, $MxLr1)) {
            goto wlU_r;
        }
        if (preg_match("\x2f\x54\x68\x65\40\x70\x68\157\156\145\40\x6e\165\155\142\145\162\40\171\157\165\40\x68\141\166\x65\40\145\x6e\x74\145\162\x65\144\40\150\141\x73\x20\142\145\x65\x6e\x20\x66\154\141\147\x67\145\144\40\x61\156\x64\40\x69\163\40\143\165\x72\x72\145\156\164\154\x79\x20\x62\154\x61\x63\x6b\x6c\x69\163\164\145\x64\56\x20\x50\154\145\141\x73\145\x20\165\x73\145\40\x61\40\144\x69\x66\x66\145\162\x65\156\164\x20\156\165\155\x62\145\x72\x20\164\157\x20\x70\162\157\x63\145\x65\144\x2e\57\151", $MoR7N, $MxLr1)) {
            goto pye04;
        }
        if (!preg_match("\57\111\x6e\x76\141\154\151\144\40\x70\150\157\156\x65\x20\x6e\165\x6d\142\x65\x72\x5c\x2e\x20\x50\x6c\145\x61\163\145\40\x70\x72\x6f\166\151\144\145\40\141\x20\166\x61\x6c\x69\144\x20\x70\x68\157\156\145\x20\x6e\165\x6d\142\x65\x72\x20\167\x69\x74\x68\40\143\x6f\165\156\x74\162\171\x20\143\157\144\145\x5c\56\57\151", $MoR7N, $MxLr1)) {
            goto VBRd3;
        }
        return "\x4e\x75\x6d\xc3\xa9\162\157\40\x64\x65\x20\x74\xc3\251\154\303\251\160\x68\157\x6e\x65\x20\151\x6e\166\141\x6c\151\144\x65\56\x20\126\x65\x75\x69\x6c\154\x65\x7a\x20\146\157\x75\x72\x6e\151\x72\x20\165\x6e\x20\156\x75\x6d\303\251\x72\x6f\40\x64\145\40\164\303\xa9\x6c\303\xa9\x70\x68\157\156\145\40\166\x61\154\151\144\x65\x20\141\166\145\x63\40\154\145\x20\x63\157\x64\x65\40\160\141\x79\x73\56";
        VBRd3:
        goto k_Ykb;
        pye04:
        return "\x4c\x65\x20\x6e\x75\155\303\xa9\x72\157\40\144\x65\40\x74\303\251\154\303\251\160\x68\157\156\145\40\x71\x75\x65\40\x76\x6f\165\x73\40\141\x76\x65\172\40\x65\156\x74\x72\xc3\251\40\141\40\xc3\xa9\x74\xc3\251\x20\x73\151\x67\156\141\x6c\xc3\xa9\x20\145\x74\x20\145\x73\x74\x20\x61\x63\x74\165\x65\154\154\x65\155\x65\x6e\164\x20\142\154\157\x71\x75\303\xa9\x2e\x20\126\145\165\151\154\x6c\x65\172\x20\x75\x74\151\x6c\x69\163\145\162\x20\x75\156\40\141\165\164\x72\x65\40\156\x75\x6d\xc3\xa9\162\157\x20\x70\x6f\x75\162\40\x63\x6f\x6e\x74\x69\x6e\165\x65\162\x2e";
        k_Ykb:
        goto zD0px;
        wlU_r:
        return "\117\x54\x50\x20\x76\x61\x6c\x69\x64\xc3\251\x20\x61\166\x65\143\x20\163\165\143\143\xc3\250\163\56";
        zD0px:
        goto Y2LnM;
        rsMwb:
        return "\103\157\144\145\x20\x4f\x54\120\40\151\x6e\x76\141\154\151\x64\x65\x2e\40\x56\145\x75\x69\x6c\154\x65\x7a\40\x72\303\251\145\163\x73\x61\171\x65\162\56";
        Y2LnM:
        goto h_opE;
        rNDji:
        $JF1XC = $MxLr1[1];
        if (strpos($JF1XC, "\100") !== false) {
            goto wZQ3E;
        }
        return "\x43\x6f\144\x65\40\145\156\x76\x6f\x79\xc3\251\40\141\x75\x20\156\x75\155\xc3\251\162\x6f\x20\x73\x65\x20\x74\x65\x72\x6d\151\x6e\x61\156\164\x20\x70\141\162\x20" . $JF1XC . "\56\40\123\x61\x69\163\151\163\x73\145\x7a\40\154\x65\40\143\x6f\144\x65\40\160\x6f\165\162\x20\143\x6f\x6e\146\151\x72\x6d\x65\x72\40\166\157\164\162\x65\x20\151\x64\145\156\x74\x69\x74\303\xa9\x2e";
        goto fgPqD;
        wZQ3E:
        return "\103\157\144\x65\40\145\x6e\x76\x6f\171\303\xa9\x20\xc3\240\x20\154\47\x61\x64\x72\145\x73\x73\x65\x20\163\145\x20\x74\145\x72\x6d\x69\x6e\141\x6e\164\40\x70\141\162\40" . $JF1XC . "\x2e\40\x53\141\151\x73\x69\163\x73\145\x7a\x20\x6c\x65\40\143\x6f\144\145\40\x70\157\x75\162\40\143\x6f\x6e\146\151\162\155\145\x72\x20\166\x6f\x74\162\x65\40\x69\x64\145\x6e\x74\x69\x74\303\xa9\x2e";
        fgPqD:
        h_opE:
        return $MoR7N;
    }
    public function checkBlacklistedPhone($T2SYt, $jeGDv)
    {
        $ON9S5 = $this->getStoreConfig(TwoFAConstants::CUSTOMER_ENABLE_BLOCK_SPAM_PHONE_NUMBER);
        if (!$ON9S5) {
            goto oksKM;
        }
        $TarLI = $this->getStoreConfig(TwoFAConstants::CUSTOMER_BLOCK_SPAM_PHONE_NUMBER);
        $JdNc7 = array_filter(array_map("\164\x72\x69\x6d", explode("\x3b", $TarLI)));
        $itES3 = $jeGDv . $T2SYt;
        $hB19v = "\x2b" . $jeGDv . $T2SYt;
        if (!(in_array($itES3, $JdNc7) || in_array($hB19v, $JdNc7))) {
            goto VSun2;
        }
        return true;
        VSun2:
        if (!in_array($T2SYt, $JdNc7)) {
            goto CUyxD;
        }
        return true;
        CUyxD:
        oksKM:
        return false;
    }
}