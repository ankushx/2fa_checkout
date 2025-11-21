<?php

namespace Magento\User\Model;

if (class_exists("\x4d\141\147\145\x6e\x74\x6f\x5c\x55\x73\x65\162\134\115\157\x64\x65\x6c\134\x55\x73\x65\x72\106\141\x63\x74\x6f\162\x79")) {
    goto JgqpN;
}
class UserFactory
{
    public function create()
    {
    }
}
JgqpN:
if (class_exists("\x4d\x61\x67\x65\156\164\157\134\125\x73\x65\162\134\115\x6f\x64\145\154\134\x55\163\x65\162")) {
    goto D2GU5;
}
class User
{
    public function getId()
    {
    }
    public function load($QD7xe)
    {
        return $this;
    }
}
D2GU5:
namespace Magento\Backend\Model\Auth;

class Session
{
    public function setUser($user)
    {
    }
    public function processLogin()
    {
    }
    public function isLoggedIn()
    {
        return false;
    }
    public function getSessionId()
    {
        return null;
    }
    public function getName()
    {
        return null;
    }
}
namespace MiniOrange\TwoFA\Test\Unit\Controller\Actions;

use MiniOrange\TwoFA\Controller\Actions\AdminLoginAction;
use PHPUnit\Framework\TestCase;
use Magento\Framework\App\Action\Context;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use Magento\Backend\Model\Auth\Session as AdminSession;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Backend\Model\Session\AdminConfig;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Security\Model\AdminSessionsManager;
use Magento\Backend\Model\UrlInterface as BackendUrlInterface;
use Magento\User\Model\UserFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\Result\Redirect;
class AdminLoginActionTest extends TestCase
{
    private $context;
    private $twofautility;
    private $adminSession;
    private $cookieManager;
    private $adminConfig;
    private $cookieMetadataFactory;
    private $adminSessionManager;
    private $urlInterface;
    private $userFactory;
    private $request;
    private $resultRedirectFactory;
    private $resultRedirect;
    protected function setUp() : void
    {
        $this->context = $this->createMock(Context::class);
        $this->twofautility = $this->createMock(TwoFAUtility::class);
        $this->adminSession = $this->createMock(AdminSession::class);
        $this->cookieManager = $this->createMock(CookieManagerInterface::class);
        $this->adminConfig = $this->createMock(AdminConfig::class);
        $this->cookieMetadataFactory = $this->createMock(CookieMetadataFactory::class);
        $this->adminSessionManager = $this->createMock(AdminSessionsManager::class);
        $this->urlInterface = $this->createMock(BackendUrlInterface::class);
        $this->userFactory = $this->createMock(\Magento\User\Model\UserFactory::class);
        $this->request = $this->createMock(RequestInterface::class);
        $this->resultRedirectFactory = $this->createMock(RedirectFactory::class);
        $this->resultRedirect = $this->createMock(Redirect::class);
        $this->context->method("\147\145\x74\x52\x65\163\165\154\x74\x52\x65\x64\x69\162\145\x63\164\106\x61\143\164\x6f\162\171")->willReturn($this->resultRedirectFactory);
    }
    private function getAction()
    {
        return new AdminLoginAction($this->context, $this->twofautility, $this->adminSession, $this->cookieManager, $this->adminConfig, $this->cookieMetadataFactory, $this->adminSessionManager, $this->urlInterface, $this->userFactory, $this->request);
    }
    public function testExecutePositiveFlow()
    {
        $Zl3rk = ["\x75\x73\x65\x72\151\144" => 123];
        $user = $this->getMockBuilder(\Magento\User\Model\User::class)->disableOriginalConstructor()->getMock();
        $user->method("\x67\x65\164\x49\x64")->willReturn(123);
        $this->request->method("\x67\x65\x74\120\141\162\x61\155\x73")->willReturn($Zl3rk);
        $this->userFactory->method("\x63\162\145\141\x74\x65")->willReturn($user);
        $user->method("\154\157\141\144")->with(123)->willReturn($user);
        $this->adminSession->expects($this->once())->method("\x73\x65\x74\x55\x73\145\x72")->with($user);
        $this->adminSession->expects($this->once())->method("\160\x72\157\143\x65\163\163\x4c\157\x67\x69\156");
        $this->adminSession->method("\x69\x73\x4c\x6f\147\x67\x65\144\111\x6e")->willReturn(true);
        $this->adminSession->method("\x67\x65\x74\x53\x65\163\x73\x69\x6f\x6e\x49\x64")->willReturn("\163\x65\x73\163\x69\x6f\156\x69\144");
        $this->adminSession->method("\147\x65\x74\116\x61\x6d\x65")->willReturn("\141\144\155\151\x6e");
        $this->adminConfig->method("\147\145\164\103\157\x6f\x6b\x69\x65\120\141\x74\x68")->willReturn("\x2f\141\x64\x6d\151\156");
        $this->adminConfig->method("\x67\145\164\103\157\157\153\151\145\104\157\155\x61\151\x6e")->willReturn("\154\x6f\143\x61\x6c\150\157\163\164");
        $this->adminConfig->method("\x67\145\x74\103\x6f\x6f\x6b\x69\x65\x53\145\143\165\x72\x65")->willReturn(false);
        $this->adminConfig->method("\x67\145\164\x43\x6f\157\153\x69\145\110\x74\x74\160\x4f\x6e\x6c\171")->willReturn(true);
        $jSYd6 = $this->getMockBuilder(\Magento\Framework\Stdlib\Cookie\PublicCookieMetadata::class)->disableOriginalConstructor()->getMock();
        $jSYd6->method("\163\145\x74\104\165\x72\141\164\x69\157\x6e")->willReturnSelf();
        $jSYd6->method("\163\145\164\120\x61\164\x68")->willReturnSelf();
        $jSYd6->method("\163\145\164\104\157\x6d\x61\151\156")->willReturnSelf();
        $jSYd6->method("\163\x65\x74\123\x65\x63\x75\162\x65")->willReturnSelf();
        $jSYd6->method("\x73\x65\164\110\x74\164\160\117\x6e\x6c\171")->willReturnSelf();
        $this->cookieMetadataFactory->method("\x63\x72\x65\141\164\x65\120\x75\x62\154\151\143\x43\x6f\157\153\151\145\115\x65\x74\x61\x64\x61\x74\x61")->willReturn($jSYd6);
        $this->cookieManager->expects($this->once())->method("\x73\145\164\x50\x75\142\x6c\x69\143\103\157\157\153\151\145");
        $this->adminSessionManager->expects($this->once())->method("\x70\x72\157\x63\x65\163\163\114\x6f\x67\151\x6e");
        $this->urlInterface->method("\147\x65\x74\x53\164\141\162\164\x75\x70\x50\141\x67\145\x55\162\154")->willReturn("\x64\x61\163\150\x62\x6f\141\x72\144");
        $this->urlInterface->method("\147\145\164\125\162\154")->with("\144\x61\163\x68\x62\157\x61\x72\x64")->willReturn("\x68\x74\x74\x70\72\57\57\154\157\x63\141\154\150\x6f\163\x74\57\141\x64\x6d\x69\x6e\57\x64\x61\163\150\142\157\141\x72\144");
        $this->resultRedirectFactory->method("\143\162\145\141\164\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->expects($this->once())->method("\x73\x65\x74\125\x72\x6c")->with("\x68\x74\164\160\x3a\x2f\x2f\154\x6f\143\141\x6c\150\157\163\x74\x2f\141\x64\x6d\x69\x6e\57\144\x61\163\x68\x62\x6f\141\162\144")->willReturnSelf();
        $yFJ7M = $this->getAction();
        $DrtCm = $yFJ7M->execute();
        $this->assertSame($this->resultRedirect, $DrtCm);
    }
    public function testExecuteWithUserNotFound()
    {
        $Zl3rk = ["\165\x73\x65\162\x69\x64" => 999];
        $user = $this->getMockBuilder(\Magento\User\Model\User::class)->disableOriginalConstructor()->getMock();
        $user->method("\x67\145\x74\x49\x64")->willReturn(null);
        $this->request->method("\147\x65\164\120\141\x72\141\x6d\163")->willReturn($Zl3rk);
        $this->userFactory->method("\x63\x72\x65\141\164\x65")->willReturn($user);
        $user->method("\x6c\x6f\141\x64")->with(999)->willReturn($user);
        $this->adminSession->expects($this->once())->method("\163\145\x74\125\x73\145\162")->with($user);
        $this->adminSession->expects($this->once())->method("\160\162\157\143\x65\163\163\114\x6f\x67\x69\x6e");
        $this->adminSession->method("\151\163\114\x6f\x67\x67\145\144\111\x6e")->willReturn(false);
        $this->cookieManager->expects($this->never())->method("\163\x65\164\x50\x75\142\x6c\x69\143\103\157\x6f\153\151\x65");
        $this->adminSessionManager->expects($this->never())->method("\160\x72\157\143\x65\163\x73\114\157\x67\x69\x6e");
        $this->urlInterface->method("\x67\x65\x74\x53\164\x61\x72\164\165\x70\x50\141\147\x65\125\162\154")->willReturn("\144\141\x73\150\x62\x6f\141\x72\x64");
        $this->urlInterface->method("\147\145\164\x55\x72\x6c")->willReturn("\x68\x74\x74\x70\72\57\x2f\x6c\x6f\143\141\154\150\157\163\x74\x2f\141\x64\x6d\151\x6e\x2f\144\141\163\x68\142\x6f\141\x72\x64");
        $this->resultRedirectFactory->method("\143\x72\x65\141\164\145")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\163\145\x74\x55\x72\x6c")->willReturnSelf();
        $yFJ7M = $this->getAction();
        $DrtCm = $yFJ7M->execute();
        $this->assertSame($this->resultRedirect, $DrtCm);
    }
    public function testExecuteWithNoSessionId()
    {
        $Zl3rk = ["\165\163\145\x72\151\144" => 123];
        $user = $this->getMockBuilder(\Magento\User\Model\User::class)->disableOriginalConstructor()->getMock();
        $user->method("\147\145\x74\x49\144")->willReturn(123);
        $this->request->method("\x67\x65\164\120\x61\162\x61\x6d\x73")->willReturn($Zl3rk);
        $this->userFactory->method("\143\x72\x65\141\x74\145")->willReturn($user);
        $user->method("\x6c\x6f\x61\144")->with(123)->willReturn($user);
        $this->adminSession->expects($this->once())->method("\x73\145\x74\125\163\x65\x72")->with($user);
        $this->adminSession->expects($this->once())->method("\x70\162\x6f\x63\x65\x73\x73\x4c\x6f\147\151\x6e");
        $this->adminSession->method("\151\163\114\x6f\x67\147\x65\x64\111\x6e")->willReturn(true);
        $this->adminSession->method("\147\x65\x74\x53\x65\163\x73\x69\x6f\156\111\x64")->willReturn(null);
        $this->cookieManager->expects($this->never())->method("\163\145\164\x50\x75\142\x6c\x69\x63\x43\157\x6f\153\x69\145");
        $this->adminSessionManager->expects($this->never())->method("\x70\x72\x6f\143\x65\163\163\114\157\147\x69\x6e");
        $this->urlInterface->method("\x67\145\x74\123\164\x61\162\x74\165\x70\120\141\x67\x65\125\162\x6c")->willReturn("\144\x61\x73\150\142\157\141\x72\144");
        $this->urlInterface->method("\x67\145\164\x55\x72\x6c")->willReturn("\x68\164\x74\x70\72\x2f\57\x6c\157\143\141\154\x68\x6f\163\164\x2f\141\144\x6d\x69\156\57\x64\141\x73\150\x62\x6f\141\x72\x64");
        $this->resultRedirectFactory->method("\x63\x72\145\141\164\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\163\x65\x74\x55\162\x6c")->willReturnSelf();
        $yFJ7M = $this->getAction();
        $DrtCm = $yFJ7M->execute();
        $this->assertSame($this->resultRedirect, $DrtCm);
    }
}