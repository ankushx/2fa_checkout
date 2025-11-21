<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Adminhtml\Otp;

use PHPUnit\Framework\TestCase;
class AuthIndexTest extends TestCase
{
    private $context;
    private $resultPageFactory;
    private $storageSession;
    private $resultPage;
    private $authIndexController;
    protected function setUp() : void
    {
        $this->context = $this->createMock(\Magento\Backend\App\Action\Context::class);
        $this->resultPageFactory = $this->createMock(\Magento\Framework\View\Result\PageFactory::class);
        $this->storageSession = $this->createMock(\Magento\Framework\Session\SessionManager::class);
        $this->resultPage = $this->createMock(\Magento\Framework\View\Result\Page::class);
        $this->authIndexController = new \MiniOrange\TwoFA\Controller\Adminhtml\Otp\AuthIndex($this->context, $this->resultPageFactory, $this->storageSession);
    }
    public function testExecuteReturnsResultPage()
    {
        $this->resultPageFactory->expects($this->once())->method("\143\162\x65\141\164\145")->willReturn($this->resultPage);
        $y1ZkZ = $this->authIndexController->execute();
        $this->assertSame($this->resultPage, $y1ZkZ);
    }
    public function testIsAllowedReturnsTrueWhenUserInSession()
    {
        $this->storageSession->method("\x67\145\164\104\141\x74\x61")->with("\x75\x73\145\x72")->willReturn(["\x69\144" => 1, "\x6e\141\x6d\145" => "\x61\144\155\151\156"]);
        $rnQdG = new \ReflectionMethod($this->authIndexController, "\137\151\x73\x41\154\x6c\x6f\167\x65\x64");
        $rnQdG->setAccessible(true);
        $this->assertTrue($rnQdG->invoke($this->authIndexController));
    }
    public function testIsAllowedReturnsFalseWhenNoUserInSession()
    {
        $this->storageSession->method("\x67\145\x74\x44\x61\164\x61")->with("\x75\163\145\x72")->willReturn(null);
        $rnQdG = new \ReflectionMethod($this->authIndexController, "\x5f\x69\x73\x41\x6c\x6c\157\167\145\x64");
        $rnQdG->setAccessible(true);
        $this->assertFalse($rnQdG->invoke($this->authIndexController));
    }
    public function testIsAllowedReturnsFalseWhenUserIsEmptyArray()
    {
        $this->storageSession->method("\x67\x65\164\104\141\x74\141")->with("\x75\163\x65\162")->willReturn([]);
        $rnQdG = new \ReflectionMethod($this->authIndexController, "\137\x69\163\x41\x6c\154\x6f\167\x65\x64");
        $rnQdG->setAccessible(true);
        $this->assertFalse($rnQdG->invoke($this->authIndexController));
    }
}