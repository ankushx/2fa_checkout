<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Mocustomer;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\ResponseFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Session;
use Magento\Store\Api\Data\StoreInterface;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use MiniOrange\TwoFA\Helper\MiniOrangeInline;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\TwoFACustomerRegistration;
use MiniOrange\TwoFA\Controller\Mocustomer\Index;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
class IndexTest extends TestCase
{
    private $controller;
    private $context;
    private $pageFactory;
    private $messageManager;
    private $responseFactory;
    private $request;
    private $twoFAUtility;
    private $miniOrangeInline;
    private $customEmail;
    private $customerModel;
    private $customerSession;
    private $resultFactory;
    private $url;
    private $storeManager;
    private $twoFACustomerRegistration;
    protected function setUp() : void
    {
        $this->context = $this->getMockBuilder(Context::class)->disableOriginalConstructor()->getMock();
        $this->pageFactory = $this->getMockBuilder(PageFactory::class)->disableOriginalConstructor()->getMock();
        $this->messageManager = $this->getMockBuilder(ManagerInterface::class)->getMockForAbstractClass();
        $this->responseFactory = $this->getMockBuilder(ResponseFactory::class)->disableOriginalConstructor()->getMock();
        $this->request = $this->getMockBuilder(RequestInterface::class)->setMethods(["\x67\145\x74\x50\157\163\164\x56\x61\154\x75\145", "\147\x65\x74\120\x61\x72\x61\155\163"])->getMockForAbstractClass();
        $this->twoFAUtility = $this->getMockBuilder(TwoFAUtility::class)->disableOriginalConstructor()->getMock();
        $this->miniOrangeInline = $this->getMockBuilder(MiniOrangeInline::class)->disableOriginalConstructor()->getMock();
        $this->customEmail = $this->getMockBuilder(CustomEmail::class)->disableOriginalConstructor()->getMock();
        $this->customerModel = $this->getMockBuilder(Customer::class)->disableOriginalConstructor()->setMethods(["\163\x65\164\x57\x65\142\x73\151\164\x65\111\144", "\x6c\157\141\x64\102\x79\105\155\x61\x69\x6c", "\x67\x65\164\111\x64"])->getMock();
        $this->customerSession = $this->getMockBuilder(Session::class)->disableOriginalConstructor()->getMock();
        $this->resultFactory = $this->getMockBuilder(ResultFactory::class)->disableOriginalConstructor()->getMock();
        $this->url = $this->getMockBuilder(UrlInterface::class)->getMockForAbstractClass();
        $this->storeManager = $this->getMockBuilder(StoreManagerInterface::class)->getMockForAbstractClass();
        $this->twoFACustomerRegistration = $this->getMockBuilder(TwoFACustomerRegistration::class)->disableOriginalConstructor()->getMock();
        $this->context->expects($this->any())->method("\x67\145\164\x4d\145\163\163\x61\x67\145\115\x61\156\x61\x67\x65\162")->willReturn($this->messageManager);
        $this->context->expects($this->any())->method("\147\x65\x74\x52\145\163\x75\154\164\106\141\x63\x74\157\x72\x79")->willReturn($this->resultFactory);
        $this->context->expects($this->any())->method("\147\145\164\125\162\x6c")->willReturn($this->url);
        $this->controller = new Index($this->context, $this->pageFactory, $this->messageManager, $this->responseFactory, $this->request, $this->twoFAUtility, $this->miniOrangeInline, $this->customEmail, $this->customerModel, $this->customerSession, $this->resultFactory, $this->url, $this->storeManager, $this->twoFACustomerRegistration);
    }
    public function testExecuteWithNoUsername()
    {
        $this->request->expects($this->once())->method("\147\x65\x74\120\157\163\x74\x56\141\x6c\x75\x65")->willReturn([]);
        $this->request->expects($this->once())->method("\x67\x65\164\x50\141\162\x61\x6d\163")->willReturn([]);
        $this->twoFAUtility->expects($this->once())->method("\x67\x65\x74\123\145\x73\x73\x69\157\x6e\126\x61\x6c\x75\145")->with("\x6d\x6f\165\x73\x65\x72\x6e\141\x6d\x65")->willReturn(null);
        $this->messageManager->expects($this->once())->method("\x61\144\144\x45\162\162\157\x72\115\x65\x73\x73\x61\147\x65")->with("\123\157\x6d\145\x74\150\151\x6e\x67\40\167\145\x6e\164\x20\x77\162\x6f\x6e\147\x2e\x20\120\x6c\145\141\163\145\x20\x74\x72\171\40\154\x6f\x67\147\151\x6e\x67\x20\x69\156\x20\141\147\141\x69\x6e\56");
        $DdQbu = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)->disableOriginalConstructor()->getMock();
        $DdQbu->expects($this->once())->method("\x73\145\x74\120\x61\164\x68")->with("\143\x75\163\164\157\155\145\162\57\x61\x63\143\157\x75\156\164")->willReturnSelf();
        $this->resultFactory->expects($this->once())->method("\x63\x72\145\141\164\x65")->with(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->willReturn($DdQbu);
        $V8vvl = $this->controller->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $V8vvl);
    }
    public function testExecuteWithEmailMethod()
    {
        $ho34U = "\x74\145\x73\164\100\x65\170\141\x6d\x70\x6c\145\56\143\x6f\x6d";
        $EtuIr = 1;
        $FTcTU = ["\x6d\x6f\160\x6f\x73\x74\x6f\160\x74\151\157\156" => "\x6d\145\164\150\157\x64", "\155\151\x6e\151\157\162\x61\x6e\x67\145\164\x66\141\137\x6d\x65\x74\150\157\144" => "\x4f\117\x45"];
        $this->request->expects($this->once())->method("\x67\x65\x74\x50\157\163\164\126\x61\x6c\x75\145")->willReturn($FTcTU);
        $this->request->expects($this->once())->method("\147\x65\164\120\x61\162\141\x6d\x73")->willReturn([]);
        $zNalz = $this->getMockBuilder(StoreInterface::class)->setMethods(["\147\145\164\x42\x61\163\x65\x55\162\154", "\147\x65\164\127\145\142\163\x69\164\x65\111\144"])->getMockForAbstractClass();
        $zNalz->expects($this->once())->method("\147\x65\164\102\141\163\x65\125\162\154")->willReturn("\x68\x74\x74\160\x3a\57\x2f\145\170\141\x6d\x70\154\x65\x2e\x63\x6f\155\57");
        $this->storeManager->expects($this->once())->method("\147\145\164\123\x74\157\x72\145")->willReturn($zNalz);
        $this->twoFAUtility->expects($this->once())->method("\x67\x65\164\x53\145\163\163\151\157\156\126\141\x6c\165\x65")->with("\155\157\165\163\x65\x72\156\141\155\145")->willReturn($ho34U);
        $this->miniOrangeInline->expects($this->once())->method("\x74\x68\151\162\x64\x53\x74\x65\160\x53\165\142\155\x69\x74")->with($this->twoFAUtility, $ho34U)->willReturn("\x73\165\x63\143\x65\x73\163");
        $DdQbu = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)->disableOriginalConstructor()->getMock();
        $this->resultFactory->expects($this->once())->method("\x63\162\x65\x61\164\x65")->with(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->willReturn($DdQbu);
        $V8vvl = $this->controller->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $V8vvl);
    }
    public function testSkipKBAConfiguration()
    {
        $ho34U = "\x74\145\163\x74\100\145\170\141\155\x70\x6c\145\56\143\x6f\155";
        $EtuIr = 1;
        $this->request->expects($this->once())->method("\147\x65\164\120\x6f\x73\164\126\x61\x6c\165\x65")->willReturn(["\163\153\151\160\x5f\x6b\x62\x61\137\143\x6f\x6e\x66\x69\147" => true]);
        $this->request->expects($this->once())->method("\x67\145\164\x50\x61\x72\141\155\x73")->willReturn([]);
        $this->twoFAUtility->expects($this->once())->method("\x67\145\x74\x53\145\163\163\x69\157\156\126\x61\154\165\145")->with("\x6d\x6f\165\163\x65\x72\x6e\141\x6d\145")->willReturn($ho34U);
        $zNalz = $this->getMockBuilder(StoreInterface::class)->setMethods(["\x67\145\x74\127\145\142\x73\x69\164\145\111\144"])->getMockForAbstractClass();
        $zNalz->expects($this->once())->method("\147\x65\164\x57\x65\x62\x73\151\x74\x65\x49\x64")->willReturn($EtuIr);
        $this->storeManager->expects($this->once())->method("\147\x65\164\x53\164\157\x72\x65")->willReturn($zNalz);
        $this->customerModel->expects($this->once())->method("\163\145\164\x57\145\142\x73\x69\x74\x65\111\x64")->with($EtuIr)->willReturnSelf();
        $this->customerModel->expects($this->once())->method("\x6c\x6f\x61\x64\102\x79\105\155\141\x69\x6c")->with($ho34U)->willReturnSelf();
        $this->customerModel->expects($this->once())->method("\147\x65\164\111\x64")->willReturn(1);
        $this->customerSession->expects($this->once())->method("\163\x65\x74\103\x75\x73\x74\157\x6d\x65\162\x41\163\x4c\157\147\x67\145\144\111\156")->with($this->customerModel)->willReturnSelf();
        $DdQbu = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)->disableOriginalConstructor()->getMock();
        $DdQbu->expects($this->once())->method("\x73\145\x74\120\x61\164\150")->with("\x63\x75\x73\x74\x6f\x6d\x65\162\57\x61\x63\x63\157\165\x6e\x74")->willReturnSelf();
        $this->resultFactory->expects($this->once())->method("\x63\x72\145\x61\164\x65")->with(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->willReturn($DdQbu);
        $V8vvl = $this->controller->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $V8vvl);
    }
    public function testSkipKBAConfigurationWithInvalidCustomer()
    {
        $ho34U = "\x74\145\x73\x74\x40\145\x78\141\155\x70\154\145\x2e\143\157\155";
        $EtuIr = 1;
        $this->request->expects($this->once())->method("\x67\x65\164\120\157\x73\x74\126\141\x6c\x75\145")->willReturn(["\x73\x6b\151\160\x5f\x6b\x62\x61\x5f\143\x6f\156\146\x69\x67" => true]);
        $this->request->expects($this->once())->method("\x67\x65\164\x50\141\162\x61\155\163")->willReturn([]);
        $this->twoFAUtility->expects($this->once())->method("\147\x65\x74\x53\145\x73\163\151\157\x6e\126\141\x6c\165\145")->with("\155\x6f\x75\x73\x65\x72\x6e\141\155\x65")->willReturn($ho34U);
        $zNalz = $this->getMockBuilder(StoreInterface::class)->setMethods(["\147\145\164\x57\x65\x62\x73\151\x74\145\x49\144"])->getMockForAbstractClass();
        $zNalz->expects($this->once())->method("\x67\x65\164\x57\145\x62\163\151\x74\145\111\144")->willReturn($EtuIr);
        $this->storeManager->expects($this->once())->method("\x67\145\x74\x53\x74\157\162\145")->willReturn($zNalz);
        $this->customerModel->expects($this->once())->method("\x73\145\x74\127\x65\x62\163\151\x74\145\111\x64")->with($EtuIr)->willReturnSelf();
        $this->customerModel->expects($this->once())->method("\154\157\x61\144\102\x79\105\155\x61\151\154")->with($ho34U)->willReturnSelf();
        $this->customerModel->expects($this->once())->method("\147\145\x74\x49\x64")->willReturn(null);
        $this->messageManager->expects($this->once())->method("\x61\144\144\x45\x72\x72\x6f\162\x4d\x65\163\x73\141\147\145")->with("\x53\157\x6d\145\x74\x68\151\156\x67\40\167\x65\x6e\164\40\167\x72\x6f\x6e\x67\x2e\x20\120\154\x65\x61\x73\145\x20\x74\x72\171\x20\154\157\x67\147\x69\156\x67\x20\x69\156\x20\141\x67\141\x69\x6e\x2e");
        $DdQbu = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)->disableOriginalConstructor()->getMock();
        $DdQbu->expects($this->once())->method("\x73\x65\x74\x50\x61\164\150")->with("\x63\165\163\x74\x6f\x6d\x65\162\x2f\x61\143\143\x6f\x75\156\164")->willReturnSelf();
        $this->resultFactory->expects($this->once())->method("\143\162\x65\x61\x74\145")->with(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->willReturn($DdQbu);
        $V8vvl = $this->controller->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $V8vvl);
    }
    public function testValidateReturningUserOtpSuccess()
    {
        $ho34U = "\x74\x65\163\x74\100\x65\x78\141\x6d\x70\154\x65\56\x63\157\x6d";
        $EtuIr = 1;
        $FTcTU = ["\155\157\160\x6f\163\x74\x6f\160\x74\x69\157\x6e" => "\165\x73\x65\x72\166\x61\x6c\157\x74\160", "\157\164\x70" => "\x31\62\x33\64\65\66"];
        $this->request->expects($this->once())->method("\147\145\164\120\157\x73\x74\126\141\154\x75\145")->willReturn($FTcTU);
        $this->request->expects($this->once())->method("\147\145\164\x50\x61\162\x61\155\163")->willReturn([]);
        $this->twoFAUtility->expects($this->once())->method("\x67\145\164\123\145\163\x73\x69\157\x6e\126\141\x6c\165\145")->with("\x6d\157\x75\163\x65\x72\x6e\141\155\x65")->willReturn($ho34U);
        $zNalz = $this->getMockBuilder(StoreInterface::class)->setMethods(["\147\x65\164\127\145\142\x73\151\x74\145\111\x64"])->getMockForAbstractClass();
        $zNalz->expects($this->once())->method("\147\x65\x74\127\x65\142\163\x69\164\145\x49\x64")->willReturn($EtuIr);
        $this->storeManager->expects($this->once())->method("\147\145\164\x53\x74\x6f\x72\x65")->willReturn($zNalz);
        $this->miniOrangeInline->expects($this->once())->method("\124\x46\101\x56\x61\154\x69\x64\x61\164\x65")->willReturn(["\x73\x74\x61\x74\x75\x73" => "\123\125\x43\x43\105\x53\x53"]);
        $this->customerModel->expects($this->once())->method("\163\x65\164\127\145\x62\x73\151\164\x65\x49\144")->with($EtuIr)->willReturnSelf();
        $this->customerModel->expects($this->once())->method("\154\x6f\141\x64\x42\x79\105\x6d\141\x69\154")->with($ho34U)->willReturnSelf();
        $this->customerModel->expects($this->once())->method("\x67\x65\164\111\144")->willReturn(1);
        $this->customerSession->expects($this->once())->method("\163\145\164\103\x75\x73\x74\157\155\145\162\x41\163\x4c\157\x67\x67\x65\144\111\156")->with($this->customerModel);
        $DdQbu = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)->disableOriginalConstructor()->getMock();
        $DdQbu->expects($this->once())->method("\163\x65\164\x50\x61\x74\150")->with("\143\x75\163\164\157\x6d\145\162\57\141\143\x63\x6f\165\156\164")->willReturnSelf();
        $this->resultFactory->expects($this->once())->method("\x63\162\x65\x61\x74\x65")->with(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->willReturn($DdQbu);
        $V8vvl = $this->controller->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $V8vvl);
    }
    public function testValidateReturningUserOtpMaxAttemptsExceeded()
    {
        $ho34U = "\164\x65\163\164\100\x65\x78\141\x6d\x70\x6c\x65\x2e\143\157\x6d";
        $FTcTU = ["\x6d\157\160\157\x73\164\157\160\x74\x69\157\x6e" => "\x75\x73\x65\162\x76\x61\154\157\x74\x70", "\157\x74\160" => "\x31\x32\x33\x34\65\x36"];
        $this->request->expects($this->once())->method("\147\x65\x74\120\x6f\163\164\x56\x61\154\x75\145")->willReturn($FTcTU);
        $this->request->expects($this->once())->method("\147\145\164\120\x61\x72\x61\155\x73")->willReturn([]);
        $this->twoFAUtility->expects($this->once())->method("\147\145\164\123\145\163\x73\151\x6f\156\126\141\154\165\145")->with("\x6d\x6f\165\163\145\x72\x6e\x61\155\145")->willReturn($ho34U);
        $this->miniOrangeInline->expects($this->once())->method("\124\106\101\x56\x61\x6c\151\144\141\164\145")->willReturn(["\163\164\x61\x74\x75\x73" => "\106\x41\x49\114\x45\104\137\x41\x54\124\105\115\x50\x54\123", "\x6d\x65\x73\163\x61\147\x65" => "\115\x61\x78\151\155\x75\155\x20\x61\x74\x74\x65\x6d\x70\164\x73\40\x72\x65\141\143\x68\145\x64"]);
        $this->messageManager->expects($this->once())->method("\x61\144\144\x45\x72\162\157\162\115\145\163\x73\141\x67\145")->with("\x4d\141\x78\x69\155\x75\155\x20\x4f\124\x50\x20\x61\x74\x74\x65\x6d\160\x74\x73\x20\x72\145\x61\x63\150\145\x64\56\x20\120\x6c\145\x61\x73\145\x20\154\157\x67\151\156\x20\141\x67\x61\x69\156\x2e");
        $this->twoFAUtility->expects($this->exactly(2))->method("\163\145\164\x53\145\163\163\151\157\x6e\126\x61\154\165\x65")->withConsecutive(["\x66\141\151\154\145\144\x5f\x6f\x74\x70\x5f\x61\164\x74\x65\x6d\160\164\163", null], ["\157\x74\160\137\145\x78\x70\151\162\x79\137\x74\x69\155\x65", null]);
        $DdQbu = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)->disableOriginalConstructor()->getMock();
        $DdQbu->expects($this->once())->method("\x73\145\x74\x50\141\164\x68")->with("\143\165\x73\x74\x6f\155\145\x72\57\141\x63\143\157\x75\156\164")->willReturnSelf();
        $this->resultFactory->expects($this->once())->method("\x63\162\x65\141\x74\145")->with(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->willReturn($DdQbu);
        $V8vvl = $this->controller->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $V8vvl);
    }
    public function testValidateFirstTimeUserOtpWithKBAEnabled()
    {
        $ho34U = "\x74\x65\x73\x74\100\145\x78\x61\x6d\160\154\x65\56\x63\x6f\155";
        $EtuIr = 1;
        $FTcTU = ["\155\157\160\x6f\163\164\x6f\160\x74\x69\157\156" => "\155\157\166\141\x6c\157\164\160", "\163\141\166\145\x73\164\x65\160" => "\117\x4f\x45", "\x6f\x74\160" => "\61\62\x33\x34\65\66"];
        $this->request->expects($this->once())->method("\147\145\x74\x50\157\163\x74\126\141\154\165\145")->willReturn($FTcTU);
        $this->request->expects($this->once())->method("\x67\145\x74\x50\141\x72\x61\155\163")->willReturn([]);
        $this->twoFAUtility->expects($this->once())->method("\147\x65\x74\123\145\163\163\151\157\156\126\141\154\x75\145")->with("\x6d\x6f\165\x73\145\x72\x6e\x61\x6d\145")->willReturn($ho34U);
        $zNalz = $this->getMockBuilder(StoreInterface::class)->getMockForAbstractClass();
        $zNalz->expects($this->once())->method("\x67\x65\x74\x57\145\142\163\151\164\145\111\144")->willReturn($EtuIr);
        $this->storeManager->expects($this->once())->method("\147\145\164\x53\x74\157\162\x65")->willReturn($zNalz);
        $this->miniOrangeInline->expects($this->once())->method("\160\x61\x67\145\106\x6f\165\162\126\x61\x6c\x69\144\x61\x74\x65")->willReturn(["\x73\x74\141\164\x75\163" => "\123\x55\103\103\105\x53\x53"]);
        $this->twoFAUtility->expects($this->exactly(3))->method("\x67\x65\164\x53\x74\x6f\x72\145\103\x6f\156\146\x69\147")->willReturnMap([["\153\142\141\x5f\155\x65\164\150\157\144" . $EtuIr, true], ["\161\165\145\x73\x74\x69\157\x6e\x5f\x73\x65\x74\x5f\163\164\x72\x69\156\x67\61" . $EtuIr, "\121\165\145\163\164\x69\x6f\x6e\x20\61"], ["\x71\x75\x65\x73\x74\151\x6f\x6e\137\x73\145\164\x5f\x73\x74\x72\x69\x6e\x67\62" . $EtuIr, "\121\165\145\x73\164\x69\157\x6e\40\62"]]);
        $this->url->expects($this->once())->method("\147\x65\164\125\x72\x6c")->with("\x6d\157\164\167\x6f\x66\x61\x2f\155\157\x63\165\x73\x74\x6f\155\145\162")->willReturn("\150\x74\x74\160\x3a\x2f\x2f\145\170\x61\155\x70\154\145\56\x63\157\155\57\155\157\x74\x77\157\146\141\x2f\155\x6f\143\165\x73\164\x6f\155\145\162");
        $DdQbu = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)->disableOriginalConstructor()->getMock();
        $DdQbu->expects($this->once())->method("\163\145\164\x55\162\154")->with($this->stringContains("\x73\164\145\160\x3d\x4b\x42\101\x5f\x51\x75\x65\163\164\x69\x6f\156"))->willReturnSelf();
        $this->resultFactory->expects($this->once())->method("\143\x72\145\141\x74\x65")->with(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->willReturn($DdQbu);
        $V8vvl = $this->controller->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $V8vvl);
    }
    public function testHandleInlineRegistrationWithSMSMethod()
    {
        $ho34U = "\x74\145\163\x74\100\145\x78\141\x6d\x70\x6c\x65\x2e\x63\157\x6d";
        $W6D_w = "\x31\x32\x33\64\x35\x36\x37\70\x39\x30";
        $QXmEU = "\125\x53";
        $FTcTU = ["\155\157\160\157\x73\x74\157\x70\164\151\x6f\x6e" => "\155\x65\x74\150\x6f\144", "\155\x69\156\151\x6f\162\x61\x6e\147\x65\164\x66\141\x5f\x6d\145\x74\150\157\x64" => "\117\x4f\123"];
        $this->request->expects($this->once())->method("\147\x65\x74\120\157\163\x74\126\141\154\165\145")->willReturn($FTcTU);
        $this->request->expects($this->once())->method("\x67\x65\164\x50\x61\x72\x61\155\x73")->willReturn([]);
        $this->twoFAUtility->expects($this->once())->method("\x67\x65\164\123\x65\163\x73\x69\x6f\156\x56\141\154\x75\145")->with("\155\x6f\x75\x73\x65\162\156\141\155\x65")->willReturn($ho34U);
        $this->twoFAUtility->expects($this->once())->method("\147\145\164\103\x75\x73\164\x6f\155\145\x72\x50\150\157\156\145\106\x72\157\155\105\x6d\141\x69\x6c")->with($ho34U)->willReturn($W6D_w);
        $this->twoFAUtility->expects($this->once())->method("\x67\x65\164\x43\165\163\164\x6f\x6d\x65\x72\103\x6f\x75\x6e\x74\x72\x79\x46\162\157\x6d\105\155\141\151\x6c")->with($ho34U)->willReturn($QXmEU);
        $this->miniOrangeInline->expects($this->once())->method("\164\x68\151\162\x64\x53\164\x65\x70\x53\x75\x62\155\151\x74")->willReturn("\x68\164\164\x70\x3a\x2f\x2f\x65\x78\141\x6d\x70\x6c\x65\56\143\x6f\155\x2f\x72\145\x64\x69\x72\x65\143\164");
        $this->miniOrangeInline->expects($this->once())->method("\x70\141\147\x65\106\157\x75\x72\103\150\x61\154\x6c\x65\156\x67\145")->willReturn(["\163\x74\x61\x74\x75\x73" => "\123\125\103\x43\x45\x53\123", "\x6d\145\163\x73\x61\x67\x65" => "\117\124\x50\40\163\145\x6e\x74\x20\x73\165\143\143\x65\x73\x73\146\165\x6c\x6c\171"]);
        $DdQbu = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)->disableOriginalConstructor()->getMock();
        $DdQbu->expects($this->once())->method("\x73\x65\164\125\x72\154")->willReturnSelf();
        $this->resultFactory->expects($this->once())->method("\143\x72\145\x61\x74\145")->with(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->willReturn($DdQbu);
        $V8vvl = $this->controller->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $V8vvl);
    }
    public function testHandleInlineRegistrationWithSMSMethodFailure()
    {
        $ho34U = "\164\145\x73\164\x40\145\170\141\x6d\160\x6c\x65\56\x63\x6f\155";
        $W6D_w = "\61\x32\63\x34\65\x36\x37\70\x39\60";
        $QXmEU = "\125\123";
        $FTcTU = ["\155\x6f\160\x6f\x73\164\x6f\160\164\x69\x6f\x6e" => "\155\x65\164\150\x6f\144", "\155\x69\x6e\x69\157\162\x61\156\x67\x65\164\146\141\x5f\x6d\x65\164\150\x6f\x64" => "\x4f\x4f\123"];
        $this->request->expects($this->once())->method("\x67\x65\x74\120\157\163\164\126\141\x6c\165\x65")->willReturn($FTcTU);
        $this->request->expects($this->once())->method("\x67\x65\164\x50\141\162\x61\x6d\163")->willReturn([]);
        $this->twoFAUtility->expects($this->once())->method("\x67\145\164\x53\145\x73\163\151\157\x6e\126\141\x6c\165\x65")->with("\155\x6f\x75\163\x65\x72\x6e\141\x6d\x65")->willReturn($ho34U);
        $this->twoFAUtility->expects($this->once())->method("\x67\145\x74\103\x75\x73\x74\157\155\x65\x72\120\150\157\156\x65\x46\x72\x6f\x6d\105\155\x61\x69\x6c")->with($ho34U)->willReturn($W6D_w);
        $this->twoFAUtility->expects($this->once())->method("\x67\145\164\103\x75\163\x74\x6f\x6d\x65\x72\103\x6f\165\x6e\164\162\171\x46\x72\157\x6d\105\x6d\141\151\x6c")->with($ho34U)->willReturn($QXmEU);
        $this->miniOrangeInline->expects($this->once())->method("\164\x68\x69\162\x64\123\164\145\160\123\165\142\155\151\x74")->willReturn("\x68\164\x74\160\72\57\57\145\170\141\x6d\x70\154\x65\x2e\x63\x6f\155\x2f\x72\x65\x64\151\162\x65\x63\164");
        $this->miniOrangeInline->expects($this->once())->method("\x70\x61\x67\x65\x46\x6f\x75\162\x43\x68\x61\154\154\x65\156\x67\145")->willReturn(["\163\x74\x61\x74\165\163" => "\106\101\111\114\x45\x44", "\155\145\163\x73\141\147\145" => "\106\141\x69\x6c\145\144\x20\x74\157\40\163\x65\x6e\144\40\x4f\124\120"]);
        $this->messageManager->expects($this->once())->method("\x61\x64\144\105\x72\162\x6f\162\115\145\x73\x73\x61\147\x65")->with("\x46\141\x69\154\145\144\40\164\157\x20\x73\145\156\x64\x20\x4f\x54\x50");
        $DdQbu = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)->disableOriginalConstructor()->getMock();
        $DdQbu->expects($this->once())->method("\163\145\164\x50\141\x74\x68")->with("\x63\165\x73\164\157\x6d\145\162\57\x61\143\143\x6f\165\156\164")->willReturnSelf();
        $this->resultFactory->expects($this->once())->method("\x63\x72\145\141\x74\145")->with(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->willReturn($DdQbu);
        $V8vvl = $this->controller->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $V8vvl);
    }
}