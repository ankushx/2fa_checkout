<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Adminhtml\Advance2fa;

use PHPUnit\Framework\TestCase;
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
        $this->fileFactory = $this->createMock(\Magento\Framework\App\Response\Http\FileFactory::class);
        $this->websiteRepository = $this->createMock(\Magento\Store\Api\WebsiteRepositoryInterface::class);
        $this->groupRepository = $this->createMock(\Magento\Customer\Api\GroupRepositoryInterface::class);
        $this->searchCriteriaBuilder = $this->createMock(\Magento\Framework\Api\SearchCriteriaBuilder::class);
        $this->resultRedirectFactory = $this->createMock(\Magento\Framework\Controller\Result\RedirectFactory::class);
        $this->resultRedirect = $this->createMock(\Magento\Framework\Controller\Result\Redirect::class);
        $this->authorization = $this->createMock(\Magento\Framework\AuthorizationInterface::class);
        $this->resultPage = $this->createMock(\Magento\Backend\Model\View\Result\Page::class);
        $this->context->method("\x67\145\x74\x4d\x65\163\x73\x61\147\x65\x4d\x61\156\141\x67\x65\x72")->willReturn($this->messageManager);
        $this->indexController = $this->getMockBuilder(\MiniOrange\TwoFA\Controller\Adminhtml\Advance2fa\Index::class)->setConstructorArgs([$this->context, $this->twofautility, $this->resultPageFactory, $this->messageManager, $this->logger, $this->fileFactory, $this->websiteRepository, $this->groupRepository, $this->searchCriteriaBuilder])->onlyMethods(["\147\x65\164\x52\x65\x71\x75\145\163\x74", "\x69\x73\106\157\x72\155\x4f\x70\x74\x69\157\x6e\102\x65\x69\156\x67\123\x61\166\x65\x64"])->getMock();
        $HVD1L = new \ReflectionClass($this->indexController);
        if (!$HVD1L->hasProperty("\137\141\165\164\x68\157\162\x69\172\141\x74\151\157\x6e")) {
            goto IzPGm;
        }
        $qZcTj = $HVD1L->getProperty("\137\x61\165\164\150\157\x72\x69\x7a\141\164\151\157\x6e");
        $qZcTj->setAccessible(true);
        $qZcTj->setValue($this->indexController, $this->authorization);
        IzPGm:
        if (!$HVD1L->hasProperty("\162\145\163\165\x6c\164\x52\145\144\x69\x72\145\x63\x74\x46\x61\x63\164\x6f\x72\x79")) {
            goto qJOnX;
        }
        $tXY1X = $HVD1L->getProperty("\162\145\x73\x75\x6c\x74\x52\145\144\x69\162\x65\143\164\x46\x61\143\x74\x6f\162\x79");
        $tXY1X->setAccessible(true);
        $tXY1X->setValue($this->indexController, $this->resultRedirectFactory);
        qJOnX:
        if (!$HVD1L->hasProperty("\x72\145\163\x75\154\x74\x50\x61\147\x65\x46\x61\143\164\157\x72\x79")) {
            goto WN0TM;
        }
        $Qfg_3 = $HVD1L->getProperty("\162\145\x73\x75\154\164\x50\141\x67\x65\106\141\143\164\157\x72\171");
        $Qfg_3->setAccessible(true);
        $Qfg_3->setValue($this->indexController, $this->resultPageFactory);
        WN0TM:
    }
    public function testExecutePositiveSettingsSaved()
    {
        $UEWrF = ["\x63\165\x73\x74\157\x6d\x65\x72\137\162\145\x6d\145\x6d\142\145\x72\137\144\145\166\x69\143\145" => 1, "\143\165\163\164\157\x6d\x65\x72\137\144\145\166\x69\x63\145\x5f\143\x6f\165\x6e\164" => 3, "\143\x75\x73\x74\x6f\155\x65\x72\137\x72\x65\155\x65\155\x62\x65\x72\137\144\145\x76\x69\143\145\137\x44\x61\x79\x73" => 7, "\x63\x75\163\x74\x6f\x6d\x65\162\137\x72\x65\x67\x69\x73\164\x72\141\x74\151\x6f\x6e\137\x69\x6e\x6c\x69\156\x65" => 1, "\143\x75\163\164\157\155\145\162\137\x73\x6b\x69\160\x5f\151\156\x6c\x69\156\145" => 1, "\x63\165\163\164\x6f\x6d\145\162\x5f\163\x6b\151\160\137\x64\x61\x79\x73" => 5, "\143\x75\x73\164\x6f\155\145\162\137\160\157\160\165\160\137\x63\165\163\164\157\x6d\x69\172\x61\x74\x69\157\156" => 1, "\102\147\x43\157\x6c\157\162" => "\x23\146\146\146", "\160\x6f\160\165\160\x42\147\103\157\154\x6f\x72" => "\x23\x66\x66\146", "\160\157\x70\x75\x70\124\x65\x78\164\x43\x6f\x6c\157\x72" => "\x23\60\x30\60", "\160\157\160\x75\x70\102\x74\156\103\157\154\x6f\162" => "\43\x31\61\x31", "\143\x75\163\164\x6f\x6d\145\x72\x5f\x69\x70\x5f\x6c\x69\163\x74\151\156\x67" => 1, "\167\x68\x69\164\145\x6c\151\163\164\x49\x50\163" => json_encode(["\x31\x2e\61\x2e\61\x2e\61"]), "\142\x6c\x61\143\x6b\x6c\151\x73\x74\x49\x50\163" => json_encode(["\62\x2e\62\x2e\x32\56\62"])];
        $fw3Ht = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->indexController->method("\x67\x65\x74\x52\x65\161\165\145\x73\164")->willReturn($fw3Ht);
        $fw3Ht->method("\x67\x65\x74\x50\141\162\141\x6d\163")->willReturn($UEWrF);
        $this->indexController->method("\x69\x73\106\x6f\162\x6d\x4f\160\164\151\157\156\102\x65\151\156\x67\x53\141\166\145\x64")->with($UEWrF)->willReturn(true);
        $this->twofautility->expects($this->once())->method("\151\163\x43\165\x73\x74\157\155\145\x72\x52\145\x67\x69\x73\x74\x65\x72\145\x64")->willReturn(true);
        $this->twofautility->expects($this->atLeastOnce())->method("\163\145\x74\x53\164\157\x72\x65\x43\x6f\156\x66\151\x67");
        $this->twofautility->expects($this->once())->method("\x66\x6c\165\x73\150\103\x61\143\150\145");
        $this->twofautility->expects($this->once())->method("\162\145\151\x6e\151\x74\x43\x6f\x6e\x66\x69\x67");
        $this->messageManager->expects($this->once())->method("\x61\144\144\123\x75\143\x63\145\x73\163\115\145\163\163\141\x67\145");
        $this->resultPageFactory->expects($this->any())->method("\143\162\145\141\164\x65")->willReturn($this->resultPage);
        $ZN3Ob = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\164\124\x69\164\154\145"])->getMock();
        $F6wG3 = $this->getMockBuilder(\stdClass::class)->addMethods(["\160\x72\145\160\145\156\x64"])->getMock();
        $this->resultPage->expects($this->any())->method("\x67\x65\164\x43\157\156\x66\151\x67")->willReturn($ZN3Ob);
        $ZN3Ob->expects($this->any())->method("\147\145\x74\124\151\x74\x6c\x65")->willReturn($F6wG3);
        $F6wG3->expects($this->any())->method("\x70\x72\145\x70\x65\x6e\x64");
        $q0qgE = $this->indexController->execute();
        $this->assertSame($this->resultPage, $q0qgE);
    }
    public function testExecuteFormNotSubmitted()
    {
        $UEWrF = [];
        $fw3Ht = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->indexController->method("\147\145\164\x52\145\x71\x75\x65\163\164")->willReturn($fw3Ht);
        $fw3Ht->method("\x67\x65\x74\120\141\162\141\x6d\163")->willReturn($UEWrF);
        $this->indexController->method("\151\163\106\157\162\155\117\x70\164\x69\x6f\156\102\145\151\x6e\147\123\141\x76\x65\144")->with($UEWrF)->willReturn(false);
        $this->resultPageFactory->expects($this->once())->method("\x63\x72\145\141\164\145")->willReturn($this->resultPage);
        $ZN3Ob = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\164\124\151\164\x6c\145"])->getMock();
        $F6wG3 = $this->getMockBuilder(\stdClass::class)->addMethods(["\160\162\145\160\x65\x6e\x64"])->getMock();
        $this->resultPage->expects($this->once())->method("\147\x65\164\103\157\x6e\x66\x69\147")->willReturn($ZN3Ob);
        $ZN3Ob->expects($this->once())->method("\x67\145\164\x54\151\x74\x6c\145")->willReturn($F6wG3);
        $F6wG3->expects($this->once())->method("\160\162\145\x70\145\156\x64");
        $q0qgE = $this->indexController->execute();
        $this->assertSame($this->resultPage, $q0qgE);
    }
    public function testExecuteException()
    {
        $UEWrF = ["\x63\165\x73\x74\x6f\155\x65\x72\137\x72\x65\x6d\145\155\142\145\x72\137\144\x65\166\151\x63\145" => 1];
        $fw3Ht = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->indexController->method("\147\x65\x74\x52\x65\161\x75\145\x73\x74")->willReturn($fw3Ht);
        $fw3Ht->method("\x67\x65\164\x50\x61\162\x61\155\x73")->willReturn($UEWrF);
        $this->indexController->method("\x69\x73\x46\x6f\x72\x6d\x4f\160\x74\151\x6f\x6e\102\x65\151\x6e\147\123\141\166\145\x64")->with($UEWrF)->willReturn(true);
        $this->twofautility->method("\151\163\103\x75\163\164\157\155\x65\162\122\x65\147\x69\163\x74\x65\162\145\144")->willReturn(true);
        $this->twofautility->method("\163\145\164\123\164\157\x72\145\103\157\x6e\x66\151\147")->willThrowException(new \Exception("\x66\x61\151\154\41"));
        $this->messageManager->expects($this->once())->method("\141\x64\x64\105\x72\x72\157\162\x4d\145\163\163\141\x67\x65");
        $this->logger->expects($this->once())->method("\x64\x65\142\165\x67");
        $this->resultPageFactory->expects($this->any())->method("\x63\x72\x65\x61\x74\x65")->willReturn($this->resultPage);
        $ZN3Ob = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\164\124\151\x74\154\x65"])->getMock();
        $F6wG3 = $this->getMockBuilder(\stdClass::class)->addMethods(["\x70\162\x65\x70\145\156\144"])->getMock();
        $this->resultPage->expects($this->any())->method("\x67\x65\x74\x43\157\156\146\151\x67")->willReturn($ZN3Ob);
        $ZN3Ob->expects($this->any())->method("\147\x65\x74\x54\151\x74\x6c\145")->willReturn($F6wG3);
        $F6wG3->expects($this->any())->method("\x70\162\145\160\x65\x6e\x64");
        $q0qgE = $this->indexController->execute();
        $this->assertSame($this->resultPage, $q0qgE);
    }
    public function testProcessValuesAndSaveDataCustomerNotRegistered()
    {
        $UEWrF = [];
        $this->twofautility->method("\151\163\x43\x75\x73\164\x6f\x6d\145\162\x52\145\x67\x69\163\164\145\x72\x65\x64")->willReturn(false);
        $this->messageManager->expects($this->once())->method("\141\144\144\x45\x72\x72\157\162\x4d\145\163\163\141\x67\x65");
        $this->resultRedirectFactory->expects($this->once())->method("\x63\162\x65\141\164\145")->willReturn($this->resultRedirect);
        $this->resultRedirect->expects($this->once())->method("\163\x65\x74\x50\141\164\150")->with("\x6d\x6f\164\x77\157\x66\141\57\141\143\x63\157\x75\156\x74\57\x69\156\144\145\170")->willReturnSelf();
        $dBDT8 = new \ReflectionMethod($this->indexController, "\160\x72\x6f\143\x65\x73\x73\x56\141\x6c\x75\x65\x73\101\x6e\144\123\x61\166\145\x44\141\x74\x61");
        $dBDT8->setAccessible(true);
        $q0qgE = $dBDT8->invoke($this->indexController, $UEWrF);
        $this->assertSame($this->resultRedirect, $q0qgE);
    }
    public function testIsAllowedTrue()
    {
        $this->authorization->method("\x69\x73\x41\154\x6c\x6f\167\x65\144")->willReturn(true);
        $dBDT8 = new \ReflectionMethod($this->indexController, "\137\x69\x73\x41\154\x6c\x6f\x77\x65\144");
        $dBDT8->setAccessible(true);
        $this->assertTrue($dBDT8->invoke($this->indexController));
    }
    public function testIsAllowedFalse()
    {
        $this->authorization->method("\151\x73\101\x6c\154\157\x77\145\x64")->willReturn(false);
        $dBDT8 = new \ReflectionMethod($this->indexController, "\x5f\151\163\101\x6c\154\x6f\x77\x65\144");
        $dBDT8->setAccessible(true);
        $this->assertFalse($dBDT8->invoke($this->indexController));
    }
}