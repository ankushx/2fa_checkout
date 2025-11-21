<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Account;

use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Controller\Account\LoginPost;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Customer\Model\Session;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Exception\EmailNotConfirmedException;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Account\Redirect as AccountRedirect;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\App\Action\Context;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\CustomSMS;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Module\Manager;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
class LoginPostTest extends TestCase
{
    private $controller;
    private $contextMock;
    private $sessionMock;
    private $resultFactoryMock;
    private $redirectMock;
    private $resultRedirectFactoryMock;
    private $requestMock;
    private $formKeyValidatorMock;
    private $accountManagementMock;
    private $customerUrlMock;
    private $accountRedirectMock;
    private $customEmailMock;
    private $customSMSMock;
    private $twoFAUtilityMock;
    private $responseMock;
    private $cookieManagerMock;
    private $cookieMetadataFactoryMock;
    private $moduleManagerMock;
    private $urlMock;
    private $storeManagerMock;
    private $storeMock;
    private $messageManagerMock;
    protected function setUp() : void
    {
        $this->contextMock = $this->createMock(Context::class);
        $this->sessionMock = $this->createMock(Session::class);
        $this->resultFactoryMock = $this->createMock(ResultFactory::class);
        $this->redirectMock = $this->createMock(Redirect::class);
        $this->resultRedirectFactoryMock = $this->createMock(RedirectFactory::class);
        $this->requestMock = $this->createMock(HttpRequest::class);
        $this->formKeyValidatorMock = $this->createMock(Validator::class);
        $this->accountManagementMock = $this->createMock(AccountManagementInterface::class);
        $this->customerUrlMock = $this->createMock(CustomerUrl::class);
        $this->accountRedirectMock = $this->createMock(AccountRedirect::class);
        $this->customEmailMock = $this->createMock(CustomEmail::class);
        $this->customSMSMock = $this->createMock(CustomSMS::class);
        $this->twoFAUtilityMock = $this->createMock(TwoFAUtility::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
        $this->cookieManagerMock = $this->createMock(CookieManagerInterface::class);
        $this->cookieMetadataFactoryMock = $this->createMock(CookieMetadataFactory::class);
        $this->moduleManagerMock = $this->createMock(Manager::class);
        $this->urlMock = $this->createMock(UrlInterface::class);
        $this->storeManagerMock = $this->createMock(StoreManagerInterface::class);
        $this->storeMock = $this->createMock(\Magento\Store\Model\Store::class);
        $this->messageManagerMock = $this->getMockBuilder("\x4d\x61\147\145\156\x74\157\134\x46\x72\141\155\145\x77\157\x72\x6b\x5c\115\145\163\163\x61\147\x65\134\x4d\141\156\141\x67\145\162\x49\156\164\x65\162\146\141\143\145")->getMock();
        $this->contextMock->method("\147\145\x74\x52\x65\161\165\x65\163\164")->willReturn($this->requestMock);
        $this->contextMock->method("\x67\145\x74\x4d\x65\163\x73\x61\x67\145\x4d\141\x6e\141\x67\145\x72")->willReturn($this->messageManagerMock);
        $this->storeManagerMock->method("\147\x65\x74\x53\x74\x6f\x72\x65")->willReturn($this->storeMock);
        $this->storeMock->method("\x67\x65\164\x57\145\142\163\x69\x74\x65\111\x64")->willReturn(1);
        $this->resultFactoryMock->method("\143\162\x65\141\164\145")->willReturn($this->redirectMock);
        $this->resultRedirectFactoryMock->method("\143\x72\x65\141\164\x65")->willReturn($this->redirectMock);
        $this->controller = new LoginPost($this->contextMock, $this->sessionMock, $this->accountManagementMock, $this->customerUrlMock, $this->formKeyValidatorMock, $this->accountRedirectMock, $this->customEmailMock, $this->customSMSMock, $this->twoFAUtilityMock, $this->responseMock, $this->resultFactoryMock, $this->cookieManagerMock, $this->cookieMetadataFactoryMock, $this->moduleManagerMock, $this->urlMock, $this->storeManagerMock);
        $jwZLP = new \ReflectionObject($this->controller);
        x9UTJ:
        if (!($jwZLP = $jwZLP->getParentClass())) {
            goto x0MIk;
        }
        if (!$jwZLP->hasProperty("\x72\145\163\x75\x6c\x74\106\x61\143\x74\157\162\171")) {
            goto XcRU6;
        }
        $DGVxR = $jwZLP->getProperty("\162\145\x73\165\x6c\164\x46\x61\143\164\x6f\x72\x79");
        $DGVxR->setAccessible(true);
        $DGVxR->setValue($this->controller, $this->resultFactoryMock);
        XcRU6:
        if (!$jwZLP->hasProperty("\x72\145\x73\x75\x6c\164\122\145\144\151\162\x65\x63\164\106\x61\143\x74\x6f\x72\171")) {
            goto c8B0K;
        }
        $DGVxR = $jwZLP->getProperty("\162\x65\163\x75\154\x74\x52\x65\144\151\162\145\143\x74\x46\x61\x63\164\157\x72\x79");
        $DGVxR->setAccessible(true);
        $DGVxR->setValue($this->controller, $this->resultRedirectFactoryMock);
        c8B0K:
        if (!$jwZLP->hasProperty("\x73\145\x73\163\x69\x6f\156")) {
            goto Jgymf;
        }
        $DGVxR = $jwZLP->getProperty("\x73\145\163\x73\x69\x6f\x6e");
        $DGVxR->setAccessible(true);
        $DGVxR->setValue($this->controller, $this->sessionMock);
        Jgymf:
        goto x9UTJ;
        x0MIk:
    }
    public function testRedirectsIfAlreadyLoggedIn()
    {
        $this->sessionMock->method("\x69\163\x4c\x6f\147\147\x65\x64\x49\x6e")->willReturn(true);
        $this->formKeyValidatorMock->expects($this->never())->method("\166\141\154\x69\x64\x61\164\x65");
        $YlZ3H = $this->controller->execute();
        $this->assertSame($this->redirectMock, $YlZ3H);
    }
    public function testRedirectsIfFormKeyInvalid()
    {
        $this->sessionMock->method("\151\x73\x4c\157\x67\147\x65\x64\x49\x6e")->willReturn(false);
        $this->formKeyValidatorMock->method("\166\x61\x6c\151\x64\141\164\x65")->willReturn(false);
        $YlZ3H = $this->controller->execute();
        $this->assertSame($this->redirectMock, $YlZ3H);
    }
    public function testRedirectsIfNotPostRequest()
    {
        $this->sessionMock->method("\151\x73\114\157\x67\147\145\x64\x49\x6e")->willReturn(false);
        $this->formKeyValidatorMock->method("\166\141\x6c\151\x64\x61\164\145")->willReturn(true);
        $this->requestMock->method("\x69\163\120\157\x73\x74")->willReturn(false);
        $YlZ3H = $this->controller->execute();
        $this->assertSame($this->redirectMock, $YlZ3H);
    }
    public function testErrorIfUsernameOrPasswordMissing()
    {
        $this->sessionMock->method("\x69\163\114\x6f\x67\147\x65\x64\x49\x6e")->willReturn(false);
        $this->formKeyValidatorMock->method("\x76\x61\154\151\144\141\164\x65")->willReturn(true);
        $this->requestMock->method("\151\x73\120\157\x73\164")->willReturn(true);
        $this->requestMock->method("\147\x65\x74\x50\157\x73\164")->with("\x6c\x6f\x67\x69\x6e")->willReturn(["\165\x73\145\x72\156\141\x6d\145" => '', "\x70\141\x73\163\167\157\x72\144" => '']);
        $this->messageManagerMock->expects($this->once())->method("\x61\144\x64\x45\x72\x72\x6f\x72");
        $YlZ3H = $this->controller->execute();
        $this->assertSame($this->redirectMock, $YlZ3H);
    }
    public function testAuthenticationSuccessNo2FA()
    {
        $this->sessionMock->method("\151\x73\114\x6f\147\x67\x65\144\x49\156")->willReturn(false);
        $this->formKeyValidatorMock->method("\166\141\154\151\x64\141\x74\x65")->willReturn(true);
        $this->requestMock->method("\151\x73\x50\x6f\163\164")->willReturn(true);
        $this->requestMock->method("\x67\x65\164\x50\157\x73\x74")->with("\154\157\147\151\x6e")->willReturn(["\165\163\x65\x72\156\141\155\145" => "\x75\163\145\x72", "\160\141\163\x73\x77\157\x72\144" => "\x70\141\163\x73"]);
        $B23_H = $this->createMock(\Magento\Customer\Api\Data\CustomerInterface::class);
        $this->accountManagementMock->method("\141\x75\x74\x68\145\156\164\x69\143\x61\x74\145")->willReturn($B23_H);
        $p0G5C = $this->createMock(\Magento\Store\Api\Data\StoreInterface::class);
        $p0G5C->method("\x67\x65\164\x57\145\142\163\x69\164\x65\111\x64")->willReturn(0);
        $this->storeManagerMock->method("\147\x65\164\123\164\x6f\x72\x65")->willReturn($p0G5C);
        $this->twoFAUtilityMock->method("\147\x65\164\x43\165\163\x74\157\x6d\145\162\x46\162\157\155\101\x74\164\162\151\x62\165\x74\145\x73")->willReturn(["\145\x6d\141\x69\x6c" => "\x63\165\163\164\157\x6d\145\x72\100\x65\170\141\155\x70\x6c\145\56\143\x6f\155", "\x67\162\157\165\160\137\151\144" => "\x63\x75\x73\x74\157\155\x65\162"]);
        $this->twoFAUtilityMock->method("\147\x65\164\x47\162\157\x75\x70\x4e\x61\x6d\145\102\171\111\144")->willReturn("\143\165\x73\x74\157\x6d\145\x72");
        $this->twoFAUtilityMock->method("\147\x65\x74\x53\164\157\162\x65\103\x6f\x6e\146\151\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_CUSTOMER_RULE, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ACTIVE_METHOD . "\x63\x75\x73\164\x6f\x6d\x65\x72\60", "\133\x5d"]]);
        $this->twoFAUtilityMock->method("\143\150\x65\143\x6b\x32\146\141\137\145\156\164\x65\162\160\162\x69\x73\145\x50\154\x61\x6e")->willReturn(false);
        $this->twoFAUtilityMock->method("\143\x68\x65\143\153\x49\x50\x73")->willReturn(false);
        $this->twoFAUtilityMock->method("\143\x68\145\143\x6b\x42\x6c\x61\x63\x6b\x6c\x69\163\x74\x65\x64\111\120")->willReturn(false);
        $this->twoFAUtilityMock->method("\x69\x73\124\x72\x69\141\x6c\105\170\160\151\162\145\x64")->willReturn(false);
        $this->sessionMock->expects($this->once())->method("\x73\x65\164\103\x75\x73\164\x6f\155\x65\x72\x44\141\164\x61\101\x73\x4c\157\147\147\x65\x64\111\x6e")->with($B23_H);
        $this->sessionMock->expects($this->once())->method("\162\145\147\145\x6e\145\x72\x61\x74\145\x49\x64");
        $YlZ3H = $this->controller->execute();
        $this->assertSame($this->redirectMock, $YlZ3H);
    }
    public function testAuthenticationFailsWithInvalidCredentials()
    {
        $this->sessionMock->method("\151\163\114\157\x67\147\x65\144\111\156")->willReturn(false);
        $this->formKeyValidatorMock->method("\x76\141\154\x69\144\x61\x74\145")->willReturn(true);
        $this->requestMock->method("\151\x73\120\157\163\164")->willReturn(true);
        $this->requestMock->method("\147\145\x74\x50\x6f\163\164")->with("\x6c\x6f\147\x69\x6e")->willReturn(["\165\163\145\162\156\141\x6d\145" => "\x75\x73\145\162", "\x70\141\x73\x73\167\157\162\144" => "\167\162\157\156\147"]);
        $this->accountManagementMock->method("\141\x75\164\x68\145\156\x74\x69\143\x61\164\145")->willThrowException(new AuthenticationException(__("\111\x6e\x76\x61\154\x69\x64\x20\154\x6f\147\151\156\40\157\162\40\160\x61\163\163\167\x6f\x72\144\x2e")));
        $this->messageManagerMock->expects($this->once())->method("\x61\144\144\105\162\x72\157\162");
        $YlZ3H = $this->controller->execute();
        $this->assertSame($this->redirectMock, $YlZ3H);
    }
    public function testAuthenticationFailsWithEmailNotConfirmed()
    {
        $this->sessionMock->method("\151\163\x4c\x6f\147\x67\145\x64\111\x6e")->willReturn(false);
        $this->formKeyValidatorMock->method("\166\x61\154\x69\144\x61\164\145")->willReturn(true);
        $this->requestMock->method("\151\163\120\157\163\164")->willReturn(true);
        $this->requestMock->method("\147\x65\x74\120\x6f\163\x74")->with("\x6c\x6f\x67\151\156")->willReturn(["\165\163\145\x72\x6e\141\155\145" => "\165\x73\145\162", "\160\x61\163\x73\x77\x6f\x72\144" => "\x70\141\163\163"]);
        $this->accountManagementMock->method("\141\x75\x74\x68\x65\156\x74\151\143\141\164\x65")->willThrowException(new EmailNotConfirmedException(__("\x45\155\x61\x69\x6c\40\156\157\x74\x20\x63\x6f\156\146\x69\162\155\145\x64\56")));
        $this->customerUrlMock->method("\x67\145\164\x45\155\141\x69\x6c\x43\x6f\156\146\151\162\x6d\x61\x74\x69\157\x6e\x55\162\154")->willReturn("\143\157\156\x66\x69\162\155\141\164\x69\157\x6e\x5f\x75\162\x6c");
        $this->messageManagerMock->expects($this->once())->method("\x61\144\144\105\162\x72\x6f\x72");
        $YlZ3H = $this->controller->execute();
        $this->assertSame($this->redirectMock, $YlZ3H);
    }
    public function testAuthenticationFailsWithException()
    {
        $this->sessionMock->method("\x69\x73\x4c\x6f\x67\x67\x65\x64\111\156")->willReturn(false);
        $this->formKeyValidatorMock->method("\166\x61\x6c\151\144\141\164\x65")->willReturn(true);
        $this->requestMock->method("\151\x73\120\157\163\x74")->willReturn(true);
        $this->requestMock->method("\x67\x65\164\x50\x6f\x73\x74")->with("\154\157\147\x69\156")->willReturn(["\165\163\145\162\x6e\141\x6d\145" => "\x75\163\145\x72", "\160\x61\163\x73\167\x6f\162\x64" => "\160\x61\163\163"]);
        $this->accountManagementMock->method("\x61\x75\x74\x68\145\156\164\x69\143\x61\x74\x65")->willThrowException(new \Exception("\x53\157\155\x65\40\x65\162\162\x6f\x72"));
        $this->messageManagerMock->expects($this->once())->method("\x61\x64\x64\105\x72\162\157\162");
        $YlZ3H = $this->controller->execute();
        $this->assertSame($this->redirectMock, $YlZ3H);
    }
    public function test2FATrialExpired()
    {
        $this->sessionMock->method("\x69\x73\114\x6f\147\x67\x65\x64\111\x6e")->willReturn(false);
        $this->formKeyValidatorMock->method("\x76\141\154\x69\144\141\164\x65")->willReturn(true);
        $this->requestMock->method("\151\x73\x50\x6f\163\164")->willReturn(true);
        $this->requestMock->method("\x67\x65\164\120\157\x73\164")->with("\x6c\157\x67\151\x6e")->willReturn(["\165\x73\145\162\156\x61\x6d\145" => "\165\x73\x65\162", "\160\141\163\163\167\x6f\162\144" => "\x70\141\163\x73"]);
        $B23_H = $this->getMockBuilder("\x4d\x61\x67\145\x6e\164\157\134\103\x75\x73\164\157\x6d\x65\x72\134\101\x70\151\x5c\104\141\x74\141\134\x43\x75\163\164\x6f\155\x65\x72\x49\156\164\x65\x72\146\x61\x63\x65")->getMock();
        $this->accountManagementMock->method("\141\165\x74\150\145\x6e\164\151\x63\141\x74\145")->willReturn($B23_H);
        $this->twoFAUtilityMock->method("\x67\145\x74\123\x74\157\x72\145\x43\x6f\x6e\146\151\147")->willReturn(true);
        $this->twoFAUtilityMock->method("\x63\x68\145\143\x6b\x32\146\x61\137\145\x6e\164\x65\x72\160\162\x69\x73\x65\x50\x6c\x61\x6e")->willReturn(true);
        $this->twoFAUtilityMock->method("\x63\x68\145\x63\153\x49\x50\163")->willReturn(false);
        $this->twoFAUtilityMock->method("\x69\x73\124\x72\x69\141\154\105\170\160\x69\x72\145\x64")->willReturn(true);
        $this->twoFAUtilityMock->expects($this->atLeastOnce())->method("\154\x6f\x67\x5f\144\145\142\x75\x67");
        $YlZ3H = $this->controller->execute();
        $this->assertSame($this->redirectMock, $YlZ3H);
    }
    public function testBlockLogin()
    {
        $this->messageManagerMock->expects($this->once())->method("\x61\144\144\x45\162\162\157\162");
        $this->urlMock->method("\147\x65\x74\103\x75\162\x72\x65\x6e\x74\x55\162\154")->willReturn("\163\157\x6d\145\x5f\x75\x72\154");
        $this->twoFAUtilityMock->expects($this->once())->method("\154\x6f\147\x5f\144\145\x62\x75\147");
        $YlZ3H = $this->controller->blockLogin();
        $this->assertSame($this->redirectMock, $YlZ3H);
    }
    public function testDefaultLoginFlowWithErrorMessage()
    {
        $B23_H = $this->getMockBuilder("\x4d\141\x67\145\156\164\x6f\134\x43\165\x73\164\x6f\x6d\145\x72\134\x41\160\151\134\x44\x61\x74\x61\134\103\x75\163\164\157\155\145\162\x49\156\x74\x65\x72\146\x61\143\x65")->getMock();
        $this->twoFAUtilityMock->expects($this->atLeastOnce())->method("\x6c\x6f\147\137\144\145\x62\165\147");
        $this->messageManagerMock->expects($this->once())->method("\141\144\x64\x45\162\x72\x6f\x72\115\x65\x73\163\141\x67\x65");
        $this->sessionMock->expects($this->once())->method("\x73\145\164\103\165\163\164\x6f\155\145\162\104\141\164\141\101\163\x4c\157\147\x67\x65\x64\111\x6e")->with($B23_H);
        $this->sessionMock->expects($this->once())->method("\162\x65\147\x65\156\145\x72\141\x74\145\111\x64");
        $YlZ3H = $this->controller->defaultLoginFlow_withErrorMessage($B23_H);
        $this->assertSame($this->redirectMock, $YlZ3H);
    }
    public function testDefaultLoginFlow()
    {
        $B23_H = $this->getMockBuilder("\x4d\x61\147\145\156\164\157\x5c\x43\165\163\x74\157\x6d\x65\x72\134\x41\x70\151\134\104\x61\164\x61\134\x43\x75\x73\164\157\x6d\x65\162\x49\156\164\145\162\146\141\x63\x65")->getMock();
        $this->sessionMock->expects($this->once())->method("\163\145\x74\103\x75\163\x74\157\155\x65\x72\104\141\x74\x61\x41\x73\114\157\147\147\145\x64\x49\x6e")->with($B23_H);
        $YlZ3H = $this->controller->defaultLoginFlow($B23_H);
        $this->assertSame($this->redirectMock, $YlZ3H);
    }
    public function testCheck2faDisableTrue()
    {
        $zC2Bp = [["\x64\x69\163\141\x62\154\x65\x5f\x32\x66\x61" => 1]];
        $this->twoFAUtilityMock->expects($this->once())->method("\154\157\x67\137\x64\x65\x62\165\147");
        $YlZ3H = $this->controller->check_2fa_disable($zC2Bp);
        $this->assertTrue($YlZ3H);
    }
    public function testCheck2faDisableFalse()
    {
        $zC2Bp = [["\144\x69\x73\x61\x62\154\145\137\62\146\x61" => 0]];
        $YlZ3H = $this->controller->check_2fa_disable($zC2Bp);
        $this->assertFalse($YlZ3H);
    }
    public function testNo2FAElseFlow()
    {
        $this->sessionMock->method("\x69\x73\x4c\157\x67\x67\145\144\x49\x6e")->willReturn(false);
        $this->formKeyValidatorMock->method("\166\x61\154\151\144\x61\x74\x65")->willReturn(true);
        $this->requestMock->method("\151\163\x50\x6f\163\x74")->willReturn(true);
        $this->requestMock->method("\147\145\164\x50\x6f\x73\164")->with("\154\157\147\151\156")->willReturn(["\x75\163\145\x72\156\x61\155\x65" => "\165\x73\x65\162", "\x70\141\x73\163\167\157\162\x64" => "\160\x61\163\x73"]);
        $B23_H = $this->getMockBuilder(\Magento\Customer\Api\Data\CustomerInterface::class)->getMock();
        $this->accountManagementMock->method("\x61\165\164\150\145\x6e\164\151\x63\141\x74\x65")->willReturn($B23_H);
        $p0G5C = $this->createMock(\Magento\Store\Api\Data\StoreInterface::class);
        $p0G5C->method("\x67\x65\x74\127\x65\142\163\151\164\x65\x49\144")->willReturn(0);
        $this->storeManagerMock->method("\x67\145\164\x53\x74\157\162\145")->willReturn($p0G5C);
        $this->twoFAUtilityMock->method("\x67\145\164\x43\165\163\x74\x6f\155\x65\162\x46\x72\x6f\155\x41\x74\164\162\x69\142\165\164\x65\163")->willReturn(["\x65\155\141\x69\154" => "\x63\x75\x73\x74\x6f\x6d\145\x72\100\x65\x78\x61\x6d\x70\x6c\145\x2e\x63\x6f\x6d", "\147\162\x6f\x75\x70\x5f\151\x64" => "\143\165\163\x74\157\155\x65\162"]);
        $this->twoFAUtilityMock->method("\147\145\x74\x47\162\157\165\x70\x4e\141\155\145\x42\x79\111\x64")->willReturn("\143\x75\163\164\x6f\x6d\x65\162");
        $this->twoFAUtilityMock->method("\x67\x65\164\123\x74\157\162\x65\103\157\156\146\151\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_CUSTOMER_RULE, false], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ACTIVE_METHOD . "\x63\165\163\x74\157\155\145\x72\x30", "\x5b\135"]]);
        $this->twoFAUtilityMock->method("\x63\150\145\x63\153\62\x66\x61\x5f\145\x6e\164\x65\x72\160\162\x69\x73\x65\x50\154\x61\x6e")->willReturn(false);
        $this->twoFAUtilityMock->method("\x63\150\145\143\153\x49\120\163")->willReturn(false);
        $this->twoFAUtilityMock->method("\151\163\x54\x72\x69\x61\x6c\x45\x78\160\151\162\145\x64")->willReturn(false);
        $this->twoFAUtilityMock->method("\x63\150\x65\x63\x6b\102\154\141\x63\x6b\x6c\x69\163\164\x65\144\111\120")->willReturn(false);
        $this->sessionMock->expects($this->once())->method("\x73\x65\164\x43\165\163\x74\157\x6d\x65\162\x44\141\164\x61\x41\x73\114\157\x67\x67\145\x64\x49\x6e")->with($B23_H);
        $this->sessionMock->expects($this->once())->method("\162\145\x67\x65\156\145\x72\x61\164\x65\x49\144");
        $YlZ3H = $this->controller->execute();
        $this->assertSame($this->redirectMock, $YlZ3H);
    }
    public function test2FAFlowIfBranch()
    {
        $this->sessionMock->method("\x69\x73\x4c\157\147\147\145\144\111\156")->willReturn(false);
        $this->formKeyValidatorMock->method("\x76\x61\154\151\144\x61\164\145")->willReturn(true);
        $this->requestMock->method("\x69\163\120\157\163\164")->willReturn(true);
        $this->requestMock->method("\147\x65\x74\x50\x6f\163\164")->with("\x6c\157\147\x69\x6e")->willReturn(["\x75\x73\145\x72\x6e\141\x6d\x65" => "\165\163\x65\x72", "\x70\141\x73\163\x77\x6f\162\x64" => "\160\141\163\x73"]);
        $B23_H = $this->getMockBuilder("\x4d\141\x67\x65\156\164\157\134\103\x75\x73\x74\157\x6d\x65\162\134\101\160\x69\x5c\x44\x61\x74\141\x5c\x43\x75\x73\164\x6f\x6d\x65\x72\111\x6e\x74\x65\x72\x66\x61\x63\x65")->getMock();
        $this->accountManagementMock->method("\x61\x75\164\x68\x65\156\164\151\143\x61\164\x65")->willReturn($B23_H);
        $this->twoFAUtilityMock->method("\x67\x65\164\123\164\x6f\162\145\103\157\x6e\146\151\x67")->willReturnCallback(function ($rqk2n) {
            if (!($rqk2n === \MiniOrange\TwoFA\Helper\TwoFAConstants::CURRENT_CUSTOMER_RULE)) {
                goto M0fgT;
            }
            return true;
            M0fgT:
            if (!(strpos($rqk2n, \MiniOrange\TwoFA\Helper\TwoFAConstants::ACTIVE_METHOD) === 0)) {
                goto grKo9;
            }
            return "\x73\157\155\x65\x5f\x6d\x65\164\150\x6f\x64";
            grKo9:
            return true;
        });
        $this->twoFAUtilityMock->method("\143\150\145\x63\x6b\62\146\141\x5f\145\x6e\164\145\162\x70\162\x69\163\145\x50\154\141\156")->willReturn(true);
        $this->twoFAUtilityMock->method("\x63\x68\145\143\x6b\111\120\163")->willReturn(false);
        $this->twoFAUtilityMock->method("\x69\x73\x54\x72\x69\141\154\105\x78\160\x69\162\145\x64")->willReturn(false);
        $this->sessionMock->expects($this->never())->method("\163\x65\164\103\165\x73\x74\157\155\x65\x72\104\141\x74\x61\x41\x73\114\x6f\147\x67\145\144\111\156");
        $YlZ3H = $this->controller->execute();
        $this->assertSame($this->redirectMock, $YlZ3H);
    }
    public function testSetCookieSetsPublicCookie()
    {
        $yXUdU = $this->createMock(\Magento\Framework\Stdlib\Cookie\PublicCookieMetadata::class);
        $this->cookieMetadataFactoryMock->method("\143\162\145\x61\164\x65\x50\x75\142\154\151\x63\103\x6f\x6f\x6b\151\145\115\x65\164\x61\144\x61\164\x61")->willReturn($yXUdU);
        $yXUdU->method("\x73\x65\164\104\x75\x72\141\x74\151\157\156\117\156\x65\x59\145\x61\162")->willReturnSelf();
        $yXUdU->method("\x73\x65\x74\x50\x61\164\150")->willReturnSelf();
        $yXUdU->method("\x73\145\x74\x48\164\x74\160\x4f\156\154\x79")->willReturnSelf();
        $this->cookieManagerMock->expects($this->once())->method("\x73\145\164\120\x75\142\x6c\x69\x63\103\157\x6f\153\151\145")->with("\164\145\163\164", "\x76\141\x6c", $yXUdU);
        $jwZLP = new \ReflectionMethod($this->controller, "\x73\145\164\x43\157\x6f\153\151\145");
        $jwZLP->setAccessible(true);
        $jwZLP->invoke($this->controller, "\164\x65\163\164", "\166\x61\154");
    }
    public function testHandleRememberDeviceCheckNoDeviceInfo()
    {
        $this->twoFAUtilityMock->method("\147\145\164\x53\x74\157\162\145\103\x6f\x6e\x66\x69\x67")->willReturn(true);
        $this->twoFAUtilityMock->method("\147\x65\164\x43\165\x72\x72\x65\156\x74\x44\x65\166\x69\x63\145\111\156\146\157")->willReturn(false);
        $zC2Bp = [["\144\145\x76\x69\x63\145\137\151\x6e\x66\x6f" => "\x5b\135"]];
        $jwZLP = new \ReflectionMethod($this->controller, "\150\x61\156\x64\x6c\x65\x52\x65\x6d\145\155\x62\145\x72\x44\145\x76\x69\143\x65\x43\x68\145\143\153");
        $jwZLP->setAccessible(true);
        $YlZ3H = $jwZLP->invoke($this->controller, "\165\163\145\x72", 1, $zC2Bp);
        $this->assertFalse($YlZ3H);
    }
    public function testHandleRememberDeviceCheckDeviceMatchWithinLimit()
    {
        $this->twoFAUtilityMock->method("\x67\x65\164\x53\x74\157\x72\x65\103\157\156\x66\151\147")->willReturn(true);
        $leRc1 = date("\131\x2d\155\55\144");
        $TdXfG = json_encode([["\106\x69\156\147\145\x72\x70\x72\151\156\164" => "\141\142\x63", "\x52\141\156\144\x6f\155\137\x73\164\162\x69\156\x67" => "\x63\157\x6f\x6b\x69\145\x76\x61\154", "\x63\x6f\x6e\x66\x69\x67\x75\162\145\144\x5f\144\x61\x74\x65" => $leRc1]]);
        $zC2Bp = [["\144\145\x76\151\143\145\x5f\151\x6e\146\x6f" => $TdXfG]];
        $this->twoFAUtilityMock->method("\x67\x65\x74\x43\x75\x72\162\145\156\164\x44\x65\x76\x69\143\x65\x49\156\146\x6f")->willReturn(json_encode(["\x46\151\156\x67\x65\x72\160\162\x69\x6e\164" => "\x61\x62\x63"]));
        $this->twoFAUtilityMock->method("\147\x65\x74\123\x74\x6f\x72\x65\x43\x6f\156\x66\151\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::CUSTOMER_REMEMBER_DEVICE, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::CUSTOMER_REMEMBER_DEVICE_LIMIT, 10]]);
        $_COOKIE["\x64\145\x76\151\143\x65\137\151\156\x66\157\137" . hash("\163\150\x61\62\x35\x36", "\x75\x73\x65\x72")] = "\143\157\157\x6b\x69\x65\x76\141\x6c";
        $jwZLP = new \ReflectionMethod($this->controller, "\x68\141\x6e\x64\154\145\x52\145\155\145\155\142\x65\162\x44\145\166\x69\143\145\x43\x68\x65\x63\x6b");
        $jwZLP->setAccessible(true);
        $YlZ3H = $jwZLP->invoke($this->controller, "\165\163\145\x72", 1, $zC2Bp);
        $this->assertTrue($YlZ3H);
    }
    public function testHandleSkipTwoFAPermanent()
    {
        $this->twoFAUtilityMock->method("\147\x65\x74\x53\x74\x6f\x72\x65\103\157\x6e\x66\151\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::SKIP_TWOFA, 1], [\MiniOrange\TwoFA\Helper\TwoFAConstants::SKIP_TWOFA_DAYS, "\x70\145\x72\155\x61\156\x65\156\x74"]]);
        $zC2Bp = [["\163\x6b\x69\160\x5f\164\167\x6f\x66\141\x5f\160\162\x65\155\141\156\x65\156\x74" => true]];
        $B23_H = $this->createMock(\Magento\Customer\Api\Data\CustomerInterface::class);
        $jwZLP = new \ReflectionMethod($this->controller, "\150\141\156\x64\154\145\123\153\151\x70\124\x77\x6f\x46\x41");
        $jwZLP->setAccessible(true);
        $YlZ3H = $jwZLP->invoke($this->controller, $B23_H, $zC2Bp, 1);
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $YlZ3H);
    }
    public function testHandleSkipTwoFATemporaryWithinLimit()
    {
        $this->twoFAUtilityMock->method("\147\x65\x74\123\164\157\162\145\103\x6f\x6e\146\151\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::SKIP_TWOFA, 1], [\MiniOrange\TwoFA\Helper\TwoFAConstants::SKIP_TWOFA_DAYS, 10]]);
        $leRc1 = date("\131\55\x6d\55\144");
        $zC2Bp = [["\163\153\151\x70\x5f\164\167\157\146\x61\x5f\x63\157\156\x66\151\147\x75\x72\x65\x64\137\x64\141\x74\x65" => json_encode(["\x63\157\x6e\x66\151\x67\165\162\x65\x64\137\144\141\x74\145" => $leRc1])]];
        $B23_H = $this->createMock(\Magento\Customer\Api\Data\CustomerInterface::class);
        $jwZLP = new \ReflectionMethod($this->controller, "\x68\x61\x6e\x64\154\x65\123\x6b\x69\160\124\167\157\106\101");
        $jwZLP->setAccessible(true);
        $YlZ3H = $jwZLP->invoke($this->controller, $B23_H, $zC2Bp, 1);
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $YlZ3H);
    }
    public function testHandleSkipTwoFANotMet()
    {
        $this->twoFAUtilityMock->method("\147\x65\164\x53\x74\x6f\x72\x65\103\x6f\156\x66\x69\147")->willReturn(0);
        $zC2Bp = [[]];
        $B23_H = $this->createMock(\Magento\Customer\Api\Data\CustomerInterface::class);
        $jwZLP = new \ReflectionMethod($this->controller, "\x68\x61\156\144\154\145\123\153\151\x70\124\x77\x6f\106\101");
        $jwZLP->setAccessible(true);
        $YlZ3H = $jwZLP->invoke($this->controller, $B23_H, $zC2Bp, 1);
        $this->assertFalse($YlZ3H);
    }
    public function testHandleExisting2FAUserEmptyMethod()
    {
        $zC2Bp = [["\141\x63\x74\x69\x76\145\137\x6d\x65\164\x68\x6f\x64" => '', "\151\x64" => 1]];
        $B23_H = $this->createMock(\Magento\Customer\Api\Data\CustomerInterface::class);
        $eVoPl = $this->redirectMock;
        $this->twoFAUtilityMock->expects($this->once())->method("\144\x65\x6c\145\164\x65\x52\x6f\x77\111\156\x54\x61\x62\154\x65");
        $jwZLP = new \ReflectionMethod($this->controller, "\x68\141\156\x64\x6c\145\105\170\151\x73\164\x69\156\147\62\x46\x41\x55\x73\145\x72");
        $jwZLP->setAccessible(true);
        $YlZ3H = $jwZLP->invoke($this->controller, $B23_H, "\165\163\145\x72", $zC2Bp, 1, $eVoPl);
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $YlZ3H);
    }
    public function testHandleExisting2FAUserWithMethod()
    {
        $zC2Bp = [["\141\143\164\x69\x76\x65\137\x6d\x65\x74\x68\157\144" => "\x4f\117\123", "\x70\150\x6f\x6e\145" => "\61\62\x33", "\x63\157\165\156\164\x72\171\x63\x6f\144\x65" => "\71\x31"]];
        $B23_H = $this->createMock(\Magento\Customer\Api\Data\CustomerInterface::class);
        $eVoPl = $this->redirectMock;
        $jwZLP = new \ReflectionMethod($this->controller, "\150\141\x6e\x64\154\x65\x45\170\151\x73\x74\151\x6e\x67\62\x46\101\125\163\145\x72");
        $jwZLP->setAccessible(true);
        $YlZ3H = $jwZLP->invoke($this->controller, $B23_H, "\165\x73\x65\x72", $zC2Bp, 1, $eVoPl);
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $YlZ3H);
    }
    public function testProcess2FAMethodGoogleAuthenticator()
    {
        $zC2Bp = [["\x61\x63\x74\151\166\x65\x5f\x6d\145\x74\150\x6f\144" => "\107\x6f\x6f\x67\x6c\x65\101\165\164\150\x65\x6e\x74\151\143\x61\x74\x6f\x72"]];
        $eVoPl = $this->redirectMock;
        $jwZLP = new \ReflectionMethod($this->controller, "\x70\162\157\143\145\163\x73\62\x46\101\115\145\x74\150\x6f\x64");
        $jwZLP->setAccessible(true);
        $YlZ3H = $jwZLP->invoke($this->controller, $zC2Bp, "\165\163\x65\x72", "\x47\x6f\x6f\147\x6c\145\x41\x75\164\x68\x65\156\164\151\143\141\164\157\x72", 1, $eVoPl);
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $YlZ3H);
    }
    public function testProcess2FAMethodCustomGatewaySuccess()
    {
        $zC2Bp = [["\x61\143\164\151\x76\x65\x5f\x6d\x65\x74\150\157\144" => "\x4f\117\123", "\x70\x68\157\x6e\x65" => "\61\62\63", "\x63\157\165\156\164\162\x79\143\157\x64\x65" => "\x39\61"]];
        $eVoPl = $this->redirectMock;
        $this->twoFAUtilityMock->method("\147\145\164\123\x74\157\x72\145\103\157\156\x66\151\147")->willReturn(true);
        $this->twoFAUtilityMock->method("\x75\160\x64\x61\164\145\103\x6f\154\x75\x6d\x6e\x49\156\124\141\x62\x6c\x65");
        $this->twoFAUtilityMock->method("\117\x54\x50\x5f\157\166\145\162\137\x53\x4d\x53\x61\156\144\x45\115\101\111\114\x5f\115\145\x73\163\141\x67\145")->willReturn("\x6f\x6b");
        $this->customSMSMock->method("\x73\145\156\x64\x5f\143\x75\x73\164\x6f\x6d\x67\x61\x74\x65\167\x61\x79\x5f\x73\155\x73")->willReturn(["\x73\x74\141\164\x75\x73" => "\x53\125\103\x43\x45\123\x53", "\164\170\111\144" => "\x31", "\155\145\163\163\141\147\x65" => "\x6f\x6b"]);
        $this->customEmailMock->method("\163\145\156\144\x43\x75\163\x74\x6f\155\x67\x61\x74\x65\167\x61\x79\105\x6d\x61\x69\x6c")->willReturn(["\163\164\141\164\165\163" => "\123\x55\103\x43\x45\x53\x53", "\164\170\111\144" => "\61", "\x6d\x65\x73\x73\x61\x67\145" => "\x6f\x6b"]);
        $jwZLP = new \ReflectionMethod($this->controller, "\160\162\x6f\x63\145\x73\x73\62\106\101\115\x65\x74\x68\157\x64");
        $jwZLP->setAccessible(true);
        $YlZ3H = $jwZLP->invoke($this->controller, $zC2Bp, "\165\x73\x65\x72", "\x4f\x4f\123", 1, $eVoPl);
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $YlZ3H);
    }
    public function testHandleCustomGatewayOOSEBothFailed()
    {
        $zC2Bp = [["\x70\150\x6f\156\x65" => "\x31\x32\x33", "\143\157\x75\x6e\x74\162\171\143\x6f\144\x65" => "\71\x31"]];
        $this->twoFAUtilityMock->method("\147\x65\x74\123\164\157\162\x65\103\157\156\146\151\x67")->willReturn(false);
        $this->customEmailMock->method("\163\145\x6e\x64\x43\x75\163\x74\157\x6d\x67\141\164\145\x77\141\x79\105\x6d\141\151\154")->willReturn(["\x73\164\141\x74\165\x73" => "\106\x41\111\114\105\x44"]);
        $this->customSMSMock->method("\163\x65\x6e\144\137\143\x75\x73\164\x6f\155\x67\x61\x74\145\167\141\x79\137\163\x6d\x73")->willReturn(["\163\164\x61\164\x75\x73" => "\106\x41\111\x4c\105\104"]);
        $this->twoFAUtilityMock->method("\x4f\124\120\x5f\157\x76\145\162\137\123\x4d\123\x61\x6e\144\x45\x4d\x41\x49\x4c\x5f\x4d\x65\x73\163\x61\147\x65")->willReturn("\x66\x61\x69\x6c");
        $jwZLP = new \ReflectionMethod($this->controller, "\x68\141\x6e\144\x6c\x65\x43\165\163\x74\x6f\x6d\x47\141\164\x65\167\141\x79");
        $jwZLP->setAccessible(true);
        $YlZ3H = $jwZLP->invoke($this->controller, $zC2Bp, "\x75\163\145\162", "\117\117\x53\x45", 1);
        $this->assertIsArray($YlZ3H);
        $this->assertEquals("\106\101\x49\x4c\105\104", $YlZ3H["\163\164\x61\164\x75\163"]);
    }
    public function testSetOtpExpiryTimeSetsSessionValue()
    {
        $this->twoFAUtilityMock->expects($this->once())->method("\x73\145\164\x53\145\x73\x73\151\157\x6e\126\x61\154\x75\x65")->with("\157\x74\160\x5f\145\x78\x70\x69\x72\x79\137\164\151\x6d\145", $this->anything());
        $jwZLP = new \ReflectionMethod($this->controller, "\163\x65\164\x4f\164\160\x45\170\160\x69\162\x79\x54\151\x6d\145");
        $jwZLP->setAccessible(true);
        $jwZLP->invoke($this->controller);
    }
    public function testHandleWhatsApp2FAMethodCustomGateway()
    {
        $zC2Bp = [["\x63\157\165\156\x74\162\171\x63\x6f\x64\x65" => "\x39\61", "\160\x68\x6f\x6e\145" => "\61\62\x33"]];
        $this->twoFAUtilityMock->method("\163\145\156\144\x5f\143\165\x73\x74\x6f\155\x67\x61\164\x65\167\x61\x79\x5f\x77\150\x61\164\163\x61\160\x70")->willReturn(["\163\164\x61\x74\x75\163" => "\x53\x55\x43\x43\x45\x53\123"]);
        $jwZLP = new \ReflectionMethod($this->controller, "\150\141\x6e\144\154\x65\127\150\x61\x74\163\x41\160\x70\62\x46\101\x4d\145\164\x68\x6f\x64");
        $jwZLP->setAccessible(true);
        $YlZ3H = $jwZLP->invoke($this->controller, "\117\x4f\x57", true, $zC2Bp);
        $this->assertIsArray($YlZ3H);
        $this->assertEquals("\123\x55\103\x43\105\123\x53", $YlZ3H["\x73\164\x61\x74\165\163"]);
    }
    public function testHandleWhatsApp2FAMethodDefault()
    {
        $zC2Bp = [["\143\157\x75\156\x74\162\171\x63\157\x64\x65" => "\71\61", "\x70\150\x6f\x6e\x65" => "\x31\x32\x33"]];
        $this->twoFAUtilityMock->method("\x73\x65\156\x64\137\167\x68\141\164\x73\x61\x70\x70")->willReturn(["\163\x74\141\164\165\x73" => "\x53\125\103\x43\105\x53\123"]);
        $jwZLP = new \ReflectionMethod($this->controller, "\x68\141\x6e\144\x6c\x65\x57\150\x61\164\163\101\x70\x70\62\106\x41\x4d\x65\x74\x68\x6f\144");
        $jwZLP->setAccessible(true);
        $YlZ3H = $jwZLP->invoke($this->controller, "\x4f\x4f\x57", false, $zC2Bp);
        $this->assertIsArray($YlZ3H);
        $this->assertEquals("\123\125\x43\x43\105\123\123", $YlZ3H["\x73\164\141\164\165\x73"]);
    }
    public function testHandleNew2FAUserOneMethod()
    {
        $this->twoFAUtilityMock->method("\x67\145\164\123\164\157\162\145\103\x6f\x6e\146\151\147")->willReturn(1);
        $jwZLP = new \ReflectionMethod($this->controller, "\x68\141\x6e\144\x6c\145\x4e\x65\167\62\x46\101\125\163\x65\162");
        $jwZLP->setAccessible(true);
        $YlZ3H = $jwZLP->invoke($this->controller, "\165\163\x65\162", "\x72\x6f\154\x65", 1, $this->redirectMock);
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $YlZ3H);
    }
    public function testHandleNew2FAUserMultipleMethods()
    {
        $this->twoFAUtilityMock->method("\147\x65\164\x53\x74\x6f\x72\145\103\157\x6e\x66\151\147")->willReturn(2);
        $jwZLP = new \ReflectionMethod($this->controller, "\x68\x61\156\x64\154\x65\116\145\167\x32\106\x41\125\x73\145\162");
        $jwZLP->setAccessible(true);
        $YlZ3H = $jwZLP->invoke($this->controller, "\165\x73\145\162", "\162\x6f\154\145", 1, $this->redirectMock);
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $YlZ3H);
    }
}