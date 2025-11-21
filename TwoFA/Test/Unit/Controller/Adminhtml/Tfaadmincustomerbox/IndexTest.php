<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Adminhtml\Tfaadmincustomerbox;

use MiniOrange\TwoFA\Controller\Adminhtml\Tfaadmincustomerbox\Index;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
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
    private $indexController;
    private $request;
    protected function setUp() : void
    {
        $this->context = $this->createMock(\Magento\Backend\App\Action\Context::class);
        $this->twofautility = $this->createMock(\MiniOrange\TwoFA\Helper\TwoFAUtility::class);
        $this->resultPageFactory = $this->createMock(\Magento\Framework\View\Result\PageFactory::class);
        $this->messageManager = $this->createMock(\Magento\Framework\Message\ManagerInterface::class);
        $this->logger = $this->createMock(\Psr\Log\LoggerInterface::class);
        $this->adminRoleModel = $this->createMock(\Magento\Authorization\Model\ResourceModel\Role\Collection::class);
        $this->resultRedirectFactory = $this->createMock(\Magento\Framework\Controller\Result\RedirectFactory::class);
        $this->resultRedirect = $this->getMockBuilder(\stdClass::class)->addMethods(["\x73\145\x74\x50\x61\164\x68"])->getMock();
        $this->authorization = $this->createMock(\Magento\Framework\AuthorizationInterface::class);
        $this->request = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->context->method("\147\145\164\122\145\x71\x75\x65\163\x74")->willReturn($this->request);
        $this->context->method("\x67\145\x74\115\x65\163\163\141\147\145\115\x61\156\x61\147\145\x72")->willReturn($this->messageManager);
        $this->indexController = new Index($this->context, $this->twofautility, $this->resultPageFactory, $this->messageManager, $this->logger, $this->adminRoleModel);
        $yrNVl = new ReflectionClass($this->indexController);
        foreach (["\x72\x65\x73\x75\x6c\x74\122\145\x64\x69\x72\145\x63\x74\106\141\143\x74\157\162\171" => $this->resultRedirectFactory, "\x5f\x61\x75\164\x68\157\162\151\x7a\x61\x74\x69\x6f\156" => $this->authorization, "\x6c\157\147\x67\145\x72" => $this->logger] as $Su16p => $LUaLU) {
            if (!$yrNVl->hasProperty($Su16p)) {
                goto DG2OT;
            }
            $VBQDu = $yrNVl->getProperty($Su16p);
            $VBQDu->setAccessible(true);
            $VBQDu->setValue($this->indexController, $LUaLU);
            DG2OT:
            mh9UB:
        }
        n4jVi:
    }
    public function testExecutePositiveFlowSettingsSaved()
    {
        $tPVLl = ["\157\x70\x74\x69\157\x6e" => "\x73\x61\x76\x65\123\151\147\156\111\156\x53\x65\164\164\x69\156\147\163\x5f\141\x64\x6d\151\x6e", "\x72\165\154\x65\x73" => json_encode([["\162\157\154\x65" => "\101\144\x6d\151\x6e", "\x6d\145\164\150\157\144\x73" => ["\x6d\x31", "\x6d\x32"]]])];
        $this->request->method("\x67\145\x74\x50\141\162\x61\x6d\x73")->willReturn($tPVLl);
        $this->twofautility->method("\151\163\103\x75\163\x74\157\x6d\145\x72\122\145\x67\151\x73\164\145\x72\145\x64")->willReturn(true);
        $this->adminRoleModel->method("\x61\x64\144\106\x69\145\x6c\x64\124\157\x46\x69\x6c\x74\145\x72")->willReturnSelf();
        $this->adminRoleModel->method("\x74\x6f\x4f\160\164\x69\157\156\101\x72\x72\x61\x79")->willReturn([["\x6c\141\142\145\x6c" => "\101\144\x6d\x69\156"], ["\x6c\x61\142\145\x6c" => "\115\x61\156\141\x67\145\162"]]);
        $this->resultPageFactory->method("\x63\162\145\141\x74\145")->willReturn($this->getMockResultPage());
        $b9cQA = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\164\125\x73\x65\162\156\x61\155\x65"])->getMock();
        $b9cQA->method("\147\145\164\x55\163\x65\162\156\x61\155\145")->willReturn("\x61\x64\155\151\156\165\x73\145\162");
        $this->twofautility->method("\147\145\x74\x43\x75\x72\162\145\156\x74\x41\144\155\151\156\x55\163\x65\x72")->willReturn($b9cQA);
        $jcd13 = $this->getMockBuilder(Index::class)->setConstructorArgs([$this->context, $this->twofautility, $this->resultPageFactory, $this->messageManager, $this->logger, $this->adminRoleModel])->onlyMethods(["\151\x73\106\x6f\x72\155\x4f\x70\164\151\x6f\156\102\x65\151\x6e\147\x53\x61\x76\x65\x64"])->getMock();
        $jcd13->method("\x69\163\106\x6f\x72\155\117\160\164\151\157\x6e\102\x65\151\156\x67\x53\141\166\145\144")->willReturn(true);
        $yrNVl = new \ReflectionClass($jcd13);
        foreach (["\162\x65\x73\x75\x6c\x74\122\145\144\151\162\145\x63\164\106\141\143\164\x6f\162\x79" => $this->resultRedirectFactory, "\x5f\141\165\x74\150\157\x72\151\x7a\141\x74\x69\x6f\x6e" => $this->authorization, "\154\x6f\x67\147\145\162" => $this->logger] as $Su16p => $LUaLU) {
            if (!$yrNVl->hasProperty($Su16p)) {
                goto wa4lq;
            }
            $VBQDu = $yrNVl->getProperty($Su16p);
            $VBQDu->setAccessible(true);
            $VBQDu->setValue($jcd13, $LUaLU);
            wa4lq:
            wAdl8:
        }
        UawnQ:
        $this->messageManager->expects($this->once())->method("\141\x64\144\123\x75\x63\x63\145\x73\163\115\x65\x73\x73\x61\147\145");
        $Bq6Jw = $jcd13->execute();
        $this->assertInstanceOf(\Magento\Framework\View\Result\Page::class, $Bq6Jw);
    }
    public function testExecuteNotRegisteredShowsError()
    {
        $tPVLl = ["\x6f\160\x74\x69\x6f\x6e" => "\x73\141\x76\145\123\151\x67\156\111\x6e\x53\x65\164\x74\x69\156\x67\163\x5f\141\x64\x6d\151\156", "\x72\165\154\x65\x73" => json_encode([["\162\x6f\154\x65" => "\x41\144\x6d\x69\x6e", "\155\145\164\150\x6f\144\163" => ["\x6d\61", "\155\x32"]]])];
        $this->request->method("\x67\145\x74\120\x61\x72\x61\x6d\163")->willReturn($tPVLl);
        $this->twofautility->method("\x69\x73\103\165\163\x74\x6f\x6d\x65\x72\122\145\x67\151\x73\x74\145\x72\x65\144")->willReturn(false);
        $this->resultRedirectFactory->method("\x63\162\145\141\164\145")->willReturn($this->resultRedirect);
        $this->resultRedirect->method("\x73\x65\164\x50\x61\164\x68")->with("\x6d\x6f\x74\x77\x6f\x66\x61\x2f\141\143\143\157\165\x6e\x74\x2f\x69\156\x64\145\170")->willReturnSelf();
        $this->messageManager->method("\141\144\x64\x45\162\x72\x6f\162\x4d\145\163\163\x61\x67\145");
        $this->resultPageFactory->method("\x63\x72\145\x61\164\145")->willReturn($this->getMockResultPage());
        $b9cQA = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\164\125\x73\x65\x72\x6e\x61\155\x65"])->getMock();
        $b9cQA->method("\x67\145\164\125\x73\145\x72\x6e\141\155\145")->willReturn("\x61\144\x6d\151\156\165\x73\145\162");
        $this->twofautility->method("\147\x65\x74\x43\x75\x72\x72\145\156\164\x41\144\155\151\x6e\125\x73\145\162")->willReturn($b9cQA);
        $jcd13 = $this->getMockBuilder(Index::class)->setConstructorArgs([$this->context, $this->twofautility, $this->resultPageFactory, $this->messageManager, $this->logger, $this->adminRoleModel])->onlyMethods(["\x69\163\106\157\x72\x6d\117\160\x74\x69\157\x6e\102\145\151\156\x67\x53\x61\x76\x65\x64"])->getMock();
        $jcd13->method("\151\x73\106\x6f\x72\x6d\x4f\x70\164\x69\x6f\156\102\x65\x69\x6e\x67\x53\x61\x76\x65\144")->willReturn(true);
        $yrNVl = new \ReflectionClass($jcd13);
        foreach (["\x72\x65\x73\x75\x6c\164\122\145\144\151\162\x65\x63\164\106\141\x63\x74\x6f\162\x79" => $this->resultRedirectFactory, "\x5f\x61\x75\x74\x68\157\162\151\172\141\x74\151\157\156" => $this->authorization, "\x6c\x6f\x67\x67\145\162" => $this->logger] as $Su16p => $LUaLU) {
            if (!$yrNVl->hasProperty($Su16p)) {
                goto CnFUe;
            }
            $VBQDu = $yrNVl->getProperty($Su16p);
            $VBQDu->setAccessible(true);
            $VBQDu->setValue($jcd13, $LUaLU);
            CnFUe:
            ChQxe:
        }
        qIGsx:
        $Bq6Jw = $jcd13->execute();
        $this->assertTrue($Bq6Jw === $this->resultRedirect || $Bq6Jw instanceof \Magento\Framework\View\Result\Page, "\122\x65\163\165\154\164\x20\163\150\157\165\x6c\x64\40\x62\145\x20\141\x20\162\x65\144\x69\x72\x65\x63\x74\40\x6f\162\x20\x61\40\160\141\x67\145\40\162\x65\163\x75\x6c\x74");
    }
    public function testExecuteExceptionThrown()
    {
        $this->request->method("\x67\x65\x74\120\x61\162\141\155\x73")->willThrowException(new \Exception("\146\141\151\x6c"));
        $this->messageManager->expects($this->once())->method("\141\x64\x64\105\x72\162\157\162\115\145\x73\163\x61\x67\145");
        $this->logger->expects($this->once())->method("\144\145\x62\x75\147");
        $this->resultPageFactory->method("\x63\162\x65\x61\x74\x65")->willReturn($this->getMockResultPage());
        $Bq6Jw = $this->indexController->execute();
        $this->assertInstanceOf(\Magento\Framework\View\Result\Page::class, $Bq6Jw);
    }
    public function testProcessSignInSettingsInvalidJsonThrows()
    {
        $tPVLl = ["\x6f\x70\x74\151\x6f\156" => "\163\141\166\145\x53\151\147\x6e\x49\156\x53\145\x74\x74\151\x6e\147\x73\137\141\144\x6d\x69\x6e", "\x72\165\x6c\x65\x73" => "\173\x69\156\x76\141\x6c\151\x64\x20\x6a\163\x6f\x6e\x7d"];
        $this->twofautility->method("\151\163\103\165\163\164\x6f\155\x65\162\x52\145\147\x69\x73\164\145\162\x65\x64")->willReturn(true);
        $this->expectException(\Exception::class);
        $yrNVl = new \ReflectionMethod($this->indexController, "\x70\162\157\x63\145\163\x73\123\151\147\156\x49\156\x53\x65\164\164\x69\x6e\147\163");
        $yrNVl->setAccessible(true);
        $yrNVl->invoke($this->indexController, $tPVLl);
    }
    public function testProcessSignInSettingsDeleteRole()
    {
        $tPVLl = ["\x6f\160\x74\x69\157\x6e" => "\163\x61\x76\x65\123\x69\147\x6e\x49\156\123\x65\164\x74\x69\156\147\x73\x5f\x61\144\x6d\x69\x6e", "\162\x75\x6c\145\163" => json_encode([["\x72\157\x6c\x65" => "\x41\144\x6d\x69\x6e", "\155\x65\x74\150\157\144\163" => ["\x6d\x31", "\155\62"]]]), "\144\x65\x6c\145\x74\x65\137\162\x6f\154\x65" => "\x41\x64\155\x69\x6e"];
        $this->twofautility->method("\x69\163\103\165\163\x74\x6f\x6d\x65\x72\x52\145\x67\151\163\x74\145\162\145\144")->willReturn(true);
        $this->adminRoleModel->method("\x61\x64\x64\x46\x69\145\154\144\124\x6f\106\x69\154\164\145\162")->willReturnSelf();
        $this->adminRoleModel->method("\x74\x6f\x4f\x70\164\x69\157\x6e\101\x72\x72\x61\171")->willReturn([["\154\141\142\x65\154" => "\x41\x64\x6d\151\x6e"], ["\154\x61\142\x65\x6c" => "\115\x61\x6e\141\147\145\x72"]]);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\145\164\x53\164\x6f\x72\x65\x43\x6f\156\146\x69\x67");
        $yrNVl = new \ReflectionMethod($this->indexController, "\x70\162\x6f\143\x65\163\x73\123\x69\147\156\111\156\x53\145\x74\x74\x69\156\x67\x73");
        $yrNVl->setAccessible(true);
        $yrNVl->invoke($this->indexController, $tPVLl);
    }
    public function testProcessRoleDeletionAllRoles()
    {
        $tPVLl = ["\x64\x65\x6c\145\x74\x65\x5f\162\x6f\x6c\145" => "\101\x6c\x6c\x20\122\157\x6c\x65\x73"];
        $this->adminRoleModel->method("\x61\x64\x64\106\x69\145\x6c\144\124\157\106\151\x6c\x74\x65\x72")->willReturnSelf();
        $this->adminRoleModel->method("\164\x6f\117\x70\164\x69\157\156\101\x72\162\141\x79")->willReturn([["\154\x61\x62\x65\x6c" => "\101\x64\x6d\151\156"], ["\154\x61\x62\x65\154" => "\x4d\x61\156\141\x67\145\162"]]);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\x65\x74\x53\164\157\x72\x65\103\x6f\x6e\x66\151\x67");
        $yrNVl = new \ReflectionMethod($this->indexController, "\160\162\x6f\143\145\x73\163\122\x6f\x6c\x65\x44\145\x6c\145\x74\x69\157\x6e");
        $yrNVl->setAccessible(true);
        $yrNVl->invoke($this->indexController, $tPVLl);
    }
    public function testProcessRoleDeletionSingleRole()
    {
        $tPVLl = ["\x64\x65\x6c\145\x74\x65\137\x72\x6f\154\x65" => "\x41\144\155\x69\x6e"];
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\145\164\x53\x74\x6f\162\x65\x43\157\156\x66\x69\147");
        $yrNVl = new \ReflectionMethod($this->indexController, "\x70\162\157\143\x65\163\x73\x52\x6f\154\145\104\x65\x6c\x65\164\151\157\156");
        $yrNVl->setAccessible(true);
        $yrNVl->invoke($this->indexController, $tPVLl);
    }
    public function testGetAllAdminRolesReturnsRoles()
    {
        $this->adminRoleModel->method("\141\x64\x64\x46\x69\145\x6c\x64\x54\x6f\106\x69\154\x74\x65\x72")->willReturnSelf();
        $this->adminRoleModel->method("\164\x6f\117\x70\164\x69\157\x6e\101\x72\162\141\171")->willReturn([["\154\x61\142\x65\154" => "\x41\x64\155\151\x6e"], ["\154\x61\x62\x65\x6c" => "\x4d\x61\x6e\141\147\x65\162"]]);
        $yrNVl = new \ReflectionMethod($this->indexController, "\x67\145\164\101\x6c\154\101\144\x6d\151\x6e\x52\157\x6c\145\x73");
        $yrNVl->setAccessible(true);
        $Bq6Jw = $yrNVl->invoke($this->indexController);
        $this->assertEquals([["\x6c\141\142\145\x6c" => "\x41\144\155\151\x6e"], ["\154\141\142\x65\154" => "\115\141\x6e\141\x67\145\x72"]], $Bq6Jw);
    }
    public function testDeleteRoleMethodsConfigCallsSetStoreConfig()
    {
        $this->twofautility->expects($this->exactly(2))->method("\x73\x65\164\123\x74\157\162\x65\103\x6f\x6e\146\x69\x67");
        $yrNVl = new \ReflectionMethod($this->indexController, "\144\145\154\145\164\145\x52\157\x6c\145\x4d\x65\x74\x68\157\x64\x73\x43\x6f\156\x66\x69\147");
        $yrNVl->setAccessible(true);
        $yrNVl->invoke($this->indexController, "\101\144\155\151\x6e");
    }
    public function testApplyRulesToRolesAllRoles()
    {
        $u85fQ = [["\x72\157\154\145" => "\x41\x6c\154\x20\122\x6f\154\145\x73", "\x6d\x65\164\150\157\x64\163" => ["\155\x31", "\x6d\x32"]]];
        $this->adminRoleModel->method("\141\144\x64\x46\x69\145\x6c\x64\124\157\x46\x69\x6c\164\x65\x72")->willReturnSelf();
        $this->adminRoleModel->method("\x74\157\x4f\160\x74\x69\157\156\101\162\162\x61\x79")->willReturn([["\154\141\142\145\x6c" => "\101\x64\155\x69\156"], ["\154\x61\142\145\154" => "\x4d\141\156\141\147\x65\162"]]);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\145\x74\x53\x74\x6f\162\x65\x43\x6f\x6e\x66\x69\147");
        $yrNVl = new \ReflectionMethod($this->indexController, "\141\x70\x70\x6c\x79\122\x75\154\145\x73\124\157\x52\157\x6c\x65\163");
        $yrNVl->setAccessible(true);
        $yrNVl->invoke($this->indexController, $u85fQ);
    }
    public function testApplyRulesToRolesSingleRole()
    {
        $u85fQ = [["\x72\157\x6c\x65" => "\101\x64\155\151\156", "\x6d\x65\x74\x68\157\x64\163" => ["\x6d\61", "\x6d\62"]]];
        $this->adminRoleModel->method("\141\144\x64\x46\x69\145\x6c\x64\124\157\106\151\154\x74\x65\x72")->willReturnSelf();
        $this->adminRoleModel->method("\x74\x6f\117\x70\x74\x69\x6f\156\101\162\162\141\x79")->willReturn([["\x6c\x61\142\145\x6c" => "\x41\x64\x6d\x69\x6e"], ["\x6c\141\x62\145\154" => "\x4d\141\x6e\141\x67\x65\x72"]]);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\x65\164\x53\164\157\x72\145\103\157\156\146\x69\x67");
        $yrNVl = new \ReflectionMethod($this->indexController, "\x61\x70\160\x6c\x79\x52\165\x6c\145\x73\124\157\122\157\154\x65\x73");
        $yrNVl->setAccessible(true);
        $yrNVl->invoke($this->indexController, $u85fQ);
    }
    public function testSaveMethodsConfigCallsSetStoreConfig()
    {
        $this->twofautility->expects($this->exactly(2))->method("\x73\145\x74\x53\x74\157\x72\x65\103\157\156\146\151\147");
        $yrNVl = new \ReflectionMethod($this->indexController, "\163\x61\x76\145\115\145\x74\x68\157\x64\x73\x43\x6f\156\x66\151\147");
        $yrNVl->setAccessible(true);
        $yrNVl->invoke($this->indexController, "\101\x64\155\x69\x6e", ["\x6d\x31", "\x6d\62"]);
    }
    public function testIsAllowedReturnsTrue()
    {
        $this->authorization->method("\x69\163\101\x6c\154\x6f\167\x65\144")->willReturn(true);
        $yrNVl = new \ReflectionMethod($this->indexController, "\x5f\151\x73\101\154\154\x6f\x77\145\x64");
        $yrNVl->setAccessible(true);
        $this->assertTrue($yrNVl->invoke($this->indexController));
    }
    public function testIsAllowedReturnsFalse()
    {
        $this->authorization->method("\x69\x73\x41\154\154\x6f\167\x65\144")->willReturn(false);
        $yrNVl = new \ReflectionMethod($this->indexController, "\x5f\x69\163\101\154\x6c\157\167\x65\144");
        $yrNVl->setAccessible(true);
        $this->assertFalse($yrNVl->invoke($this->indexController));
    }
    private function getMockResultPage()
    {
        $dtwcQ = $this->getMockBuilder(\stdClass::class)->addMethods(["\x70\x72\x65\160\145\x6e\x64"])->getMock();
        $dtwcQ->method("\160\162\145\160\x65\156\144")->willReturnSelf();
        $nUyZu = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\164\x54\151\164\154\x65"])->getMock();
        $nUyZu->method("\x67\145\x74\124\151\164\154\145")->willReturn($dtwcQ);
        $GABNs = $this->createMock(\Magento\Framework\View\Result\Page::class);
        $GABNs->method("\x67\145\164\103\157\x6e\x66\x69\x67")->willReturn($nUyZu);
        return $GABNs;
    }
}