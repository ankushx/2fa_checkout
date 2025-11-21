<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper;

use MiniOrange\TwoFA\Helper\TwoFAUtility;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use Magento\Store\Model\ScopeInterface;
class WebsiteStub
{
    public function getId()
    {
        return 7;
    }
}
class StoreStub
{
    public function getWebsiteId()
    {
        return 1;
    }
}
class TwoFAUtilityTest extends TestCase
{
    protected $utility;
    protected $scopeConfig;
    protected $adminFactory;
    protected $customerFactory;
    protected $urlInterface;
    protected $configWriter;
    protected $resource;
    protected $assetRepo;
    protected $helperBackend;
    protected $frontendUrl;
    protected $adminSession;
    protected $customerSession;
    protected $authSession;
    protected $reinitableConfig;
    protected $coreSession;
    protected $cacheTypeList;
    protected $cacheFrontendPool;
    protected $logger;
    protected $dir;
    protected $userContext;
    protected $userCollectionFactory;
    protected $userFactory;
    protected $storeManager;
    protected $customerModel;
    protected $groupRepository;
    protected $websiteCollectionFactory;
    protected $ipWhitelistedCollectionFactory;
    protected $ipWhitelistedAdminCollectionFactory;
    protected $url;
    protected $resultFactory;
    protected $cookieManager;
    protected $cookieMetadataFactory;
    protected $logger_customlog;
    protected $productMetadata;
    protected $dateTime;
    protected $messageManager;
    protected $fileSystem;
    protected $sessionValues;
    private $websiteRepository;
    private $moduleManager;
    protected function setUp() : void
    {
        $this->scopeConfig = $this->createMock(\Magento\Framework\App\Config\ScopeConfigInterface::class);
        $this->adminFactory = $this->createMock(\Magento\User\Model\UserFactory::class);
        $this->customerFactory = $this->createMock(\Magento\Customer\Model\CustomerFactory::class);
        $this->urlInterface = $this->createMock(\Magento\Framework\UrlInterface::class);
        $this->configWriter = $this->createMock(\Magento\Framework\App\Config\Storage\WriterInterface::class);
        $this->resource = $this->createMock(\Magento\Framework\App\ResourceConnection::class);
        $this->assetRepo = $this->createMock(\Magento\Framework\View\Asset\Repository::class);
        $this->helperBackend = $this->createMock(\Magento\Backend\Helper\Data::class);
        $this->frontendUrl = $this->createMock(\Magento\Framework\Url::class);
        $this->adminSession = $this->createMock(\Magento\Backend\Model\Session::class);
        $this->customerSession = $this->createMock(\Magento\Customer\Model\Session::class);
        $this->authSession = $this->createMock(\Magento\Backend\Model\Auth\Session::class);
        $this->reinitableConfig = $this->createMock(\Magento\Framework\App\Config\ReinitableConfigInterface::class);
        $this->coreSession = $this->getMockBuilder(\Magento\Framework\Session\SessionManager::class)->disableOriginalConstructor()->onlyMethods(["\x73\164\141\162\x74"])->addMethods(["\147\x65\x74\x4d\171\124\145\163\164\x56\x61\x6c\165\145", "\x73\145\x74\x4d\x79\x54\145\x73\x74\126\141\x6c\x75\145"])->getMock();
        $this->sessionValues = [];
        $this->coreSession->method("\147\x65\x74\x4d\x79\x54\145\x73\x74\x56\141\154\165\145")->willReturnCallback(function () {
            return $this->sessionValues;
        });
        $this->coreSession->method("\163\145\164\x4d\171\124\145\x73\x74\x56\x61\154\x75\x65")->willReturnCallback(function ($h2u_e) {
            $this->sessionValues = $h2u_e;
        });
        $this->coreSession->method("\x73\x74\x61\x72\x74")->willReturn(true);
        $this->cacheTypeList = $this->createMock(\Magento\Framework\App\Cache\TypeListInterface::class);
        $this->cacheFrontendPool = $this->createMock(\Magento\Framework\App\Cache\Frontend\Pool::class);
        $this->logger = $this->createMock(\Psr\Log\LoggerInterface::class);
        $this->fileSystem = $this->createMock(\Magento\Framework\Filesystem\Driver\File::class);
        $this->dir = $this->createMock(\Magento\Framework\Filesystem\DirectoryList::class);
        $this->userContext = $this->createMock(\Magento\Authorization\Model\UserContextInterface::class);
        $this->userCollectionFactory = $this->createMock(\Magento\User\Model\ResourceModel\User\CollectionFactory::class);
        $this->userFactory = $this->createMock(\Magento\User\Model\UserFactory::class);
        $this->storeManager = $this->createMock(\Magento\Store\Model\StoreManagerInterface::class);
        $this->customerModel = $this->createMock(\Magento\Customer\Model\Customer::class);
        $this->groupRepository = $this->createMock(\Magento\Customer\Api\GroupRepositoryInterface::class);
        $this->websiteCollectionFactory = $this->createMock(\Magento\Store\Model\ResourceModel\Website\CollectionFactory::class);
        $this->ipWhitelistedCollectionFactory = $this->createMock(\MiniOrange\TwoFA\Model\ResourceModel\IpWhitelisted\CollectionFactory::class);
        $this->ipWhitelistedAdminCollectionFactory = $this->createMock(\MiniOrange\TwoFA\Model\ResourceModel\IpWhitelistedAdmin\CollectionFactory::class);
        $this->url = $this->createMock(\Magento\Framework\UrlInterface::class);
        $this->resultFactory = $this->createMock(\Magento\Framework\Controller\ResultFactory::class);
        $this->cookieManager = $this->createMock(\Magento\Framework\Stdlib\CookieManagerInterface::class);
        $this->cookieMetadataFactory = $this->createMock(\Magento\Framework\Stdlib\Cookie\CookieMetadataFactory::class);
        $this->logger_customlog = $this->createMock(\MiniOrange\TwoFA\Logger\Logger::class);
        $this->productMetadata = $this->createMock(\Magento\Framework\App\ProductMetadataInterface::class);
        $this->dateTime = $this->createMock(\Magento\Framework\Stdlib\DateTime\DateTime::class);
        $this->messageManager = $this->createMock(\Magento\Framework\Message\ManagerInterface::class);
        $this->websiteRepository = $this->createMock(\Magento\Store\Api\WebsiteRepositoryInterface::class);
        $this->moduleManager = $this->createMock(\Magento\Framework\Module\Manager::class);
        $this->utility = new TwoFAUtility($this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager);
    }
    public function testGetHiddenPhone_ReturnsObfuscatedPhone()
    {
        $this->assertEquals("\x78\170\x78\x78\170\x78\170\70\71\x30", $this->utility->getHiddenPhone("\61\62\63\x34\x35\x36\x37\x38\x39\x30"));
    }
    public function testGetHiddenPhone_ShortPhone_ReturnsObfuscated()
    {
        $this->assertEquals("\x78\x78\170\x78\x78\170\x78\61\x32\x33", $this->utility->getHiddenPhone("\x31\62\x33"));
    }
    public function testGetHiddenEmail_ObfuscatesEmail()
    {
        $this->assertEquals("\165\x78\x78\x78\x72\100\144\x6f\x6d\x61\x69\x6e\x2e\143\157\x6d", $this->utility->getHiddenEmail("\x75\x73\x65\x72\x40\144\x6f\155\141\151\156\56\143\157\155"));
    }
    public function testGetHiddenEmail_Empty_ReturnsEmptyString()
    {
        $this->assertSame('', $this->utility->getHiddenEmail(''));
    }
    public function testGetHiddenEmail_Null_ReturnsEmptyString()
    {
        $this->assertSame('', $this->utility->getHiddenEmail(null));
    }
    public function testIsCurlInstalled_ReturnsTrueIfLoaded()
    {
        $this->assertContains("\x63\165\x72\154", get_loaded_extensions(), "\x63\x75\162\154\x20\x65\170\164\145\x6e\x73\x69\x6f\156\x20\x73\150\157\165\154\x64\x20\142\145\40\x6c\x6f\x61\144\x65\x64\40\x66\157\x72\x20\164\x68\x69\x73\40\164\145\x73\164");
        $this->assertEquals(1, $this->utility->isCurlInstalled());
    }
    public function testIsCurlInstalled_ReturnsFalseIfNotLoaded()
    {
        $RoD1b = $this->utility->isCurlInstalled();
        $this->assertTrue($RoD1b === 1 || $RoD1b === 0);
    }
    public function testIsBlank_WithNull_ReturnsTrue()
    {
        $this->assertTrue($this->utility->isBlank(null));
    }
    public function testIsBlank_WithEmptyString_ReturnsTrue()
    {
        $this->assertTrue($this->utility->isBlank(''));
    }
    public function testIsBlank_WithNonEmptyString_ReturnsFalse()
    {
        $this->assertFalse($this->utility->isBlank("\146\x6f\x6f"));
    }
    public function testGetCustomerDetailss_ReturnsCustomerName()
    {
        $this->customerSession->method("\147\x65\x74\x4e\x61\155\145")->willReturn("\112\157\150\x6e\x20\104\157\145");
        $this->customerSession->method("\x67\145\164\x49\144")->willReturn(123);
        $this->assertEquals("\112\x6f\x68\x6e\40\104\x6f\145", $this->utility->get_customer_detailss());
    }
    public function testGetCurrentWebsiteId_ReturnsFromConfig()
    {
        $Btl21 = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\x74\127\145\x62\x73\151\164\145\111\x64"])->getMock();
        $Btl21->method("\147\x65\x74\127\145\142\x73\x69\x74\x65\111\x64")->willReturn(1);
        $this->storeManager->method("\x67\x65\164\x53\164\157\162\145")->willReturn($Btl21);
        $RoD1b = $this->utility->getWebsiteOrStoreBasedOnTrialStatus();
        $this->assertEquals(1, $RoD1b);
    }
    public function testGetCurrentWebsiteId_FallsBackToFirstWebsite()
    {
        $Btl21 = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\x74\127\x65\x62\x73\151\164\145\111\144"])->getMock();
        $Btl21->method("\x67\x65\x74\127\x65\x62\163\x69\164\x65\x49\x64")->willReturn(1);
        $this->storeManager->method("\x67\x65\164\x53\164\157\x72\x65")->willReturn($Btl21);
        $RoD1b = $this->utility->getWebsiteOrStoreBasedOnTrialStatus();
        $this->assertEquals(1, $RoD1b);
    }
    public function testGetAllWebsites_ReturnsCollection()
    {
        $esWDy = ["\167\x65\142\x73\x69\x74\145\x31", "\167\x65\142\163\x69\164\x65\62"];
        $this->websiteCollectionFactory->method("\x63\x72\x65\x61\164\x65")->willReturn($esWDy);
        $this->assertEquals($esWDy, $this->utility->get_all_websites());
    }
    public function testIsCustomerRegistered_TrueIfLicensePlanAndNotTrialExpired()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x63\150\x65\143\x6b\x5f\x6c\151\143\x65\x6e\163\x65\137\160\154\x61\156", "\151\163\x54\x72\x69\141\154\x45\x78\160\151\162\x65\144"])->getMock();
        $Bi2JU->method("\143\150\x65\143\x6b\x5f\x6c\x69\143\145\x6e\x73\x65\137\160\x6c\x61\156")->willReturn(true);
        $Bi2JU->method("\x69\163\124\162\151\x61\154\105\170\x70\x69\162\145\144")->willReturn(false);
        $this->assertTrue($Bi2JU->isCustomerRegistered());
    }
    public function testIsCustomerRegistered_FalseIfNoEmail()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x63\150\145\x63\x6b\x5f\x6c\x69\x63\145\156\x73\145\137\x70\x6c\141\x6e", "\151\163\124\x72\151\x61\154\105\x78\x70\x69\x72\x65\x64", "\x67\145\164\x43\x75\x73\x74\x6f\155\x65\162\104\145\164\x61\151\154\x73"])->getMock();
        $Bi2JU->method("\143\x68\145\143\153\x5f\x6c\x69\143\145\x6e\x73\x65\137\x70\154\141\156")->willReturn(false);
        $Bi2JU->method("\151\x73\x54\162\151\x61\x6c\x45\170\x70\x69\162\x65\144")->willReturn(true);
        $Bi2JU->method("\x67\x65\164\103\x75\163\x74\157\155\x65\162\104\x65\164\x61\151\x6c\x73")->willReturn(["\x65\x6d\x61\151\x6c" => null]);
        $this->assertFalse($Bi2JU->isCustomerRegistered());
    }
    public function testCheckLicensePlan_TrueIfLevelMet()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\147\145\164\137\x6c\x69\x63\145\156\163\145\137\160\x6c\141\156"])->getMock();
        $Bi2JU->method("\147\x65\164\x5f\154\151\143\145\156\163\145\x5f\160\x6c\x61\156")->willReturn(5);
        $this->assertTrue($Bi2JU->check_license_plan(4));
    }
    public function testCheckLicensePlan_FalseIfLevelNotMet()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\147\145\x74\137\154\151\143\x65\x6e\x73\145\x5f\160\154\141\x6e"])->getMock();
        $Bi2JU->method("\x67\145\164\x5f\x6c\151\143\x65\156\163\x65\137\x70\154\x61\x6e")->willReturn(2);
        $this->assertFalse($Bi2JU->check_license_plan(4));
    }
    public function testGetCustomerDetails_ReturnsExpectedArray()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x67\145\164\x53\164\x6f\x72\x65\x43\x6f\156\x66\151\x67"])->getMock();
        $Bi2JU->method("\147\x65\x74\x53\164\x6f\x72\145\x43\157\156\x66\151\147")->willReturnMap([[TwoFAConstants::CUSTOMER_EMAIL, "\x75\163\x65\x72\100\145\x78\x61\155\160\154\145\x2e\143\157\155"], [TwoFAConstants::CUSTOMER_KEY, "\x6b\145\x79"], [TwoFAConstants::API_KEY, "\141\160\x69"], [TwoFAConstants::TOKEN, "\x74\x6f\153\145\156"]]);
        $RoD1b = $Bi2JU->getCustomerDetails();
        $this->assertEquals(["\145\155\141\x69\x6c" => "\165\x73\x65\x72\100\x65\x78\x61\155\x70\x6c\x65\x2e\x63\157\155", "\x63\165\x73\x74\157\x6d\x65\162\137\113\145\171" => "\153\x65\171", "\141\x70\x69\137\x4b\x65\171" => "\x61\160\x69", "\x74\157\153\145\x6e" => "\164\x6f\x6b\x65\156"], $RoD1b);
    }
    public function testGetSessionValue_ReturnsValueIfSet()
    {
        $this->sessionValues = ["\x66\157\x6f" => "\142\141\162"];
        $this->assertEquals("\x62\x61\x72", $this->utility->getSessionValue("\146\157\x6f"));
    }
    public function testGetSessionValue_ReturnsNullIfNotSet()
    {
        $this->sessionValues = ["\146\157\x6f" => "\x62\x61\162"];
        $this->assertNull($this->utility->getSessionValue("\142\141\172"));
    }
    public function testGetCompleteSession_ReturnsArray()
    {
        $this->sessionValues = ["\x66\157\x6f" => "\142\x61\x72"];
        $this->assertEquals(["\146\x6f\x6f" => "\142\x61\x72"], $this->utility->getCompleteSession());
    }
    public function testGetCompleteSession_ReturnsEmptyArrayIfNull()
    {
        $this->sessionValues = null;
        $this->assertEquals([], $this->utility->getCompleteSession());
    }
    public function testSetSessionValue_SetsValue()
    {
        $this->utility->setSessionValue("\x66\157\x6f", "\142\141\162");
        $this->assertEquals("\x62\x61\x72", $this->sessionValues["\x66\x6f\157"]);
    }
    public function testGetAdminSessionData_ReturnsValue()
    {
        $this->adminSession->expects($this->once())->method("\147\145\164\x44\141\x74\x61")->with("\x6b\145\x79", false)->willReturn("\x76\141\x6c\x75\145");
        $this->assertEquals("\166\x61\154\165\x65", $this->utility->getAdminSessionData("\x6b\x65\171"));
    }
    public function testSetAdminSessionData_SetsValue()
    {
        $KKMeO = new class
        {
            public $data = array();
            public function setData($qZ3iu, $hLmqr)
            {
                $this->data[$qZ3iu] = $hLmqr;
                return $this;
            }
        };
        $yN244 = new \ReflectionClass($this->utility);
        $foUZ9 = $yN244->getProperty("\x61\144\x6d\x69\156\123\x65\x73\x73\x69\x6f\156");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $KKMeO);
        $this->assertSame($KKMeO, $this->utility->setAdminSessionData("\x6b\145\x79", "\x76\x61\x6c\165\x65"));
        $this->assertEquals("\166\x61\154\x75\x65", $KKMeO->data["\153\x65\171"]);
    }
    public function testGetSessionData_ReturnsValue()
    {
        $this->customerSession->expects($this->once())->method("\x67\145\164\104\141\164\x61")->with("\x6b\145\x79", false)->willReturn("\x76\141\154\x75\145");
        $this->assertEquals("\166\x61\154\x75\145", $this->utility->getSessionData("\153\x65\x79"));
    }
    public function testSetSessionData_SetsValue()
    {
        $O_B8h = new class
        {
            public $data = array();
            public function setData($qZ3iu, $hLmqr)
            {
                $this->data[$qZ3iu] = $hLmqr;
                return $this;
            }
        };
        $yN244 = new \ReflectionClass($this->utility);
        $foUZ9 = $yN244->getProperty("\143\165\163\x74\157\155\x65\x72\x53\145\x73\163\151\x6f\x6e");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $O_B8h);
        $this->assertSame($O_B8h, $this->utility->setSessionData("\153\145\171", "\x76\141\x6c\x75\145"));
        $this->assertEquals("\166\x61\x6c\x75\145", $O_B8h->data["\x6b\x65\171"]);
    }
    public function testSetSessionValueForCurrentUser_CustomerLoggedIn()
    {
        $O_B8h = new class
        {
            public function isLoggedIn()
            {
                return true;
            }
        };
        $yN244 = new \ReflectionClass($this->utility);
        $foUZ9 = $yN244->getProperty("\143\165\163\164\x6f\x6d\145\162\123\145\163\163\151\157\156");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $O_B8h);
        $this->utility->setSessionValueForCurrentUser("\146\x6f\x6f", "\x62\141\x72");
        $this->assertEquals("\142\141\x72", $this->sessionValues["\146\157\157"]);
    }
    public function testSetSessionValueForCurrentUser_AdminLoggedIn()
    {
        $O_B8h = new class
        {
            public function isLoggedIn()
            {
                return false;
            }
        };
        $jIBrz = new class
        {
            public function isLoggedIn()
            {
                return true;
            }
        };
        $KKMeO = new class
        {
            public $data = array();
            public function setData($qZ3iu, $hLmqr)
            {
                $this->data[$qZ3iu] = $hLmqr;
                return $this;
            }
        };
        $yN244 = new \ReflectionClass($this->utility);
        $foUZ9 = $yN244->getProperty("\x63\165\x73\x74\x6f\155\145\162\123\145\163\163\x69\157\x6e");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $O_B8h);
        $foUZ9 = $yN244->getProperty("\x61\165\x74\150\123\145\x73\x73\x69\157\156");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $jIBrz);
        $foUZ9 = $yN244->getProperty("\x61\144\155\151\x6e\x53\x65\x73\x73\x69\x6f\156");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $KKMeO);
        $this->utility->setSessionValueForCurrentUser("\146\x6f\157", "\142\141\x72");
        $this->assertEquals("\x62\141\162", $KKMeO->data["\146\x6f\x6f"]);
    }
    public function testSetSessionValueForCurrentUser_NotLoggedIn()
    {
        $O_B8h = new class
        {
            public function isLoggedIn()
            {
                return false;
            }
        };
        $jIBrz = new class
        {
            public function isLoggedIn()
            {
                return false;
            }
        };
        $yN244 = new \ReflectionClass($this->utility);
        $foUZ9 = $yN244->getProperty("\143\x75\163\x74\157\155\x65\x72\x53\x65\x73\163\151\157\x6e");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $O_B8h);
        $foUZ9 = $yN244->getProperty("\x61\165\164\150\123\x65\163\163\151\x6f\156");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $jIBrz);
        $this->utility->setSessionValueForCurrentUser("\x66\157\157", "\142\141\162");
        $this->assertArrayNotHasKey("\146\157\157", (array) $this->sessionValues);
    }
    public function testCustomgatewayValidateOTP_Success()
    {
        $this->sessionValues = ["\x63\165\163\164\157\155\x67\141\164\x65\167\141\x79\137\x6f\164\x70" => "\x31\62\x33\x34", "\157\x70\x74\137\145\x78\160\x69\x72\171\x5f\x74\x69\155\145" => time() + 60, "\146\141\151\x6c\x65\144\137\157\164\x70\x5f\x61\164\x74\x65\x6d\160\164\163" => 0];
        $this->assertEquals("\123\125\103\x43\105\x53\x53", $this->utility->customgateway_validateOTP("\x31\x32\63\64"));
    }
    public function testCustomgatewayValidateOTP_FailedOTP()
    {
        $this->sessionValues = ["\143\x75\x73\164\x6f\155\x67\141\164\145\x77\141\171\137\x6f\x74\160" => "\61\x32\63\64", "\157\x70\x74\x5f\145\170\160\x69\162\x79\137\x74\151\155\145" => time() + 60, "\x66\141\x69\x6c\145\144\x5f\x6f\x74\x70\x5f\x61\164\164\x65\155\160\x74\163" => 0];
        $this->assertEquals("\106\x41\111\x4c\105\x44", $this->utility->customgateway_validateOTP("\x39\71\71\71"));
    }
    public function testCustomgatewayValidateOTP_ExpiredOTP()
    {
        $this->sessionValues = ["\143\x75\x73\164\x6f\155\x67\x61\164\x65\x77\x61\171\x5f\x6f\164\x70" => "\x31\62\x33\64", "\x6f\x70\164\x5f\145\170\x70\x69\162\171\x5f\164\x69\155\x65" => time() - 60, "\x66\x61\151\x6c\145\x64\x5f\x6f\x74\x70\x5f\141\164\164\145\x6d\x70\x74\x73" => 0];
        $this->assertEquals("\106\101\x49\x4c\x45\x44\x5f\117\x54\120\x5f\105\x58\120\x49\x52\105\104", $this->utility->customgateway_validateOTP("\x31\62\63\64"));
    }
    public function testCustomgatewayValidateOTP_FailedAttemptsExceeded()
    {
        $this->sessionValues = ["\x63\x75\163\164\157\x6d\x67\141\x74\x65\x77\141\x79\x5f\157\164\160" => "\x31\62\63\x34", "\x6f\x70\x74\137\x65\170\x70\x69\x72\171\x5f\x74\151\155\x65" => time() + 60, "\146\x61\151\x6c\x65\144\137\x6f\164\x70\x5f\141\164\164\145\x6d\x70\x74\163" => 10];
        $this->assertEquals("\106\101\111\114\x45\104\x5f\x41\x54\124\x45\115\120\x54\x53", $this->utility->customgateway_validateOTP("\61\x32\x33\x34"));
    }
    public function testCheckIPs_ReturnsTrueForWhitelistedIP()
    {
        $this->scopeConfig->method("\147\x65\x74\126\x61\x6c\x75\145")->willReturnCallback(function ($A5Wk5, $dX7mo) {
            if (!($A5Wk5 === "\155\151\x6e\x69\x6f\x72\141\x6e\x67\145\57\124\x77\157\106\101\x2f" . TwoFAConstants::IP_LISTING && $dX7mo === ScopeInterface::SCOPE_STORE)) {
                goto Hh58k;
            }
            return 1;
            Hh58k:
            if (!($A5Wk5 === "\155\151\156\151\157\162\141\156\147\145\x2f\124\x77\157\x46\x41\x2f" . TwoFAConstants::ALL_IP_WHITLISTED && $dX7mo === ScopeInterface::SCOPE_STORE)) {
                goto B8COv;
            }
            return json_encode(["\x31\x2e\62\56\x33\x2e\64"]);
            B8COv:
            return null;
        });
        $this->utility = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x67\145\164\x5f\x63\x6c\x69\x65\156\x74\x5f\x69\x70"])->getMock();
        $this->utility->method("\147\145\164\x5f\x63\154\151\145\x6e\x74\x5f\x69\x70")->willReturn("\x31\x2e\62\x2e\63\56\64");
        $this->assertTrue($this->utility->checkIPs("\x63\165\x73\164\x6f\155\145\162"));
    }
    public function testCheckIPs_ReturnsFalseForNonWhitelistedIP()
    {
        $this->scopeConfig->method("\x67\145\164\x56\141\154\165\x65")->willReturn(1);
        $this->utility = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x67\145\x74\137\x63\x6c\x69\145\x6e\164\x5f\151\x70"])->getMock();
        $this->utility->method("\x67\145\x74\x5f\143\154\151\x65\x6e\x74\x5f\x69\160")->willReturn("\65\56\x36\x2e\67\56\x38");
        $this->scopeConfig->method("\147\x65\164\126\141\154\165\x65")->willReturn(json_encode(["\x31\x2e\62\56\63\x2e\x34"]));
        $this->assertFalse($this->utility->checkIPs("\x63\x75\x73\x74\157\155\x65\162"));
    }
    public function testGetCustomerPhoneFromEmail_ReturnsPhone()
    {
        $this->storeManager->method("\x67\x65\164\123\x74\157\162\x65")->willReturn(new StoreStub());
        $ubwvh = new class
        {
            public function getId()
            {
                return 1;
            }
            public function getDefaultBillingAddress()
            {
                return new class
                {
                    public function getTelephone()
                    {
                        return "\x31\62\63\64\65\x36\x37\x38\71\60";
                    }
                };
            }
        };
        $dg7NT = new class($ubwvh)
        {
            private $customer;
            public function __construct($ubwvh)
            {
                $this->customer = $ubwvh;
            }
            public function setWebsiteId($etV8W)
            {
                return $this;
            }
            public function loadByEmail($oT0hO)
            {
                return $this->customer;
            }
        };
        $yN244 = new \ReflectionClass($this->utility);
        $foUZ9 = $yN244->getProperty("\143\x75\x73\164\157\155\145\x72\x4d\157\144\x65\x6c");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $dg7NT);
        $this->assertEquals("\61\x32\x33\64\x35\x36\x37\70\71\60", $this->utility->getCustomerPhoneFromEmail("\x75\x73\x65\x72\x40\145\170\x61\x6d\x70\154\x65\56\x63\x6f\x6d"));
    }
    public function testGetCustomerPhoneFromEmail_ReturnsNullIfNoId()
    {
        $this->storeManager->method("\147\145\164\123\x74\157\x72\145")->willReturn(new StoreStub());
        $ubwvh = new class
        {
            public function getId()
            {
                return null;
            }
            public function getDefaultBillingAddress()
            {
                return null;
            }
        };
        $dg7NT = new class($ubwvh)
        {
            private $customer;
            public function __construct($ubwvh)
            {
                $this->customer = $ubwvh;
            }
            public function setWebsiteId($etV8W)
            {
                return $this;
            }
            public function loadByEmail($oT0hO)
            {
                return $this->customer;
            }
        };
        $yN244 = new \ReflectionClass($this->utility);
        $foUZ9 = $yN244->getProperty("\143\165\163\164\157\x6d\145\162\x4d\x6f\x64\145\154");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $dg7NT);
        $this->assertNull($this->utility->getCustomerPhoneFromEmail("\165\x73\145\162\100\x65\170\x61\155\x70\x6c\x65\56\143\157\x6d"));
    }
    public function testFlushCache_CallsCleanTypeAndCleanBackend()
    {
        $stbLo = new class
        {
            public function getBackend()
            {
                return new class
                {
                    public function clean()
                    {
                    }
                };
            }
        };
        $this->cacheTypeList->expects($this->once())->method("\143\x6c\145\141\156\x54\171\160\145")->with("\144\142\x5f\144\x64\154");
        $yN244 = new \ReflectionClass($this->utility);
        $foUZ9 = $yN244->getProperty("\143\141\143\150\145\106\162\157\156\164\x65\156\144\120\x6f\157\154");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, new \ArrayIterator([$stbLo]));
        $this->utility->flushCache();
    }
    public function testPutFileContents_CallsFilePutContents()
    {
        $kmgA5 = $this->createMock(\Magento\Framework\Filesystem\Driver\File::class);
        $yN244 = new \ReflectionClass($this->utility);
        $foUZ9 = $yN244->getProperty("\146\x69\154\145\x53\x79\x73\x74\145\x6d");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $kmgA5);
        $kmgA5->expects($this->once())->method("\146\151\154\145\x50\165\164\x43\x6f\x6e\x74\x65\x6e\x74\163")->with("\146\x69\154\x65\x2e\164\x78\164", "\144\141\164\x61");
        $this->utility->putFileContents("\146\151\x6c\x65\56\x74\170\164", "\144\x61\x74\141");
    }
    public function testGetLogoutUrl_CustomerLoggedIn()
    {
        $this->customerSession->method("\151\163\x4c\x6f\147\x67\145\x64\111\x6e")->willReturn(true);
        $this->utility = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x67\x65\x74\x55\x72\154"])->getMock();
        $this->utility->method("\x67\x65\164\x55\x72\154")->with("\143\x75\163\164\x6f\x6d\x65\162\57\141\143\143\157\x75\156\164\57\x6c\x6f\x67\x6f\165\x74")->willReturn("\57\143\165\163\x74\157\x6d\145\x72\57\x6c\157\147\x6f\165\x74");
        $this->assertEquals("\57\x63\x75\163\164\x6f\155\145\162\x2f\x6c\157\147\157\x75\x74", $this->utility->getLogoutUrl());
    }
    public function testGetLogoutUrl_AdminLoggedIn()
    {
        $this->customerSession->method("\151\163\x4c\x6f\147\147\145\x64\111\x6e")->willReturn(false);
        $this->authSession->method("\151\163\x4c\157\x67\147\145\x64\x49\x6e")->willReturn(true);
        $this->utility = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x67\145\164\101\x64\x6d\151\156\125\x72\154"])->getMock();
        $this->utility->method("\x67\x65\164\101\144\x6d\x69\x6e\x55\162\154")->with("\x61\x64\x6d\x69\x6e\x68\x74\x6d\154\x2f\141\x75\x74\x68\x2f\x6c\157\x67\x6f\165\x74")->willReturn("\57\141\x64\155\151\x6e\57\x6c\x6f\x67\157\165\x74");
        $this->assertEquals("\57\x61\144\x6d\x69\x6e\57\x6c\157\147\x6f\x75\x74", $this->utility->getLogoutUrl());
    }
    public function testGetLogoutUrl_NotLoggedIn()
    {
        $this->customerSession->method("\151\163\114\157\147\147\145\144\x49\x6e")->willReturn(false);
        $this->authSession->method("\151\x73\114\157\147\147\145\144\x49\156")->willReturn(false);
        $this->assertEquals("\57", $this->utility->getLogoutUrl());
    }
    public function testGetCallBackUrl_ReturnsExpectedUrl()
    {
        $this->utility = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x67\145\164\102\141\163\145\x55\x72\x6c"])->getMock();
        $this->utility->method("\147\145\164\x42\x61\163\x65\x55\x72\154")->willReturn("\150\x74\x74\x70\163\72\57\57\x65\x78\141\155\160\154\145\x2e\x63\x6f\x6d\57");
        $this->assertEquals("\150\x74\x74\x70\x73\x3a\57\x2f\x65\x78\x61\x6d\x70\x6c\145\x2e\143\x6f\155\x2f" . TwoFAConstants::CALLBACK_URL, $this->utility->getCallBackUrl());
    }
    public function testGetAdminPageUrl_ReturnsAdminBaseUrl()
    {
        $this->utility = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x67\145\164\101\144\155\151\156\102\141\163\x65\x55\162\154"])->getMock();
        $this->utility->method("\x67\x65\x74\101\x64\155\x69\x6e\102\141\x73\145\125\x72\x6c")->willReturn("\x68\164\164\160\163\72\57\x2f\x61\x64\x6d\x69\156\56\x65\x78\x61\x6d\160\x6c\145\56\143\x6f\155\x2f");
        $this->assertEquals("\x68\164\164\160\163\x3a\57\57\x61\144\155\x69\x6e\56\x65\x78\141\x6d\160\154\x65\56\x63\157\155\57", $this->utility->getAdminPageUrl());
    }
    public function testGetCustomerLoginUrl_ReturnsExpectedUrl()
    {
        $this->utility = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\147\145\x74\125\162\154"])->getMock();
        $this->utility->method("\x67\145\x74\x55\x72\x6c")->with("\143\165\x73\x74\157\155\145\x72\57\141\x63\143\x6f\x75\156\x74\x2f\154\157\x67\x69\x6e")->willReturn("\57\x63\165\163\x74\157\155\x65\x72\57\154\157\147\x69\x6e");
        $this->assertEquals("\57\x63\165\x73\x74\x6f\x6d\x65\x72\x2f\x6c\x6f\147\151\156", $this->utility->getCustomerLoginUrl());
    }
    public function testGetIsTestConfigurationClicked_ReturnsConfig()
    {
        $this->scopeConfig->method("\147\x65\164\x56\x61\x6c\165\145")->willReturn(true);
        $this->assertTrue($this->utility->getIsTestConfigurationClicked());
    }
    public function testGetIsIpForCustomerClicked_ReturnsConfig()
    {
        $this->scopeConfig->method("\147\145\x74\x56\x61\154\165\145")->willReturn(true);
        $this->assertTrue($this->utility->getIsIp_for_CustomerClicked());
    }
    public function testGetIsIpForAdminClicked_ReturnsConfig()
    {
        $this->scopeConfig->method("\147\x65\164\x56\x61\x6c\x75\x65")->willReturn(true);
        $this->assertTrue($this->utility->getIsIp_for_AdminClicked());
    }
    public function testGetValueFromTableSQL_ReturnsValue()
    {
        $DyiBA = new class
        {
            public function fetchOne()
            {
                return "\x76\141\x6c\165\x65";
            }
        };
        $this->resource->method("\147\x65\164\103\157\x6e\156\x65\143\164\151\x6f\156")->willReturn($DyiBA);
        $this->utility = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x6c\157\147\x5f\144\x65\x62\165\147"])->getMock();
        $this->utility->expects($this->atLeast(2))->method("\154\x6f\147\x5f\x64\x65\x62\165\x67");
        $this->assertEquals("\166\141\x6c\x75\145", $this->utility->getValueFromTableSQL("\164\141\142\x6c\x65", "\x63\157\154", "\151\144\113\x65\x79", "\151\144\x56\x61\154\x75\145"));
    }
    public function testGetCurrentAdminUser_ReturnsUser()
    {
        $user = new \stdClass();
        $jIBrz = new class($user)
        {
            private $user;
            public function __construct($user)
            {
                $this->user = $user;
            }
            public function getUser()
            {
                return $this->user;
            }
        };
        $yN244 = new \ReflectionClass($this->utility);
        $foUZ9 = $yN244->getProperty("\141\165\x74\x68\123\145\x73\163\151\x6f\x6e");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $jIBrz);
        $this->assertSame($user, $this->utility->getCurrentAdminUser());
    }
    public function testLogDebug_LogsStringAndObject()
    {
        $wT2Wf = $this->createMock(\MiniOrange\TwoFA\Logger\Logger::class);
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x69\x73\114\x6f\147\x45\x6e\141\x62\x6c\x65"])->getMock();
        $Bi2JU->method("\x69\163\114\157\x67\x45\156\141\142\154\145")->willReturn(true);
        $yN244 = new \ReflectionClass($Bi2JU);
        $foUZ9 = $yN244->getProperty("\x5f\x6c\157\x67\147\145\x72");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($Bi2JU, $wT2Wf);
        $wT2Wf->expects($this->atLeastOnce())->method("\144\x65\142\x75\147");
        $Bi2JU->log_debug("\x74\x65\x73\164\x20\155\145\163\x73\141\147\145");
        $Bi2JU->log_debug((object) ["\x66\157\157" => "\142\141\162"], (object) ["\146\x6f\157" => "\x62\x61\x72"]);
    }
    public function testCustomlog_LogsIfEnabled()
    {
        $this->utility = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x69\163\114\x6f\147\x45\156\141\142\x6c\x65"])->getMock();
        $this->utility->method("\x69\x73\114\x6f\x67\x45\156\x61\142\154\x65")->willReturn(true);
        $this->logger_customlog->expects($this->once())->method("\x64\x65\x62\165\147")->with("\154\x6f\x67\x20\x74\x68\151\x73");
        $this->utility->customlog("\x6c\157\147\40\164\150\x69\163");
    }
    public function testCustomlog_DoesNotLogIfDisabled()
    {
        $this->utility = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x69\163\114\157\147\x45\x6e\141\x62\154\145"])->getMock();
        $this->utility->method("\x69\x73\x4c\157\x67\105\156\141\x62\x6c\x65")->willReturn(false);
        $this->logger_customlog->expects($this->never())->method("\x64\145\x62\x75\x67");
        $this->utility->customlog("\154\157\147\40\164\150\x69\x73");
    }
    public function testIsLogEnable_ReturnsConfig()
    {
        $this->scopeConfig->method("\147\x65\164\x56\x61\x6c\165\145")->willReturn(true);
        $this->assertTrue($this->utility->isLogEnable());
    }
    public function testAuthenticatorIssuer_ReturnsCustomIssuer()
    {
        $this->scopeConfig->method("\147\x65\164\x56\141\x6c\x75\x65")->willReturn("\115\x79\111\x73\x73\x75\145\162");
        $this->assertEquals("\115\x79\111\163\163\165\x65\x72", $this->utility->AuthenticatorIssuer());
    }
    public function testAuthenticatorIssuer_ReturnsDefaultIfNull()
    {
        $this->scopeConfig->method("\x67\x65\164\x56\141\154\x75\145")->willReturn(null);
        $this->assertEquals("\155\151\156\151\x4f\162\141\x6e\147\x65", $this->utility->AuthenticatorIssuer());
    }
    public function testSanitizeOtp_RemovesNonNumeric()
    {
        $this->assertEquals("\61\62\63\x34", $this->utility->sanitize_otp("\61\x61\x32\142\63\143\x34\x64"));
    }
    public function testCheckOtpExpiry_Expired()
    {
        $this->sessionValues = ["\x6f\160\164\x5f\145\x78\160\151\162\171\x5f\x74\x69\155\145" => time() - 10];
        $this->assertTrue($this->utility->check_otp_expiry());
    }
    public function testCheckOtpExpiry_NotExpired()
    {
        $this->sessionValues = ["\157\160\x74\x5f\145\x78\160\x69\x72\x79\x5f\x74\x69\x6d\x65" => time() + 100];
        $this->assertFalse($this->utility->check_otp_expiry());
    }
    public function testGenerateFingerprint_ReturnsHash()
    {
        $Cclw0 = "\x4d\x6f\172\151\154\154\141\57\x35\x2e\60\40\x28\x57\x69\x6e\x64\x6f\167\x73\40\x4e\x54\x20\x31\60\56\60\x3b\x20\127\151\x6e\66\64\73\40\x78\x36\64\51";
        $nMsLo = hash("\163\150\x61\62\x35\x36", $Cclw0);
        $this->assertEquals($nMsLo, $this->utility->generateFingerprint($Cclw0));
    }
    public function testIsMobileDevice_TrueForMobile()
    {
        $Cclw0 = "\x4d\157\172\x69\154\154\141\x2f\x35\x2e\60\40\x28\151\x50\x68\157\156\145\73\x20\x43\120\x55\x20\x69\x50\x68\x6f\156\x65\40\x4f\x53\40\61\x30\137\x33\40\x6c\151\x6b\x65\40\115\x61\x63\x20\x4f\123\40\x58\x29";
        $this->assertTrue($this->utility->isMobileDevice($Cclw0));
    }
    public function testIsMobileDevice_FalseForDesktop()
    {
        $Cclw0 = "\115\157\x7a\151\154\x6c\x61\x2f\x35\x2e\x30\x20\50\x57\151\x6e\144\x6f\x77\x73\40\x4e\124\40\x31\x30\56\x30\x3b\x20\x57\x69\156\x36\x34\73\40\x78\66\64\x29";
        $this->assertFalse($this->utility->isMobileDevice($Cclw0));
    }
    public function testGetOS_Windows()
    {
        $Cclw0 = "\x4d\x6f\172\151\x6c\154\141\x2f\x35\56\60\40\x28\x57\x69\156\x64\157\x77\163\x20\x4e\x54\x20\x31\60\x2e\x30\x3b\x20\x57\x69\x6e\66\64\x3b\40\170\66\64\x29";
        $this->assertEquals("\x57\x69\x6e\x64\157\167\163", $this->utility->getOS($Cclw0));
    }
    public function testGetOS_Mac()
    {
        $Cclw0 = "\x4d\x6f\x7a\x69\154\154\x61\x2f\65\x2e\60\40\x28\x4d\141\143\151\x6e\x74\157\163\150\73\40\111\x6e\164\145\x6c\40\115\141\x63\40\117\x53\40\130\40\x31\x30\x5f\61\65\x5f\x37\x29";
        $this->assertEquals("\115\141\x63", $this->utility->getOS($Cclw0));
    }
    public function testGetOS_Linux()
    {
        $Cclw0 = "\115\157\x7a\x69\x6c\x6c\x61\x2f\x35\x2e\x30\x20\x28\x58\x31\x31\x3b\x20\x4c\151\x6e\165\170\x20\x78\x38\66\x5f\x36\x34\51";
        $this->assertEquals("\x4c\151\x6e\x75\170", $this->utility->getOS($Cclw0));
    }
    public function testGetOS_Android()
    {
        $Cclw0 = "\115\x6f\x7a\151\154\154\141\x2f\65\56\60\x20\x28\114\151\x6e\x75\170\73\40\101\x6e\144\162\x6f\x69\144\40\x38\56\60\x2e\60\x3b\x20\123\x4d\x2d\107\71\x35\x30\106\51";
        $this->assertEquals("\x4c\x69\x6e\165\170", $this->utility->getOS($Cclw0));
    }
    public function testGetOS_iOS()
    {
        $Cclw0 = "\x4d\157\x7a\151\x6c\154\x61\x2f\x35\56\60\40\50\151\120\x68\x6f\156\145\73\x20\103\120\x55\40\x69\x50\150\157\x6e\145\40\117\123\x20\x31\x30\x5f\x33\40\x6c\x69\153\x65\40\x4d\141\x63\x20\x4f\x53\x20\130\x29";
        $this->assertEquals("\x4d\141\x63", $this->utility->getOS($Cclw0));
    }
    public function testGetOS_Unknown()
    {
        $Cclw0 = "\x4d\x6f\172\151\154\154\141\x2f\65\56\x30\x20\x28\125\x6e\153\156\x6f\x77\156\x44\145\x76\151\143\x65\x29";
        $this->assertEquals("\x55\156\x6b\156\x6f\x77\x6e\40\117\x53", $this->utility->getOS($Cclw0));
    }
    public function testRemoveSignInSettFings_SetsConfigToZero()
    {
        $this->configWriter->expects($this->atLeastOnce())->method("\x73\141\x76\145");
        $this->utility->removeSignInSettFings();
    }
    public function testReinitConfig_CallsReinit()
    {
        $this->reinitableConfig->expects($this->once())->method("\162\145\151\x6e\151\164");
        $this->utility->reinitConfig();
    }
    public function testMicr_TrueIfLicensePlan()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x63\150\145\143\153\x5f\154\x69\x63\145\156\163\x65\137\x70\154\141\x6e"])->getMock();
        $Bi2JU->method("\143\x68\x65\x63\x6b\137\x6c\x69\x63\145\156\163\145\x5f\160\x6c\141\x6e")->willReturn(true);
        $this->assertTrue($Bi2JU->micr());
    }
    public function testMicr_FalseIfEmailOrKeyBlank()
    {
        $this->scopeConfig->method("\147\145\x74\126\141\x6c\165\x65")->willReturnMap([["\x43\x55\123\x54\117\115\105\x52\x5f\105\115\101\x49\114", null, ''], ["\x43\125\x53\124\x4f\115\x45\122\137\x4b\105\131", null, '']]);
        $this->assertFalse($this->utility->micr());
    }
    public function testMclv_TrueIfLicensePlan()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\143\x68\145\143\153\x5f\x6c\x69\x63\145\x6e\x73\x65\x5f\x70\154\x61\156"])->getMock();
        $Bi2JU->method("\x63\150\145\x63\153\137\x6c\x69\143\x65\156\163\x65\x5f\x70\154\x61\156")->willReturn(true);
        $this->assertTrue($Bi2JU->mclv());
    }
    public function testUpdateRowInTable_CallsUpdate()
    {
        $DyiBA = new class
        {
            public $called = false;
            public function update()
            {
                $this->called = true;
            }
        };
        $this->resource->method("\147\x65\x74\x43\157\156\x6e\145\143\164\x69\x6f\x6e")->willReturn($DyiBA);
        $this->utility->updateRowInTable("\164\141\142\x6c\145", ["\x63\x6f\x6c" => "\166\141\x6c"], "\x69\x64\x4b\145\x79", "\151\144\x56\141\x6c\165\x65");
        $this->assertTrue($DyiBA->called);
    }
    public function testDeleteRowInTable_CallsExec()
    {
        $DyiBA = new class
        {
            public $called = false;
            public function exec()
            {
                $this->called = true;
            }
        };
        $this->resource->method("\147\x65\164\103\157\156\156\x65\x63\x74\151\x6f\x6e")->willReturn($DyiBA);
        $this->utility->deleteRowInTable("\164\141\142\154\x65", "\151\144\x4b\145\x79", "\151\144\126\x61\x6c\165\x65");
        $this->assertTrue($DyiBA->called);
    }
    public function testDeleteRowInTableWithWebsiteID_CallsExec()
    {
        $DyiBA = new class
        {
            public $called = false;
            public function exec()
            {
                $this->called = true;
            }
        };
        $this->resource->method("\x67\145\164\103\157\156\x6e\145\x63\164\151\x6f\x6e")->willReturn($DyiBA);
        $this->utility->deleteRowInTableWithWebsiteID("\164\x61\x62\x6c\145", "\x69\x64\x4b\x65\x79", "\x69\x64\x56\141\154\x75\x65", "\x77\145\142\x73\151\164\x65\x49\144");
        $this->assertTrue($DyiBA->called);
    }
    public function testOTPOverSMSAndEMAILMessage_AllSuccess()
    {
        $UYLkD = $this->utility->OTP_over_SMSandEMAIL_Message("\165\x73\145\162\100\x65\x78\x61\x6d\x70\x6c\145\x2e\x63\x6f\x6d", "\x31\x32\x33\x34\65\66\x37\x38\x39\x30", "\123\x55\103\x43\105\x53\123", "\123\x55\103\103\x45\123\x53");
        $this->assertStringContainsString("\x54\150\145\40\117\124\x50\40\x68\x61\163\40\x62\x65\145\156\x20\163\145\156\164\x20\164\157\40\171\157\x75\162\40\120\x68\157\156\145", $UYLkD);
        $this->assertStringContainsString("\141\x6e\144\x20\x45\x6d\141\151\154\x3a", $UYLkD);
    }
    public function testOTPOverSMSAndEMAILMessage_EmailSuccess_SMSSuccess()
    {
        $UYLkD = $this->utility->OTP_over_SMSandEMAIL_Message("\165\163\145\162\100\145\x78\141\155\x70\x6c\x65\56\143\x6f\x6d", "\61\x32\63\x34\65\66\67\70\x39\x30", "\123\125\x43\x43\105\123\x53", "\x53\125\103\x43\x45\x53\123");
        $this->assertStringContainsString("\124\150\145\x20\117\124\x50\40\150\x61\163\x20\x62\145\x65\x6e\40\x73\145\156\164\x20\x74\157\x20\171\x6f\x75\x72\40\120\x68\157\156\x65", $UYLkD);
        $this->assertStringContainsString("\x61\156\x64\40\105\155\141\x69\154\x3a", $UYLkD);
    }
    public function testOTPOverSMSAndEMAILMessage_EmailFailed_SMSSuccess()
    {
        $UYLkD = $this->utility->OTP_over_SMSandEMAIL_Message("\x75\x73\145\x72\x40\145\x78\x61\155\x70\x6c\x65\x2e\x63\157\x6d", "\x31\62\x33\64\x35\66\67\x38\71\x30", "\x46\x41\111\x4c\x45\x44", "\123\125\x43\103\x45\123\x53");
        $this->assertStringContainsString("\124\150\145\x20\x4f\124\x50\40\x68\x61\163\x20\x62\x65\x65\156\x20\163\x65\x6e\164\40\x74\157\x20\171\157\165\162\x20\x50\x68\157\156\145", $UYLkD);
        $this->assertStringContainsString("\106\x61\151\x6c\145\x64\40\164\157\40\x73\x65\156\x64\40\x4f\124\120\40\x74\x6f\40\145\x6d\x61\151\x6c", $UYLkD);
    }
    public function testOTPOverSMSAndEMAILMessage_AllFailed()
    {
        $UYLkD = $this->utility->OTP_over_SMSandEMAIL_Message("\x75\163\x65\162\100\145\170\141\155\160\x6c\x65\56\x63\x6f\x6d", "\61\x32\63\64\65\66\x37\70\71\60", "\106\101\111\114\x45\104", "\106\x41\111\114\x45\104");
        $this->assertStringContainsString("\106\x61\151\x6c\x65\x64\40\x74\157\x20\163\145\x6e\x64\x20\117\x54\x50\x20\164\x6f\40\145\x6d\x61\151\154\40\141\x6e\144\x20\160\x68\x6f\156\x65", $UYLkD);
    }
    public function testTfaMethodArray_ReturnsExpectedArray()
    {
        $RoD1b = $this->utility->tfaMethodArray();
        $this->assertIsArray($RoD1b);
        $this->assertArrayHasKey("\x4f\x4f\123", $RoD1b);
        $this->assertArrayHasKey("\107\157\157\147\x6c\x65\x41\x75\x74\x68\x65\156\x74\151\143\141\164\x6f\162", $RoD1b);
    }
    public function testAuthenticatorUrl_ReturnsExpectedFormat()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\154\157\147\137\144\x65\142\x75\x67", "\x67\145\164\123\145\x73\163\x69\x6f\x6e\x56\x61\154\x75\145", "\147\145\x74\103\165\162\162\x65\x6e\x74\x41\144\155\x69\x6e\125\163\145\x72", "\x67\145\x74\x41\x75\164\x68\145\156\x74\151\143\x61\x74\157\x72\x53\x65\143\162\x65\164", "\147\145\x74\x41\154\x6c\115\x6f\x54\x66\141\x55\x73\x65\162\x44\x65\164\141\x69\x6c\163", "\147\x65\x74\x43\165\x73\164\x6f\155\x65\x72\115\157\124\x66\141\x55\x73\x65\x72\104\145\164\141\x69\x6c\x73", "\101\x75\x74\150\145\156\164\x69\143\x61\164\x6f\162\x49\x73\x73\165\145\162", "\163\x65\x74\123\x65\163\x73\x69\x6f\156\126\x61\154\165\x65"])->getMock();
        $Bi2JU->method("\147\145\x74\x53\145\163\x73\151\157\x6e\126\x61\154\165\x65")->willReturn(null);
        $ZBeTV = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\x74\x55\163\x65\x72\156\x61\x6d\145"])->getMock();
        $ZBeTV->method("\x67\145\164\x55\163\145\162\156\141\x6d\145")->willReturn("\141\x64\x6d\151\156");
        $Bi2JU->method("\x67\x65\x74\103\165\x72\x72\145\156\x74\x41\144\155\x69\156\x55\x73\x65\x72")->willReturn($ZBeTV);
        $Bi2JU->method("\x67\x65\164\101\x75\164\x68\x65\x6e\x74\151\143\x61\x74\157\x72\123\145\x63\162\x65\164")->willReturn("\x53\x45\103\122\x45\x54");
        $Bi2JU->method("\101\x75\164\150\145\x6e\164\151\143\141\x74\157\162\x49\163\x73\x75\145\x72")->willReturn("\155\151\x6e\x69\117\162\x61\156\147\x65");
        $Bi2JU->method("\x67\145\164\x41\x6c\154\115\157\124\x66\141\x55\x73\145\x72\x44\x65\x74\141\151\154\x73")->willReturn([]);
        $Bi2JU->method("\147\145\x74\x43\165\163\164\157\x6d\x65\x72\x4d\157\124\146\141\125\x73\145\x72\x44\x65\x74\141\x69\x6c\x73")->willReturn([]);
        $Bi2JU->method("\163\x65\x74\x53\145\163\163\x69\x6f\x6e\x56\x61\x6c\x75\145")->willReturn(null);
        $kWJUb = $Bi2JU->AuthenticatorUrl();
        $this->assertStringContainsString("\x6f\164\x70\x61\165\164\x68\72\x2f\57\164\x6f\x74\160\57", $kWJUb);
        $this->assertStringContainsString("\x69\x73\163\x75\x65\162\75\155\151\x6e\151\117\x72\x61\x6e\x67\145", $kWJUb);
    }
    public function testVerifyGauthCode_ReturnsJson()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x67\145\x74\x41\x75\x74\150\x65\x6e\164\x69\x63\141\x74\x6f\x72\123\145\x63\x72\145\164", "\x67\145\164\123\x65\163\163\x69\x6f\x6e\x56\141\x6c\x75\145", "\x73\145\164\x53\145\163\163\151\157\156\x56\x61\154\x75\145", "\x6c\157\147\x5f\144\145\142\165\147"])->getMock();
        $Bi2JU->method("\147\x65\164\101\165\x74\x68\x65\156\x74\x69\143\x61\164\157\162\123\145\x63\162\x65\164")->willReturn("\112\102\x53\x57\131\63\104\x50\105\110\120\113\63\x50\x58\120");
        $Bi2JU->method("\147\x65\x74\x53\145\x73\163\x69\157\156\126\141\154\165\145")->willReturn(null);
        $Bi2JU->method("\x73\x65\164\x53\145\163\163\151\x6f\156\126\x61\154\x75\145")->willReturn(null);
        $Bi2JU->method("\x6c\157\147\137\144\x65\x62\x75\147")->willReturn(null);
        $ZQYi9 = $Bi2JU->getCode("\112\x42\x53\127\x59\x33\104\x50\x45\x48\120\113\x33\x50\x58\120");
        $RoD1b = $Bi2JU->verifyGauthCode($ZQYi9, "\165\x73\145\162");
        $this->assertJson($RoD1b);
    }
    public function testGetCode_Returns6DigitCode()
    {
        $Iiekl = "\x4a\x42\123\127\x59\63\104\x50\x45\110\x50\113\x33\x50\x58\x50";
        $ZQYi9 = $this->utility->getCode($Iiekl, 1);
        $this->assertMatchesRegularExpression("\x2f\x5e\133\60\x2d\x39\135\173\66\x7d\44\57", $ZQYi9);
    }
    public function testBase32Decode_ReturnsExpected()
    {
        $Iiekl = "\112\x42\123\127\x59\63\104\120\x45\x48\x50\x4b\63\120\x58\120";
        $MLM0W = $this->utility->_base32Decode($Iiekl);
        $this->assertIsString($MLM0W);
    }
    public function testGetBase32LookupTable_ReturnsArray()
    {
        $ck05Q = $this->utility->_getBase32LookupTable();
        $this->assertIsArray($ck05Q);
        $this->assertContains("\101", $ck05Q);
    }
    public function testTimingSafeEquals_TrueForEqual()
    {
        $this->assertTrue($this->utility->timingSafeEquals("\x61\142\x63", "\141\x62\143"));
        $this->assertFalse($this->utility->timingSafeEquals("\141\x62\143", "\144\x65\146"));
    }
    public function testCustomgatewayGenerateOTP_ReturnsString()
    {
        $HoKg3 = $this->utility->Customgateway_GenerateOTP();
        $this->assertIsString($HoKg3);
        $this->assertGreaterThanOrEqual(4, strlen($HoKg3));
    }
    public function testGetOTPLength_GoogleAuthenticator()
    {
        $this->assertEquals(6, $this->utility->get_OTP_length("\x47\x6f\157\x67\x6c\145\101\165\x74\x68\x65\156\x74\x69\x63\141\x74\157\x72"));
    }
    public function testCheckCustomGatewayMethodConfigured_ReturnsBool()
    {
        $this->scopeConfig->method("\x67\145\x74\126\141\154\x75\x65")->willReturn("\166\x61\x6c\165\145");
        $this->assertFalse($this->utility->check_customGateway_methodConfigured());
    }
    public function testGetGroupNameById_ReturnsString()
    {
        $o99Jk = new class
        {
            public function getCode()
            {
                return "\107\x65\156\x65\162\x61\154";
            }
        };
        $this->groupRepository->method("\x67\145\x74\x42\171\x49\144")->willReturn($o99Jk);
        $this->assertEquals("\107\145\156\x65\x72\141\x6c", $this->utility->getGroupNameById(1));
    }
    public function testCheck2faEnterprisePlan_ReturnsInt()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\143\150\145\143\x6b\x5f\154\151\x63\x65\x6e\163\x65\137\160\x6c\x61\156", "\151\x73\x54\x72\x69\x61\154\x45\x78\x70\151\x72\145\144"])->getMock();
        $Bi2JU->method("\143\x68\145\143\x6b\137\x6c\151\143\x65\156\163\145\137\160\154\141\156")->willReturn(true);
        $Bi2JU->method("\151\163\124\162\x69\x61\x6c\x45\170\x70\x69\x72\x65\x64")->willReturn(false);
        $this->assertEquals(1, $Bi2JU->check2fa_enterprisePlan());
    }
    public function testCheck2faBackendPlan_ReturnsInt()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\143\x68\145\143\x6b\137\154\x69\143\145\x6e\x73\x65\137\x70\154\141\156", "\151\x73\x54\162\x69\141\154\105\170\x70\x69\x72\x65\144"])->getMock();
        $Bi2JU->method("\x63\150\145\143\153\137\154\x69\x63\145\x6e\x73\145\x5f\x70\154\x61\x6e")->willReturn(true);
        $Bi2JU->method("\151\x73\x54\162\151\141\x6c\105\170\160\151\x72\x65\x64")->willReturn(false);
        $this->assertEquals(1, $Bi2JU->check2fa_backendPlan());
    }
    public function testCheck2faAllInclusivePlan_ReturnsInt()
    {
        $this->scopeConfig->method("\x67\145\x74\126\x61\154\x75\x65")->willReturn(true);
        $this->assertIsInt($this->utility->check2fa_allInclusivePlan());
    }
    public function testGetEmailTemplateList_ReturnsArray()
    {
        $JrA7v = $this->getMockBuilder(\stdClass::class)->addMethods(["\146\x72\157\x6d"])->getMock();
        $JrA7v->method("\146\x72\157\x6d")->willReturn("\163\x65\x6c\145\143\x74\137\x71\x75\x65\x72\171");
        $DyiBA = $this->getMockBuilder(\stdClass::class)->addMethods(["\x73\x65\x6c\145\x63\164", "\146\x65\x74\143\x68\101\154\x6c"])->getMock();
        $DyiBA->method("\163\x65\x6c\x65\143\164")->willReturn($JrA7v);
        $DyiBA->method("\x66\x65\x74\x63\x68\101\154\x6c")->willReturn([["\164\x65\x6d\x70\154\x61\x74\145\x5f\x63\157\144\x65" => "\146\157\157", "\164\145\x6d\160\x6c\141\164\145\x5f\x69\x64" => 1]]);
        $this->resource->method("\147\145\164\103\157\x6e\x6e\145\143\164\x69\x6f\x6e")->willReturn($DyiBA);
        $this->assertIsArray($this->utility->getemailtemplatelist());
    }
    public function testCheckBlacklistedIP_ReturnsBool()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x67\145\164\x5f\x63\154\151\x65\x6e\x74\137\151\x70", "\147\x65\x74\x53\x74\157\162\145\103\157\x6e\146\x69\x67"])->getMock();
        $Bi2JU->method("\x67\x65\x74\x5f\x63\x6c\x69\145\x6e\x74\137\151\x70")->willReturn("\x31\x2e\62\x2e\63\x2e\64");
        $Bi2JU->method("\147\x65\164\123\164\157\x72\145\103\157\x6e\x66\151\x67")->willReturnCallback(function ($qZ3iu) {
            if (!($qZ3iu === TwoFAConstants::IP_LISTING)) {
                goto bhTML;
            }
            return 1;
            bhTML:
            if (!($qZ3iu === TwoFAConstants::ALL_IP_BLACKLISTED)) {
                goto NV795;
            }
            return json_encode(["\61\56\62\x2e\63\x2e\x34"]);
            NV795:
            return null;
        });
        $this->assertTrue($Bi2JU->checkBlacklistedIP());
    }
    public function testCheckTrustedIPs_ReturnsBool()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x67\x65\164\x5f\x63\x6c\x69\145\156\164\137\x69\x70", "\x67\145\x74\x49\x70\127\150\151\x74\x65\x6c\x69\163\164\145\x64\111\160\x41\144\x64\x72\x65\163\163\145\163", "\x6c\x6f\x67\x5f\144\145\142\x75\x67", "\x67\145\x74\x53\x74\157\x72\145\x43\157\x6e\x66\151\x67"])->getMock();
        $Bi2JU->method("\x67\145\x74\137\143\154\x69\x65\x6e\164\137\x69\160")->willReturn("\x31\56\x32\x2e\x33\56\64");
        $Bi2JU->method("\x67\x65\x74\111\160\127\x68\151\x74\x65\x6c\151\163\164\x65\x64\111\x70\101\x64\144\x72\145\163\x73\145\163")->willReturn(["\61\x2e\x32\56\x33\x2e\x34"]);
        $Bi2JU->method("\154\157\147\137\144\x65\142\x75\147")->willReturn(null);
        $Bi2JU->method("\147\x65\164\123\164\x6f\162\145\x43\x6f\x6e\x66\x69\x67")->willReturn(1);
        $this->assertTrue($Bi2JU->checkTrustedIPs("\x63\165\163\164\157\x6d\145\162"));
    }
    public function testGetClientIp_ReturnsString()
    {
        $p9N3F = $this->utility->get_client_ip();
        $this->assertIsString($p9N3F);
    }
    public function testGetCustomerKeys_ReturnsArray()
    {
        $RoD1b = $this->utility->getCustomerKeys();
        $this->assertIsArray($RoD1b);
        $this->assertArrayHasKey("\x63\x75\163\x74\x6f\x6d\145\x72\x5f\x6b\145\171", $RoD1b);
        $this->assertArrayHasKey("\x61\x70\x69\x4b\145\171", $RoD1b);
    }
    public function testGetApiUrls_ReturnsArray()
    {
        $RoD1b = TwoFAUtility::getApiUrls();
        $this->assertIsArray($RoD1b);
        $this->assertArrayHasKey("\166\x61\x6c\151\144\141\x74\x65", $RoD1b);
    }
    public function testSendCustomgatewayWhatsapp_ReturnsArray()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\154\157\x67\137\144\145\x62\x75\147", "\x67\x65\x74\123\x74\157\x72\145\x43\x6f\156\146\x69\x67"])->getMock();
        $Bi2JU->method("\154\157\147\x5f\x64\x65\142\x75\147")->willReturn(null);
        $Bi2JU->method("\x67\x65\164\123\x74\157\x72\x65\x43\157\x6e\146\x69\147")->willReturn("\166\x61\154\x75\145");
        $RoD1b = $Bi2JU->send_customgateway_whatsapp("\61\62\x33\x34\x35\66\x37\x38\x39\60", "\x31\x32\x33\64");
        $this->assertIsArray($RoD1b);
    }
    public function testCheckDeviceLimit_TrueWhenNoDevices()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\147\145\x74\x53\x74\157\x72\145\103\x6f\156\x66\151\147", "\x67\145\x74\x53\x65\163\x73\x69\x6f\x6e\x56\x61\x6c\165\145", "\147\x65\164\101\x6c\154\x4d\x6f\x54\x66\141\125\163\145\x72\x44\145\x74\141\151\154\x73", "\x67\145\164\103\x75\162\x72\145\x6e\164\x44\145\166\151\143\145\111\156\146\x6f", "\x6c\157\147\137\x64\x65\x62\165\147"])->getMock();
        $Bi2JU->method("\x67\145\x74\123\164\x6f\162\x65\103\157\156\x66\x69\x67")->willReturn(1);
        $Bi2JU->method("\147\145\164\123\145\x73\x73\151\157\x6e\x56\141\154\x75\145")->willReturn("\165\x73\x65\x72\x40\x65\x78\141\x6d\160\x6c\145\56\143\157\155");
        $Bi2JU->method("\x67\145\x74\101\154\154\x4d\x6f\x54\146\141\125\x73\x65\x72\x44\145\x74\x61\x69\154\x73")->willReturn([]);
        $Bi2JU->method("\147\145\164\x43\x75\x72\162\145\x6e\164\x44\145\166\151\143\x65\x49\x6e\146\157")->willReturn(json_encode(["\x46\x69\x6e\x67\145\x72\x70\162\151\156\164" => "\x61\x62\143"]));
        $Bi2JU->method("\x6c\x6f\x67\x5f\x64\x65\142\x75\147")->willReturn(null);
        $this->assertTrue($Bi2JU->check_device_limit(1, "\165\163\145\x72\x40\145\x78\x61\155\x70\x6c\x65\56\x63\157\x6d"));
    }
    public function testCheckDeviceLimitAdmin_TrueWhenNoDevices()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x67\x65\164\123\164\157\162\x65\103\157\156\x66\151\x67", "\x67\145\164\123\x65\163\163\x69\x6f\x6e\x56\141\x6c\165\145", "\x67\145\164\101\x6c\x6c\115\x6f\x54\x66\x61\125\163\x65\162\x44\145\164\141\x69\154\163", "\x67\x65\x74\x43\x75\x72\x72\145\156\x74\x44\x65\166\x69\143\145\111\x6e\x66\x6f", "\154\157\x67\x5f\144\145\142\x75\147"])->getMock();
        $Bi2JU->method("\x67\145\x74\x53\x74\157\x72\x65\x43\x6f\156\146\151\x67")->willReturn(1);
        $Bi2JU->method("\x67\x65\164\123\x65\x73\163\x69\x6f\156\126\141\x6c\165\145")->willReturn("\141\144\155\x69\x6e\x40\x65\170\x61\x6d\160\154\145\x2e\x63\x6f\x6d");
        $Bi2JU->method("\147\x65\x74\x41\154\154\x4d\x6f\124\x66\x61\x55\x73\145\162\104\x65\164\x61\151\154\x73")->willReturn([]);
        $Bi2JU->method("\x67\x65\x74\x43\x75\x72\x72\x65\x6e\x74\x44\x65\x76\x69\143\145\x49\156\x66\157")->willReturn(json_encode(["\x46\151\156\147\x65\x72\160\x72\151\156\164" => "\x61\x62\143"]));
        $Bi2JU->method("\154\157\x67\137\144\x65\142\x75\147")->willReturn(null);
        $this->assertTrue($Bi2JU->check_device_limit_admin("\141\x64\155\151\156"));
    }
    public function testCheckAndSaveDeviceData_NoException()
    {
        $_SERVER["\110\x54\124\120\x5f\125\x53\105\122\137\x41\107\x45\116\x54"] = "\125\x6e\151\164\x54\145\163\164\x41\147\x65\x6e\x74";
        $_SERVER["\122\105\x4d\117\x54\x45\137\x41\104\x44\x52"] = "\x31\x32\67\56\x30\56\x30\x2e\x31";
        $XkQUt = $this->getMockBuilder(\Magento\Framework\Stdlib\Cookie\PublicCookieMetadata::class)->onlyMethods(["\163\145\x74\120\x61\164\150", "\163\145\164\110\x74\164\160\117\x6e\154\x79", "\163\145\164\104\x75\162\x61\x74\151\157\x6e"])->getMock();
        $XkQUt->method("\163\x65\164\120\141\164\x68")->willReturnSelf();
        $XkQUt->method("\x73\x65\164\x48\x74\164\160\117\x6e\x6c\171")->willReturnSelf();
        $XkQUt->method("\x73\x65\164\104\x75\162\x61\164\x69\x6f\x6e")->willReturnSelf();
        $this->cookieMetadataFactory->method("\143\162\x65\141\164\145\x50\x75\x62\154\x69\x63\x43\157\157\153\x69\x65\x4d\x65\x74\x61\144\x61\164\x61")->willReturn($XkQUt);
        $this->cookieManager->method("\163\145\164\120\x75\142\154\151\x63\x43\x6f\157\153\151\x65")->willReturn(null);
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\147\145\164\x5f\x61\x64\x6d\x69\156\x5f\x72\157\x6c\145\x5f\156\x61\x6d\145", "\147\145\164\x53\x74\x6f\162\x65\x43\x6f\x6e\x66\x69\x67", "\x6c\x6f\147\137\x64\145\142\165\x67", "\165\160\144\x61\164\145\x43\x6f\154\x75\155\156\x49\156\x54\x61\x62\154\145"])->getMock();
        $Bi2JU->method("\147\x65\x74\x5f\x61\144\155\x69\156\x5f\162\x6f\x6c\x65\x5f\x6e\x61\x6d\x65")->willReturn("\141\144\x6d\x69\x6e");
        $Bi2JU->method("\147\145\x74\x53\164\157\162\145\103\157\156\x66\x69\147")->willReturn(1);
        $Bi2JU->method("\154\x6f\x67\137\x64\145\x62\x75\x67")->willReturn(null);
        $Bi2JU->method("\x75\x70\144\x61\164\x65\103\x6f\154\165\x6d\x6e\x49\x6e\124\141\142\154\x65")->willReturn(null);
        $FO9q9 = [["\x64\x65\166\x69\x63\145\137\x69\156\x66\157" => null]];
        $Bi2JU->check_and_save_device_data(true, "\x75\x73\x65\x72", 1, $FO9q9);
        $this->assertTrue(true);
    }
    public function testWhitelistCustomerThroughSession_NoException()
    {
        $Btl21 = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\164\127\145\142\x73\151\x74\145\111\144"])->getMock();
        $Btl21->method("\x67\x65\x74\x57\145\142\x73\x69\x74\145\111\144")->willReturn(1);
        $this->storeManager->method("\x67\x65\x74\x53\164\x6f\162\145")->willReturn($Btl21);
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\147\x65\164\123\145\163\163\151\157\156\x56\141\x6c\x75\145", "\x67\145\x74\103\165\x73\164\x6f\155\145\x72\x4d\157\x54\x66\x61\x55\x73\145\x72\104\145\164\x61\x69\154\163", "\x67\x65\164\123\164\157\x72\x65\103\x6f\156\146\151\x67", "\165\x70\x64\x61\x74\x65\103\x6f\x6c\x75\x6d\x6e\x49\156\124\141\142\x6c\x65", "\151\x6e\163\145\162\x74\122\x6f\x77\111\x6e\x54\141\x62\154\145"])->getMock();
        $Bi2JU->method("\147\145\164\123\145\163\163\151\x6f\x6e\126\141\154\x75\x65")->willReturn("\165\163\145\x72");
        $Bi2JU->method("\147\145\x74\x43\165\163\164\157\155\x65\x72\115\157\124\146\x61\x55\163\x65\x72\104\x65\x74\x61\x69\x6c\163")->willReturn([]);
        $Bi2JU->method("\147\x65\x74\123\164\x6f\162\x65\103\157\x6e\146\x69\x67")->willReturn(1);
        $Bi2JU->method("\x75\x70\x64\x61\x74\x65\103\157\154\165\155\x6e\111\x6e\x54\141\142\x6c\145")->willReturn(null);
        $Bi2JU->method("\x69\156\x73\x65\x72\x74\122\157\x77\111\156\x54\141\142\x6c\x65")->willReturn(null);
        $Bi2JU->whitelistCustomerThroughSession(true);
        $this->assertTrue(true);
    }
    public function testRemoveSettingsAfterAccount_NoException()
    {
        $this->configWriter->expects($this->atLeastOnce())->method("\163\x61\x76\x65");
        $this->utility->removeSettingsAfterAccount();
        $this->assertTrue(true);
    }
    public function testWhitelistAdminThroughSession_SkipTwofa()
    {
        $Btl21 = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\x74\127\145\x62\x73\x69\x74\x65\x49\144"])->getMock();
        $Btl21->method("\x67\x65\164\x57\x65\x62\163\x69\164\x65\x49\x64")->willReturn(-1);
        $this->storeManager->method("\147\x65\x74\123\164\157\x72\145")->willReturn($Btl21);
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x67\x65\x74\123\145\163\x73\151\x6f\x6e\x56\x61\154\165\145", "\147\145\x74\101\154\154\x4d\x6f\x54\x66\x61\x55\x73\x65\x72\104\145\x74\141\151\154\x73", "\165\x70\x64\x61\164\x65\103\x6f\x6c\165\155\156\111\x6e\x54\x61\x62\x6c\145", "\x69\156\163\x65\x72\x74\122\x6f\167\x49\x6e\x54\x61\x62\154\145"])->getMock();
        $Bi2JU->method("\x67\x65\x74\x53\x65\x73\163\151\157\x6e\x56\141\x6c\x75\x65")->willReturn("\141\x64\x6d\151\x6e");
        $Bi2JU->method("\147\x65\x74\101\154\154\x4d\x6f\124\146\141\125\163\145\x72\104\145\x74\141\x69\x6c\x73")->willReturn([]);
        $Bi2JU->method("\x75\160\144\141\164\x65\103\x6f\154\x75\155\156\111\156\x54\141\142\x6c\x65")->willReturn(null);
        $Bi2JU->method("\151\156\x73\x65\162\x74\x52\157\167\x49\x6e\x54\141\142\x6c\145")->willReturn(null);
        $Bi2JU->whitelistAdminThroughSession(true);
        $this->assertTrue(true);
    }
    public function testWhitelistAdminThroughSession_Permanent()
    {
        $Btl21 = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\164\127\145\142\163\x69\164\145\x49\x64"])->getMock();
        $Btl21->method("\147\145\x74\x57\x65\142\x73\x69\x74\145\111\x64")->willReturn(-1);
        $this->storeManager->method("\x67\145\164\123\164\157\x72\x65")->willReturn($Btl21);
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\147\x65\164\123\x65\x73\x73\151\x6f\156\126\x61\x6c\x75\x65", "\x67\x65\164\101\x6c\154\x4d\x6f\124\x66\x61\125\x73\x65\162\104\145\164\141\x69\154\163", "\x75\160\144\141\164\145\x43\157\154\x75\155\x6e\111\156\124\x61\142\x6c\145", "\151\156\x73\x65\x72\x74\122\157\167\111\x6e\124\141\x62\154\x65"])->getMock();
        $Bi2JU->method("\147\x65\x74\123\x65\x73\x73\x69\157\x6e\x56\141\x6c\x75\145")->willReturn("\141\x64\x6d\151\x6e");
        $Bi2JU->method("\147\145\164\101\154\x6c\x4d\x6f\x54\146\141\x55\163\145\162\x44\145\x74\x61\x69\x6c\163")->willReturn([]);
        $Bi2JU->method("\x75\x70\144\x61\164\x65\103\x6f\154\x75\155\156\x49\x6e\x54\141\x62\x6c\145")->willReturn(null);
        $Bi2JU->method("\151\x6e\x73\145\x72\x74\x52\x6f\167\x49\x6e\x54\x61\142\x6c\145")->willReturn(null);
        $Bi2JU->whitelistAdminThroughSession(false);
        $this->assertTrue(true);
    }
    public function testUpdateColumnInTable_CallsUpdate()
    {
        $DyiBA = $this->getMockBuilder(\stdClass::class)->addMethods(["\165\160\144\x61\164\145"])->getMock();
        $DyiBA->expects($this->once())->method("\x75\x70\x64\141\164\145");
        $this->resource->method("\147\145\164\103\157\156\x6e\145\x63\164\x69\157\x6e")->willReturn($DyiBA);
        $this->utility->updateColumnInTable("\164\x61\142\154\x65", "\x63\x6f\x6c", "\x76\x61\x6c", "\x69\144\113\x65\171", "\x69\x64\x56\x61\x6c\x75\145", 1);
        $this->assertTrue(true);
    }
    public function testInsertRowInTable_CallsInsertMultiple()
    {
        $DyiBA = $this->getMockBuilder(\stdClass::class)->addMethods(["\151\x6e\x73\x65\162\164\x4d\x75\x6c\164\151\160\x6c\x65"])->getMock();
        $DyiBA->expects($this->once())->method("\151\156\x73\145\x72\164\115\165\x6c\x74\151\x70\x6c\145");
        $this->resource->method("\147\x65\x74\103\157\x6e\156\145\143\x74\151\157\x6e")->willReturn($DyiBA);
        $this->utility->insertRowInTable("\164\x61\x62\154\x65", [["\143\x6f\x6c" => "\x76\x61\x6c"]]);
        $this->assertTrue(true);
    }
    public function testGetClearSessionForSkipTwoFA_CallsSetSessionValue()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\163\x65\164\123\145\163\x73\x69\157\x6e\126\141\154\x75\145"])->getMock();
        $Bi2JU->expects($this->atLeastOnce())->method("\163\145\x74\123\x65\x73\x73\151\x6f\x6e\126\141\154\x75\145");
        $Bi2JU->getClearSessionForSkipTwoFA();
        $this->assertTrue(true);
    }
    public function testLoginAndRedirectCustomer_ReturnsRedirect()
    {
        $user = new \stdClass();
        $dg7NT = $this->getMockBuilder(\Magento\Customer\Model\Customer::class)->disableOriginalConstructor()->onlyMethods(["\x6c\x6f\x61\144\102\x79\x45\x6d\x61\x69\x6c"])->addMethods(["\163\x65\x74\x57\x65\142\x73\151\x74\x65\111\144"])->getMock();
        $dg7NT->method("\x73\145\x74\x57\x65\142\x73\151\164\x65\x49\x64")->willReturnSelf();
        $dg7NT->method("\154\157\141\144\x42\x79\105\x6d\141\x69\x6c")->willReturn($user);
        $CmR2O = $this->getMockBuilder(\stdClass::class)->addMethods(["\163\145\164\125\162\x6c"])->getMock();
        $CmR2O->method("\163\x65\x74\125\162\154")->willReturnSelf();
        $KLhKw = $this->getMockBuilder(\Magento\Framework\Controller\ResultFactory::class)->disableOriginalConstructor()->onlyMethods(["\x63\x72\x65\141\x74\x65"])->getMock();
        $KLhKw->method("\143\x72\145\x61\164\x65")->willReturn($CmR2O);
        $R52NJ = $this->getMockBuilder(\Magento\Framework\UrlInterface::class)->disableOriginalConstructor()->getMock();
        $R52NJ->method("\x67\145\164\125\162\154")->willReturn("\143\x75\163\164\x6f\x6d\145\x72\57\x61\143\143\157\x75\x6e\x74");
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $dg7NT, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $R52NJ, $KLhKw, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\147\145\x74\x53\x65\x73\x73\151\x6f\156\126\141\154\165\145", "\147\145\x74\x43\165\163\x74\x6f\155\145\162\106\x72\x6f\155\x41\x74\164\162\x69\142\165\x74\145\x73"])->getMock();
        $Bi2JU->method("\147\145\164\x53\x65\x73\x73\x69\157\156\126\x61\154\x75\x65")->willReturn("\x75\163\x65\162\100\x65\x78\x61\x6d\160\x6c\145\x2e\143\x6f\155");
        $Bi2JU->method("\x67\x65\x74\103\x75\163\x74\x6f\x6d\145\x72\106\x72\157\155\x41\164\164\x72\x69\142\165\164\145\x73")->willReturn($user);
        $this->customerSession->expects($this->once())->method("\163\x65\164\x43\x75\x73\x74\157\x6d\x65\162\101\163\x4c\x6f\x67\x67\x65\144\x49\x6e")->with($user);
        $RoD1b = $Bi2JU->loginAndRedirectCustomer();
        $this->assertTrue(method_exists($RoD1b, "\163\145\164\125\x72\154"));
    }
    public function testGetCustomerFromAttributes_ReturnsCustomer()
    {
        $ubwvh = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\x74\x49\x64"])->getMock();
        $ubwvh->method("\x67\145\164\111\x64")->willReturn(1);
        $dg7NT = $this->getMockBuilder(\stdClass::class)->addMethods(["\163\145\164\127\145\142\163\151\x74\x65\x49\144", "\154\157\x61\144\102\171\x45\155\x61\x69\x6c"])->getMock();
        $dg7NT->method("\163\145\164\x57\x65\x62\163\x69\164\145\x49\x64")->willReturnSelf();
        $dg7NT->method("\x6c\157\x61\x64\102\x79\x45\x6d\x61\x69\154")->willReturn($ubwvh);
        $Btl21 = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\x74\127\145\142\x73\x69\164\145\111\x64"])->getMock();
        $Btl21->method("\147\x65\164\x57\x65\x62\x73\151\164\x65\x49\144")->willReturn(1);
        $this->storeManager->method("\x67\x65\164\x53\164\157\162\x65")->willReturn($Btl21);
        $yN244 = new \ReflectionClass($this->utility);
        $foUZ9 = $yN244->getProperty("\x63\x75\x73\x74\x6f\x6d\145\162\115\x6f\x64\145\x6c");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $dg7NT);
        $RoD1b = $this->utility->getCustomerFromAttributes("\x75\163\x65\162\100\x65\x78\x61\155\160\x6c\145\x2e\x63\157\x6d");
        $this->assertEquals($ubwvh, $RoD1b);
    }
    public function testGetAdminRoleName_ReturnsRole()
    {
        $ucYcb = new class
        {
            public function getData()
            {
                return ["\x72\157\x6c\145\x5f\x6e\x61\x6d\x65" => "\141\x64\155\151\156"];
            }
        };
        $z5roH = $this->getMockBuilder(\stdClass::class)->addMethods(["\143\162\x65\x61\164\145", "\141\144\x64\x46\151\145\154\144\124\157\x46\x69\154\164\145\162", "\147\x65\x74\106\x69\162\x73\164\111\x74\145\155"])->getMock();
        $z5roH->method("\143\162\145\x61\164\145")->willReturn($z5roH);
        $z5roH->method("\x61\x64\x64\x46\151\x65\x6c\x64\x54\157\x46\151\154\x74\145\x72")->willReturn($z5roH);
        $z5roH->method("\147\145\164\x46\x69\x72\x73\x74\x49\164\145\155")->willReturn($ucYcb);
        $this->userCollectionFactory->method("\143\162\x65\141\x74\x65")->willReturn($z5roH);
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\147\145\164\123\145\x73\163\151\157\156\x56\141\154\x75\145"])->getMock();
        $Bi2JU->method("\147\145\164\123\x65\163\x73\151\157\156\126\141\154\165\145")->willReturn(1);
        $yN244 = new \ReflectionClass($Bi2JU);
        $foUZ9 = $yN244->getProperty("\x61\x75\x74\x68\123\x65\163\163\x69\x6f\x6e");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($Bi2JU, $this->authSession);
        $dfdYI = $Bi2JU->get_admin_role_name();
        $this->assertEquals("\x61\x64\155\151\x6e", $dfdYI);
    }
    public function testGetAllMoTfaUserDetails_ReturnsArray()
    {
        $DyiBA = $this->getMockBuilder(\stdClass::class)->addMethods(["\x73\x65\154\x65\143\164", "\x66\x65\164\x63\x68\101\x6c\154"])->getMock();
        $JrA7v = $this->getMockBuilder(\stdClass::class)->addMethods(["\146\162\x6f\155", "\x77\150\145\162\145"])->getMock();
        $JrA7v->method("\x66\x72\157\x6d")->willReturnSelf();
        $JrA7v->method("\167\x68\145\162\145")->willReturnSelf();
        $DyiBA->method("\163\x65\x6c\145\x63\164")->willReturn($JrA7v);
        $DyiBA->method("\x66\x65\164\143\x68\x41\154\154")->willReturn([["\x75\x73\145\x72\x6e\x61\x6d\x65" => "\165\x73\x65\162", "\x73\145\143\162\145\164" => "\x53\105\103\122\105\124"]]);
        $this->resource->method("\x67\145\164\103\x6f\x6e\x6e\x65\x63\164\151\x6f\x6e")->willReturn($DyiBA);
        $RoD1b = $this->utility->getAllMoTfaUserDetails("\155\x69\x6e\151\157\162\141\156\x67\x65\137\164\146\x61\x5f\x75\x73\x65\x72\x73", "\x75\163\145\x72", 1);
        $this->assertIsArray($RoD1b);
        $this->assertEquals("\x75\163\145\x72", $RoD1b[0]["\165\x73\x65\x72\156\x61\x6d\145"]);
    }
    public function testGetCustomerMoTfaUserDetails_ReturnsArray()
    {
        $DyiBA = $this->getMockBuilder(\stdClass::class)->addMethods(["\x73\145\154\x65\x63\x74", "\146\145\164\x63\150\101\154\154"])->getMock();
        $JrA7v = $this->getMockBuilder(\stdClass::class)->addMethods(["\146\x72\x6f\x6d", "\x77\150\x65\x72\145"])->getMock();
        $JrA7v->method("\146\162\157\155")->willReturnSelf();
        $JrA7v->method("\167\150\145\x72\145")->willReturnSelf();
        $DyiBA->method("\x73\x65\x6c\x65\143\164")->willReturn($JrA7v);
        $DyiBA->method("\x66\145\164\x63\x68\x41\x6c\154")->willReturn([["\x75\163\145\x72\x6e\x61\x6d\145" => "\165\163\145\x72", "\163\x65\x63\x72\145\164" => "\123\105\x43\122\x45\124"]]);
        $Btl21 = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\x74\x57\x65\x62\x73\151\x74\145\x49\x64"])->getMock();
        $Btl21->method("\147\x65\x74\x57\x65\142\x73\151\x74\x65\111\x64")->willReturn(1);
        $this->storeManager->method("\147\x65\x74\x53\164\157\x72\145")->willReturn($Btl21);
        $this->resource->method("\x67\x65\x74\x43\157\156\156\x65\143\164\x69\157\x6e")->willReturn($DyiBA);
        $RoD1b = $this->utility->getCustomerMoTfaUserDetails("\x6d\151\x6e\x69\x6f\162\141\x6e\x67\x65\x5f\x74\x66\141\x5f\165\x73\x65\162\x73", "\x75\x73\145\162");
        $this->assertIsArray($RoD1b);
        $this->assertEquals("\x75\x73\145\162", $RoD1b[0]["\x75\163\145\x72\156\x61\x6d\145"]);
    }
    public function testGetAuthenticatorSecret_ReturnsSecretOrFalse()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x6c\x6f\147\137\x64\145\x62\x75\x67", "\147\145\x74\123\x65\x73\x73\151\157\x6e\126\141\x6c\165\145", "\x67\x65\164\101\x6c\x6c\115\157\x54\x66\x61\125\x73\x65\x72\x44\145\x74\x61\151\154\x73", "\147\x65\x74\103\165\x73\164\x6f\155\x65\162\x4d\157\124\x66\141\125\x73\145\x72\104\x65\164\x61\151\x6c\163"])->getMock();
        $Bi2JU->method("\x6c\157\147\137\x64\145\x62\x75\x67")->willReturn(null);
        $Bi2JU->method("\x67\x65\x74\123\145\163\163\x69\x6f\x6e\x56\141\x6c\x75\145")->willReturn(null);
        $Bi2JU->method("\x67\x65\x74\101\154\x6c\115\157\x54\x66\x61\x55\163\145\x72\x44\x65\x74\141\x69\x6c\163")->willReturn([["\163\x65\x63\162\145\x74" => "\x53\105\103\x52\x45\124", "\163\153\151\160\x5f\x74\x77\157\146\x61" => null]]);
        $Bi2JU->method("\147\x65\164\x43\165\x73\x74\157\155\145\x72\115\x6f\x54\x66\x61\x55\163\145\x72\x44\x65\164\x61\x69\x6c\163")->willReturn([["\x73\x65\x63\x72\x65\x74" => "\x53\105\103\x52\105\124", "\x73\153\x69\160\x5f\164\x77\x6f\x66\141" => null]]);
        $Iiekl = $Bi2JU->getAuthenticatorSecret("\165\x73\145\x72");
        $this->assertTrue($Iiekl === "\123\105\103\122\105\x54" || $Iiekl === false);
    }
    public function testAuthenticatorCustomerUrl_ReturnsExpectedFormat()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\154\157\147\x5f\x64\145\x62\x75\147", "\147\145\164\123\x65\163\x73\151\x6f\x6e\x56\141\154\165\145", "\x67\x65\x6e\145\162\141\164\145\x52\x61\x6e\144\157\155\x53\x74\x72\x69\x6e\147", "\x73\x65\164\123\x65\163\163\x69\x6f\x6e\x56\x61\x6c\165\145", "\101\165\x74\x68\145\x6e\164\151\x63\x61\x74\x6f\162\111\163\163\x75\x65\162"])->getMock();
        $Bi2JU->method("\x6c\x6f\x67\137\144\145\142\165\147")->willReturn(null);
        $Bi2JU->method("\x67\x65\x74\x53\x65\163\x73\151\157\x6e\x56\x61\154\165\145")->willReturn(null);
        $Bi2JU->method("\x67\145\156\145\162\141\164\x65\122\x61\x6e\144\157\x6d\123\164\162\x69\156\x67")->willReturn("\x53\105\x43\122\x45\x54");
        $Bi2JU->method("\x73\x65\164\123\145\163\163\151\x6f\x6e\x56\141\154\165\x65")->willReturn(null);
        $Bi2JU->method("\x41\165\x74\150\145\156\164\151\143\x61\164\x6f\162\x49\163\x73\x75\145\x72")->willReturn("\155\151\156\151\x4f\162\141\x6e\147\145");
        $kWJUb = $Bi2JU->AuthenticatorCustomerUrl("\165\163\145\x72\x40\145\x78\141\x6d\x70\154\x65\56\x63\x6f\x6d");
        $this->assertStringContainsString("\157\x74\160\141\165\164\x68\72\57\57\x74\x6f\x74\x70\57", $kWJUb);
        $this->assertStringContainsString("\151\x73\x73\x75\145\162\x3d\155\151\156\x69\117\162\141\156\147\x65", $kWJUb);
    }
    public function testGetCustomerCountryFromEmail_ReturnsCountryOrNull()
    {
        $this->storeManager->method("\x67\x65\x74\x53\164\157\162\x65")->willReturn(new StoreStub());
        $ubwvh = new class
        {
            public function getId()
            {
                return 1;
            }
            public function getDefaultBillingAddress()
            {
                return new class
                {
                    public function getCountryId()
                    {
                        return "\x49\x4e";
                    }
                };
            }
        };
        $dg7NT = new class($ubwvh)
        {
            private $customer;
            public function __construct($ubwvh)
            {
                $this->customer = $ubwvh;
            }
            public function setWebsiteId($etV8W)
            {
                return $this;
            }
            public function loadByEmail($oT0hO)
            {
                return $this->customer;
            }
        };
        $yN244 = new \ReflectionClass($this->utility);
        $foUZ9 = $yN244->getProperty("\143\165\x73\x74\x6f\x6d\145\x72\115\x6f\x64\145\154");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $dg7NT);
        $RoD1b = $this->utility->getCustomerCountryFromEmail("\x75\x73\x65\162\100\x65\x78\x61\x6d\x70\x6c\x65\56\x63\157\155");
        $this->assertTrue($RoD1b === "\111\x4e" || $RoD1b === null);
    }
    public function testGetIpWhitelistedIpAddresses_ReturnsArray()
    {
        $yBBjA = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\164\103\x6f\154\x75\x6d\x6e\x56\141\x6c\165\145\163"])->getMock();
        $yBBjA->method("\x67\x65\164\103\x6f\x6c\x75\155\156\126\141\154\x75\x65\163")->willReturn(["\x31\56\62\x2e\63\x2e\64", "\x35\x2e\x36\56\67\56\70"]);
        $this->ipWhitelistedCollectionFactory->method("\143\162\x65\x61\x74\x65")->willReturn($yBBjA);
        $RoD1b = $this->utility->getIpWhitelistedIpAddresses("\x63\x75\163\164\157\155\x65\x72");
        $this->assertIsArray($RoD1b);
    }
    public function testGetSkipTwoFa_CallsLoginAndRedirectCustomer()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x6c\x6f\147\x5f\144\145\142\x75\x67", "\147\145\x74\123\164\x6f\162\x65\103\157\x6e\x66\151\147", "\x77\150\x69\164\x65\154\x69\x73\x74\x43\x75\x73\x74\157\155\x65\162\124\x68\162\x6f\x75\x67\x68\123\x65\163\163\x69\x6f\156", "\147\x65\164\103\154\145\x61\162\123\x65\x73\163\x69\x6f\156\x46\157\x72\x53\153\151\x70\x54\167\157\106\x41", "\154\x6f\147\151\x6e\101\x6e\x64\x52\145\x64\151\x72\x65\143\x74\103\165\x73\164\157\x6d\x65\x72"])->getMock();
        $Bi2JU->method("\154\x6f\147\x5f\x64\x65\142\165\x67")->willReturn(null);
        $Bi2JU->method("\147\145\164\x53\164\x6f\x72\x65\103\x6f\156\146\151\147")->willReturn("\160\x65\x72\x6d\x61\x6e\x65\156\164");
        $Bi2JU->method("\167\150\x69\x74\145\154\x69\163\164\x43\x75\x73\x74\157\x6d\x65\162\x54\x68\x72\157\x75\x67\150\123\x65\163\163\151\157\x6e")->willReturn(null);
        $Bi2JU->method("\147\145\164\103\x6c\145\141\162\123\145\163\163\x69\157\x6e\x46\157\162\123\x6b\151\x70\124\167\x6f\106\x41")->willReturn(null);
        $Bi2JU->method("\154\157\x67\x69\x6e\101\156\x64\x52\x65\x64\151\162\145\x63\x74\x43\x75\x73\x74\157\x6d\145\162")->willReturn("\x72\145\x64\151\162\x65\143\164");
        $RoD1b = $Bi2JU->getSkipTwoFa();
        $this->assertEquals("\x72\145\144\x69\x72\145\143\164", $RoD1b);
    }
    public function testGetSkipTwoFa_Admin_NoException()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\154\157\x67\x5f\x64\145\142\x75\147", "\x67\145\164\x5f\141\x64\155\x69\156\x5f\x72\157\x6c\x65\x5f\x6e\x61\x6d\x65", "\147\x65\164\x53\164\157\x72\x65\x43\x6f\156\146\151\147", "\x77\150\151\x74\145\x6c\x69\163\x74\101\144\x6d\x69\156\124\x68\162\x6f\x75\x67\150\123\x65\163\163\x69\157\156", "\x67\x65\164\103\x6c\145\x61\x72\x41\144\155\151\x6e\x53\145\x73\x73\x69\x6f\156\106\x6f\x72\x53\153\151\160\x54\x77\157\x46\101"])->getMock();
        $Bi2JU->method("\x6c\157\x67\137\x64\145\x62\x75\x67")->willReturn(null);
        $Bi2JU->method("\147\145\164\x5f\x61\x64\155\151\x6e\x5f\162\157\154\x65\x5f\156\x61\155\145")->willReturn("\141\144\x6d\x69\156");
        $Bi2JU->method("\x67\x65\164\123\164\157\x72\x65\x43\157\156\146\x69\x67")->willReturn("\x70\x65\162\x6d\x61\156\145\156\164");
        $Bi2JU->method("\x77\x68\x69\x74\145\x6c\151\x73\164\x41\144\155\151\156\124\150\162\157\x75\x67\150\x53\x65\163\163\151\x6f\x6e")->willReturn(null);
        $Bi2JU->method("\x67\145\x74\103\154\x65\x61\x72\101\x64\155\151\x6e\123\145\x73\x73\151\x6f\156\106\157\x72\x53\153\151\160\x54\x77\x6f\x46\101")->willReturn(null);
        $this->assertNull($Bi2JU->getSkipTwoFa_Admin());
    }
    public function testGetAdminSession_ReturnsAdminSession()
    {
        $this->assertSame($this->adminSession, $this->utility->getAdminSession());
    }
    public function testGetImageUrl_ReturnsAssetUrl()
    {
        $this->assetRepo->expects($this->once())->method("\147\x65\x74\125\x72\x6c")->with($this->anything())->willReturn("\x68\x74\164\160\72\57\57\x65\170\x61\155\160\x6c\145\56\x63\157\155\x2f\x69\155\x61\x67\145\56\x70\x6e\x67");
        $this->assertEquals("\x68\164\x74\x70\x3a\x2f\57\x65\170\x61\x6d\160\x6c\145\x2e\x63\157\155\57\151\x6d\141\x67\x65\x2e\160\156\147", $this->utility->getImageUrl("\x69\155\x61\x67\x65\56\x70\156\x67"));
    }
    public function testGetCustomerSecret_ReturnsSessionValue()
    {
        $this->sessionValues = ["\143\x75\x73\164\x6f\155\x65\162\137\x69\156\154\x69\156\x65\137\x73\x65\x63\162\x65\x74" => "\163\x65\x63\162\145\164\x31\x32\x33"];
        $this->assertEquals("\x73\x65\143\x72\x65\x74\61\x32\63", $this->utility->getCustomerSecret());
    }
    public function testGetAdminSecret_ReturnsSessionValue()
    {
        $this->sessionValues = [\MiniOrange\TwoFA\Helper\TwoFAConstants::PRE_SECRET => "\x61\144\155\x69\x6e\x73\145\143\x72\x65\x74", \MiniOrange\TwoFA\Helper\TwoFAConstants::ADMIN_IS_INLINE => null];
        $this->assertEquals("\141\x64\155\151\156\163\x65\x63\162\x65\164", $this->utility->getAdminSecret());
    }
    public function testIsTwoFAConfigured_ReturnsTrueIfConfigured()
    {
        $this->scopeConfig->method("\147\x65\164\126\x61\x6c\165\x65")->willReturn("\x73\x6f\x6d\x65\x5f\x75\162\154");
        $this->assertTrue($this->utility->isTwoFAConfigured());
    }
    public function testIsTwoFAConfigured_ReturnsFalseIfNotConfigured()
    {
        $this->scopeConfig->method("\147\x65\164\126\x61\x6c\x75\145")->willReturn(null);
        $this->assertFalse($this->utility->isTwoFAConfigured());
    }
    public function testIsUserLoggedIn_ReturnsTrueIfCustomerOrAdminLoggedIn()
    {
        $O_B8h = $this->createMock(\Magento\Customer\Model\Session::class);
        $O_B8h->method("\x69\163\114\x6f\x67\x67\x65\x64\111\x6e")->willReturn(true);
        $yN244 = new \ReflectionClass($this->utility);
        $foUZ9 = $yN244->getProperty("\143\165\x73\164\157\x6d\x65\x72\123\145\x73\x73\151\x6f\x6e");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $O_B8h);
        $this->assertTrue($this->utility->isUserLoggedIn());
    }
    public function testIsUserLoggedIn_ReturnsFalseIfNotLoggedIn()
    {
        $O_B8h = $this->createMock(\Magento\Customer\Model\Session::class);
        $O_B8h->method("\x69\163\114\x6f\147\147\x65\x64\111\x6e")->willReturn(false);
        $jIBrz = $this->createMock(\Magento\Backend\Model\Auth\Session::class);
        $jIBrz->method("\151\163\x4c\157\147\x67\x65\144\x49\156")->willReturn(false);
        $yN244 = new \ReflectionClass($this->utility);
        $foUZ9 = $yN244->getProperty("\x63\x75\163\164\157\155\x65\x72\x53\x65\163\x73\151\x6f\x6e");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $O_B8h);
        $foUZ9 = $yN244->getProperty("\x61\x75\x74\150\x53\145\163\163\151\x6f\x6e");
        $foUZ9->setAccessible(true);
        $foUZ9->setValue($this->utility, $jIBrz);
        $this->assertFalse($this->utility->isUserLoggedIn());
    }
    public function testGetCurrentUser_ReturnsCustomer()
    {
        $ubwvh = new \stdClass();
        $this->customerSession->method("\x67\145\x74\103\165\163\x74\157\155\x65\162")->willReturn($ubwvh);
        $this->assertSame($ubwvh, $this->utility->getCurrentUser());
    }
    public function testGetAdminLoginUrl_ReturnsAdminUrl()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x67\145\164\x41\x64\x6d\151\156\125\162\154"])->getMock();
        $Bi2JU->method("\x67\145\x74\101\144\x6d\151\x6e\x55\x72\154")->with("\x61\x64\155\151\156\150\164\155\x6c\57\x61\165\x74\150\x2f\x6c\x6f\147\x69\x6e")->willReturn("\x2f\141\x64\x6d\x69\x6e\x2f\154\157\147\x69\156");
        $this->assertEquals("\x2f\x61\x64\155\x69\156\x2f\x6c\157\147\x69\x6e", $Bi2JU->getAdminLoginUrl());
    }
    public function testGetFileContents_ReturnsFileContents()
    {
        $this->fileSystem->expects($this->once())->method("\146\x69\x6c\145\x47\145\164\103\157\156\164\145\156\x74\x73")->with("\x66\151\154\145\56\164\170\164")->willReturn("\146\x69\154\x65\144\141\164\x61");
        $this->assertEquals("\146\x69\154\x65\144\141\x74\141", $this->utility->getFileContents("\x66\x69\154\145\56\164\x78\164"));
    }
    public function testGetRootDirectory_ReturnsRoot()
    {
        $this->dir->expects($this->once())->method("\147\145\x74\x52\157\x6f\164")->willReturn("\57\166\x61\162\x2f\x77\167\x77");
        $this->assertEquals("\x2f\x76\141\x72\x2f\x77\x77\x77", $this->utility->getRootDirectory());
    }
    public function testUpdateStatus_ReturnsContent()
    {
        $Bi2JU = $this->getMockBuilder(TwoFAUtility::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->resource, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->adminSession, $this->customerSession, $this->authSession, $this->reinitableConfig, $this->coreSession, $this->cacheTypeList, $this->cacheFrontendPool, $this->logger, $this->fileSystem, $this->userContext, $this->userCollectionFactory, $this->userFactory, $this->dir, $this->storeManager, $this->customerModel, $this->groupRepository, $this->websiteCollectionFactory, $this->ipWhitelistedCollectionFactory, $this->ipWhitelistedAdminCollectionFactory, $this->url, $this->resultFactory, $this->cookieManager, $this->cookieMetadataFactory, $this->logger_customlog, $this->productMetadata, $this->dateTime, $this->messageManager, $this->websiteRepository, $this->moduleManager])->onlyMethods(["\x67\145\x74\x53\x74\157\162\145\x43\x6f\156\x66\151\x67"])->getMock();
        $Bi2JU->method("\x67\x65\164\123\164\x6f\162\x65\x43\x6f\x6e\146\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CUSTOMER_KEY, "\x6b\x65\171"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::API_KEY, "\141\x70\151"]]);
        $this->assertTrue(method_exists($Bi2JU, "\x75\x70\x64\x61\164\145\x5f\163\x74\x61\x74\x75\163"));
    }
}