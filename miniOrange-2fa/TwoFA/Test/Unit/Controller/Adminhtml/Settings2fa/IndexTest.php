<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Adminhtml\Settings2fa;

use MiniOrange\TwoFA\Controller\Adminhtml\Settings2fa\Index;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
class IndexTest extends TestCase
{
    private $context;
    private $twofautility;
    private $resultPageFactory;
    private $messageManager;
    private $logger;
    private $fileFactory;
    private $websiteRepository;
    private $groupRepository;
    private $searchCriteriaBuilder;
    private $indexController;
    private $resultPage;
    private $resultPageConfig;
    private $resultPageTitle;
    private $request;
    protected function setUp() : void
    {
        $this->context = $this->createMock(\Magento\Backend\App\Action\Context::class);
        $this->twofautility = $this->createMock(\MiniOrange\TwoFA\Helper\TwoFAUtility::class);
        $this->resultPageFactory = $this->createMock(\Magento\Framework\View\Result\PageFactory::class);
        $this->messageManager = $this->createMock(\Magento\Framework\Message\ManagerInterface::class);
        $this->logger = $this->createMock(\Psr\Log\LoggerInterface::class);
        $this->fileFactory = $this->createMock(\Magento\Framework\App\Response\Http\FileFactory::class);
        $this->websiteRepository = $this->createMock(\Magento\Store\Api\WebsiteRepositoryInterface::class);
        $this->groupRepository = $this->createMock(\Magento\Customer\Api\GroupRepositoryInterface::class);
        $this->searchCriteriaBuilder = $this->createMock(\Magento\Framework\Api\SearchCriteriaBuilder::class);
        $this->resultPage = $this->createMock(\Magento\Framework\View\Result\Page::class);
        $this->resultPageConfig = $this->createMock(\Magento\Framework\View\Page\Config::class);
        $this->resultPageTitle = $this->createMock(\Magento\Framework\View\Page\Title::class);
        $this->request = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->context->method("\x67\145\164\122\x65\x71\165\145\163\x74")->willReturn($this->request);
        $this->context->method("\x67\145\x74\x4d\145\x73\163\141\x67\x65\x4d\x61\x6e\x61\x67\145\162")->willReturn($this->messageManager);
        $this->indexController = new Index($this->context, $this->twofautility, $this->resultPageFactory, $this->messageManager, $this->logger, $this->fileFactory, $this->websiteRepository, $this->groupRepository, $this->searchCriteriaBuilder);
    }
    public function testExecutePositiveFlowSettingsSaved()
    {
        $ZHQ_E = ["\157\160\164\x69\x6f\156" => "\163\x61\x76\x65\x53\x69\156\x67\111\156\123\145\x74\x74\151\156\x67\x73\x5f\143\x75\x73\164\157\155\145\162", "\x72\x75\154\145\163" => json_encode([])];
        $this->request->method("\x67\145\164\x50\141\162\x61\155\x73")->willReturn($ZHQ_E);
        $this->indexController = $this->getControllerWithProcessValuesAndSaveDataMock();
        $this->twofautility->expects($this->once())->method("\146\x6c\165\163\x68\x43\x61\143\x68\145");
        $this->messageManager->expects($this->once())->method("\141\x64\x64\123\165\143\143\x65\x73\x73\115\145\163\163\x61\147\145");
        $this->twofautility->expects($this->once())->method("\162\145\x69\x6e\x69\164\x43\x6f\x6e\146\151\x67");
        $this->resultPageFactory->method("\143\162\145\x61\x74\x65")->willReturn($this->resultPage);
        $this->resultPage->method("\147\x65\x74\x43\157\156\146\151\147")->willReturn($this->resultPageConfig);
        $this->resultPageConfig->method("\147\x65\164\x54\151\164\x6c\x65")->willReturn($this->resultPageTitle);
        $this->resultPageTitle->expects($this->once())->method("\160\x72\x65\x70\x65\x6e\144");
        $Vm7HE = $this->createMock(\Magento\Framework\Api\SearchCriteriaInterface::class);
        $this->searchCriteriaBuilder->method("\143\162\x65\141\x74\x65")->willReturn($Vm7HE);
        $FZXsD = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\164\x49\164\145\155\163"])->getMock();
        $FZXsD->method("\147\145\x74\x49\x74\x65\x6d\x73")->willReturn([]);
        $this->groupRepository->method("\x67\x65\x74\x4c\151\x73\164")->with($Vm7HE)->willReturn($FZXsD);
        $gr6wt = $this->indexController->execute();
        $this->assertSame($this->resultPage, $gr6wt);
    }
    public function testExecuteExceptionThrown()
    {
        $ZHQ_E = ["\x6f\x70\164\151\157\x6e" => "\163\141\x76\x65\x53\x69\x6e\x67\x49\x6e\123\145\164\164\x69\x6e\x67\x73\137\x63\165\x73\164\157\155\145\162", "\x72\x75\x6c\145\x73" => json_encode([])];
        $this->request->method("\x67\x65\164\x50\x61\x72\141\155\163")->willReturn($ZHQ_E);
        $this->indexController = $this->getControllerWithProcessValuesAndSaveDataMock(true);
        $this->messageManager->expects($this->once())->method("\x61\144\x64\x45\162\x72\x6f\162\115\145\x73\163\141\147\145");
        $this->logger->expects($this->once())->method("\144\145\142\x75\147");
        $this->resultPageFactory->method("\143\x72\x65\x61\x74\x65")->willReturn($this->resultPage);
        $this->resultPage->method("\x67\145\164\x43\x6f\x6e\146\151\x67")->willReturn($this->resultPageConfig);
        $this->resultPageConfig->method("\147\145\164\x54\151\164\154\x65")->willReturn($this->resultPageTitle);
        $this->resultPageTitle->expects($this->once())->method("\x70\x72\x65\160\x65\156\144");
        $gr6wt = $this->indexController->execute();
        $this->assertSame($this->resultPage, $gr6wt);
    }
    public function testExecuteWithEmptyParams()
    {
        $this->request->method("\x67\145\164\x50\x61\162\x61\155\163")->willReturn([]);
        $this->resultPageFactory->method("\x63\x72\x65\141\164\x65")->willReturn($this->resultPage);
        $this->resultPage->method("\147\145\x74\x43\x6f\156\146\151\147")->willReturn($this->resultPageConfig);
        $this->resultPageConfig->method("\147\145\x74\124\x69\164\x6c\x65")->willReturn($this->resultPageTitle);
        $this->resultPageTitle->expects($this->once())->method("\x70\162\145\160\145\156\144");
        $gr6wt = $this->indexController->execute();
        $this->assertSame($this->resultPage, $gr6wt);
    }
    public function testProcessValuesAndSaveDataValidRulesAllSitesGroups()
    {
        $ZHQ_E = ["\x6f\x70\164\151\157\156" => "\163\141\166\x65\x53\151\156\x67\x49\x6e\x53\145\x74\164\151\x6e\x67\x73\x5f\x63\165\x73\164\157\x6d\x65\x72", "\162\x75\x6c\145\x73" => json_encode([["\163\151\164\x65" => "\x41\154\154\x20\123\151\x74\145\x73", "\x67\x72\157\165\160" => "\101\154\154\x20\107\162\157\x75\160\163", "\155\x65\x74\x68\157\x64\x73" => ["\155\61", "\155\x32"]]])];
        $this->mockWebsitesAndGroups();
        $UAtYS = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\164\x49\144"])->getMock();
        $UAtYS->method("\147\145\x74\111\x64")->willReturn(1);
        $this->twofautility->method("\x67\145\164\x57\x65\142\163\151\164\x65\x42\171\103\157\144\145\117\162\116\x61\x6d\145")->willReturn($UAtYS);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\145\164\123\164\157\x72\x65\103\157\156\x66\x69\147");
        $s1HoY = new \ReflectionMethod($this->indexController, "\x70\x72\x6f\x63\145\x73\163\x56\x61\x6c\165\145\x73\101\x6e\144\123\141\166\x65\104\141\x74\x61");
        $s1HoY->setAccessible(true);
        $s1HoY->invoke($this->indexController, $ZHQ_E);
    }
    public function testProcessValuesAndSaveDataNoRules()
    {
        $ZHQ_E = ["\157\x70\x74\151\157\156" => "\163\141\166\x65\x53\x69\156\147\x49\156\x53\x65\164\x74\x69\x6e\x67\163\x5f\143\165\163\164\157\x6d\x65\x72"];
        $this->twofautility->expects($this->never())->method("\x73\x65\x74\x53\x74\x6f\162\145\x43\x6f\156\146\151\x67");
        $s1HoY = new \ReflectionMethod($this->indexController, "\x70\162\157\x63\x65\x73\163\x56\141\x6c\x75\145\x73\101\156\144\123\141\166\x65\x44\141\164\x61");
        $s1HoY->setAccessible(true);
        $s1HoY->invoke($this->indexController, $ZHQ_E);
    }
    public function testProcessValuesAndSaveDataInvalidJsonRules()
    {
        $ZHQ_E = ["\x6f\160\x74\x69\x6f\x6e" => "\x73\141\166\x65\x53\151\156\147\x49\156\x53\x65\x74\164\x69\156\147\x73\x5f\143\165\163\164\157\155\x65\162", "\x72\165\154\145\x73" => "\x6e\157\x74\55\152\x73\x6f\x6e"];
        $this->twofautility->expects($this->never())->method("\x73\x65\x74\x53\x74\x6f\x72\145\x43\157\156\146\151\147");
        $s1HoY = new \ReflectionMethod($this->indexController, "\x70\162\157\x63\145\163\163\x56\x61\x6c\x75\145\x73\101\156\x64\123\141\166\145\x44\x61\164\x61");
        $s1HoY->setAccessible(true);
        $s1HoY->invoke($this->indexController, $ZHQ_E);
    }
    public function testGetAllCustomerGroupsReturnsGroups()
    {
        $Vm7HE = $this->createMock(\Magento\Framework\Api\SearchCriteria::class);
        $QxC2b = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\164\111\144", "\x67\145\x74\103\x6f\x64\145"])->getMock();
        $QxC2b->method("\x67\x65\x74\111\x64")->willReturn(1);
        $QxC2b->method("\x67\x65\x74\103\157\x64\145")->willReturn("\107\x65\156\145\162\141\x6c");
        $nEmwi = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\164\x49\x64", "\x67\x65\x74\103\157\x64\x65"])->getMock();
        $nEmwi->method("\147\x65\164\x49\x64")->willReturn(2);
        $nEmwi->method("\147\145\x74\103\x6f\x64\145")->willReturn("\127\150\157\x6c\145\163\x61\154\x65");
        $FZXsD = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\x74\111\164\x65\155\x73"])->getMock();
        $FZXsD->method("\147\145\x74\x49\164\145\x6d\x73")->willReturn([$QxC2b, $nEmwi]);
        $this->searchCriteriaBuilder->method("\143\162\145\141\164\145")->willReturn($Vm7HE);
        $this->groupRepository->method("\147\145\x74\x4c\151\163\164")->willReturn($FZXsD);
        $s1HoY = new \ReflectionMethod($this->indexController, "\147\145\164\x41\x6c\x6c\x43\165\163\x74\x6f\155\145\x72\107\x72\x6f\165\x70\163");
        $s1HoY->setAccessible(true);
        $gr6wt = $s1HoY->invoke($this->indexController);
        $this->assertEquals([1 => "\x47\x65\x6e\145\x72\141\154", 2 => "\127\150\157\x6c\x65\163\141\x6c\x65"], $gr6wt);
    }
    public function testGetAllCustomerGroupsNoGroups()
    {
        $Vm7HE = $this->createMock(\Magento\Framework\Api\SearchCriteria::class);
        $FZXsD = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\164\111\164\145\x6d\x73"])->getMock();
        $FZXsD->method("\x67\145\164\111\164\x65\155\163")->willReturn([]);
        $this->searchCriteriaBuilder->method("\x63\162\145\x61\x74\145")->willReturn($Vm7HE);
        $this->groupRepository->method("\x67\x65\x74\114\x69\163\x74")->willReturn($FZXsD);
        $s1HoY = new \ReflectionMethod($this->indexController, "\x67\x65\164\x41\x6c\154\x43\165\163\x74\157\x6d\145\162\107\162\157\x75\x70\x73");
        $s1HoY->setAccessible(true);
        $gr6wt = $s1HoY->invoke($this->indexController);
        $this->assertEquals([], $gr6wt);
    }
    public function testProcessRoleDeletionAllSitesAllGroups()
    {
        $ZHQ_E = ["\144\145\x6c\145\x74\145\137\162\157\154\x65" => "\x41\x6c\x6c\40\107\x72\157\x75\160\163", "\x64\145\x6c\x65\164\145\137\162\157\x6c\x65\x5f\x73\151\164\145" => "\x41\x6c\154\40\123\x69\164\x65\x73"];
        $vDlrD = ["\x31" => "\x47\x65\156\145\162\x61\154"];
        $this->mockWebsitesAndGroups();
        $UAtYS = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\164\111\x64"])->getMock();
        $UAtYS->method("\x67\x65\164\x49\x64")->willReturn(1);
        $this->twofautility->method("\147\145\164\127\x65\142\x73\151\164\145\x42\171\103\x6f\x64\x65\117\162\116\141\x6d\145")->willReturn($UAtYS);
        $this->twofautility->expects($this->atLeastOnce())->method("\163\145\164\x53\164\157\162\x65\x43\x6f\x6e\146\x69\147");
        $s1HoY = new \ReflectionMethod($this->indexController, "\160\162\157\x63\145\163\163\x52\157\x6c\x65\x44\145\x6c\145\164\x69\157\x6e");
        $s1HoY->setAccessible(true);
        $s1HoY->invoke($this->indexController, $ZHQ_E, $vDlrD);
    }
    public function testProcessRoleDeletionNoWebsiteFound()
    {
        $ZHQ_E = ["\x64\x65\154\x65\164\x65\x5f\x72\157\154\x65" => "\x47\x65\156\x65\162\141\154", "\x64\x65\154\x65\164\x65\x5f\x72\x6f\x6c\x65\x5f\x73\151\164\145" => "\x4e\157\164\101\x57\145\142\x73\x69\164\x65"];
        $vDlrD = ["\61" => "\107\x65\x6e\x65\x72\x61\154"];
        $this->websiteRepository->method("\x67\145\x74\114\x69\x73\x74")->willReturn([]);
        $this->twofautility->expects($this->never())->method("\163\145\164\x53\164\157\x72\145\103\157\x6e\x66\x69\147");
        $s1HoY = new \ReflectionMethod($this->indexController, "\x70\162\157\143\145\163\163\x52\157\154\145\104\145\154\145\x74\x69\157\156");
        $s1HoY->setAccessible(true);
        $s1HoY->invoke($this->indexController, $ZHQ_E, $vDlrD);
    }
    public function testGetAllWebsitesReturnsCodes()
    {
        $ai_m9 = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\164\103\x6f\144\145"])->getMock();
        $ai_m9->method("\147\145\164\x43\x6f\144\145")->willReturn("\x62\x61\163\145");
        $Fqz3W = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\x74\x43\x6f\x64\x65"])->getMock();
        $Fqz3W->method("\x67\145\x74\103\157\144\x65")->willReturn("\x73\x65\x63\x6f\x6e\144");
        $this->websiteRepository->method("\147\x65\164\114\x69\163\164")->willReturn([$ai_m9, $Fqz3W]);
        $s1HoY = new \ReflectionMethod($this->indexController, "\147\x65\164\x41\154\x6c\x57\145\142\163\151\164\x65\x73");
        $s1HoY->setAccessible(true);
        $gr6wt = $s1HoY->invoke($this->indexController);
        $this->assertEquals(["\142\141\163\145", "\163\145\143\157\156\144"], $gr6wt);
    }
    public function testGetAllWebsitesNoWebsites()
    {
        $this->websiteRepository->method("\147\145\164\x4c\x69\x73\164")->willReturn([]);
        $s1HoY = new \ReflectionMethod($this->indexController, "\x67\145\164\101\154\154\127\145\142\163\151\x74\145\x73");
        $s1HoY->setAccessible(true);
        $gr6wt = $s1HoY->invoke($this->indexController);
        $this->assertEquals([], $gr6wt);
    }
    public function testDeleteRoleMethodsConfigCallsSetStoreConfig()
    {
        $this->twofautility->expects($this->exactly(2))->method("\x73\145\x74\123\164\157\162\145\103\157\x6e\x66\x69\147");
        $s1HoY = new \ReflectionMethod($this->indexController, "\x64\145\154\145\x74\x65\122\x6f\154\x65\x4d\x65\x74\150\x6f\x64\163\x43\157\156\x66\x69\147");
        $s1HoY->setAccessible(true);
        $s1HoY->invoke($this->indexController, "\163\x69\164\145", "\x67\x72\x6f\x75\160");
    }
    public function testSaveMethodsConfigCallsSetStoreConfig()
    {
        $this->twofautility->expects($this->exactly(2))->method("\x73\x65\164\x53\x74\x6f\162\145\x43\x6f\x6e\146\151\x67");
        $s1HoY = new \ReflectionMethod($this->indexController, "\163\x61\x76\x65\x4d\x65\x74\x68\157\144\x73\x43\x6f\156\x66\x69\x67");
        $s1HoY->setAccessible(true);
        $s1HoY->invoke($this->indexController, "\163\151\x74\145", "\147\162\x6f\x75\160", ["\155\61", "\155\x32"]);
    }
    private function mockWebsitesAndGroups()
    {
        $UeH5h = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\x74\103\157\144\x65", "\x67\145\164\x4e\x61\x6d\145", "\147\x65\164\111\x64"])->getMock();
        $UeH5h->method("\147\x65\x74\x43\157\x64\145")->willReturn("\x62\x61\163\x65");
        $UeH5h->method("\x67\145\x74\x4e\x61\155\x65")->willReturn("\x42\x61\x73\x65\x20\x53\x69\164\x65");
        $UeH5h->method("\x67\145\x74\111\144")->willReturn(1);
        $this->websiteRepository->method("\147\145\164\x4c\151\163\164")->willReturn([$UeH5h]);
        $NR_2G = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\164\111\144", "\x67\145\x74\x43\157\x64\145"])->getMock();
        $NR_2G->method("\147\145\x74\111\x64")->willReturn(1);
        $NR_2G->method("\147\145\164\103\x6f\x64\x65")->willReturn("\107\145\156\x65\x72\x61\x6c");
        $FZXsD = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\x74\111\164\145\155\163"])->getMock();
        $FZXsD->method("\147\x65\x74\x49\x74\x65\x6d\x73")->willReturn([$NR_2G]);
        $this->searchCriteriaBuilder->method("\x63\x72\x65\x61\x74\145")->willReturn($this->createMock(\Magento\Framework\Api\SearchCriteria::class));
        $this->groupRepository->method("\147\x65\164\114\151\x73\x74")->willReturn($FZXsD);
    }
    private function getControllerWithProcessValuesAndSaveDataMock($RCIkP = false)
    {
        $WNwqy = $this->getMockBuilder(Index::class)->setConstructorArgs([$this->context, $this->twofautility, $this->resultPageFactory, $this->messageManager, $this->logger, $this->fileFactory, $this->websiteRepository, $this->groupRepository, $this->searchCriteriaBuilder])->onlyMethods(["\160\x72\x6f\x63\x65\x73\x73\x56\141\154\165\145\x73\101\156\x64\x53\141\166\x65\104\141\164\x61"])->getMock();
        if (!$RCIkP) {
            goto jGQtz;
        }
        $WNwqy->method("\x70\x72\157\x63\145\163\x73\x56\x61\x6c\x75\145\163\101\x6e\144\123\x61\166\145\104\x61\x74\141")->willThrowException(new \Exception("\146\141\x69\x6c"));
        jGQtz:
        return $WNwqy;
    }
}