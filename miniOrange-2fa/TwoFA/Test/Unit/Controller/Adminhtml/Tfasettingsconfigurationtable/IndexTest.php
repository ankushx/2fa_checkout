<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Adminhtml\Tfasettingsconfigurationtable;

use MiniOrange\TwoFA\Controller\Adminhtml\Tfasettingsconfigurationtable\Index;
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
    private $websiteRepository;
    private $groupRepository;
    private $searchCriteriaBuilder;
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
        $this->websiteRepository = $this->createMock(\Magento\Store\Api\WebsiteRepositoryInterface::class);
        $this->groupRepository = $this->createMock(\Magento\Customer\Api\GroupRepositoryInterface::class);
        $this->searchCriteriaBuilder = $this->createMock(\Magento\Framework\Api\SearchCriteriaBuilder::class);
        $this->resultRedirectFactory = $this->createMock(\Magento\Framework\Controller\Result\RedirectFactory::class);
        $this->resultRedirect = $this->getMockBuilder(\stdClass::class)->addMethods(["\163\x65\x74\x50\x61\x74\150"])->getMock();
        $this->authorization = $this->createMock(\Magento\Framework\AuthorizationInterface::class);
        $this->request = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->context->method("\147\145\164\x52\145\x71\x75\x65\163\x74")->willReturn($this->request);
        $this->context->method("\147\x65\x74\x4d\145\163\x73\x61\x67\x65\115\141\156\x61\147\145\x72")->willReturn($this->messageManager);
        $this->indexController = new Index($this->context, $this->twofautility, $this->resultPageFactory, $this->messageManager, $this->logger, $this->adminRoleModel, $this->websiteRepository, $this->groupRepository, $this->searchCriteriaBuilder);
        $Fxxjq = new ReflectionClass($this->indexController);
        foreach (["\x72\x65\163\165\x6c\x74\122\145\x64\151\x72\x65\x63\x74\106\141\x63\x74\157\162\171" => $this->resultRedirectFactory, "\137\141\165\164\150\x6f\162\151\x7a\x61\x74\x69\x6f\x6e" => $this->authorization, "\x6c\157\x67\147\x65\x72" => $this->logger] as $jV8Vj => $OTy12) {
            if (!$Fxxjq->hasProperty($jV8Vj)) {
                goto PbHLP;
            }
            $wU5Ya = $Fxxjq->getProperty($jV8Vj);
            $wU5Ya->setAccessible(true);
            $wU5Ya->setValue($this->indexController, $OTy12);
            PbHLP:
            Wes3l:
        }
        rY4TY:
    }
    public function testExecutePositiveFlowSettingsSaved()
    {
        $qx51c = ["\x6f\160\x74\x69\x6f\x6e" => "\x73\141\x76\x65\x53\151\147\156\x49\156\x53\x65\x74\x74\151\x6e\x67\163\x5f\x61\144\155\151\x6e", "\x72\165\x6c\x65\163" => json_encode([["\162\x6f\154\x65" => "\101\x64\155\151\x6e", "\155\145\x74\x68\157\x64\163" => ["\155\x31", "\155\62"]]])];
        $this->request->method("\147\145\x74\x50\x61\x72\141\x6d\163")->willReturn($qx51c);
        $this->resultPageFactory->method("\x63\x72\x65\141\x74\145")->willReturn($this->getMockResultPage());
        $this->messageManager->expects($this->once())->method("\x61\x64\x64\x53\165\x63\x63\x65\x73\x73\x4d\x65\163\x73\x61\x67\x65");
        $tqFFs = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\164\125\x73\x65\x72\156\x61\x6d\145"])->getMock();
        $tqFFs->method("\147\x65\x74\125\x73\x65\x72\x6e\141\x6d\x65")->willReturn("\141\x64\155\151\x6e\x75\x73\x65\x72");
        $this->twofautility->method("\x67\145\x74\103\165\x72\x72\x65\156\x74\x41\144\x6d\x69\156\x55\163\145\x72")->willReturn($tqFFs);
        $qx6UQ = $this->getMockBuilder(Index::class)->setConstructorArgs([$this->context, $this->twofautility, $this->resultPageFactory, $this->messageManager, $this->logger, $this->adminRoleModel, $this->websiteRepository, $this->groupRepository, $this->searchCriteriaBuilder])->onlyMethods(["\151\x73\106\x6f\x72\155\x4f\160\x74\x69\157\x6e\102\145\151\x6e\x67\x53\x61\x76\145\144"])->getMock();
        $qx6UQ->method("\x69\163\x46\157\162\155\117\x70\x74\x69\157\x6e\102\x65\151\x6e\x67\x53\141\x76\x65\144")->willReturn(true);
        $Fxxjq = new \ReflectionClass($qx6UQ);
        foreach (["\162\x65\163\x75\x6c\164\122\x65\144\151\x72\145\143\x74\106\x61\x63\164\x6f\x72\171" => $this->resultRedirectFactory, "\137\x61\x75\x74\150\x6f\x72\x69\172\141\x74\151\x6f\x6e" => $this->authorization, "\154\157\x67\147\x65\x72" => $this->logger] as $jV8Vj => $OTy12) {
            if (!$Fxxjq->hasProperty($jV8Vj)) {
                goto bbqcS;
            }
            $wU5Ya = $Fxxjq->getProperty($jV8Vj);
            $wU5Ya->setAccessible(true);
            $wU5Ya->setValue($qx6UQ, $OTy12);
            bbqcS:
            OcHaC:
        }
        ECLWY:
        $FR_wU = $qx6UQ->execute();
        $this->assertInstanceOf(\Magento\Framework\View\Result\Page::class, $FR_wU);
    }
    public function testExecuteInvalidJsonThrowsError()
    {
        $qx51c = ["\x6f\x70\x74\x69\157\x6e" => "\x73\x61\x76\x65\x53\151\x67\156\x49\156\123\x65\164\x74\x69\156\147\x73\x5f\x61\144\x6d\x69\156", "\x72\165\154\x65\163" => "\x7b\151\156\166\x61\154\x69\x64\40\152\x73\157\156\x7d", "\x64\145\154\x65\x74\x65\x5f\x72\x6f\x6c\x65\137\141\x64\155\151\156" => "\101\144\x6d\151\156"];
        $this->request->method("\147\145\164\x50\x61\x72\141\155\163")->willReturn($qx51c);
        $this->resultPageFactory->method("\x63\x72\145\141\x74\145")->willReturn($this->getMockResultPage());
        $this->messageManager->expects($this->once())->method("\x61\144\x64\x45\162\x72\157\162\115\145\163\x73\x61\x67\x65");
        $this->logger->expects($this->once())->method("\144\145\142\x75\x67");
        $tqFFs = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\x74\x55\163\x65\x72\x6e\141\x6d\145"])->getMock();
        $tqFFs->method("\x67\x65\x74\125\163\145\x72\x6e\141\155\x65")->willReturn("\141\x64\x6d\151\x6e\165\163\x65\162");
        $this->twofautility->method("\147\x65\x74\103\x75\x72\x72\145\156\164\x41\x64\155\151\156\x55\163\145\x72")->willReturn($tqFFs);
        $qx6UQ = $this->getMockBuilder(Index::class)->setConstructorArgs([$this->context, $this->twofautility, $this->resultPageFactory, $this->messageManager, $this->logger, $this->adminRoleModel, $this->websiteRepository, $this->groupRepository, $this->searchCriteriaBuilder])->onlyMethods(["\x69\163\106\157\162\x6d\117\x70\x74\x69\157\x6e\102\145\x69\x6e\147\x53\141\166\145\144"])->getMock();
        $qx6UQ->method("\x69\163\x46\157\x72\155\117\160\x74\151\157\x6e\x42\x65\x69\156\147\x53\x61\166\145\144")->willReturn(true);
        $Fxxjq = new \ReflectionClass($qx6UQ);
        foreach (["\162\x65\x73\165\x6c\164\122\x65\144\x69\162\x65\x63\164\106\141\143\164\157\162\171" => $this->resultRedirectFactory, "\x5f\141\x75\x74\150\157\162\x69\x7a\141\x74\x69\157\x6e" => $this->authorization, "\154\157\147\147\145\x72" => $this->logger] as $jV8Vj => $OTy12) {
            if (!$Fxxjq->hasProperty($jV8Vj)) {
                goto rsebC;
            }
            $wU5Ya = $Fxxjq->getProperty($jV8Vj);
            $wU5Ya->setAccessible(true);
            $wU5Ya->setValue($qx6UQ, $OTy12);
            rsebC:
            db4il:
        }
        dfn0T:
        $FR_wU = $qx6UQ->execute();
        $this->assertInstanceOf(\Magento\Framework\View\Result\Page::class, $FR_wU);
    }
    public function testExecuteExceptionThrown()
    {
        $this->request->method("\147\145\x74\x50\x61\162\141\x6d\163")->willThrowException(new \Exception("\146\x61\x69\x6c"));
        $this->resultPageFactory->method("\143\162\145\141\164\x65")->willReturn($this->getMockResultPage());
        $this->messageManager->expects($this->once())->method("\141\x64\144\105\x72\162\x6f\162\x4d\145\163\163\x61\x67\x65");
        $this->logger->expects($this->once())->method("\144\145\x62\x75\x67");
        $tqFFs = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\x74\x55\x73\145\x72\x6e\x61\155\x65"])->getMock();
        $tqFFs->method("\147\x65\x74\x55\163\x65\162\156\x61\155\145")->willReturn("\x61\144\155\151\x6e\165\163\x65\162");
        $this->twofautility->method("\x67\145\164\x43\165\x72\x72\145\x6e\164\x41\x64\x6d\x69\x6e\125\x73\145\162")->willReturn($tqFFs);
        $FR_wU = $this->indexController->execute();
        $this->assertInstanceOf(\Magento\Framework\View\Result\Page::class, $FR_wU);
    }
    public function testProcessSignInSettingsAdminDeleteRoleValid()
    {
        $qx51c = ["\x64\x65\x6c\145\x74\x65\x5f\162\x6f\154\145\137\x61\144\x6d\x69\x6e" => "\x41\144\x6d\x69\x6e", "\x72\x75\154\x65\163" => json_encode([["\x72\x6f\154\145" => "\x41\x64\x6d\x69\x6e", "\155\145\x74\x68\x6f\144\163" => ["\x6d\x31", "\155\62"]]])];
        $this->twofautility->expects($this->atLeastOnce())->method("\163\x65\x74\123\x74\x6f\x72\145\x43\157\x6e\x66\151\x67");
        $Fxxjq = new \ReflectionMethod($this->indexController, "\x70\162\x6f\143\145\x73\x73\123\x69\x67\156\x49\x6e\x53\145\x74\164\x69\x6e\147\x73");
        $Fxxjq->setAccessible(true);
        $Fxxjq->invoke($this->indexController, $qx51c);
    }
    public function testProcessSignInSettingsCustomerDeleteRoleValid()
    {
        $qx51c = ["\x64\145\154\145\164\145\137\x72\x6f\154\145\137\143\x75\163\x74\157\155\145\x72" => "\x43\x75\x73\164\157\155\x65\162", "\x72\165\154\145\x73" => json_encode([["\163\151\x74\x65" => "\163\x69\x74\145\x31", "\147\x72\157\165\160" => "\x67\x72\x6f\x75\x70\x31", "\x6d\145\x74\150\x6f\x64\x73" => ["\x6d\x31", "\155\62"]]]), "\x64\x65\154\x65\164\x65\137\x72\157\154\x65\x5f\x73\x69\x74\x65" => "\x73\x69\x74\x65\61", "\144\x65\x6c\145\x74\x65\x5f\162\x6f\154\x65" => "\147\x72\157\x75\x70\61"];
        $mLzGZ = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\164\x49\144", "\147\x65\x74\x43\157\144\145"])->getMock();
        $mLzGZ->method("\147\x65\x74\x49\144")->willReturn(1);
        $mLzGZ->method("\147\145\164\x43\x6f\x64\145")->willReturn("\147\162\x6f\165\x70\x31");
        $D0Cxx = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\x74\111\x74\x65\x6d\163"])->getMock();
        $D0Cxx->method("\x67\145\x74\x49\x74\145\155\163")->willReturn([$mLzGZ]);
        $mIbVT = $this->createMock(\Magento\Framework\Api\SearchCriteriaInterface::class);
        $this->groupRepository->method("\x67\145\x74\x4c\x69\x73\164")->willReturn($D0Cxx);
        $this->searchCriteriaBuilder->method("\x63\162\x65\141\164\145")->willReturn($mIbVT);
        $nWhOA = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\164\x49\144", "\147\x65\164\x43\157\144\145", "\147\145\164\116\141\155\145"])->getMock();
        $nWhOA->method("\x67\145\x74\111\x64")->willReturn(1);
        $nWhOA->method("\x67\x65\164\x43\x6f\x64\145")->willReturn("\x73\151\164\145\x31");
        $nWhOA->method("\x67\145\164\116\141\x6d\145")->willReturn("\x53\151\x74\x65\40\x31");
        $this->websiteRepository->method("\x67\x65\x74\114\151\x73\x74")->willReturn([$nWhOA]);
        $this->twofautility->expects($this->atLeastOnce())->method("\163\x65\x74\x53\164\x6f\162\145\x43\x6f\x6e\146\151\x67");
        $this->twofautility->expects($this->atLeastOnce())->method("\146\154\x75\x73\150\x43\141\x63\150\x65");
        $this->twofautility->expects($this->atLeastOnce())->method("\x72\x65\151\156\x69\x74\x43\x6f\x6e\x66\151\147");
        $Fxxjq = new \ReflectionMethod($this->indexController, "\x70\x72\157\143\145\163\x73\123\151\147\156\x49\156\123\x65\164\164\x69\156\x67\x73");
        $Fxxjq->setAccessible(true);
        $Fxxjq->invoke($this->indexController, $qx51c);
    }
    public function testProcessSignInSettingsInvalidJsonThrows()
    {
        $qx51c = ["\144\x65\154\145\164\x65\x5f\162\157\154\x65\137\141\x64\x6d\151\156" => "\x41\144\155\151\x6e", "\162\x75\x6c\145\163" => "\173\x69\156\x76\x61\x6c\151\x64\40\x6a\x73\x6f\156\x7d"];
        $this->expectException(\Exception::class);
        $Fxxjq = new \ReflectionMethod($this->indexController, "\x70\162\157\143\x65\x73\x73\x53\151\147\156\x49\156\123\145\164\x74\x69\x6e\147\163");
        $Fxxjq->setAccessible(true);
        $Fxxjq->invoke($this->indexController, $qx51c);
    }
    public function testProcessRoleDeletionForAdminAllRoles()
    {
        $qx51c = ["\x64\x65\x6c\145\164\145\137\162\x6f\x6c\x65\137\141\144\155\x69\156" => "\x41\154\154\40\122\157\x6c\x65\x73"];
        $this->adminRoleModel->method("\141\144\x64\106\x69\145\x6c\144\x54\x6f\106\151\154\x74\145\x72")->willReturnSelf();
        $this->adminRoleModel->method("\164\x6f\117\160\164\151\157\x6e\x41\162\162\141\x79")->willReturn([["\154\141\142\145\x6c" => "\101\x64\x6d\x69\x6e"], ["\154\x61\x62\145\154" => "\115\141\156\141\147\145\x72"]]);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\x65\x74\123\164\x6f\x72\145\x43\x6f\x6e\146\x69\x67");
        $Fxxjq = new \ReflectionMethod($this->indexController, "\160\x72\157\x63\145\163\163\x52\x6f\154\145\x44\145\x6c\x65\164\151\x6f\x6e\137\106\157\162\x5f\101\x64\155\151\x6e");
        $Fxxjq->setAccessible(true);
        $Fxxjq->invoke($this->indexController, $qx51c);
    }
    public function testProcessRoleDeletionForAdminSingleRole()
    {
        $qx51c = ["\144\145\x6c\x65\x74\145\x5f\x72\157\x6c\145\x5f\x61\x64\155\x69\156" => "\101\x64\155\x69\x6e"];
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\145\x74\123\164\x6f\x72\x65\103\157\x6e\x66\x69\147");
        $Fxxjq = new \ReflectionMethod($this->indexController, "\160\x72\x6f\x63\145\x73\163\122\157\x6c\x65\x44\x65\x6c\x65\164\x69\157\x6e\137\x46\157\162\137\x41\x64\x6d\151\156");
        $Fxxjq->setAccessible(true);
        $Fxxjq->invoke($this->indexController, $qx51c);
    }
    public function testGetAllAdminRolesReturnsRoles()
    {
        $this->adminRoleModel->method("\x61\x64\x64\x46\151\145\154\144\x54\x6f\x46\x69\x6c\x74\145\162")->willReturnSelf();
        $this->adminRoleModel->method("\x74\157\x4f\160\164\151\x6f\156\x41\x72\x72\x61\x79")->willReturn([["\154\141\x62\x65\x6c" => "\101\144\x6d\x69\x6e"], ["\154\141\142\x65\154" => "\x4d\141\x6e\141\147\145\162"]]);
        $Fxxjq = new \ReflectionMethod($this->indexController, "\x67\x65\164\x41\x6c\154\101\x64\155\151\156\122\157\x6c\145\163");
        $Fxxjq->setAccessible(true);
        $FR_wU = $Fxxjq->invoke($this->indexController);
        $this->assertEquals([["\154\141\x62\145\154" => "\101\144\155\x69\x6e"], ["\x6c\141\142\x65\154" => "\x4d\x61\156\x61\x67\x65\162"]], $FR_wU);
    }
    public function testGetAllAdminRolesEmpty()
    {
        $this->adminRoleModel->method("\x61\144\144\x46\151\x65\x6c\x64\x54\x6f\x46\151\x6c\164\145\162")->willReturnSelf();
        $this->adminRoleModel->method("\164\157\117\x70\x74\x69\157\x6e\101\x72\162\x61\171")->willReturn([]);
        $Fxxjq = new \ReflectionMethod($this->indexController, "\x67\145\x74\x41\154\154\x41\144\155\151\x6e\x52\157\154\x65\163");
        $Fxxjq->setAccessible(true);
        $FR_wU = $Fxxjq->invoke($this->indexController);
        $this->assertEquals([], $FR_wU);
    }
    public function testDeleteRoleMethodsConfigAdminCallsSetStoreConfig()
    {
        $this->twofautility->expects($this->exactly(2))->method("\x73\x65\x74\123\164\x6f\162\x65\x43\157\156\146\151\147");
        $Fxxjq = new \ReflectionMethod($this->indexController, "\144\145\154\x65\164\x65\x52\157\154\145\x4d\145\164\x68\157\x64\x73\103\x6f\156\x66\x69\147\137\141\x64\x6d\x69\156");
        $Fxxjq->setAccessible(true);
        $Fxxjq->invoke($this->indexController, "\101\x64\x6d\151\156");
    }
    public function testGetAllCustomerGroupsReturnsGroups()
    {
        $mLzGZ = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\164\x49\144", "\147\145\x74\103\x6f\144\145"])->getMock();
        $mLzGZ->method("\x67\x65\164\x49\x64")->willReturn(1);
        $mLzGZ->method("\147\x65\x74\x43\157\x64\x65")->willReturn("\147\162\x6f\x75\160\61");
        $D0Cxx = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\x74\x49\164\x65\x6d\163"])->getMock();
        $D0Cxx->method("\x67\145\x74\x49\164\x65\155\x73")->willReturn([$mLzGZ]);
        $mIbVT = $this->createMock(\Magento\Framework\Api\SearchCriteriaInterface::class);
        $this->groupRepository->method("\147\145\164\x4c\x69\x73\x74")->willReturn($D0Cxx);
        $this->searchCriteriaBuilder->method("\x63\x72\145\141\164\x65")->willReturn($mIbVT);
        $Fxxjq = new \ReflectionMethod($this->indexController, "\147\145\x74\x41\154\154\x43\165\x73\164\157\x6d\145\x72\x47\x72\x6f\165\160\163");
        $Fxxjq->setAccessible(true);
        $FR_wU = $Fxxjq->invoke($this->indexController);
        $this->assertEquals([1 => "\x67\x72\157\x75\160\x31"], $FR_wU);
    }
    public function testGetAllCustomerGroupsEmpty()
    {
        $D0Cxx = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\164\111\164\x65\x6d\163"])->getMock();
        $D0Cxx->method("\x67\145\164\111\164\145\x6d\163")->willReturn([]);
        $mIbVT = $this->createMock(\Magento\Framework\Api\SearchCriteriaInterface::class);
        $this->groupRepository->method("\x67\x65\x74\x4c\x69\163\164")->willReturn($D0Cxx);
        $this->searchCriteriaBuilder->method("\143\x72\145\x61\164\x65")->willReturn($mIbVT);
        $Fxxjq = new \ReflectionMethod($this->indexController, "\x67\x65\x74\101\154\x6c\x43\x75\163\x74\157\155\145\162\x47\162\157\165\160\x73");
        $Fxxjq->setAccessible(true);
        $FR_wU = $Fxxjq->invoke($this->indexController);
        $this->assertEquals([], $FR_wU);
    }
    public function testProcessRoleDeletionCustomerAllSitesAllGroups()
    {
        $qx51c = ["\x64\145\x6c\x65\x74\x65\137\162\x6f\154\145" => "\x41\x6c\x6c\40\107\162\157\x75\x70\163", "\144\x65\x6c\x65\164\145\x5f\162\157\154\145\x5f\x73\x69\164\145" => "\x41\154\x6c\x20\x53\x69\x74\145\163"];
        $nWhOA = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\x74\111\144", "\147\x65\164\x43\x6f\x64\145", "\x67\x65\164\116\141\155\145"])->getMock();
        $nWhOA->method("\x67\x65\x74\111\x64")->willReturn(1);
        $nWhOA->method("\x67\x65\164\103\157\144\145")->willReturn("\163\x69\x74\x65\x31");
        $nWhOA->method("\x67\145\x74\x4e\141\x6d\x65")->willReturn("\x53\151\164\x65\x20\61");
        $this->websiteRepository->method("\x67\x65\x74\x4c\x69\x73\x74")->willReturn([$nWhOA]);
        $BEdTI = [1 => "\x67\x72\157\165\160\61"];
        $this->twofautility->method("\x67\145\x74\x57\145\142\163\151\x74\145\102\171\x43\157\144\x65\x4f\162\116\141\155\145")->willReturn($nWhOA);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\x65\x74\123\x74\157\x72\145\x43\x6f\156\x66\x69\147");
        $Fxxjq = new \ReflectionMethod($this->indexController, "\x70\162\157\x63\x65\x73\x73\122\x6f\154\x65\x44\145\154\145\x74\151\157\156\x5f\143\165\x73\x74\157\155\145\162");
        $Fxxjq->setAccessible(true);
        $Fxxjq->invoke($this->indexController, $qx51c, $BEdTI);
    }
    public function testProcessRoleDeletionCustomerSingleSiteGroup()
    {
        $qx51c = ["\x64\145\x6c\145\x74\145\137\162\x6f\x6c\145" => "\147\x72\x6f\x75\x70\61", "\144\145\x6c\145\x74\145\137\x72\x6f\x6c\x65\x5f\x73\x69\164\145" => "\163\151\x74\145\x31"];
        $nWhOA = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\164\111\144", "\x67\x65\164\x43\157\x64\x65", "\x67\145\x74\116\141\155\145"])->getMock();
        $nWhOA->method("\147\x65\164\111\144")->willReturn(1);
        $nWhOA->method("\x67\x65\164\103\157\144\x65")->willReturn("\163\151\164\x65\61");
        $nWhOA->method("\147\x65\x74\x4e\x61\x6d\x65")->willReturn("\x53\x69\164\145\x20\x31");
        $this->websiteRepository->method("\x67\145\x74\114\151\163\x74")->willReturn([$nWhOA]);
        $BEdTI = [1 => "\147\x72\x6f\x75\160\61"];
        $this->twofautility->method("\147\145\164\x57\x65\x62\x73\151\x74\145\102\x79\103\x6f\144\x65\117\162\x4e\x61\155\145")->willReturn($nWhOA);
        $this->twofautility->expects($this->atLeastOnce())->method("\163\145\x74\x53\164\x6f\162\x65\103\x6f\x6e\x66\x69\147");
        $Fxxjq = new \ReflectionMethod($this->indexController, "\160\162\x6f\x63\x65\163\x73\122\x6f\154\145\x44\145\x6c\145\x74\151\x6f\x6e\x5f\143\x75\x73\x74\157\x6d\145\x72");
        $Fxxjq->setAccessible(true);
        $Fxxjq->invoke($this->indexController, $qx51c, $BEdTI);
    }
    public function testGetAllWebsitesReturnsCodes()
    {
        $nWhOA = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\x74\x43\x6f\x64\145"])->getMock();
        $nWhOA->method("\x67\145\164\x43\x6f\x64\x65")->willReturn("\x73\x69\164\145\61");
        $this->websiteRepository->method("\x67\145\x74\114\151\163\164")->willReturn([$nWhOA]);
        $Fxxjq = new \ReflectionMethod($this->indexController, "\x67\x65\x74\101\x6c\154\127\x65\142\x73\x69\164\145\x73");
        $Fxxjq->setAccessible(true);
        $FR_wU = $Fxxjq->invoke($this->indexController);
        $this->assertEquals(["\163\x69\x74\145\x31"], $FR_wU);
    }
    public function testGetAllWebsitesEmpty()
    {
        $this->websiteRepository->method("\x67\x65\164\114\151\163\164")->willReturn([]);
        $Fxxjq = new \ReflectionMethod($this->indexController, "\x67\x65\164\x41\x6c\x6c\127\145\142\x73\151\x74\x65\163");
        $Fxxjq->setAccessible(true);
        $FR_wU = $Fxxjq->invoke($this->indexController);
        $this->assertEquals([], $FR_wU);
    }
    public function testDeleteRoleMethodsConfigCallsSetStoreConfig()
    {
        $this->twofautility->expects($this->exactly(2))->method("\163\x65\164\x53\x74\x6f\162\x65\103\157\x6e\146\x69\x67");
        $Fxxjq = new \ReflectionMethod($this->indexController, "\144\145\154\145\164\x65\x52\x6f\154\145\115\x65\164\x68\x6f\144\163\x43\157\x6e\146\x69\x67");
        $Fxxjq->setAccessible(true);
        $Fxxjq->invoke($this->indexController, "\163\151\x74\145\x31", "\147\162\x6f\165\x70\61");
    }
    public function testIsAllowedReturnsTrue()
    {
        $this->authorization->method("\151\163\x41\x6c\154\x6f\167\145\144")->willReturn(true);
        $Fxxjq = new \ReflectionMethod($this->indexController, "\x5f\151\163\101\x6c\154\x6f\167\145\x64");
        $Fxxjq->setAccessible(true);
        $this->assertTrue($Fxxjq->invoke($this->indexController));
    }
    public function testIsAllowedReturnsFalse()
    {
        $this->authorization->method("\151\x73\x41\x6c\x6c\157\x77\145\x64")->willReturn(false);
        $Fxxjq = new \ReflectionMethod($this->indexController, "\137\x69\163\101\154\154\x6f\167\145\x64");
        $Fxxjq->setAccessible(true);
        $this->assertFalse($Fxxjq->invoke($this->indexController));
    }
    public function testApplyRulesToRolesAllRoles()
    {
        $dwroA = [["\x72\x6f\x6c\145" => "\101\154\x6c\x20\122\x6f\x6c\145\x73", "\155\x65\164\x68\157\144\163" => ["\x6d\61", "\x6d\62"]]];
        $this->adminRoleModel->method("\x61\144\x64\x46\151\145\x6c\x64\x54\x6f\106\x69\x6c\x74\x65\162")->willReturnSelf();
        $this->adminRoleModel->method("\164\157\x4f\x70\x74\x69\157\156\101\x72\x72\141\171")->willReturn([["\x6c\141\x62\x65\x6c" => "\x41\144\155\151\156"], ["\x6c\x61\x62\x65\x6c" => "\115\141\156\141\147\x65\x72"]]);
        $this->twofautility->expects($this->atLeastOnce())->method("\163\x65\164\x53\164\x6f\162\145\x43\157\x6e\x66\151\x67");
        $Fxxjq = new \ReflectionMethod($this->indexController, "\x61\x70\160\154\x79\x52\x75\x6c\x65\163\x54\x6f\122\x6f\154\x65\x73");
        $Fxxjq->setAccessible(true);
        $Fxxjq->invoke($this->indexController, $dwroA);
    }
    public function testApplyRulesToRolesSingleRole()
    {
        $dwroA = [["\x72\x6f\x6c\145" => "\101\x64\x6d\151\156", "\155\145\164\x68\x6f\x64\163" => ["\x6d\x31", "\155\62"]]];
        $this->adminRoleModel->method("\141\144\144\106\151\x65\154\144\124\x6f\x46\x69\x6c\x74\x65\162")->willReturnSelf();
        $this->adminRoleModel->method("\x74\x6f\117\160\164\151\157\x6e\101\x72\x72\x61\x79")->willReturn([["\154\141\142\145\154" => "\101\x64\155\151\x6e"], ["\154\x61\x62\x65\x6c" => "\x4d\x61\156\141\x67\145\162"]]);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\x65\x74\123\164\x6f\x72\x65\103\x6f\156\x66\151\x67");
        $Fxxjq = new \ReflectionMethod($this->indexController, "\x61\x70\160\154\171\122\165\154\x65\163\124\x6f\122\157\x6c\145\163");
        $Fxxjq->setAccessible(true);
        $Fxxjq->invoke($this->indexController, $dwroA);
    }
    public function testApplyRulesToRolesMissingMethodsOrRole()
    {
        $dwroA = [["\162\157\154\145" => "\101\144\x6d\151\x6e"], ["\155\x65\164\150\x6f\144\x73" => ["\x6d\61", "\x6d\x32"]]];
        $this->adminRoleModel->method("\141\x64\144\x46\151\x65\154\144\124\x6f\106\151\154\164\x65\162")->willReturnSelf();
        $this->adminRoleModel->method("\x74\157\117\x70\164\x69\157\156\x41\162\162\x61\171")->willReturn([["\x6c\x61\142\x65\x6c" => "\101\x64\x6d\x69\x6e"], ["\x6c\141\x62\145\154" => "\115\141\x6e\141\147\145\x72"]]);
        $this->twofautility->expects($this->never())->method("\x73\145\164\123\x74\157\x72\145\x43\x6f\x6e\x66\x69\147");
        $Fxxjq = new \ReflectionMethod($this->indexController, "\141\160\160\154\171\x52\x75\x6c\145\163\x54\x6f\122\x6f\x6c\145\163");
        $Fxxjq->setAccessible(true);
        $Fxxjq->invoke($this->indexController, $dwroA);
    }
    private function getMockResultPage()
    {
        $Jmg6e = $this->getMockBuilder(\stdClass::class)->addMethods(["\x70\162\x65\160\x65\x6e\144"])->getMock();
        $Jmg6e->method("\x70\162\145\x70\145\156\144")->willReturnSelf();
        $FVzl9 = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\164\124\151\x74\x6c\145"])->getMock();
        $FVzl9->method("\x67\x65\164\124\x69\x74\154\x65")->willReturn($Jmg6e);
        $VTHjl = $this->createMock(\Magento\Framework\View\Result\Page::class);
        $VTHjl->method("\147\145\164\103\157\x6e\x66\151\147")->willReturn($FVzl9);
        return $VTHjl;
    }
}