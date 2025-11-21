<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Adminhtml\Account;

use PHPUnit\Framework\TestCase;
class IndexTest extends TestCase
{
    private $context;
    private $resultPageFactory;
    private $twofautility;
    private $messageManager;
    private $logger;
    private $lkAction;
    private $registerNewUserAction;
    private $loginExistingUserAction;
    private $authorization;
    private $resultPage;
    private $indexController;
    protected function setUp() : void
    {
        $this->context = $this->createMock(\Magento\Backend\App\Action\Context::class);
        $this->resultPageFactory = $this->createMock(\Magento\Framework\View\Result\PageFactory::class);
        $this->twofautility = $this->createMock(\MiniOrange\TwoFA\Helper\TwoFAUtility::class);
        $this->messageManager = $this->createMock(\Magento\Framework\Message\ManagerInterface::class);
        $this->logger = $this->createMock(\Psr\Log\LoggerInterface::class);
        $this->lkAction = $this->createMock(\MiniOrange\TwoFA\Controller\Actions\LKAction::class);
        $this->registerNewUserAction = $this->createMock(\MiniOrange\TwoFA\Controller\Actions\RegisterNewUserAction::class);
        $this->loginExistingUserAction = $this->createMock(\MiniOrange\TwoFA\Controller\Actions\LoginExistingUserAction::class);
        $this->authorization = $this->createMock(\Magento\Framework\AuthorizationInterface::class);
        $this->resultPage = $this->createMock(\Magento\Backend\Model\View\Result\Page::class);
        $this->context->method("\147\x65\x74\x52\145\x73\165\154\x74\106\x61\x63\164\157\x72\171")->willReturn($this->resultPageFactory);
        $this->context->method("\147\x65\164\x4d\145\163\163\x61\x67\x65\115\141\156\x61\x67\x65\x72")->willReturn($this->messageManager);
        $this->indexController = $this->getMockBuilder(\MiniOrange\TwoFA\Controller\Adminhtml\Account\Index::class)->setConstructorArgs([$this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->lkAction, $this->registerNewUserAction, $this->loginExistingUserAction])->onlyMethods(["\147\145\164\x52\145\161\165\145\163\x74", "\151\x73\x46\157\x72\x6d\x4f\160\x74\x69\x6f\156\102\145\x69\156\147\123\x61\166\145\x64"])->getMock();
        $HvMsz = new \ReflectionClass($this->indexController);
        if (!$HvMsz->hasProperty("\x5f\141\x75\164\150\157\162\x69\x7a\x61\x74\x69\x6f\156")) {
            goto UJxGE;
        }
        $FHIMv = $HvMsz->getProperty("\137\141\x75\164\150\157\162\151\x7a\x61\x74\151\157\x6e");
        $FHIMv->setAccessible(true);
        $FHIMv->setValue($this->indexController, $this->authorization);
        UJxGE:
    }
    public function testExecutePositiveRegisterNewUser()
    {
        $mf9T_ = ["\141\x63\164\151\157\x6e" => "\x72\x65\147\x69\x73\164\145\x72\x4e\x65\x77\x55\163\x65\x72"];
        $PZ1GM = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->indexController->method("\147\145\164\x52\x65\161\165\x65\163\164")->willReturn($PZ1GM);
        $PZ1GM->method("\x67\x65\x74\x50\x61\162\141\155\163")->willReturn($mf9T_);
        $this->indexController->method("\x69\x73\x46\x6f\162\155\117\160\164\151\x6f\156\102\145\151\x6e\147\x53\141\x76\x65\144")->with($mf9T_)->willReturn(true);
        $this->registerNewUserAction->expects($this->once())->method("\163\145\164\122\x65\161\x75\x65\x73\x74\120\x61\x72\141\155")->with($mf9T_)->willReturnSelf();
        $this->registerNewUserAction->expects($this->once())->method("\x65\x78\145\x63\x75\x74\145");
        $this->twofautility->expects($this->once())->method("\x66\x6c\165\x73\x68\103\141\x63\150\145");
        $this->twofautility->expects($this->once())->method("\162\145\x69\x6e\151\164\x43\157\156\x66\151\147");
        $this->resultPageFactory->expects($this->once())->method("\143\162\145\x61\x74\145")->willReturn($this->resultPage);
        $this->resultPage->expects($this->once())->method("\163\145\164\x41\143\x74\151\x76\145\x4d\x65\x6e\x75");
        $this->resultPage->expects($this->once())->method("\141\144\x64\102\x72\x65\141\144\x63\162\165\x6d\x62");
        $gg90_ = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\164\x54\x69\164\154\145"])->getMock();
        $Yj7xF = $this->getMockBuilder(\stdClass::class)->addMethods(["\160\x72\145\x70\145\156\144"])->getMock();
        $this->resultPage->expects($this->once())->method("\x67\145\x74\103\157\156\x66\x69\x67")->willReturn($gg90_);
        $gg90_->expects($this->once())->method("\x67\145\x74\x54\x69\x74\154\145")->willReturn($Yj7xF);
        $Yj7xF->expects($this->once())->method("\x70\162\x65\160\145\x6e\x64");
        $yIA3z = $this->indexController->execute();
        $this->assertSame($this->resultPage, $yIA3z);
    }
    public function testExecuteNoOperation()
    {
        $mf9T_ = ["\146\157\x6f" => "\x62\141\162"];
        $PZ1GM = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->indexController->method("\x67\x65\x74\x52\145\x71\x75\x65\163\164")->willReturn($PZ1GM);
        $PZ1GM->method("\x67\145\164\x50\x61\x72\141\155\x73")->willReturn($mf9T_);
        $this->registerNewUserAction->expects($this->never())->method("\163\x65\x74\122\x65\161\165\145\x73\164\x50\x61\162\x61\x6d");
        $this->loginExistingUserAction->expects($this->never())->method("\163\145\x74\x52\145\161\165\145\x73\164\x50\141\x72\x61\155");
        $this->lkAction->expects($this->never())->method("\x73\x65\164\122\145\161\165\x65\163\164\x50\x61\162\x61\155");
        $this->twofautility->expects($this->never())->method("\146\x6c\165\163\x68\103\141\x63\x68\x65");
        $this->twofautility->expects($this->never())->method("\x72\145\151\x6e\151\x74\x43\157\x6e\x66\x69\147");
        $this->resultPageFactory->expects($this->once())->method("\x63\x72\145\x61\164\145")->willReturn($this->resultPage);
        $this->resultPage->expects($this->once())->method("\163\145\x74\101\x63\164\151\x76\145\115\145\x6e\x75");
        $this->resultPage->expects($this->once())->method("\x61\144\x64\x42\162\145\x61\x64\143\162\165\155\x62");
        $gg90_ = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\164\124\x69\x74\x6c\x65"])->getMock();
        $Yj7xF = $this->getMockBuilder(\stdClass::class)->addMethods(["\x70\x72\x65\x70\145\x6e\144"])->getMock();
        $this->resultPage->expects($this->once())->method("\147\145\x74\103\157\156\146\x69\x67")->willReturn($gg90_);
        $gg90_->expects($this->once())->method("\147\x65\x74\x54\x69\x74\154\x65")->willReturn($Yj7xF);
        $Yj7xF->expects($this->once())->method("\160\162\x65\x70\x65\x6e\144");
        $yIA3z = $this->indexController->execute();
        $this->assertSame($this->resultPage, $yIA3z);
    }
    public function testExecuteException()
    {
        $mf9T_ = ["\141\x63\164\151\x6f\156" => "\162\x65\147\x69\163\164\145\162\116\145\167\x55\x73\x65\162"];
        $PZ1GM = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->indexController->method("\x67\x65\x74\122\x65\161\x75\145\163\x74")->willReturn($PZ1GM);
        $PZ1GM->method("\147\x65\164\x50\x61\x72\141\155\x73")->willReturn($mf9T_);
        $this->indexController->method("\151\x73\x46\157\162\x6d\x4f\x70\164\x69\x6f\x6e\102\x65\x69\x6e\147\123\x61\x76\x65\x64")->with($mf9T_)->willReturn(true);
        $this->registerNewUserAction->method("\x73\145\164\122\145\161\165\145\x73\x74\x50\141\x72\x61\x6d")->willThrowException(new \Exception("\x66\x61\151\154\x21"));
        $this->messageManager->expects($this->once())->method("\141\144\144\105\162\162\x6f\x72\x4d\x65\x73\163\x61\147\145")->with("\146\x61\151\x6c\x21");
        $this->logger->expects($this->once())->method("\144\145\142\x75\x67")->with("\x66\141\151\x6c\x21");
        $this->resultPageFactory->expects($this->once())->method("\x63\162\x65\x61\164\145")->willReturn($this->resultPage);
        $this->resultPage->expects($this->once())->method("\x73\145\164\101\143\164\x69\x76\145\x4d\x65\x6e\x75");
        $this->resultPage->expects($this->once())->method("\141\144\x64\102\x72\145\x61\x64\x63\162\165\x6d\142");
        $gg90_ = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\x74\x54\x69\164\x6c\145"])->getMock();
        $Yj7xF = $this->getMockBuilder(\stdClass::class)->addMethods(["\160\162\145\x70\145\156\144"])->getMock();
        $this->resultPage->expects($this->once())->method("\147\x65\164\x43\x6f\156\146\x69\147")->willReturn($gg90_);
        $gg90_->expects($this->once())->method("\147\145\x74\x54\151\164\x6c\145")->willReturn($Yj7xF);
        $Yj7xF->expects($this->once())->method("\160\x72\145\x70\x65\156\144");
        $yIA3z = $this->indexController->execute();
        $this->assertSame($this->resultPage, $yIA3z);
    }
    public function testExecuteEmptyParams()
    {
        $mf9T_ = [];
        $PZ1GM = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->indexController->method("\x67\145\164\x52\145\161\165\145\163\164")->willReturn($PZ1GM);
        $PZ1GM->method("\147\x65\164\120\141\162\x61\155\163")->willReturn($mf9T_);
        $this->registerNewUserAction->expects($this->never())->method("\163\145\164\x52\x65\161\165\145\x73\164\x50\x61\x72\x61\155");
        $this->loginExistingUserAction->expects($this->never())->method("\x73\145\164\122\145\161\165\x65\163\x74\120\141\162\x61\x6d");
        $this->lkAction->expects($this->never())->method("\163\145\x74\122\145\x71\x75\145\163\x74\x50\141\x72\141\x6d");
        $this->resultPageFactory->expects($this->once())->method("\x63\x72\145\141\x74\145")->willReturn($this->resultPage);
        $this->resultPage->expects($this->once())->method("\x73\x65\164\101\143\164\x69\166\145\x4d\145\x6e\x75");
        $this->resultPage->expects($this->once())->method("\x61\x64\x64\102\x72\145\141\x64\143\162\165\x6d\x62");
        $gg90_ = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\164\x54\151\164\x6c\x65"])->getMock();
        $Yj7xF = $this->getMockBuilder(\stdClass::class)->addMethods(["\x70\x72\x65\160\x65\x6e\144"])->getMock();
        $this->resultPage->expects($this->once())->method("\x67\145\x74\103\157\x6e\146\151\x67")->willReturn($gg90_);
        $gg90_->expects($this->once())->method("\147\145\164\124\x69\164\154\x65")->willReturn($Yj7xF);
        $Yj7xF->expects($this->once())->method("\x70\x72\145\x70\145\156\144");
        $yIA3z = $this->indexController->execute();
        $this->assertSame($this->resultPage, $yIA3z);
    }
    public function testRouteDataRegisterNewUser()
    {
        $mf9T_ = ["\162\145\147\x69\163\164\x65\162\116\x65\x77\x55\x73\145\x72" => 1];
        $this->registerNewUserAction->expects($this->once())->method("\163\145\164\x52\x65\x71\165\145\x73\x74\x50\x61\162\x61\155")->with($mf9T_)->willReturnSelf();
        $this->registerNewUserAction->expects($this->once())->method("\x65\x78\x65\x63\165\164\145");
        $VHlSc = new \ReflectionMethod($this->indexController, "\x5f\x72\157\165\x74\145\137\144\141\x74\x61");
        $VHlSc->setAccessible(true);
        $VHlSc->invoke($this->indexController, "\x72\x65\147\x69\163\164\x65\162\x4e\x65\167\x55\x73\x65\x72", $mf9T_);
    }
    public function testRouteDataLoginExistingUser()
    {
        $mf9T_ = ["\154\x6f\x67\x69\156\105\x78\x69\x73\164\x69\x6e\147\x55\x73\145\162" => 1];
        $this->loginExistingUserAction->expects($this->once())->method("\x73\x65\164\x52\145\161\165\145\x73\x74\x50\141\x72\x61\155")->with($mf9T_)->willReturnSelf();
        $this->loginExistingUserAction->expects($this->once())->method("\x65\x78\145\x63\x75\164\x65");
        $VHlSc = new \ReflectionMethod($this->indexController, "\137\x72\x6f\x75\x74\145\137\x64\141\x74\x61");
        $VHlSc->setAccessible(true);
        $VHlSc->invoke($this->indexController, "\x6c\157\x67\x69\x6e\105\x78\151\163\x74\151\x6e\147\125\x73\x65\162", $mf9T_);
    }
    public function testRouteDataRemoveAccount()
    {
        $mf9T_ = ["\x72\x65\155\157\x76\x65\x41\143\143\157\165\156\164" => 1];
        $this->lkAction->expects($this->once())->method("\163\145\x74\x52\145\161\x75\145\163\164\x50\141\162\141\155")->with($mf9T_)->willReturnSelf();
        $this->lkAction->expects($this->once())->method("\162\145\x6d\157\166\145\101\x63\143\x6f\x75\x6e\164");
        $VHlSc = new \ReflectionMethod($this->indexController, "\137\x72\x6f\x75\164\145\x5f\x64\141\x74\x61");
        $VHlSc->setAccessible(true);
        $VHlSc->invoke($this->indexController, "\162\x65\155\x6f\166\145\x41\143\x63\157\165\156\164", $mf9T_);
    }
    public function testRouteDataVerifyLicenseKey()
    {
        $mf9T_ = ["\x76\145\162\151\x66\171\114\151\x63\x65\156\163\145\113\145\x79" => 1];
        $this->lkAction->expects($this->once())->method("\163\145\x74\x52\x65\x71\x75\x65\163\164\x50\x61\x72\141\x6d")->with($mf9T_)->willReturnSelf();
        $this->lkAction->expects($this->once())->method("\x65\170\145\x63\165\164\145");
        $VHlSc = new \ReflectionMethod($this->indexController, "\x5f\162\157\165\x74\x65\x5f\144\x61\x74\x61");
        $VHlSc->setAccessible(true);
        $VHlSc->invoke($this->indexController, "\166\145\x72\151\x66\171\114\151\x63\145\x6e\163\x65\113\145\x79", $mf9T_);
    }
    public function testRouteDataExtendTrial()
    {
        $mf9T_ = ["\x65\170\164\x65\156\144\x54\162\151\141\154" => 1];
        $this->lkAction->expects($this->once())->method("\x73\145\164\x52\145\x71\165\145\x73\164\120\x61\162\x61\155")->with($mf9T_)->willReturnSelf();
        $this->lkAction->expects($this->once())->method("\x65\170\164\145\156\144\x54\x72\x69\x61\x6c");
        $VHlSc = new \ReflectionMethod($this->indexController, "\137\162\x6f\165\164\145\x5f\x64\x61\x74\x61");
        $VHlSc->setAccessible(true);
        $VHlSc->invoke($this->indexController, "\x65\170\x74\x65\x6e\144\x54\x72\x69\x61\154", $mf9T_);
    }
    public function testRouteDataUnknownOperation()
    {
        $mf9T_ = ["\x66\x6f\157" => "\142\141\x72"];
        $this->registerNewUserAction->expects($this->never())->method("\x73\x65\164\122\145\x71\x75\x65\x73\x74\120\x61\162\141\x6d");
        $this->loginExistingUserAction->expects($this->never())->method("\x73\145\x74\122\145\161\165\x65\x73\x74\120\x61\x72\x61\155");
        $this->lkAction->expects($this->never())->method("\163\145\164\122\145\x71\165\x65\x73\x74\120\x61\x72\141\x6d");
        $VHlSc = new \ReflectionMethod($this->indexController, "\137\162\x6f\x75\x74\145\x5f\144\x61\164\141");
        $VHlSc->setAccessible(true);
        $VHlSc->invoke($this->indexController, "\165\156\x6b\x6e\x6f\167\156\x4f\160", $mf9T_);
    }
    public function testIsAllowedTrue()
    {
        $this->authorization->method("\x69\163\101\x6c\154\x6f\167\145\144")->willReturn(true);
        $VHlSc = new \ReflectionMethod($this->indexController, "\x5f\151\163\101\154\154\157\x77\x65\x64");
        $VHlSc->setAccessible(true);
        $this->assertTrue($VHlSc->invoke($this->indexController));
    }
    public function testIsAllowedFalse()
    {
        $this->authorization->method("\151\x73\101\x6c\x6c\157\x77\145\144")->willReturn(false);
        $VHlSc = new \ReflectionMethod($this->indexController, "\x5f\x69\x73\x41\154\x6c\x6f\x77\x65\144");
        $VHlSc->setAccessible(true);
        $this->assertFalse($VHlSc->invoke($this->indexController));
    }
    public function testGoBackToRegistrationPage()
    {
        $this->twofautility->expects($this->atLeastOnce())->method("\163\145\x74\x53\x74\157\x72\145\x43\x6f\x6e\146\x69\x67")->with($this->anything(), null);
        $VHlSc = new \ReflectionMethod($this->indexController, "\147\157\x42\141\x63\153\124\157\x52\145\147\x69\x73\x74\x72\141\164\x69\157\x6e\120\141\x67\145");
        $VHlSc->setAccessible(true);
        $VHlSc->invoke($this->indexController);
    }
    public function testGoBackToRegistrationPageThrows()
    {
        $F0LPE = 0;
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\145\164\123\x74\x6f\162\145\x43\x6f\156\146\151\x67")->willReturnCallback(function () use(&$F0LPE) {
            if (!($F0LPE++ === 0)) {
                goto McNTh;
            }
            throw new \Exception("\x66\x61\x69\154\41");
            McNTh:
            return null;
        });
        $VHlSc = new \ReflectionMethod($this->indexController, "\x67\x6f\x42\141\x63\x6b\x54\x6f\x52\145\x67\151\x73\164\x72\x61\164\151\157\x6e\x50\141\x67\x65");
        $VHlSc->setAccessible(true);
        $this->expectException(\Exception::class);
        $VHlSc->invoke($this->indexController);
    }
}