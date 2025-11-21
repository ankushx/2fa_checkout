<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Customer;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Stdlib\Cookie\PublicCookieMetadata;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\Api\Data\GroupInterface;
use Magento\Store\Api\Data\StoreInterface;
use MiniOrange\TwoFA\Controller\Customer\Index;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Magento\Customer\Model\Data\Customer;
use Magento\Framework\App\ViewInterface;
use Magento\Framework\App\ObjectManager as MagentoObjectManager;
class IndexTest extends TestCase
{
    private $controller;
    private $context;
    private $request;
    private $twoFAUtility;
    private $resultFactory;
    private $url;
    private $storeManager;
    private $messageManager;
    private $cookieManager;
    private $cookieMetadataFactory;
    private $publicCookieMetadata;
    private $customerSession;
    private $groupRepository;
    private $objectManager;
    private $magentoObjectManager;
    protected function setUp() : void
    {
        $this->objectManager = new ObjectManager($this);
        $this->context = $this->getMockBuilder(Context::class)->disableOriginalConstructor()->getMock();
        $this->request = $this->getMockBuilder(RequestInterface::class)->setMethods(["\x67\145\164\x50\157\163\x74\x56\x61\x6c\165\145"])->getMockForAbstractClass();
        $this->twoFAUtility = $this->getMockBuilder(TwoFAUtility::class)->disableOriginalConstructor()->getMock();
        $this->twoFAUtility->method("\147\x65\x74\127\x65\x62\x73\151\x74\x65\x4f\162\123\164\157\162\x65\x42\x61\163\x65\x64\x4f\156\124\x72\x69\x61\x6c\123\164\141\164\x75\163")->willReturn(1);
        $this->resultFactory = $this->getMockBuilder(ResultFactory::class)->disableOriginalConstructor()->getMock();
        $this->url = $this->getMockBuilder(UrlInterface::class)->getMockForAbstractClass();
        $this->storeManager = $this->getMockBuilder(StoreManagerInterface::class)->getMockForAbstractClass();
        $this->messageManager = $this->getMockBuilder(ManagerInterface::class)->getMockForAbstractClass();
        $this->cookieManager = $this->getMockBuilder(CookieManagerInterface::class)->getMockForAbstractClass();
        $this->publicCookieMetadata = $this->getMockBuilder(PublicCookieMetadata::class)->disableOriginalConstructor()->getMock();
        $this->publicCookieMetadata->expects($this->any())->method("\x73\145\x74\104\x75\162\x61\x74\151\x6f\x6e\117\156\x65\x59\x65\141\x72")->willReturnSelf();
        $this->publicCookieMetadata->expects($this->any())->method("\163\x65\x74\x50\141\164\x68")->with("\57")->willReturnSelf();
        $this->publicCookieMetadata->expects($this->any())->method("\163\x65\x74\x48\x74\x74\160\x4f\x6e\x6c\x79")->with(false)->willReturnSelf();
        $this->cookieMetadataFactory = $this->getMockBuilder(CookieMetadataFactory::class)->disableOriginalConstructor()->getMock();
        $this->cookieMetadataFactory->expects($this->any())->method("\143\x72\145\x61\x74\x65\120\165\x62\154\x69\x63\x43\x6f\x6f\153\x69\x65\115\x65\164\141\144\x61\164\141")->willReturn($this->publicCookieMetadata);
        $this->customerSession = $this->getMockBuilder(Session::class)->disableOriginalConstructor()->getMock();
        $this->groupRepository = $this->getMockBuilder(GroupRepositoryInterface::class)->getMockForAbstractClass();
        $this->magentoObjectManager = $this->getMockBuilder(MagentoObjectManager::class)->disableOriginalConstructor()->getMock();
        $f1haV = new \ReflectionClass(MagentoObjectManager::class);
        $BOsO0 = $f1haV->getProperty("\137\x69\x6e\x73\x74\141\x6e\x63\145");
        $BOsO0->setAccessible(true);
        $BOsO0->setValue(null, $this->magentoObjectManager);
        $this->context->expects($this->any())->method("\147\145\164\x4d\x65\x73\x73\x61\147\145\115\x61\156\x61\x67\145\x72")->willReturn($this->messageManager);
        $this->context->expects($this->any())->method("\x67\x65\x74\x52\x65\163\x75\x6c\164\x46\141\143\x74\157\x72\x79")->willReturn($this->resultFactory);
        $this->controller = new Index($this->context, $this->request, $this->twoFAUtility, $this->resultFactory, $this->url, $this->storeManager, $this->messageManager, $this->cookieManager, $this->cookieMetadataFactory);
    }
    protected function tearDown() : void
    {
        $f1haV = new \ReflectionClass(MagentoObjectManager::class);
        $BOsO0 = $f1haV->getProperty("\137\151\x6e\x73\x74\x61\156\143\x65");
        $BOsO0->setAccessible(true);
        $BOsO0->setValue(null, null);
    }
    public function testExecuteResetTwoFAWithSingleActiveMethod()
    {
        $Iqqf7 = ["\x65\155\141\151\154" => "\164\145\163\x74\x40\145\x78\141\x6d\160\x6c\x65\x2e\143\157\x6d", "\x67\x72\157\x75\160\137\x69\144" => 1];
        $Bx71o = 1;
        $F0B9N = "\x47\x65\x6e\x65\162\141\x6c";
        $UOHfh = $this->getMockBuilder(Customer::class)->disableOriginalConstructor()->setMethods(["\147\x65\164\x44\x61\164\x61"])->getMock();
        $UOHfh->expects($this->once())->method("\x67\x65\x74\x44\141\x74\x61")->willReturn($Iqqf7);
        $this->customerSession->expects($this->once())->method("\147\x65\x74\x43\x75\163\164\157\x6d\145\x72")->willReturn($UOHfh);
        $this->magentoObjectManager->expects($this->exactly(2))->method("\147\x65\x74")->willReturnMap([["\115\141\147\x65\156\x74\157\134\103\165\x73\x74\x6f\x6d\145\x72\134\115\x6f\144\x65\154\x5c\123\x65\x73\x73\151\157\x6e", $this->customerSession], ["\115\141\147\x65\x6e\164\157\134\103\165\x73\x74\157\x6d\145\162\134\x41\x70\x69\x5c\107\x72\x6f\x75\160\122\145\160\157\x73\151\164\x6f\x72\171\x49\156\x74\145\x72\146\141\x63\x65", $this->groupRepository]]);
        $RnHL3 = $this->getMockBuilder(StoreInterface::class)->getMockForAbstractClass();
        $RnHL3->method("\x67\145\x74\127\x65\142\163\x69\164\x65\x49\x64")->willReturn($Bx71o);
        $this->storeManager->method("\x67\x65\164\x53\164\157\x72\x65")->willReturn($RnHL3);
        $EbyGL = $this->getMockBuilder(GroupInterface::class)->getMockForAbstractClass();
        $EbyGL->expects($this->once())->method("\147\x65\164\x43\157\x64\145")->willReturn($F0B9N);
        $this->groupRepository->expects($this->once())->method("\x67\145\x74\x42\x79\111\144")->with(1)->willReturn($EbyGL);
        $this->cookieManager->expects($this->once())->method("\x73\x65\164\120\165\142\154\x69\143\103\157\x6f\x6b\151\x65")->with("\155\157\x75\163\x65\x72\156\141\x6d\145", "\164\x65\163\x74\100\x65\170\x61\155\x70\154\x65\x2e\143\157\155", $this->publicCookieMetadata);
        $this->request->expects($this->once())->method("\x67\x65\x74\120\157\x73\x74\126\x61\x6c\x75\x65")->willReturn(["\162\x65\x73\x65\164\137\164\x77\x6f\x66\x61" => true]);
        $this->twoFAUtility->expects($this->once())->method("\147\x65\164\101\x6c\154\x4d\157\x54\x66\141\x55\x73\145\162\x44\145\164\x61\x69\154\163")->with("\155\x69\x6e\x69\157\162\141\156\147\x65\137\164\x66\141\x5f\165\163\x65\162\x73", "\x74\x65\x73\x74\100\x65\170\141\x6d\160\x6c\x65\56\143\x6f\x6d", $Bx71o)->willReturn([["\x69\144" => 1]]);
        $this->twoFAUtility->expects($this->exactly(2))->method("\147\145\164\123\164\157\x72\145\103\157\x6e\x66\x69\147")->willReturnMap([[TwoFAConstants::NUMBER_OF_CUSTOMER_METHOD . $F0B9N . $Bx71o, 1], [TwoFAConstants::ACTIVE_METHOD . $F0B9N . $Bx71o, "\133\x22\145\155\141\151\x6c\x22\x5d"]]);
        $hxdp7 = "\x68\164\x74\160\72\57\x2f\x65\x78\x61\x6d\x70\154\145\56\x63\157\x6d\57\x6d\x6f\164\167\157\x66\141\57\x6d\x6f\x63\165\163\x74\157\x6d\145\x72";
        $this->url->expects($this->once())->method("\x67\x65\164\x55\x72\154")->with("\x6d\157\164\x77\x6f\146\x61\57\155\x6f\x63\165\x73\x74\x6f\155\145\162")->willReturn($hxdp7);
        $hQ7Hr = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)->disableOriginalConstructor()->getMock();
        $hQ7Hr->expects($this->once())->method("\163\x65\x74\125\162\x6c")->with($hxdp7 . "\x3f\155\157\160\157\163\x74\x6f\x70\x74\x69\157\x6e\75\x6d\x65\164\x68\157\x64\x26\151\x6e\x6c\x69\156\x65\137\x6f\x6e\145\137\155\x65\x74\150\x6f\144\75\x31\46\x6d\x69\x6e\151\157\162\x61\156\147\145\164\146\x61\x5f\155\145\x74\150\157\x64\75\x65\155\141\151\154");
        $this->resultFactory->expects($this->once())->method("\143\162\145\x61\x74\x65")->with(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->willReturn($hQ7Hr);
        $qLwfy = $this->controller->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $qLwfy);
    }
    public function testExecuteResetTwoFAWithNoActiveMethods()
    {
        $Iqqf7 = ["\x65\x6d\x61\151\154" => "\164\145\x73\x74\100\145\x78\x61\x6d\x70\154\145\56\x63\157\155", "\147\x72\x6f\x75\160\137\151\x64" => 1];
        $Bx71o = 1;
        $F0B9N = "\x47\145\156\145\x72\141\x6c";
        $UOHfh = $this->getMockBuilder(Customer::class)->disableOriginalConstructor()->setMethods(["\147\145\164\104\141\x74\x61"])->getMock();
        $UOHfh->expects($this->once())->method("\x67\145\x74\104\141\x74\x61")->willReturn($Iqqf7);
        $this->customerSession->expects($this->once())->method("\x67\145\x74\x43\x75\x73\x74\x6f\x6d\x65\162")->willReturn($UOHfh);
        $EbyGL = $this->getMockBuilder(GroupInterface::class)->getMockForAbstractClass();
        $EbyGL->expects($this->once())->method("\x67\x65\164\x43\x6f\144\145")->willReturn($F0B9N);
        $this->groupRepository->expects($this->once())->method("\x67\145\x74\x42\x79\111\144")->with(1)->willReturn($EbyGL);
        $this->magentoObjectManager->expects($this->exactly(2))->method("\147\x65\x74")->willReturnMap([["\115\x61\147\145\156\164\x6f\x5c\x43\165\x73\164\x6f\x6d\145\x72\x5c\115\157\144\145\154\134\123\x65\x73\163\151\x6f\x6e", $this->customerSession], ["\x4d\x61\147\145\x6e\164\x6f\x5c\103\x75\163\x74\157\155\145\162\134\101\x70\151\x5c\x47\x72\x6f\x75\x70\122\145\160\157\163\151\164\x6f\x72\171\x49\156\164\145\x72\x66\x61\143\145", $this->groupRepository]]);
        $RnHL3 = $this->getMockBuilder(StoreInterface::class)->getMockForAbstractClass();
        $RnHL3->method("\x67\145\x74\x57\145\142\163\151\164\x65\111\144")->willReturn($Bx71o);
        $this->storeManager->method("\147\x65\x74\x53\164\x6f\162\x65")->willReturn($RnHL3);
        $this->cookieManager->expects($this->once())->method("\x73\145\x74\x50\165\142\154\x69\143\103\157\x6f\153\151\x65")->with("\x6d\157\x75\x73\145\162\156\x61\155\145", "\164\x65\163\x74\x40\x65\170\x61\155\x70\154\x65\x2e\143\157\155", $this->publicCookieMetadata);
        $this->request->expects($this->once())->method("\x67\145\x74\x50\x6f\163\164\x56\x61\154\165\x65")->willReturn(["\x72\x65\x73\145\164\137\164\x77\157\146\141" => true]);
        $this->twoFAUtility->expects($this->once())->method("\x67\x65\x74\101\x6c\154\x4d\157\124\x66\141\x55\163\x65\162\x44\x65\164\x61\151\154\x73")->willReturn([]);
        $this->twoFAUtility->expects($this->once())->method("\x67\x65\x74\123\x74\157\x72\145\103\x6f\156\x66\151\147")->with(TwoFAConstants::NUMBER_OF_CUSTOMER_METHOD . $F0B9N . $Bx71o)->willReturn(null);
        $this->messageManager->expects($this->once())->method("\141\x64\144\x45\162\162\157\x72\115\145\x73\x73\141\147\x65")->with("\x59\x6f\165\x20\143\141\x6e\156\157\164\40\143\x6f\x6e\x66\151\147\165\x72\x65\40\x54\167\157\x20\x46\141\x63\x74\x6f\x72\x20\101\x75\164\150\x65\x6e\x74\151\143\x61\164\x69\157\156\40\155\x65\164\x68\x6f\144\x2e");
        $XRwKR = "\x68\164\x74\x70\x3a\x2f\x2f\145\170\x61\155\x70\x6c\x65\56\x63\157\155\57\x6d\x6f\164\167\x6f\146\141\57\143\x75\163\164\157\155\x65\x72";
        $this->url->expects($this->once())->method("\147\x65\x74\x55\162\154")->willReturn($XRwKR);
        $hQ7Hr = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)->disableOriginalConstructor()->getMock();
        $hQ7Hr->expects($this->once())->method("\163\x65\164\x55\x72\154")->with($XRwKR);
        $this->resultFactory->expects($this->once())->method("\143\162\145\141\x74\145")->with(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->willReturn($hQ7Hr);
        $qLwfy = $this->controller->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $qLwfy);
    }
    public function testExecuteResetKBAWithValidConfig()
    {
        $Iqqf7 = ["\145\155\141\151\154" => "\164\145\163\164\x40\145\170\141\155\160\x6c\x65\56\x63\157\155", "\x67\162\157\x75\160\137\x69\x64" => 1];
        $Bx71o = 1;
        $UOHfh = $this->getMockBuilder(Customer::class)->disableOriginalConstructor()->setMethods(["\x67\145\164\104\141\164\141"])->getMock();
        $UOHfh->expects($this->once())->method("\x67\x65\x74\104\141\164\141")->willReturn($Iqqf7);
        $this->customerSession->expects($this->once())->method("\x67\145\x74\x43\165\163\x74\x6f\155\x65\162")->willReturn($UOHfh);
        $this->magentoObjectManager->expects($this->exactly(1))->method("\147\145\164")->with("\115\x61\147\145\x6e\x74\x6f\x5c\103\x75\x73\164\x6f\x6d\x65\x72\x5c\115\157\144\x65\154\134\123\x65\163\163\x69\157\156")->willReturn($this->customerSession);
        $RnHL3 = $this->getMockBuilder(StoreInterface::class)->getMockForAbstractClass();
        $RnHL3->method("\147\x65\164\127\x65\x62\x73\x69\164\145\111\144")->willReturn($Bx71o);
        $this->storeManager->method("\147\x65\164\123\164\157\x72\145")->willReturn($RnHL3);
        $this->request->expects($this->once())->method("\x67\145\164\x50\x6f\163\164\126\141\154\x75\x65")->willReturn(["\x72\x65\163\x65\x74\x5f\x6b\142\x61" => true]);
        $this->twoFAUtility->expects($this->once())->method("\x67\x65\x74\x41\x6c\154\x4d\157\x54\146\141\125\x73\145\162\104\x65\x74\x61\151\154\x73")->willReturn([["\x69\144" => 1]]);
        $this->twoFAUtility->expects($this->exactly(3))->method("\x67\145\x74\x53\164\x6f\162\145\x43\157\x6e\x66\x69\x67")->willReturnMap([["\x6b\142\141\x5f\x6d\x65\x74\150\157\144\x31", 1], ["\161\165\145\163\x74\x69\157\156\137\x73\145\164\137\x73\164\x72\151\x6e\147\x31\x31", "\121\165\x65\163\x74\x69\x6f\156\x20\x31"], ["\161\x75\x65\x73\164\x69\157\156\137\x73\x65\164\x5f\x73\164\x72\x69\x6e\x67\x32\61", "\x51\x75\145\163\164\x69\x6f\x6e\40\62"]]);
        $hxdp7 = "\x68\x74\x74\160\72\57\x2f\145\x78\x61\x6d\160\154\145\56\x63\x6f\155\57\155\x6f\164\167\x6f\x66\141\x2f\155\x6f\143\x75\163\x74\157\155\x65\x72";
        $this->url->expects($this->once())->method("\147\x65\164\125\x72\154")->with("\x6d\157\164\x77\157\146\141\x2f\155\157\x63\x75\163\x74\x6f\155\x65\x72")->willReturn($hxdp7);
        $hQ7Hr = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)->disableOriginalConstructor()->getMock();
        $hQ7Hr->expects($this->once())->method("\163\145\x74\x55\x72\154")->with($hxdp7 . "\77\155\x6f\x6f\160\x74\151\x6f\156\x3d\x69\x6e\166\157\153\145\x49\156\154\151\x6e\145\46\x73\164\x65\160\75\113\x42\x41\137\x51\x75\145\163\164\151\157\x6e")->willReturnSelf();
        $this->resultFactory->expects($this->once())->method("\x63\162\145\141\164\x65")->with(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->willReturn($hQ7Hr);
        $qLwfy = $this->controller->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $qLwfy);
    }
    public function testExecuteWithNoPostData()
    {
        $this->request->expects($this->once())->method("\x67\x65\164\x50\x6f\163\164\x56\141\x6c\165\145")->willReturn([]);
        $UOHfh = $this->getMockBuilder(Customer::class)->disableOriginalConstructor()->setMethods(["\147\x65\164\104\x61\x74\141"])->getMock();
        $UOHfh->expects($this->once())->method("\147\x65\164\104\141\x74\141")->willReturn(["\x65\x6d\x61\x69\154" => "\164\x65\x73\164\x40\x65\170\141\x6d\x70\154\145\x2e\x63\157\155", "\x67\x72\x6f\165\x70\137\x69\x64" => 1]);
        $this->customerSession->expects($this->once())->method("\147\x65\164\103\165\x73\164\x6f\x6d\x65\162")->willReturn($UOHfh);
        $this->magentoObjectManager->expects($this->exactly(1))->method("\x67\x65\x74")->with("\115\x61\x67\145\x6e\x74\157\134\103\165\x73\164\157\155\145\162\x5c\115\157\x64\145\x6c\134\123\145\x73\163\151\x6f\156")->willReturn($this->customerSession);
        $RnHL3 = $this->getMockBuilder(StoreInterface::class)->getMockForAbstractClass();
        $RnHL3->expects($this->any())->method("\x67\x65\164\127\x65\x62\163\x69\x74\x65\x49\144")->willReturn(1);
        $this->storeManager->method("\x67\145\164\123\x74\x6f\162\145")->willReturn($RnHL3);
        $L0Ijp = $this->getMockBuilder(ViewInterface::class)->getMockForAbstractClass();
        $L0Ijp->expects($this->once())->method("\x6c\x6f\x61\x64\x4c\141\171\157\x75\164");
        $L0Ijp->expects($this->once())->method("\162\145\x6e\x64\x65\x72\114\141\x79\x6f\x75\x74");
        $f1haV = new \ReflectionClass($this->controller);
        $c4aUg = $f1haV->getProperty("\137\x76\x69\145\x77");
        $c4aUg->setAccessible(true);
        $c4aUg->setValue($this->controller, $L0Ijp);
        $this->controller->execute();
    }
    public function testExecuteResetKBAWithInvalidConfig()
    {
        $Iqqf7 = ["\x65\x6d\x61\151\x6c" => "\164\145\163\x74\100\145\170\x61\x6d\x70\154\x65\x2e\143\x6f\x6d", "\147\162\x6f\x75\160\137\x69\x64" => 1];
        $Bx71o = 1;
        $UOHfh = $this->getMockBuilder(Customer::class)->disableOriginalConstructor()->setMethods(["\147\x65\164\104\141\164\x61"])->getMock();
        $UOHfh->expects($this->once())->method("\x67\145\164\x44\141\164\141")->willReturn($Iqqf7);
        $this->customerSession->expects($this->once())->method("\147\x65\164\103\x75\163\x74\157\x6d\145\x72")->willReturn($UOHfh);
        $this->magentoObjectManager->expects($this->exactly(1))->method("\147\145\164")->with("\x4d\x61\147\x65\x6e\x74\157\x5c\103\165\x73\x74\157\x6d\x65\162\134\x4d\157\x64\x65\154\134\123\x65\x73\x73\x69\x6f\x6e")->willReturn($this->customerSession);
        $RnHL3 = $this->getMockBuilder(StoreInterface::class)->getMockForAbstractClass();
        $RnHL3->expects($this->any())->method("\x67\x65\x74\x57\145\x62\x73\x69\x74\145\111\x64")->willReturn(1);
        $this->storeManager->method("\x67\145\x74\123\x74\x6f\x72\145")->willReturn($RnHL3);
        $this->request->expects($this->once())->method("\x67\x65\164\120\157\x73\164\x56\x61\154\165\145")->willReturn(["\162\x65\x73\145\164\137\153\142\x61" => true]);
        $this->twoFAUtility->expects($this->once())->method("\147\145\164\101\x6c\154\115\x6f\124\x66\x61\x55\163\x65\162\104\x65\x74\141\151\x6c\163")->willReturn([["\x69\x64" => 1]]);
        $this->twoFAUtility->expects($this->exactly(3))->method("\x67\x65\x74\x53\x74\x6f\162\x65\x43\157\x6e\x66\151\x67")->willReturnMap([["\153\142\141\137\155\x65\x74\x68\x6f\x64\x31", null], ["\x71\165\145\163\164\x69\157\x6e\x5f\x73\145\164\137\163\164\x72\151\156\x67\x31\61", null], ["\x71\x75\x65\x73\164\151\157\156\137\163\x65\164\137\163\164\x72\151\x6e\x67\x32\x31", null]]);
        $this->messageManager->expects($this->once())->method("\141\x64\144\x45\162\162\x6f\162\x4d\145\x73\163\x61\147\x65")->with("\131\157\x75\40\x63\x61\x6e\x6e\157\164\40\x63\157\156\x66\151\x67\x75\x72\145\40\113\x42\101\x20\102\141\143\x6b\165\x70\x20\x6d\x65\164\x68\157\x64\56");
        $hxdp7 = "\x68\164\x74\x70\72\x2f\57\145\x78\x61\155\x70\x6c\145\56\143\x6f\x6d\57\155\x6f\x74\x77\x6f\x66\141\x2f\x63\x75\x73\164\x6f\155\145\162";
        $this->url->expects($this->once())->method("\x67\145\x74\x55\162\154")->with("\155\157\x74\x77\x6f\x66\141\57\x63\165\163\x74\157\x6d\x65\162")->willReturn($hxdp7);
        $hQ7Hr = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)->disableOriginalConstructor()->getMock();
        $hQ7Hr->expects($this->once())->method("\x73\145\x74\125\x72\154")->with($hxdp7)->willReturnSelf();
        $this->resultFactory->expects($this->once())->method("\x63\x72\x65\141\x74\145")->with(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->willReturn($hQ7Hr);
        $qLwfy = $this->controller->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $qLwfy);
    }
}