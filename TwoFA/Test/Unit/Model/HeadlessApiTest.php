<?php

namespace MiniOrange\TwoFA\Test\Unit\Model;

use MiniOrange\TwoFA\Model\HeadlessApi;
use PHPUnit\Framework\TestCase;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\ResourceConnection;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\CustomSMS;
use Magento\Store\Model\StoreManagerInterface;
class HeadlessApiTest extends TestCase
{
    private $headlessApi;
    private $accountManagement;
    private $customerSession;
    private $twofautility;
    private $resourceConnection;
    private $storeManager;
    private $customEmail;
    private $customSMS;
    private $storeMock;
    protected function setUp() : void
    {
        $this->accountManagement = $this->createMock(AccountManagementInterface::class);
        $this->customerSession = $this->createMock(Session::class);
        $this->twofautility = $this->createMock(TwoFAUtility::class);
        $this->resourceConnection = $this->createMock(ResourceConnection::class);
        $this->storeManager = $this->createMock(StoreManagerInterface::class);
        $this->customEmail = $this->createMock(CustomEmail::class);
        $this->customSMS = $this->createMock(CustomSMS::class);
        $this->storeMock = $this->createMock(\Magento\Store\Model\Store::class);
        $this->storeMock->method("\x67\x65\164\127\x65\x62\163\151\x74\145\x49\x64")->willReturn(1);
        $this->storeManager->method("\x67\x65\x74\x53\164\157\162\145")->willReturn($this->storeMock);
        $this->headlessApi = new HeadlessApi($this->accountManagement, $this->customerSession, $this->twofautility, $this->resourceConnection, $this->storeManager, $this->customEmail, $this->customSMS);
    }
    public function testAuthenticateApiReturnsErrorOnInvalidEmail()
    {
        $IoeyO = $this->headlessApi->authenticateApi("\151\x6e\166\141\154\x69\x64", "\x70\x61\163\163", "\153\145\x79");
        $this->assertEquals("\105\122\122\x4f\122", $IoeyO["\x73\x74\141\x74\x75\163"]);
        $this->assertStringContainsString("\x49\156\x76\x61\x6c\x69\x64\x20\165\x73\x65\x72\156\x61\155\145", $IoeyO["\155\x65\163\x73\141\x67\x65"]);
    }
    public function testAuthenticateApiReturnsErrorOnException()
    {
        $this->accountManagement->method("\x61\x75\x74\x68\x65\156\x74\x69\143\x61\x74\x65")->willThrowException(new \Magento\Framework\Exception\LocalizedException(__("\146\x61\151\x6c")));
        $rr8Dq = $this->createMock(\Magento\Store\Model\Store::class);
        $rr8Dq->method("\x67\x65\x74\127\x65\x62\x73\x69\x74\x65\111\x64")->willReturn(1);
        $this->storeManager->method("\147\145\164\x53\x74\x6f\162\145")->willReturn($rr8Dq);
        $this->twofautility->method("\x67\145\164\123\x74\157\x72\145\103\x6f\156\x66\x69\x67")->willReturn(true);
        $IoeyO = $this->headlessApi->authenticateApi("\164\145\163\164\x40\145\x78\x61\155\x70\154\145\56\x63\x6f\155", "\160\x61\163\163", "\153\x65\x79");
        $this->assertEquals("\105\122\x52\x4f\122", $IoeyO["\x73\x74\x61\x74\165\x73"]);
        $this->assertStringContainsString("\x41\x75\x74\150\145\x6e\x74\x69\x63\x61\x74\x69\157\156\x20\146\x61\x69\154\145\144", $IoeyO["\155\145\163\163\x61\147\x65"]);
    }
    public function testLoginApiDelegatesToValidateOtp()
    {
        $FyYBt = $this->getMockBuilder(HeadlessApi::class)->disableOriginalConstructor()->onlyMethods(["\166\x61\x6c\151\x64\141\164\145\x4f\164\x70"])->getMock();
        $FyYBt->expects($this->once())->method("\x76\x61\154\151\x64\141\164\145\117\164\x70")->with("\165\x73\x65\162", "\x6b\x65\171", "\x61\165\164\150", "\164\170", "\157\164\160")->willReturn(["\163\x75\143\x63\x65\163\163" => true]);
        $IoeyO = $FyYBt->loginApi("\x75\x73\x65\x72", "\153\145\x79", "\141\165\x74\150", "\164\x78", "\157\164\x70");
        $this->assertTrue($IoeyO["\x73\165\143\x63\145\163\x73"]);
    }
    public function testValidateOtpWithCustomGatewayEnabledReturnsSuccess()
    {
        $this->twofautility->method("\147\145\x74\123\164\x6f\x72\x65\x43\x6f\156\146\x69\x67")->willReturn(true);
        $this->twofautility->method("\143\165\163\x74\157\x6d\x67\141\164\x65\x77\141\171\x5f\x76\141\154\151\x64\x61\164\145\x4f\x54\x50")->willReturn("\123\x55\103\x43\105\123\123");
        $IoeyO = $this->headlessApi->validateOtp("\165\x73\x65\162", "\x6b\x65\x79", "\117\117\x45", "\164\170", "\x6f\x74\160");
        if (isset($IoeyO["\x73\x75\143\x63\x65\x73\163"]) && isset($IoeyO["\162\145\x73\x70\157\x6e\163\145"]["\x73\x74\141\164\165\163"])) {
            goto VxwvB;
        }
        if (isset($IoeyO["\x6d\x65\x73\163\x61\x67\145"])) {
            goto bFnf0;
        }
        $this->fail("\x55\156\145\170\x70\x65\x63\164\x65\144\x20\162\145\163\x75\154\164\x20\163\164\x72\x75\x63\164\165\162\145\x3a\x20" . var_export($IoeyO, true));
        goto O4rrS;
        VxwvB:
        $this->assertEquals("\x53\x55\x43\103\x45\123\123", $IoeyO["\x73\x75\143\x63\145\x73\163"]);
        $this->assertEquals("\x53\x55\x43\103\x45\x53\x53", $IoeyO["\x72\145\163\160\x6f\x6e\163\145"]["\x73\x74\141\164\165\x73"]);
        goto O4rrS;
        bFnf0:
        $this->assertEquals("\x50\154\x65\141\163\145\x20\x65\x6e\x61\x62\x6c\145\40\x79\x6f\x75\162\x20\146\162\x6f\x6e\164\145\156\x64\40\x74\167\157\x66\x61", $IoeyO["\155\x65\163\x73\141\147\145"]);
        O4rrS:
    }
    public function testValidateOtpWithCustomGatewayDisabledReturnsSuccess()
    {
        $this->twofautility->method("\147\x65\x74\123\x74\157\162\x65\x43\157\156\146\x69\147")->willReturn(false);
        $this->twofautility->method("\166\141\x6c\x69\144\x61\x74\145\117\164\160\x52\x65\161\x75\x65\163\164")->willReturn(["\x73\164\141\164\165\x73" => "\x53\125\x43\x43\x45\x53\x53"]);
        $IoeyO = $this->headlessApi->validateOtp("\165\x73\x65\162", "\x6b\145\x79", "\x4f\117\123", "\164\170", "\157\x74\x70");
        if (isset($IoeyO["\163\x75\x63\143\x65\x73\x73"]) && isset($IoeyO["\x72\x65\163\x70\x6f\x6e\163\145"]["\163\x74\x61\164\x75\x73"])) {
            goto DYFIH;
        }
        if (isset($IoeyO["\x6d\x65\163\x73\x61\147\145"])) {
            goto U3YZ3;
        }
        $this->fail("\x55\x6e\x65\x78\160\x65\x63\x74\145\x64\40\162\x65\163\x75\154\164\40\163\x74\x72\165\143\164\x75\x72\145\x3a\40" . var_export($IoeyO, true));
        goto YCvBD;
        DYFIH:
        $this->assertEquals("\x53\x55\x43\103\x45\x53\x53", $IoeyO["\x73\165\143\x63\145\x73\x73"]);
        $this->assertEquals("\x53\x55\103\103\x45\x53\123", $IoeyO["\162\145\163\160\x6f\156\x73\x65"]["\x73\x74\x61\x74\x75\163"]);
        goto YCvBD;
        U3YZ3:
        $this->assertEquals("\x50\154\x65\x61\163\x65\40\145\x6e\x61\142\x6c\x65\x20\x79\157\x75\162\x20\x66\162\x6f\x6e\x74\145\x6e\144\40\164\x77\157\146\141", $IoeyO["\155\145\x73\x73\141\x67\x65"]);
        YCvBD:
    }
    public function testSendOtpWithInvalidEmailReturnsError()
    {
        $this->twofautility->method("\147\x65\164\x53\164\x6f\162\x65\x43\157\156\146\x69\147")->willReturn(true);
        $IoeyO = $this->headlessApi->sendOtp("\151\x6e\x76\x61\x6c\151\144", "\x2b\x31\62\x33\x34\x35\x36\67\x38\71\60", "\117\x4f\105", "\x6b\145\171");
        $this->assertEquals("\x45\x52\122\x4f\x52", $IoeyO["\x73\164\x61\164\165\x73"]);
    }
    public function testSendOtpWithInvalidPhoneReturnsErrorForOOS()
    {
        $this->twofautility->method("\147\145\x74\123\164\x6f\x72\145\x43\157\156\146\151\x67")->willReturn(true);
        $IoeyO = $this->headlessApi->sendOtp("\x75\x73\145\x72\100\x65\170\x61\x6d\160\154\x65\x2e\x63\x6f\x6d", "\x69\156\x76\141\154\151\x64", "\x4f\117\123", "\x6b\145\x79");
        $this->assertEquals("\105\x52\122\117\122", $IoeyO["\163\x74\x61\164\x75\163"]);
    }
    public function testSendOtpApiWithOtpThrottling()
    {
        $this->twofautility->method("\147\x65\164\x53\145\x73\x73\151\157\156\x56\141\x6c\x75\x65")->willReturn(time());
        $IoeyO = $this->headlessApi->sendOtpApi("\x75\x73\145\x72\100\x65\x78\x61\155\x70\x6c\x65\x2e\143\157\x6d", "\x2b\61\62\x33\x34\65\x36\67\x38\71\60", "\x4f\117\105");
        $this->assertEquals("\x45\122\x52\x4f\x52", $IoeyO['']["\x73\x74\141\164\x75\x73"]);
        $this->assertStringContainsString("\117\124\120\40\163\x65\156\164\x20\141\x20\146\x65\167\x20\x73\x65\x63\x6f\156\144\x73\40\x61\x67\157", $IoeyO['']["\x6d\145\163\x73\141\147\x65"]);
    }
    public function testAuthenticateApiWithInlineRegistrationDisabledReturnsFrontendMessage()
    {
        $rr8Dq = $this->createMock(\Magento\Store\Api\Data\StoreInterface::class);
        $rr8Dq->method("\x67\145\x74\x57\145\x62\x73\151\164\145\x49\144")->willReturn(1);
        $this->storeManager->method("\x67\x65\x74\123\164\x6f\162\145")->willReturn($rr8Dq);
        $this->twofautility->method("\x67\x65\x74\x53\x74\x6f\x72\145\x43\x6f\x6e\x66\151\x67")->willReturn(false);
        $IoeyO = $this->headlessApi->authenticateApi("\x75\x73\x65\x72\100\x65\x78\x61\155\x70\x6c\x65\56\x63\157\155", "\x70\x61\x73\x73\167\157\162\144", "\153\x65\171");
        if (isset($IoeyO["\163\165\x63\x63\145\163\x73"]) && isset($IoeyO["\162\x65\x73\x70\x6f\156\163\x65"]["\163\x74\141\x74\x75\163"])) {
            goto EA5Fe;
        }
        if (isset($IoeyO["\x6d\145\x73\163\x61\x67\x65"])) {
            goto m63qV;
        }
        $this->fail("\x55\156\x65\x78\x70\x65\143\x74\145\x64\40\x72\x65\x73\165\x6c\164\x20\x73\x74\162\165\x63\164\165\162\145\x3a\40" . var_export($IoeyO, true));
        goto hLlC_;
        EA5Fe:
        $this->assertEquals("\123\x55\x43\x43\x45\x53\123", $IoeyO["\x73\165\x63\143\145\163\x73"]);
        $this->assertEquals("\x53\125\x43\x43\x45\x53\123", $IoeyO["\162\x65\x73\x70\157\156\x73\x65"]["\163\x74\141\x74\x75\x73"]);
        goto hLlC_;
        m63qV:
        $this->assertEquals("\x50\154\x65\x61\x73\x65\40\145\x6e\x61\142\154\x65\x20\x79\157\x75\x72\40\146\x72\x6f\156\x74\x65\156\144\40\164\x77\x6f\146\x61", $IoeyO["\x6d\x65\x73\x73\x61\x67\x65"]);
        hLlC_:
    }
    public function testAuthenticateApiWithInlineRegistrationAndCustomGatewayEmail()
    {
        $this->accountManagement->method("\141\x75\x74\150\x65\x6e\x74\151\x63\141\x74\145")->willReturn(true);
        $this->twofautility->method("\x67\145\x74\x53\x74\x6f\x72\x65\103\157\156\x66\x69\x67")->willReturnMap([\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1 => true, \MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL => true]);
        $this->customEmail->method("\x73\x65\156\144\x43\165\x73\164\x6f\x6d\147\x61\164\145\x77\141\x79\x45\155\141\x69\154")->willReturn(["\x73\x74\141\x74\165\x73" => "\x53\125\x43\103\105\123\x53"]);
        $IoeyO = $this->headlessApi->authenticateApi("\165\163\145\x72\100\x65\x78\141\155\x70\x6c\x65\x2e\143\157\x6d", "\160\141\x73\163\x77\x6f\162\144", "\153\145\x79");
        if (isset($IoeyO["\163\x75\143\x63\145\x73\163"]) && isset($IoeyO["\162\145\163\160\157\156\x73\x65"]["\163\164\141\x74\x75\x73"])) {
            goto IJ3H5;
        }
        if (isset($IoeyO["\155\x65\x73\x73\141\x67\145"])) {
            goto FP61V;
        }
        $this->fail("\125\156\145\x78\160\145\x63\x74\145\144\40\162\x65\163\165\x6c\x74\x20\163\x74\x72\x75\x63\164\165\162\145\x3a\40" . var_export($IoeyO, true));
        goto VLyGi;
        IJ3H5:
        $this->assertEquals("\x53\x55\103\x43\105\123\123", $IoeyO["\x73\x75\x63\143\x65\163\163"]);
        $this->assertEquals("\123\x55\103\103\105\x53\123", $IoeyO["\162\145\x73\160\x6f\x6e\163\145"]["\x73\164\x61\164\x75\x73"]);
        goto VLyGi;
        FP61V:
        $this->assertEquals("\x50\154\x65\141\x73\x65\x20\x65\x6e\x61\x62\x6c\x65\40\171\157\x75\162\x20\146\x72\157\x6e\164\x65\x6e\x64\x20\x74\167\x6f\x66\141", $IoeyO["\x6d\x65\163\x73\x61\x67\145"]);
        VLyGi:
    }
    public function testSendOtpWithInlineRegistrationDisabled()
    {
        $this->twofautility->method("\x67\x65\x74\123\164\157\x72\x65\x43\157\156\x66\x69\147")->willReturn(false);
        $IoeyO = $this->headlessApi->sendOtp("\x75\163\x65\x72\x40\x65\x78\141\155\160\x6c\145\56\143\157\x6d", "\53\x31\x32\x33\x34\x35\x36\67\70\x39\x30", "\x4f\117\105", "\153\145\171");
        if (isset($IoeyO["\x73\x75\x63\143\145\x73\x73"]) && isset($IoeyO["\x72\145\163\160\157\x6e\163\145"]["\163\164\141\x74\165\163"])) {
            goto ZhEAX;
        }
        if (isset($IoeyO["\x6d\x65\x73\x73\141\x67\x65"])) {
            goto iHJnJ;
        }
        $this->fail("\x55\156\145\x78\160\145\143\164\145\144\x20\162\x65\163\165\154\164\40\163\x74\x72\x75\x63\164\x75\x72\x65\x3a\40" . var_export($IoeyO, true));
        goto qQTsP;
        ZhEAX:
        $this->assertEquals("\x53\125\103\103\x45\123\123", $IoeyO["\163\165\x63\x63\145\x73\x73"]);
        $this->assertEquals("\123\125\103\103\105\123\x53", $IoeyO["\162\145\x73\x70\x6f\x6e\x73\x65"]["\163\164\141\164\165\163"]);
        goto qQTsP;
        iHJnJ:
        $this->assertEquals("\120\154\x65\141\x73\x65\40\x65\x6e\141\142\154\145\x20\171\157\x75\x72\40\146\x72\157\x6e\x74\x65\156\144\x20\x74\167\157\146\x61", $IoeyO["\x6d\145\163\163\x61\x67\x65"]);
        qQTsP:
    }
    public function testSendOtpWithCustomGatewayEmailEnabledOOE()
    {
        $this->twofautility->method("\x67\145\x74\x53\164\x6f\162\145\x43\157\156\x66\x69\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false]]);
        $this->customEmail->method("\x73\x65\156\x64\103\165\163\164\157\155\147\141\164\x65\x77\x61\x79\x45\x6d\x61\x69\154")->willReturn(["\163\164\x61\164\165\x73" => "\x53\x55\103\103\x45\123\123"]);
        $IoeyO = $this->headlessApi->sendOtp("\165\x73\x65\162\x40\x65\x78\x61\x6d\x70\x6c\145\56\143\157\x6d", "\53\x31\x32\63\x34\x35\66\67\70\71\60", "\x4f\117\105", "\x6b\145\171");
        if (isset($IoeyO["\x73\165\x63\x63\145\x73\163"]) && isset($IoeyO["\x72\145\x73\160\157\x6e\163\x65"]["\x73\164\141\x74\x75\x73"])) {
            goto H23Jr;
        }
        if (isset($IoeyO["\155\x65\163\163\x61\147\x65"])) {
            goto nY_WY;
        }
        $this->fail("\x55\156\145\x78\160\145\143\164\145\144\40\162\x65\x73\x75\154\164\x20\163\164\162\x75\143\164\x75\x72\x65\x3a\40" . var_export($IoeyO, true));
        goto VbSAn;
        H23Jr:
        $this->assertEquals("\x53\x55\x43\103\105\123\x53", $IoeyO["\163\165\143\x63\x65\163\x73"]);
        $this->assertEquals("\123\125\103\103\105\123\x53", $IoeyO["\162\x65\x73\160\x6f\156\163\x65"]["\163\x74\x61\x74\165\x73"]);
        goto VbSAn;
        nY_WY:
        $this->assertEquals("\120\x6c\x65\141\x73\x65\40\145\156\x61\x62\x6c\145\40\171\x6f\165\162\x20\x66\x72\157\x6e\x74\x65\x6e\x64\x20\x74\x77\157\146\141", $IoeyO["\155\x65\x73\x73\141\x67\x65"]);
        VbSAn:
    }
    public function testSendOtpWithCustomGatewaySMSEnabledOOS()
    {
        $this->twofautility->method("\x67\145\164\123\164\x6f\x72\145\x43\157\156\146\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, true]]);
        $this->customSMS->method("\163\145\156\144\x5f\143\x75\163\164\x6f\155\x67\141\x74\145\x77\x61\x79\x5f\163\155\163")->willReturn(["\163\164\141\164\165\x73" => "\123\125\x43\103\x45\123\x53"]);
        $IoeyO = $this->headlessApi->sendOtp("\x75\163\x65\162\x40\x65\170\141\155\x70\154\145\56\x63\x6f\x6d", "\x2b\61\62\63\x34\65\66\67\x38\x39\x30", "\117\117\x53", "\153\x65\171");
        if (isset($IoeyO["\163\x75\143\143\x65\x73\x73"]) && isset($IoeyO["\x72\x65\x73\160\157\x6e\x73\145"]["\x73\x74\x61\x74\165\163"])) {
            goto HYw4Y;
        }
        if (isset($IoeyO["\x6d\145\x73\x73\141\x67\x65"])) {
            goto ltCZd;
        }
        $this->fail("\x55\x6e\x65\170\160\x65\143\x74\x65\x64\x20\x72\145\x73\165\x6c\x74\40\163\164\162\x75\x63\164\165\x72\145\72\x20" . var_export($IoeyO, true));
        goto l4arD;
        HYw4Y:
        $this->assertEquals("\123\125\103\103\105\123\x53", $IoeyO["\x73\x75\143\143\145\163\163"]);
        $this->assertEquals("\x53\125\103\x43\x45\x53\123", $IoeyO["\x72\145\x73\x70\157\156\163\x65"]["\163\164\141\164\165\163"]);
        goto l4arD;
        ltCZd:
        $this->assertEquals("\120\x6c\145\141\163\x65\x20\x65\156\x61\142\x6c\x65\x20\x79\x6f\165\x72\x20\146\162\157\156\164\145\156\144\40\164\x77\x6f\x66\x61", $IoeyO["\x6d\x65\163\163\141\x67\145"]);
        l4arD:
    }
    public function testSendOtpWithCustomGatewaySMSEmailEnabledOOSE()
    {
        $this->twofautility->method("\x67\x65\x74\123\x74\157\162\x65\103\157\x6e\x66\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, true]]);
        $this->customEmail->method("\x73\x65\x6e\144\103\x75\x73\x74\157\155\x67\141\x74\x65\167\x61\x79\105\155\x61\151\x6c")->willReturn(["\163\164\141\x74\165\x73" => "\x53\x55\x43\x43\x45\x53\123"]);
        $this->customSMS->method("\x73\x65\x6e\144\x5f\x63\x75\163\x74\x6f\x6d\147\141\x74\145\167\x61\171\137\163\x6d\163")->willReturn(["\163\164\141\x74\165\163" => "\x53\x55\103\x43\x45\x53\123"]);
        $this->twofautility->method("\117\x54\x50\x5f\x6f\166\x65\x72\x5f\x53\115\123\141\x6e\x64\105\115\101\111\114\x5f\115\x65\x73\163\x61\147\x65")->willReturn("\155\163\147");
        $IoeyO = $this->headlessApi->sendOtp("\x75\163\x65\x72\x40\x65\x78\x61\155\160\154\x65\56\x63\x6f\x6d", "\x2b\x31\x32\x33\x34\65\66\x37\70\71\x30", "\117\117\x53\105", "\153\145\x79");
        if (isset($IoeyO["\163\x75\x63\143\x65\x73\x73"]) && isset($IoeyO["\x72\x65\163\x70\157\x6e\163\x65"]["\x73\164\x61\x74\x75\163"])) {
            goto rXATS;
        }
        if (isset($IoeyO["\155\x65\x73\163\x61\x67\x65"])) {
            goto Zj7In;
        }
        $this->fail("\x55\x6e\145\x78\160\145\x63\x74\145\x64\x20\162\x65\x73\x75\x6c\164\40\163\164\x72\x75\x63\x74\x75\x72\x65\x3a\40" . var_export($IoeyO, true));
        goto zMZu6;
        rXATS:
        $this->assertEquals("\x53\125\103\x43\x45\123\123", $IoeyO["\x73\165\143\143\x65\x73\163"]);
        $this->assertEquals("\123\x55\x43\x43\105\123\123", $IoeyO["\x72\145\x73\x70\157\156\163\145"]["\163\x74\141\x74\x75\163"]);
        goto zMZu6;
        Zj7In:
        $this->assertEquals("\120\x6c\x65\141\x73\145\40\x65\156\141\142\154\x65\40\x79\157\x75\162\40\x66\162\x6f\x6e\x74\145\156\x64\x20\164\x77\x6f\146\x61", $IoeyO["\155\145\x73\x73\141\x67\x65"]);
        zMZu6:
    }
    public function testSendOtpWithCustomGatewayWhatsAppEnabledOOW()
    {
        $this->twofautility->method("\147\145\x74\x53\x74\x6f\162\145\103\x6f\156\146\151\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, true]]);
        $this->twofautility->method("\x73\x65\x6e\144\137\x63\165\x73\164\x6f\x6d\147\x61\164\145\x77\141\x79\137\x77\x68\x61\164\x73\x61\x70\160")->willReturn(["\163\164\141\164\165\x73" => "\x53\x55\x43\x43\x45\x53\123"]);
        $IoeyO = $this->headlessApi->sendOtp("\x75\163\x65\x72\x40\x65\x78\x61\155\x70\154\145\56\x63\157\155", "\53\x31\62\63\x34\x35\x36\x37\x38\x39\x30", "\x4f\117\127", "\x6b\x65\x79");
        if (isset($IoeyO["\x73\x75\143\x63\145\163\x73"]) && isset($IoeyO["\x72\145\x73\160\x6f\156\x73\x65"]["\x73\164\x61\x74\165\163"])) {
            goto ujWjy;
        }
        if (isset($IoeyO["\155\145\x73\x73\x61\147\x65"])) {
            goto dJirY;
        }
        $this->fail("\125\x6e\145\170\x70\x65\143\x74\x65\144\x20\162\145\x73\x75\x6c\x74\40\x73\x74\162\x75\143\164\165\x72\x65\72\40" . var_export($IoeyO, true));
        goto nFT3G;
        ujWjy:
        $this->assertEquals("\123\125\103\x43\105\123\x53", $IoeyO["\x73\x75\143\x63\145\x73\x73"]);
        $this->assertEquals("\123\125\x43\x43\x45\123\x53", $IoeyO["\x72\145\x73\160\x6f\x6e\163\145"]["\163\164\141\x74\165\x73"]);
        goto nFT3G;
        dJirY:
        $this->assertEquals("\x50\154\x65\x61\163\x65\40\x65\x6e\141\142\154\145\x20\171\x6f\165\x72\x20\146\x72\157\x6e\x74\145\156\x64\x20\x74\167\x6f\146\141", $IoeyO["\x6d\145\163\x73\141\147\145"]);
        nFT3G:
    }
    public function testSendOtpWithCustomGatewayWhatsAppDisabledOOW()
    {
        $this->twofautility->method("\x67\145\x74\123\x74\157\x72\145\x43\x6f\156\x66\151\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\x73\145\x6e\x64\x5f\x77\x68\x61\x74\163\141\160\x70")->willReturn(["\x73\x74\141\x74\x75\163" => "\123\x55\x43\103\105\x53\123"]);
        $IoeyO = $this->headlessApi->sendOtp("\165\x73\145\162\x40\145\x78\x61\155\160\154\x65\56\x63\157\155", "\x2b\61\62\63\x34\x35\66\67\x38\x39\x30", "\x4f\117\x57", "\153\x65\x79");
        if (isset($IoeyO["\163\x75\x63\x63\145\x73\x73"]) && isset($IoeyO["\x72\x65\163\160\157\x6e\163\x65"]["\x73\164\x61\164\x75\x73"])) {
            goto GjJlo;
        }
        if (isset($IoeyO["\155\x65\163\163\x61\147\x65"])) {
            goto HFAYG;
        }
        $this->fail("\x55\x6e\x65\170\160\145\x63\164\145\x64\40\162\x65\163\x75\x6c\164\x20\163\164\162\x75\x63\164\x75\x72\x65\x3a\40" . var_export($IoeyO, true));
        goto s8XQb;
        GjJlo:
        $this->assertEquals("\123\125\x43\x43\105\x53\x53", $IoeyO["\163\165\143\143\x65\163\163"]);
        $this->assertEquals("\x53\125\103\103\x45\123\123", $IoeyO["\x72\x65\163\x70\x6f\x6e\x73\145"]["\x73\x74\141\x74\x75\x73"]);
        goto s8XQb;
        HFAYG:
        $this->assertEquals("\x50\x6c\145\141\163\x65\40\145\x6e\x61\142\154\145\x20\x79\x6f\x75\162\40\x66\162\157\156\x74\x65\156\x64\40\x74\167\x6f\x66\141", $IoeyO["\155\145\163\x73\x61\x67\x65"]);
        s8XQb:
    }
    public function testSendOtpApiWithInvalidEmail()
    {
        $this->twofautility->method("\154\157\147\x5f\x64\x65\142\165\147");
        $IoeyO = $this->headlessApi->sendOtpApi("\x69\156\x76\x61\x6c\151\x64", "\53\61\62\x33\64\65\x36\67\70\71\60", "\x4f\117\x45");
        $this->assertEquals("\x45\122\x52\117\122", $IoeyO["\x73\164\141\164\165\x73"]);
    }
    public function testSendOtpApiWithUserRowAndPhoneFromDb()
    {
        $this->twofautility->method("\x67\145\164\123\x65\x73\x73\x69\x6f\x6e\x56\x61\x6c\165\x65")->willReturn(null);
        $this->twofautility->method("\x67\x65\164\x43\165\163\x74\x6f\x6d\x65\162\x4d\x6f\x54\146\x61\125\x73\x65\x72\x44\145\164\x61\x69\x6c\163")->willReturn([["\x63\x6f\165\x6e\164\162\x79\143\x6f\144\145" => "\71\61", "\x70\x68\x6f\x6e\145" => "\x39\71\71\71\x39\x39\x39\71\71\x39", "\141\143\x74\x69\166\145\137\x6d\145\x74\150\x6f\144" => "\117\x4f\x45", "\151\144" => 1]]);
        $this->twofautility->method("\147\x65\164\123\164\x6f\162\145\x43\157\156\146\x69\x67")->willReturn(true);
        $this->customEmail->method("\x73\145\156\x64\x43\165\x73\x74\x6f\155\x67\141\164\x65\167\141\x79\x45\x6d\141\x69\154")->willReturn(["\163\x74\141\x74\165\x73" => "\123\125\x43\x43\105\123\x53"]);
        $this->customSMS->method("\x73\145\156\144\137\x63\165\163\164\157\x6d\147\x61\164\x65\167\x61\x79\x5f\163\x6d\163")->willReturn(["\x73\164\x61\164\x75\163" => "\x53\x55\x43\x43\105\x53\x53"]);
        $this->twofautility->method("\x4f\124\120\137\x6f\166\145\x72\x5f\x53\x4d\123\141\156\144\x45\x4d\x41\x49\x4c\x5f\x4d\x65\163\x73\141\x67\145")->willReturn("\155\163\147");
        $IoeyO = $this->headlessApi->sendOtpApi("\165\x73\145\x72\x40\x65\170\x61\155\160\154\x65\56\143\x6f\x6d", '', "\x4f\x4f\x53");
        $this->assertArrayHasKey('', $IoeyO);
    }
    public function testValidateOtpApiWithCustomGatewayEmailEnabled()
    {
        $this->twofautility->method("\147\145\x74\x53\164\157\x72\x65\x43\x6f\156\x66\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\143\165\163\164\x6f\155\x67\x61\x74\x65\x77\x61\171\137\166\x61\154\x69\x64\x61\164\x65\x4f\x54\x50")->willReturn("\x53\x55\x43\x43\x45\123\123");
        $IoeyO = $this->headlessApi->validateOtpApi("\x75\163\145\162\100\145\170\141\x6d\160\154\x65\56\x63\x6f\x6d", "\x4f\117\105", "\x6f\164\160");
        if (isset($IoeyO["\x73\165\143\x63\145\x73\163"]) && isset($IoeyO["\x72\145\163\x70\157\x6e\163\145"]["\x73\x74\141\x74\165\163"])) {
            goto eV_n4;
        }
        if (isset($IoeyO["\x6d\x65\x73\x73\x61\x67\145"])) {
            goto qDlCd;
        }
        $this->fail("\x55\156\145\170\x70\145\x63\x74\145\144\x20\x72\145\x73\x75\x6c\164\40\163\x74\162\x75\143\x74\165\162\145\x3a\40" . var_export($IoeyO, true));
        goto mVeZv;
        eV_n4:
        $this->assertEquals("\x53\x55\103\x43\105\123\123", $IoeyO["\163\x75\143\143\145\x73\x73"]);
        $this->assertEquals("\123\125\103\x43\x45\x53\123", $IoeyO["\x72\x65\163\160\x6f\x6e\x73\145"]["\x73\164\141\164\x75\163"]);
        goto mVeZv;
        qDlCd:
        $this->assertEquals("\x50\154\x65\141\163\x65\40\x65\x6e\x61\142\154\x65\40\x79\157\165\x72\40\146\162\x6f\156\164\x65\x6e\x64\40\164\x77\157\x66\x61", $IoeyO["\155\x65\x73\x73\141\x67\145"]);
        mVeZv:
    }
    public function testValidateOtpApiWithCustomGatewaySMSEnabled()
    {
        $this->twofautility->method("\x67\145\164\x53\164\x6f\x72\x65\x43\x6f\x6e\146\151\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\x63\165\163\x74\x6f\x6d\x67\141\x74\145\167\141\171\137\166\x61\x6c\151\144\141\164\145\x4f\124\x50")->willReturn("\123\125\x43\103\x45\x53\x53");
        $IoeyO = $this->headlessApi->validateOtpApi("\165\163\145\162\x40\145\170\141\155\160\154\x65\x2e\x63\157\155", "\117\x4f\x53", "\x6f\164\x70");
        if (isset($IoeyO["\163\165\x63\x63\x65\163\x73"]) && isset($IoeyO["\162\x65\163\160\x6f\x6e\163\x65"]["\163\x74\141\164\165\163"])) {
            goto knkhV;
        }
        if (isset($IoeyO["\155\x65\163\163\x61\x67\x65"])) {
            goto Vme3s;
        }
        $this->fail("\125\x6e\x65\170\x70\145\143\164\x65\144\x20\162\x65\163\165\154\164\x20\x73\164\x72\165\x63\x74\165\162\145\72\x20" . var_export($IoeyO, true));
        goto la4vd;
        knkhV:
        $this->assertEquals("\x53\125\103\x43\105\x53\123", $IoeyO["\163\x75\x63\143\x65\163\x73"]);
        $this->assertEquals("\x53\125\103\x43\105\123\123", $IoeyO["\x72\x65\163\x70\157\x6e\163\145"]["\163\x74\x61\x74\165\163"]);
        goto la4vd;
        Vme3s:
        $this->assertEquals("\x50\x6c\x65\141\x73\145\40\145\x6e\x61\142\154\x65\40\x79\157\165\x72\x20\146\x72\x6f\156\164\145\x6e\x64\x20\x74\x77\x6f\x66\141", $IoeyO["\155\145\163\x73\x61\x67\x65"]);
        la4vd:
    }
    public function testValidateOtpApiWithCustomGatewayWhatsAppEnabled()
    {
        $this->twofautility->method("\x67\x65\164\123\164\157\x72\x65\103\x6f\x6e\146\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, true]]);
        $this->twofautility->method("\x63\165\163\164\157\x6d\x67\x61\164\145\x77\141\171\137\x76\x61\x6c\x69\144\x61\164\145\117\x54\120")->willReturn("\123\125\x43\103\x45\123\123");
        $IoeyO = $this->headlessApi->validateOtpApi("\165\x73\x65\162\x40\145\x78\x61\x6d\160\154\145\56\143\x6f\155", "\x4f\x4f\127", "\x6f\164\160");
        if (isset($IoeyO["\x73\165\x63\x63\145\x73\x73"]) && isset($IoeyO["\162\x65\163\160\157\156\x73\x65"]["\163\164\x61\164\165\x73"])) {
            goto a2qih;
        }
        if (isset($IoeyO["\155\145\163\163\141\x67\145"])) {
            goto ELKGw;
        }
        $this->fail("\125\156\145\170\x70\x65\x63\x74\x65\x64\40\162\145\163\165\154\x74\40\163\x74\x72\165\x63\164\x75\162\x65\x3a\x20" . var_export($IoeyO, true));
        goto t4YGp;
        a2qih:
        $this->assertEquals("\x53\125\x43\103\x45\123\x53", $IoeyO["\163\165\x63\x63\145\x73\x73"]);
        $this->assertEquals("\123\125\103\103\x45\123\x53", $IoeyO["\x72\145\x73\x70\157\156\163\145"]["\x73\164\141\164\x75\163"]);
        goto t4YGp;
        ELKGw:
        $this->assertEquals("\120\x6c\x65\x61\x73\145\40\x65\x6e\141\x62\154\x65\40\x79\157\165\162\x20\146\162\x6f\x6e\x74\x65\x6e\144\x20\x74\x77\157\x66\x61", $IoeyO["\x6d\145\x73\x73\141\x67\x65"]);
        t4YGp:
    }
    public function testSendOtpWithCustomGatewayEmailThrowsException()
    {
        $this->twofautility->method("\x67\x65\x74\123\164\x6f\x72\x65\103\x6f\x6e\x66\x69\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false]]);
        $this->customEmail->method("\163\145\x6e\144\103\x75\x73\164\157\155\147\x61\164\145\x77\x61\171\x45\155\141\151\154")->willReturn(["\x73\164\x61\164\165\163" => "\x46\101\111\x4c\105\x44", "\155\x65\163\163\x61\147\145" => "\146\141\151\154"]);
        $IoeyO = $this->headlessApi->sendOtp("\x75\163\145\x72\x40\145\170\x61\155\160\x6c\x65\56\x63\157\155", "\53\x31\62\x33\64\x35\x36\67\70\71\x30", "\117\x4f\x45", "\x6b\145\x79");
        $this->assertArrayHasKey("\x6d\x65\x73\x73\141\147\x65", $IoeyO);
        $this->assertEquals("\x50\154\145\141\163\x65\40\145\x6e\141\x62\154\145\40\171\157\x75\x72\40\146\x72\157\x6e\164\145\x6e\144\40\x74\x77\157\146\x61", $IoeyO["\x6d\145\163\x73\141\147\x65"]);
    }
    public function testSendOtpWithCustomGatewaySmsThrowsException()
    {
        $this->twofautility->method("\x67\145\164\123\x74\157\x72\x65\x43\x6f\156\x66\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, true]]);
        $this->customSMS->method("\x73\145\156\x64\137\x63\165\163\164\157\155\x67\141\164\145\167\141\x79\137\x73\155\x73")->willReturn(["\x73\x74\x61\x74\165\163" => "\x46\x41\111\114\x45\x44", "\x6d\145\163\x73\141\147\x65" => "\x66\141\151\154"]);
        $IoeyO = $this->headlessApi->sendOtp("\165\x73\145\162\100\x65\x78\141\x6d\160\x6c\x65\56\143\x6f\x6d", "\53\61\62\x33\64\65\66\67\x38\x39\60", "\117\x4f\x53", "\x6b\145\171");
        $this->assertArrayHasKey("\x6d\x65\163\163\x61\147\145", $IoeyO);
        $this->assertEquals("\120\x6c\145\x61\163\145\40\145\x6e\141\142\154\x65\40\171\x6f\x75\x72\40\x66\162\157\156\164\145\156\144\40\164\x77\157\146\x61", $IoeyO["\155\145\163\x73\141\x67\145"]);
    }
    public function testSendOtpWithOtpOverSmsAndEmailThrowsException()
    {
        $this->twofautility->method("\147\145\164\123\164\x6f\162\145\x43\x6f\x6e\146\151\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, true]]);
        $this->customEmail->method("\163\x65\x6e\x64\103\165\x73\164\157\x6d\147\141\x74\145\167\141\171\x45\155\141\151\x6c")->willReturn(["\163\164\x61\x74\165\x73" => "\123\125\103\x43\x45\123\x53"]);
        $this->customSMS->method("\x73\145\156\144\137\143\x75\163\164\x6f\x6d\147\141\164\x65\167\x61\171\137\x73\x6d\x73")->willReturn(["\163\164\x61\164\165\x73" => "\123\125\103\103\105\123\x53"]);
        $this->twofautility->method("\117\x54\120\x5f\x6f\166\145\162\137\123\x4d\123\141\x6e\x64\105\115\101\x49\114\137\115\145\163\x73\141\x67\145")->willReturn("\146\141\x69\x6c");
        $IoeyO = $this->headlessApi->sendOtp("\x75\163\x65\162\x40\x65\170\x61\x6d\x70\154\x65\x2e\x63\x6f\155", "\53\61\62\63\x34\x35\x36\x37\70\x39\x30", "\117\x4f\x53\x45", "\153\145\x79");
        $this->assertArrayHasKey("\x6d\x65\163\x73\141\147\x65", $IoeyO);
        $this->assertEquals("\x50\x6c\145\x61\x73\x65\x20\145\x6e\x61\x62\154\x65\40\171\x6f\x75\162\x20\x66\x72\x6f\x6e\164\145\156\144\x20\x74\167\x6f\x66\x61", $IoeyO["\x6d\145\x73\163\x61\x67\x65"]);
    }
    public function testAuthenticateApiWithGetCustomerKeysReturningInvalidStructure()
    {
        $this->accountManagement->method("\141\x75\164\x68\x65\x6e\164\151\143\141\x74\145")->willReturn(true);
        $this->twofautility->method("\x67\x65\x74\x53\x74\157\162\x65\103\157\156\146\x69\147")->willReturnMap([\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1 => true, \MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL => false]);
        $this->twofautility->method("\147\x65\x74\103\165\163\x74\x6f\155\x65\x72\113\x65\x79\163")->willReturn(["\142\x61\144\137\153\x65\171" => "\166\x61\154\165\x65"]);
        $IoeyO = $this->headlessApi->authenticateApi("\165\x73\145\162\100\x65\170\x61\155\160\154\x65\56\x63\x6f\155", "\x70\x61\x73\163\167\157\x72\144", "\x6b\145\x79");
        $this->assertArrayHasKey("\155\x65\163\x73\141\147\145", $IoeyO);
        $this->assertEquals("\x50\x6c\145\141\x73\145\40\145\156\x61\x62\x6c\x65\x20\171\x6f\x75\162\40\146\x72\157\156\x74\x65\156\144\40\x74\167\157\x66\x61", $IoeyO["\155\145\x73\x73\x61\147\x65"]);
    }
    public function testSendOtpWithCurlChallengeReturningInvalidJson()
    {
        $this->accountManagement->method("\x61\165\x74\x68\145\156\164\151\x63\x61\164\145")->willReturn(true);
        $this->twofautility->method("\x67\145\x74\123\164\157\x72\145\x43\157\x6e\x66\151\147")->willReturnMap([\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1 => true, \MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL => false]);
        $this->twofautility->method("\147\x65\x74\103\x75\x73\164\x6f\x6d\x65\162\x4b\x65\171\x73")->willReturn(["\143\165\x73\x74\x6f\155\145\162\137\x6b\x65\x79" => "\x6b\x65\171", "\x61\160\151\113\145\x79" => "\141\160\x69"]);
        $this->twofautility->method("\147\145\164\x41\160\151\125\x72\x6c\x73")->willReturn(["\143\150\141\x6c\x6c\x61\x6e\x67\145" => "\x75\x72\154"]);
        $IoeyO = $this->headlessApi->authenticateApi("\165\x73\x65\162\100\145\x78\141\155\160\x6c\x65\x2e\x63\x6f\155", "\160\141\x73\x73\x77\157\162\x64", "\153\145\x79");
        $this->assertArrayHasKey("\x6d\x65\x73\163\141\147\145", $IoeyO);
        $this->assertEquals("\x50\x6c\x65\141\163\145\x20\x65\156\141\x62\154\145\x20\171\157\165\x72\40\146\162\x6f\156\164\145\156\144\40\x74\x77\x6f\146\141", $IoeyO["\x6d\x65\x73\x73\141\147\145"]);
    }
    public function testSendOtpApiWithNegativeLastOtpSentTime()
    {
        $this->twofautility->method("\147\x65\x74\x53\x65\x73\163\x69\157\x6e\126\x61\x6c\165\145")->willReturn(-100);
        $this->twofautility->method("\147\x65\164\103\x75\163\164\x6f\x6d\x65\162\115\x6f\124\146\x61\x55\163\x65\162\x44\x65\x74\141\151\x6c\x73")->willReturn([["\143\x6f\165\156\x74\x72\x79\x63\x6f\x64\x65" => "\x39\x31", "\x70\150\x6f\x6e\145" => "\x39\x39\x39\x39\71\71\71\x39\71\71", "\141\143\164\151\x76\x65\137\155\145\164\x68\x6f\x64" => "\117\117\x53", "\151\x64" => 1]]);
        $this->twofautility->method("\163\x65\156\144\x5f\157\x74\x70\137\165\x73\x69\156\147\x5f\x6d\x69\x6e\x69\x4f\x72\x61\156\147\145\x5f\147\x61\164\145\167\x61\x79\x5f\x75\x73\x69\156\x67\x41\x70\151\143\x61\154\154")->willReturn(["\163\x74\x61\x74\165\x73" => "\106\101\111\114\105\104", "\x6d\145\163\163\141\147\145" => "\146\141\151\154"]);
        $IoeyO = $this->headlessApi->sendOtpApi("\165\x73\145\x72\100\x65\170\x61\x6d\x70\154\x65\56\x63\157\155", "\x2b\61\62\63\64\65\66\x37\70\71\60", "\x4f\x4f\x45");
        $this->assertArrayHasKey('', $IoeyO);
        $this->assertArrayHasKey("\163\x74\141\164\x75\x73", $IoeyO['']);
        $this->assertEquals("\106\x41\111\114\105\104", $IoeyO['']["\163\x74\141\164\165\163"]);
        $this->assertArrayHasKey("\x6d\145\163\163\x61\x67\x65", $IoeyO['']);
    }
    public function testSendOtpWithUnknownAuthType()
    {
        $this->expectException(\TypeError::class);
        $this->twofautility->method("\x67\145\164\123\x74\157\x72\145\103\157\156\x66\x69\x67")->willReturn(true);
        $this->headlessApi->sendOtp("\x75\163\x65\162\x40\145\x78\x61\155\x70\154\145\56\143\157\155", "\53\x31\x32\x33\x34\65\x36\x37\70\x39\x30", "\125\116\113\x4e\x4f\x57\116", "\153\x65\x79");
    }
    public function testValidateOtpWithUnknownAuthType()
    {
        $this->twofautility->method("\x67\145\x74\123\164\157\x72\x65\x43\x6f\x6e\x66\151\147")->willReturn(false);
        $this->twofautility->method("\166\141\154\x69\144\141\x74\145\117\164\160\x52\x65\161\x75\x65\163\164")->willReturn(["\163\164\141\x74\165\163" => "\x53\x55\103\x43\105\123\x53"]);
        $IoeyO = $this->headlessApi->validateOtp("\165\x73\145\162\100\x65\170\141\x6d\160\x6c\x65\x2e\143\x6f\155", "\153\145\x79", "\x55\116\x4b\x4e\x4f\x57\x4e", "\164\x78", "\157\164\160");
        $this->assertEquals("\123\125\103\x43\x45\x53\x53", $IoeyO["\x73\x75\x63\x63\x65\163\x73"]);
    }
    public function testSendOtpWithCustomGatewayEmail_WhenInlineRegistrationDisabled_ReturnsFrontendMessage()
    {
        $this->twofautility->method("\147\145\x74\x53\x74\x6f\x72\x65\x43\157\156\146\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false]]);
        $this->customEmail->method("\163\145\156\x64\103\165\x73\164\x6f\155\x67\141\x74\145\167\141\171\105\x6d\x61\151\154")->willReturn(["\x73\164\141\164\165\163" => "\x46\x41\111\x4c\105\x44", "\x6d\x65\163\x73\141\147\x65" => "\146\x61\151\x6c"]);
        $IoeyO = $this->headlessApi->sendOtp("\x75\163\145\162\100\x65\x78\141\155\x70\x6c\145\56\143\x6f\155", "\53\61\x32\63\x34\65\66\x37\70\x39\x30", "\x4f\x4f\105", "\x6b\x65\171");
        $this->assertArrayHasKey("\x6d\145\x73\163\x61\147\x65", $IoeyO);
        $this->assertEquals("\x50\154\145\x61\x73\x65\40\145\156\141\142\x6c\145\x20\171\x6f\x75\162\x20\146\162\x6f\156\x74\x65\x6e\x64\x20\x74\167\157\x66\141", $IoeyO["\x6d\145\x73\x73\141\x67\x65"]);
    }
    public function testSendOtpWithCustomGatewayEmail_WhenInlineRegistrationEnabled_ReturnsFailedStatus()
    {
        $this->twofautility->method("\x67\x65\164\x53\164\x6f\x72\145\103\157\156\146\x69\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false]]);
        $this->customEmail->method("\163\x65\x6e\x64\x43\x75\163\x74\x6f\155\147\x61\164\x65\x77\141\171\x45\x6d\141\x69\x6c")->willReturn(["\x73\x74\141\x74\x75\163" => "\x46\101\x49\114\105\104", "\x6d\x65\163\x73\141\x67\x65" => "\x66\141\151\154"]);
        $IoeyO = $this->headlessApi->sendOtp("\165\x73\145\x72\x40\x65\x78\x61\155\160\x6c\x65\56\x63\x6f\x6d", "\53\x31\62\63\64\x35\x36\x37\x38\x39\60", "\x4f\117\x45", "\153\x65\171");
        $this->assertArrayHasKey("\155\145\163\x73\141\147\x65", $IoeyO);
        $this->assertEquals("\120\154\x65\x61\163\x65\40\145\156\141\x62\x6c\x65\40\x79\157\165\x72\x20\x66\162\157\x6e\x74\145\156\144\x20\164\x77\x6f\146\141", $IoeyO["\155\145\x73\163\x61\x67\145"]);
    }
    public function testSendOtpWithCustomGatewayWhatsAppEnabledSuccess()
    {
        $this->twofautility->method("\x67\145\164\x57\145\x62\163\151\x74\145\117\x72\123\x74\157\162\145\102\141\163\x65\x64\x4f\x6e\124\162\151\x61\x6c\123\164\x61\x74\165\x73")->willReturn(1);
        $this->twofautility->method("\147\x65\x74\x53\164\x6f\x72\145\103\157\156\146\151\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, true]]);
        $this->twofautility->method("\163\x65\156\144\137\x63\x75\163\164\x6f\155\x67\x61\x74\x65\x77\141\171\137\167\x68\x61\164\163\141\160\x70")->willReturn(["\x73\x74\141\164\x75\x73" => "\x53\125\x43\103\105\x53\123", "\x6d\x65\x73\x73\141\147\145" => "\163\x65\x6e\x74"]);
        $IoeyO = $this->headlessApi->sendOtp("\165\x73\145\x72\x40\x65\170\x61\155\160\x6c\x65\x2e\143\157\155", "\x2b\61\x32\x33\64\x35\66\67\x38\71\60", "\117\117\127", "\153\x65\171");
        $this->assertArrayHasKey('', $IoeyO);
        $this->assertEquals("\123\x55\x43\x43\105\x53\123", $IoeyO['']["\x73\x74\141\x74\165\163"]);
    }
    public function testSendOtpWithCustomGatewayWhatsAppEnabledFailure()
    {
        $this->twofautility->method("\147\145\x74\127\x65\142\x73\x69\164\x65\117\162\123\164\157\162\x65\x42\141\x73\x65\144\x4f\x6e\x54\x72\x69\x61\x6c\123\x74\x61\164\165\163")->willReturn(1);
        $this->twofautility->method("\x67\x65\x74\x53\164\157\x72\145\103\x6f\x6e\146\x69\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, true]]);
        $this->twofautility->method("\163\145\x6e\144\137\143\x75\x73\x74\157\x6d\x67\141\164\x65\x77\141\171\x5f\x77\x68\x61\164\x73\x61\160\x70")->willReturn(["\x73\x74\x61\x74\x75\163" => "\106\101\x49\114\105\x44", "\x6d\x65\x73\163\141\x67\145" => "\x66\x61\x69\154"]);
        $IoeyO = $this->headlessApi->sendOtp("\165\163\x65\162\x40\145\170\x61\x6d\160\154\145\x2e\x63\157\x6d", "\53\61\62\63\x34\x35\x36\67\70\71\x30", "\117\x4f\x57", "\153\145\x79");
        $this->assertArrayHasKey('', $IoeyO);
        $this->assertEquals("\x46\x41\111\x4c\x45\x44", $IoeyO['']["\163\x74\x61\x74\x75\x73"]);
    }
    public function testSendOtpWithCustomGatewayWhatsAppDisabledFallbackMiniorangeSuccess()
    {
        $this->twofautility->method("\x67\145\164\127\x65\x62\x73\151\x74\x65\x4f\x72\123\164\157\x72\x65\x42\141\163\145\144\x4f\156\x54\x72\x69\141\154\x53\164\141\x74\x75\x73")->willReturn(1);
        $this->twofautility->method("\147\145\164\x53\x74\x6f\x72\x65\103\157\x6e\x66\151\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\x73\145\x6e\x64\x5f\x77\150\141\164\163\x61\160\x70")->willReturn(["\163\x74\141\x74\x75\x73" => "\x53\x55\x43\103\x45\123\x53", "\x6d\145\x73\x73\x61\147\x65" => "\163\x65\156\164"]);
        $IoeyO = $this->headlessApi->sendOtp("\165\163\145\162\100\x65\x78\141\x6d\x70\x6c\x65\56\x63\x6f\155", "\53\61\62\x33\x34\x35\66\67\70\x39\60", "\117\x4f\127", "\153\145\x79");
        $this->assertArrayHasKey('', $IoeyO);
        $this->assertEquals("\123\125\103\x43\105\x53\123", $IoeyO['']["\163\x74\141\164\165\x73"]);
    }
    public function testSendOtpWithCustomGatewayWhatsAppDisabledFallbackMiniorangeFailure()
    {
        $this->twofautility->method("\x67\145\x74\x57\x65\142\163\151\164\x65\x4f\x72\x53\164\157\x72\x65\102\141\163\x65\144\x4f\156\124\x72\x69\x61\x6c\x53\x74\x61\164\x75\163")->willReturn(1);
        $this->twofautility->method("\x67\145\164\x53\x74\x6f\162\145\103\157\x6e\x66\151\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\x73\145\x6e\x64\137\167\x68\141\164\163\x61\x70\x70")->willReturn(["\163\164\141\x74\165\163" => "\x46\101\x49\x4c\105\104", "\x6d\145\x73\163\141\x67\x65" => "\146\x61\x69\x6c"]);
        $IoeyO = $this->headlessApi->sendOtp("\165\x73\145\162\x40\145\170\141\x6d\160\x6c\x65\56\x63\157\155", "\53\x31\x32\63\x34\65\66\x37\70\71\x30", "\117\x4f\x57", "\x6b\x65\171");
        $this->assertArrayHasKey('', $IoeyO);
        $this->assertEquals("\106\101\111\114\x45\x44", $IoeyO['']["\x73\164\141\x74\165\163"]);
    }
    public function testSendOtpOOSEWithOnlyEmailEnabled()
    {
        $this->twofautility->method("\147\x65\x74\127\x65\x62\x73\151\164\145\117\162\123\x74\157\x72\145\102\x61\x73\x65\144\117\156\x54\162\151\141\x6c\123\164\x61\x74\x75\x73")->willReturn(1);
        $this->twofautility->method("\x67\x65\164\123\x74\x6f\x72\145\103\157\x6e\146\151\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false]]);
        $this->customEmail->method("\x73\145\156\144\x43\x75\163\x74\157\155\147\141\x74\x65\167\x61\171\105\155\141\151\x6c")->willReturn(["\x73\164\141\x74\x75\163" => "\123\125\103\x43\x45\x53\123"]);
        $this->customSMS->method("\163\145\x6e\144\x5f\x63\x75\x73\164\157\155\x67\141\164\x65\167\x61\x79\x5f\x73\x6d\163")->willReturn(["\163\x74\x61\x74\165\163" => "\x46\101\x49\x4c\x45\104"]);
        $this->twofautility->method("\117\x54\120\137\157\166\145\162\137\123\x4d\x53\141\156\144\x45\115\x41\x49\x4c\x5f\115\x65\x73\x73\x61\147\x65")->willReturn("\x6d\163\147");
        $IoeyO = $this->headlessApi->sendOtp("\165\x73\x65\x72\100\x65\x78\141\x6d\x70\x6c\x65\x2e\143\x6f\155", "\x2b\x31\62\63\64\x35\x36\x37\x38\x39\x30", "\117\x4f\123\x45", "\153\145\171");
        $this->assertArrayHasKey('', $IoeyO);
        $this->assertEquals("\x53\125\103\x43\105\x53\x53", $IoeyO['']["\163\164\x61\x74\165\163"]);
    }
    public function testSendOtpOOSEWithOnlySMSEnabled()
    {
        $this->twofautility->method("\147\145\x74\127\x65\x62\x73\x69\x74\145\x4f\x72\x53\x74\x6f\162\145\x42\141\x73\145\144\117\156\124\x72\x69\x61\x6c\x53\164\141\x74\165\x73")->willReturn(1);
        $this->twofautility->method("\x67\145\x74\123\x74\x6f\162\145\x43\157\156\x66\151\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, true]]);
        $this->customEmail->method("\x73\x65\x6e\x64\103\x75\x73\164\x6f\x6d\147\141\x74\x65\x77\141\x79\105\x6d\141\151\x6c")->willReturn(["\x73\x74\141\164\x75\x73" => "\106\x41\111\x4c\105\104"]);
        $this->customSMS->method("\163\x65\x6e\144\137\143\165\x73\x74\x6f\x6d\147\141\164\145\x77\141\171\x5f\163\155\163")->willReturn(["\163\x74\141\164\x75\163" => "\x53\125\x43\103\105\x53\123"]);
        $this->twofautility->method("\x4f\x54\x50\137\x6f\x76\x65\162\137\x53\x4d\x53\x61\156\x64\x45\115\101\x49\114\137\115\x65\x73\163\141\x67\x65")->willReturn("\155\x73\147");
        $IoeyO = $this->headlessApi->sendOtp("\165\163\145\x72\x40\145\x78\141\155\x70\x6c\145\x2e\143\157\155", "\x2b\x31\x32\x33\x34\x35\66\x37\70\x39\x30", "\x4f\117\123\x45", "\153\145\171");
        $this->assertArrayHasKey('', $IoeyO);
        $this->assertEquals("\123\x55\x43\103\105\x53\x53", $IoeyO['']["\x73\x74\x61\164\x75\163"]);
    }
    public function testSendOtpWithInvalidCustomerKeys()
    {
        $this->twofautility->method("\x67\x65\164\x53\164\x6f\x72\145\x43\157\x6e\x66\151\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::INVOKE_INLINE_REGISTERATION . 1, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false]]);
        $this->twofautility->method("\x67\x65\x74\103\x75\x73\164\157\x6d\145\x72\113\x65\171\163")->willReturn(null);
        $IoeyO = $this->headlessApi->sendOtp("\165\x73\x65\162\100\145\170\141\x6d\160\154\145\56\143\x6f\155", "\53\x31\62\x33\64\x35\66\67\70\71\60", "\117\x4f\105", "\153\x65\x79");
        $this->assertIsArray($IoeyO);
    }
    public function testSendOtpWithEmptyPhoneFromDb()
    {
        $this->twofautility->method("\147\145\x74\x53\x74\x6f\x72\x65\x43\157\156\x66\151\147")->willReturn(true);
        $this->twofautility->method("\x67\x65\164\103\165\163\164\x6f\x6d\x65\x72\115\x6f\x54\146\141\x55\163\145\162\104\x65\x74\x61\151\x6c\163")->willReturn([["\x63\x6f\165\x6e\x74\162\171\x63\157\144\x65" => '', "\160\x68\x6f\x6e\x65" => '', "\141\143\x74\151\x76\x65\137\155\145\x74\150\x6f\x64" => "\117\117\x53", "\x69\144" => 1]]);
        $IoeyO = $this->headlessApi->sendOtp("\165\163\145\162\x40\145\x78\x61\155\160\154\x65\56\x63\x6f\155", '', "\x4f\117\123", "\x6b\x65\171");
        $this->assertIsArray($IoeyO);
    }
    public function testSendOtpApiWithMissingPhoneForSmsAuthType()
    {
        $this->twofautility->method("\x67\145\164\123\145\x73\163\151\x6f\156\126\141\x6c\x75\145")->willReturn(null);
        $this->twofautility->method("\147\x65\x74\x43\165\163\164\157\x6d\145\x72\115\157\124\146\141\x55\163\145\x72\104\x65\x74\x61\x69\x6c\x73")->willReturn([["\143\x6f\x75\156\164\162\x79\143\x6f\144\x65" => '', "\x70\x68\157\156\x65" => '', "\x61\143\164\151\x76\x65\137\155\x65\164\150\x6f\x64" => "\117\117\123", "\x69\144" => 1]]);
        $IoeyO = $this->headlessApi->sendOtpApi("\165\x73\145\x72\x40\145\x78\x61\x6d\x70\154\145\x2e\x63\157\155", '', "\117\x4f\123");
        $this->assertArrayHasKey('', $IoeyO);
        $this->assertArrayHasKey("\x73\164\x61\x74\x75\x73", $IoeyO['']);
        $this->assertEquals("\105\x52\x52\117\122", $IoeyO['']["\163\x74\141\164\165\163"]);
        $this->assertStringContainsString("\111\x6e\166\x61\x6c\x69\x64\x20\160\x68\157\156\145\40\156\x75\x6d\142\145\162", $IoeyO['']["\x6d\x65\x73\163\141\147\145"]);
    }
}