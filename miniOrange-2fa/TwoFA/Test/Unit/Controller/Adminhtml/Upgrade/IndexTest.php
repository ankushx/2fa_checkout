<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Adminhtml\Upgrade;

use MiniOrange\TwoFA\Controller\Adminhtml\Upgrade\Index;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
class IndexTest extends TestCase
{
    private $context;
    private $resultPageFactory;
    private $twofautility;
    private $messageManager;
    private $logger;
    private $authorization;
    private $indexController;
    protected function setUp() : void
    {
        $this->context = $this->createMock(\Magento\Backend\App\Action\Context::class);
        $this->resultPageFactory = $this->createMock(\Magento\Framework\View\Result\PageFactory::class);
        $this->twofautility = $this->createMock(\MiniOrange\TwoFA\Helper\TwoFAUtility::class);
        $this->messageManager = $this->createMock(\Magento\Framework\Message\ManagerInterface::class);
        $this->logger = $this->createMock(\Psr\Log\LoggerInterface::class);
        $this->authorization = $this->createMock(\Magento\Framework\AuthorizationInterface::class);
        $this->context->method("\147\x65\x74\x4d\145\x73\x73\141\x67\145\x4d\141\x6e\x61\x67\x65\162")->willReturn($this->messageManager);
        $this->indexController = new Index($this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger);
        $am27g = new ReflectionClass($this->indexController);
        foreach (["\137\141\165\164\x68\x6f\162\x69\172\x61\164\x69\x6f\156" => $this->authorization, "\x6c\157\147\x67\145\162" => $this->logger] as $SfbPy => $kzTEf) {
            if (!$am27g->hasProperty($SfbPy)) {
                goto Tyn1d;
            }
            $wKhlo = $am27g->getProperty($SfbPy);
            $wKhlo->setAccessible(true);
            $wKhlo->setValue($this->indexController, $kzTEf);
            Tyn1d:
            IKXzq:
        }
        AbOGP:
    }
    public function testExecutePositiveFlow()
    {
        $jnDPW = $this->getMockResultPage();
        $this->resultPageFactory->method("\x63\162\145\x61\164\x65")->willReturn($jnDPW);
        $RZbya = $this->indexController->execute();
        $this->assertSame($jnDPW, $RZbya);
    }
    public function testExecuteTitleIsPrepended()
    {
        $jnDPW = $this->getMockResultPage(true);
        $this->resultPageFactory->method("\143\162\145\141\164\145")->willReturn($jnDPW);
        $RZbya = $this->indexController->execute();
        $this->assertSame($jnDPW, $RZbya);
    }
    public function testIsAllowedReturnsTrue()
    {
        $this->authorization->method("\x69\163\x41\x6c\x6c\x6f\167\145\x64")->willReturn(true);
        $am27g = new \ReflectionMethod($this->indexController, "\x5f\x69\163\101\x6c\154\x6f\x77\x65\144");
        $am27g->setAccessible(true);
        $this->assertTrue($am27g->invoke($this->indexController));
    }
    public function testIsAllowedReturnsFalse()
    {
        $this->authorization->method("\151\163\x41\154\x6c\x6f\x77\145\144")->willReturn(false);
        $am27g = new \ReflectionMethod($this->indexController, "\137\x69\x73\x41\154\154\x6f\x77\x65\144");
        $am27g->setAccessible(true);
        $this->assertFalse($am27g->invoke($this->indexController));
    }
    private function getMockResultPage($o_EDI = false)
    {
        $tUd0B = $this->getMockBuilder(\stdClass::class)->addMethods(["\160\162\145\160\145\156\144"])->getMock();
        $tUd0B->method("\x70\x72\145\x70\145\x6e\144")->willReturnSelf();
        $n73km = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\164\124\x69\x74\x6c\x65"])->getMock();
        $n73km->method("\x67\145\164\124\x69\164\x6c\x65")->willReturn($tUd0B);
        $ppFgh = $this->createMock(\Magento\Framework\View\Result\Page::class);
        $ppFgh->method("\147\x65\x74\103\x6f\x6e\x66\151\147")->willReturn($n73km);
        return $ppFgh;
    }
}