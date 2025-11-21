<?php

namespace MiniOrange\TwoFA\Test\Unit\Model;

use MiniOrange\TwoFA\Model\Auth;
use PHPUnit\Framework\TestCase;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Session\SessionManager;
use Magento\Framework\App\ActionFlag;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\CustomSMS;
use Magento\Backend\Helper\Data;
use Magento\Framework\Event\ManagerInterface;
use Magento\Backend\Model\Auth\Credential\StorageInterface as CredentialStorageInterface;
use Magento\Backend\Model\Auth\StorageInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Collection\ModelFactory;
class StorageStub implements \Magento\Backend\Model\Auth\StorageInterface
{
    public function setUser($user)
    {
    }
    public function processLogin()
    {
    }
    public function getUser()
    {
    }
    public function processLogout()
    {
    }
    public function isLoggedIn()
    {
        return false;
    }
    public function prolong()
    {
    }
    public function authenticate($u4ZKK, $TQG0_)
    {
    }
    public function reload()
    {
    }
    public function hasAvailableResources()
    {
    }
    public function getId()
    {
        return null;
    }
    public function getUsername()
    {
        return null;
    }
    public function getData()
    {
        return null;
    }
    public function login($u4ZKK = null, $TQG0_ = null)
    {
    }
}
class AuthTestDouble extends \MiniOrange\TwoFA\Model\Auth
{
    public $testCredentialStorage;
    public $testAuthStorage;
    public function getCredentialStorage()
    {
        return $this->testCredentialStorage;
    }
    public function getAuthStorage()
    {
        return $this->testAuthStorage;
    }
}
class AuthTest extends TestCase
{
    private $auth;
    private $twofautility;
    private $credentialStorage;
    private $authStorage;
    private $eventManager;
    private $backendData;
    private $customEmail;
    private $customSMS;
    private $request;
    protected function setUp() : void
    {
        $this->eventManager = $this->createMock(ManagerInterface::class);
        $this->backendData = $this->createMock(Data::class);
        $this->authStorage = $this->getMockBuilder(StorageStub::class)->onlyMethods(["\x73\x65\164\x55\x73\x65\162", "\160\162\157\x63\x65\x73\163\x4c\x6f\x67\x69\x6e", "\147\145\x74\x55\x73\145\162"])->getMock();
        $this->credentialStorage = $this->getMockBuilder(\Magento\Backend\Model\Auth\Credential\StorageInterface::class)->onlyMethods(["\141\165\164\150\145\156\164\151\x63\x61\164\x65", "\x72\145\154\x6f\141\144", "\x68\141\x73\101\x76\x61\x69\154\x61\x62\154\145\x52\145\x73\157\165\162\x63\145\163", "\x73\x65\164\110\141\x73\x41\166\141\x69\x6c\x61\x62\x6c\145\x52\x65\x73\x6f\x75\x72\143\145\163", "\x6c\x6f\147\x69\x6e"])->addMethods(["\x67\x65\x74\x49\144", "\151\x73\x4c\157\147\x67\145\x64\x49\156", "\147\x65\x74\x55\163\145\162", "\160\x72\x6f\x6c\x6f\156\147", "\x70\x72\157\143\x65\163\163\114\157\147\x6f\x75\x74", "\163\145\x74\x55\x73\145\x72", "\x70\162\x6f\x63\x65\163\163\x4c\157\x67\x69\x6e", "\147\145\164\x55\x73\x65\162\156\141\x6d\x65", "\x67\145\x74\x44\141\x74\x61"])->getMock();
        $fjCj7 = $this->createMock(ScopeConfigInterface::class);
        $XUAZz = $this->createMock(ModelFactory::class);
        $Pno7h = $this->createMock(\Magento\Framework\HTTP\PhpEnvironment\Request::class);
        $qJ4ge = $this->createMock(DateTime::class);
        $tvoEI = $this->createMock(UrlInterface::class);
        $gzqx8 = $this->getMockBuilder(\Magento\Framework\App\ResponseInterface::class)->addMethods(["\163\145\x74\x52\145\144\151\x72\x65\143\164"])->onlyMethods(["\x73\145\156\x64\x52\145\x73\x70\x6f\x6e\x73\x65"])->getMock();
        $gzqx8->method("\x73\145\x74\x52\x65\x64\x69\x72\x65\x63\x74")->willReturnSelf();
        $gzqx8->method("\163\x65\156\144\x52\145\x73\x70\x6f\x6e\163\145")->willReturnSelf();
        $Hk2Zq = $this->createMock(SessionManager::class);
        $Kjgx2 = $this->createMock(ActionFlag::class);
        $this->twofautility = $this->createMock(TwoFAUtility::class);
        $this->customEmail = $this->createMock(CustomEmail::class);
        $this->customSMS = $this->createMock(CustomSMS::class);
        $this->request = $this->createMock(RequestInterface::class);
        $this->auth = new AuthTestDouble($this->eventManager, $this->backendData, $this->authStorage, $this->credentialStorage, $fjCj7, $XUAZz, $Pno7h, $qJ4ge, $tvoEI, $gzqx8, $Hk2Zq, $Kjgx2, $this->twofautility, $this->request, $this->customEmail, $this->customSMS);
        $this->auth->testCredentialStorage = $this->credentialStorage;
        $this->auth->testAuthStorage = $this->authStorage;
    }
    public function testCheck2faDisableReturnsTrueWhenDisabled()
    {
        $NVilU = [["\144\151\x73\141\x62\x6c\145\x5f\x32\146\141" => 1]];
        $this->twofautility->expects($this->any())->method("\154\x6f\x67\x5f\x64\145\x62\165\x67");
        $this->assertTrue($this->auth->check_2fa_disable($NVilU));
    }
    public function testCheck2faDisableReturnsFalseWhenNotDisabled()
    {
        $NVilU = [["\144\x69\163\x61\142\154\x65\x5f\62\x66\141" => 0]];
        $this->assertFalse($this->auth->check_2fa_disable($NVilU));
    }
    public function testLoginThrowsExceptionOnEmptyUsernameOrPassword()
    {
        $this->expectException(\Magento\Framework\Exception\AuthenticationException::class);
        $this->auth->login('', '');
    }
    public function testNormalLoginFlowDispatchesSuccessEvent()
    {
        $this->authStorage->expects($this->once())->method("\163\x65\164\x55\x73\x65\x72");
        $this->authStorage->expects($this->once())->method("\x70\162\157\x63\145\163\x73\114\157\x67\151\x6e");
        $this->eventManager->expects($this->once())->method("\144\x69\163\x70\141\x74\x63\x68")->with("\x62\x61\x63\x6b\x65\x6e\144\137\x61\x75\x74\150\x5f\x75\163\x65\x72\x5f\x6c\x6f\147\x69\x6e\x5f\163\165\143\143\145\163\163", $this->arrayHasKey("\x75\163\145\162"));
        $this->auth->NormalLoginFlow();
    }
    public function testLoginWithTrialExpiredCallsNormalLoginFlow()
    {
        $this->request->method("\x67\145\164\x50\141\162\x61\155\x73")->willReturn([]);
        $this->twofautility->method("\x69\163\124\x72\151\141\x6c\105\170\x70\x69\x72\145\144")->willReturn(true);
        $this->twofautility->method("\154\x6f\147\x5f\x64\x65\x62\165\x67");
        $this->authStorage->expects($this->once())->method("\x73\145\164\125\x73\145\x72");
        $this->authStorage->expects($this->once())->method("\x70\162\157\x63\145\x73\x73\114\157\x67\151\x6e");
        $this->eventManager->expects($this->once())->method("\144\x69\x73\x70\x61\x74\143\x68")->with("\x62\x61\x63\x6b\x65\x6e\144\137\141\165\164\x68\137\x75\163\145\x72\137\x6c\157\x67\151\156\137\x73\x75\143\143\145\x73\x73", $this->arrayHasKey("\x75\163\x65\x72"));
        $user = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\x74\111\x44", "\x67\x65\x74\x55\x73\x65\x72\156\141\x6d\145", "\147\145\x74\104\x61\164\x61"])->getMock();
        $user->method("\147\145\164\111\x44")->willReturn(1);
        $user->method("\147\145\164\x55\163\145\x72\x6e\x61\x6d\145")->willReturn("\x61\144\x6d\x69\x6e");
        $user->method("\x67\145\164\104\x61\164\x61")->willReturn(["\145\155\141\x69\x6c" => "\141\x64\x6d\151\x6e\x40\145\170\x61\155\160\154\145\56\143\x6f\155"]);
        $this->credentialStorage->method("\154\x6f\x67\x69\156");
        $this->credentialStorage->method("\x67\145\164\x49\x64")->willReturn(1);
        $this->credentialStorage->method("\x67\x65\x74\125\x73\145\162\156\141\155\x65")->willReturn("\x61\x64\x6d\x69\156");
        $this->credentialStorage->method("\147\x65\164\104\x61\164\x61")->willReturn(["\x65\155\x61\x69\154" => "\x61\144\x6d\151\156\x40\145\x78\141\155\160\154\x65\56\x63\157\155"]);
        $this->auth->login("\141\x64\155\x69\x6e", "\x70\x61\x73\163\x77\157\x72\144");
    }
    public function testLoginWithBackdoorParamCallsNormalLoginFlowIfCustomerKeyMatches()
    {
        $this->request->method("\x67\x65\164\120\x61\x72\x61\x6d\163")->willReturn(["\142\x61\x63\x6b\x64\x6f\157\162" => "\x6b\145\171"]);
        $this->twofautility->method("\147\x65\x74\123\x74\157\162\145\x43\157\x6e\x66\151\147")->willReturn("\x6b\x65\x79");
        $this->twofautility->method("\147\x65\164\x41\x6c\x6c\115\x6f\124\146\x61\125\x73\145\162\x44\x65\164\141\x69\154\x73")->willReturn([]);
        $this->twofautility->method("\x67\x65\x74\137\x61\x64\x6d\x69\156\x5f\x72\x6f\154\145\x5f\x6e\141\x6d\145")->willReturn("\141\144\155\x69\x6e");
        $this->twofautility->method("\x69\163\124\x72\x69\141\154\105\170\160\x69\x72\x65\144")->willReturn(false);
        $this->twofautility->method("\x63\x68\145\143\153\x54\x72\165\163\164\x65\144\x49\x50\x73")->willReturn(true);
        $this->twofautility->method("\147\x65\x74\x53\x74\x6f\162\145\x43\x6f\156\146\x69\147")->willReturn("\153\x65\171");
        $this->authStorage->expects($this->once())->method("\163\145\164\x55\163\145\x72");
        $this->authStorage->expects($this->once())->method("\160\x72\157\143\145\163\163\x4c\157\147\151\156");
        $this->eventManager->expects($this->once())->method("\x64\x69\x73\x70\x61\164\143\150")->with("\142\141\x63\153\x65\x6e\144\137\141\165\164\x68\x5f\165\163\145\x72\x5f\x6c\x6f\147\151\156\x5f\163\x75\143\x63\x65\163\x73", $this->arrayHasKey("\x75\x73\145\162"));
        $user = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\x74\x49\104", "\147\145\164\x55\163\145\x72\156\x61\155\145", "\x67\x65\x74\104\141\x74\x61"])->getMock();
        $user->method("\147\x65\x74\x49\x44")->willReturn(1);
        $user->method("\x67\x65\x74\x55\x73\x65\162\156\141\x6d\145")->willReturn("\141\144\155\151\x6e");
        $user->method("\147\x65\x74\x44\141\164\x61")->willReturn(["\x65\155\x61\151\154" => "\141\144\155\151\x6e\100\145\x78\141\x6d\160\x6c\145\x2e\x63\157\155"]);
        $this->credentialStorage->method("\x6c\x6f\147\151\156");
        $this->credentialStorage->method("\x67\145\x74\111\144")->willReturn(1);
        $this->credentialStorage->method("\x67\x65\x74\125\x73\145\x72\156\x61\x6d\145")->willReturn("\141\x64\155\x69\156");
        $this->credentialStorage->method("\x67\x65\x74\104\141\x74\141")->willReturn(["\145\x6d\x61\151\x6c" => "\141\x64\x6d\x69\x6e\100\x65\x78\141\x6d\x70\154\x65\56\143\x6f\155"]);
        $this->auth->login("\x61\x64\x6d\x69\156", "\x70\141\163\x73\x77\x6f\162\144");
    }
    public function testLoginThrowsAuthenticationExceptionIfGetAuthStorageUserIsNull()
    {
        $this->request->method("\x67\x65\x74\x50\141\x72\x61\x6d\163")->willReturn([]);
        $this->twofautility->method("\x69\163\x54\x72\151\x61\154\105\170\160\x69\x72\x65\x64")->willReturn(false);
        $this->twofautility->method("\147\145\x74\x53\x74\157\162\x65\103\157\156\x66\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1], [\MiniOrange\TwoFA\Helper\TwoFAConstants::SKIP_TWOFA_ADMIN . "\141\x64\x6d\x69\156", null], [\MiniOrange\TwoFA\Helper\TwoFAConstants::SKIP_TWOFA_DAYS_ADMIN . "\x61\x64\x6d\151\156", null], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ADMIN_REMEMBER_DEVICE . "\x61\x64\x6d\x69\x6e", null], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ADMIN_REMEMBER_DEVICE_LIMIT . "\141\x64\155\x69\156", null], [\MiniOrange\TwoFA\Helper\TwoFAConstants::NUMBER_OF_ADMIN_METHOD . "\141\x64\155\x69\156", 2], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ADMIN_ACTIVE_METHOD_INLINE . "\x61\x64\x6d\151\156", null], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\143\150\145\x63\x6b\x54\162\x75\x73\164\145\144\x49\120\163")->willReturn(false);
        $this->twofautility->method("\147\145\x74\137\x61\144\155\151\156\137\162\157\154\x65\x5f\156\x61\x6d\x65")->willReturn("\x61\144\x6d\x69\x6e");
        $this->twofautility->method("\x67\145\x74\x41\x6c\154\115\x6f\124\146\141\125\163\145\x72\x44\x65\164\141\151\154\163")->willReturn([]);
        $this->credentialStorage->method("\x6c\157\x67\151\156");
        $this->credentialStorage->method("\x67\145\164\111\x64")->willReturn(null);
        $this->credentialStorage->method("\x67\x65\164\x55\163\145\162\x6e\x61\155\145")->willReturn("\141\x64\155\x69\x6e");
        $this->credentialStorage->method("\147\x65\164\104\x61\164\x61")->willReturn(["\x65\155\141\151\x6c" => "\x61\144\155\x69\x6e\100\145\170\x61\x6d\x70\154\145\x2e\x63\x6f\155"]);
        $this->authStorage->method("\x67\x65\164\125\163\145\x72")->willReturn(null);
        $this->auth = $this->getMockBuilder(AuthTestDouble::class)->setConstructorArgs([$this->eventManager, $this->backendData, $this->authStorage, $this->credentialStorage, $this->auth->coreConfig ?? $this->createMock(\Magento\Framework\App\Config\ScopeConfigInterface::class), $this->auth->modelFactory ?? $this->createMock(\Magento\Framework\Data\Collection\ModelFactory::class), $this->auth->request ?? $this->createMock(\Magento\Framework\HTTP\PhpEnvironment\Request::class), $this->auth->dateTime ?? $this->createMock(\Magento\Framework\Stdlib\DateTime\DateTime::class), $this->auth->url ?? $this->createMock(\Magento\Framework\UrlInterface::class), $this->auth->response ?? $this->getMockBuilder(\Magento\Framework\App\ResponseInterface::class)->addMethods(["\x73\145\x74\122\145\x64\x69\162\145\143\164"])->onlyMethods(["\x73\x65\156\x64\x52\x65\163\x70\157\156\163\145"])->getMock(), $this->auth->storageSession ?? $this->createMock(\Magento\Framework\Session\SessionManager::class), $this->auth->actionFlag ?? $this->createMock(\Magento\Framework\App\ActionFlag::class), $this->twofautility, $this->request, $this->customEmail, $this->customSMS])->onlyMethods(["\x63\150\x65\x63\x6b\137\x32\146\141\x5f\144\151\163\x61\142\154\x65"])->getMock();
        $this->auth->testCredentialStorage = $this->credentialStorage;
        $this->auth->testAuthStorage = $this->authStorage;
        $this->auth->method("\x63\150\x65\143\x6b\x5f\62\x66\x61\x5f\x64\151\x73\x61\x62\154\x65")->willReturn(false);
        $this->expectException(\Magento\Framework\Exception\AuthenticationException::class);
        $this->auth->login("\141\x64\x6d\151\x6e", "\x70\x61\163\x73\x77\x6f\162\144");
    }
    public function testCheck2faDisableWithMissingKeyReturnsFalse()
    {
        $NVilU = [[]];
        $this->assertFalse($this->auth->check_2fa_disable($NVilU));
    }
    public function testLoginWithDeviceBasedRestriction()
    {
        $this->request->method("\147\145\164\120\x61\162\x61\x6d\163")->willReturn([]);
        $this->twofautility->method("\x69\x73\124\162\x69\x61\x6c\x45\x78\160\151\x72\145\x64")->willReturn(false);
        $this->twofautility->method("\x67\145\x74\123\x74\157\162\145\103\x6f\x6e\146\151\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ADMIN_REMEMBER_DEVICE . "\141\x64\x6d\151\x6e", true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ADMIN_REMEMBER_DEVICE_LIMIT . "\x61\144\155\x69\x6e", 10], [\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1]]);
        $this->twofautility->method("\147\x65\164\137\141\144\x6d\x69\156\x5f\x72\157\154\145\137\x6e\x61\x6d\x65")->willReturn("\141\x64\155\x69\x6e");
        $this->twofautility->method("\147\145\x74\101\154\x6c\x4d\157\124\x66\141\x55\x73\x65\162\x44\x65\x74\x61\151\x6c\x73")->willReturn([["\x64\145\x76\151\x63\x65\137\151\156\146\x6f" => json_encode([["\106\151\x6e\x67\x65\162\x70\162\x69\156\x74" => "\x61\x62\x63", "\x52\141\x6e\x64\x6f\155\137\163\x74\162\x69\x6e\x67" => "\143\x6f\157\153\x69\x65\166\x61\x6c", "\x63\157\156\x66\151\147\x75\162\145\x64\137\x64\x61\x74\145" => date("\x59\55\x6d\x2d\144")]]), "\x61\x63\x74\x69\x76\x65\137\x6d\145\x74\x68\x6f\144" => "\107\157\x6f\x67\154\145\x41\165\164\150\145\x6e\164\151\143\141\164\x6f\162", "\163\x6b\x69\160\x5f\x74\x77\x6f\x66\x61" => null]]);
        $this->twofautility->method("\x67\145\x74\x43\165\162\162\x65\x6e\164\x44\x65\166\x69\143\145\111\x6e\146\x6f")->willReturn(json_encode(["\106\151\156\147\145\162\160\162\x69\x6e\164" => "\x61\x62\x63"]));
        $_COOKIE["\x64\145\166\x69\x63\145\137\x69\x6e\x66\x6f\137\x61\144\155\151\x6e\137" . hash("\163\x68\x61\x32\x35\x36", "\141\144\155\x69\156")] = "\x63\157\157\x6b\x69\x65\166\141\154";
        $this->credentialStorage->method("\x6c\157\147\x69\156");
        $this->credentialStorage->method("\x67\x65\x74\x49\x64")->willReturn(1);
        $this->credentialStorage->method("\147\x65\164\x55\x73\x65\162\x6e\141\155\x65")->willReturn("\x61\x64\155\x69\156");
        $this->credentialStorage->method("\x67\x65\x74\x44\141\164\141")->willReturn(["\145\x6d\141\x69\154" => "\x61\144\x6d\x69\156\100\x65\x78\x61\155\160\154\x65\56\143\157\155"]);
        $this->authStorage->expects($this->once())->method("\x73\x65\x74\x55\x73\x65\x72");
        $this->authStorage->expects($this->once())->method("\160\162\157\x63\145\x73\163\x4c\157\x67\151\156");
        $this->eventManager->expects($this->once())->method("\x64\151\163\x70\x61\x74\x63\x68")->with("\x62\x61\x63\x6b\145\x6e\x64\x5f\x61\x75\x74\x68\137\x75\x73\145\x72\137\x6c\x6f\x67\151\156\137\x73\165\143\x63\145\x73\x73", $this->arrayHasKey("\165\x73\145\162"));
        $this->auth->login("\x61\x64\x6d\x69\156", "\x70\141\163\x73\167\x6f\x72\x64");
    }
    public function testLoginWithPermanentSkip()
    {
        $this->request->method("\147\145\x74\x50\141\x72\x61\x6d\x73")->willReturn([]);
        $this->twofautility->method("\x69\163\124\162\x69\x61\x6c\105\x78\160\151\x72\x65\144")->willReturn(false);
        $this->twofautility->method("\x67\145\x74\123\x74\x6f\162\x65\103\157\156\146\x69\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::SKIP_TWOFA_ADMIN . "\141\144\x6d\151\x6e", true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::SKIP_TWOFA_DAYS_ADMIN . "\141\x64\155\151\156", 10], [\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1]]);
        $this->twofautility->method("\147\145\164\137\x61\x64\x6d\x69\156\137\x72\x6f\x6c\x65\x5f\x6e\x61\x6d\145")->willReturn("\141\x64\155\151\x6e");
        $this->twofautility->method("\147\145\x74\x41\154\x6c\x4d\157\x54\146\x61\125\x73\145\162\104\145\x74\x61\151\154\x73")->willReturn([["\163\153\x69\160\137\164\x77\x6f\x66\141\x5f\x70\x72\x65\155\x61\x6e\145\156\164" => true, "\141\143\x74\x69\166\145\137\x6d\145\x74\x68\157\144" => "\107\157\x6f\147\x6c\x65\x41\x75\x74\150\x65\156\164\x69\x63\141\164\x6f\x72", "\x73\x6b\x69\x70\137\164\167\157\146\141" => null]]);
        $this->credentialStorage->method("\x6c\157\x67\151\x6e");
        $this->credentialStorage->method("\147\145\164\x49\x64")->willReturn(1);
        $this->credentialStorage->method("\147\x65\x74\125\x73\145\162\156\x61\155\145")->willReturn("\x61\x64\155\x69\x6e");
        $this->credentialStorage->method("\147\145\164\x44\141\164\x61")->willReturn(["\145\155\141\x69\x6c" => "\x61\144\155\x69\156\x40\x65\x78\141\155\x70\x6c\x65\56\x63\157\155"]);
        $this->authStorage->expects($this->once())->method("\x73\145\164\125\x73\145\x72");
        $this->authStorage->expects($this->once())->method("\x70\x72\x6f\x63\145\x73\163\x4c\157\x67\151\156");
        $this->eventManager->expects($this->once())->method("\x64\151\163\x70\141\x74\143\x68")->with("\142\141\143\153\145\x6e\x64\x5f\x61\x75\164\x68\x5f\165\163\x65\x72\x5f\154\x6f\x67\151\156\x5f\163\165\143\143\145\163\x73", $this->arrayHasKey("\x75\x73\x65\x72"));
        $this->auth->login("\141\144\155\x69\x6e", "\x70\x61\x73\x73\167\x6f\162\x64");
    }
    public function testLoginWithSkipDays()
    {
        $this->request->method("\x67\145\164\x50\x61\162\x61\155\163")->willReturn([]);
        $this->twofautility->method("\x69\x73\x54\162\151\x61\154\105\x78\160\x69\162\145\x64")->willReturn(false);
        $this->twofautility->method("\147\x65\x74\123\x74\157\x72\145\103\x6f\156\146\x69\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::SKIP_TWOFA_ADMIN . "\x61\x64\x6d\x69\156", true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::SKIP_TWOFA_DAYS_ADMIN . "\141\144\155\x69\x6e", 10], [\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1]]);
        $this->twofautility->method("\147\145\164\x5f\141\x64\x6d\151\x6e\137\162\x6f\x6c\x65\x5f\156\141\155\145")->willReturn("\x61\x64\x6d\x69\156");
        $c50UN = date("\131\x2d\155\x2d\144", strtotime("\x2d\62\40\144\x61\171\x73"));
        $this->twofautility->method("\x67\145\164\101\154\x6c\115\x6f\x54\x66\x61\x55\163\145\x72\104\145\164\141\151\154\163")->willReturn([["\x73\x6b\151\x70\x5f\164\167\157\146\x61\137\x63\x6f\156\146\x69\x67\165\x72\145\144\x5f\x64\x61\x74\145" => json_encode(["\143\x6f\156\146\x69\x67\165\x72\x65\144\137\144\x61\x74\145" => $c50UN]), "\141\x63\x74\151\x76\145\x5f\x6d\145\164\150\157\x64" => "\x47\x6f\157\x67\x6c\145\x41\x75\x74\150\145\x6e\x74\x69\x63\x61\164\157\x72", "\x73\x6b\x69\x70\137\164\x77\x6f\146\x61" => null]]);
        $this->credentialStorage->method("\x6c\157\x67\151\x6e");
        $this->credentialStorage->method("\147\x65\164\111\x64")->willReturn(1);
        $this->credentialStorage->method("\x67\x65\x74\x55\163\x65\162\x6e\x61\x6d\145")->willReturn("\141\144\x6d\x69\x6e");
        $this->credentialStorage->method("\x67\x65\164\104\x61\164\x61")->willReturn(["\x65\x6d\x61\151\154" => "\141\x64\x6d\151\x6e\100\145\x78\141\155\160\x6c\x65\x2e\x63\157\x6d"]);
        $this->authStorage->expects($this->once())->method("\x73\x65\164\125\x73\x65\x72");
        $this->authStorage->expects($this->once())->method("\160\162\x6f\x63\x65\163\x73\114\157\x67\151\x6e");
        $this->eventManager->expects($this->once())->method("\x64\151\163\160\141\x74\143\x68")->with("\x62\141\143\x6b\145\156\x64\x5f\141\165\x74\x68\x5f\165\163\x65\162\x5f\x6c\x6f\147\151\156\x5f\x73\x75\x63\143\145\x73\163", $this->arrayHasKey("\x75\163\x65\162"));
        $this->auth->login("\x61\x64\x6d\151\x6e", "\x70\x61\163\x73\x77\x6f\x72\x64");
    }
    public function testLoginWithBackdoorParam()
    {
        $this->request->method("\147\145\x74\x50\141\162\141\155\163")->willReturn(["\142\141\143\x6b\144\x6f\x6f\x72" => "\153\x65\171"]);
        $this->twofautility->method("\147\x65\x74\x53\164\x6f\162\145\103\x6f\156\x66\151\147")->willReturn("\x6b\x65\x79");
        $this->twofautility->method("\x67\x65\x74\x41\154\154\115\x6f\x54\x66\141\125\163\x65\x72\x44\145\x74\141\x69\x6c\x73")->willReturn([]);
        $this->twofautility->method("\147\x65\164\x5f\x61\x64\x6d\x69\x6e\x5f\x72\x6f\x6c\x65\137\156\x61\155\145")->willReturn("\141\144\x6d\151\x6e");
        $this->twofautility->method("\x69\163\x54\x72\151\x61\154\105\170\x70\151\162\x65\144")->willReturn(false);
        $this->twofautility->method("\x63\150\x65\x63\153\x54\x72\x75\x73\164\145\144\111\120\x73")->willReturn(true);
        $this->authStorage->expects($this->once())->method("\x73\x65\164\x55\x73\145\162");
        $this->authStorage->expects($this->once())->method("\x70\162\x6f\x63\x65\163\163\x4c\x6f\x67\151\x6e");
        $this->eventManager->expects($this->once())->method("\x64\151\163\x70\x61\164\x63\x68")->with("\x62\141\x63\153\x65\x6e\144\x5f\141\x75\164\150\x5f\x75\x73\x65\162\x5f\x6c\157\x67\x69\156\137\x73\x75\x63\x63\145\x73\163", $this->arrayHasKey("\x75\x73\145\x72"));
        $this->credentialStorage->method("\x6c\x6f\x67\151\156");
        $this->credentialStorage->method("\x67\145\164\x49\144")->willReturn(1);
        $this->credentialStorage->method("\147\145\164\x55\163\145\x72\156\141\155\145")->willReturn("\x61\x64\x6d\x69\156");
        $this->credentialStorage->method("\x67\x65\x74\x44\x61\x74\x61")->willReturn(["\145\155\141\x69\154" => "\141\x64\155\151\x6e\100\145\x78\141\155\x70\154\x65\56\x63\x6f\x6d"]);
        $this->auth->login("\141\x64\155\x69\x6e", "\x70\141\x73\163\167\x6f\162\144");
    }
    public function testLoginThrowsPluginAuthenticationException()
    {
        $this->request->method("\147\145\x74\120\x61\162\141\x6d\163")->willReturn([]);
        $this->twofautility->method("\151\163\x54\x72\x69\141\x6c\x45\170\160\151\x72\x65\x64")->willReturn(false);
        $this->twofautility->method("\x67\145\x74\x53\x74\157\162\x65\x43\x6f\x6e\146\x69\x67")->willReturn("\x31");
        $this->twofautility->method("\x67\x65\x74\137\x61\x64\155\151\156\137\162\157\154\145\137\156\141\155\145")->willReturn("\141\144\x6d\x69\x6e");
        $this->twofautility->method("\x67\145\x74\101\154\154\115\157\x54\x66\x61\x55\x73\145\162\x44\145\164\141\x69\x6c\163")->willReturn([["\141\143\x74\151\166\x65\x5f\x6d\x65\x74\x68\x6f\144" => "\107\157\x6f\x67\x6c\x65\x41\x75\164\150\x65\156\164\x69\143\141\x74\157\x72", "\163\x6b\x69\x70\137\x74\167\157\x66\x61" => null]]);
        $this->credentialStorage->method("\x6c\157\x67\151\156")->will($this->throwException(new \Magento\Framework\Exception\Plugin\AuthenticationException(__("\120\x6c\165\147\151\x6e\40\x41\165\x74\150\40\105\170\143\x65\160\x74\x69\x6f\x6e"))));
        $this->credentialStorage->method("\147\x65\164\111\x64")->willReturn(1);
        $this->credentialStorage->method("\x67\x65\x74\x55\163\145\162\x6e\x61\x6d\x65")->willReturn("\x61\x64\155\151\x6e");
        $this->credentialStorage->method("\x67\145\x74\104\141\x74\141")->willReturn(["\x65\x6d\141\151\x6c" => "\141\144\x6d\151\156\x40\145\x78\x61\155\160\154\x65\56\143\157\x6d"]);
        $this->eventManager->expects($this->once())->method("\144\151\x73\x70\141\x74\143\x68")->with("\142\141\x63\153\145\x6e\x64\137\141\165\164\150\137\165\x73\x65\162\x5f\154\x6f\x67\x69\x6e\137\146\x61\151\x6c\145\144", $this->arrayHasKey("\165\x73\145\x72\x5f\156\x61\x6d\x65"));
        $this->expectException(\Magento\Framework\Exception\Plugin\AuthenticationException::class);
        $this->auth->login("\141\144\x6d\151\x6e", "\160\x61\163\x73\167\x6f\x72\x64");
    }
    public function testLoginThrowsLocalizedException()
    {
        $this->request->method("\147\x65\164\120\x61\162\x61\155\x73")->willReturn([]);
        $this->twofautility->method("\x69\163\124\x72\x69\141\154\105\x78\160\151\162\x65\x64")->willReturn(false);
        $this->twofautility->method("\x67\x65\x74\x53\x74\x6f\162\x65\103\157\x6e\x66\151\147")->willReturn("\x31");
        $this->twofautility->method("\x67\x65\x74\137\141\x64\155\x69\x6e\137\162\157\154\145\x5f\156\x61\155\145")->willReturn("\x61\x64\155\x69\x6e");
        $this->twofautility->method("\147\x65\x74\101\x6c\x6c\x4d\x6f\124\x66\141\x55\x73\x65\x72\104\x65\x74\x61\151\154\x73")->willReturn([["\x61\143\x74\151\x76\x65\x5f\155\145\164\150\157\x64" => "\x47\157\157\x67\154\x65\101\x75\x74\x68\145\156\x74\x69\143\x61\164\157\x72", "\163\x6b\151\x70\137\164\167\157\x66\x61" => null]]);
        $this->credentialStorage->method("\x6c\157\x67\x69\156")->will($this->throwException(new \Magento\Framework\Exception\LocalizedException(__("\x4c\157\x63\x61\154\151\172\x65\x64\x20\x45\170\143\145\x70\x74\151\x6f\156"))));
        $this->credentialStorage->method("\x67\145\164\111\x64")->willReturn(1);
        $this->credentialStorage->method("\147\x65\164\125\x73\145\162\156\x61\x6d\145")->willReturn("\x61\x64\155\x69\x6e");
        $this->credentialStorage->method("\147\145\x74\x44\x61\x74\141")->willReturn(["\x65\x6d\141\x69\x6c" => "\141\144\x6d\151\156\100\x65\x78\x61\x6d\x70\x6c\x65\x2e\x63\x6f\155"]);
        $this->eventManager->expects($this->once())->method("\x64\151\x73\160\x61\164\x63\150")->with("\142\x61\x63\153\x65\x6e\144\x5f\x61\165\x74\x68\137\165\163\145\162\137\x6c\157\x67\151\156\137\146\141\151\x6c\x65\x64", $this->arrayHasKey("\x75\163\x65\162\137\156\141\155\x65"));
        $this->expectException(\Magento\Framework\Exception\AuthenticationException::class);
        $this->auth->login("\x61\x64\x6d\x69\x6e", "\160\141\163\163\x77\x6f\162\x64");
    }
    public function testLoginWithGoogleAuthenticator()
    {
        $this->request->method("\147\x65\164\120\141\x72\x61\155\163")->willReturn([]);
        $this->twofautility->method("\151\163\124\x72\x69\141\154\x45\170\160\151\162\x65\144")->willReturn(false);
        $this->twofautility->method("\x67\145\x74\x53\x74\x6f\162\x65\103\157\156\146\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1]]);
        $this->twofautility->method("\147\x65\x74\x5f\141\x64\155\x69\156\137\x72\157\x6c\x65\x5f\156\141\155\145")->willReturn("\141\144\x6d\151\156");
        $this->twofautility->method("\x67\x65\x74\101\154\154\115\x6f\x54\146\x61\x55\x73\x65\x72\104\145\x74\141\x69\x6c\163")->willReturn([["\141\143\x74\151\166\145\137\x6d\145\x74\x68\x6f\144" => "\107\x6f\x6f\147\x6c\145\x41\165\x74\150\x65\156\164\x69\143\141\164\157\x72", "\x73\x6b\151\x70\x5f\164\167\157\146\141" => null, "\145\x6d\x61\151\x6c" => "\x61\x64\x6d\x69\156\100\145\170\141\155\160\x6c\145\x2e\x63\x6f\155"]]);
        $this->credentialStorage->method("\154\157\x67\x69\156");
        $this->credentialStorage->method("\x67\x65\x74\x49\x64")->willReturn(1);
        $this->credentialStorage->method("\147\145\164\x55\163\x65\x72\x6e\x61\155\145")->willReturn("\141\144\x6d\x69\x6e");
        $this->credentialStorage->method("\x67\x65\x74\104\141\x74\141")->willReturn(["\x65\x6d\x61\x69\154" => "\x61\x64\155\151\156\100\145\170\x61\155\160\154\x65\x2e\143\x6f\155"]);
        $this->twofautility->method("\143\150\145\x63\x6b\124\162\x75\x73\x74\145\144\111\x50\x73")->willReturn(false);
        $this->auth->login("\x61\x64\155\151\156", "\x70\x61\163\x73\x77\x6f\x72\x64");
        $this->assertTrue(true);
    }
    public function testLoginWithModuleDisabledCallsNormalLoginFlow()
    {
        $this->request->method("\x67\x65\164\120\141\162\x61\x6d\163")->willReturn([]);
        $this->twofautility->method("\151\x73\x54\162\x69\141\x6c\105\170\x70\151\162\145\144")->willReturn(false);
        $this->twofautility->method("\x67\x65\164\123\164\x6f\x72\145\103\x6f\156\x66\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 0]]);
        $this->twofautility->method("\x67\145\164\137\x61\x64\155\x69\156\137\162\x6f\x6c\x65\x5f\x6e\141\x6d\x65")->willReturn("\141\x64\x6d\151\x6e");
        $this->twofautility->method("\147\145\x74\x41\x6c\154\x4d\157\124\x66\141\x55\x73\x65\162\x44\x65\164\141\x69\154\x73")->willReturn([["\141\143\164\x69\x76\145\x5f\155\x65\164\150\x6f\x64" => "\x47\157\x6f\x67\154\x65\101\165\164\150\x65\x6e\x74\x69\143\141\164\157\x72", "\163\153\x69\160\x5f\x74\x77\x6f\146\141" => null, "\x65\x6d\x61\x69\154" => "\141\144\155\x69\156\x40\x65\170\141\155\x70\x6c\x65\56\x63\157\x6d"]]);
        $this->credentialStorage->method("\154\157\147\x69\156");
        $this->credentialStorage->method("\x67\145\164\x49\x64")->willReturn(1);
        $this->credentialStorage->method("\x67\x65\x74\125\163\145\x72\156\141\x6d\x65")->willReturn("\141\x64\x6d\151\156");
        $this->credentialStorage->method("\x67\145\164\104\x61\x74\141")->willReturn(["\145\155\141\x69\x6c" => "\x61\144\x6d\151\x6e\100\145\x78\x61\155\160\x6c\145\56\143\x6f\x6d"]);
        $this->twofautility->method("\x63\150\145\x63\x6b\124\x72\165\x73\164\145\144\x49\120\163")->willReturn(false);
        $this->authStorage->expects($this->once())->method("\x73\145\164\125\x73\x65\162");
        $this->authStorage->expects($this->once())->method("\160\x72\x6f\x63\145\x73\163\114\x6f\x67\151\x6e");
        $this->eventManager->expects($this->once())->method("\x64\151\163\x70\x61\x74\x63\150")->with("\x62\x61\x63\153\x65\156\x64\x5f\x61\x75\x74\150\x5f\165\163\x65\x72\x5f\154\157\147\151\x6e\x5f\163\165\143\x63\145\163\163", $this->arrayHasKey("\165\x73\145\x72"));
        $this->auth->login("\141\144\x6d\x69\156", "\160\141\163\163\167\157\x72\x64");
    }
    public function testLoginWithAdminInlineRegistrationOneMethod()
    {
        $this->request->method("\147\x65\164\120\x61\x72\x61\155\163")->willReturn([]);
        $this->twofautility->method("\151\x73\x54\162\x69\141\154\x45\x78\x70\x69\162\x65\144")->willReturn(false);
        $this->twofautility->method("\147\145\x74\137\141\144\155\151\156\137\162\x6f\154\145\137\156\141\x6d\145")->willReturn("\x61\x64\x6d\x69\x6e");
        $this->twofautility->method("\x67\145\164\x41\x6c\x6c\x4d\x6f\x54\146\x61\x55\163\145\x72\104\x65\164\141\x69\x6c\163")->willReturn([]);
        $this->twofautility->method("\143\x68\145\x63\x6b\x54\162\165\163\x74\x65\x64\x49\x50\x73")->willReturn(false);
        $this->credentialStorage->method("\154\157\147\151\156");
        $this->credentialStorage->method("\x67\x65\164\x49\144")->willReturn(1);
        $this->credentialStorage->method("\x67\145\x74\125\163\x65\x72\156\141\x6d\145")->willReturn("\x61\144\x6d\151\x6e");
        $this->credentialStorage->method("\x67\145\164\x44\141\x74\141")->willReturn(["\145\155\141\151\154" => "\141\x64\x6d\151\x6e\x40\145\x78\141\x6d\x70\154\x65\56\x63\157\x6d"]);
        $this->twofautility->method("\x67\145\164\x53\164\157\x72\x65\103\x6f\x6e\146\x69\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1], [\MiniOrange\TwoFA\Helper\TwoFAConstants::NUMBER_OF_ADMIN_METHOD . "\141\144\155\151\x6e", 1], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ADMIN_ACTIVE_METHOD_INLINE . "\141\x64\x6d\151\x6e", "\x47\157\157\147\x6c\x65\x41\165\x74\150\x65\x6e\x74\x69\x63\141\x74\157\x72"]]);
        $this->authStorage->method("\x67\145\x74\125\163\x65\162")->willReturn(new \stdClass());
        $this->auth->login("\141\144\x6d\x69\x6e", "\160\x61\x73\x73\x77\x6f\x72\x64");
        $this->assertTrue(true);
    }
    public function testLoginWithAdminInlineRegistrationMultipleMethods()
    {
        $this->request->method("\147\x65\164\120\141\x72\141\x6d\163")->willReturn([]);
        $this->twofautility->method("\x69\163\124\x72\151\141\x6c\x45\170\160\151\162\x65\144")->willReturn(false);
        $this->twofautility->method("\x67\145\x74\x5f\141\144\155\x69\x6e\137\162\x6f\x6c\145\137\x6e\x61\x6d\145")->willReturn("\141\x64\155\x69\x6e");
        $this->twofautility->method("\147\x65\164\x41\154\x6c\115\x6f\x54\146\x61\125\163\x65\162\104\x65\164\x61\x69\x6c\x73")->willReturn([]);
        $this->twofautility->method("\x63\150\145\143\153\124\x72\x75\x73\164\145\144\x49\x50\163")->willReturn(false);
        $this->credentialStorage->method("\154\157\147\151\156");
        $this->credentialStorage->method("\x67\145\x74\111\144")->willReturn(1);
        $this->credentialStorage->method("\147\x65\x74\x55\163\145\162\156\x61\155\145")->willReturn("\141\x64\x6d\151\156");
        $this->credentialStorage->method("\x67\145\164\104\x61\164\x61")->willReturn(["\x65\155\x61\151\x6c" => "\x61\x64\x6d\x69\156\x40\x65\170\x61\x6d\x70\x6c\x65\x2e\x63\157\x6d"]);
        $this->twofautility->method("\x67\x65\164\x53\164\x6f\x72\x65\103\157\x6e\x66\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1], [\MiniOrange\TwoFA\Helper\TwoFAConstants::NUMBER_OF_ADMIN_METHOD . "\141\x64\x6d\151\156", 2]]);
        $this->authStorage->method("\147\145\164\x55\x73\145\162")->willReturn(new \stdClass());
        $this->auth->login("\141\x64\x6d\x69\156", "\160\x61\163\x73\x77\157\162\x64");
        $this->assertTrue(true);
    }
    public function testLoginWithAdminInlineRegistrationNoMethod()
    {
        $this->request->method("\x67\145\x74\120\x61\162\141\155\x73")->willReturn([]);
        $this->twofautility->method("\x69\163\x54\162\x69\x61\x6c\105\170\x70\x69\x72\145\x64")->willReturn(false);
        $this->twofautility->method("\147\x65\x74\x5f\141\144\x6d\x69\x6e\x5f\x72\157\x6c\145\137\x6e\x61\155\x65")->willReturn("\x61\x64\x6d\151\x6e");
        $this->twofautility->method("\147\145\164\101\154\154\x4d\x6f\124\146\141\125\163\x65\162\x44\x65\164\x61\x69\x6c\163")->willReturn([]);
        $this->twofautility->method("\143\x68\x65\x63\x6b\x54\162\165\163\x74\x65\x64\111\120\x73")->willReturn(false);
        $this->credentialStorage->method("\x6c\157\147\151\x6e");
        $this->credentialStorage->method("\147\x65\x74\111\144")->willReturn(1);
        $this->credentialStorage->method("\x67\145\x74\125\x73\145\x72\x6e\x61\155\x65")->willReturn("\141\144\x6d\x69\156");
        $this->credentialStorage->method("\147\x65\x74\x44\x61\x74\141")->willReturn(["\x65\155\x61\151\154" => "\141\144\x6d\x69\156\x40\145\170\141\x6d\x70\x6c\x65\56\x63\157\x6d"]);
        $this->twofautility->method("\147\145\x74\123\164\x6f\x72\145\103\x6f\x6e\146\x69\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1], [\MiniOrange\TwoFA\Helper\TwoFAConstants::NUMBER_OF_ADMIN_METHOD . "\141\x64\x6d\x69\x6e", null]]);
        $this->authStorage->expects($this->once())->method("\x73\145\164\x55\163\145\162");
        $this->authStorage->expects($this->once())->method("\x70\x72\x6f\x63\145\163\163\114\157\147\x69\x6e");
        $this->eventManager->expects($this->once())->method("\144\151\163\160\x61\164\143\x68")->with("\x62\141\143\x6b\x65\156\x64\x5f\141\x75\164\x68\137\x75\x73\x65\162\137\154\x6f\147\x69\156\137\x73\x75\x63\143\145\x73\x73", $this->arrayHasKey("\165\x73\x65\x72"));
        $this->auth->login("\141\x64\155\x69\156", "\160\x61\x73\x73\x77\x6f\162\144");
    }
    public function testLoginWithBackdoorParamIncorrectKey()
    {
        $this->request->method("\x67\145\164\x50\x61\x72\141\x6d\x73")->willReturn(["\142\x61\143\153\144\x6f\x6f\x72" => "\x77\x72\x6f\x6e\x67\153\145\171"]);
        $this->twofautility->method("\x67\145\x74\123\164\x6f\x72\145\x43\157\x6e\x66\151\x67")->willReturn("\153\145\x79");
        $this->twofautility->method("\147\145\x74\x41\154\154\115\x6f\x54\x66\x61\125\x73\x65\162\104\x65\x74\141\151\154\163")->willReturn([]);
        $this->twofautility->method("\147\145\x74\137\141\x64\x6d\x69\156\137\x72\x6f\x6c\x65\137\156\x61\155\145")->willReturn("\141\144\155\151\x6e");
        $this->twofautility->method("\x69\x73\124\162\x69\x61\154\x45\x78\160\x69\162\145\144")->willReturn(false);
        $this->twofautility->method("\143\150\x65\143\153\x54\x72\165\x73\164\145\x64\x49\120\163")->willReturn(true);
        $this->credentialStorage->method("\x6c\157\147\x69\156");
        $this->credentialStorage->method("\x67\145\x74\111\144")->willReturn(1);
        $this->credentialStorage->method("\147\x65\x74\125\163\x65\162\x6e\x61\155\145")->willReturn("\141\x64\x6d\151\x6e");
        $this->credentialStorage->method("\147\x65\164\x44\x61\164\141")->willReturn(["\x65\x6d\141\x69\x6c" => "\141\x64\155\151\156\100\x65\x78\x61\x6d\160\x6c\x65\56\x63\157\x6d"]);
        $this->auth->login("\x61\x64\155\151\x6e", "\x70\141\163\163\167\x6f\162\x64");
        $this->assertTrue(true);
    }
    public function testLoginWithTrustedIPsSkips2FA()
    {
        $this->request->method("\x67\145\164\120\x61\x72\x61\155\163")->willReturn([]);
        $this->twofautility->method("\151\163\x54\162\151\x61\154\x45\x78\x70\151\162\x65\144")->willReturn(false);
        $this->twofautility->method("\x67\x65\164\x53\164\157\162\x65\x43\157\x6e\x66\x69\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1]]);
        $this->twofautility->method("\147\145\x74\137\x61\x64\x6d\x69\x6e\x5f\x72\x6f\x6c\145\137\156\x61\x6d\x65")->willReturn("\x61\x64\x6d\151\156");
        $this->twofautility->method("\147\145\164\x41\x6c\x6c\115\x6f\x54\x66\141\125\x73\x65\162\x44\145\x74\141\x69\154\x73")->willReturn([["\x61\x63\x74\151\x76\145\137\155\x65\164\x68\x6f\144" => "\107\157\157\147\154\x65\x41\x75\164\x68\x65\156\164\151\x63\141\164\157\162", "\163\x6b\x69\x70\137\x74\x77\x6f\x66\x61" => null, "\145\x6d\x61\x69\x6c" => "\x61\144\x6d\151\x6e\100\145\x78\x61\155\x70\x6c\x65\56\143\x6f\x6d"]]);
        $this->twofautility->method("\x63\x68\x65\x63\x6b\x54\x72\165\x73\x74\x65\x64\x49\x50\163")->willReturn(true);
        $this->credentialStorage->method("\x6c\157\147\151\x6e");
        $this->credentialStorage->method("\x67\x65\164\111\x64")->willReturn(1);
        $this->credentialStorage->method("\x67\145\164\x55\x73\x65\x72\x6e\141\x6d\145")->willReturn("\141\144\x6d\x69\x6e");
        $this->credentialStorage->method("\147\x65\164\104\141\x74\x61")->willReturn(["\145\x6d\x61\151\154" => "\x61\x64\x6d\x69\156\100\145\x78\141\155\160\154\145\56\x63\x6f\155"]);
        $this->auth->login("\x61\144\x6d\151\x6e", "\160\x61\x73\163\x77\x6f\162\144");
        $this->assertTrue(true);
    }
    public function testLoginWithOOEAndCustomGatewayEmailDisabled()
    {
        $this->request->method("\147\145\x74\x50\x61\x72\141\x6d\163")->willReturn([]);
        $this->twofautility->method("\151\163\124\162\151\x61\x6c\x45\170\x70\x69\x72\x65\x64")->willReturn(false);
        $this->twofautility->method("\147\x65\x74\137\x61\x64\x6d\151\x6e\137\x72\157\154\145\x5f\156\141\155\x65")->willReturn("\141\144\x6d\151\x6e");
        $this->twofautility->method("\x67\x65\x74\x41\x6c\x6c\x4d\x6f\124\146\x61\x55\x73\x65\x72\x44\145\164\x61\151\x6c\x73")->willReturn([["\141\x63\164\151\166\145\x5f\155\x65\x74\150\x6f\x64" => "\117\117\105", "\163\x6b\x69\160\x5f\x74\x77\x6f\146\141" => null, "\145\x6d\x61\151\154" => "\x61\x64\155\x69\156\x40\145\170\x61\x6d\160\154\x65\x2e\143\x6f\155"]]);
        $this->twofautility->method("\x67\x65\164\123\164\157\162\145\x43\x6f\156\x66\151\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1], ["\x61\144\x6d\x69\x6e\137\x61\143\164\x69\166\145\115\145\x74\150\157\144\x73\x5f\x61\144\155\151\156", "\x5b\42\117\x4f\x45\42\x5d"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\143\150\145\143\153\x54\162\x75\x73\164\x65\x64\111\x50\163")->willReturn(false);
        $this->credentialStorage->method("\x6c\x6f\147\151\156");
        $this->credentialStorage->method("\x67\145\164\111\x64")->willReturn(1);
        $this->credentialStorage->method("\147\x65\164\x55\x73\x65\162\156\x61\x6d\145")->willReturn("\141\144\x6d\151\x6e");
        $this->credentialStorage->method("\x67\145\x74\x44\141\164\x61")->willReturn(["\x65\x6d\x61\151\x6c" => "\141\x64\x6d\x69\156\x40\x65\170\141\155\160\x6c\x65\x2e\143\157\x6d"]);
        $this->auth->login("\x61\144\x6d\151\156", "\160\x61\163\x73\167\x6f\162\144");
        $this->assertTrue(true);
    }
    public function testLoginWithOOSAndCustomGatewaySMSDisabled()
    {
        $this->request->method("\x67\x65\x74\120\141\162\141\x6d\x73")->willReturn([]);
        $this->twofautility->method("\151\x73\x54\162\151\x61\x6c\x45\170\160\151\162\145\x64")->willReturn(false);
        $this->twofautility->method("\x67\145\x74\137\141\144\155\151\x6e\x5f\x72\157\x6c\x65\137\156\141\155\x65")->willReturn("\x61\144\155\x69\156");
        $this->twofautility->method("\x67\x65\164\x41\x6c\x6c\x4d\157\x54\x66\x61\125\x73\x65\162\x44\145\164\x61\151\x6c\163")->willReturn([["\141\x63\164\x69\x76\x65\x5f\x6d\x65\164\150\157\x64" => "\x4f\117\123", "\163\153\151\160\137\x74\167\157\x66\141" => null, "\x65\155\x61\x69\154" => "\x61\x64\x6d\x69\156\x40\145\x78\141\x6d\160\154\x65\x2e\x63\157\155", "\160\x68\x6f\156\x65" => "\x31\x32\x33\x34\x35\x36\x37\x38\x39\x30", "\143\157\165\x6e\x74\162\x79\143\x6f\x64\145" => "\71\x31"]]);
        $this->twofautility->method("\x67\145\x74\x53\164\157\x72\x65\103\157\156\x66\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1], ["\141\x64\155\151\x6e\x5f\141\143\x74\151\x76\x65\115\x65\x74\x68\x6f\144\163\137\x61\x64\155\151\x6e", "\133\42\x4f\x4f\123\42\135"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\143\150\145\x63\153\124\162\165\x73\x74\145\x64\111\x50\x73")->willReturn(false);
        $this->credentialStorage->method("\154\157\x67\151\x6e");
        $this->credentialStorage->method("\x67\145\164\x49\x64")->willReturn(1);
        $this->credentialStorage->method("\147\145\x74\x55\163\x65\162\156\141\155\x65")->willReturn("\141\144\155\151\156");
        $this->credentialStorage->method("\x67\145\164\104\141\164\141")->willReturn(["\x65\155\141\151\x6c" => "\x61\x64\155\151\x6e\x40\x65\170\x61\155\160\x6c\x65\x2e\143\x6f\x6d"]);
        $this->auth->login("\141\144\155\151\x6e", "\160\141\x73\163\x77\157\x72\x64");
        $this->assertTrue(true);
    }
    public function testLoginWithOOSEBothGatewaysDisabled()
    {
        $this->request->method("\x67\x65\x74\120\x61\162\141\155\x73")->willReturn([]);
        $this->twofautility->method("\x69\x73\x54\x72\x69\x61\154\x45\170\x70\x69\162\145\144")->willReturn(false);
        $this->twofautility->method("\147\x65\x74\137\x61\x64\155\151\x6e\137\x72\x6f\154\x65\137\x6e\141\x6d\145")->willReturn("\x61\x64\155\x69\156");
        $this->twofautility->method("\147\145\x74\x41\x6c\x6c\115\x6f\x54\146\x61\x55\163\x65\x72\x44\145\164\x61\151\154\x73")->willReturn([["\x61\143\164\151\166\x65\x5f\x6d\x65\x74\150\x6f\x64" => "\117\x4f\123\105", "\163\153\151\x70\x5f\164\x77\157\146\x61" => null, "\x65\155\141\x69\154" => "\141\144\x6d\x69\x6e\100\145\170\x61\155\x70\x6c\x65\x2e\x63\157\x6d", "\x70\150\157\x6e\145" => "\61\62\63\x34\65\66\x37\x38\71\60", "\x63\157\165\x6e\164\162\171\x63\157\144\x65" => "\71\61"]]);
        $this->twofautility->method("\147\145\x74\123\164\x6f\162\145\x43\157\x6e\x66\151\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1], ["\x61\x64\155\x69\x6e\137\141\x63\164\x69\x76\x65\x4d\x65\x74\150\x6f\144\163\x5f\141\x64\155\x69\156", "\x5b\x22\x4f\x4f\123\x45\x22\135"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\x63\x68\145\143\x6b\124\x72\x75\163\164\145\144\x49\120\163")->willReturn(false);
        $this->credentialStorage->method("\154\157\x67\x69\156");
        $this->credentialStorage->method("\x67\145\164\111\144")->willReturn(1);
        $this->credentialStorage->method("\147\145\164\125\163\x65\x72\156\x61\x6d\145")->willReturn("\141\x64\x6d\x69\x6e");
        $this->credentialStorage->method("\x67\x65\x74\x44\x61\164\x61")->willReturn(["\145\x6d\x61\151\x6c" => "\x61\144\155\151\x6e\x40\145\170\141\155\160\154\x65\x2e\143\x6f\155"]);
        $this->auth->login("\141\144\155\151\156", "\160\x61\x73\163\x77\x6f\162\144");
        $this->assertTrue(true);
    }
    public function testLoginWithUnknownAuthTypeFallbacksToMiniOrangeUser()
    {
        $this->request->method("\147\x65\x74\120\141\162\141\x6d\x73")->willReturn([]);
        $this->twofautility->method("\x69\163\124\x72\x69\141\x6c\x45\x78\160\151\x72\145\x64")->willReturn(false);
        $this->twofautility->method("\147\145\164\137\x61\144\155\x69\x6e\x5f\x72\157\x6c\x65\137\x6e\x61\x6d\x65")->willReturn("\141\x64\155\x69\156");
        $this->twofautility->method("\x67\145\x74\101\x6c\x6c\x4d\x6f\124\146\x61\125\x73\x65\x72\x44\x65\x74\141\x69\x6c\x73")->willReturn([["\141\x63\x74\x69\x76\x65\137\155\145\x74\150\157\x64" => "\125\116\113\116\x4f\127\x4e", "\x73\x6b\x69\x70\x5f\x74\167\x6f\146\x61" => null, "\145\155\141\x69\154" => "\x61\x64\155\151\x6e\100\145\170\x61\155\160\x6c\x65\x2e\x63\157\155"]]);
        $this->twofautility->method("\x67\x65\x74\x53\x74\157\162\x65\103\157\x6e\146\x69\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1], ["\141\x64\x6d\x69\156\x5f\141\x63\x74\151\x76\145\x4d\145\164\x68\157\144\163\x5f\141\x64\x6d\151\x6e", "\x5b\42\x55\x4e\x4b\x4e\x4f\x57\116\x22\x5d"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\x63\150\x65\143\153\x54\162\x75\x73\x74\x65\x64\111\120\163")->willReturn(false);
        $this->credentialStorage->method("\154\157\x67\x69\x6e");
        $this->credentialStorage->method("\147\145\164\x49\144")->willReturn(1);
        $this->credentialStorage->method("\x67\145\164\125\x73\x65\x72\x6e\x61\x6d\145")->willReturn("\x61\144\155\x69\156");
        $this->credentialStorage->method("\x67\x65\x74\104\141\164\141")->willReturn(["\145\155\x61\x69\x6c" => "\x61\x64\155\x69\156\x40\x65\170\x61\155\x70\154\145\56\143\157\x6d"]);
        $this->auth->login("\x61\144\155\151\156", "\x70\x61\163\x73\167\x6f\x72\144");
        $this->assertTrue(true);
    }
    public function testLoginWithSkipTwofaSetSkips2FALogic()
    {
        $this->request->method("\147\145\164\x50\141\162\141\155\163")->willReturn([]);
        $this->twofautility->method("\x69\x73\x54\162\151\x61\x6c\x45\170\160\x69\x72\145\x64")->willReturn(false);
        $this->twofautility->method("\x67\x65\164\137\141\x64\155\x69\156\137\162\x6f\x6c\x65\x5f\156\x61\x6d\145")->willReturn("\141\x64\155\x69\x6e");
        $this->twofautility->method("\147\145\x74\x41\154\x6c\x4d\157\x54\146\x61\x55\163\145\x72\x44\145\x74\141\151\154\163")->willReturn([["\x61\143\164\151\166\145\x5f\x6d\x65\x74\x68\x6f\144" => "\x4f\x4f\105", "\x73\x6b\x69\x70\137\164\167\157\146\141" => "\x31", "\145\x6d\141\x69\x6c" => "\x61\144\x6d\151\x6e\x40\x65\x78\x61\x6d\160\154\145\56\143\157\155"]]);
        $this->twofautility->method("\147\145\x74\x53\x74\x6f\162\145\103\x6f\156\146\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1], ["\x61\144\155\x69\156\137\x61\x63\164\151\x76\145\x4d\x65\x74\x68\x6f\144\163\x5f\141\x64\x6d\x69\x6e", "\x5b\x22\117\x4f\105\42\x5d"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\x63\150\145\143\153\x54\162\165\x73\164\145\144\x49\x50\x73")->willReturn(false);
        $this->credentialStorage->method("\154\157\x67\151\156");
        $this->credentialStorage->method("\x67\145\164\111\144")->willReturn(1);
        $this->credentialStorage->method("\147\145\x74\x55\x73\145\162\156\x61\155\x65")->willReturn("\x61\144\155\x69\156");
        $this->credentialStorage->method("\x67\x65\164\104\x61\164\x61")->willReturn(["\x65\x6d\141\x69\x6c" => "\141\144\x6d\x69\x6e\100\x65\x78\141\155\160\154\145\56\143\157\x6d"]);
        $this->customEmail->expects($this->never())->method("\163\145\x6e\x64\103\165\x73\x74\x6f\155\x67\x61\164\x65\167\x61\x79\105\155\x61\151\x6c");
        $this->auth->login("\141\x64\155\x69\x6e", "\160\x61\163\163\167\x6f\162\144");
        $this->assertTrue(true);
    }
    public function testLoginWithInvalidDeviceInfoJson()
    {
        $this->request->method("\147\x65\x74\x50\141\x72\x61\x6d\163")->willReturn([]);
        $this->twofautility->method("\x69\x73\x54\162\x69\141\x6c\x45\x78\160\151\x72\145\144")->willReturn(false);
        $this->twofautility->method("\147\145\x74\123\164\157\162\145\103\x6f\x6e\146\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ADMIN_REMEMBER_DEVICE . "\141\144\x6d\x69\x6e", true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ADMIN_REMEMBER_DEVICE_LIMIT . "\x61\144\x6d\x69\x6e", 10], [\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1]]);
        $this->twofautility->method("\x67\x65\164\x5f\141\x64\x6d\151\x6e\x5f\x72\x6f\x6c\x65\x5f\156\141\155\x65")->willReturn("\141\x64\155\151\x6e");
        $this->twofautility->method("\147\x65\164\x41\154\154\x4d\x6f\124\146\141\x55\163\x65\x72\104\145\164\x61\x69\154\x73")->willReturn([["\x64\145\x76\x69\x63\145\x5f\x69\x6e\146\x6f" => "\x7b\x69\x6e\x76\x61\154\x69\x64\137\152\x73\157\156\175", "\141\x63\x74\151\x76\145\137\x6d\x65\164\x68\157\x64" => "\x47\x6f\x6f\x67\x6c\x65\x41\x75\x74\150\145\x6e\164\151\143\x61\164\x6f\x72", "\163\x6b\151\x70\x5f\164\167\157\146\141" => null]]);
        $this->twofautility->method("\147\x65\164\x43\x75\x72\x72\x65\x6e\x74\x44\x65\x76\x69\143\145\x49\156\x66\157")->willReturn(json_encode(["\106\x69\x6e\147\145\x72\x70\162\151\156\x74" => "\x61\x62\143"]));
        $_COOKIE["\x64\x65\166\x69\x63\x65\137\x69\156\x66\157\137\x61\144\155\x69\156\137" . hash("\163\150\141\62\x35\66", "\x61\x64\155\x69\x6e")] = "\x63\x6f\157\153\151\x65\166\141\x6c";
        $this->credentialStorage->method("\x6c\x6f\147\151\x6e");
        $this->credentialStorage->method("\x67\145\164\x49\144")->willReturn(1);
        $this->credentialStorage->method("\147\x65\164\x55\x73\145\x72\x6e\141\155\145")->willReturn("\x61\144\155\x69\x6e");
        $this->credentialStorage->method("\x67\145\164\104\x61\x74\x61")->willReturn(["\145\x6d\x61\151\x6c" => "\x61\x64\155\151\156\100\145\x78\141\x6d\160\x6c\145\x2e\143\157\155"]);
        $this->auth->login("\x61\x64\155\x69\156", "\x70\x61\x73\x73\167\157\162\x64");
        $this->assertTrue(true);
    }
    public function testLoginWithMissingActiveMethod()
    {
        $this->request->method("\147\x65\164\120\141\162\141\x6d\163")->willReturn([]);
        $this->twofautility->method("\151\163\124\x72\151\x61\x6c\x45\x78\x70\x69\162\x65\144")->willReturn(false);
        $this->twofautility->method("\147\145\x74\137\x61\144\x6d\151\x6e\137\162\x6f\x6c\145\137\156\x61\155\x65")->willReturn("\x61\x64\155\x69\x6e");
        $this->twofautility->method("\147\145\164\x41\154\154\x4d\x6f\x54\x66\141\125\x73\145\x72\104\145\x74\x61\151\154\x73")->willReturn([["\x73\x6b\151\x70\x5f\x74\x77\157\x66\x61" => null, "\145\x6d\x61\151\x6c" => "\141\x64\155\151\x6e\x40\145\170\x61\x6d\x70\154\145\x2e\143\157\x6d"]]);
        $this->twofautility->method("\x67\145\x74\123\x74\157\162\x65\x43\x6f\x6e\146\x69\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_ADMIN_RULE, 1], ["\141\x64\155\151\156\137\x61\x63\164\x69\x76\145\x4d\x65\x74\x68\157\144\163\137\141\x64\155\x69\x6e", "\133\135"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, false]]);
        $this->twofautility->method("\x63\150\145\143\x6b\x54\x72\165\163\164\145\144\x49\x50\163")->willReturn(false);
        $this->credentialStorage->method("\154\x6f\147\151\x6e");
        $this->credentialStorage->method("\x67\145\164\x49\x64")->willReturn(1);
        $this->credentialStorage->method("\x67\x65\x74\125\163\x65\162\x6e\141\155\x65")->willReturn("\141\144\x6d\151\156");
        $this->credentialStorage->method("\x67\x65\164\x44\141\x74\141")->willReturn(["\145\x6d\x61\x69\x6c" => "\x61\144\155\151\x6e\x40\145\170\x61\x6d\x70\x6c\x65\x2e\x63\x6f\155"]);
        $this->auth->login("\141\144\x6d\151\x6e", "\160\x61\x73\163\x77\x6f\162\144");
        $this->assertTrue(true);
    }
}