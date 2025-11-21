<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Adminhtml\Customer2fa;

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
        $this->context->method("\x67\x65\164\115\145\x73\x73\141\147\x65\x4d\x61\156\141\147\145\x72")->willReturn($this->messageManager);
        $this->indexController = $this->getMockBuilder(\MiniOrange\TwoFA\Controller\Adminhtml\Customer2fa\Index::class)->setConstructorArgs([$this->context, $this->twofautility, $this->resultPageFactory, $this->messageManager, $this->logger, $this->fileFactory, $this->websiteRepository, $this->groupRepository, $this->searchCriteriaBuilder])->onlyMethods(["\147\x65\x74\122\145\161\165\145\163\x74", "\x69\x73\106\x6f\162\155\x4f\160\164\151\x6f\156\102\x65\151\156\x67\x53\141\x76\145\144"])->getMock();
        $QpHIY = new \ReflectionClass($this->indexController);
        if (!$QpHIY->hasProperty("\x5f\x61\165\x74\x68\x6f\162\x69\x7a\141\x74\151\157\156")) {
            goto AmKA5;
        }
        $lTFrY = $QpHIY->getProperty("\137\141\x75\164\150\157\162\151\x7a\x61\164\x69\x6f\156");
        $lTFrY->setAccessible(true);
        $lTFrY->setValue($this->indexController, $this->authorization);
        AmKA5:
        if (!$QpHIY->hasProperty("\162\145\x73\x75\154\x74\x52\145\x64\151\x72\145\x63\x74\106\x61\x63\164\x6f\x72\171")) {
            goto dVK7k;
        }
        $I61Xa = $QpHIY->getProperty("\x72\x65\x73\165\x6c\164\x52\x65\144\x69\x72\x65\x63\164\x46\141\x63\164\157\162\x79");
        $I61Xa->setAccessible(true);
        $I61Xa->setValue($this->indexController, $this->resultRedirectFactory);
        dVK7k:
        if (!$QpHIY->hasProperty("\162\x65\163\165\x6c\x74\120\x61\x67\x65\x46\141\x63\x74\157\162\x79")) {
            goto hGPY5;
        }
        $sLKTZ = $QpHIY->getProperty("\162\x65\x73\165\x6c\x74\120\x61\147\145\x46\x61\x63\x74\x6f\x72\x79");
        $sLKTZ->setAccessible(true);
        $sLKTZ->setValue($this->indexController, $this->resultPageFactory);
        hGPY5:
    }
    public function testExecutePositiveSettingsSaved()
    {
        $flNKa = ["\157\x70\x74\x69\x6f\156" => "\x73\141\166\x65\123\151\156\147\111\156\x53\145\164\x74\151\x6e\147\x73\x5f\143\x75\163\x74\157\155\145\162", "\162\165\154\x65\163" => json_encode([["\x73\151\164\145" => "\x41\154\x6c\40\x53\151\164\145\163", "\x67\x72\157\x75\x70" => "\101\154\x6c\x20\x47\x72\157\165\x70\x73", "\155\x65\164\150\x6f\x64\x73" => [["\x6b\145\x79" => "\163\x6d\x73"]]]])];
        $zfJTm = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->indexController->method("\147\145\164\122\145\161\x75\145\163\164")->willReturn($zfJTm);
        $zfJTm->method("\147\145\164\120\141\162\141\x6d\163")->willReturn($flNKa);
        $this->indexController->method("\x69\x73\x46\x6f\x72\x6d\117\x70\x74\x69\157\x6e\102\145\x69\156\147\123\141\x76\x65\144")->with($flNKa)->willReturn(true);
        $this->twofautility->expects($this->once())->method("\x69\x73\103\x75\x73\x74\x6f\x6d\145\162\122\x65\147\x69\x73\164\145\x72\x65\144")->willReturn(true);
        $this->twofautility->method("\x63\x68\x65\x63\153\x32\146\x61\137\145\x6e\164\145\x72\x70\162\151\x73\145\120\154\141\x6e")->willReturn("\x31");
        $this->twofautility->expects($this->atLeastOnce())->method("\163\x65\x74\x53\164\157\x72\x65\x43\157\x6e\146\x69\x67");
        $this->twofautility->expects($this->once())->method("\x66\x6c\165\163\x68\103\141\x63\x68\x65");
        $this->twofautility->expects($this->once())->method("\162\x65\151\x6e\x69\164\x43\157\x6e\146\x69\x67");
        $this->messageManager->expects($this->once())->method("\141\x64\x64\x53\x75\x63\143\145\163\x73\x4d\x65\x73\x73\141\x67\145");
        $this->twofautility->expects($this->once())->method("\147\145\x74\101\144\x6d\x69\x6e\x55\x72\154")->willReturn("\162\145\x64\151\x72\x65\x63\164\55\x75\x72\x6c");
        $this->resultRedirectFactory->expects($this->any())->method("\143\x72\145\x61\164\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->expects($this->once())->method("\x73\145\x74\125\x72\154")->with("\162\145\x64\151\x72\x65\x63\164\55\x75\162\154")->willReturnSelf();
        $wGJOE = [1 => "\x47\145\156\x65\162\141\154"];
        $JGPPO = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\164\103\x6f\x64\145", "\x67\145\x74\x4e\141\x6d\145", "\x67\x65\x74\111\144"])->getMock();
        $JGPPO->method("\147\x65\164\x43\157\144\x65")->willReturn("\x62\141\163\145");
        $JGPPO->method("\x67\x65\x74\116\141\155\145")->willReturn("\x42\x61\x73\x65");
        $JGPPO->method("\147\145\x74\x49\144")->willReturn(1);
        $j3VaC = [$JGPPO];
        $this->websiteRepository->method("\147\145\x74\x4c\151\163\164")->willReturn($j3VaC);
        $aipgy = $this->createMock(\Magento\Framework\Api\SearchCriteriaInterface::class);
        $this->searchCriteriaBuilder->method("\143\162\x65\x61\164\145")->willReturn($aipgy);
        $erDVb = new class
        {
            public function getItems()
            {
                return [new class
                {
                    public function getId()
                    {
                        return 1;
                    }
                    public function getCode()
                    {
                        return "\107\145\x6e\145\162\141\x6c";
                    }
                }];
            }
        };
        $this->groupRepository->method("\x67\145\x74\x4c\151\163\x74")->with($aipgy)->willReturn($erDVb);
        $this->resultPageFactory->expects($this->any())->method("\x63\x72\145\x61\164\145")->willReturn($this->resultPage);
        $yjdso = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\x65\164\x54\151\x74\x6c\x65"])->getMock();
        $XRPe5 = $this->getMockBuilder(\stdClass::class)->addMethods(["\160\162\145\x70\x65\156\144"])->getMock();
        $this->resultPage->expects($this->any())->method("\x67\x65\x74\103\x6f\x6e\x66\x69\147")->willReturn($yjdso);
        $yjdso->expects($this->any())->method("\x67\x65\164\x54\x69\x74\x6c\x65")->willReturn($XRPe5);
        $XRPe5->expects($this->any())->method("\160\162\x65\160\x65\156\144");
        $sMBJm = $this->indexController->execute();
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $sMBJm);
    }
    public function testExecuteFormNotSubmitted()
    {
        $flNKa = [];
        $zfJTm = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->indexController->method("\x67\x65\164\x52\145\x71\165\145\x73\164")->willReturn($zfJTm);
        $zfJTm->method("\147\145\x74\120\x61\162\141\x6d\x73")->willReturn($flNKa);
        $this->indexController->method("\x69\x73\x46\x6f\x72\155\117\160\164\151\x6f\156\102\x65\x69\156\147\x53\141\x76\x65\144")->with($flNKa)->willReturn(false);
        $this->resultPageFactory->expects($this->once())->method("\143\x72\x65\141\164\145")->willReturn($this->resultPage);
        $yjdso = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\164\124\x69\x74\154\x65"])->getMock();
        $XRPe5 = $this->getMockBuilder(\stdClass::class)->addMethods(["\160\x72\145\x70\145\156\x64"])->getMock();
        $this->resultPage->expects($this->once())->method("\147\145\x74\103\x6f\x6e\x66\x69\147")->willReturn($yjdso);
        $yjdso->expects($this->once())->method("\x67\145\164\x54\x69\x74\154\145")->willReturn($XRPe5);
        $XRPe5->expects($this->once())->method("\160\x72\x65\160\x65\156\x64");
        $sMBJm = $this->indexController->execute();
        $this->assertSame($this->resultPage, $sMBJm);
    }
    public function testExecuteException()
    {
        $flNKa = ["\157\160\164\151\x6f\x6e" => "\163\141\x76\x65\x53\151\156\x67\x49\156\x53\x65\x74\164\x69\156\147\163\x5f\143\x75\x73\164\x6f\x6d\x65\x72", "\162\x75\x6c\x65\x73" => "\151\156\x76\x61\154\151\x64\x2d\x6a\163\x6f\x6e"];
        $zfJTm = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->indexController->method("\x67\x65\x74\122\145\161\165\x65\163\x74")->willReturn($zfJTm);
        $zfJTm->method("\x67\145\x74\120\x61\162\x61\155\x73")->willReturn($flNKa);
        $this->indexController->method("\151\163\x46\x6f\162\155\117\x70\x74\151\157\x6e\102\x65\x69\156\147\123\x61\166\x65\144")->with($flNKa)->willReturn(true);
        $this->twofautility->method("\x69\x73\x43\x75\x73\164\x6f\155\x65\162\x52\x65\x67\x69\x73\164\x65\x72\145\x64")->willReturn(true);
        $this->twofautility->method("\x63\x68\145\143\153\x32\146\x61\137\145\x6e\x74\x65\x72\160\x72\x69\163\145\120\154\x61\x6e")->willReturn("\61");
        $this->twofautility->method("\x73\x65\164\x53\164\x6f\162\x65\103\157\x6e\146\151\147")->willThrowException(new \Exception("\x66\x61\151\154\41"));
        $this->messageManager->expects($this->once())->method("\141\x64\144\x45\x72\x72\157\x72\x4d\145\163\163\141\x67\x65");
        $this->logger->expects($this->once())->method("\x64\145\142\165\x67");
        $this->resultPageFactory->expects($this->any())->method("\143\162\145\x61\164\x65")->willReturn($this->resultPage);
        $yjdso = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\145\x74\x54\x69\x74\x6c\145"])->getMock();
        $XRPe5 = $this->getMockBuilder(\stdClass::class)->addMethods(["\x70\x72\145\160\x65\156\144"])->getMock();
        $this->resultPage->expects($this->any())->method("\147\145\x74\x43\157\x6e\x66\x69\x67")->willReturn($yjdso);
        $yjdso->expects($this->any())->method("\147\145\x74\x54\x69\x74\154\x65")->willReturn($XRPe5);
        $XRPe5->expects($this->any())->method("\x70\x72\145\x70\x65\156\x64");
        $sMBJm = $this->indexController->execute();
        $this->assertSame($this->resultPage, $sMBJm);
    }
    public function testProcessValuesAndSaveDataCustomerNotRegistered()
    {
        $flNKa = [];
        $this->twofautility->method("\x69\163\103\165\163\164\x6f\x6d\145\162\x52\145\x67\151\163\x74\x65\x72\x65\x64")->willReturn(false);
        $this->twofautility->method("\x63\x68\x65\143\153\62\146\x61\137\x65\x6e\x74\x65\162\x70\x72\151\163\145\x50\x6c\x61\x6e")->willReturn("\x30");
        $this->messageManager->expects($this->once())->method("\x61\144\144\x45\x72\162\x6f\162\x4d\145\163\x73\x61\x67\145");
        $this->resultRedirectFactory->expects($this->once())->method("\143\x72\145\141\164\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->expects($this->once())->method("\163\x65\164\x50\x61\164\150")->with("\x6d\157\x74\167\157\x66\141\57\x61\x63\143\157\x75\156\164\x2f\x69\x6e\144\x65\170")->willReturnSelf();
        $rHFQb = new \ReflectionMethod($this->indexController, "\x70\x72\157\143\145\x73\x73\x56\x61\x6c\165\x65\163\x41\x6e\144\x53\141\166\x65\x44\141\x74\x61");
        $rHFQb->setAccessible(true);
        $sMBJm = $rHFQb->invoke($this->indexController, $flNKa);
        $this->assertSame($this->resultRedirect, $sMBJm);
    }
    public function testIsAllowedTrue()
    {
        $this->authorization->method("\151\163\101\154\x6c\x6f\x77\x65\x64")->willReturn(true);
        $rHFQb = new \ReflectionMethod($this->indexController, "\x5f\x69\163\x41\154\x6c\157\167\x65\144");
        $rHFQb->setAccessible(true);
        $this->assertTrue($rHFQb->invoke($this->indexController));
    }
    public function testIsAllowedFalse()
    {
        $this->authorization->method("\151\x73\x41\x6c\x6c\157\x77\x65\144")->willReturn(false);
        $rHFQb = new \ReflectionMethod($this->indexController, "\137\151\163\101\154\x6c\157\167\145\x64");
        $rHFQb->setAccessible(true);
        $this->assertFalse($rHFQb->invoke($this->indexController));
    }
}