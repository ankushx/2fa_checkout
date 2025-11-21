<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper;

use MiniOrange\TwoFA\Helper\Data;
use PHPUnit\Framework\TestCase;
class DataTest extends TestCase
{
    private $scopeConfig;
    private $adminFactory;
    private $customerFactory;
    private $urlInterface;
    private $configWriter;
    private $assetRepo;
    private $helperBackend;
    private $frontendUrl;
    private $dateTime;
    private $messageManager;
    private $dataHelper;
    protected function setUp() : void
    {
        $this->scopeConfig = $this->createMock(\Magento\Framework\App\Config\ScopeConfigInterface::class);
        $this->adminFactory = $this->createMock(\Magento\User\Model\UserFactory::class);
        $this->customerFactory = $this->createMock(\Magento\Customer\Model\CustomerFactory::class);
        $this->urlInterface = $this->createMock(\Magento\Framework\UrlInterface::class);
        $this->configWriter = $this->createMock(\Magento\Framework\App\Config\Storage\WriterInterface::class);
        $this->assetRepo = $this->createMock(\Magento\Framework\View\Asset\Repository::class);
        $this->helperBackend = $this->createMock(\Magento\Backend\Helper\Data::class);
        $this->frontendUrl = $this->createMock(\Magento\Framework\Url::class);
        $this->dateTime = $this->createMock(\Magento\Framework\Stdlib\DateTime\DateTime::class);
        $this->messageManager = $this->getMockBuilder(\Magento\Framework\Message\ManagerInterface::class)->getMock();
        $this->dataHelper = new Data($this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->dateTime);
        $KxfM5 = new \ReflectionClass($this->dataHelper);
        if (!$KxfM5->hasProperty("\x6d\145\x73\x73\x61\x67\x65\x4d\141\156\141\147\x65\x72")) {
            goto knMjl;
        }
        $FPzc8 = $KxfM5->getProperty("\155\145\163\x73\141\147\x65\x4d\141\x6e\x61\x67\145\162");
        $FPzc8->setAccessible(true);
        $FPzc8->setValue($this->dataHelper, $this->messageManager);
        knMjl:
    }
    public function testGetMiniOrangeUrl()
    {
        $this->assertEquals(\MiniOrange\TwoFA\Helper\TwoFAConstants::HOSTNAME, $this->dataHelper->getMiniOrangeUrl());
    }
    public function testGetStoreCustomConfig()
    {
        $this->scopeConfig->expects($this->once())->method("\x67\145\164\x56\141\x6c\165\145")->with("\x66\157\x6f", \Magento\Store\Model\ScopeInterface::SCOPE_STORE)->willReturn("\142\x61\x72");
        $this->assertEquals("\x62\x61\162", $this->dataHelper->getStoreCustomConfig("\146\x6f\x6f"));
    }
    public function testSaveConfigAdmin()
    {
        $mzEAX = $this->getMockBuilder(\stdClass::class)->addMethods(["\x6c\x6f\x61\x64", "\x61\x64\144\104\x61\x74\141", "\x73\145\x74\111\144", "\163\x61\x76\x65"])->getMock();
        $mzEAX->method("\x6c\x6f\x61\144")->willReturnSelf();
        $mzEAX->method("\141\144\x64\x44\141\164\x61")->willReturnSelf();
        $mzEAX->method("\163\x65\x74\x49\144")->willReturnSelf();
        $mzEAX->expects($this->once())->method("\x73\x61\166\145");
        $this->adminFactory->method("\x63\162\145\x61\x74\145")->willReturn($mzEAX);
        $this->dataHelper->saveConfig("\x75\x72\154", "\166\141\x6c", 1, true);
    }
    public function testSaveConfigCustomer()
    {
        $mzEAX = $this->getMockBuilder(\stdClass::class)->addMethods(["\154\x6f\x61\144", "\x61\144\144\x44\141\x74\141", "\163\145\164\x49\144", "\163\x61\x76\145"])->getMock();
        $mzEAX->method("\154\x6f\141\144")->willReturnSelf();
        $mzEAX->method("\x61\144\144\x44\141\x74\x61")->willReturnSelf();
        $mzEAX->method("\x73\145\x74\111\x64")->willReturnSelf();
        $mzEAX->expects($this->once())->method("\163\x61\166\145");
        $this->customerFactory->method("\143\x72\x65\141\164\x65")->willReturn($mzEAX);
        $this->dataHelper->saveConfig("\x75\162\154", "\x76\141\154", 1, false);
    }
    public function testGetAdminStoreConfig()
    {
        $mzEAX = $this->getMockBuilder(\stdClass::class)->addMethods(["\154\x6f\141\x64", "\147\145\x74\104\x61\164\141"])->getMock();
        $mzEAX->method("\x6c\x6f\x61\144")->willReturnSelf();
        $mzEAX->method("\147\145\164\x44\141\164\141")->with("\x66\x6f\157")->willReturn("\x62\141\162");
        $this->adminFactory->method("\x63\x72\145\141\x74\145")->willReturn($mzEAX);
        $this->assertEquals("\x62\141\x72", $this->dataHelper->getAdminStoreConfig("\146\x6f\x6f", 1));
    }
    public function testGetCustomerStoreConfig()
    {
        $mzEAX = $this->getMockBuilder(\stdClass::class)->addMethods(["\x6c\157\141\x64", "\x67\x65\x74\104\x61\x74\x61"])->getMock();
        $mzEAX->method("\154\157\x61\144")->willReturnSelf();
        $mzEAX->method("\x67\145\x74\104\x61\164\x61")->with("\146\x6f\x6f")->willReturn("\x62\x61\x72");
        $this->customerFactory->method("\143\162\x65\141\x74\x65")->willReturn($mzEAX);
        $this->assertEquals("\142\x61\x72", $this->dataHelper->getCustomerStoreConfig("\x66\157\x6f", 1));
    }
    public function testGetImageUrl()
    {
        $this->assetRepo->expects($this->once())->method("\147\145\164\x55\x72\154")->with("\115\x69\156\x69\117\162\141\x6e\x67\x65\137\124\x77\157\106\101\x3a\72\151\x6d\141\x67\145\x73\57\x69\x6d\x67\56\160\x6e\x67")->willReturn("\151\x6d\147\x75\162\154");
        $this->assertEquals("\151\155\147\165\162\x6c", $this->dataHelper->getImageUrl("\x69\x6d\147\x2e\x70\x6e\147"));
    }
    public function testGetUrl()
    {
        $this->urlInterface->expects($this->once())->method("\x67\145\x74\125\x72\x6c")->with("\x72\157\165\x74\x65", ["\x5f\161\x75\x65\162\x79" => ["\146\x6f\157" => "\142\141\x72"]])->willReturn("\165\162\x6c");
        $this->assertEquals("\x75\x72\154", $this->dataHelper->getUrl("\x72\x6f\165\x74\x65", ["\x66\x6f\x6f" => "\142\x61\x72"]));
    }
    public function testGetAdminCssUrl()
    {
        $this->assetRepo->expects($this->once())->method("\x67\145\x74\x55\x72\154")->with("\115\151\156\x69\117\162\141\x6e\x67\x65\137\124\167\x6f\x46\x41\72\x3a\143\163\x73\57\x73\164\171\154\145\56\x63\x73\163", ["\141\162\145\141" => "\x61\x64\155\x69\156\x68\164\x6d\x6c"])->willReturn("\x63\x73\163\x75\162\x6c");
        $this->assertEquals("\143\x73\x73\165\x72\154", $this->dataHelper->getAdminCssUrl("\163\164\x79\x6c\x65\56\x63\163\x73"));
    }
    public function testGetAdminJSUrl()
    {
        $this->assetRepo->expects($this->once())->method("\x67\x65\164\125\x72\154")->with("\x4d\x69\x6e\x69\117\x72\x61\156\147\145\137\x54\x77\157\106\x41\72\72\152\163\x2f\x73\x63\x72\151\x70\164\56\152\x73", ["\141\162\145\141" => "\141\x64\155\151\156\150\164\155\154"])->willReturn("\x6a\x73\x75\162\154");
        $this->assertEquals("\152\163\x75\x72\x6c", $this->dataHelper->getAdminJSUrl("\163\143\x72\x69\x70\x74\56\152\x73"));
    }
    public function testGetResourcePath()
    {
        $t0gBg = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\164\x53\x6f\x75\x72\x63\x65\x46\151\154\145"])->getMock();
        $t0gBg->method("\x67\145\164\123\x6f\165\x72\x63\x65\x46\x69\154\145")->willReturn("\x63\x65\162\x74\x70\141\x74\x68");
        $this->assetRepo->method("\x63\x72\x65\x61\164\145\x41\x73\163\145\x74")->with("\115\151\156\x69\117\x72\x61\x6e\x67\145\x5f\124\167\x6f\x46\101\72\x3a\x63\145\162\164\163\57\x63\145\162\164\x2e\160\145\x6d", ["\x61\x72\145\141" => "\141\144\155\x69\x6e\x68\x74\155\x6c"])->willReturn($t0gBg);
        $this->assertEquals("\143\x65\x72\164\x70\141\164\150", $this->dataHelper->getResourcePath("\x63\145\x72\164\56\160\145\155"));
    }
    public function testGetAdminBaseUrl()
    {
        $this->helperBackend->expects($this->once())->method("\147\145\164\x48\x6f\x6d\145\x50\141\147\x65\125\x72\154")->willReturn("\x61\x64\155\151\156\x75\162\154");
        $this->assertEquals("\141\x64\x6d\151\156\165\162\154", $this->dataHelper->getAdminBaseUrl());
    }
    public function testGetAdminUrl()
    {
        $this->helperBackend->expects($this->once())->method("\x67\x65\x74\125\162\x6c")->with("\x72\x6f\x75\164\x65", ["\x5f\161\165\x65\x72\171" => ["\x66\x6f\x6f" => "\x62\x61\x72"]])->willReturn("\x61\144\155\151\156\x75\162\x6c");
        $this->assertEquals("\141\144\155\x69\156\x75\x72\154", $this->dataHelper->getAdminUrl("\162\157\165\164\x65", ["\x66\x6f\157" => "\142\141\162"]));
    }
    public function testGetAdminSecureUrl()
    {
        $this->helperBackend->expects($this->once())->method("\147\x65\164\125\x72\x6c")->with("\162\157\x75\164\x65", ["\137\163\145\x63\165\x72\x65" => true, "\x5f\161\165\x65\x72\171" => ["\x66\157\x6f" => "\142\x61\x72"]])->willReturn("\163\x65\x63\x75\162\145\x75\x72\154");
        $this->assertEquals("\x73\x65\x63\x75\x72\145\x75\162\154", $this->dataHelper->getAdminSecureUrl("\162\x6f\x75\x74\145", ["\x66\157\157" => "\142\141\x72"]));
    }
    public function testGetCurrentUrl()
    {
        $this->urlInterface->expects($this->once())->method("\x67\x65\x74\x43\x75\x72\162\145\x6e\164\x55\x72\x6c")->willReturn("\x63\x75\162\162\x65\x6e\x74\x75\x72\154");
        $this->assertEquals("\x63\165\162\x72\145\x6e\164\x75\x72\154", $this->dataHelper->getCurrentUrl());
    }
    public function testGetFrontendUrl()
    {
        $this->frontendUrl->expects($this->once())->method("\x67\145\164\x55\x72\154")->with("\x72\157\165\164\x65", ["\x5f\x71\x75\x65\162\x79" => ["\x66\x6f\157" => "\x62\x61\162"]])->willReturn("\x66\x72\x6f\156\164\x65\x6e\x64\165\162\154");
        $this->assertEquals("\146\162\157\x6e\164\145\156\x64\x75\162\154", $this->dataHelper->getFrontendUrl("\162\157\x75\x74\145", ["\146\x6f\x6f" => "\x62\x61\162"]));
    }
    public function testGetBaseUrl()
    {
        $this->urlInterface->expects($this->once())->method("\147\x65\164\102\141\163\145\125\162\x6c")->willReturn("\142\141\163\x65\x75\x72\x6c");
        $this->assertEquals("\x62\x61\x73\145\165\x72\154", $this->dataHelper->getBaseUrl());
    }
    public function testGetStoreConfig()
    {
        $this->scopeConfig->expects($this->once())->method("\147\145\x74\126\141\x6c\x75\x65")->with("\x6d\x69\156\151\157\162\141\x6e\147\x65\57\x54\167\x6f\x46\x41\57\x66\157\157", \Magento\Store\Model\ScopeInterface::SCOPE_STORE)->willReturn("\142\x61\x72");
        $this->assertEquals("\x62\x61\x72", $this->dataHelper->getStoreConfig("\x66\157\157"));
    }
    public function testSetStoreConfig()
    {
        $this->configWriter->expects($this->once())->method("\x73\x61\x76\145")->with("\x6d\151\156\x69\157\162\x61\156\x67\x65\x2f\x54\x77\x6f\106\x41\57\x66\x6f\x6f", "\x62\x61\162");
        $this->dataHelper->setStoreConfig("\146\157\157", "\x62\x61\x72");
    }
    public function testIsTrialExpiredNotExpiredSetsDate()
    {
        $AVRwu = $this->getMockBuilder(\MiniOrange\TwoFA\Helper\Data::class)->setConstructorArgs([$this->scopeConfig, $this->adminFactory, $this->customerFactory, $this->urlInterface, $this->configWriter, $this->assetRepo, $this->helperBackend, $this->frontendUrl, $this->dateTime])->addMethods(["\143\150\x65\x63\x6b\x5f\x6c\x69\143\145\156\163\145\137\160\154\x61\x6e"])->getMock();
        $AVRwu->method("\143\150\x65\x63\153\137\154\x69\143\145\x6e\x73\145\x5f\160\154\x61\x6e")->with(4)->willReturn(true);
        $this->scopeConfig->method("\x67\x65\164\x56\x61\x6c\165\x65")->willReturn(null);
        $this->dateTime->method("\x67\x6d\164\x44\141\164\x65")->willReturn("\x32\x30\x32\x33\55\x30\x31\x2d\60\x31\x20\x30\60\x3a\x30\x30\72\60\60");
        $this->configWriter->expects($this->once())->method("\163\141\166\x65");
        $this->assertFalse($AVRwu->isTrialExpired());
    }
}