<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Adminhtml\Usermanagement;

use MiniOrange\TwoFA\Controller\Adminhtml\Usermanagement\Index;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
class IndexTest extends TestCase
{
    private $request;
    private $context;
    private $resultPageFactory;
    private $twofautility;
    private $messageManager;
    private $logger;
    private $resultFactory;
    private $indexController;
    protected function setUp() : void
    {
        $this->request = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)->onlyMethods(["\x67\x65\164\x50\x6f\163\164\x56\x61\154\x75\145"])->disableOriginalConstructor()->getMock();
        $this->context = $this->createMock(\Magento\Backend\App\Action\Context::class);
        $this->resultPageFactory = $this->createMock(\Magento\Framework\View\Result\PageFactory::class);
        $this->twofautility = $this->createMock(\MiniOrange\TwoFA\Helper\TwoFAUtility::class);
        $this->messageManager = $this->createMock(\Magento\Framework\Message\ManagerInterface::class);
        $this->logger = $this->createMock(\Psr\Log\LoggerInterface::class);
        $this->resultFactory = $this->createMock(\Magento\Framework\Controller\ResultFactory::class);
        $this->context->method("\x67\x65\164\x4d\x65\x73\x73\x61\x67\x65\115\141\x6e\x61\x67\x65\x72")->willReturn($this->messageManager);
        $this->indexController = new Index($this->request, $this->context, $this->resultPageFactory, $this->twofautility, $this->messageManager, $this->logger, $this->resultFactory);
        $I5myu = new ReflectionClass($this->indexController);
        foreach (["\x6c\157\x67\147\145\x72" => $this->logger] as $ZqGIm => $nMjCA) {
            if (!$I5myu->hasProperty($ZqGIm)) {
                goto YJsqL;
            }
            $W_JHz = $I5myu->getProperty($ZqGIm);
            $W_JHz->setAccessible(true);
            $W_JHz->setValue($this->indexController, $nMjCA);
            YJsqL:
            SewsY:
        }
        G8Cgn:
    }
    public function testExecutePositiveFlowNoFormOption()
    {
        $this->request->method("\147\145\164\120\157\163\x74\126\x61\x6c\165\x65")->willReturn([]);
        $NgGdy = $this->getMockResultPage();
        $this->resultPageFactory->method("\x63\162\x65\x61\164\145")->willReturn($NgGdy);
        $TKulV = $this->indexController->execute();
        $this->assertSame($NgGdy, $TKulV);
    }
    public function testExecuteResetSelectedUsersPositive()
    {
        $m2n_F = [["\145\x6d\141\x69\154" => "\141\x40\142\56\143\x6f\x6d", "\167\145\142\x73\151\164\145\137\151\144" => 1, "\x69\x64" => 10], ["\145\155\x61\151\154" => "\x63\100\144\x2e\143\x6f\x6d", "\167\145\x62\x73\151\164\x65\x5f\x69\144" => 2, "\x69\144" => 20]];
        $nHM1D = ["\157\x70\164\x69\x6f\156" => "\x73\141\166\x65", "\162\x65\163\145\164\x5f\163\x65\154\x65\143\x74\x65\144\x5f\165\x73\x65\x72\x73" => true, "\x61\154\154\x5f\165\163\x65\x72\163\54\x77\145\x62\163\151\x74\x65\x5f\x69\x64" => json_encode($m2n_F)];
        $this->request->method("\x67\145\164\120\x6f\163\x74\x56\x61\154\x75\145")->willReturn($nHM1D);
        $this->twofautility->method("\147\x65\x74\101\x6c\x6c\115\x6f\124\146\x61\125\163\145\162\104\145\164\141\151\x6c\163")->willReturnCallback(function ($RXGzO, $vERQH, $z2guu) use($m2n_F) {
            foreach ($m2n_F as $user) {
                if (!($user["\x65\155\x61\151\x6c"] === $vERQH && $user["\167\x65\142\163\151\x74\145\x5f\x69\x64"] === $z2guu)) {
                    goto wcnAX;
                }
                return [["\x69\144" => $user["\x69\144"]]];
                wcnAX:
                X4y90:
            }
            XH9jI:
            return [];
        });
        $this->twofautility->expects($this->exactly(2))->method("\x64\x65\x6c\x65\164\145\x52\157\x77\111\156\124\x61\x62\x6c\145");
        $this->twofautility->expects($this->exactly(2))->method("\146\154\x75\x73\150\103\x61\x63\x68\145");
        $this->twofautility->expects($this->exactly(2))->method("\x72\x65\151\156\151\164\x43\x6f\x6e\146\151\147");
        $this->messageManager->expects($this->once())->method("\x61\144\144\123\165\143\x63\145\163\163\115\x65\163\163\x61\x67\145");
        $NgGdy = $this->getMockResultPage();
        $this->resultPageFactory->method("\143\x72\145\141\164\x65")->willReturn($NgGdy);
        $TKulV = $this->indexController->execute();
        $this->assertSame($NgGdy, $TKulV);
    }
    public function testExecuteResetSelectedUsersNoUsers()
    {
        $nHM1D = ["\157\160\x74\x69\157\x6e" => "\x73\141\166\x65", "\x72\x65\x73\145\x74\x5f\x73\x65\x6c\145\143\x74\x65\144\137\x75\x73\145\162\163" => true, "\141\x6c\154\137\x75\163\x65\162\x73\x2c\x77\x65\142\163\151\x74\x65\137\151\144" => json_encode([])];
        $this->request->method("\147\x65\x74\x50\x6f\163\x74\126\141\x6c\x75\x65")->willReturn($nHM1D);
        $this->messageManager->expects($this->once())->method("\x61\144\144\x45\x72\x72\x6f\x72\x4d\x65\x73\x73\141\x67\x65");
        $NgGdy = $this->getMockResultPage();
        $this->resultPageFactory->method("\x63\162\x65\141\x74\145")->willReturn($NgGdy);
        $TKulV = $this->indexController->execute();
        $this->assertSame($NgGdy, $TKulV);
    }
    public function testExecuteResetDevicePositive()
    {
        $nHM1D = ["\x6f\160\x74\x69\x6f\x6e" => "\163\141\x76\145", "\x72\x65\x73\x65\x74\137\x64\x65\x76\x69\x63\x65" => true, "\x64\145\x76\151\x63\x65\137\x69\x6e\144\145\170" => 0];
        $this->request->method("\147\x65\x74\120\157\x73\164\126\x61\x6c\165\145")->willReturn($nHM1D);
        $this->twofautility->method("\x67\145\164\123\x74\x6f\162\x65\x43\x6f\156\x66\x69\x67")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::USER_MANAGEMENT_USERNAME, "\165\163\145\162"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::USER_MANAGEMENT_WEBSITEID, 1]]);
        $xiBcd = [["\144\x65\166\x69\143\x65\x5f\151\156\146\157" => json_encode([["\x66\157\157" => "\x62\141\x72"], ["\142\141\x7a" => "\161\x75\170"]])]];
        $this->twofautility->method("\147\145\164\x41\154\x6c\x4d\157\124\146\x61\x55\163\145\x72\104\145\164\141\x69\154\x73")->willReturn($xiBcd);
        $this->twofautility->expects($this->once())->method("\165\x70\144\x61\x74\x65\103\x6f\x6c\x75\x6d\x6e\111\156\x54\x61\x62\154\145");
        $this->twofautility->expects($this->once())->method("\x66\154\165\x73\150\x43\141\x63\150\145");
        $this->twofautility->expects($this->once())->method("\162\x65\x69\x6e\151\164\103\x6f\156\146\x69\147");
        $this->messageManager->expects($this->once())->method("\x61\144\144\x53\165\x63\143\x65\x73\x73\x4d\x65\x73\x73\141\147\x65");
        $NgGdy = $this->getMockResultPage();
        $this->resultPageFactory->method("\x63\x72\145\x61\164\145")->willReturn($NgGdy);
        $TKulV = $this->indexController->execute();
        $this->assertSame($NgGdy, $TKulV);
    }
    public function testExecuteResetDeviceNoDeviceInfo()
    {
        $nHM1D = ["\157\x70\164\151\157\x6e" => "\163\141\x76\145", "\x72\x65\x73\x65\x74\x5f\144\145\x76\151\143\145" => true, "\x64\x65\x76\151\143\x65\137\x69\156\144\x65\x78" => 0];
        $this->request->method("\x67\145\164\x50\157\x73\x74\126\x61\154\165\145")->willReturn($nHM1D);
        $this->twofautility->method("\147\x65\x74\x53\164\x6f\162\145\x43\157\156\x66\x69\147")->willReturnMap([[\MiniOrange\TwoFA\Helper\TwoFAConstants::USER_MANAGEMENT_USERNAME, "\x75\163\145\162"], [\MiniOrange\TwoFA\Helper\TwoFAConstants::USER_MANAGEMENT_WEBSITEID, 1]]);
        $xiBcd = [["\x64\x65\166\151\143\x65\x5f\151\x6e\x66\x6f" => '']];
        $this->twofautility->method("\x67\x65\164\101\x6c\154\115\157\x54\146\x61\125\163\145\x72\x44\x65\x74\141\151\x6c\163")->willReturn($xiBcd);
        $this->twofautility->expects($this->never())->method("\x75\x70\144\141\164\145\x43\157\x6c\x75\155\156\x49\156\x54\x61\142\154\145");
        $NgGdy = $this->getMockResultPage();
        $this->resultPageFactory->method("\x63\162\145\141\x74\145")->willReturn($NgGdy);
        $TKulV = $this->indexController->execute();
        $this->assertSame($NgGdy, $TKulV);
    }
    public function testExecuteDisableSelectedUsersPositive()
    {
        $m2n_F = [["\145\x6d\x61\x69\x6c" => "\x61\100\x62\56\143\157\155", "\167\x65\x62\163\151\x74\x65\x5f\x69\x64" => 1, "\x69\x64" => 10, "\144\151\x73\141\142\154\x65\137\62\x66\x61" => false], ["\145\x6d\x61\151\x6c" => "\x63\x40\144\56\x63\157\155", "\x77\145\142\x73\151\164\x65\137\x69\144" => 2, "\151\x64" => 20, "\x64\151\x73\x61\142\x6c\x65\x5f\x32\x66\141" => true]];
        $nHM1D = ["\x6f\160\164\x69\x6f\156" => "\163\x61\166\x65", "\x64\151\163\141\x62\154\x65\x5f\x73\x65\x6c\x65\x63\164\x65\144\137\165\x73\x65\x72\163" => true, "\x61\154\x6c\137\165\163\x65\x72\x73\54\167\145\x62\163\x69\164\145\x5f\151\144" => json_encode($m2n_F)];
        $this->request->method("\x67\145\x74\120\157\163\164\126\141\x6c\x75\145")->willReturn($nHM1D);
        $this->twofautility->method("\147\x65\x74\101\x6c\154\x4d\x6f\124\146\141\x55\163\x65\162\104\145\x74\x61\151\154\x73")->willReturnCallback(function ($RXGzO, $vERQH, $z2guu) use($m2n_F) {
            foreach ($m2n_F as $user) {
                if (!($user["\x65\155\141\151\x6c"] === $vERQH && $user["\167\x65\x62\x73\151\164\x65\137\151\144"] === $z2guu)) {
                    goto Vi6Sn;
                }
                return [$user];
                Vi6Sn:
                r2rYG:
            }
            Gmx6N:
            return [];
        });
        $this->twofautility->expects($this->exactly(2))->method("\165\160\x64\141\x74\x65\103\x6f\154\x75\155\x6e\x49\156\124\141\x62\x6c\145");
        $this->twofautility->expects($this->exactly(2))->method("\146\x6c\165\163\150\103\141\x63\x68\145");
        $this->twofautility->expects($this->exactly(2))->method("\162\145\x69\156\x69\x74\103\157\156\146\x69\147");
        $this->messageManager->expects($this->once())->method("\141\x64\144\123\165\143\x63\145\x73\x73\x4d\x65\x73\163\141\147\x65");
        $NgGdy = $this->getMockResultPage();
        $this->resultPageFactory->method("\143\x72\145\141\x74\x65")->willReturn($NgGdy);
        $TKulV = $this->indexController->execute();
        $this->assertSame($NgGdy, $TKulV);
    }
    public function testExecuteResetPositive()
    {
        $nHM1D = ["\x6f\160\164\x69\157\x6e" => "\163\141\166\145", "\162\x65\163\x65\164" => true, "\145\x6d\141\151\x6c" => "\141\100\142\x2e\x63\x6f\x6d", "\x77\145\x62\163\151\x74\145\137\151\x64" => 1];
        $this->request->method("\x67\145\x74\x50\x6f\x73\164\126\141\x6c\165\x65")->willReturn($nHM1D);
        $xiBcd = [["\151\x64" => 10]];
        $this->twofautility->method("\x67\145\164\101\x6c\x6c\115\x6f\124\146\x61\125\163\145\x72\x44\145\x74\141\151\154\x73")->willReturn($xiBcd);
        $this->twofautility->expects($this->once())->method("\144\x65\x6c\x65\164\x65\x52\x6f\x77\111\156\x54\x61\x62\x6c\x65");
        $this->twofautility->expects($this->once())->method("\146\x6c\165\x73\150\103\x61\143\150\145");
        $this->twofautility->expects($this->once())->method("\x72\x65\151\x6e\x69\164\103\x6f\156\146\x69\x67");
        $this->messageManager->expects($this->once())->method("\141\144\x64\123\165\143\x63\x65\163\x73\x4d\x65\163\163\141\147\145");
        $NgGdy = $this->getMockResultPage();
        $this->resultPageFactory->method("\143\x72\x65\141\x74\145")->willReturn($NgGdy);
        $TKulV = $this->indexController->execute();
        $this->assertSame($NgGdy, $TKulV);
    }
    public function testExecuteResetNoUserFound()
    {
        $nHM1D = ["\162\x65\x73\145\164" => true, "\145\155\141\x69\x6c" => "\141\x40\x62\x2e\x63\157\155", "\167\x65\142\x73\x69\164\145\x5f\x69\x64" => 1];
        $this->request->method("\147\x65\x74\120\157\x73\x74\126\141\154\165\x65")->willReturn($nHM1D);
        $this->twofautility->method("\x67\x65\164\x41\x6c\x6c\x4d\157\x54\x66\141\x55\x73\x65\162\x44\x65\164\x61\151\154\x73")->willReturn([]);
        $this->twofautility->expects($this->never())->method("\x64\x65\154\145\x74\145\x52\157\167\111\156\x54\x61\x62\154\x65");
        $this->twofautility->expects($this->never())->method("\146\x6c\165\x73\150\103\x61\x63\150\x65");
        $this->twofautility->expects($this->never())->method("\162\145\151\x6e\151\x74\103\157\x6e\x66\151\x67");
        $this->messageManager->expects($this->never())->method("\141\x64\144\123\x75\143\x63\x65\x73\163\115\x65\x73\x73\141\x67\x65");
        $NgGdy = $this->getMockResultPage();
        $this->resultPageFactory->method("\x63\162\x65\x61\164\145")->willReturn($NgGdy);
        $TKulV = $this->indexController->execute();
        $this->assertSame($NgGdy, $TKulV);
    }
    private function getMockResultPage()
    {
        $JcsEL = $this->getMockBuilder(\stdClass::class)->addMethods(["\160\162\145\160\x65\156\x64"])->getMock();
        $JcsEL->method("\x70\162\x65\160\145\x6e\x64")->willReturnSelf();
        $xhr5k = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\x74\x54\x69\164\154\145"])->getMock();
        $xhr5k->method("\x67\145\x74\124\x69\x74\x6c\145")->willReturn($JcsEL);
        $R0FIM = $this->createMock(\Magento\Framework\View\Result\Page::class);
        $R0FIM->method("\x67\145\x74\x43\x6f\x6e\146\151\147")->willReturn($xhr5k);
        return $R0FIM;
    }
}