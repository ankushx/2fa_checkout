<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Adminhtml\Otp;

if (!function_exists("\x5f\x5f")) {
    function __($sW3Tg)
    {
        return $sW3Tg;
    }
}
use MiniOrange\TwoFA\Controller\Adminhtml\Otp\AuthPost;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
class AuthPostTest extends TestCase
{
    private $context;
    private $storageSession;
    private $sessionsManager;
    private $remoteAddress;
    private $url;
    private $response;
    private $twofautility;
    private $customEmail;
    private $customSMS;
    private $authPostController;
    private $request;
    private $backendUrl;
    private $resultRedirectFactory;
    private $resultRedirect;
    private $messageManager;
    private $auth;
    protected function setUp() : void
    {
        $this->context = $this->createMock(\Magento\Backend\App\Action\Context::class);
        $this->storageSession = $this->createMock(\Magento\Framework\Session\SessionManager::class);
        $this->sessionsManager = $this->createMock(\Magento\Security\Model\AdminSessionsManager::class);
        $this->remoteAddress = $this->createMock(\Magento\Framework\HTTP\PhpEnvironment\RemoteAddress::class);
        $this->url = $this->createMock(\Magento\Framework\UrlInterface::class);
        $this->response = $this->createMock(\Magento\Framework\App\Response\Http::class);
        $this->twofautility = $this->createMock(\MiniOrange\TwoFA\Helper\TwoFAUtility::class);
        $this->customEmail = $this->createMock(\MiniOrange\TwoFA\Helper\CustomEmail::class);
        $this->customSMS = $this->createMock(\MiniOrange\TwoFA\Helper\CustomSMS::class);
        $this->request = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->backendUrl = $this->createMock(\Magento\Backend\Model\UrlInterface::class);
        $this->resultRedirectFactory = $this->createMock(\Magento\Framework\Controller\Result\RedirectFactory::class);
        $this->resultRedirect = $this->createMock(\Magento\Backend\Model\View\Result\Redirect::class);
        $this->messageManager = $this->createMock(\Magento\Framework\Message\ManagerInterface::class);
        $this->auth = $this->createMock(\Magento\Backend\Model\Auth::class);
        $this->context->method("\x67\x65\x74\x52\x65\161\165\145\163\164")->willReturn($this->request);
        $this->context->method("\x67\145\x74\115\x65\x73\x73\141\147\145\x4d\x61\156\141\147\145\x72")->willReturn($this->messageManager);
        $this->authPostController = new AuthPost($this->context, $this->storageSession, $this->sessionsManager, $this->remoteAddress, $this->url, $this->response, $this->twofautility, $this->customEmail, $this->customSMS);
        $xPetv = new ReflectionClass($this->authPostController);
        foreach (["\x72\145\x73\165\x6c\x74\x52\145\x64\x69\x72\145\x63\x74\x46\x61\143\x74\157\x72\171" => $this->resultRedirectFactory, "\137\141\x75\x74\x68" => $this->auth, "\137\x72\x65\x71\165\x65\x73\x74" => $this->request, "\x5f\x62\x61\143\x6b\145\156\x64\x55\x72\x6c" => $this->backendUrl, "\155\145\163\x73\141\147\145\x4d\141\x6e\x61\x67\x65\x72" => $this->messageManager, "\x5f\x75\x72\154" => $this->url, "\x5f\162\x65\163\160\x6f\156\163\x65" => $this->response] as $i7nGa => $hmBWb) {
            if (!$xPetv->hasProperty($i7nGa)) {
                goto N00AN;
            }
            $JXymg = $xPetv->getProperty($i7nGa);
            $JXymg->setAccessible(true);
            $JXymg->setValue($this->authPostController, $hmBWb);
            N00AN:
            RL9bS:
        }
        Cqj1Q:
    }
    public function testExecutePositiveFlowOtpSuccess()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\x67\x65\164\x55\x73\145\x72\156\141\x6d\145" => "\141\144\x6d\151\x6e"]);
        $EF1T8 = ["\x61\x75\x74\x68\x74\171\x70\145" => "\117\117\105", "\145\x6d\141\151\x6c" => "\x61\x64\155\151\156\x40\145\x78\x61\x6d\x70\154\145\56\143\157\155", "\x70\x68\157\x6e\145" => "\61\x32\x33\x34\x35\x36\x37\70\x39\60", "\x63\x6f\165\x6e\x74\162\171\143\x6f\144\x65" => "\71\61", "\163\145\143\162\145\x74" => "\163\x65\143\162\x65\x74"];
        $this->storageSession->method("\x67\145\x74\104\141\x74\141")->with("\165\x73\145\162")->willReturn($user);
        $this->request->method("\147\145\x74\120\141\162\x61\155\x73")->willReturn($EF1T8);
        $this->twofautility->method("\147\145\156\145\x72\141\164\145\x52\141\156\x64\157\155\123\164\162\151\x6e\147")->willReturn("\x73\x65\x63\162\x65\164");
        $this->twofautility->method("\147\145\x74\123\x74\157\162\x65\103\x6f\156\x66\151\x67")->willReturn(false);
        $this->twofautility->method("\x73\x65\164\x53\145\163\163\151\157\x6e\x56\141\154\165\x65");
        $this->twofautility->method("\x6c\157\x67\x5f\144\145\142\x75\x67");
        $this->customEmail->method("\x73\x65\x6e\144\x43\165\163\164\x6f\155\x67\141\x74\145\x77\x61\171\105\x6d\141\x69\x6c")->willReturn(["\163\164\x61\x74\x75\163" => "\x53\x55\x43\x43\105\x53\123", "\x6d\x65\163\x73\141\x67\x65" => "\x4f\124\x50\40\x73\145\x6e\164", "\164\170\x49\x64" => "\x31"]);
        $this->resultRedirectFactory->method("\143\x72\x65\x61\164\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\x73\x65\x74\120\141\x74\150")->willReturnSelf();
        $this->url->method("\x67\145\x74\125\162\x6c")->willReturn("\162\x65\x64\151\x72\145\143\x74\x2d\165\x72\154");
        $this->response->method("\x73\145\164\122\x65\x64\x69\162\x65\x63\x74")->willReturn($this->response);
        $gxXUR = $this->authPostController->execute();
        $this->assertTrue($gxXUR instanceof \Magento\Framework\App\ResponseInterface || $gxXUR instanceof \Magento\Backend\Model\View\Result\Redirect);
    }
    public function testExecuteNoUserInSession()
    {
        $this->storageSession->method("\x67\145\164\104\x61\164\141")->with("\165\x73\x65\162")->willReturn(null);
        $this->resultRedirectFactory->method("\143\x72\145\141\x74\145")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\163\x65\x74\120\x61\164\x68")->willReturnSelf();
        $gxXUR = $this->authPostController->execute();
        $this->assertInstanceOf(\Magento\Backend\Model\View\Result\Redirect::class, $gxXUR);
    }
    public function testExecuteExceptionThrown()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\147\145\x74\125\163\145\x72\x6e\x61\155\x65" => "\141\x64\155\151\156"]);
        $this->storageSession->method("\x67\145\164\x44\x61\164\x61")->with("\x75\163\145\162")->willReturn($user);
        $this->request->method("\x67\145\164\120\x61\x72\141\155\163")->willReturn(["\163\153\151\160\x74\167\157\146\141" => 1]);
        $this->twofautility->method("\147\145\164\x53\x6b\x69\x70\124\167\157\x46\x61\137\101\x64\155\x69\156")->willThrowException(new \Exception("\124\145\163\164\x20\105\170\x63\x65\x70\x74\151\x6f\x6e"));
        $this->resultRedirectFactory->method("\x63\162\145\x61\x74\145")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\x73\x65\164\120\141\164\x68")->willReturnSelf();
        $this->messageManager->expects($this->once())->method("\141\144\144\x45\x72\162\157\162")->with("\x54\145\163\x74\x20\x45\170\143\x65\x70\x74\151\157\156");
        $gxXUR = $this->authPostController->execute();
        $this->assertInstanceOf(\Magento\Backend\Model\View\Result\Redirect::class, $gxXUR);
    }
    public function testExecuteOtpFailed()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\x67\x65\164\x55\163\145\x72\156\141\x6d\145" => "\x61\x64\155\x69\x6e"]);
        $EF1T8 = ["\x61\165\164\150\x74\x79\160\x65" => "\117\117\105", "\x65\x6d\x61\151\x6c" => "\141\x64\155\151\156\100\x65\170\141\x6d\x70\154\145\x2e\143\x6f\155", "\x70\150\x6f\156\x65" => "\61\62\63\64\65\66\67\x38\71\60", "\143\x6f\x75\x6e\164\162\x79\143\157\x64\145" => "\x39\x31", "\x73\x65\x63\162\145\x74" => "\163\x65\x63\x72\145\164"];
        $this->storageSession->method("\x67\x65\164\104\141\x74\141")->with("\165\x73\x65\162")->willReturn($user);
        $this->request->method("\147\145\x74\x50\141\x72\141\155\163")->willReturn($EF1T8);
        $this->twofautility->method("\x67\x65\x6e\x65\x72\x61\x74\145\122\x61\x6e\144\157\155\123\164\x72\151\x6e\147")->willReturn("\163\x65\143\x72\145\x74");
        $this->twofautility->method("\147\x65\x74\x53\x74\157\162\145\103\157\x6e\146\151\147")->willReturn(false);
        $this->twofautility->method("\x73\145\x74\x53\x65\x73\x73\151\157\x6e\x56\x61\154\165\145");
        $this->twofautility->method("\154\x6f\147\137\144\145\142\165\147");
        $this->customEmail->method("\163\x65\156\x64\x43\x75\163\x74\157\x6d\x67\x61\164\x65\167\x61\x79\x45\x6d\x61\x69\x6c")->willReturn(["\x73\164\x61\164\x75\x73" => "\106\x41\111\114\x45\x44", "\x6d\x65\163\163\141\147\145" => "\x4f\124\120\40\x66\x61\151\x6c\x65\144", "\x74\170\x49\144" => "\x31"]);
        $this->resultRedirectFactory->method("\143\x72\x65\141\164\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\x73\145\164\x50\x61\164\150")->willReturnSelf();
        $this->url->method("\147\145\x74\125\x72\x6c")->willReturn("\x72\145\144\x69\162\145\x63\164\55\x75\162\x6c");
        $this->response->method("\x73\x65\164\x52\145\x64\x69\162\x65\x63\164")->willReturn($this->response);
        $gxXUR = $this->authPostController->execute();
        $this->assertTrue($gxXUR instanceof \Magento\Framework\App\ResponseInterface || $gxXUR instanceof \Magento\Backend\Model\View\Result\Redirect);
    }
    public function testExecuteOtpFalseStatus()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\147\145\x74\x55\163\145\x72\156\x61\x6d\x65" => "\141\x64\155\x69\x6e"]);
        $EF1T8 = ["\x56\x61\x6c\x69\144\141\x74\x65" => 1, "\x61\165\x74\150\55\143\x6f\x64\x65" => "\61\62\63\x34\x35\x36"];
        $this->storageSession->method("\x67\145\x74\104\x61\x74\x61")->with("\x75\163\x65\162")->willReturn($user);
        $this->request->method("\x67\145\164\120\x61\162\141\155\x73")->willReturn($EF1T8);
        $this->twofautility->method("\x67\145\164\x41\154\154\115\157\124\146\141\125\163\145\x72\x44\145\164\141\151\154\163")->willReturn([["\x61\143\164\x69\x76\x65\x5f\x6d\x65\x74\x68\157\144" => "\117\x4f\x45"]]);
        $this->twofautility->method("\x67\145\x74\x53\x65\x73\163\151\x6f\x6e\x56\x61\x6c\165\x65")->willReturn("\x4f\117\105");
        $this->twofautility->method("\x6c\157\147\137\x64\145\142\165\x67");
        $this->twofautility->method("\147\145\x74\x53\x74\157\x72\145\x43\x6f\156\x66\x69\147")->willReturn(false);
        $this->twofautility->method("\x63\x75\x73\164\157\155\147\141\164\x65\x77\x61\171\137\x76\x61\154\x69\x64\141\x74\x65\117\124\120")->willReturn("\x46\x41\114\123\x45");
        $this->resultRedirectFactory->method("\x63\162\145\141\164\145")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\x73\x65\164\x50\141\x74\150")->willReturnSelf();
        $this->url->method("\147\145\x74\x55\162\x6c")->willReturn("\162\x65\144\151\x72\x65\x63\x74\x2d\x75\162\x6c");
        $this->response->method("\x73\145\164\122\x65\144\151\x72\145\143\x74")->willReturn($this->response);
        $eWfiw = $this->getMockBuilder(\stdClass::class)->addMethods(["\x73\x65\x74\125\163\145\x72", "\x70\x72\157\143\x65\x73\x73\114\x6f\147\x69\156"])->getMock();
        $this->auth->method("\x67\x65\x74\x41\x75\x74\150\123\164\157\x72\141\x67\145")->willReturn($eWfiw);
        $U70Ig = $this->getMockBuilder(\stdClass::class)->addMethods(["\x69\x73\x4f\x74\x68\x65\x72\x53\145\x73\163\x69\157\x6e\163\124\x65\162\155\151\156\x61\164\145\x64"])->getMock();
        $U70Ig->method("\151\x73\117\x74\150\x65\x72\123\x65\x73\x73\151\x6f\156\x73\x54\145\x72\155\x69\x6e\x61\164\145\x64")->willReturn(false);
        $this->sessionsManager->method("\x67\x65\x74\x43\x75\x72\x72\145\x6e\164\x53\145\163\163\x69\x6f\x6e")->willReturn($U70Ig);
        $gxXUR = $this->authPostController->execute();
        $this->assertTrue($gxXUR instanceof \Magento\Framework\App\ResponseInterface || $gxXUR instanceof \Magento\Backend\Model\View\Result\Redirect);
    }
    public function testExecuteMissingParams()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\x67\145\164\x55\x73\x65\162\x6e\141\155\x65" => "\141\144\155\x69\156"]);
        $this->storageSession->method("\147\x65\x74\104\x61\164\141")->with("\x75\163\145\x72")->willReturn($user);
        $this->request->method("\x67\145\x74\x50\141\x72\x61\x6d\163")->willReturn([]);
        $this->resultRedirectFactory->method("\143\x72\x65\141\x74\145")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\x73\x65\164\x50\x61\164\x68")->willReturnSelf();
        $gxXUR = $this->authPostController->execute();
        $this->assertInstanceOf(\Magento\Backend\Model\View\Result\Redirect::class, $gxXUR);
    }
    public function testExecuteEdgeEmptyEmailPhoneCountry()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\x67\x65\x74\x55\163\145\x72\x6e\x61\x6d\x65" => "\141\x64\155\x69\156"]);
        $EF1T8 = ["\x61\165\x74\x68\x74\x79\160\145" => "\x4f\x4f\105", "\x65\155\x61\x69\154" => '', "\x70\x68\x6f\x6e\x65" => '', "\143\x6f\165\x6e\164\x72\171\x63\x6f\x64\x65" => ''];
        $this->storageSession->method("\147\x65\x74\x44\x61\164\x61")->with("\165\x73\x65\162")->willReturn($user);
        $this->request->method("\147\x65\164\120\x61\x72\x61\x6d\x73")->willReturn($EF1T8);
        $this->twofautility->method("\x67\145\x6e\x65\162\x61\164\145\122\141\156\x64\157\x6d\123\x74\x72\151\x6e\147")->willReturn("\163\x65\143\162\x65\x74");
        $this->twofautility->method("\147\x65\x74\x53\x74\157\162\145\103\x6f\156\x66\x69\147")->willReturn(false);
        $this->twofautility->method("\163\145\x74\123\x65\x73\163\151\157\156\x56\x61\x6c\x75\x65");
        $this->twofautility->method("\154\157\147\137\144\145\142\x75\147");
        $this->customEmail->method("\x73\145\156\144\103\x75\x73\164\157\x6d\x67\141\x74\145\x77\x61\x79\105\155\141\151\154")->willReturn(["\163\x74\x61\164\165\x73" => "\x53\x55\103\103\x45\x53\123", "\155\145\x73\163\x61\147\145" => "\x4f\x54\x50\x20\163\145\x6e\164", "\x74\170\x49\144" => "\61"]);
        $this->resultRedirectFactory->method("\143\162\x65\x61\x74\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\x73\145\164\120\x61\x74\150")->willReturnSelf();
        $this->url->method("\x67\x65\x74\x55\162\x6c")->willReturn("\x72\x65\144\x69\x72\x65\x63\x74\55\165\x72\154");
        $this->response->method("\x73\145\164\x52\x65\144\151\162\x65\143\164")->willReturn($this->response);
        $gxXUR = $this->authPostController->execute();
        $this->assertTrue($gxXUR instanceof \Magento\Framework\App\ResponseInterface || $gxXUR instanceof \Magento\Backend\Model\View\Result\Redirect);
    }
    public function testExecuteAllOtherSessionsTerminatedWarning()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\x67\x65\x74\125\163\x65\x72\156\x61\155\145" => "\141\144\x6d\151\x6e"]);
        $EF1T8 = ["\x73\153\151\160\x74\167\157\146\x61" => 1];
        $this->storageSession->method("\147\145\x74\104\x61\164\x61")->with("\x75\x73\145\x72")->willReturn($user);
        $this->request->method("\147\x65\164\x50\x61\162\141\x6d\x73")->willReturn($EF1T8);
        $this->twofautility->method("\x67\x65\x74\123\153\x69\x70\x54\x77\x6f\x46\141\x5f\x41\x64\x6d\x69\156");
        $eWfiw = $this->getMockBuilder(\stdClass::class)->addMethods(["\x73\145\164\x55\163\x65\162", "\160\x72\x6f\x63\x65\163\x73\x4c\157\x67\151\156"])->getMock();
        $this->auth->method("\x67\x65\x74\x41\x75\164\150\x53\164\157\162\x61\x67\145")->willReturn($eWfiw);
        $this->sessionsManager->method("\160\162\157\143\145\x73\x73\114\157\147\151\156");
        $U70Ig = $this->getMockBuilder(\stdClass::class)->addMethods(["\151\x73\117\x74\150\145\x72\123\145\x73\x73\151\157\156\x73\124\145\x72\155\151\156\x61\164\x65\144"])->getMock();
        $U70Ig->method("\x69\163\117\164\x68\145\162\x53\x65\163\163\x69\157\156\x73\124\145\x72\155\x69\156\141\164\145\144")->willReturn(true);
        $this->sessionsManager->method("\x67\145\164\x43\165\162\162\x65\x6e\x74\x53\x65\163\x73\151\157\x6e")->willReturn($U70Ig);
        $this->resultRedirectFactory->method("\143\162\145\141\x74\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\x73\x65\164\x50\141\x74\x68")->willReturnSelf();
        $this->backendUrl->method("\x67\x65\x74\x53\164\x61\x72\x74\x75\x70\x50\141\x67\x65\x55\x72\154")->willReturn("\x73\164\141\162\x74\x75\x70\55\165\x72\x6c");
        $this->messageManager->expects($this->once())->method("\x61\x64\144\x57\x61\162\156\151\156\x67");
        $gxXUR = $this->authPostController->execute();
        $this->assertInstanceOf(\Magento\Backend\Model\View\Result\Redirect::class, $gxXUR);
    }
    public function testExecuteChooseMethodNotOOE()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\147\145\x74\x55\x73\x65\x72\x6e\141\x6d\145" => "\x61\x64\155\151\156"]);
        $EF1T8 = ["\x63\x68\157\157\163\145\x5f\x6d\x65\164\x68\157\144" => 1, "\x73\x74\145\160\163" => "\117\x4f\x53"];
        $this->storageSession->method("\x67\x65\x74\104\141\164\x61")->with("\165\x73\145\x72")->willReturn($user);
        $this->request->method("\147\x65\164\120\x61\162\x61\x6d\163")->willReturn($EF1T8);
        $this->url->method("\x67\145\x74\125\x72\x6c")->willReturn("\x72\x65\144\151\x72\145\x63\164\x2d\165\x72\x6c");
        $this->response->method("\x73\x65\x74\x52\x65\x64\151\162\145\x63\x74")->willReturn($this->response);
        $gxXUR = $this->authPostController->execute();
        $this->assertSame($this->response, $gxXUR);
    }
    public function testExecuteChooseMethodOOEWithNoAdminEmail()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\147\145\164\x55\163\x65\x72\156\x61\x6d\145" => "\141\144\x6d\151\156"]);
        $EF1T8 = ["\143\x68\157\157\x73\145\x5f\x6d\145\164\150\x6f\144" => 1, "\163\x74\x65\x70\x73" => "\117\x4f\x45"];
        $this->storageSession->method("\x67\x65\164\x44\x61\x74\141")->with("\165\163\145\162")->willReturn($user);
        $this->request->method("\147\145\164\x50\x61\x72\x61\x6d\x73")->willReturn($EF1T8);
        $this->twofautility->method("\x67\x65\x74\123\x65\163\x73\151\x6f\156\126\141\154\165\x65")->willReturn('');
        $this->url->method("\x67\145\164\125\162\154")->willReturn("\162\x65\144\x69\162\145\x63\164\x2d\x75\162\154");
        $this->response->method("\163\x65\164\122\x65\144\x69\x72\x65\143\164")->willReturn($this->response);
        $gxXUR = $this->authPostController->execute();
        $this->assertSame($this->response, $gxXUR);
    }
    public function testExecuteChooseMethodOOEWithAdminEmail()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\147\x65\164\x55\163\145\162\x6e\141\155\145" => "\141\x64\155\x69\156"]);
        $EF1T8 = ["\x63\x68\157\157\163\145\x5f\x6d\145\x74\x68\157\144" => 1, "\163\x74\x65\160\x73" => "\x4f\x4f\105"];
        $this->storageSession->method("\147\x65\x74\104\x61\164\141")->with("\x75\163\x65\162")->willReturn($user);
        $this->request->method("\x67\x65\x74\120\x61\162\x61\x6d\x73")->willReturn($EF1T8);
        $this->twofautility->method("\147\145\164\x53\x65\x73\x73\x69\157\x6e\126\141\154\x75\x65")->willReturn("\141\x64\155\151\156\100\145\x78\x61\155\x70\x6c\145\56\143\157\155");
        $this->url->method("\147\145\164\x55\162\x6c")->willReturn("\162\145\144\151\162\x65\143\164\55\x75\162\154");
        $this->response->method("\x73\x65\x74\122\145\144\x69\162\x65\143\164")->willReturn($this->response);
        $this->resultRedirectFactory->method("\143\x72\x65\x61\x74\145")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\163\145\x74\120\x61\x74\150")->willReturnSelf();
        $gxXUR = $this->authPostController->execute();
        $this->assertTrue($gxXUR instanceof \Magento\Framework\App\ResponseInterface || $gxXUR instanceof \Magento\Backend\Model\View\Result\Redirect);
    }
    public function testExecuteValidateGoogleAuthenticator()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\x67\145\164\125\x73\145\x72\x6e\x61\x6d\x65" => "\x61\144\x6d\x69\x6e"]);
        $EF1T8 = ["\x56\141\x6c\151\x64\x61\164\x65" => 1, "\107\x6f\x6f\x67\154\x65\101\x75\164\x68\x65\x6e\x74\x69\x63\141\164\157\162" => "\107\157\x6f\147\154\x65\101\x75\x74\x68\x65\156\x74\x69\143\x61\x74\157\x72", "\141\x75\x74\150\55\x63\x6f\x64\145" => "\x31\x32\x33\64\65\x36"];
        $this->storageSession->method("\x67\145\x74\104\x61\164\141")->with("\x75\163\145\162")->willReturn($user);
        $this->request->method("\x67\x65\164\120\141\162\x61\x6d\x73")->willReturn($EF1T8);
        $this->twofautility->method("\147\145\x74\101\154\x6c\x4d\x6f\124\x66\x61\x55\x73\145\x72\104\x65\x74\x61\x69\x6c\x73")->willReturn([["\x61\x63\x74\x69\x76\x65\x5f\x6d\145\164\150\x6f\144" => "\107\x6f\x6f\147\x6c\x65\101\165\164\150\x65\156\x74\151\143\x61\164\157\x72"]]);
        $this->twofautility->method("\147\x65\164\x53\145\163\163\x69\157\156\126\141\x6c\165\x65")->willReturn("\107\x6f\x6f\147\154\145\x41\x75\164\x68\x65\156\164\151\143\x61\x74\x6f\162");
        $this->twofautility->method("\154\157\x67\137\x64\x65\x62\165\x67");
        $this->twofautility->method("\166\x65\x72\151\146\x79\107\x61\x75\164\150\x43\x6f\x64\x65")->willReturn(json_encode(["\x73\164\x61\x74\165\x73" => "\x53\125\103\103\105\x53\123"]));
        $this->twofautility->method("\x73\145\x74\123\145\163\163\x69\157\x6e\x56\141\154\165\x65");
        $this->twofautility->method("\147\x65\x6e\x65\x72\x61\164\x65\x52\141\x6e\x64\x6f\x6d\x53\164\162\x69\x6e\147")->willReturn("\163\145\143\162\x65\x74");
        $this->resultRedirectFactory->method("\143\x72\145\141\x74\145")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\x73\145\164\x50\x61\x74\x68")->willReturnSelf();
        $this->url->method("\147\145\164\x55\162\154")->willReturn("\162\x65\144\151\x72\145\x63\x74\55\165\x72\x6c");
        $this->response->method("\x73\x65\x74\122\x65\144\x69\162\145\143\x74")->willReturn($this->response);
        $eWfiw = $this->getMockBuilder(\stdClass::class)->addMethods(["\x73\x65\164\125\163\x65\x72", "\x70\x72\157\143\x65\163\x73\x4c\x6f\147\151\156"])->getMock();
        $this->auth->method("\147\145\164\101\x75\x74\x68\x53\x74\x6f\162\x61\147\145")->willReturn($eWfiw);
        $U70Ig = $this->getMockBuilder(\stdClass::class)->addMethods(["\x69\x73\x4f\164\150\x65\x72\x53\x65\163\x73\x69\x6f\156\163\x54\x65\x72\155\151\x6e\141\x74\x65\144"])->getMock();
        $U70Ig->method("\151\163\117\164\150\x65\x72\123\x65\x73\163\x69\157\x6e\163\124\145\x72\x6d\151\156\141\164\x65\144")->willReturn(false);
        $this->sessionsManager->method("\147\145\x74\103\x75\x72\162\x65\156\164\123\x65\x73\163\151\157\156")->willReturn($U70Ig);
        $gxXUR = $this->authPostController->execute();
        $this->assertTrue($gxXUR instanceof \Magento\Framework\App\ResponseInterface || $gxXUR instanceof \Magento\Backend\Model\View\Result\Redirect);
    }
    public function testExecuteValidateOOWCustomGateway()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\147\x65\x74\x55\163\x65\x72\x6e\141\155\145" => "\141\144\155\x69\156"]);
        $EF1T8 = ["\141\165\164\150\x74\x79\x70\145" => "\117\x4f\x57", "\x63\157\165\156\164\162\171\x63\157\x64\x65" => "\x39\61", "\160\150\x6f\156\145" => "\61\62\x33\64\x35\x36\67\70\x39\x30", "\x65\155\x61\x69\x6c" => "\141\x64\x6d\x69\156\100\x65\x78\141\155\160\154\145\56\143\x6f\155", "\163\145\143\162\x65\x74" => "\163\x65\143\x72\x65\164"];
        $this->storageSession->method("\147\x65\x74\x44\141\x74\141")->with("\165\163\145\162")->willReturn($user);
        $this->request->method("\147\x65\164\x50\141\162\x61\x6d\x73")->willReturn($EF1T8);
        $this->twofautility->method("\147\x65\156\145\162\x61\x74\145\122\x61\156\x64\157\x6d\x53\164\162\x69\156\x67")->willReturn("\x73\x65\143\x72\145\164");
        $this->twofautility->method("\147\145\x74\x53\x74\157\x72\145\x43\157\156\146\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP, null]]);
        $this->twofautility->method("\103\165\x73\164\157\x6d\147\x61\164\145\167\141\x79\137\107\145\x6e\145\162\141\x74\145\x4f\124\120")->willReturn("\157\164\160");
        $this->twofautility->method("\x73\x65\156\144\137\143\165\163\164\157\x6d\x67\141\164\145\167\x61\x79\x5f\x77\150\x61\x74\163\141\160\160")->willReturn(["\x73\164\141\164\165\163" => "\x53\125\x43\103\x45\x53\123", "\x6d\x65\163\x73\x61\x67\145" => "\117\x54\120\x20\x73\145\156\x74", "\164\x78\111\144" => "\x31"]);
        $this->twofautility->method("\x73\145\164\123\145\x73\163\x69\157\x6e\126\141\x6c\165\145");
        $this->twofautility->method("\x6c\157\x67\x5f\144\x65\142\x75\x67");
        $this->resultRedirectFactory->method("\143\162\x65\141\x74\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\x73\145\x74\x50\x61\164\x68")->willReturnSelf();
        $this->url->method("\x67\145\x74\x55\162\x6c")->willReturn("\x72\x65\x64\x69\162\x65\143\x74\x2d\165\x72\x6c");
        $this->response->method("\x73\x65\x74\x52\x65\x64\x69\x72\x65\x63\164")->willReturn($this->response);
        $gxXUR = $this->authPostController->execute();
        $this->assertTrue($gxXUR instanceof \Magento\Framework\App\ResponseInterface || $gxXUR instanceof \Magento\Backend\Model\View\Result\Redirect);
    }
    public function testExecuteValidateOOSECustomGateway()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\147\145\164\x55\163\x65\x72\x6e\141\155\145" => "\x61\144\155\x69\x6e"]);
        $EF1T8 = ["\x61\x75\x74\150\164\x79\x70\x65" => "\x4f\117\123\105", "\143\157\165\156\x74\x72\x79\x63\x6f\x64\x65" => "\x39\61", "\x70\x68\x6f\156\145" => "\61\62\63\64\x35\x36\67\x38\x39\60", "\145\x6d\141\x69\x6c" => "\x61\x64\155\151\156\100\x65\x78\141\x6d\160\154\145\56\143\157\155", "\163\145\143\x72\x65\x74" => "\163\x65\143\x72\x65\x74"];
        $this->storageSession->method("\147\145\164\104\x61\x74\x61")->with("\165\x73\145\162")->willReturn($user);
        $this->request->method("\147\x65\164\x50\141\x72\141\x6d\x73")->willReturn($EF1T8);
        $this->twofautility->method("\x67\x65\156\145\x72\x61\x74\145\x52\141\x6e\x64\157\155\x53\x74\x72\x69\x6e\147")->willReturn("\163\x65\x63\162\x65\x74");
        $this->twofautility->method("\147\x65\x74\x53\x74\157\162\x65\103\157\x6e\146\151\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, true], [\MiniOrange\TwoFA\Helper\TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, true]]);
        $this->twofautility->method("\103\x75\x73\164\157\x6d\x67\141\x74\145\x77\141\x79\x5f\x47\145\156\145\x72\141\164\145\117\x54\120")->willReturn("\x6f\164\x70");
        $this->customEmail->method("\163\145\x6e\144\x43\165\x73\x74\x6f\155\x67\x61\164\145\x77\141\171\x45\155\x61\151\154")->willReturn(["\163\x74\141\x74\x75\163" => "\123\125\103\103\x45\x53\123"]);
        $this->customSMS->method("\163\145\156\144\137\143\165\163\x74\x6f\155\147\141\x74\145\167\x61\171\137\x73\x6d\x73")->willReturn(["\163\x74\x61\164\165\x73" => "\123\125\x43\103\x45\123\x53"]);
        $this->twofautility->method("\x4f\x54\120\137\157\x76\145\162\x5f\x53\x4d\x53\141\156\x64\x45\115\x41\111\x4c\x5f\115\145\x73\x73\x61\147\x65")->willReturn("\x6d\x65\x73\x73\x61\x67\145");
        $this->twofautility->method("\163\145\x74\x53\x65\163\x73\x69\157\x6e\126\x61\x6c\165\x65");
        $this->twofautility->method("\x6c\157\147\x5f\x64\x65\x62\x75\147");
        $this->resultRedirectFactory->method("\143\162\x65\141\x74\145")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\163\x65\x74\x50\141\x74\150")->willReturnSelf();
        $this->url->method("\147\145\x74\x55\x72\x6c")->willReturn("\x72\x65\144\x69\x72\x65\x63\x74\55\x75\x72\x6c");
        $this->response->method("\x73\145\x74\122\x65\x64\x69\x72\145\143\x74")->willReturn($this->response);
        $gxXUR = $this->authPostController->execute();
        $this->assertTrue($gxXUR instanceof \Magento\Framework\App\ResponseInterface || $gxXUR instanceof \Magento\Backend\Model\View\Result\Redirect);
    }
    public function testExecuteValidateFailedBranch()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\147\x65\x74\125\163\145\x72\156\x61\155\145" => "\141\144\155\151\x6e"]);
        $EF1T8 = ["\126\x61\x6c\151\144\x61\x74\145" => 1, "\141\x75\164\150\55\x63\x6f\x64\x65" => "\61\x32\x33\64\x35\66"];
        $this->storageSession->method("\x67\x65\x74\104\141\x74\x61")->with("\165\163\145\162")->willReturn($user);
        $this->request->method("\147\x65\x74\120\141\x72\141\155\163")->willReturn($EF1T8);
        $this->twofautility->method("\x67\x65\164\101\x6c\154\115\x6f\x54\146\141\125\163\145\162\104\145\164\141\151\154\x73")->willReturn([["\141\143\x74\x69\166\145\137\155\145\x74\150\x6f\x64" => "\117\x4f\x45"]]);
        $this->twofautility->method("\x67\x65\x74\123\x65\x73\x73\151\x6f\156\x56\x61\x6c\165\x65")->willReturn("\x4f\x4f\x45");
        $this->twofautility->method("\x6c\x6f\x67\x5f\x64\145\142\165\147");
        $this->twofautility->method("\147\145\164\123\x74\x6f\x72\145\103\157\x6e\x66\x69\x67")->willReturn(false);
        $this->twofautility->method("\143\165\x73\164\157\x6d\x67\141\164\145\167\141\171\x5f\166\x61\154\x69\144\x61\x74\145\117\x54\x50")->willReturn("\106\101\x49\x4c\105\x44");
        $this->resultRedirectFactory->method("\x63\162\x65\x61\164\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\163\x65\x74\120\x61\x74\150")->willReturnSelf();
        $this->url->method("\147\145\164\x55\x72\x6c")->willReturn("\x72\x65\x64\151\x72\145\x63\x74\55\x75\162\x6c");
        $this->response->method("\163\145\x74\122\145\x64\x69\162\145\143\x74")->willReturn($this->response);
        $eWfiw = $this->getMockBuilder(\stdClass::class)->addMethods(["\163\145\164\x55\x73\x65\x72", "\x70\x72\x6f\143\x65\163\x73\114\x6f\147\151\x6e"])->getMock();
        $this->auth->method("\x67\x65\164\x41\165\x74\150\x53\164\x6f\162\x61\147\145")->willReturn($eWfiw);
        $U70Ig = $this->getMockBuilder(\stdClass::class)->addMethods(["\151\x73\x4f\x74\x68\x65\162\123\145\163\163\x69\157\156\x73\124\145\x72\x6d\x69\x6e\x61\164\145\x64"])->getMock();
        $U70Ig->method("\151\163\x4f\164\x68\145\x72\x53\x65\x73\x73\x69\157\156\163\124\x65\162\155\x69\x6e\141\164\x65\144")->willReturn(false);
        $this->sessionsManager->method("\x67\x65\164\103\x75\162\162\x65\x6e\x74\123\x65\x73\163\x69\x6f\x6e")->willReturn($U70Ig);
        $gxXUR = $this->authPostController->execute();
        $this->assertTrue($gxXUR instanceof \Magento\Framework\App\ResponseInterface || $gxXUR instanceof \Magento\Backend\Model\View\Result\Redirect);
    }
    public function testExecuteValidateFalseBranchWithInline()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\x67\145\164\x55\x73\x65\x72\156\141\155\145" => "\x61\x64\155\x69\156"]);
        $EF1T8 = ["\126\141\x6c\151\x64\141\164\145" => 1, "\x61\x75\164\150\x2d\143\157\x64\145" => "\61\62\x33\x34\65\66"];
        $this->storageSession->method("\x67\x65\164\104\x61\x74\x61")->with("\x75\163\145\162")->willReturn($user);
        $this->request->method("\x67\x65\164\x50\x61\162\x61\x6d\163")->willReturn($EF1T8);
        $this->twofautility->method("\147\x65\164\x41\x6c\154\x4d\x6f\x54\x66\141\x55\163\x65\x72\104\145\x74\141\x69\154\x73")->willReturn([["\141\143\164\151\166\x65\137\155\145\164\x68\157\x64" => "\117\117\x45"]]);
        $this->twofautility->method("\x67\x65\164\x53\x65\x73\163\151\x6f\x6e\x56\141\x6c\165\x65")->willReturnMap([["\141\144\155\151\156\137\141\143\x74\x69\x76\x65\x5f\x6d\145\x74\x68\x6f\x64", null], ["\141\x64\155\x69\x6e\137\x69\163\151\156\x6c\151\156\x65", 1]]);
        $this->twofautility->method("\x6c\157\x67\x5f\144\x65\x62\x75\147");
        $this->twofautility->method("\x67\x65\164\123\x74\157\x72\145\103\x6f\156\x66\151\x67")->willReturn(false);
        $this->twofautility->method("\143\165\x73\x74\157\x6d\x67\x61\x74\x65\x77\x61\171\137\166\141\x6c\x69\144\x61\164\x65\117\x54\x50")->willReturn("\x46\101\114\123\x45");
        $this->resultRedirectFactory->method("\x63\x72\145\x61\164\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\163\x65\164\x50\141\x74\150")->willReturnSelf();
        $this->url->method("\x67\x65\x74\x55\162\x6c")->willReturn("\162\x65\x64\x69\x72\145\143\164\x2d\165\162\x6c");
        $this->response->method("\x73\145\164\122\145\x64\x69\x72\x65\143\164")->willReturn($this->response);
        $eWfiw = $this->getMockBuilder(\stdClass::class)->addMethods(["\x73\x65\164\125\163\145\x72", "\x70\x72\157\143\x65\163\x73\x4c\157\x67\151\156"])->getMock();
        $this->auth->method("\x67\145\164\101\165\164\150\123\164\x6f\162\x61\x67\x65")->willReturn($eWfiw);
        $U70Ig = $this->getMockBuilder(\stdClass::class)->addMethods(["\151\x73\x4f\164\150\145\x72\x53\x65\x73\163\151\157\156\163\x54\x65\162\x6d\151\x6e\x61\164\x65\x64"])->getMock();
        $U70Ig->method("\x69\163\x4f\x74\x68\145\162\123\x65\163\163\x69\x6f\156\163\x54\145\162\x6d\151\156\141\x74\x65\144")->willReturn(false);
        $this->sessionsManager->method("\147\x65\x74\103\x75\x72\x72\x65\156\x74\123\x65\163\163\151\x6f\x6e")->willReturn($U70Ig);
        $gxXUR = $this->authPostController->execute();
        $this->assertTrue($gxXUR instanceof \Magento\Framework\App\ResponseInterface || $gxXUR instanceof \Magento\Backend\Model\View\Result\Redirect);
    }
    public function testExecuteValidateExceptionThrown()
    {
        $user = $this->createConfiguredMock(\Magento\User\Model\User::class, ["\147\145\164\x55\x73\145\x72\156\141\155\145" => "\141\144\155\x69\x6e"]);
        $EF1T8 = ["\x56\x61\154\x69\144\x61\x74\145" => 1, "\x61\165\x74\x68\x2d\143\x6f\x64\x65" => "\61\62\x33\64\65\x36"];
        $this->storageSession->method("\x67\x65\164\104\141\164\141")->with("\x75\163\x65\162")->willReturn($user);
        $this->request->method("\x67\x65\164\120\141\162\x61\155\x73")->willReturn($EF1T8);
        $this->twofautility->method("\x67\145\164\x41\x6c\x6c\x4d\x6f\x54\146\141\x55\163\145\x72\104\x65\x74\x61\x69\x6c\x73")->willThrowException(new \Exception("\126\x61\x6c\x69\144\x61\164\151\x6f\x6e\x20\105\x78\x63\145\160\x74\151\157\x6e"));
        $this->resultRedirectFactory->method("\143\x72\x65\141\164\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\x73\145\164\120\141\x74\x68")->willReturnSelf();
        $this->messageManager->expects($this->once())->method("\141\x64\144\x45\x72\x72\x6f\162")->with("\x56\141\x6c\151\x64\x61\164\151\x6f\156\40\x45\x78\x63\145\x70\164\151\x6f\156");
        $gxXUR = $this->authPostController->execute();
        $this->assertTrue($gxXUR instanceof \Magento\Framework\App\ResponseInterface || $gxXUR instanceof \Magento\Backend\Model\View\Result\Redirect);
    }
    public function testGetRedirectWithValidPath()
    {
        $this->resultRedirectFactory->method("\143\x72\x65\141\x74\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->expects($this->once())->method("\x73\x65\x74\120\141\x74\150")->with("\163\157\x6d\x65\55\160\x61\164\150")->willReturnSelf();
        $xPetv = new \ReflectionMethod($this->authPostController, "\x5f\x67\x65\x74\122\x65\x64\x69\162\x65\x63\164");
        $xPetv->setAccessible(true);
        $gxXUR = $xPetv->invoke($this->authPostController, "\163\x6f\155\x65\55\160\x61\x74\x68");
        $this->assertSame($this->resultRedirect, $gxXUR);
    }
    public function testGetRedirectWithEmptyPath()
    {
        $this->resultRedirectFactory->method("\143\x72\145\141\x74\145")->willReturn($this->resultRedirect);
        $this->resultRedirect->expects($this->once())->method("\x73\145\164\x50\141\x74\x68")->with('')->willReturnSelf();
        $xPetv = new \ReflectionMethod($this->authPostController, "\137\147\145\x74\x52\x65\x64\151\162\145\x63\164");
        $xPetv->setAccessible(true);
        $gxXUR = $xPetv->invoke($this->authPostController, '');
        $this->assertSame($this->resultRedirect, $gxXUR);
    }
    public function testIsAllowedAlwaysReturnsTrue()
    {
        $xPetv = new \ReflectionMethod($this->authPostController, "\x5f\x69\x73\x41\154\154\157\x77\x65\x64");
        $xPetv->setAccessible(true);
        $this->assertTrue($xPetv->invoke($this->authPostController));
    }
}