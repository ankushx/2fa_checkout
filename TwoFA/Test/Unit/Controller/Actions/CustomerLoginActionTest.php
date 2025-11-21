<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Actions;

use MiniOrange\TwoFA\Controller\Actions\CustomerLoginAction;
use PHPUnit\Framework\TestCase;
use Magento\Framework\App\Action\Context;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use Magento\Customer\Model\Session;
use Magento\Framework\App\ResponseFactory;
use Magento\Framework\App\Response\Http as ResponseHttp;
class CustomerLoginActionTest extends TestCase
{
    private $context;
    private $twofautility;
    private $customerSession;
    private $responseFactory;
    private $response;
    protected function setUp() : void
    {
        $this->context = $this->createMock(Context::class);
        $this->twofautility = $this->createMock(TwoFAUtility::class);
        $this->customerSession = $this->createMock(Session::class);
        $this->responseFactory = $this->createMock(ResponseFactory::class);
        $this->response = $this->createMock(ResponseHttp::class);
    }
    private function getAction()
    {
        return new CustomerLoginAction($this->context, $this->twofautility, $this->customerSession, $this->responseFactory);
    }
    public function testExecutePositiveFlow()
    {
        $user = (object) ["\151\x64" => 1];
        $sB5st = $this->getMockBuilder(CustomerLoginAction::class)->setConstructorArgs([$this->context, $this->twofautility, $this->customerSession, $this->responseFactory])->onlyMethods(["\147\145\x74\x52\145\x73\160\x6f\x6e\x73\145"])->getMock();
        $sB5st->setUser($user);
        $sB5st->method("\147\145\x74\122\145\163\x70\x6f\x6e\x73\x65")->willReturn($this->response);
        $this->twofautility->method("\147\145\x74\102\141\x73\x65\x55\x72\x6c")->willReturn("\x68\164\164\x70\x3a\57\57\154\157\x63\x61\x6c\150\157\x73\164\57");
        $this->twofautility->method("\147\x65\x74\125\162\154")->willReturn("\150\164\x74\x70\72\57\x2f\154\157\143\141\154\150\x6f\x73\x74\x2f\143\165\163\x74\x6f\x6d\145\162\57\x61\x63\x63\157\x75\156\x74");
        $this->twofautility->expects($this->once())->method("\154\157\x67\x5f\x64\x65\142\x75\x67")->with("\x43\x75\x73\x74\157\x6d\145\162\x4c\157\147\151\156\x41\x63\x74\151\157\x6e\x3a\40\145\x78\x65\143\165\x74\x65");
        $this->customerSession->expects($this->once())->method("\163\145\164\x43\165\163\164\x6f\x6d\145\162\x41\x73\114\157\x67\147\145\x64\111\x6e")->with($user);
        $this->responseFactory->method("\x63\x72\x65\x61\x74\x65")->willReturn($this->response);
        $this->response->expects($this->once())->method("\x73\x65\164\x52\145\144\151\x72\x65\x63\164")->with("\x68\x74\x74\x70\x3a\57\x2f\x6c\157\x63\141\154\x68\157\163\164\57\143\x75\163\x74\157\155\x65\162\x2f\x61\143\143\157\165\x6e\x74")->willReturnSelf();
        $this->response->expects($this->once())->method("\x73\x65\156\144\122\145\163\160\x6f\156\163\145")->willReturnSelf();
        $UDeZl = $sB5st->execute();
        $this->assertSame($this->response, $UDeZl);
    }
    public function testExecuteWithNoUserSet()
    {
        $sB5st = $this->getMockBuilder(CustomerLoginAction::class)->setConstructorArgs([$this->context, $this->twofautility, $this->customerSession, $this->responseFactory])->onlyMethods(["\147\x65\164\x52\x65\x73\x70\157\x6e\x73\145"])->getMock();
        $sB5st->method("\x67\145\x74\x52\x65\163\x70\x6f\156\x73\145")->willReturn($this->response);
        $this->twofautility->method("\147\x65\x74\x42\141\163\x65\x55\x72\x6c")->willReturn("\x68\x74\164\160\72\x2f\57\x6c\157\143\x61\154\x68\x6f\x73\164\57");
        $this->twofautility->method("\147\x65\x74\x55\x72\x6c")->willReturn("\x68\x74\x74\x70\x3a\x2f\57\x6c\157\x63\x61\154\150\x6f\x73\164\57\x63\x75\x73\x74\x6f\x6d\x65\x72\57\x61\143\143\157\x75\x6e\x74");
        $this->customerSession->expects($this->once())->method("\163\x65\164\103\165\163\x74\157\x6d\145\x72\x41\x73\114\157\x67\147\145\144\x49\x6e")->with(null);
        $this->responseFactory->method("\x63\x72\x65\141\x74\x65")->willReturn($this->response);
        $this->response->method("\x73\145\164\122\145\x64\151\162\x65\143\x74")->willReturnSelf();
        $this->response->method("\x73\x65\156\144\x52\145\163\160\157\156\x73\145")->willReturnSelf();
        $UDeZl = $sB5st->execute();
        $this->assertSame($this->response, $UDeZl);
    }
    public function testExecuteThrowsIfSessionFails()
    {
        $user = (object) ["\151\144" => 1];
        $sB5st = $this->getMockBuilder(CustomerLoginAction::class)->setConstructorArgs([$this->context, $this->twofautility, $this->customerSession, $this->responseFactory])->onlyMethods(["\147\x65\164\x52\x65\163\160\157\x6e\x73\x65"])->getMock();
        $sB5st->setUser($user);
        $sB5st->method("\x67\145\x74\122\x65\163\x70\x6f\x6e\x73\145")->willReturn($this->response);
        $this->twofautility->method("\147\145\164\102\x61\163\x65\125\162\x6c")->willReturn("\x68\164\164\160\72\57\x2f\x6c\x6f\143\x61\154\x68\157\x73\x74\x2f");
        $this->twofautility->method("\147\145\x74\x55\162\x6c")->willReturn("\150\x74\164\160\x3a\x2f\57\x6c\x6f\143\x61\x6c\x68\x6f\x73\164\x2f\x63\165\163\164\157\155\145\x72\x2f\x61\x63\143\x6f\165\x6e\164");
        $this->customerSession->expects($this->once())->method("\163\x65\164\103\165\x73\164\x6f\155\x65\162\101\x73\114\x6f\x67\x67\x65\144\x49\156")->with($user)->will($this->throwException(new \Exception("\x53\x65\x73\163\151\157\x6e\x20\145\162\x72\157\162")));
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("\123\x65\x73\x73\151\x6f\x6e\x20\x65\162\x72\157\162");
        $sB5st->execute();
    }
    public function testSetUserReturnsSelf()
    {
        $sB5st = $this->getAction();
        $user = (object) ["\151\x64" => 2];
        $UDeZl = $sB5st->setUser($user);
        $this->assertSame($sB5st, $UDeZl);
        $XYMfF = new \ReflectionClass($sB5st);
        $ZdkoT = $XYMfF->getProperty("\165\x73\145\x72");
        $ZdkoT->setAccessible(true);
        $this->assertSame($user, $ZdkoT->getValue($sB5st));
    }
    public function testSetUserWithNull()
    {
        $sB5st = $this->getAction();
        $UDeZl = $sB5st->setUser(null);
        $this->assertSame($sB5st, $UDeZl);
        $XYMfF = new \ReflectionClass($sB5st);
        $ZdkoT = $XYMfF->getProperty("\x75\x73\145\x72");
        $ZdkoT->setAccessible(true);
        $this->assertNull($ZdkoT->getValue($sB5st));
    }
}