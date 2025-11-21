<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper;

use MiniOrange\TwoFA\Helper\TwoFACustomerRegistration;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
class TwoFACustomerRegistrationTest extends TestCase
{
    private $context;
    private $twofautility;
    private $customerFactory;
    private $storeManager;
    private $registration;
    protected function setUp() : void
    {
        $this->context = $this->createMock(\Magento\Framework\App\Helper\Context::class);
        $this->twofautility = $this->getMockBuilder(\MiniOrange\TwoFA\Helper\TwoFAUtility::class)->disableOriginalConstructor()->onlyMethods(["\147\x65\x74\123\x65\163\163\x69\x6f\156\126\x61\x6c\165\x65"])->getMock();
        $this->customerFactory = $this->createMock(\Magento\Customer\Model\CustomerFactory::class);
        $this->storeManager = $this->createMock(\Magento\Store\Model\StoreManagerInterface::class);
        $this->registration = new TwoFACustomerRegistration($this->context, $this->twofautility, $this->customerFactory, $this->storeManager);
    }
    public function testExecute_DoesNothing()
    {
        $this->assertNull($this->registration->execute());
    }
    public function testCreateNewCustomerAtRegistration_PositiveFlow()
    {
        $yIS2c = ["\x65\155\141\x69\154" => "\x75\163\x65\162\100\145\x78\x61\x6d\160\154\x65\56\143\x6f\155", "\x66\151\162\163\x74\156\141\x6d\x65" => "\112\157\150\x6e", "\x6c\x61\163\164\x6e\x61\155\145" => "\x44\157\145", "\160\141\163\163\167\157\162\x64" => "\x73\x65\x63\x72\145\x74"];
        $this->twofautility->expects($this->once())->method("\147\x65\164\123\x65\163\163\x69\157\x6e\x56\141\x6c\x75\145")->with("\x6d\x6f\137\143\x75\163\164\x6f\x6d\145\162\137\x70\x61\x67\x65\x5f\x70\141\x72\x61\x6d\145\x74\145\x72\x73")->willReturn(json_encode($yIS2c));
        $Nsfca = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\164\x57\x65\142\163\151\x74\145\x49\144"])->getMock();
        $Nsfca->method("\147\x65\x74\x57\x65\x62\163\x69\x74\x65\x49\144")->willReturn(2);
        $GCorc = $this->createMock(\stdClass::class);
        $this->storeManager->method("\147\145\164\127\145\142\163\151\x74\x65")->willReturn($Nsfca);
        $this->storeManager->method("\x67\x65\164\123\164\157\162\x65")->willReturn($GCorc);
        $WXwSP = $this->getMockBuilder(\stdClass::class)->addMethods(["\163\145\164\127\145\142\163\x69\164\x65\111\144", "\x73\145\164\x53\164\x6f\x72\145", "\x73\145\164\x45\155\141\151\154", "\x73\x65\x74\x46\x69\162\163\x74\x6e\141\x6d\x65", "\x73\x65\164\x4c\141\163\x74\x6e\x61\155\145", "\x73\145\x74\120\x61\163\x73\x77\157\x72\144", "\x73\145\x74\107\x72\x6f\165\x70\x49\x64", "\x73\141\x76\145"])->getMock();
        $WXwSP->expects($this->once())->method("\163\145\164\127\145\x62\163\x69\x74\145\x49\144")->with(2)->willReturnSelf();
        $WXwSP->expects($this->once())->method("\x73\145\164\123\x74\157\x72\145")->with($GCorc)->willReturnSelf();
        $WXwSP->expects($this->once())->method("\x73\x65\164\x45\155\141\151\154")->with("\165\163\x65\x72\x40\145\170\141\155\x70\x6c\145\x2e\143\x6f\155")->willReturnSelf();
        $WXwSP->expects($this->once())->method("\163\x65\x74\106\151\x72\163\164\156\x61\155\145")->with("\x4a\157\150\156")->willReturnSelf();
        $WXwSP->expects($this->once())->method("\x73\145\x74\x4c\141\163\x74\x6e\141\155\145")->with("\x44\x6f\145")->willReturnSelf();
        $WXwSP->expects($this->once())->method("\163\145\164\120\x61\163\x73\x77\x6f\x72\144")->with("\x73\145\143\162\145\x74")->willReturnSelf();
        $WXwSP->expects($this->once())->method("\x73\145\164\107\x72\157\x75\160\111\144")->with(1)->willReturnSelf();
        $WXwSP->expects($this->once())->method("\x73\x61\166\x65")->willReturnSelf();
        $this->customerFactory->method("\x63\162\x65\x61\x74\x65")->willReturn($WXwSP);
        $this->registration->createNewCustomerAtRegistration();
    }
}