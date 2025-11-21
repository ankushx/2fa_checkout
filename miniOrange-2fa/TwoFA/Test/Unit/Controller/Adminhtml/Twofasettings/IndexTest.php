<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Adminhtml\Twofasettings;

use MiniOrange\TwoFA\Controller\Adminhtml\Twofasettings\Index;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
class IndexTest extends TestCase
{
    private $request;
    private $context;
    private $resultPageFactory;
    private $twofautility;
    private $messageManager;
    private $logger;
    private $resultFactory;
    private $customEmail;
    private $customSMS;
    private $resultRedirectFactory;
    private $resultRedirect;
    private $authorization;
    private $indexController;
    protected function setUp() : void
    {
        $this->request = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->context = $this->createMock(\Magento\Backend\App\Action\Context::class);
        $this->resultPageFactory = $this->createMock(\Magento\Framework\View\Result\PageFactory::class);
        $this->twofautility = $this->createMock(\MiniOrange\TwoFA\Helper\TwoFAUtility::class);
        $this->messageManager = $this->createMock(\Magento\Framework\Message\ManagerInterface::class);
        $this->logger = $this->createMock(\Psr\Log\LoggerInterface::class);
        $this->resultFactory = $this->createMock(\Magento\Framework\Controller\ResultFactory::class);
        $this->customEmail = $this->createMock(\MiniOrange\TwoFA\Helper\CustomEmail::class);
        $this->customSMS = $this->createMock(\MiniOrange\TwoFA\Helper\CustomSMS::class);
        $this->resultRedirectFactory = $this->createMock(\Magento\Framework\Controller\Result\RedirectFactory::class);
        $this->resultRedirect = $this->getMockBuilder(\stdClass::class)->addMethods(["\x73\145\164\120\x61\164\150"])->getMock();
        $this->authorization = $this->createMock(\Magento\Framework\AuthorizationInterface::class);
        $this->context->method("\147\145\x74\x4d\x65\x73\x73\x61\147\x65\115\141\156\x61\x67\x65\162")->willReturn($this->messageManager);
        $this->indexController = new Index($this->request, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS);
        $mCx6j = new ReflectionClass($this->indexController);
        foreach (["\x72\x65\163\165\x6c\x74\122\145\x64\x69\x72\145\x63\164\106\141\x63\164\157\162\x79" => $this->resultRedirectFactory, "\x5f\141\x75\x74\x68\x6f\x72\x69\172\141\x74\x69\157\x6e" => $this->authorization, "\154\157\147\x67\x65\x72" => $this->logger] as $p3g1l => $zW0RY) {
            if (!$mCx6j->hasProperty($p3g1l)) {
                goto N9Wv8;
            }
            $v4NDX = $mCx6j->getProperty($p3g1l);
            $v4NDX->setAccessible(true);
            $v4NDX->setValue($this->indexController, $zW0RY);
            N9Wv8:
            EtlbY:
        }
        Ub5la:
    }
    public function testExecutePositiveFlowConfigure()
    {
        $MZH78 = ["\157\160\x74\x69\x6f\156" => "\x54\x66\x61\x4d\x65\164\150\157\x64\x43\x6f\x6e\x66\x69\x67\165\162\x65"];
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)->onlyMethods(["\x67\145\x74\120\157\163\164\126\141\x6c\165\x65", "\x67\145\164\120\141\x72\x61\x6d\x73"])->disableOriginalConstructor()->getMock();
        $myEmK->method("\147\145\x74\x50\157\163\164\126\141\154\x75\x65")->willReturn($MZH78);
        $myEmK->method("\x67\145\164\120\x61\x72\141\x6d\x73")->willReturn([]);
        $this->twofautility->method("\x69\163\103\165\163\164\157\155\145\x72\x52\x65\x67\x69\163\164\145\x72\x65\x64")->willReturn(true);
        $u00sM = $this->getMockRedirect();
        $this->resultFactory->method("\x63\162\x65\141\x74\145")->willReturn($u00sM);
        $E21po = $this->getMockBuilder(Index::class)->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\143\x6f\156\146\151\x67\165\x72\145", "\147\145\164\x52\x65\161\x75\x65\163\x74"])->getMock();
        $E21po->method("\143\157\x6e\x66\151\147\165\x72\x65")->willReturn("\x73\x6f\155\x65\55\x75\x72\154");
        $E21po->method("\x67\145\164\x52\145\x71\x75\145\x73\x74")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($E21po);
        foreach (["\x72\x65\163\165\154\164\122\145\144\x69\162\145\x63\x74\106\141\143\x74\157\x72\171" => $this->resultRedirectFactory, "\137\x61\x75\x74\150\157\x72\x69\x7a\x61\164\x69\157\x6e" => $this->authorization, "\154\x6f\x67\147\145\x72" => $this->logger] as $p3g1l => $zW0RY) {
            if (!$mCx6j->hasProperty($p3g1l)) {
                goto ixEyv;
            }
            $v4NDX = $mCx6j->getProperty($p3g1l);
            $v4NDX->setAccessible(true);
            $v4NDX->setValue($E21po, $zW0RY);
            ixEyv:
            tosKt:
        }
        NXCy6:
        if (!$mCx6j->hasProperty("\162\x65\163\x75\154\x74\x46\141\x63\x74\157\162\x79")) {
            goto ov0kJ;
        }
        $v4NDX = $mCx6j->getProperty("\162\x65\x73\x75\x6c\164\106\141\x63\x74\157\x72\x79");
        $v4NDX->setAccessible(true);
        $v4NDX->setValue($E21po, $this->resultFactory);
        ov0kJ:
        $u00sM->expects($this->once())->method("\163\x65\x74\x55\162\154")->with("\x73\157\x6d\x65\55\x75\x72\x6c");
        $r5SYH = $E21po->execute();
        $this->assertSame($u00sM, $r5SYH);
    }
    public function testExecuteNotRegisteredShowsError()
    {
        $MZH78 = ["\x6f\x70\164\151\x6f\156" => "\x54\146\141\x4d\x65\164\150\x6f\x64\x43\x6f\156\x66\x69\147\165\x72\145"];
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)->onlyMethods(["\147\145\x74\x50\157\x73\164\x56\x61\x6c\165\x65", "\x67\x65\x74\120\141\x72\141\x6d\163"])->disableOriginalConstructor()->getMock();
        $myEmK->method("\147\145\x74\120\157\x73\164\126\x61\154\165\145")->willReturn($MZH78);
        $this->twofautility->method("\151\x73\103\x75\x73\x74\x6f\155\x65\162\122\x65\x67\x69\163\164\145\162\145\x64")->willReturn(false);
        $this->resultRedirectFactory->method("\143\162\145\141\x74\145")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\163\x65\x74\120\141\164\150")->with("\155\157\164\x77\x6f\146\x61\x2f\x61\x63\x63\157\165\x6e\x74\x2f\151\x6e\144\x65\x78")->willReturnSelf();
        $this->messageManager->expects($this->once())->method("\141\x64\x64\x45\x72\x72\x6f\x72\115\x65\163\163\x61\x67\x65");
        $E21po = $this->getMockBuilder(Index::class)->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\147\145\x74\122\145\x71\165\x65\x73\164"])->getMock();
        $E21po->method("\x67\x65\164\122\145\x71\165\x65\x73\x74")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($E21po);
        foreach (["\162\145\x73\165\x6c\164\x52\x65\x64\x69\162\145\143\x74\x46\141\x63\x74\x6f\x72\x79" => $this->resultRedirectFactory, "\x5f\141\165\x74\x68\x6f\x72\x69\172\x61\x74\x69\x6f\x6e" => $this->authorization, "\154\x6f\147\147\145\162" => $this->logger] as $p3g1l => $zW0RY) {
            if (!$mCx6j->hasProperty($p3g1l)) {
                goto r1Mq7;
            }
            $v4NDX = $mCx6j->getProperty($p3g1l);
            $v4NDX->setAccessible(true);
            $v4NDX->setValue($E21po, $zW0RY);
            r1Mq7:
            bph5M:
        }
        x91Sb:
        $r5SYH = $E21po->execute();
        $this->assertSame($this->resultRedirect, $r5SYH);
    }
    public function testExecuteConfigureParamNotInActiveMethods()
    {
        $_SERVER["\x52\105\121\x55\105\x53\x54\x5f\125\x52\111"] = "\57\141\x64\155\151\156\57\x74\145\x73\x74";
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)->onlyMethods(["\x67\x65\x74\x50\157\x73\x74\x56\x61\154\165\x65", "\x67\145\x74\x50\x61\162\x61\155\163"])->disableOriginalConstructor()->getMock();
        $myEmK->method("\x67\x65\x74\120\157\163\x74\x56\141\x6c\x75\x65")->willReturn([]);
        $myEmK->method("\147\x65\164\x50\141\162\141\x6d\x73")->willReturn(["\143\157\x6e\146\151\147\165\x72\145" => "\146\x6f\157"]);
        $this->twofautility->method("\147\x65\x74\137\141\x64\155\151\x6e\137\162\x6f\154\145\x5f\x6e\141\155\x65")->willReturn("\x61\x64\155\x69\x6e");
        $this->twofautility->method("\x67\x65\x74\123\x74\x6f\x72\x65\x43\157\x6e\x66\151\147")->willReturn('');
        $u00sM = $this->getMockRedirect();
        $this->resultFactory->method("\x63\x72\x65\x61\164\x65")->willReturn($u00sM);
        $E21po = $this->getMockBuilder(Index::class)->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\147\x65\x74\122\145\161\x75\145\163\x74"])->getMock();
        $E21po->method("\147\x65\164\122\x65\x71\165\x65\163\164")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($E21po);
        foreach (["\162\x65\x73\165\x6c\164\x52\x65\144\x69\162\145\x63\x74\106\141\x63\164\x6f\162\x79" => $this->resultRedirectFactory, "\137\141\165\x74\150\x6f\162\x69\172\x61\x74\151\157\x6e" => $this->authorization, "\x6c\157\147\x67\145\x72" => $this->logger] as $p3g1l => $zW0RY) {
            if (!$mCx6j->hasProperty($p3g1l)) {
                goto DIFwO;
            }
            $v4NDX = $mCx6j->getProperty($p3g1l);
            $v4NDX->setAccessible(true);
            $v4NDX->setValue($E21po, $zW0RY);
            DIFwO:
            wpJsC:
        }
        VWlF5:
        if (!$mCx6j->hasProperty("\x72\145\x73\x75\x6c\164\x46\141\143\x74\x6f\x72\171")) {
            goto UcE_W;
        }
        $v4NDX = $mCx6j->getProperty("\x72\145\163\x75\154\164\x46\141\143\x74\157\x72\x79");
        $v4NDX->setAccessible(true);
        $v4NDX->setValue($E21po, $this->resultFactory);
        UcE_W:
        $u00sM->expects($this->once())->method("\x73\145\x74\125\162\154");
        $r5SYH = $E21po->execute();
        $this->assertSame($u00sM, $r5SYH);
    }
    public function testExecuteReturnsResultPage()
    {
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)->onlyMethods(["\x67\145\x74\120\x6f\x73\x74\126\x61\154\x75\145", "\x67\145\164\x50\x61\x72\141\155\163"])->disableOriginalConstructor()->getMock();
        $myEmK->method("\x67\x65\x74\120\157\x73\164\126\141\x6c\x75\x65")->willReturn([]);
        $myEmK->method("\147\x65\164\x50\141\x72\141\x6d\163")->willReturn([]);
        $this->resultPageFactory->method("\143\162\145\141\x74\x65")->willReturn($this->getMockResultPage());
        $E21po = $this->getMockBuilder(Index::class)->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\147\145\164\122\145\x71\x75\x65\x73\164"])->getMock();
        $E21po->method("\x67\145\x74\122\145\x71\x75\x65\x73\164")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($E21po);
        foreach (["\x72\x65\163\165\x6c\x74\x52\145\x64\x69\162\145\x63\164\x46\141\143\164\x6f\x72\x79" => $this->resultRedirectFactory, "\137\x61\x75\164\x68\157\x72\x69\172\141\164\151\x6f\156" => $this->authorization, "\x6c\x6f\x67\x67\x65\162" => $this->logger] as $p3g1l => $zW0RY) {
            if (!$mCx6j->hasProperty($p3g1l)) {
                goto CvNxA;
            }
            $v4NDX = $mCx6j->getProperty($p3g1l);
            $v4NDX->setAccessible(true);
            $v4NDX->setValue($E21po, $zW0RY);
            CvNxA:
            QXbPz:
        }
        bNiVL:
        $r5SYH = $E21po->execute();
        $this->assertInstanceOf(\Magento\Framework\View\Result\Page::class, $r5SYH);
    }
    public function testConfigureNotRegistered()
    {
        $this->twofautility->method("\x69\163\103\165\x73\164\157\x6d\x65\162\122\145\147\x69\163\164\145\x72\x65\144")->willReturn(false);
        $this->messageManager->expects($this->once())->method("\x61\x64\x64\x53\x75\x63\x63\x65\x73\163\x4d\x65\x73\163\141\x67\x65");
        $r5SYH = $this->indexController->configure();
        $this->assertNull($r5SYH);
    }
    public function testConfigureRegisteredUserFoundOOE_CustomGatewayEmailEnabled()
    {
        $this->twofautility->method("\x69\163\103\x75\x73\x74\157\155\145\162\122\x65\147\x69\x73\164\x65\x72\145\x64")->willReturn(true);
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\x74\125\x73\145\x72\156\x61\x6d\145"])->getMock();
        $jffoB->method("\x67\x65\x74\125\x73\x65\162\x6e\x61\x6d\x65")->willReturn("\x61\144\155\x69\x6e");
        $this->twofautility->method("\x67\145\x74\103\165\162\162\145\156\x74\x41\144\155\x69\156\125\x73\145\162")->willReturn($jffoB);
        $this->twofautility->method("\x67\145\x74\101\x6c\x6c\x4d\157\x54\x66\141\x55\x73\x65\162\x44\145\164\x61\151\x6c\x73")->willReturn([["\143\x6f\x6e\x66\x69\x67\165\x72\x65\144\x5f\155\x65\x74\150\x6f\x64\163" => "\x4f\x4f\x45", "\145\155\141\151\x6c" => "\x61\144\155\151\x6e\100\145\170\x61\155\160\x6c\x65\56\143\157\155", "\160\x68\157\156\145" => "\61\x32\63\x34\65\x36\x37\70\71\x30", "\143\x6f\x75\156\164\162\x79\x63\157\x64\x65" => "\x39\x31"]]);
        $this->twofautility->method("\x67\145\x74\x53\x74\157\162\145\103\x6f\156\x66\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->customEmail->method("\163\x65\156\144\103\x75\x73\x74\x6f\x6d\147\x61\164\x65\167\141\171\105\155\x61\x69\x6c")->willReturn(["\x73\x74\x61\164\165\163" => "\x53\125\103\103\x45\123\x53", "\164\x78\x49\144" => "\x31"]);
        $this->twofautility->method("\x73\x65\164\x53\145\163\163\151\157\x6e\126\141\154\x75\145");
        $this->twofautility->method("\x6c\x6f\x67\137\x64\x65\x62\x75\147");
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\x67\x65\x74\x50\141\162\x61\155\x73")->willReturn(["\141\x75\164\x68\x54\171\160\145" => "\x4f\x4f\x45", "\145\x6d\141\151\154" => "\141\144\155\x69\x6e\100\145\x78\141\x6d\x70\x6c\145\56\x63\157\155", "\160\150\x6f\x6e\145" => "\61\x32\63\x34\x35\66\x37\x38\71\x30", "\x63\157\165\x6e\x74\162\171\143\x6f\144\145" => "\71\61"]);
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\x67\x65\164\122\x65\x71\x75\x65\x73\164"])->getMock();
        $DUvZF->method("\x67\x65\x74\x52\145\x71\165\145\163\x74")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            fRw09:
        }
        ZEI8J:
        $r5SYH = $DUvZF->configure();
        $this->assertIsString($r5SYH);
        $this->assertStringContainsString("\162\137\163\164\x61\164\165\163\x3d\x53\x55\x43\103\105\x53\x53", $r5SYH);
    }
    public function testConfigureRegisteredUserFoundOOE_CustomGatewayEmailDisabled()
    {
        $this->twofautility->method("\151\163\103\165\163\164\x6f\x6d\145\x72\x52\145\147\151\x73\164\145\x72\145\x64")->willReturn(true);
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\164\x55\163\x65\x72\156\141\155\x65"])->getMock();
        $jffoB->method("\147\145\x74\x55\163\x65\162\156\x61\x6d\x65")->willReturn("\141\x64\155\151\156");
        $this->twofautility->method("\147\145\164\x43\165\x72\x72\145\x6e\x74\x41\144\x6d\151\x6e\x55\x73\x65\x72")->willReturn($jffoB);
        $this->twofautility->method("\147\145\x74\101\x6c\x6c\x4d\157\x54\x66\141\125\x73\145\x72\104\x65\164\x61\151\x6c\x73")->willReturn([["\x63\157\x6e\146\151\147\165\x72\145\144\x5f\x6d\145\x74\x68\157\144\x73" => "\x4f\x4f\x45", "\x65\x6d\141\x69\154" => "\x61\x64\x6d\151\x6e\100\x65\x78\141\x6d\x70\154\x65\x2e\143\x6f\155", "\x70\150\157\156\x65" => "\x31\62\63\64\65\x36\67\x38\x39\60", "\143\x6f\x75\x6e\164\x72\171\143\157\x64\145" => "\x39\x31"]]);
        $this->twofautility->method("\x67\x65\x74\123\x74\157\x72\x65\103\x6f\156\146\151\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\163\x65\164\123\145\x73\x73\x69\157\x6e\126\141\x6c\165\x65");
        $this->twofautility->method("\154\157\x67\137\144\145\142\165\x67");
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\x67\145\164\x50\x61\162\x61\x6d\163")->willReturn(["\x61\165\x74\x68\124\171\x70\145" => "\x4f\x4f\105", "\145\155\x61\151\x6c" => "\x61\144\155\151\156\x40\145\x78\141\155\x70\154\x65\56\143\x6f\155", "\x70\x68\157\156\145" => "\x31\x32\x33\x34\65\66\x37\70\71\60", "\x63\x6f\165\156\164\x72\x79\x63\157\x64\x65" => "\x39\x31"]);
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\147\145\x74\122\145\x71\165\145\163\164"])->getMock();
        $DUvZF->method("\147\145\x74\x52\x65\x71\165\x65\163\164")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            d3yyY:
        }
        oNXfG:
        $r5SYH = $DUvZF->configure();
        $this->assertIsString($r5SYH);
    }
    public function testConfigureRegisteredUserNotFoundSecretPresent()
    {
        $this->twofautility->method("\151\x73\x43\x75\x73\x74\x6f\x6d\x65\162\122\145\147\x69\x73\x74\145\162\145\x64")->willReturn(true);
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\x74\x55\163\x65\162\156\141\x6d\x65"])->getMock();
        $jffoB->method("\x67\x65\164\x55\x73\x65\162\x6e\x61\155\x65")->willReturn("\141\x64\155\151\156");
        $this->twofautility->method("\147\145\x74\x43\x75\x72\162\x65\x6e\164\101\144\x6d\151\156\x55\x73\145\x72")->willReturn($jffoB);
        $this->twofautility->method("\147\145\x74\101\x6c\154\115\157\124\x66\x61\x55\x73\145\x72\x44\145\164\x61\151\154\x73")->willReturn([]);
        $this->twofautility->method("\x67\145\164\123\x65\x73\163\x69\157\x6e\x56\141\x6c\x75\145")->willReturn("\163\x65\143\162\145\164");
        $this->twofautility->method("\163\145\x74\123\145\163\163\x69\157\x6e\x56\141\x6c\165\145");
        $this->twofautility->method("\x67\145\156\x65\x72\x61\164\145\122\141\x6e\x64\157\155\123\x74\162\151\x6e\147")->willReturn("\x73\145\x63\162\145\x74");
        $this->twofautility->method("\x6c\x6f\x67\137\144\145\x62\x75\147");
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\x67\x65\164\120\141\x72\x61\155\163")->willReturn(["\x61\x75\x74\x68\124\171\x70\145" => "\x4f\117\105", "\145\155\141\x69\154" => "\141\144\155\151\x6e\x40\x65\170\141\x6d\x70\154\x65\56\143\157\x6d", "\x70\x68\x6f\x6e\x65" => "\x31\62\63\x34\x35\x36\67\x38\x39\60", "\x63\x6f\x75\156\x74\162\x79\x63\x6f\x64\x65" => "\71\61"]);
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\x67\145\x74\x52\145\161\x75\x65\x73\164"])->getMock();
        $DUvZF->method("\147\x65\x74\x52\x65\x71\x75\145\x73\x74")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            uTYd1:
        }
        t0msV:
        $r5SYH = $DUvZF->configure();
        $this->assertIsString($r5SYH);
    }
    public function testConfigureRegisteredUserNotFoundSecretNotPresent()
    {
        $this->twofautility->method("\x69\163\x43\165\x73\164\x6f\x6d\x65\162\122\145\x67\151\163\164\145\162\x65\144")->willReturn(true);
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\x74\125\x73\x65\x72\156\141\155\145"])->getMock();
        $jffoB->method("\147\145\164\x55\163\145\x72\x6e\141\x6d\x65")->willReturn("\x61\144\155\x69\156");
        $this->twofautility->method("\x67\145\x74\x43\165\x72\x72\x65\x6e\164\101\x64\x6d\151\156\x55\x73\x65\162")->willReturn($jffoB);
        $this->twofautility->method("\x67\145\x74\x41\154\154\115\157\124\146\141\x55\x73\x65\162\x44\145\164\141\x69\154\163")->willReturn([]);
        $this->twofautility->method("\x67\x65\x74\x53\x65\x73\163\x69\157\x6e\126\141\x6c\165\x65")->willReturn(null);
        $this->twofautility->method("\x73\145\x74\x53\x65\163\x73\x69\157\x6e\126\x61\x6c\x75\145");
        $this->twofautility->method("\147\x65\156\145\x72\x61\x74\x65\x52\141\x6e\x64\x6f\155\123\x74\162\151\156\x67")->willReturn("\163\x65\x63\x72\x65\x74");
        $this->twofautility->method("\x6c\157\147\137\144\145\x62\165\x67");
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\147\x65\x74\120\141\162\x61\155\163")->willReturn(["\x61\165\x74\x68\124\x79\160\145" => "\117\117\x45", "\145\x6d\x61\151\154" => "\141\144\155\151\156\100\145\170\141\x6d\x70\x6c\x65\56\x63\x6f\x6d", "\160\150\157\x6e\145" => "\61\x32\x33\64\65\66\67\70\71\60", "\x63\x6f\x75\156\164\162\x79\x63\157\x64\x65" => "\71\x31"]);
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\147\145\x74\122\145\x71\165\x65\x73\x74"])->getMock();
        $DUvZF->method("\147\145\164\122\x65\161\x75\x65\x73\x74")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            PNsxH:
        }
        DfNdr:
        $r5SYH = $DUvZF->configure();
        $this->assertIsString($r5SYH);
    }
    public function testConfigureStepTwo_GoogleAuthenticator_Success()
    {
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\164\125\163\x65\162\x6e\141\x6d\145"])->getMock();
        $jffoB->method("\147\x65\164\125\163\145\x72\156\141\155\x65")->willReturn("\x61\x64\x6d\151\156");
        $this->twofautility->method("\x67\x65\164\103\165\162\x72\145\156\164\101\x64\155\151\x6e\125\163\x65\x72")->willReturn($jffoB);
        $this->twofautility->method("\151\x73\x43\165\163\x74\x6f\155\145\162\x52\x65\x67\x69\x73\x74\x65\x72\x65\144")->willReturn(true);
        $this->twofautility->method("\166\x65\x72\151\146\171\x47\x61\x75\x74\150\x43\x6f\144\145")->willReturn(json_encode(["\163\x74\141\x74\165\x73" => "\x53\125\103\x43\x45\x53\x53"]));
        $this->twofautility->method("\x6c\x6f\147\137\144\x65\142\165\x67");
        $this->twofautility->method("\147\x65\164\123\145\163\x73\151\157\x6e\126\141\154\x75\x65")->willReturn(1);
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\x67\145\164\x50\x61\162\141\155\x73")->willReturn(["\141\x75\x74\150\124\x79\x70\x65" => "\x47\x6f\157\147\x6c\x65\x41\165\164\x68\x65\x6e\164\151\143\x61\164\157\x72", "\157\156\x65\55\164\151\x6d\145\x2d\x6f\164\x70\55\164\x6f\153\x65\156" => "\x31\x32\x33\64\65\x36"]);
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\x67\x65\x74\x52\145\161\165\x65\x73\164"])->getMock();
        $DUvZF->method("\147\145\x74\x52\x65\161\x75\145\163\x74")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            qUEw9:
        }
        H0jIf:
        $this->twofautility->method("\x67\x65\x74\101\x6c\154\x4d\x6f\124\146\141\x55\x73\x65\x72\104\x65\164\x61\x69\154\163")->willReturn([]);
        $r5SYH = $DUvZF->configure_step_two();
        $this->assertIsString($r5SYH);
        $this->assertStringContainsString("\163\x74\141\164\x75\x73\75\163\165\143\143\x65\163\163", $r5SYH);
    }
    public function testConfigureStepTwo_OOE_CustomGatewayEnabled_Success()
    {
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\164\x55\163\145\162\156\141\x6d\x65"])->getMock();
        $jffoB->method("\147\145\164\x55\163\x65\x72\156\x61\x6d\x65")->willReturn("\x61\x64\155\x69\156");
        $this->twofautility->method("\x67\x65\x74\x43\x75\x72\x72\x65\x6e\164\101\144\155\x69\x6e\125\x73\x65\162")->willReturn($jffoB);
        $this->twofautility->method("\x69\163\x43\x75\163\164\x6f\x6d\145\x72\122\145\x67\x69\163\164\145\x72\145\x64")->willReturn(true);
        $this->twofautility->method("\147\145\x74\x53\164\x6f\x72\145\103\157\x6e\x66\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\143\165\163\x74\x6f\x6d\147\141\164\145\167\141\x79\137\x76\x61\154\151\144\x61\x74\145\117\124\120")->willReturn("\x53\x55\103\103\105\123\123");
        $this->twofautility->method("\154\157\x67\x5f\144\145\x62\165\147");
        $this->twofautility->method("\x67\x65\x74\x53\145\163\x73\x69\157\156\x56\x61\154\165\x65")->willReturn(1);
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\x67\145\x74\120\141\x72\x61\155\163")->willReturn(["\x61\165\164\150\x54\171\160\x65" => "\x4f\x4f\105", "\x6f\x6e\145\55\x74\x69\x6d\145\55\157\164\x70\55\164\x6f\x6b\145\156" => "\61\62\63\64\65\x36"]);
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\147\x65\164\122\145\161\x75\x65\163\164"])->getMock();
        $DUvZF->method("\x67\145\164\x52\145\161\x75\x65\x73\164")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            hVjx3:
        }
        FURkd:
        $r5SYH = $DUvZF->configure_step_two();
        $this->assertIsString($r5SYH);
        $this->assertStringContainsString("\x73\164\x61\x74\x75\x73\x3d\163\x75\143\x63\145\163\x73", $r5SYH);
    }
    public function testTestConfiguration_RowFound_MethodNotInConfiguredMethods()
    {
        $this->twofautility->method("\151\x73\x43\x75\163\164\x6f\155\145\162\122\x65\x67\151\163\164\x65\x72\145\144")->willReturn(true);
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\164\x55\163\x65\x72\x6e\x61\x6d\x65"])->getMock();
        $jffoB->method("\147\145\x74\x55\163\x65\162\156\x61\x6d\145")->willReturn("\x61\144\155\151\x6e");
        $this->twofautility->method("\x67\x65\x74\103\165\x72\162\145\x6e\164\101\x64\x6d\151\156\125\163\145\x72")->willReturn($jffoB);
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\147\x65\x74\x50\x61\162\x61\x6d\163")->willReturn(["\x54\145\x73\x74\103\157\x6e\x66\x69\147\x4d\x65\164\150\x6f\144\x4e\141\x6d\x65" => "\117\x4f\105"]);
        $this->twofautility->method("\x67\x65\x74\x41\154\154\115\157\x54\146\x61\125\163\145\162\x44\145\164\141\x69\154\163")->willReturn([["\x63\157\156\146\x69\147\165\162\x65\144\137\x6d\x65\x74\150\x6f\144\163" => "\x4f\x4f\123"]]);
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\x67\x65\x74\x52\x65\x71\x75\145\x73\164"])->getMock();
        $DUvZF->method("\147\145\x74\x52\x65\x71\165\145\x73\164")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            Fp2oS:
        }
        kRS5V:
        $r5SYH = $DUvZF->test_configuration();
        $this->assertIsString($r5SYH);
        $this->assertStringContainsString("\x73\x74\141\164\165\163\x3d\x65\x72\x72\157\x72", $r5SYH);
    }
    public function testActivateMethod_RowFound_MethodInConfiguredMethods()
    {
        $this->twofautility->method("\x69\163\x43\x75\163\164\157\155\145\162\x52\x65\147\x69\x73\x74\145\x72\145\144")->willReturn(true);
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\x74\x55\163\145\162\156\141\x6d\x65"])->getMock();
        $jffoB->method("\147\x65\x74\x55\x73\x65\x72\x6e\141\155\x65")->willReturn("\x61\144\155\151\156");
        $this->twofautility->method("\147\145\164\103\x75\162\162\x65\x6e\164\101\144\x6d\x69\x6e\125\163\x65\162")->willReturn($jffoB);
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\x67\145\x74\120\x61\162\141\155\163")->willReturn(["\101\x63\164\x69\x76\141\164\x65\115\x65\x74\150\157\144\116\x61\x6d\x65" => "\117\x4f\x45"]);
        $this->twofautility->method("\x67\x65\x74\x41\154\x6c\x4d\x6f\124\x66\x61\125\163\x65\x72\104\145\164\141\x69\x6c\x73")->willReturn([["\143\157\x6e\x66\151\x67\165\162\x65\x64\x5f\x6d\x65\164\x68\x6f\144\163" => "\117\117\x45"]]);
        $this->twofautility->method("\165\160\144\141\164\x65\x52\157\167\x49\156\x54\141\142\154\145");
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\147\x65\x74\122\145\x71\x75\x65\x73\x74"])->getMock();
        $DUvZF->method("\147\145\164\122\145\x71\x75\145\x73\x74")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            wNlWy:
        }
        m6zQQ:
        $r5SYH = $DUvZF->activate_method();
        $this->assertIsString($r5SYH);
        $this->assertStringContainsString("\163\164\141\164\x75\163\75\163\165\143\143\145\x73\163", $r5SYH);
    }
    public function testActivateMethod_RowFound_MethodNotInConfiguredMethods()
    {
        $this->twofautility->method("\x69\x73\103\x75\163\x74\x6f\155\145\x72\122\x65\147\151\x73\164\x65\162\145\x64")->willReturn(true);
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\x74\125\x73\x65\162\x6e\x61\155\145"])->getMock();
        $jffoB->method("\147\x65\164\125\163\145\x72\156\141\x6d\145")->willReturn("\141\144\155\x69\156");
        $this->twofautility->method("\147\145\x74\103\165\x72\162\x65\156\164\x41\x64\x6d\151\156\x55\x73\145\x72")->willReturn($jffoB);
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\147\x65\164\x50\x61\162\141\155\x73")->willReturn(["\101\x63\164\151\166\x61\164\x65\115\145\164\150\157\144\116\x61\155\145" => "\x4f\x4f\123"]);
        $this->twofautility->method("\147\x65\164\101\x6c\154\115\157\124\x66\141\125\x73\145\162\104\145\164\141\151\154\163")->willReturn([["\143\x6f\x6e\146\x69\147\165\x72\145\144\137\x6d\x65\x74\x68\157\x64\x73" => "\117\117\105"]]);
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\x67\x65\x74\122\x65\x71\x75\145\x73\164"])->getMock();
        $DUvZF->method("\x67\x65\164\122\x65\161\x75\x65\163\x74")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            lxgN7:
        }
        sNuML:
        $r5SYH = $DUvZF->activate_method();
        $this->assertIsString($r5SYH);
        $this->assertStringContainsString("\x73\x74\141\x74\165\163\x3d\145\x72\162\x6f\x72", $r5SYH);
    }
    public function testActivateMethod_RowNotFound()
    {
        $this->twofautility->method("\x69\x73\x43\x75\x73\164\x6f\x6d\145\x72\122\x65\147\x69\x73\x74\145\x72\145\x64")->willReturn(true);
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\164\125\x73\145\162\156\x61\x6d\x65"])->getMock();
        $jffoB->method("\147\x65\x74\125\163\145\162\x6e\141\155\x65")->willReturn("\x61\x64\x6d\151\x6e");
        $this->twofautility->method("\147\145\164\103\165\x72\162\145\156\x74\x41\144\x6d\151\x6e\125\x73\x65\162")->willReturn($jffoB);
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\147\145\x74\120\x61\x72\x61\x6d\x73")->willReturn(["\101\x63\x74\x69\x76\x61\x74\145\115\145\x74\x68\157\x64\116\x61\x6d\x65" => "\x4f\x4f\105"]);
        $this->twofautility->method("\147\x65\x74\101\154\x6c\x4d\x6f\124\x66\x61\x55\x73\145\x72\x44\145\164\x61\x69\154\x73")->willReturn([]);
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\x67\145\x74\x52\145\x71\x75\x65\x73\x74"])->getMock();
        $DUvZF->method("\147\x65\164\x52\x65\x71\165\145\x73\x74")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            gbGA9:
        }
        k0yS7:
        $r5SYH = $DUvZF->activate_method();
        $this->assertIsString($r5SYH);
        $this->assertStringContainsString("\x73\x74\141\164\165\163\x3d\x65\x72\162\157\x72", $r5SYH);
    }
    public function testGoBackToPreviousConfigReturnsData()
    {
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\164\x55\x73\145\162\x6e\x61\x6d\x65"])->getMock();
        $jffoB->method("\147\x65\164\x55\x73\145\162\x6e\x61\x6d\x65")->willReturn("\x61\144\x6d\151\156");
        $this->twofautility->method("\147\x65\164\103\x75\162\162\x65\156\x74\101\x64\x6d\151\x6e\x55\163\145\x72")->willReturn($jffoB);
        $this->twofautility->method("\x67\145\164\123\145\163\163\151\x6f\x6e\x56\141\154\x75\145")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::PRE_USERNAME, "\165\x6e\141\x6d\145"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::PRE_EMAIL, "\x75\x65\x6d\141\x69\154"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::PRE_PHONE, "\165\160\150\x6f\156\145"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::PRE_TRANSACTIONID, "\165\164\x49\104"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::PRE_SECRET, "\x75\123\x65\x63\162\145\164"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::PRE_ACTIVE_METHOD, "\x75\101\x63\x74\x69\166\x65"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::PRE_CONFIG_METHOD, "\165\x43\157\156\x66\x69\x67"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::PRE_COUNTRY_CODE, "\165\143\x6f\165\x6e\x74\162\x79"]]);
        $r5SYH = $this->indexController->goBack_to_PreviousConfig();
        $this->assertIsArray($r5SYH);
        $this->assertArrayHasKey("\x75\x73\145\162\x6e\141\155\145", $r5SYH);
        $this->assertArrayHasKey("\141\143\164\151\166\145\x5f\155\x65\x74\150\x6f\144", $r5SYH);
    }
    public function testIsAllowedReturnsTrue()
    {
        $this->authorization->method("\151\x73\101\154\154\157\167\145\x64")->willReturn(true);
        $mCx6j = new \ReflectionMethod($this->indexController, "\137\x69\x73\101\154\x6c\x6f\x77\x65\x64");
        $mCx6j->setAccessible(true);
        $this->assertTrue($mCx6j->invoke($this->indexController));
    }
    public function testIsAllowedReturnsFalse()
    {
        $this->authorization->method("\151\x73\x41\x6c\x6c\157\x77\x65\x64")->willReturn(false);
        $mCx6j = new \ReflectionMethod($this->indexController, "\137\151\163\x41\x6c\x6c\157\167\x65\x64");
        $mCx6j->setAccessible(true);
        $this->assertFalse($mCx6j->invoke($this->indexController));
    }
    private function getMockResultPage()
    {
        $vOx1h = $this->getMockBuilder(\stdClass::class)->addMethods(["\x70\162\145\x70\145\x6e\x64"])->getMock();
        $vOx1h->method("\160\x72\145\x70\x65\156\x64")->willReturnSelf();
        $CQAQo = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\x74\124\151\x74\154\x65"])->getMock();
        $CQAQo->method("\147\145\164\124\151\164\x6c\145")->willReturn($vOx1h);
        $Z53ME = $this->createMock(\Magento\Framework\View\Result\Page::class);
        $Z53ME->method("\x67\x65\164\x43\x6f\156\x66\151\147")->willReturn($CQAQo);
        return $Z53ME;
    }
    private function getMockRedirect()
    {
        return $this->getMockBuilder(\stdClass::class)->addMethods(["\x73\145\164\125\x72\154"])->getMock();
    }
    public function testTestConfiguration_OOS_CustomGatewaySMSEnabled()
    {
        $this->twofautility->method("\151\x73\x43\165\x73\164\157\155\x65\162\122\x65\147\x69\x73\x74\x65\x72\145\144")->willReturn(true);
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\x74\125\x73\145\162\x6e\141\x6d\x65"])->getMock();
        $jffoB->method("\147\x65\x74\x55\163\x65\x72\156\141\x6d\145")->willReturn("\x61\x64\x6d\x69\156");
        $this->twofautility->method("\147\145\x74\103\165\x72\162\145\x6e\x74\x41\x64\155\x69\x6e\x55\163\145\162")->willReturn($jffoB);
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\x67\x65\x74\x50\x61\162\x61\155\163")->willReturn(["\x54\x65\x73\x74\103\x6f\x6e\146\x69\147\115\145\x74\150\157\x64\116\x61\155\145" => "\117\117\123"]);
        $this->twofautility->method("\x67\x65\x74\x41\154\154\115\157\124\x66\x61\x55\163\x65\162\104\x65\x74\x61\x69\154\x73")->willReturn([["\143\157\x6e\x66\151\147\165\x72\145\x64\137\155\x65\164\150\157\144\x73" => "\117\x4f\x53", "\x70\x68\x6f\x6e\145" => "\x31\x32\63\x34\x35\66\67\70\x39\60", "\143\157\x75\x6e\x74\x72\171\143\157\x64\145" => "\71\61"]]);
        $this->twofautility->method("\147\x65\164\x53\x74\157\x72\x65\x43\157\156\146\x69\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->customSMS->method("\163\145\x6e\x64\x5f\x63\165\163\164\157\x6d\147\x61\164\145\x77\141\x79\x5f\x73\155\x73")->willReturn(["\163\x74\141\164\165\163" => "\123\x55\103\103\x45\x53\123", "\164\x78\111\x64" => "\61"]);
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\147\145\164\122\x65\x71\x75\145\163\x74"])->getMock();
        $DUvZF->method("\147\145\x74\122\145\161\x75\145\x73\x74")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            Voepz:
        }
        YlBA3:
        $r5SYH = $DUvZF->test_configuration();
        $this->assertIsString($r5SYH);
        $this->assertStringContainsString("\x72\137\x73\x74\x61\x74\x75\x73\75\123\125\103\x43\105\123\123", $r5SYH);
    }
    public function testTestConfiguration_OOSE_BothCustomGatewaysEnabled_Success()
    {
        $this->twofautility->method("\151\x73\x43\x75\x73\164\x6f\155\145\x72\122\145\x67\151\x73\164\x65\162\145\x64")->willReturn(true);
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\164\x55\163\145\162\x6e\141\155\x65"])->getMock();
        $jffoB->method("\147\x65\x74\x55\163\145\x72\156\x61\155\145")->willReturn("\x61\x64\x6d\x69\x6e");
        $this->twofautility->method("\x67\x65\164\x43\x75\162\162\x65\156\x74\x41\x64\155\151\156\x55\x73\x65\x72")->willReturn($jffoB);
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\147\x65\164\120\141\162\x61\x6d\163")->willReturn(["\124\x65\x73\x74\x43\x6f\156\x66\151\147\x4d\145\164\x68\157\144\116\x61\x6d\145" => "\x4f\117\123\x45"]);
        $this->twofautility->method("\147\x65\164\101\154\154\x4d\x6f\124\146\x61\x55\x73\145\162\x44\x65\x74\x61\151\154\x73")->willReturn([["\x63\157\156\x66\x69\x67\165\x72\x65\x64\137\x6d\145\x74\x68\x6f\x64\163" => "\x4f\117\123\105", "\x65\x6d\141\151\154" => "\x61\x64\155\151\156\100\x65\170\x61\x6d\160\154\x65\56\x63\157\x6d", "\160\150\157\x6e\x65" => "\61\x32\x33\x34\x35\x36\67\70\71\x30", "\x63\157\x75\x6e\164\162\x79\143\x6f\x64\145" => "\x39\x31"]]);
        $this->twofautility->method("\x67\x65\x74\x53\x74\157\x72\145\x43\157\156\x66\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->customEmail->method("\x73\145\156\144\x43\x75\163\x74\157\155\x67\141\x74\145\167\x61\171\x45\x6d\x61\x69\x6c")->willReturn(["\x73\164\x61\164\x75\x73" => "\x53\125\103\103\x45\x53\123"]);
        $this->customSMS->method("\x73\145\156\x64\x5f\x63\165\163\x74\157\155\x67\x61\164\x65\167\x61\x79\x5f\163\155\x73")->willReturn(["\163\164\141\164\x75\x73" => "\123\x55\x43\x43\105\x53\123"]);
        $this->twofautility->method("\117\x54\120\x5f\157\x76\x65\162\137\123\115\x53\141\156\144\105\x4d\x41\x49\114\x5f\115\x65\163\163\x61\147\x65")->willReturn("\x4f\x54\120\40\163\x65\x6e\x74");
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\147\x65\x74\x52\x65\161\x75\145\x73\x74"])->getMock();
        $DUvZF->method("\147\145\x74\x52\145\x71\x75\145\163\164")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            oF8aF:
        }
        JzRtI:
        $r5SYH = $DUvZF->test_configuration();
        $this->assertIsString($r5SYH);
        $this->assertStringContainsString("\x72\137\163\164\x61\164\x75\x73\x3d\123\125\103\103\105\123\x53", $r5SYH);
    }
    public function testTestConfiguration_OOW_CustomGatewayWhatsappEnabled()
    {
        $this->twofautility->method("\x69\163\103\165\x73\x74\157\155\145\162\122\145\x67\151\x73\164\145\x72\x65\x64")->willReturn(true);
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\x74\x55\x73\145\x72\156\x61\x6d\145"])->getMock();
        $jffoB->method("\147\145\x74\125\163\145\162\x6e\141\155\x65")->willReturn("\x61\x64\x6d\151\x6e");
        $this->twofautility->method("\x67\145\164\103\x75\x72\162\145\156\164\x41\x64\x6d\x69\156\x55\163\x65\x72")->willReturn($jffoB);
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\147\145\164\120\x61\162\x61\x6d\x73")->willReturn(["\x54\x65\163\x74\x43\157\156\x66\x69\147\x4d\x65\x74\150\157\144\116\x61\155\145" => "\117\117\x57"]);
        $this->twofautility->method("\x67\x65\164\101\154\x6c\x4d\157\124\146\x61\x55\163\x65\x72\x44\145\x74\141\x69\x6c\163")->willReturn([["\x63\157\156\x66\151\147\x75\162\x65\x64\137\155\145\x74\150\x6f\144\163" => "\117\117\127", "\160\x68\x6f\156\145" => "\x31\x32\x33\x34\65\66\67\x38\71\x30", "\143\x6f\x75\x6e\164\x72\x79\x63\157\x64\145" => "\71\x31"]]);
        $this->twofautility->method("\147\145\164\123\x74\157\x72\x65\x43\x6f\156\146\151\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, true]]);
        $this->twofautility->method("\163\x65\x6e\144\x5f\143\x75\x73\164\x6f\x6d\147\141\164\x65\x77\x61\x79\x5f\167\x68\141\164\x73\x61\x70\160")->willReturn(["\x73\164\141\x74\165\163" => "\x53\x55\103\x43\105\x53\123", "\x74\x78\111\144" => "\61"]);
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\x67\145\x74\122\x65\161\165\x65\163\164"])->getMock();
        $DUvZF->method("\147\145\164\122\x65\x71\165\x65\163\x74")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            OsUah:
        }
        ATTCz:
        $r5SYH = $DUvZF->test_configuration();
        $this->assertIsString($r5SYH);
        $this->assertStringContainsString("\162\x5f\x73\x74\141\164\x75\x73\75\123\x55\103\x43\105\123\123", $r5SYH);
    }
    public function testConfigureStepTwo_OOS_CustomGatewaySMSEnabled_Success()
    {
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\x74\x55\163\x65\162\156\x61\x6d\145"])->getMock();
        $jffoB->method("\x67\x65\x74\125\163\145\162\x6e\x61\x6d\x65")->willReturn("\141\144\155\x69\156");
        $this->twofautility->method("\147\145\x74\x43\165\162\x72\145\156\164\x41\x64\155\x69\x6e\x55\x73\x65\x72")->willReturn($jffoB);
        $this->twofautility->method("\151\163\x43\165\x73\x74\157\x6d\x65\162\x52\x65\147\151\x73\x74\x65\x72\145\x64")->willReturn(true);
        $this->twofautility->method("\x67\145\x74\123\164\157\162\x65\x43\157\156\146\151\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\x63\165\163\164\x6f\x6d\x67\x61\x74\x65\167\x61\171\137\166\x61\x6c\151\x64\x61\x74\x65\117\x54\120")->willReturn("\x53\x55\103\x43\105\123\x53");
        $this->twofautility->method("\154\157\x67\137\144\x65\142\x75\x67");
        $this->twofautility->method("\147\145\x74\123\x65\163\x73\x69\x6f\x6e\126\x61\154\165\145")->willReturn(1);
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\x67\x65\164\x50\141\162\141\x6d\x73")->willReturn(["\141\165\164\x68\124\x79\160\x65" => "\x4f\x4f\123", "\157\156\145\x2d\164\x69\x6d\x65\55\x6f\164\160\x2d\164\x6f\153\145\156" => "\61\62\x33\x34\65\x36"]);
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\147\x65\x74\122\145\x71\165\145\163\164"])->getMock();
        $DUvZF->method("\147\x65\x74\x52\145\x71\165\x65\x73\164")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            y1BxY:
        }
        qLwj_:
        $r5SYH = $DUvZF->configure_step_two();
        $this->assertIsString($r5SYH);
        $this->assertStringContainsString("\x73\164\141\164\x75\x73\75\x73\165\143\x63\x65\163\163", $r5SYH);
    }
    public function testConfigureStepTwo_OOSE_BothCustomGatewaysEnabled_Success()
    {
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\164\x55\x73\x65\162\156\x61\x6d\x65"])->getMock();
        $jffoB->method("\x67\145\x74\x55\x73\x65\x72\156\x61\x6d\145")->willReturn("\141\144\x6d\151\156");
        $this->twofautility->method("\147\x65\164\x43\165\x72\162\x65\x6e\164\x41\x64\155\x69\x6e\x55\163\x65\x72")->willReturn($jffoB);
        $this->twofautility->method("\x69\x73\x43\x75\163\164\x6f\155\145\x72\x52\x65\147\x69\163\x74\x65\162\x65\x64")->willReturn(true);
        $this->twofautility->method("\147\145\164\x53\x74\157\162\145\103\157\x6e\146\151\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\143\x75\x73\164\157\155\x67\141\164\145\167\141\171\137\166\x61\x6c\151\x64\x61\x74\x65\117\x54\120")->willReturn("\x53\125\103\103\x45\123\x53");
        $this->twofautility->method("\154\157\x67\x5f\144\x65\x62\165\x67");
        $this->twofautility->method("\x67\145\x74\x53\145\163\x73\x69\157\156\x56\x61\x6c\165\x65")->willReturn(1);
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\x67\x65\x74\120\141\x72\141\155\x73")->willReturn(["\141\165\164\x68\x54\171\x70\145" => "\x4f\x4f\x53\x45", "\x6f\156\x65\x2d\164\x69\x6d\145\55\157\164\x70\x2d\164\157\x6b\x65\x6e" => "\61\x32\x33\x34\x35\66"]);
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\147\145\x74\x52\145\161\x75\145\163\164"])->getMock();
        $DUvZF->method("\147\145\164\122\x65\x71\x75\145\163\164")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            yz5bO:
        }
        ScA9n:
        $r5SYH = $DUvZF->configure_step_two();
        $this->assertIsString($r5SYH);
        $this->assertStringContainsString("\x73\164\x61\x74\165\x73\75\163\x75\143\x63\x65\163\163", $r5SYH);
    }
    public function testConfigureStepTwo_OOW_CustomGatewayWhatsappEnabled_Success()
    {
        $jffoB = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\164\x55\x73\145\162\156\141\x6d\145"])->getMock();
        $jffoB->method("\x67\145\x74\x55\163\x65\162\x6e\141\155\x65")->willReturn("\x61\144\x6d\151\x6e");
        $this->twofautility->method("\147\145\x74\x43\x75\x72\162\145\x6e\164\101\144\155\151\156\x55\x73\145\162")->willReturn($jffoB);
        $this->twofautility->method("\x69\x73\103\165\163\164\157\155\x65\x72\x52\145\x67\151\163\x74\x65\x72\x65\x64")->willReturn(true);
        $this->twofautility->method("\x67\145\164\123\x74\x6f\x72\145\x43\x6f\156\x66\151\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, true]]);
        $this->twofautility->method("\143\165\163\164\157\x6d\147\x61\x74\145\167\141\171\137\x76\141\x6c\151\x64\141\164\145\117\x54\120")->willReturn("\x53\x55\x43\x43\x45\123\x53");
        $this->twofautility->method("\x6c\157\147\x5f\x64\145\142\x75\x67");
        $this->twofautility->method("\147\x65\x74\123\x65\163\163\151\157\156\126\x61\154\x75\145")->willReturn(1);
        $myEmK = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)->getMock();
        $myEmK->method("\147\145\164\x50\x61\x72\x61\x6d\163")->willReturn(["\x61\165\164\150\x54\x79\x70\x65" => "\117\x4f\127", "\157\156\x65\55\164\x69\155\145\55\x6f\164\x70\55\x74\157\x6b\x65\x6e" => "\x31\x32\63\64\x35\x36"]);
        $DUvZF = $this->getMockBuilder(get_class($this->indexController))->setConstructorArgs([$myEmK, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods(["\147\145\x74\122\x65\161\x75\145\x73\164"])->getMock();
        $DUvZF->method("\147\145\164\122\145\x71\x75\x65\163\164")->willReturn($myEmK);
        $mCx6j = new \ReflectionClass($this->indexController);
        foreach ($mCx6j->getProperties() as $p3g1l) {
            $p3g1l->setAccessible(true);
            $p3g1l->setValue($DUvZF, $p3g1l->getValue($this->indexController));
            gRmq_:
        }
        ZG7Ai:
        $r5SYH = $DUvZF->configure_step_two();
        $this->assertIsString($r5SYH);
        $this->assertStringContainsString("\x73\164\141\x74\165\163\75\x73\165\143\x63\x65\x73\x73", $r5SYH);
    }
}