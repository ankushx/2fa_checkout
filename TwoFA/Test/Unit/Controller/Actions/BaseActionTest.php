<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Actions;

use MiniOrange\TwoFA\Controller\Actions\BaseAction;
use PHPUnit\Framework\TestCase;
use Magento\Framework\App\Action\Context;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use MiniOrange\TwoFA\Helper\Exception\NotRegisteredException;
use MiniOrange\TwoFA\Helper\Exception\RequiredFieldsException;
class BaseActionConcrete extends BaseAction
{
    public $resultRedirectFactory;
    public function __construct($daT8d, $YGlcN, $tSmrw = null)
    {
        $this->resultRedirectFactory = $tSmrw;
        parent::__construct($daT8d, $YGlcN);
    }
    public function execute()
    {
    }
    public function callCheckIfRequiredFieldsEmpty($NlrPm)
    {
        return $this->checkIfRequiredFieldsEmpty($NlrPm);
    }
    public function callSendHTTPRedirectRequest($JBvT4, $MmHNT)
    {
        return $this->sendHTTPRedirectRequest($JBvT4, $MmHNT);
    }
    public function callCheckIfValidPlugin()
    {
        return $this->checkIfValidPlugin();
    }
}
class BaseActionTest extends TestCase
{
    private $context;
    private $twofautility;
    private $resultRedirectFactory;
    private $resultRedirect;
    protected function setUp() : void
    {
        $this->context = $this->createMock(Context::class);
        $this->twofautility = $this->createMock(TwoFAUtility::class);
        $this->resultRedirectFactory = $this->getMockBuilder(\stdClass::class)->addMethods(["\143\162\x65\141\x74\145"])->getMock();
        $this->resultRedirect = $this->getMockBuilder(\stdClass::class)->addMethods(["\x73\x65\x74\125\x72\x6c"])->getMock();
    }
    public function getAction()
    {
        $TO_Um = new BaseActionConcrete($this->context, $this->twofautility, $this->resultRedirectFactory);
        $TO_Um->resultRedirectFactory = $this->resultRedirectFactory;
        return $TO_Um;
    }
    public function testCheckIfRequiredFieldsEmptyAllFieldsPresent()
    {
        $this->twofautility->method("\151\x73\102\154\x61\156\153")->willReturn(false);
        $TO_Um = $this->getAction();
        $this->assertNull($TO_Um->callCheckIfRequiredFieldsEmpty(["\146\157\157" => "\142\x61\x72", "\142\141\172" => "\x71\x75\170"]));
    }
    public function testCheckIfRequiredFieldsEmptyThrowsOnBlank()
    {
        $this->twofautility->method("\151\x73\102\154\x61\156\153")->willReturnCallback(function ($i1qtJ) {
            return $i1qtJ === '' || $i1qtJ === null;
        });
        $TO_Um = $this->getAction();
        $this->expectException(RequiredFieldsException::class);
        $TO_Um->callCheckIfRequiredFieldsEmpty(["\146\157\x6f" => '', "\142\141\x7a" => "\161\x75\170"]);
    }
    public function testCheckIfRequiredFieldsEmptyThrowsOnMissingKeyInArray()
    {
        $this->twofautility->method("\151\x73\x42\154\141\x6e\153")->willReturn(false);
        $TO_Um = $this->getAction();
        $this->expectException(RequiredFieldsException::class);
        $TO_Um->callCheckIfRequiredFieldsEmpty(["\x66\157\157" => ["\x62\141\162" => "\x62\141\x7a"]]);
    }
    public function testCheckIfRequiredFieldsEmptyThrowsOnBlankInArray()
    {
        $this->twofautility->method("\x69\163\x42\x6c\x61\x6e\153")->willReturnCallback(function ($i1qtJ) {
            return $i1qtJ === '';
        });
        $TO_Um = $this->getAction();
        $this->expectException(RequiredFieldsException::class);
        $TO_Um->callCheckIfRequiredFieldsEmpty(["\x66\157\157" => ["\146\x6f\x6f" => '']]);
    }
    public function testSendHTTPRedirectRequestReturnsRedirect()
    {
        $this->resultRedirectFactory->method("\143\x72\x65\141\164\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->expects($this->once())->method("\x73\145\x74\125\x72\x6c")->with("\x68\x74\x74\x70\163\72\57\x2f\145\170\x61\x6d\x70\154\x65\56\143\157\155\57\x72\145\x71\x75\145\x73\x74")->willReturnSelf();
        $TO_Um = $this->getAction();
        $f3o4u = $TO_Um->callSendHTTPRedirectRequest("\x2f\162\x65\x71\x75\x65\163\x74", "\x68\164\164\x70\163\x3a\x2f\x2f\145\x78\x61\155\160\x6c\x65\x2e\x63\x6f\x6d");
        $this->assertSame($this->resultRedirect, $f3o4u);
    }
    public function testCheckIfValidPluginNoException()
    {
        $this->twofautility->method("\155\x69\x63\x72")->willReturn(true);
        $TO_Um = $this->getAction();
        $this->assertNull($TO_Um->callCheckIfValidPlugin());
    }
    public function testCheckIfValidPluginThrowsException()
    {
        $this->twofautility->method("\155\151\143\162")->willReturn(false);
        $TO_Um = $this->getAction();
        $this->expectException(NotRegisteredException::class);
        $TO_Um->callCheckIfValidPlugin();
    }
}