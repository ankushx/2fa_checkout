<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Adminhtml\Support;

use MiniOrange\TwoFA\Controller\Adminhtml\Support\Index;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
class IndexTest extends TestCase
{
    private $context;
    private $twofautility;
    private $resultPageFactory;
    private $messageManager;
    private $logger;
    private $fileFactory;
    private $resultFactory;
    private $redirect;
    private $resultRedirect;
    private $authorization;
    private $indexController;
    private $request;
    protected function setUp() : void
    {
        $this->context = $this->createMock(\Magento\Backend\App\Action\Context::class);
        $this->twofautility = $this->createMock(\MiniOrange\TwoFA\Helper\TwoFAUtility::class);
        $this->resultPageFactory = $this->createMock(\Magento\Framework\View\Result\PageFactory::class);
        $this->messageManager = $this->createMock(\Magento\Framework\Message\ManagerInterface::class);
        $this->logger = $this->createMock(\Psr\Log\LoggerInterface::class);
        $this->fileFactory = $this->createMock(\Magento\Framework\App\Response\Http\FileFactory::class);
        $this->resultFactory = $this->createMock(\Magento\Framework\Controller\ResultFactory::class);
        $this->redirect = $this->getMockBuilder(\Magento\Backend\Model\Url::class)->disableOriginalConstructor()->addMethods(["\147\145\164\x52\145\x66\145\x72\145\162\x55\162\154"])->getMock();
        $this->resultRedirect = $this->getMockBuilder(\stdClass::class)->addMethods(["\x73\145\164\125\162\x6c"])->getMock();
        $this->authorization = $this->createMock(\Magento\Framework\AuthorizationInterface::class);
        $this->request = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->context->method("\147\145\x74\122\145\161\x75\145\163\164")->willReturn($this->request);
        $this->context->method("\147\145\x74\x4d\145\x73\x73\141\x67\145\115\141\156\141\147\x65\162")->willReturn($this->messageManager);
        $this->indexController = new Index($this->context, $this->twofautility, $this->resultPageFactory, $this->messageManager, $this->logger, $this->fileFactory);
        $bjCj_ = new ReflectionClass($this->indexController);
        foreach (["\x72\145\163\165\154\164\x46\x61\143\164\157\162\171" => $this->resultFactory, "\137\162\145\144\151\x72\145\x63\x74" => $this->redirect, "\137\x61\165\164\x68\x6f\162\x69\172\141\164\151\157\x6e" => $this->authorization, "\x6c\157\x67\147\145\162" => $this->logger] as $LsWRG => $x_6v7) {
            if (!$bjCj_->hasProperty($LsWRG)) {
                goto BZvK8;
            }
            $nN7SF = $bjCj_->getProperty($LsWRG);
            $nN7SF->setAccessible(true);
            $nN7SF->setValue($this->indexController, $x_6v7);
            BZvK8:
            tx7lm:
        }
        ktwaE:
    }
    public function testExecuteEnableDebugLog()
    {
        $I8FON = ["\x6f\x70\164\151\x6f\x6e" => "\145\156\x61\x62\154\x65\x5f\x64\145\x62\x75\147\x5f\x6c\x6f\147", "\144\145\142\x75\x67\137\154\x6f\147\137\157\x6e" => 1];
        $this->request->method("\147\x65\164\x50\x61\162\x61\x6d\x73")->willReturn($I8FON);
        $this->twofautility->method("\x69\x73\103\165\x73\x74\x6f\x6d\x4c\x6f\x67\105\170\x69\x73\x74")->willReturn(false);
        $this->resultFactory->method("\x63\162\145\x61\x74\x65")->willReturn($this->resultRedirect);
        $this->redirect->method("\x67\x65\x74\122\x65\x66\145\162\145\x72\x55\x72\x6c")->willReturn("\x72\145\x66\145\x72\145\x72\x2d\165\162\154");
        $this->resultRedirect->expects($this->once())->method("\x73\145\x74\x55\x72\x6c")->with("\x72\x65\x66\x65\x72\145\x72\x2d\x75\x72\x6c")->willReturnSelf();
        $this->messageManager->expects($this->once())->method("\141\x64\144\x53\x75\143\x63\145\x73\x73\115\x65\163\163\x61\147\x65");
        $QTS_L = $this->indexController->execute();
        $this->assertSame($this->resultRedirect, $QTS_L);
    }
    public function testExecuteClearDownloadLogsDownload()
    {
        $I8FON = ["\x6f\160\x74\151\x6f\156" => "\x63\154\145\x61\x72\x5f\144\x6f\167\x6e\x6c\x6f\x61\x64\x5f\x6c\x6f\x67\x73", "\144\157\x77\x6e\154\157\x61\x64\x5f\x6c\157\x67\163" => 1];
        $this->request->method("\147\x65\x74\120\x61\x72\141\155\x73")->willReturn($I8FON);
        $this->twofautility->method("\151\x73\x4c\x6f\x67\x45\x6e\141\x62\x6c\x65")->willReturn(true);
        $this->twofautility->method("\151\163\x43\165\x73\164\x6f\x6d\114\x6f\x67\105\x78\x69\x73\164")->willReturn(true);
        $this->indexController = $this->getControllerWithCreateLogFileMock();
        $this->resultFactory->expects($this->never())->method("\143\x72\x65\x61\x74\145");
        $QTS_L = $this->indexController->execute();
        $this->assertEquals("\154\157\147\55\x66\x69\154\x65\x2d\162\145\163\x75\154\164", $QTS_L);
    }
    public function testExecuteClearDownloadLogsNoLog()
    {
        $I8FON = ["\x6f\160\164\151\157\x6e" => "\x63\154\145\x61\162\x5f\x64\x6f\167\156\154\157\x61\144\137\154\157\147\163", "\x64\x6f\167\x6e\x6c\157\x61\x64\x5f\154\157\x67\x73" => 1];
        $this->request->method("\147\145\164\120\141\x72\x61\155\x73")->willReturn($I8FON);
        $this->twofautility->method("\x69\163\114\x6f\147\x45\x6e\x61\x62\154\x65")->willReturn(false);
        $this->twofautility->method("\151\x73\103\165\x73\164\x6f\155\114\157\147\105\x78\x69\x73\x74")->willReturn(false);
        $this->resultFactory->method("\x63\162\x65\141\x74\x65")->willReturn($this->resultRedirect);
        $this->redirect->method("\x67\145\x74\122\145\x66\x65\x72\145\162\x55\162\154")->willReturn("\x72\145\x66\x65\x72\145\x72\55\x75\162\x6c");
        $this->resultRedirect->expects($this->once())->method("\163\145\x74\x55\x72\x6c")->with("\162\145\146\x65\162\x65\162\55\x75\162\x6c")->willReturnSelf();
        $this->messageManager->expects($this->once())->method("\x61\x64\144\x45\162\162\157\x72\115\x65\x73\163\x61\147\x65");
        $QTS_L = $this->indexController->execute();
        $this->assertSame($this->resultRedirect, $QTS_L);
    }
    public function testExecuteExceptionThrown()
    {
        $this->request->method("\x67\x65\164\120\x61\162\141\x6d\163")->willThrowException(new \Exception("\146\x61\151\154"));
        $this->messageManager->expects($this->once())->method("\141\x64\144\105\162\162\x6f\x72\115\145\163\163\x61\x67\145");
        $this->logger->expects($this->once())->method("\144\x65\x62\165\147");
        $this->resultFactory->method("\143\162\145\141\164\145")->willReturn($this->resultRedirect);
        $this->redirect->method("\x67\x65\164\122\145\x66\145\162\145\x72\x55\162\154")->willReturn("\x72\145\146\145\162\145\x72\x2d\165\x72\154");
        $this->resultRedirect->expects($this->once())->method("\x73\145\x74\125\162\x6c")->with("\x72\x65\x66\145\162\145\162\55\165\162\x6c")->willReturnSelf();
        $QTS_L = $this->indexController->execute();
        $this->assertSame($this->resultRedirect, $QTS_L);
    }
    public function testCreateLogFileCallsFileFactory()
    {
        $this->fileFactory->expects($this->once())->method("\143\x72\145\x61\164\145")->with("\x66\151\x6c\145\56\x6c\x6f\x67", ["\x74\171\160\145" => "\x66\151\x6c\x65\156\141\155\145", "\166\141\x6c\x75\145" => "\x70\x61\164\x68", "\162\155" => 0], \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR)->willReturn("\x66\x69\x6c\x65\55\x72\x65\163\x75\154\x74");
        $QTS_L = $this->indexController->create_log_file("\x66\x69\154\x65\x2e\x6c\157\147", ["\x74\x79\160\x65" => "\146\151\x6c\145\x6e\x61\155\x65", "\166\x61\x6c\x75\145" => "\160\141\x74\150", "\x72\x6d" => 0]);
        $this->assertEquals("\146\151\x6c\145\x2d\162\x65\163\x75\x6c\x74", $QTS_L);
    }
    public function testCustomerConfigurationSettingsLogs()
    {
        $this->twofautility->method("\147\145\x74\x53\164\157\162\145\x43\x6f\x6e\146\151\147")->willReturn("\143\165\x73\x74\157\155\145\x72\x40\x65\170\x61\155\x70\x6c\145\x2e\143\x6f\x6d");
        $this->twofautility->expects($this->atLeastOnce())->method("\143\x75\163\x74\x6f\x6d\154\x6f\x67");
        $this->twofautility->method("\147\145\164\x5f\x6d\141\147\145\x6e\164\157\x5f\x76\145\162\x73\x69\x6f\x6e")->willReturn("\x32\56\x34\56\66");
        $bjCj_ = new \ReflectionMethod($this->indexController, "\143\165\x73\164\x6f\155\145\162\x43\x6f\156\146\x69\147\x75\x72\x61\164\151\157\156\x53\x65\x74\164\151\x6e\x67\163");
        $bjCj_->setAccessible(true);
        $bjCj_->invoke($this->indexController);
    }
    public function testIsAllowedReturnsTrue()
    {
        $this->authorization->method("\x69\163\101\x6c\x6c\157\x77\x65\x64")->willReturn(true);
        $bjCj_ = new \ReflectionMethod($this->indexController, "\137\151\163\x41\x6c\154\x6f\167\x65\144");
        $bjCj_->setAccessible(true);
        $this->assertTrue($bjCj_->invoke($this->indexController));
    }
    public function testIsAllowedReturnsFalse()
    {
        $this->authorization->method("\x69\x73\101\154\154\x6f\x77\145\x64")->willReturn(false);
        $bjCj_ = new \ReflectionMethod($this->indexController, "\137\151\163\101\x6c\154\157\167\x65\144");
        $bjCj_->setAccessible(true);
        $this->assertFalse($bjCj_->invoke($this->indexController));
    }
    private function getControllerWithSupportQueryMock()
    {
        $x_6v7 = $this->getMockBuilder(Index::class)->setConstructorArgs([$this->context, $this->twofautility, $this->resultPageFactory, $this->messageManager, $this->logger, $this->fileFactory])->onlyMethods(["\143\x68\145\x63\153\111\146\123\x75\160\x70\157\x72\x74\x51\165\x65\x72\171\x46\151\145\154\144\x73\x45\x6d\x70\164\x79"])->getMock();
        $x_6v7->method("\x63\x68\x65\x63\x6b\x49\146\123\x75\160\x70\x6f\x72\x74\x51\165\145\162\x79\x46\151\x65\154\144\x73\x45\x6d\160\164\171");
        $bjCj_ = new \ReflectionClass($x_6v7);
        foreach (["\162\145\x73\x75\x6c\x74\106\x61\x63\164\157\162\171" => $this->resultFactory, "\x5f\x72\145\x64\x69\x72\145\143\x74" => $this->redirect, "\x5f\x61\165\x74\x68\157\x72\151\x7a\x61\x74\x69\157\x6e" => $this->authorization, "\154\157\147\147\x65\x72" => $this->logger] as $LsWRG => $m0cbL) {
            if (!$bjCj_->hasProperty($LsWRG)) {
                goto prRpN;
            }
            $nN7SF = $bjCj_->getProperty($LsWRG);
            $nN7SF->setAccessible(true);
            $nN7SF->setValue($x_6v7, $m0cbL);
            prRpN:
            gUGQ2:
        }
        KU3Je:
        return $x_6v7;
    }
    private function getControllerWithCreateLogFileMock()
    {
        $x_6v7 = $this->getMockBuilder(Index::class)->setConstructorArgs([$this->context, $this->twofautility, $this->resultPageFactory, $this->messageManager, $this->logger, $this->fileFactory])->onlyMethods(["\143\x72\x65\141\164\145\x5f\x6c\157\147\x5f\x66\151\154\x65"])->getMock();
        $x_6v7->method("\143\162\145\x61\164\x65\x5f\154\x6f\147\x5f\146\151\154\x65")->willReturn("\x6c\157\147\55\146\151\x6c\x65\x2d\162\x65\x73\165\154\x74");
        return $x_6v7;
    }
}