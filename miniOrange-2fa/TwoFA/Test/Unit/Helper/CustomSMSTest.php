<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper;

use MiniOrange\TwoFA\Helper\CustomSMS;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
class CustomSMSTest extends TestCase
{
    private $twofautility;
    private $inlineTranslation;
    private $context;
    private $customSMS;
    protected function setUp() : void
    {
        $this->twofautility = $this->createMock(TwoFAUtility::class);
        $this->inlineTranslation = $this->createMock(StateInterface::class);
        $this->context = $this->createMock(Context::class);
        $this->context->method("\147\145\164\x4c\x6f\x67\147\x65\x72")->willReturn($this->createMock(\Psr\Log\LoggerInterface::class));
        $this->customSMS = new CustomSMS($this->context, $this->twofautility, $this->inlineTranslation);
    }
    public function testSendCustomgatewaySmsTwilioPositive()
    {
        $this->twofautility->method("\x67\145\164\123\164\157\x72\x65\x43\x6f\x6e\146\x69\x67")->willReturn("\164\x77\x69\154\x69\157");
        $this->twofautility->expects($this->atLeastOnce())->method("\154\157\x67\x5f\x64\145\142\165\x67");
        $y5byD = $this->getMockBuilder(CustomSMS::class)->setConstructorArgs([$this->context, $this->twofautility, $this->inlineTranslation])->onlyMethods(["\x73\x65\156\144\x5f\124\167\x69\154\x69\x6f\x5f\103\x75\x73\164\x6f\155\x47\x61\164\x65\167\141\x79\137\123\x4d\123"])->getMock();
        $y5byD->expects($this->once())->method("\163\x65\x6e\144\137\x54\167\x69\154\x69\x6f\137\103\x75\x73\164\157\155\x47\x61\x74\x65\167\141\171\137\123\115\x53")->willReturn(["\x73\164\x61\x74\165\163" => "\x53\x55\103\x43\105\123\x53"]);
        $jK6zr = $y5byD->send_customgateway_sms("\61\62\x33\x34\65\x36\x37\x38\71\60", "\x31\62\x33\64");
        $this->assertEquals("\123\125\103\103\105\123\123", $jK6zr["\x73\x74\x61\x74\165\163"]);
    }
    public function testSendCustomgatewaySmsNoProvider()
    {
        $this->twofautility->method("\x67\x65\164\123\x74\157\162\x65\103\x6f\156\x66\x69\x67")->willReturn('');
        $jK6zr = $this->customSMS->send_customgateway_sms("\61\62\63\x34\x35\66\x37\70\x39\60", "\x31\62\63\64");
        $this->assertEquals("\106\101\111\114\105\104", $jK6zr["\x73\x74\141\x74\x75\x73"]);
        $this->assertStringContainsString("\116\x6f\x20\x63\165\163\164\x6f\x6d\x20\147\141\x74\145\x77\141\171\x20\155\x65\164\150\157\144\40\x63\x6f\x6e\146\x69\147\165\162\145\x64", $jK6zr["\x6d\145\x73\x73\141\147\x65"]);
    }
    public function testSendTwilioCustomGatewaySmsMissingMessage()
    {
        $this->twofautility->method("\x67\145\x74\x53\164\157\x72\145\x43\157\x6e\146\x69\147")->willReturnMap([["\103\125\123\x54\117\115\x5f\107\101\x54\x45\x57\x41\131\x5f\124\x57\x49\x4c\111\117\x5f\x53\x49\x44", null, "\x73\x69\144"], ["\103\x55\123\124\117\x4d\137\107\x41\x54\x45\127\101\x59\x5f\124\127\111\x4c\x49\x4f\137\x54\117\113\x45\116", null, "\164\157\x6b\x65\156"], ["\103\125\123\x54\x4f\x4d\137\107\x41\x54\105\127\x41\x59\x5f\124\127\111\x4c\111\x4f\x5f\x4e\125\115\102\105\122", null, "\x66\162\157\x6d"], ["\103\125\x53\124\117\115\107\x41\x54\x45\127\101\x59\137\123\115\x53\137\x4d\x45\123\123\101\107\105", null, null]]);
        $jK6zr = $this->customSMS->send_Twilio_CustomGateway_SMS("\61\62\63\64\65\x36\67\70\71\x30", "\61\x32\x33\x34");
        $this->assertEquals("\x46\x41\x49\114\105\x44", $jK6zr["\x73\164\x61\164\165\x73"]);
        $this->assertStringContainsString("\x52\145\x63\x69\x70\151\x65\156\x74\47\163\40\155\x65\163\163\141\x67\145\x20\x69\163\x20\x6e\x6f\164\x20\163\145\x74", $jK6zr["\155\x65\163\x73\x61\x67\145"]);
    }
    public function testSendGetMethodCustomGatewaySmsMissingConfig()
    {
        $this->twofautility->method("\x67\x65\164\123\x74\157\162\145\x43\x6f\156\146\x69\147")->willReturnMap([["\x43\x55\123\124\x4f\x4d\137\107\101\x54\x45\127\101\x59\137\107\105\x54\115\x45\x54\110\117\x44\x5f\x55\x52\x4c", null, null], ["\x43\x55\123\124\x4f\115\107\x41\x54\105\127\x41\x59\x5f\123\x4d\123\x5f\x4d\x45\123\x53\101\x47\105", null, null]]);
        $jK6zr = $this->customSMS->send_GetMethod_CustomGateway_SMS("\61\62\63\x34\65\x36\67\70\x39\x30", "\x31\62\63\64");
        $this->assertEquals("\106\101\111\114\x45\x44", $jK6zr["\163\x74\141\x74\x75\163"]);
        $this->assertStringContainsString("\x53\115\123\40\103\157\156\x66\151\147\x75\x72\x61\164\x69\x6f\156\40\x69\163\x20\x6e\157\x74\40\163\x65\x74\x20\x70\162\157\x70\x65\x72\x6c\171", $jK6zr["\155\x65\x73\x73\141\147\145"]);
    }
    public function testSendPostMethodCustomGatewaySmsMissingConfig()
    {
        $this->twofautility->method("\147\x65\164\x53\164\x6f\x72\145\x43\x6f\156\x66\x69\147")->willReturnMap([["\x43\x55\123\124\117\115\x5f\107\x41\x54\x45\127\101\131\137\120\x4f\123\x54\115\x45\x54\110\x4f\x44\x5f\x55\x52\114", null, null], ["\103\125\123\x54\117\115\x47\101\x54\x45\127\x41\x59\137\x50\x4f\x53\x54\137\106\x49\x45\114\104", null, null], ["\103\125\x53\x54\x4f\115\x47\101\x54\x45\127\x41\131\137\x50\117\123\124\137\120\110\x4f\x4e\105\x5f\101\124\x54\122", null, null], ["\x43\125\123\124\x4f\x4d\107\x41\x54\105\127\x41\131\x5f\x50\x4f\x53\124\137\115\x45\x53\123\101\x47\105\x5f\101\x54\x54\122", null, null], ["\x43\125\x53\124\117\x4d\107\101\124\x45\x57\101\131\x5f\123\x4d\x53\x5f\115\105\123\x53\101\x47\105", null, null]]);
        $jK6zr = $this->customSMS->send_PostMethod_CustomGateway_SMS("\61\x32\63\x34\65\x36\67\x38\71\x30", "\61\62\x33\x34");
        $this->assertEquals("\106\101\x49\114\105\104", $jK6zr["\163\164\x61\164\165\x73"]);
        $this->assertStringContainsString("\123\115\123\x20\103\157\156\x66\x69\147\x75\x72\141\164\151\x6f\x6e\40\x69\163\x20\156\x6f\x74\40\163\x65\x74\40\160\162\157\x70\145\x72\x6c\x79", $jK6zr["\155\x65\x73\163\141\x67\145"]);
    }
}