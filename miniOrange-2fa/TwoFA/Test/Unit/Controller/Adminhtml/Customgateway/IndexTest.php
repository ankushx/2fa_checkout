<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Adminhtml\Customgateway;

use PHPUnit\Framework\TestCase;
class IndexTest extends TestCase
{
    private $request;
    private $context;
    private $resultPageFactory;
    private $twofautility;
    private $messageManager;
    private $logger;
    private $resultFactory;
    private $customEmail;
    private $customSMS;
    private $resultRedirectFactory;
    private $resultRedirect;
    private $authorization;
    private $resultPage;
    private $indexController;
    protected function setUp() : void
    {
        $this->request = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)->disableOriginalConstructor()->onlyMethods(["\147\x65\x74\120\x6f\x73\x74\x56\141\154\165\x65", "\147\x65\164\x50\x61\162\141\x6d\163"])->getMock();
        $this->context = $this->createMock(\Magento\Backend\App\Action\Context::class);
        $this->resultPageFactory = $this->createMock(\Magento\Framework\View\Result\PageFactory::class);
        $this->twofautility = $this->createMock(\MiniOrange\TwoFA\Helper\TwoFAUtility::class);
        $this->messageManager = $this->createMock(\Magento\Framework\Message\ManagerInterface::class);
        $this->logger = $this->createMock(\Psr\Log\LoggerInterface::class);
        $this->resultFactory = $this->createMock(\Magento\Framework\Controller\ResultFactory::class);
        $this->customEmail = $this->createMock(\MiniOrange\TwoFA\Helper\CustomEmail::class);
        $this->customSMS = $this->createMock(\MiniOrange\TwoFA\Helper\CustomSMS::class);
        $this->resultRedirectFactory = $this->createMock(\Magento\Framework\Controller\Result\RedirectFactory::class);
        $this->resultRedirect = $this->createMock(\Magento\Framework\Controller\Result\Redirect::class);
        $this->authorization = $this->createMock(\Magento\Framework\AuthorizationInterface::class);
        $this->resultPage = $this->createMock(\Magento\Backend\Model\View\Result\Page::class);
        $this->context->method("\147\145\x74\115\145\x73\x73\x61\147\145\x4d\141\x6e\x61\147\145\162")->willReturn($this->messageManager);
        $this->indexController = $this->getMockBuilder(\MiniOrange\TwoFA\Controller\Adminhtml\Customgateway\Index::class)->setConstructorArgs([$this->request, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory, $this->customEmail, $this->customSMS])->onlyMethods([])->getMock();
        $GMZ4w = new \ReflectionClass($this->indexController);
        if (!$GMZ4w->hasProperty("\x5f\x61\165\164\150\x6f\162\151\172\x61\164\x69\x6f\x6e")) {
            goto mQnPZ;
        }
        $VxrWK = $GMZ4w->getProperty("\137\x61\x75\x74\x68\x6f\162\151\172\x61\164\x69\x6f\x6e");
        $VxrWK->setAccessible(true);
        $VxrWK->setValue($this->indexController, $this->authorization);
        mQnPZ:
        if (!$GMZ4w->hasProperty("\x72\145\163\x75\x6c\164\122\x65\x64\x69\162\145\143\x74\106\x61\x63\164\x6f\162\171")) {
            goto khNPz;
        }
        $yyu4m = $GMZ4w->getProperty("\162\145\x73\x75\154\x74\x52\x65\x64\151\x72\145\143\x74\106\141\x63\164\x6f\162\171");
        $yyu4m->setAccessible(true);
        $yyu4m->setValue($this->indexController, $this->resultRedirectFactory);
        khNPz:
        if (!$GMZ4w->hasProperty("\162\145\x73\x75\x6c\164\x50\141\x67\145\106\141\143\164\157\162\x79")) {
            goto mN_K9;
        }
        $E150i = $GMZ4w->getProperty("\162\145\x73\x75\154\164\120\141\147\x65\106\141\x63\164\x6f\x72\171");
        $E150i->setAccessible(true);
        $E150i->setValue($this->indexController, $this->resultPageFactory);
        mN_K9:
    }
    public function testExecutePositiveSettingsSaved()
    {
        $fLz7l = ["\145\x6e\141\142\154\x65\137\105\x6d\141\x69\x6c\143\x75\x73\x74\x6f\155\147\x61\x74\x65\x77\x61\x79" => 1, "\x65\156\141\142\x6c\x65\x5f\x63\165\x73\164\157\155\x67\141\x74\145\x77\141\171\x5f\146\x6f\162\x45\155\141\151\154" => 1];
        $this->request->method("\147\145\x74\x50\157\x73\x74\126\x61\154\x75\x65")->willReturn($fLz7l);
        $this->twofautility->method("\x69\x73\x43\x75\163\x74\157\155\x65\x72\x52\x65\147\151\163\164\145\x72\x65\x64")->willReturn(true);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\x65\164\123\x74\x6f\162\145\x43\x6f\156\146\151\147");
        $this->twofautility->expects($this->atLeastOnce())->method("\x66\154\165\163\150\x43\x61\143\x68\145");
        $this->twofautility->expects($this->atLeastOnce())->method("\162\x65\151\156\x69\x74\x43\x6f\x6e\146\151\147");
        $this->resultPageFactory->expects($this->any())->method("\x63\162\145\x61\164\x65")->willReturn($this->resultPage);
        $ccFmK = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\164\124\151\164\x6c\145"])->getMock();
        $dnWHW = $this->getMockBuilder(\stdClass::class)->addMethods(["\160\162\145\x70\x65\x6e\144"])->getMock();
        $this->resultPage->expects($this->any())->method("\147\x65\x74\x43\157\156\146\151\x67")->willReturn($ccFmK);
        $ccFmK->expects($this->any())->method("\x67\145\164\124\x69\x74\154\145")->willReturn($dnWHW);
        $dnWHW->expects($this->any())->method("\x70\162\145\160\x65\x6e\x64");
        $dPVNE = $this->indexController->execute();
        $this->assertSame($this->resultPage, $dPVNE);
    }
    public function testExecuteCustomerNotRegistered()
    {
        $fLz7l = ["\x65\x6e\141\142\154\x65\137\x45\x6d\141\151\x6c\x63\x75\163\164\157\155\147\141\164\145\167\x61\171" => 1, "\145\x6e\141\x62\154\x65\x5f\x63\x75\163\164\157\x6d\x67\x61\x74\145\167\141\x79\x5f\x66\x6f\x72\105\x6d\x61\x69\154" => 1];
        $this->request->method("\147\145\x74\x50\x6f\x73\x74\126\x61\x6c\165\145")->willReturn($fLz7l);
        $this->twofautility->method("\151\x73\x43\165\x73\x74\157\x6d\145\x72\x52\x65\x67\151\x73\164\x65\162\x65\x64")->willReturn(false);
        $this->messageManager->expects($this->once())->method("\141\x64\144\105\162\162\x6f\x72\x4d\145\163\x73\141\x67\x65");
        $this->resultRedirectFactory->expects($this->once())->method("\x63\x72\x65\x61\164\x65")->willReturn($this->resultRedirect);
        $this->resultRedirect->expects($this->once())->method("\x73\x65\x74\120\x61\164\x68")->with("\155\x6f\x74\167\157\146\141\57\141\143\143\x6f\165\156\x74\57\151\x6e\144\145\170")->willReturnSelf();
        $aYYIX = new \ReflectionMethod($this->indexController, "\x70\162\x6f\143\x65\x73\x73\126\x61\x6c\165\x65\x73\101\x6e\x64\x53\x61\x76\145\104\x61\164\141");
        $aYYIX->setAccessible(true);
        $dPVNE = $aYYIX->invoke($this->indexController, $fLz7l);
        $this->assertSame($this->resultRedirect, $dPVNE);
    }
    public function testProcessValuesAndSaveData_WhatsappSubmit()
    {
        $fLz7l = ["\167\x68\141\x74\163\141\160\160\x5f\x73\x75\142\155\x69\x74" => 1, "\x70\x68\x6f\156\x65\137\x6e\165\155\142\x65\162\137\x69\x64" => "\160\x69\x64", "\164\145\155\x70\x6c\141\x74\145\137\156\141\155\x65" => "\x74\x70\154", "\x74\x65\155\x70\154\x61\164\x65\137\154\x61\x6e\147\x75\x61\147\x65" => "\145\156", "\141\143\x63\x65\x73\163\137\164\x6f\x6b\x65\x6e" => "\x74\x6f\153\x65\156", "\x6f\x74\160\137\x6c\145\x6e\x67\164\150" => 6];
        $this->twofautility->method("\151\x73\103\165\x73\x74\157\155\x65\162\122\x65\147\x69\163\x74\x65\x72\x65\x64")->willReturn(true);
        $this->twofautility->expects($this->atLeastOnce())->method("\163\x65\x74\123\x74\x6f\162\145\103\157\156\x66\x69\147");
        $this->twofautility->expects($this->atLeastOnce())->method("\146\154\x75\163\x68\103\141\x63\150\x65");
        $this->twofautility->expects($this->atLeastOnce())->method("\162\145\x69\x6e\x69\x74\x43\157\x6e\146\x69\x67");
        $this->messageManager->expects($this->once())->method("\141\144\x64\123\165\143\143\x65\163\x73\x4d\145\163\163\x61\147\145");
        $aYYIX = new \ReflectionMethod($this->indexController, "\x70\162\x6f\143\x65\163\x73\126\141\154\x75\145\163\x41\x6e\144\x53\141\166\145\x44\141\164\141");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_WhatsappSubmitDelete()
    {
        $fLz7l = ["\x77\150\x61\x74\163\x61\160\x70\x5f\163\x75\x62\x6d\x69\164\137\x64\145\x6c\145\164\x65" => 1];
        $this->twofautility->method("\151\163\103\165\x73\164\x6f\x6d\145\x72\x52\145\x67\x69\163\164\145\x72\145\144")->willReturn(true);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\x65\x74\123\x74\157\162\x65\x43\157\156\146\x69\147");
        $this->twofautility->expects($this->atLeastOnce())->method("\x66\154\x75\x73\150\x43\141\143\150\x65");
        $this->twofautility->expects($this->atLeastOnce())->method("\x72\x65\151\x6e\151\x74\103\x6f\156\146\151\x67");
        $this->messageManager->expects($this->once())->method("\141\x64\144\x53\165\x63\143\145\163\x73\x4d\x65\x73\x73\141\147\145");
        $aYYIX = new \ReflectionMethod($this->indexController, "\160\x72\157\x63\x65\x73\x73\126\141\154\x75\145\163\x41\156\144\x53\x61\x76\x65\104\x61\x74\x61");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_TestSmsWhatsapp_Success()
    {
        $fLz7l = ["\164\x65\163\164\137\163\155\163\137\x77\150\141\164\163\141\x70\160" => 1, "\143\x75\x73\164\157\155\x5f\147\141\164\145\x77\x61\x79\x5f\164\x65\x73\x74\137\x6d\157\142\151\x6c\x65\x4e\x75\x6d\142\x65\162\x5f\x77\x68\141\x74\163\x61\160\160" => "\x31\62\63"];
        $this->twofautility->method("\x69\x73\103\x75\163\x74\x6f\x6d\145\162\122\145\x67\x69\x73\164\145\x72\x65\144")->willReturn(true);
        $this->twofautility->method("\x43\165\163\x74\x6f\x6d\x67\141\164\145\167\141\171\137\107\145\x6e\145\162\141\164\145\x4f\x54\120")->willReturn("\x6f\164\160");
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\145\164\x53\164\157\162\x65\103\157\x6e\146\x69\147");
        $this->twofautility->expects($this->atLeastOnce())->method("\146\x6c\165\163\x68\103\141\143\x68\145");
        $this->twofautility->expects($this->atLeastOnce())->method("\162\x65\151\156\x69\x74\x43\157\x6e\x66\151\x67");
        $this->twofautility->method("\163\145\156\144\x5f\x63\165\163\x74\x6f\x6d\147\141\164\145\167\141\x79\x5f\167\x68\x61\164\x73\141\160\x70")->willReturn(["\163\x74\141\164\x75\x73" => "\123\125\103\x43\x45\123\123"]);
        $this->messageManager->expects($this->once())->method("\141\144\144\x53\x75\x63\143\145\x73\163\x4d\145\163\163\x61\147\145");
        $aYYIX = new \ReflectionMethod($this->indexController, "\160\162\x6f\143\145\163\163\126\x61\154\165\145\163\x41\156\x64\123\x61\x76\145\x44\x61\x74\141");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_TestSmsWhatsapp_Failed()
    {
        $fLz7l = ["\164\x65\x73\164\137\x73\x6d\163\137\x77\150\141\164\163\141\160\160" => 1, "\143\x75\x73\164\x6f\x6d\x5f\147\x61\164\145\x77\x61\171\x5f\164\x65\163\164\137\x6d\157\x62\x69\154\x65\x4e\x75\x6d\x62\x65\162\x5f\167\150\x61\164\x73\x61\x70\x70" => "\61\x32\x33"];
        $this->twofautility->method("\x69\163\x43\165\163\164\x6f\155\145\162\122\x65\x67\151\163\164\145\x72\x65\x64")->willReturn(true);
        $this->twofautility->method("\103\x75\x73\164\157\x6d\147\x61\164\145\167\x61\171\137\x47\x65\x6e\145\x72\x61\x74\145\117\x54\120")->willReturn("\x6f\164\x70");
        $this->twofautility->expects($this->atLeastOnce())->method("\163\x65\x74\x53\x74\157\162\x65\x43\157\156\146\x69\x67");
        $this->twofautility->expects($this->atLeastOnce())->method("\146\154\165\x73\x68\x43\141\x63\x68\x65");
        $this->twofautility->expects($this->atLeastOnce())->method("\x72\x65\x69\x6e\151\x74\103\x6f\x6e\x66\x69\x67");
        $this->twofautility->method("\x73\x65\x6e\144\x5f\x63\165\x73\164\157\x6d\x67\141\x74\145\167\x61\171\x5f\x77\150\x61\164\x73\141\160\x70")->willReturn(["\163\164\141\x74\165\x73" => "\x46\x41\111\114\105\104", "\x6d\x65\x73\163\x61\147\145" => "\x66\141\151\x6c"]);
        $this->messageManager->expects($this->once())->method("\x61\x64\x64\105\162\x72\157\162\x4d\145\x73\x73\x61\147\145");
        $aYYIX = new \ReflectionMethod($this->indexController, "\160\162\x6f\x63\x65\163\x73\x56\141\x6c\165\x65\x73\x41\156\144\x53\x61\x76\145\104\x61\164\x61");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_TestSmsWhatsapp_Unknown()
    {
        $fLz7l = ["\x74\x65\163\164\x5f\x73\x6d\163\137\167\x68\x61\164\163\x61\x70\160" => 1, "\x63\x75\163\x74\157\155\137\x67\x61\x74\x65\x77\x61\171\x5f\x74\x65\x73\164\137\155\157\142\x69\x6c\145\x4e\x75\x6d\x62\145\x72\137\167\150\141\x74\163\141\x70\x70" => "\x31\62\63"];
        $this->twofautility->method("\151\x73\x43\x75\x73\x74\x6f\155\145\x72\122\x65\147\x69\163\164\x65\x72\145\x64")->willReturn(true);
        $this->twofautility->method("\x43\165\x73\164\157\155\x67\141\x74\145\x77\x61\171\x5f\x47\145\x6e\145\x72\141\164\x65\x4f\124\120")->willReturn("\x6f\x74\160");
        $this->twofautility->expects($this->atLeastOnce())->method("\163\145\164\x53\x74\x6f\162\145\103\157\x6e\146\x69\147");
        $this->twofautility->expects($this->atLeastOnce())->method("\x66\154\165\163\x68\x43\141\143\x68\x65");
        $this->twofautility->expects($this->atLeastOnce())->method("\162\145\x69\x6e\x69\164\x43\x6f\x6e\x66\x69\147");
        $this->twofautility->method("\x73\x65\156\x64\x5f\x63\x75\x73\x74\x6f\x6d\147\141\x74\145\x77\141\x79\x5f\167\x68\141\164\x73\x61\160\x70")->willReturn(["\x73\164\141\164\x75\163" => "\106\101\111\114\x45\x44"]);
        $this->messageManager->expects($this->once())->method("\x61\x64\x64\x45\162\x72\x6f\x72\x4d\x65\x73\163\141\x67\145");
        $aYYIX = new \ReflectionMethod($this->indexController, "\x70\162\157\x63\145\x73\163\126\x61\x6c\165\x65\163\x41\x6e\144\x53\141\x76\x65\104\141\x74\141");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_TestSmsWhatsapp_Null()
    {
        $fLz7l = ["\164\x65\163\x74\x5f\x73\x6d\x73\x5f\x77\x68\x61\x74\x73\x61\x70\160" => 1, "\x63\165\x73\164\157\155\x5f\147\x61\164\145\x77\141\x79\x5f\x74\145\x73\164\x5f\x6d\157\x62\151\154\x65\116\165\155\142\145\162\137\167\150\x61\164\163\141\x70\x70" => "\61\62\x33"];
        $this->twofautility->method("\x69\163\x43\165\163\164\x6f\155\145\162\122\145\x67\151\163\164\x65\162\145\x64")->willReturn(true);
        $this->twofautility->method("\x43\x75\163\164\157\155\147\141\164\145\x77\x61\x79\137\107\145\x6e\x65\x72\141\164\145\117\124\120")->willReturn("\157\164\x70");
        $this->twofautility->expects($this->atLeastOnce())->method("\163\145\164\123\164\x6f\162\x65\103\157\156\146\151\147");
        $this->twofautility->expects($this->atLeastOnce())->method("\146\x6c\165\163\x68\x43\141\x63\x68\x65");
        $this->twofautility->expects($this->atLeastOnce())->method("\x72\x65\151\156\x69\164\x43\x6f\x6e\146\151\147");
        $this->twofautility->method("\163\145\x6e\x64\137\x63\165\163\164\x6f\155\147\141\164\145\x77\x61\171\x5f\x77\150\141\164\x73\141\160\x70")->willReturn(null);
        $this->messageManager->expects($this->once())->method("\x61\x64\144\105\x72\x72\157\162\115\x65\x73\163\x61\x67\145");
        $aYYIX = new \ReflectionMethod($this->indexController, "\x70\162\157\143\145\163\163\126\x61\x6c\165\x65\163\101\x6e\x64\123\141\166\145\x44\141\x74\141");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_TestEmail_Success()
    {
        $fLz7l = ["\164\145\163\164\x5f\145\x6d\141\x69\x6c" => 1, "\143\165\163\164\157\x6d\x5f\x67\x61\x74\x65\x77\x61\171\x5f\x73\145\156\x64\137\x74\157" => "\164\157\x40\x65\170\x61\155\160\154\x65\56\143\157\155"];
        $this->twofautility->method("\x69\x73\x43\x75\163\x74\157\155\x65\162\x52\145\147\151\x73\x74\x65\x72\x65\144")->willReturn(true);
        $this->twofautility->method("\147\x65\164\x53\x74\x6f\x72\145\103\157\156\x66\151\147")->willReturn("\146\x72\157\155\100\x65\x78\141\x6d\160\x6c\145\x2e\x63\157\155");
        $this->twofautility->method("\x43\165\x73\x74\x6f\155\147\x61\164\x65\x77\x61\x79\137\107\145\x6e\145\x72\x61\x74\145\x4f\124\120")->willReturn("\x6f\164\x70");
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\x65\x74\123\x74\157\162\145\x43\157\156\x66\151\147");
        $this->twofautility->expects($this->atLeastOnce())->method("\x66\154\165\163\x68\x43\141\x63\x68\145");
        $this->customEmail->method("\163\x65\x6e\x64\103\165\163\x74\x6f\x6d\x67\x61\x74\x65\x77\141\171\x45\x6d\x61\151\154")->willReturn(["\x73\164\x61\x74\x75\x73" => "\x53\125\103\x43\x45\123\x53"]);
        $this->messageManager->expects($this->once())->method("\141\x64\x64\123\x75\143\143\145\x73\x73\x4d\x65\163\x73\141\x67\145");
        $aYYIX = new \ReflectionMethod($this->indexController, "\160\162\157\x63\x65\163\163\x56\141\154\165\x65\x73\x41\156\144\x53\x61\166\145\104\x61\x74\x61");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_TestEmail_Error()
    {
        $fLz7l = ["\164\x65\163\x74\x5f\145\155\x61\151\154" => 1, "\143\x75\163\164\x6f\x6d\137\147\x61\x74\145\x77\x61\x79\x5f\x73\145\x6e\x64\137\164\157" => "\x74\157\100\145\170\x61\x6d\x70\154\x65\56\143\157\x6d"];
        $this->twofautility->method("\151\163\103\165\x73\x74\x6f\155\145\162\122\145\x67\x69\x73\164\x65\162\x65\144")->willReturn(true);
        $this->twofautility->method("\x67\x65\164\123\164\x6f\x72\x65\103\157\156\146\x69\x67")->willReturn("\146\x72\157\x6d\100\145\170\141\155\x70\154\145\56\143\157\155");
        $this->twofautility->method("\103\165\163\x74\157\x6d\147\141\164\x65\167\141\x79\x5f\107\x65\156\x65\x72\141\164\x65\117\124\x50")->willReturn("\x6f\164\x70");
        $this->twofautility->expects($this->atLeastOnce())->method("\163\x65\x74\x53\164\157\x72\x65\103\x6f\x6e\x66\151\x67");
        $this->twofautility->expects($this->atLeastOnce())->method("\x66\x6c\165\x73\x68\x43\x61\143\150\145");
        $this->customEmail->method("\x73\145\x6e\x64\103\165\x73\164\157\155\147\x61\x74\x65\x77\x61\171\105\155\141\151\154")->willReturn(["\163\x74\141\x74\x75\x73" => "\x46\101\x49\x4c\105\x44", "\164\x65\x63\150\x5f\155\x65\163\x73\x61\x67\145" => "\x66\x61\x69\x6c"]);
        $this->messageManager->expects($this->once())->method("\141\x64\144\105\x72\162\157\x72\x4d\145\163\x73\141\x67\x65");
        $aYYIX = new \ReflectionMethod($this->indexController, "\x70\162\x6f\x63\145\163\163\126\x61\154\165\145\163\x41\x6e\x64\123\x61\x76\x65\104\141\x74\x61");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_SmsSubmit_Twilio()
    {
        $fLz7l = ["\163\x6d\163\137\x73\165\x62\x6d\x69\164" => 1, "\x63\x75\163\164\157\155\x5f\147\141\164\145\167\141\171\x5f\141\x70\151\120\162\157\x76\x69\144\145\x72\x5f\x73\x6d\x73" => "\164\x77\151\x6c\151\x6f", "\x63\165\x73\164\x6f\155\137\147\x61\x74\x65\167\141\x79\137\x74\x77\x69\154\151\x6f\x5f\163\x69\144" => "\163\x69\x64", "\x63\165\163\x74\157\155\x5f\147\x61\164\x65\167\x61\171\137\164\167\151\x6c\x69\157\x5f\x74\157\153\x65\x6e" => "\164\x6f\153\145\x6e", "\x63\165\x73\164\157\155\x5f\147\x61\164\145\167\141\x79\x5f\164\x77\151\154\151\157\x5f\160\x68\137\156\x75\x6d\142\x65\162" => "\x6e\165\x6d"];
        $this->twofautility->method("\151\x73\x43\165\x73\164\x6f\x6d\x65\162\x52\145\147\x69\x73\x74\145\x72\x65\144")->willReturn(true);
        $this->request->method("\147\x65\164\x50\x61\x72\x61\x6d\163")->willReturn([]);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\145\164\123\164\x6f\162\x65\x43\x6f\156\146\x69\147");
        $this->twofautility->expects($this->atLeastOnce())->method("\x66\154\165\x73\150\103\141\x63\150\x65");
        $this->twofautility->expects($this->atLeastOnce())->method("\162\x65\x69\x6e\x69\x74\x43\x6f\x6e\146\x69\147");
        $this->messageManager->expects($this->once())->method("\141\x64\x64\123\165\143\x63\x65\x73\163\115\x65\x73\163\x61\147\x65");
        $aYYIX = new \ReflectionMethod($this->indexController, "\160\162\x6f\x63\145\x73\163\126\141\x6c\x75\x65\x73\x41\156\x64\123\x61\166\145\x44\x61\164\141");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_SmsSubmit_GetMethod()
    {
        $fLz7l = ["\x73\x6d\x73\137\163\165\142\x6d\151\164" => 1, "\143\165\x73\164\157\155\x5f\x67\141\164\x65\167\x61\x79\137\x61\x70\151\x50\162\x6f\x76\x69\x64\x65\x72\137\x73\x6d\163" => "\x67\145\164\x4d\x65\164\x68\157\x64", "\x63\165\163\164\157\x6d\x5f\147\141\164\x65\167\x61\x79\137\147\x65\x74\x6d\x65\164\x68\157\x64\125\122\114" => "\165\162\154"];
        $this->twofautility->method("\x69\x73\103\x75\163\164\x6f\x6d\x65\x72\122\145\x67\151\x73\x74\145\162\x65\144")->willReturn(true);
        $this->request->method("\147\x65\164\120\x61\162\141\155\x73")->willReturn([]);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\x65\164\123\164\157\x72\x65\103\157\156\x66\x69\147");
        $this->twofautility->expects($this->atLeastOnce())->method("\146\x6c\x75\163\x68\x43\x61\x63\150\145");
        $this->twofautility->expects($this->atLeastOnce())->method("\x72\145\x69\x6e\x69\164\x43\157\x6e\x66\151\x67");
        $this->messageManager->expects($this->once())->method("\x61\144\x64\123\165\143\x63\145\x73\163\x4d\145\163\x73\141\x67\x65");
        $aYYIX = new \ReflectionMethod($this->indexController, "\160\x72\157\143\145\163\163\x56\141\154\x75\x65\x73\x41\156\144\x53\141\x76\x65\104\141\164\x61");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_SmsSubmit_PostMethod()
    {
        $fLz7l = ["\163\155\x73\x5f\x73\x75\142\155\151\164" => 1, "\143\165\x73\164\157\155\137\x67\x61\164\x65\x77\x61\171\137\141\160\151\x50\x72\x6f\x76\x69\144\145\162\137\163\155\163" => "\x70\157\163\x74\x4d\145\164\150\x6f\x64", "\x63\x75\x73\x74\x6f\155\x5f\147\141\164\x65\x77\141\x79\x5f\x70\157\x73\x74\155\x65\x74\150\x6f\x64\x55\122\114" => "\x75\162\x6c", "\x70\157\163\x74\137\155\x65\x74\150\x6f\x64\x5f\160\150\x6f\x6e\145\137\x61\164\x74\162" => "\160\x68\x6f\156\145", "\160\157\163\x74\x5f\x6d\145\164\150\x6f\144\x5f\x6d\x65\x73\x73\x61\x67\145\137\x61\x74\164\x72" => "\155\x73\x67", "\x64\x79\156\x61\x6d\151\143\x5f\x61\x74\164\162\x69\142\165\x74\x65\163" => [["\x6e\141\155\x65" => "\146\x6f\157", "\166\x61\x6c\x75\x65" => "\x62\x61\162"], ["\x6e\x61\155\145" => '', "\166\x61\x6c\x75\145" => '']]];
        $this->twofautility->method("\x69\163\x43\165\x73\x74\x6f\155\145\162\122\145\x67\x69\163\x74\x65\x72\145\x64")->willReturn(true);
        $this->request->method("\x67\x65\x74\x50\141\162\141\155\x73")->willReturn([]);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\x65\164\x53\x74\x6f\x72\x65\x43\x6f\x6e\x66\x69\x67");
        $this->twofautility->expects($this->atLeastOnce())->method("\x66\x6c\x75\163\x68\x43\x61\143\150\x65");
        $this->twofautility->expects($this->atLeastOnce())->method("\162\x65\x69\156\151\164\103\x6f\156\x66\x69\147");
        $this->messageManager->expects($this->once())->method("\x61\x64\144\x53\x75\x63\x63\145\x73\x73\115\x65\163\x73\141\x67\x65");
        $aYYIX = new \ReflectionMethod($this->indexController, "\x70\x72\x6f\x63\145\x73\163\126\x61\154\165\145\163\101\x6e\144\x53\x61\x76\x65\x44\x61\164\141");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_SmsSubmitDelete_Twilio()
    {
        $fLz7l = ["\163\155\x73\137\163\165\x62\155\x69\x74\137\x64\145\154\x65\x74\145" => 1, "\x63\x75\x73\x74\x6f\155\137\x67\141\164\x65\x77\141\x79\x5f\x61\160\151\x50\162\157\166\x69\144\145\162\137\163\x6d\x73" => "\x74\x77\x69\154\x69\157"];
        $this->twofautility->method("\151\163\x43\165\x73\x74\157\x6d\145\162\x52\x65\x67\x69\x73\164\x65\162\x65\x64")->willReturn(true);
        $this->request->method("\x67\x65\164\x50\x61\x72\141\155\163")->willReturn([]);
        $this->twofautility->expects($this->atLeastOnce())->method("\163\x65\x74\x53\164\157\162\x65\x43\x6f\x6e\x66\x69\x67");
        $this->twofautility->expects($this->atLeastOnce())->method("\x66\154\x75\163\x68\103\141\x63\x68\x65");
        $this->twofautility->expects($this->atLeastOnce())->method("\162\x65\x69\156\151\x74\x43\157\x6e\146\x69\x67");
        $this->messageManager->expects($this->once())->method("\141\144\x64\x53\165\143\143\x65\x73\x73\x4d\x65\x73\163\x61\147\x65");
        $aYYIX = new \ReflectionMethod($this->indexController, "\160\x72\x6f\x63\145\x73\163\x56\x61\x6c\x75\x65\163\x41\156\x64\x53\141\166\145\x44\141\x74\x61");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_ClearPostSMSParamField()
    {
        $fLz7l = ["\143\154\x65\x61\x72\137\160\x6f\163\164\123\115\123\x50\141\162\x61\155\x5f\x66\x69\145\154\x64" => 1];
        $this->twofautility->method("\151\x73\103\165\163\164\157\155\x65\x72\122\145\x67\x69\163\164\x65\162\x65\x64")->willReturn(true);
        $this->twofautility->expects($this->atLeastOnce())->method("\163\145\x74\x53\x74\157\162\145\103\157\156\146\151\x67");
        $this->twofautility->expects($this->atLeastOnce())->method("\146\154\165\163\x68\x43\x61\x63\150\145");
        $this->twofautility->expects($this->atLeastOnce())->method("\162\x65\x69\x6e\x69\164\x43\x6f\x6e\x66\x69\x67");
        $aYYIX = new \ReflectionMethod($this->indexController, "\x70\x72\x6f\143\x65\163\x73\126\141\x6c\165\x65\x73\101\x6e\144\123\x61\166\x65\104\141\x74\x61");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_TestSms_Success()
    {
        $fLz7l = ["\164\145\x73\x74\137\163\x6d\163" => 1, "\x63\165\163\164\x6f\x6d\137\147\141\164\x65\x77\141\x79\137\164\145\x73\x74\137\x6d\x6f\x62\x69\x6c\145\116\165\155\x62\x65\162" => "\x31\x32\x33"];
        $this->twofautility->method("\x69\163\103\x75\x73\x74\x6f\x6d\145\162\x52\145\147\x69\163\x74\x65\162\145\144")->willReturn(true);
        $this->twofautility->method("\103\x75\x73\164\x6f\155\x67\141\164\145\x77\141\x79\x5f\x47\x65\156\145\162\141\164\145\x4f\124\x50")->willReturn("\157\164\x70");
        $this->twofautility->expects($this->atLeastOnce())->method("\163\145\164\123\x74\x6f\x72\x65\x43\157\x6e\x66\151\147");
        $this->twofautility->expects($this->atLeastOnce())->method("\146\154\x75\163\150\103\x61\143\x68\x65");
        $this->twofautility->expects($this->atLeastOnce())->method("\x72\145\x69\x6e\x69\x74\103\x6f\x6e\146\x69\147");
        $this->customSMS->method("\163\145\x6e\144\x5f\143\165\x73\164\157\x6d\147\x61\x74\145\x77\141\171\137\x73\x6d\x73")->willReturn(["\163\x74\141\164\165\x73" => "\x53\125\103\103\105\x53\123"]);
        $this->messageManager->expects($this->once())->method("\x61\x64\x64\x53\165\x63\x63\x65\163\x73\x4d\145\x73\x73\141\147\x65");
        $aYYIX = new \ReflectionMethod($this->indexController, "\x70\162\x6f\x63\x65\163\x73\x56\141\x6c\165\x65\163\101\x6e\x64\123\x61\x76\x65\x44\141\x74\x61");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_TestSms_Error()
    {
        $fLz7l = ["\164\145\x73\x74\137\x73\155\x73" => 1, "\x63\165\x73\164\157\x6d\137\147\141\x74\x65\x77\x61\x79\137\x74\x65\163\x74\137\155\157\x62\151\154\145\116\x75\155\142\145\x72" => "\61\x32\63"];
        $this->twofautility->method("\151\163\x43\x75\x73\x74\157\155\x65\162\122\x65\x67\x69\163\164\x65\x72\145\144")->willReturn(true);
        $this->twofautility->method("\103\x75\163\x74\157\155\x67\141\x74\145\167\x61\x79\137\x47\x65\156\x65\x72\x61\x74\145\x4f\124\x50")->willReturn("\157\x74\160");
        $this->twofautility->expects($this->atLeastOnce())->method("\163\145\164\x53\x74\x6f\x72\145\x43\157\x6e\x66\151\147");
        $this->twofautility->expects($this->atLeastOnce())->method("\x66\154\165\163\x68\x43\141\143\x68\x65");
        $this->twofautility->expects($this->atLeastOnce())->method("\x72\145\x69\x6e\x69\x74\103\x6f\x6e\146\151\x67");
        $this->customSMS->method("\x73\x65\156\144\x5f\x63\x75\x73\x74\157\155\x67\141\164\x65\x77\141\x79\137\x73\x6d\163")->willReturn(["\163\164\141\164\165\x73" => "\106\101\111\x4c\x45\x44", "\164\145\x63\x68\137\155\x65\x73\163\x61\x67\145" => "\x66\x61\151\x6c"]);
        $this->messageManager->expects($this->once())->method("\x61\x64\144\x45\x72\x72\157\162\x4d\145\x73\x73\x61\x67\x65");
        $aYYIX = new \ReflectionMethod($this->indexController, "\x70\162\157\143\145\163\x73\126\141\154\165\x65\x73\101\156\144\x53\x61\166\x65\x44\x61\x74\x61");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_CustomgatewayEmailConfiguration()
    {
        $fLz7l = ["\143\x75\x73\164\x6f\x6d\x67\141\x74\x65\x77\141\x79\x5f\x65\155\x61\x69\x6c\x43\x6f\x6e\x66\151\147\165\162\x61\164\x69\x6f\x6e" => 1, "\143\x75\163\x74\x6f\155\x5f\x67\141\164\x65\167\x61\171\137\150\157\x73\164\x6e\141\155\x65" => "\x68\x6f\163\x74", "\x63\x75\163\164\x6f\x6d\x5f\147\x61\x74\x65\167\141\x79\137\x70\x6f\162\164" => "\62\65", "\143\x75\x73\164\157\155\137\147\x61\x74\145\167\x61\171\137\160\162\x6f\x74\x6f\x63\x6f\x6c" => "\163\155\x74\x70", "\x63\x75\163\x74\157\155\137\147\x61\164\x65\167\x61\171\137\141\x75\x74\x68\145\x6e\164\x69\x63\x61\164\x69\157\156" => "\x70\154\x61\x69\x6e", "\143\165\x73\x74\157\155\137\x67\x61\x74\145\x77\x61\x79\137\x75\x73\145\x72\156\x61\x6d\145" => "\165\163\x65\162", "\143\165\163\164\157\x6d\137\x67\x61\x74\145\167\141\171\x5f\x70\141\163\x73\167\157\162\144" => "\160\141\x73\x73", "\143\165\163\x74\157\155\107\141\164\x65\167\141\171\x5f\146\162\157\x6d\137\143\157\156\146\151\x67\165\x72\x61\164\151\157\156" => "\146\162\x6f\x6d", "\x63\165\163\x74\157\155\107\x61\164\145\x77\x61\171\137\x6e\141\155\x65\x5f\x63\157\156\146\x69\147\x75\x72\x61\x74\151\x6f\156" => "\x6e\x61\155\x65", "\x63\x75\163\164\157\x6d\x47\141\164\145\x77\x61\x79\x5f\157\x74\160\x4c\145\x6e\147\164\150\x5f\143\x6f\x6e\146\151\147\x75\162\x61\x74\x69\x6f\x6e" => 6, "\x65\x6d\141\x69\x6c\x5f\164\145\x6d\x70\154\x61\x74\x65" => "\164\160\x6c"];
        $this->twofautility->method("\151\x73\103\165\x73\164\x6f\x6d\145\x72\122\x65\147\x69\x73\164\x65\162\x65\x64")->willReturn(true);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\x65\164\x53\164\157\x72\145\x43\157\156\x66\x69\x67");
        $this->twofautility->expects($this->atLeastOnce())->method("\146\154\x75\x73\150\x43\x61\x63\x68\145");
        $this->twofautility->expects($this->atLeastOnce())->method("\x72\145\151\156\x69\164\x43\157\156\x66\151\x67");
        $this->messageManager->expects($this->once())->method("\x61\144\x64\123\165\x63\x63\x65\x73\163\x4d\x65\163\163\x61\x67\145");
        $aYYIX = new \ReflectionMethod($this->indexController, "\x70\162\157\x63\x65\163\163\126\141\154\165\145\163\101\x6e\144\123\x61\166\x65\104\141\x74\x61");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_CustomgatewayEmailConfigurationDelete()
    {
        $fLz7l = ["\x63\x75\163\164\157\x6d\147\141\x74\x65\x77\x61\x79\x5f\x65\155\141\x69\154\103\157\156\x66\151\147\165\162\141\164\151\157\x6e\x5f\144\x65\154\145\164\145" => 1, "\x63\x75\x73\x74\157\155\137\147\x61\164\145\x77\x61\171\x5f\160\162\x6f\x74\x6f\143\x6f\154" => "\163\x6d\x74\160", "\x63\165\x73\164\157\155\137\x67\x61\164\145\167\x61\171\x5f\141\165\164\150\x65\x6e\164\x69\143\141\164\151\x6f\x6e" => "\160\x6c\141\151\156", "\x63\x75\x73\164\157\155\x47\x61\164\145\x77\x61\171\x5f\157\164\160\x4c\145\x6e\147\164\150\137\x63\x6f\x6e\x66\151\147\x75\x72\x61\164\x69\157\x6e" => 6];
        $this->twofautility->method("\x69\163\103\165\x73\x74\x6f\x6d\145\162\122\x65\147\x69\x73\x74\x65\x72\x65\x64")->willReturn(true);
        $this->twofautility->expects($this->atLeastOnce())->method("\163\x65\x74\123\x74\x6f\x72\145\x43\157\x6e\x66\x69\x67");
        $this->twofautility->expects($this->atLeastOnce())->method("\146\154\165\x73\150\103\141\x63\150\145");
        $this->twofautility->expects($this->atLeastOnce())->method("\162\145\x69\x6e\x69\164\103\157\x6e\146\x69\147");
        $this->messageManager->expects($this->once())->method("\141\144\x64\123\165\143\x63\x65\163\x73\x4d\145\163\x73\141\147\145");
        $aYYIX = new \ReflectionMethod($this->indexController, "\160\x72\157\143\x65\x73\163\x56\141\x6c\x75\145\x73\101\x6e\x64\123\x61\166\x65\x44\141\164\x61");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
    public function testProcessValuesAndSaveData_CustomgatewaySmsConfiguration()
    {
        $fLz7l = ["\x63\x75\163\x74\157\x6d\x67\x61\x74\145\x77\141\x79\137\x73\x6d\x73\103\157\x6e\146\151\147\x75\162\x61\164\151\157\156" => 1, "\143\x75\163\x74\x6f\x6d\x47\141\x74\145\167\141\171\x5f\155\x65\163\x73\x61\147\x65\137\123\115\123\x63\157\x6e\x66\x69\147\x75\162\x61\164\151\157\156" => "\x6d\163\147", "\x63\x75\x73\164\157\x6d\107\141\x74\x65\167\x61\x79\x5f\x6f\x74\x70\x4c\145\x6e\x67\x74\x68\137\x63\x6f\156\x66\151\x67\x75\x72\x61\164\x69\157\x6e" => 6];
        $this->twofautility->method("\x69\163\103\165\163\x74\157\155\x65\x72\x52\x65\x67\x69\163\x74\x65\162\145\x64")->willReturn(true);
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\x65\x74\x53\164\157\x72\145\103\x6f\156\146\x69\x67");
        $this->twofautility->expects($this->atLeastOnce())->method("\146\154\165\163\x68\103\x61\x63\150\145");
        $this->twofautility->expects($this->atLeastOnce())->method("\x72\x65\x69\x6e\x69\x74\x43\157\x6e\x66\x69\147");
        $aYYIX = new \ReflectionMethod($this->indexController, "\x70\162\x6f\x63\x65\x73\x73\126\x61\x6c\165\x65\163\101\156\x64\123\x61\x76\145\104\x61\164\141");
        $aYYIX->setAccessible(true);
        $aYYIX->invoke($this->indexController, $fLz7l);
    }
}