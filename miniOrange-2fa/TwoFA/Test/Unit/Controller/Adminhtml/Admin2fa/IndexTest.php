<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Adminhtml\Admin2fa;

use PHPUnit\Framework\TestCase;
class IndexTest extends TestCase
{
    private $context;
    private $twofautility;
    private $resultPageFactory;
    private $messageManager;
    private $logger;
    private $adminRoleModel;
    private $resultRedirectFactory;
    private $resultRedirect;
    private $authorization;
    private $resultPage;
    private $indexController;
    protected function setUp() : void
    {
        $this->context = $this->createMock(\Magento\Backend\App\Action\Context::class);
        $this->twofautility = $this->createMock(\MiniOrange\TwoFA\Helper\TwoFAUtility::class);
        $this->resultPageFactory = $this->createMock(\Magento\Framework\View\Result\PageFactory::class);
        $this->messageManager = $this->createMock(\Magento\Framework\Message\ManagerInterface::class);
        $this->logger = $this->createMock(\Psr\Log\LoggerInterface::class);
        $this->adminRoleModel = $this->createMock(\Magento\Authorization\Model\ResourceModel\Role\Collection::class);
        $this->resultRedirectFactory = $this->createMock(\Magento\Framework\Controller\Result\RedirectFactory::class);
        $this->resultRedirect = $this->createMock(\Magento\Framework\Controller\Result\Redirect::class);
        $this->authorization = $this->createMock(\Magento\Framework\AuthorizationInterface::class);
        $this->resultPage = $this->createMock(\Magento\Backend\Model\View\Result\Page::class);
        $this->context->method("\x67\x65\164\115\x65\163\x73\x61\x67\145\x4d\141\x6e\141\147\x65\162")->willReturn($this->messageManager);
        $this->indexController = $this->getMockBuilder(\MiniOrange\TwoFA\Controller\Adminhtml\Admin2fa\Index::class)->setConstructorArgs([$this->context, $this->twofautility, $this->resultPageFactory, $this->messageManager, $this->logger, $this->adminRoleModel])->onlyMethods(["\147\x65\x74\122\145\161\165\145\163\164", "\x69\x73\x46\x6f\x72\x6d\x4f\x70\164\x69\x6f\156\x42\x65\151\x6e\x67\123\x61\166\x65\144"])->getMock();
        $ukLSw = new \ReflectionClass($this->indexController);
        if (!$ukLSw->hasProperty("\137\x61\165\x74\150\x6f\x72\151\172\141\x74\151\157\156")) {
            goto r_QTj;
        }
        $IRAiV = $ukLSw->getProperty("\x5f\x61\x75\164\150\x6f\x72\151\x7a\141\164\x69\157\x6e");
        $IRAiV->setAccessible(true);
        $IRAiV->setValue($this->indexController, $this->authorization);
        r_QTj:
        if (!$ukLSw->hasProperty("\x72\145\163\165\154\x74\x52\x65\144\x69\162\145\x63\164\x46\141\x63\164\157\x72\x79")) {
            goto OfTth;
        }
        $UeAio = $ukLSw->getProperty("\162\145\x73\165\154\164\x52\145\144\151\162\145\143\164\106\141\143\x74\x6f\x72\x79");
        $UeAio->setAccessible(true);
        $UeAio->setValue($this->indexController, $this->resultRedirectFactory);
        OfTth:
        if (!$ukLSw->hasProperty("\162\x65\x73\x75\154\164\120\x61\x67\x65\x46\x61\143\x74\x6f\162\x79")) {
            goto MbkYk;
        }
        $lUQH4 = $ukLSw->getProperty("\162\145\163\165\154\x74\x50\x61\x67\145\106\x61\x63\x74\157\x72\171");
        $lUQH4->setAccessible(true);
        $lUQH4->setValue($this->indexController, $this->resultPageFactory);
        MbkYk:
    }
    public function testExecutePositiveSettingsSaved()
    {
        $pUIzs = ["\x6f\x70\x74\151\x6f\156" => "\x73\x61\x76\x65\x53\151\x67\156\x49\156\123\145\164\x74\151\156\147\x73\x5f\141\x64\x6d\151\156", "\x72\165\x6c\x65\x73" => json_encode([["\x72\x6f\x6c\x65" => "\101\144\155\x69\x6e", "\x6d\x65\x74\150\157\x64\x73" => ["\163\x6d\x73"]]])];
        $GbdJZ = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->indexController->method("\x67\145\164\122\145\x71\x75\x65\163\164")->willReturn($GbdJZ);
        $GbdJZ->method("\x67\x65\164\120\141\x72\x61\155\x73")->willReturn($pUIzs);
        $this->indexController->method("\151\x73\106\x6f\162\155\x4f\160\x74\x69\x6f\x6e\x42\145\x69\156\x67\123\x61\x76\x65\x64")->with($pUIzs)->willReturn(true);
        $MBh2r = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\164\x55\x73\x65\162\x6e\141\155\x65"])->getMock();
        $MBh2r->method("\x67\x65\164\x55\x73\145\162\156\x61\155\x65")->willReturn("\141\x64\x6d\151\156\x75\163\145\x72");
        $this->twofautility->method("\147\145\164\103\165\x72\x72\x65\x6e\164\x41\144\x6d\151\156\125\x73\145\x72")->willReturn($MBh2r);
        $gpN11 = $this->getMockBuilder(\Magento\Authorization\Model\ResourceModel\Role\Collection::class)->disableOriginalConstructor()->onlyMethods(["\x61\x64\x64\x46\151\x65\x6c\144\x54\157\x46\x69\x6c\x74\x65\x72", "\164\157\117\160\164\x69\157\156\101\x72\162\x61\x79"])->getMock();
        $gpN11->method("\141\x64\x64\106\x69\x65\x6c\144\x54\157\106\151\x6c\164\145\162")->willReturnSelf();
        $gpN11->method("\164\x6f\117\160\x74\x69\x6f\156\x41\162\x72\x61\171")->willReturn([["\x6c\x61\142\x65\x6c" => "\101\x64\x6d\x69\x6e"], ["\154\141\x62\x65\x6c" => "\115\141\x6e\141\x67\145\162"]]);
        $this->adminRoleModel->method("\x61\144\x64\106\151\145\154\x64\124\157\x46\x69\154\x74\145\x72")->willReturn($gpN11);
        $this->adminRoleModel->method("\x74\157\117\x70\x74\151\157\156\x41\x72\x72\141\171")->willReturn([["\x6c\x61\142\145\154" => "\101\144\155\151\156"], ["\x6c\x61\142\x65\x6c" => "\115\x61\156\x61\x67\145\x72"]]);
        $this->twofautility->expects($this->once())->method("\x69\x73\x43\x75\x73\x74\157\155\x65\162\x52\x65\147\151\163\x74\x65\162\145\144")->willReturn(true);
        $this->twofautility->expects($this->any())->method("\x73\x65\x74\x53\164\157\162\145\x43\x6f\156\x66\x69\x67")->willReturn(null);
        $this->twofautility->expects($this->once())->method("\x66\x6c\165\x73\x68\103\141\x63\150\x65")->willReturn(null);
        $this->twofautility->expects($this->once())->method("\x72\145\x69\x6e\x69\164\103\x6f\156\x66\x69\147")->willReturn(null);
        $this->messageManager->expects($this->once())->method("\x61\144\x64\x53\165\x63\x63\x65\163\163\115\x65\163\x73\141\x67\x65");
        $this->twofautility->expects($this->once())->method("\147\145\x74\101\x64\155\x69\x6e\125\162\154")->willReturn("\x72\x65\x64\x69\x72\x65\x63\x74\55\x75\162\x6c");
        $this->resultRedirectFactory->expects($this->any())->method("\x63\x72\x65\141\164\145")->willReturn($this->resultRedirect);
        $this->resultRedirect->expects($this->once())->method("\x73\145\164\125\x72\154")->with("\x72\145\144\x69\x72\x65\143\164\55\x75\162\154")->willReturnSelf();
        $this->resultPageFactory->expects($this->any())->method("\x63\162\x65\141\x74\145")->willReturn($this->resultPage);
        $c2gAU = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\164\124\151\164\154\145"])->getMock();
        $N6_il = $this->getMockBuilder(\stdClass::class)->addMethods(["\160\162\145\x70\x65\156\144"])->getMock();
        $this->resultPage->expects($this->any())->method("\147\145\164\103\157\156\x66\x69\147")->willReturn($c2gAU);
        $c2gAU->expects($this->any())->method("\147\145\164\124\x69\164\154\x65")->willReturn($N6_il);
        $N6_il->expects($this->any())->method("\160\162\x65\x70\145\x6e\144");
        $uqH8x = $this->indexController->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $uqH8x);
    }
    public function testExecuteFormNotSubmitted()
    {
        $pUIzs = [];
        $GbdJZ = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->indexController->method("\x67\x65\164\122\x65\161\x75\145\163\164")->willReturn($GbdJZ);
        $GbdJZ->method("\x67\145\164\120\141\162\141\155\x73")->willReturn($pUIzs);
        $this->indexController->method("\151\x73\106\157\x72\x6d\x4f\x70\x74\151\x6f\x6e\102\145\x69\x6e\147\123\x61\166\x65\144")->with($pUIzs)->willReturn(false);
        $MBh2r = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\x74\x55\x73\x65\162\156\141\155\145"])->getMock();
        $MBh2r->method("\147\145\164\125\163\145\x72\156\x61\155\145")->willReturn("\x61\x64\155\151\156\165\x73\x65\162");
        $this->twofautility->method("\x67\145\164\103\165\x72\x72\145\x6e\x74\101\x64\x6d\x69\x6e\x55\x73\145\x72")->willReturn($MBh2r);
        $this->resultPageFactory->expects($this->once())->method("\143\x72\x65\x61\x74\x65")->willReturn($this->resultPage);
        $c2gAU = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\x74\124\x69\x74\154\145"])->getMock();
        $N6_il = $this->getMockBuilder(\stdClass::class)->addMethods(["\160\162\145\160\145\156\x64"])->getMock();
        $this->resultPage->expects($this->once())->method("\147\145\164\103\x6f\156\146\x69\147")->willReturn($c2gAU);
        $c2gAU->expects($this->once())->method("\147\145\x74\124\x69\164\x6c\x65")->willReturn($N6_il);
        $N6_il->expects($this->once())->method("\x70\162\145\160\x65\x6e\144");
        $uqH8x = $this->indexController->execute();
        $this->assertSame($this->resultPage, $uqH8x);
    }
    public function testExecuteException()
    {
        $pUIzs = ["\157\x70\x74\x69\x6f\156" => "\x73\x61\x76\x65\x53\151\x67\x6e\111\x6e\x53\145\x74\164\151\156\147\x73\x5f\141\144\x6d\x69\x6e", "\x72\x75\154\x65\163" => "\151\156\166\x61\154\x69\144\55\152\x73\157\156"];
        $GbdJZ = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->indexController->method("\147\145\164\122\145\161\165\145\x73\164")->willReturn($GbdJZ);
        $GbdJZ->method("\x67\145\164\x50\x61\x72\x61\x6d\163")->willReturn($pUIzs);
        $this->indexController->method("\x69\x73\x46\157\162\x6d\x4f\160\164\151\157\156\x42\145\151\x6e\x67\123\x61\x76\x65\x64")->with($pUIzs)->willReturn(true);
        $MBh2r = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\164\x55\x73\x65\162\x6e\x61\155\x65"])->getMock();
        $MBh2r->method("\x67\x65\164\125\x73\145\162\156\x61\155\145")->willReturn("\x61\x64\155\151\x6e\x75\163\145\162");
        $this->twofautility->method("\x67\145\x74\103\165\162\162\145\x6e\x74\101\144\x6d\x69\x6e\x55\x73\145\162")->willReturn($MBh2r);
        $this->twofautility->method("\x69\x73\x43\x75\163\x74\157\155\x65\162\122\x65\x67\x69\x73\164\x65\x72\x65\x64")->willReturn(true);
        $this->twofautility->method("\x73\x65\164\123\164\157\162\145\103\x6f\156\146\151\x67")->willThrowException(new \Exception("\146\x61\151\154\41"));
        $this->messageManager->expects($this->once())->method("\x61\x64\144\x45\162\162\x6f\162\115\145\x73\163\x61\147\x65");
        $this->logger->expects($this->once())->method("\x64\145\x62\x75\x67");
        $this->resultPageFactory->expects($this->any())->method("\143\162\145\141\x74\x65")->willReturn($this->resultPage);
        $c2gAU = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\164\x54\x69\164\x6c\x65"])->getMock();
        $N6_il = $this->getMockBuilder(\stdClass::class)->addMethods(["\160\x72\145\x70\145\x6e\x64"])->getMock();
        $this->resultPage->expects($this->any())->method("\x67\145\164\x43\157\156\146\151\x67")->willReturn($c2gAU);
        $c2gAU->expects($this->any())->method("\x67\145\164\124\151\x74\x6c\x65")->willReturn($N6_il);
        $N6_il->expects($this->any())->method("\x70\162\x65\160\x65\x6e\144");
        $uqH8x = $this->indexController->execute();
        $this->assertSame($this->resultPage, $uqH8x);
    }
}