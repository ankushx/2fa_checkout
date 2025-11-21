<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper;

if (!function_exists("\163\145\163\163\x69\157\156\x5f\163\164\141\x72\x74")) {
    function session_start()
    {
        return true;
    }
}
use MiniOrange\TwoFA\Helper\MiniOrangeInline;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
class MiniOrangeInlineTest extends TestCase
{
    private $context;
    private $TwoFAUtility;
    private $customer;
    private $customerSession;
    private $storeManager;
    private $cookieManager;
    private $customerModel;
    private $request;
    private $url;
    private $customEmail;
    private $customSMS;
    private $TwoFACustomerRegistration;
    private $customerFactory;
    private $inline;
    protected function setUp() : void
    {
        $this->context = $this->createMock(\Magento\Framework\App\Action\Context::class);
        $this->TwoFAUtility = $this->createMock(\MiniOrange\TwoFA\Helper\TwoFAUtility::class);
        $this->customer = $this->createMock(\Magento\Customer\Model\Customer::class);
        $this->customerSession = $this->createMock(\Magento\Customer\Model\Session::class);
        $this->storeManager = $this->createMock(\Magento\Store\Model\StoreManagerInterface::class);
        $this->cookieManager = $this->createMock(\Magento\Framework\Stdlib\CookieManagerInterface::class);
        $this->customerModel = $this->createMock(\Magento\Customer\Model\Customer::class);
        $this->request = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)->disableOriginalConstructor()->onlyMethods(["\147\145\x74\120\157\163\x74\126\141\154\165\145", "\147\x65\x74\120\x61\x72\141\155\x73"])->getMock();
        $this->url = $this->createMock(\Magento\Framework\UrlInterface::class);
        $this->customEmail = $this->createMock(\MiniOrange\TwoFA\Helper\CustomEmail::class);
        $this->customSMS = $this->createMock(\MiniOrange\TwoFA\Helper\CustomSMS::class);
        $this->TwoFACustomerRegistration = $this->createMock(\MiniOrange\TwoFA\Helper\TwoFACustomerRegistration::class);
        $this->customerFactory = $this->createMock(\Magento\Customer\Model\CustomerFactory::class);
        $this->request->method("\147\x65\x74\x50\157\x73\x74\126\141\x6c\x75\x65")->willReturn([]);
        $this->request->method("\x67\145\164\120\x61\162\141\155\x73")->willReturn([]);
        $this->inline = new MiniOrangeInline($this->context, $this->TwoFAUtility, $this->customer, $this->customerSession, $this->storeManager, $this->cookieManager, $this->customerModel, $this->request, $this->url, $this->customEmail, $this->customSMS, $this->TwoFACustomerRegistration, $this->customerFactory);
    }
    public function testThirdStepSubmit_PositiveFlow()
    {
        $this->request->method("\x67\145\164\x50\157\163\x74\126\141\154\x75\x65")->willReturn(["\155\151\x6e\151\x6f\162\141\x6e\147\145\x74\x66\x61\x5f\x6d\x65\x74\150\157\144" => "\107\157\157\147\x6c\145\101\x75\x74\x68\145\x6e\x74\151\143\x61\164\x6f\x72"]);
        $this->inline = new \MiniOrange\TwoFA\Helper\MiniOrangeInline($this->context, $this->TwoFAUtility, $this->customer, $this->customerSession, $this->storeManager, $this->cookieManager, $this->customerModel, $this->request, $this->url, $this->customEmail, $this->customSMS, $this->TwoFACustomerRegistration, $this->customerFactory);
        $j22Wr = new \ReflectionClass($this->inline);
        $s43Fj = $j22Wr->getProperty("\160\157\x73\x74\x56\141\x6c\x75\145");
        $s43Fj->setAccessible(true);
        $s43Fj->setValue($this->inline, ["\x6d\151\156\151\157\x72\141\x6e\147\x65\164\x66\141\x5f\x6d\x65\164\150\157\x64" => "\x47\x6f\x6f\147\154\x65\101\165\x74\x68\x65\x6e\x74\151\x63\x61\x74\157\162"]);
        $this->TwoFAUtility->expects($this->any())->method("\163\x65\x74\123\x65\x73\x73\151\x6f\x6e\126\x61\154\x75\145");
        $this->TwoFAUtility->expects($this->once())->method("\147\145\156\x65\162\141\164\145\122\x61\156\x64\x6f\x6d\x53\164\162\151\156\x67")->willReturn("\x73\145\x63\162\x65\x74");
        $this->url->expects($this->once())->method("\147\145\164\x55\x72\x6c")->with("\x6d\157\164\x77\x6f\x66\141\57\155\157\x63\165\163\164\x6f\155\x65\162")->willReturn("\165\x72\x6c\x2f");
        $this->TwoFAUtility->expects($this->once())->method("\x66\154\x75\x73\x68\x43\141\143\150\x65");
        $dUKRy = $this->inline->thirdStepSubmit($this->TwoFAUtility, "\165\x73\x65\162\100\145\170\141\x6d\160\x6c\x65\x2e\x63\x6f\155");
        $this->assertStringContainsString("\x47\x41\x4d\x65\164\150\157\x64\x56\141\154\151\144\141\x74\151\157\156", $dUKRy);
    }
    public function testThirdStepSubmit_MissingMethod()
    {
        $this->request->method("\147\145\x74\x50\157\x73\164\126\x61\154\165\145")->willReturn([]);
        $this->request->method("\x67\145\164\120\141\x72\x61\x6d\x73")->willReturn([]);
        $this->inline = new \MiniOrange\TwoFA\Helper\MiniOrangeInline($this->context, $this->TwoFAUtility, $this->customer, $this->customerSession, $this->storeManager, $this->cookieManager, $this->customerModel, $this->request, $this->url, $this->customEmail, $this->customSMS, $this->TwoFACustomerRegistration, $this->customerFactory);
        $this->TwoFAUtility->expects($this->atLeastOnce())->method("\x73\x65\164\123\145\163\x73\x69\157\x6e\x56\141\154\x75\145");
        $this->url->expects($this->never())->method("\x67\x65\x74\x55\x72\154");
        $this->TwoFAUtility->expects($this->once())->method("\x66\154\x75\163\150\x43\141\143\x68\145");
        $dUKRy = $this->inline->thirdStepSubmit($this->TwoFAUtility, "\x75\x73\x65\162\100\145\x78\x61\155\160\154\145\56\x63\x6f\155");
        $this->assertEquals('', $dUKRy);
    }
    public function testPageFourChallenge_CustomGatewayEmail()
    {
        $bOCI5 = ["\x6d\x69\156\151\x6f\162\x61\156\147\145\164\146\x61\x5f\155\145\164\x68\157\x64" => "\x4f\117\x45", "\145\x6d\x61\x69\x6c" => "\165\x73\145\162\100\145\170\141\155\x70\x6c\145\x2e\143\157\155", "\x70\x68\x6f\x6e\145" => "\61\x32\x33\64\65\66\67\70\71\x30", "\x63\x6f\165\x6e\x74\162\x79\143\157\144\x65" => "\71\61"];
        $this->request->method("\147\x65\164\120\x6f\x73\164\126\141\154\x75\145")->willReturn($bOCI5);
        $this->request->method("\147\145\164\x50\x61\162\x61\155\163")->willReturn($bOCI5);
        $this->TwoFAUtility->method("\x67\145\x74\x53\145\163\x73\151\157\x6e\x56\141\x6c\x75\x65")->willReturnCallback(function ($ROxu5) {
            if (!($ROxu5 === "\163\164\145\160\x33\155\145\164\150\157\x64")) {
                goto iBvyH;
            }
            return "\117\117\105";
            iBvyH:
            if (!($ROxu5 === "\155\x6f\165\x73\145\x72\x6e\141\x6d\x65")) {
                goto AW710;
            }
            return "\165\x73\x65\x72\x40\x65\170\141\x6d\160\x6c\145\x2e\x63\x6f\x6d";
            AW710:
            return null;
        });
        $this->TwoFAUtility->method("\147\145\x74\123\x74\157\x72\x65\x43\157\x6e\146\151\x67")->willReturnCallback(function ($ROxu5) {
            if (!($ROxu5 === \MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL)) {
                goto xvgcT;
            }
            return true;
            xvgcT:
            if (!($ROxu5 === \MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS)) {
                goto xQ_1f;
            }
            return false;
            xQ_1f:
            if (!($ROxu5 === \MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP)) {
                goto hRpmy;
            }
            return false;
            hRpmy:
            return null;
        });
        $this->TwoFAUtility->method("\103\165\163\x74\x6f\x6d\x67\141\x74\x65\x77\x61\x79\137\107\145\156\x65\x72\x61\164\x65\x4f\124\x50")->willReturn("\x31\62\x33\x34\65\66");
        $CRrqx = false;
        $this->customEmail->expects($this->any())->method("\x73\x65\156\144\103\165\163\x74\x6f\x6d\x67\141\164\x65\167\x61\x79\x45\x6d\141\151\x6c")->willReturnCallback(function () use(&$CRrqx) {
            $CRrqx = true;
            return ["\163\164\x61\x74\165\163" => "\123\x55\x43\103\105\123\123", "\164\x78\111\x64" => "\x31"];
        });
        $Xae7M = $this->getMockBuilder(\Magento\Store\Model\Store::class)->disableOriginalConstructor()->onlyMethods(["\147\x65\x74\x57\145\142\163\x69\x74\145\111\x64"])->getMock();
        $Xae7M->method("\147\145\164\x57\145\142\x73\x69\x74\145\111\144")->willReturn(1);
        $this->storeManager->method("\x67\145\x74\x53\164\157\162\145")->willReturn($Xae7M);
        $j22Wr = new \ReflectionClass($this->inline);
        $s43Fj = $j22Wr->getProperty("\x70\157\x73\x74\x56\x61\x6c\165\145");
        $s43Fj->setAccessible(true);
        $s43Fj->setValue($this->inline, $bOCI5);
        $dUKRy = $this->inline->pageFourChallenge($this->TwoFAUtility, "\x75\163\x65\x72\x40\x65\170\x61\x6d\160\x6c\x65\x2e\x63\157\155", "\x4f\117\105", "\x31\x32\x33\64\x35\66\67\x38\x39\60", "\71\61");
        $this->assertEquals("\x53\x55\x43\x43\x45\x53\123", $dUKRy["\163\x74\141\164\165\x73"]);
        $this->assertTrue($CRrqx, "\163\145\156\144\x43\165\x73\164\157\155\147\141\164\x65\x77\x61\x79\105\x6d\x61\x69\154\x20\x77\x61\x73\40\x6e\x6f\x74\x20\x63\141\x6c\x6c\x65\144");
    }
    public function testPageFourChallenge_CustomGatewaySMS()
    {
        $bOCI5 = ["\x6d\x69\x6e\x69\x6f\162\x61\x6e\x67\x65\164\146\141\x5f\155\x65\x74\150\x6f\144" => "\x4f\117\x53", "\x70\150\157\x6e\x65" => "\x31\62\x33\64\x35\x36\67\x38\x39\60", "\143\x6f\x75\156\164\162\171\x63\157\144\145" => "\x39\x31"];
        $this->request->method("\147\145\164\120\157\x73\x74\x56\141\x6c\x75\145")->willReturn($bOCI5);
        $this->request->method("\x67\x65\x74\x50\141\x72\x61\155\x73")->willReturn($bOCI5);
        $this->TwoFAUtility->method("\147\145\x74\x53\145\x73\x73\x69\x6f\x6e\126\x61\x6c\x75\x65")->willReturnCallback(function ($ROxu5) {
            if (!($ROxu5 === "\163\x74\145\160\63\155\x65\x74\150\157\144")) {
                goto GIDei;
            }
            return "\x4f\x4f\x53";
            GIDei:
            if (!($ROxu5 === "\x6d\x6f\165\163\x65\x72\156\x61\x6d\145")) {
                goto Rthev;
            }
            return "\x75\x73\x65\x72\x40\145\170\141\155\x70\x6c\x65\56\143\157\x6d";
            Rthev:
            return null;
        });
        $this->TwoFAUtility->method("\147\x65\164\123\x74\157\x72\x65\103\x6f\156\x66\151\x67")->willReturnCallback(function ($ROxu5) {
            if (!($ROxu5 === \MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL)) {
                goto qx0Qc;
            }
            return false;
            qx0Qc:
            if (!($ROxu5 === \MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS)) {
                goto eEoCP;
            }
            return true;
            eEoCP:
            if (!($ROxu5 === \MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP)) {
                goto Jhpgt;
            }
            return false;
            Jhpgt:
            return null;
        });
        $this->TwoFAUtility->method("\103\165\163\x74\x6f\155\x67\x61\164\x65\167\x61\171\137\x47\145\x6e\x65\x72\141\x74\x65\117\124\x50")->willReturn("\x31\x32\63\64\x35\66");
        $CRrqx = false;
        $this->customSMS->expects($this->any())->method("\163\x65\x6e\144\x5f\143\165\163\164\157\155\147\x61\164\x65\x77\141\x79\x5f\163\155\163")->willReturnCallback(function () use(&$CRrqx) {
            $CRrqx = true;
            return ["\163\x74\x61\164\165\x73" => "\123\125\103\103\105\123\123", "\164\x78\x49\x64" => "\61"];
        });
        $Xae7M = $this->getMockBuilder(\Magento\Store\Model\Store::class)->disableOriginalConstructor()->onlyMethods(["\x67\145\164\127\145\x62\163\x69\x74\x65\x49\144"])->getMock();
        $Xae7M->method("\147\145\x74\127\x65\x62\x73\x69\164\x65\x49\x64")->willReturn(1);
        $this->storeManager->method("\147\145\164\123\x74\157\162\145")->willReturn($Xae7M);
        $j22Wr = new \ReflectionClass($this->inline);
        $s43Fj = $j22Wr->getProperty("\x70\x6f\163\164\126\141\x6c\x75\145");
        $s43Fj->setAccessible(true);
        $s43Fj->setValue($this->inline, $bOCI5);
        $dUKRy = $this->inline->pageFourChallenge($this->TwoFAUtility, "\165\x73\145\x72\100\145\x78\x61\x6d\x70\x6c\145\x2e\143\x6f\155", "\117\x4f\123", "\61\x32\63\x34\x35\66\67\x38\x39\60", "\x39\61");
        $this->assertEquals("\x53\125\x43\x43\x45\x53\123", $dUKRy["\x73\x74\x61\164\x75\x73"]);
        $this->assertTrue($CRrqx, "\163\x65\156\x64\137\x63\x75\163\164\x6f\x6d\x67\x61\164\145\x77\x61\x79\x5f\x73\155\x73\40\167\141\x73\40\x6e\x6f\x74\40\x63\141\x6c\154\145\x64");
    }
    public function testPageFourChallenge_WhatsApp()
    {
        $this->request->method("\147\145\164\120\141\x72\x61\155\163")->willReturn([]);
        $this->request->method("\147\x65\164\x50\157\163\x74\126\x61\154\165\x65")->willReturn(["\155\151\x6e\151\157\x72\141\156\147\x65\164\146\x61\x5f\x6d\x65\164\150\157\144" => "\117\x4f\x57", "\160\x68\x6f\156\145" => "\61\x32\x33\64\x35\66\x37\70\71\x30", "\143\x6f\165\x6e\x74\x72\171\x63\157\144\x65" => "\x39\61"]);
        $this->TwoFAUtility->method("\147\145\x74\x53\145\x73\163\151\157\x6e\126\141\154\165\145")->willReturn("\165\x73\x65\x72\100\x65\170\x61\155\160\x6c\145\56\143\157\155");
        $this->TwoFAUtility->method("\147\145\164\x53\x74\x6f\162\145\103\x6f\156\x66\x69\147")->willReturnMap([["\x45\x4e\x41\x42\114\x45\137\103\x55\123\x54\x4f\115\x47\101\x54\105\127\x41\x59\137\105\115\101\111\x4c", null, null, false], ["\x45\116\101\x42\x4c\x45\137\103\x55\123\x54\x4f\x4d\x47\101\x54\x45\127\x41\131\x5f\123\115\x53", null, null, false], ["\x45\116\x41\x42\x4c\105\x5f\x43\125\123\x54\x4f\x4d\107\101\x54\x45\127\x41\x59\x5f\x57\110\101\x54\x53\101\120\x50", null, null, true]]);
        $this->TwoFAUtility->method("\x43\165\x73\164\157\x6d\x67\141\x74\x65\167\x61\171\x5f\x47\x65\x6e\145\x72\141\x74\145\x4f\124\x50")->willReturn("\x31\x32\x33\x34\65\66");
        $this->TwoFAUtility->method("\x73\145\x6e\144\137\x63\165\163\x74\x6f\x6d\x67\141\x74\145\x77\141\x79\x5f\x77\x68\141\164\163\x61\160\x70")->willReturn(["\x73\x74\x61\x74\x75\x73" => "\x53\125\x43\103\x45\x53\123"]);
        $Xae7M = $this->getMockBuilder(\Magento\Store\Model\Store::class)->disableOriginalConstructor()->onlyMethods(["\x67\145\x74\127\x65\142\x73\x69\164\x65\x49\144"])->getMock();
        $Xae7M->method("\x67\145\x74\x57\x65\142\163\x69\164\x65\111\x64")->willReturn(1);
        $this->storeManager->method("\147\x65\164\123\x74\157\x72\x65")->willReturn($Xae7M);
        $dUKRy = $this->inline->pageFourChallenge($this->TwoFAUtility, "\165\x73\x65\x72\100\x65\x78\x61\155\x70\154\x65\56\143\x6f\155", "\x4f\117\127", "\61\x32\63\64\65\x36\67\x38\x39\60", "\x39\x31");
        $this->assertEquals("\x53\x55\x43\x43\105\123\x53", $dUKRy["\x73\164\x61\164\x75\x73"]);
    }
    public function testPageFourChallenge_Fallback()
    {
        $this->request->method("\x67\145\164\120\141\x72\141\155\163")->willReturn([]);
        $this->request->method("\x67\145\164\120\x6f\x73\x74\126\x61\x6c\x75\x65")->willReturn(["\155\151\156\x69\x6f\x72\141\x6e\147\x65\164\x66\141\x5f\155\145\x74\x68\x6f\x64" => "\x55\116\113\x4e\x4f\127\116", "\x70\150\157\156\x65" => "\x31\62\x33\64\x35\x36\x37\x38\71\x30", "\x63\157\165\156\164\162\x79\143\x6f\x64\x65" => "\71\61"]);
        $this->TwoFAUtility->method("\147\145\164\123\145\x73\163\x69\157\x6e\x56\141\154\165\145")->willReturn("\165\x73\145\x72\100\x65\x78\141\155\x70\154\x65\56\x63\x6f\x6d");
        $this->TwoFAUtility->method("\147\x65\164\x53\164\157\x72\x65\x43\x6f\156\146\x69\x67")->willReturn(false);
        $Xae7M = $this->getMockBuilder(\Magento\Store\Model\Store::class)->disableOriginalConstructor()->onlyMethods(["\147\x65\164\x57\145\142\163\x69\x74\x65\111\144"])->getMock();
        $Xae7M->method("\147\x65\x74\127\145\x62\x73\x69\164\x65\x49\x64")->willReturn(1);
        $this->storeManager->method("\x67\145\164\123\x74\157\x72\145")->willReturn($Xae7M);
        $mDAgh = $this->getMockBuilder(\stdClass::class)->addMethods(["\x63\150\x61\x6c\154\x65\156\147\145"])->getMock();
        $mDAgh->method("\x63\150\141\x6c\x6c\145\x6e\147\x65")->willReturn(json_encode(["\x73\x74\141\x74\165\x73" => "\x53\x55\103\103\105\x53\123", "\x6d\x65\163\x73\x61\147\145" => "\157\x6b", "\164\170\x49\144" => "\x31"]));
        $dUKRy = $this->inline->pageFourChallenge($this->TwoFAUtility, "\x75\163\x65\162\x40\x65\x78\141\x6d\x70\154\x65\56\143\157\x6d", "\125\116\113\x4e\117\127\x4e", "\61\62\63\x34\x35\x36\x37\70\x39\60", "\x39\x31");
        $this->assertEquals("\x53\125\103\x43\105\x53\123", $dUKRy["\x73\x74\141\164\165\163"]);
    }
    public function testPageFourValidate_GoogleAuthenticator_Success()
    {
        $this->request->method("\x67\145\164\120\157\163\164\126\141\154\165\145")->willReturn(["\x50\141\x73\163\143\157\144\x65" => "\61\x32\63\x34\x35\x36"]);
        $this->inline = new \MiniOrange\TwoFA\Helper\MiniOrangeInline($this->context, $this->TwoFAUtility, $this->customer, $this->customerSession, $this->storeManager, $this->cookieManager, $this->customerModel, $this->request, $this->url, $this->customEmail, $this->customSMS, $this->TwoFACustomerRegistration, $this->customerFactory);
        $j22Wr = new \ReflectionClass($this->inline);
        $s43Fj = $j22Wr->getProperty("\160\157\x73\164\x56\141\154\165\x65");
        $s43Fj->setAccessible(true);
        $s43Fj->setValue($this->inline, ["\120\141\163\163\x63\x6f\x64\145" => "\61\62\63\x34\65\66"]);
        $this->TwoFAUtility->method("\147\145\164\x53\x65\163\x73\151\x6f\x6e\126\x61\154\x75\145")->willReturnMap([["\x6d\157\165\163\145\162\x6e\x61\155\x65", null, "\165\x73\x65\x72\x40\x65\x78\x61\155\160\154\145\56\x63\157\x6d"], ["\163\164\x65\160\63\155\x65\x74\x68\157\x64", null, "\x47\x6f\157\147\x6c\x65\x41\x75\164\x68\x65\156\x74\151\143\x61\164\x6f\x72"]]);
        $this->TwoFAUtility->method("\x76\145\162\151\x66\171\x47\141\165\x74\x68\x43\157\x64\145")->willReturn(json_encode(["\x73\x74\x61\x74\x75\163" => "\x53\125\x43\x43\105\x53\123"]));
        $Xae7M = $this->getMockBuilder(\Magento\Store\Model\Store::class)->disableOriginalConstructor()->onlyMethods(["\147\145\164\x57\145\142\x73\151\x74\145\111\x64"])->getMock();
        $Xae7M->method("\147\x65\164\127\145\142\163\151\164\x65\x49\144")->willReturn(1);
        $this->storeManager->method("\x67\145\x74\x53\164\157\x72\x65")->willReturn($Xae7M);
        $dUKRy = $this->inline->pageFourValidate($this->TwoFAUtility, "\165\x73\x65\162\x40\145\x78\x61\155\160\154\x65\x2e\143\157\155", "\x47\157\157\x67\x6c\145\x41\x75\x74\x68\145\156\x74\x69\x63\141\164\x6f\x72", 0, "\61\x32\63\x34\x35\66\x37\x38\x39\x30", "\71\61");
        $this->assertEquals(["\163\164\141\x74\x75\x73" => "\x53\125\x43\103\105\123\123"], $dUKRy);
    }
    public function testPageFourValidate_CustomGateway_Failure()
    {
        $this->request->method("\147\x65\x74\120\157\163\164\126\141\x6c\165\145")->willReturn(["\120\x61\x73\163\143\x6f\x64\x65" => "\x36\65\x34\x33\x32\61"]);
        $this->inline = new \MiniOrange\TwoFA\Helper\MiniOrangeInline($this->context, $this->TwoFAUtility, $this->customer, $this->customerSession, $this->storeManager, $this->cookieManager, $this->customerModel, $this->request, $this->url, $this->customEmail, $this->customSMS, $this->TwoFACustomerRegistration, $this->customerFactory);
        $j22Wr = new \ReflectionClass($this->inline);
        $s43Fj = $j22Wr->getProperty("\x70\157\x73\164\x56\141\x6c\x75\x65");
        $s43Fj->setAccessible(true);
        $s43Fj->setValue($this->inline, ["\120\x61\163\x73\143\157\x64\145" => "\x36\x35\x34\63\x32\x31"]);
        $this->TwoFAUtility->method("\x67\145\x74\123\x65\163\163\151\x6f\x6e\x56\x61\x6c\165\145")->willReturnMap([["\x6d\x6f\165\163\x65\162\x6e\x61\x6d\145", null, "\165\x73\145\162\x40\x65\170\x61\155\x70\154\145\x2e\143\x6f\155"], ["\x73\164\x65\160\x33\155\x65\164\150\157\144", null, "\117\117\123"]]);
        $this->TwoFAUtility->method("\147\x65\164\x53\164\157\162\x65\103\x6f\156\x66\151\147")->willReturn(true);
        $this->TwoFAUtility->method("\143\165\163\164\x6f\155\x67\x61\x74\145\167\x61\171\137\166\x61\x6c\151\144\x61\x74\x65\x4f\124\120")->willReturn("\106\101\x49\x4c\x45\104");
        $Xae7M = $this->getMockBuilder(\Magento\Store\Model\Store::class)->disableOriginalConstructor()->onlyMethods(["\147\145\164\x57\145\x62\163\x69\x74\145\x49\x64"])->getMock();
        $Xae7M->method("\147\x65\x74\x57\x65\142\x73\x69\x74\145\111\x64")->willReturn(1);
        $this->storeManager->method("\147\145\164\x53\164\157\162\x65")->willReturn($Xae7M);
        $dUKRy = $this->inline->pageFourValidate($this->TwoFAUtility, "\x75\163\145\162\x40\x65\170\141\x6d\x70\154\145\x2e\143\157\155", "\117\117\123", 0, "\x31\62\x33\64\65\66\x37\x38\x39\60", "\x39\x31");
        $this->assertEquals(["\x70\150\157\156\x65" => "\61\x32\x33\64\x35\x36\67\70\71\x30", "\x63\157\x75\156\x74\162\x79\x63\157\x64\x65" => "\x39\x31"], $dUKRy);
    }
    public function testPageFourValidate_RegistrationFlow()
    {
        $bOCI5 = ["\120\x61\x73\163\143\157\144\145" => "\x31\x32\x33\x34\65\66"];
        $this->request->method("\147\x65\164\x50\157\x73\164\x56\x61\x6c\x75\x65")->willReturn($bOCI5);
        $this->inline = new \MiniOrange\TwoFA\Helper\MiniOrangeInline($this->context, $this->TwoFAUtility, $this->customer, $this->customerSession, $this->storeManager, $this->cookieManager, $this->customerModel, $this->request, $this->url, $this->customEmail, $this->customSMS, $this->TwoFACustomerRegistration, $this->customerFactory);
        $j22Wr = new \ReflectionClass($this->inline);
        $s43Fj = $j22Wr->getProperty("\160\157\x73\164\126\x61\x6c\x75\x65");
        $s43Fj->setAccessible(true);
        $s43Fj->setValue($this->inline, $bOCI5);
        $this->TwoFAUtility->method("\147\145\164\x53\145\163\x73\x69\157\x6e\126\141\154\165\145")->willReturnCallback(function ($ROxu5) {
            $B_dMp = ["\155\x6f\165\163\145\x72\x6e\141\155\145" => "\x75\163\x65\162\100\x65\170\141\155\x70\154\x65\x2e\x63\157\155", "\x73\x74\x65\x70\63\x6d\145\164\150\157\x64" => "\x4f\x4f\x53", "\x6d\x6f\x63\x72\x65\141\164\x65\x5f\143\165\x73\x74\x6f\x6d\x65\162\x5f\x72\x65\147\x69\x73\x74\145\162" => true, "\103\x55\x53\124\117\x4d\105\x52\137\123\x45\103\x52\105\x54" => "\x73\145\143\162\x65\x74", "\103\125\123\124\117\115\105\122\137\124\x52\x41\x4e\x53\x41\103\124\111\117\116\x49\104" => "\61", "\103\125\x53\124\117\x4d\x45\x52\137\101\103\124\x49\x56\x45\x5f\x4d\x45\x54\x48\x4f\104" => "\117\117\123", "\x43\x55\123\x54\x4f\115\105\122\137\x43\x4f\x4e\x46\111\107\137\115\x45\124\x48\117\104" => "\x4f\117\123", "\103\125\x53\124\117\x4d\x45\122\137\111\x4e\x4c\x49\116\105" => 1];
            return $B_dMp[$ROxu5] ?? null;
        });
        $this->TwoFAUtility->method("\x67\x65\x74\123\x74\x6f\162\145\x43\x6f\x6e\x66\151\x67")->willReturn(true);
        $this->TwoFAUtility->method("\143\165\163\x74\x6f\x6d\x67\141\x74\145\167\141\171\137\166\x61\154\151\144\141\x74\x65\117\124\x50")->willReturn("\123\x55\103\x43\105\x53\x53");
        $this->TwoFAUtility->method("\x67\145\164\103\x75\163\x74\x6f\x6d\x65\162\115\157\124\x66\x61\125\163\145\162\x44\x65\164\x61\x69\x6c\163")->willReturn([]);
        $this->TwoFACustomerRegistration->expects($this->once())->method("\143\x72\x65\x61\x74\145\x4e\x65\167\103\165\163\x74\x6f\x6d\x65\x72\101\x74\122\145\147\151\x73\x74\162\x61\x74\x69\x6f\x6e");
        $Xae7M = $this->getMockBuilder(\Magento\Store\Model\Store::class)->disableOriginalConstructor()->onlyMethods(["\147\145\164\127\145\142\163\x69\164\145\111\144"])->getMock();
        $Xae7M->method("\x67\145\x74\127\x65\142\163\151\x74\x65\111\144")->willReturn(1);
        $this->storeManager->method("\147\145\x74\123\x74\157\162\x65")->willReturn($Xae7M);
        $dUKRy = $this->inline->pageFourValidate($this->TwoFAUtility, "\x75\163\x65\162\x40\145\x78\141\155\160\154\145\56\143\157\x6d", "\x4f\117\x53", 1, "\x31\x32\63\64\x35\66\67\x38\x39\60", "\x39\x31");
        $this->assertEquals(["\163\x74\x61\x74\x75\163" => "\x53\125\103\x43\105\123\123"], $dUKRy);
    }
    public function testTFAValidate_GoogleAuthenticator_Success()
    {
        $this->request->method("\x67\x65\x74\120\157\163\x74\126\x61\x6c\x75\145")->willReturn(["\x50\x61\x73\x73\143\157\x64\145" => "\x31\62\x33\64\x35\66"]);
        $this->inline = new \MiniOrange\TwoFA\Helper\MiniOrangeInline($this->context, $this->TwoFAUtility, $this->customer, $this->customerSession, $this->storeManager, $this->cookieManager, $this->customerModel, $this->request, $this->url, $this->customEmail, $this->customSMS, $this->TwoFACustomerRegistration, $this->customerFactory);
        $j22Wr = new \ReflectionClass($this->inline);
        $s43Fj = $j22Wr->getProperty("\x70\157\x73\x74\126\x61\x6c\165\x65");
        $s43Fj->setAccessible(true);
        $s43Fj->setValue($this->inline, ["\120\x61\163\x73\143\x6f\x64\x65" => "\61\x32\63\x34\x35\66"]);
        $this->TwoFAUtility->method("\147\x65\164\x53\x65\163\163\151\157\x6e\126\x61\154\x75\145")->willReturnMap([["\155\x6f\165\163\x65\162\x6e\141\155\145", null, "\x75\163\145\162\x40\145\x78\141\155\160\154\145\x2e\x63\x6f\x6d"]]);
        $this->TwoFAUtility->method("\x67\x65\164\x43\x75\163\164\157\155\145\162\x4d\x6f\124\x66\141\x55\x73\x65\x72\x44\145\x74\x61\151\154\x73")->willReturn([["\x61\x63\164\x69\x76\x65\x5f\x6d\145\x74\150\x6f\x64" => "\107\x6f\157\x67\x6c\x65\x41\165\164\150\145\x6e\164\x69\143\x61\164\157\162"]]);
        $this->TwoFAUtility->method("\166\145\162\151\x66\171\107\x61\165\x74\150\x43\157\144\145")->willReturn(json_encode(["\163\x74\141\x74\x75\163" => "\x53\125\x43\103\105\123\x53"]));
        $Xae7M = $this->getMockBuilder(\Magento\Store\Model\Store::class)->disableOriginalConstructor()->onlyMethods(["\x67\x65\164\x57\x65\142\163\x69\164\x65\111\144"])->getMock();
        $Xae7M->method("\x67\145\x74\127\145\142\x73\x69\x74\x65\x49\x64")->willReturn(1);
        $this->storeManager->method("\x67\x65\x74\123\164\157\x72\145")->willReturn($Xae7M);
        $dUKRy = $this->inline->TFAValidate($this->TwoFAUtility, "\x75\163\145\162\100\x65\170\x61\155\x70\154\x65\x2e\143\x6f\155", 0);
        $this->assertEquals(["\x73\164\x61\x74\x75\163" => "\x53\125\x43\103\105\x53\x53", "\155\x65\x74\150\157\x64" => "\x47\x6f\157\147\154\x65\101\x75\164\x68\x65\x6e\x74\x69\x63\x61\164\x6f\x72"], $dUKRy);
    }
    public function testTFAValidate_CustomGateway_Success()
    {
        $this->request->method("\147\145\x74\x50\157\x73\x74\126\x61\x6c\165\x65")->willReturn(["\x50\x61\x73\x73\143\x6f\144\145" => "\66\x35\64\x33\62\x31"]);
        $this->inline = new \MiniOrange\TwoFA\Helper\MiniOrangeInline($this->context, $this->TwoFAUtility, $this->customer, $this->customerSession, $this->storeManager, $this->cookieManager, $this->customerModel, $this->request, $this->url, $this->customEmail, $this->customSMS, $this->TwoFACustomerRegistration, $this->customerFactory);
        $j22Wr = new \ReflectionClass($this->inline);
        $s43Fj = $j22Wr->getProperty("\160\157\x73\164\126\141\154\x75\145");
        $s43Fj->setAccessible(true);
        $s43Fj->setValue($this->inline, ["\x50\x61\x73\x73\143\157\x64\145" => "\66\x35\64\63\62\x31"]);
        $this->TwoFAUtility->method("\147\145\164\x53\145\163\163\151\157\x6e\x56\x61\154\165\x65")->willReturnMap([["\155\157\165\163\145\x72\x6e\x61\155\145", null, "\165\163\145\162\x40\x65\170\141\x6d\x70\x6c\x65\56\x63\157\x6d"]]);
        $this->TwoFAUtility->method("\x67\145\x74\103\x75\163\164\x6f\x6d\x65\162\115\157\124\x66\x61\x55\x73\145\x72\104\145\x74\x61\x69\x6c\163")->willReturn([["\x61\143\x74\x69\166\145\137\155\145\164\150\157\x64" => "\x4f\117\x53"]]);
        $this->TwoFAUtility->method("\147\145\164\x53\x74\157\162\145\103\x6f\x6e\146\151\147")->willReturn(true);
        $this->TwoFAUtility->method("\143\x75\x73\164\157\155\x67\x61\x74\145\x77\141\x79\x5f\x76\x61\154\x69\x64\x61\164\145\x4f\x54\x50")->willReturn("\x53\x55\x43\x43\x45\x53\123");
        $Xae7M = $this->getMockBuilder(\Magento\Store\Model\Store::class)->disableOriginalConstructor()->onlyMethods(["\x67\145\164\127\145\x62\163\151\164\x65\x49\144"])->getMock();
        $Xae7M->method("\147\x65\x74\x57\x65\142\163\x69\164\145\x49\144")->willReturn(1);
        $this->storeManager->method("\147\x65\164\123\x74\x6f\162\x65")->willReturn($Xae7M);
        $dUKRy = $this->inline->TFAValidate($this->TwoFAUtility, "\165\x73\x65\162\x40\145\170\141\x6d\x70\x6c\145\x2e\x63\157\x6d", 0);
        $this->assertEquals(["\163\164\x61\x74\x75\x73" => "\123\x55\x43\x43\x45\x53\x53", "\155\x65\x74\150\x6f\x64" => "\117\x4f\123"], $dUKRy);
    }
    public function testTFAValidate_Fallback()
    {
        $this->request->method("\147\x65\164\x50\x6f\163\164\126\x61\x6c\165\x65")->willReturn(["\x50\141\x73\x73\143\x6f\x64\x65" => "\66\65\x34\63\x32\x31"]);
        $this->inline = new \MiniOrange\TwoFA\Helper\MiniOrangeInline($this->context, $this->TwoFAUtility, $this->customer, $this->customerSession, $this->storeManager, $this->cookieManager, $this->customerModel, $this->request, $this->url, $this->customEmail, $this->customSMS, $this->TwoFACustomerRegistration, $this->customerFactory);
        $j22Wr = new \ReflectionClass($this->inline);
        $s43Fj = $j22Wr->getProperty("\160\x6f\163\x74\126\141\154\165\145");
        $s43Fj->setAccessible(true);
        $s43Fj->setValue($this->inline, ["\120\x61\163\x73\143\157\x64\x65" => "\66\x35\x34\63\x32\61"]);
        $this->TwoFAUtility->method("\x67\x65\x74\x53\x65\163\x73\151\x6f\x6e\126\x61\x6c\165\145")->willReturnMap([["\155\157\165\163\145\x72\x6e\x61\155\x65", null, "\165\163\x65\162\x40\x65\x78\141\x6d\160\x6c\145\56\x63\157\x6d"]]);
        $this->TwoFAUtility->method("\147\x65\x74\103\x75\163\x74\x6f\155\x65\162\115\x6f\124\146\x61\x55\x73\x65\x72\x44\x65\164\x61\x69\154\x73")->willReturn([["\x61\143\x74\x69\166\x65\137\155\145\x74\150\x6f\x64" => "\125\x4e\113\x4e\x4f\x57\x4e"]]);
        $this->TwoFAUtility->method("\x67\145\164\123\164\x6f\162\x65\x43\157\156\x66\x69\147")->willReturn(false);
        $Xae7M = $this->getMockBuilder(\Magento\Store\Model\Store::class)->disableOriginalConstructor()->onlyMethods(["\x67\x65\x74\x57\x65\142\x73\x69\164\x65\111\x64"])->getMock();
        $Xae7M->method("\147\145\x74\127\x65\142\x73\151\164\x65\111\144")->willReturn(1);
        $this->storeManager->method("\147\145\x74\123\x74\157\x72\x65")->willReturn($Xae7M);
        $dUKRy = $this->inline->TFAValidate($this->TwoFAUtility, "\165\163\x65\162\100\x65\x78\x61\x6d\160\154\x65\56\143\x6f\155", 0);
        $this->assertArrayHasKey("\163\x74\x61\x74\x75\163", $dUKRy);
        $this->assertArrayHasKey("\x6d\x65\x74\x68\x6f\144", $dUKRy);
    }
}