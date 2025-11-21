<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Actions;

use MiniOrange\TwoFA\Controller\Actions\BaseAdminAction;
use PHPUnit\Framework\TestCase;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface;
use MiniOrange\TwoFA\Helper\Exception\NotRegisteredException;
use MiniOrange\TwoFA\Helper\Exception\RequiredFieldsException;
use MiniOrange\TwoFA\Helper\Exception\SupportQueryRequiredFieldsException;
class BaseAdminActionConcrete extends BaseAdminAction
{
    public function execute()
    {
    }
    public function callCheckIfRequiredFieldsEmpty($ycIs5)
    {
        return $this->checkIfRequiredFieldsEmpty($ycIs5);
    }
    public function callIsFormOptionBeingSaved($Qi5nq)
    {
        return $this->isFormOptionBeingSaved($Qi5nq);
    }
    public function callCheckIfValidPlugin()
    {
        return $this->checkIfValidPlugin();
    }
}
class BaseAdminActionTest extends TestCase
{
    private $context;
    private $resultPageFactory;
    private $twofautility;
    private $messageManager;
    private $logger;
    protected function setUp() : void
    {
        $this->context = $this->createMock(Context::class);
        $this->resultPageFactory = $this->createMock(PageFactory::class);
        $this->twofautility = $this->createMock(TwoFAUtility::class);
        $this->messageManager = $this->createMock(ManagerInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
    }
    public function getAction()
    {
        return new BaseAdminActionConcrete($this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger);
    }
    public function testCheckIfSupportQueryFieldsEmptyAllFieldsPresent()
    {
        $this->twofautility->method("\151\x73\x42\154\x61\x6e\153")->willReturn(false);
        $Li8tn = $this->getAction();
        $this->assertNull($Li8tn->checkIfSupportQueryFieldsEmpty(["\x66\157\x6f" => "\x62\x61\x72", "\142\141\172" => "\161\x75\170"]));
    }
    public function testCheckIfSupportQueryFieldsEmptyThrowsSupportQueryException()
    {
        $this->twofautility->method("\151\163\102\154\141\x6e\153")->willReturnCallback(function ($Q9a7M) {
            return $Q9a7M === '' || $Q9a7M === null;
        });
        $Li8tn = $this->getAction();
        $this->expectException(SupportQueryRequiredFieldsException::class);
        $Li8tn->checkIfSupportQueryFieldsEmpty(["\146\157\157" => '', "\x62\141\172" => "\x71\165\x78"]);
    }
    public function testCheckIfRequiredFieldsEmptyAllFieldsPresent()
    {
        $this->twofautility->method("\151\x73\x42\x6c\141\156\x6b")->willReturn(false);
        $Li8tn = $this->getAction();
        $this->assertNull($Li8tn->callCheckIfRequiredFieldsEmpty(["\146\x6f\x6f" => "\142\x61\x72", "\142\x61\172" => "\x71\165\x78"]));
    }
    public function testCheckIfRequiredFieldsEmptyThrowsOnBlank()
    {
        $this->twofautility->method("\x69\x73\102\x6c\141\156\x6b")->willReturnCallback(function ($Q9a7M) {
            return $Q9a7M === '' || $Q9a7M === null;
        });
        $Li8tn = $this->getAction();
        $this->expectException(RequiredFieldsException::class);
        $Li8tn->callCheckIfRequiredFieldsEmpty(["\146\157\x6f" => '', "\x62\x61\172" => "\161\x75\170"]);
    }
    public function testCheckIfRequiredFieldsEmptyThrowsOnMissingKeyInArray()
    {
        $this->twofautility->method("\x69\163\x42\154\141\x6e\x6b")->willReturn(false);
        $Li8tn = $this->getAction();
        $this->expectException(RequiredFieldsException::class);
        $Li8tn->callCheckIfRequiredFieldsEmpty(["\146\157\x6f" => ["\142\141\162" => "\142\x61\172"]]);
    }
    public function testCheckIfRequiredFieldsEmptyThrowsOnBlankInArray()
    {
        $this->twofautility->method("\151\x73\102\x6c\141\x6e\x6b")->willReturnCallback(function ($Q9a7M) {
            return $Q9a7M === '';
        });
        $Li8tn = $this->getAction();
        $this->expectException(RequiredFieldsException::class);
        $Li8tn->callCheckIfRequiredFieldsEmpty(["\146\157\157" => ["\146\157\157" => '']]);
    }
    public function testIsFormOptionBeingSavedReturnsTrue()
    {
        $Li8tn = $this->getAction();
        $this->assertTrue($Li8tn->callIsFormOptionBeingSaved(["\157\x70\x74\151\x6f\156" => "\163\141\166\x65"]));
    }
    public function testIsFormOptionBeingSavedReturnsFalse()
    {
        $Li8tn = $this->getAction();
        $this->assertFalse($Li8tn->callIsFormOptionBeingSaved(["\x6f\x74\150\145\x72" => "\166\141\154\165\145"]));
    }
    public function testCheckIfValidPluginNoException()
    {
        $this->twofautility->method("\x6d\x69\x63\162")->willReturn(true);
        $Li8tn = $this->getAction();
        $this->assertNull($Li8tn->callCheckIfValidPlugin());
    }
    public function testCheckIfValidPluginThrowsException()
    {
        $this->twofautility->method("\155\151\143\162")->willReturn(false);
        $Li8tn = $this->getAction();
        $this->expectException(NotRegisteredException::class);
        $Li8tn->callCheckIfValidPlugin();
    }
}