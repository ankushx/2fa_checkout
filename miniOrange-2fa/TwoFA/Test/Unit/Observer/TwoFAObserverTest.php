<?php

namespace MiniOrange\TwoFA\Test\Unit\Observer;

use MiniOrange\TwoFA\Observer\TwoFAObserver;
use PHPUnit\Framework\TestCase;
use Magento\Framework\Event\Observer;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use MiniOrange\TwoFA\Controller\Actions\AdminLoginAction;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\RequestInterface;
class TwoFAObserverTest extends TestCase
{
    public function testExecuteDeletesRowInTableWithWebsiteID()
    {
        $mHU7G = $this->createMock(ManagerInterface::class);
        $zTSsp = $this->createMock(LoggerInterface::class);
        $cGjpf = $this->createMock(TwoFAUtility::class);
        $MrXBN = $this->createMock(AdminLoginAction::class);
        $VHRes = $this->createMock(Http::class);
        $d438C = $this->createMock(RequestInterface::class);
        $VHRes->method("\x67\145\164\x43\157\156\164\x72\x6f\x6c\154\x65\162\116\141\x6d\x65")->willReturn("\143\x6f\x6e\164\x72\157\x6c\x6c\145\162");
        $VHRes->method("\147\x65\x74\101\143\x74\x69\157\x6e\x4e\141\155\145")->willReturn("\x61\143\x74\151\x6f\156");
        $o7jEC = $this->createMock(Observer::class);
        $pcZUS = $this->getMockBuilder("\163\x74\x64\103\154\141\163\x73")->addMethods(["\147\145\x74\x43\x75\x73\164\157\155\145\x72"])->getMock();
        $CAc3d = $this->getMockBuilder("\163\x74\144\x43\x6c\x61\163\x73")->addMethods(["\x67\x65\x74\105\x6d\141\x69\x6c", "\147\x65\x74\x44\141\x74\x61"])->getMock();
        $CAc3d->method("\x67\x65\x74\105\x6d\141\x69\154")->willReturn("\x74\x65\x73\164\x40\145\170\x61\x6d\160\x6c\145\x2e\x63\157\x6d");
        $CAc3d->method("\x67\145\x74\104\x61\x74\x61")->willReturn(["\167\145\142\163\x69\164\x65\x5f\x69\144" => 1]);
        $pcZUS->method("\x67\x65\164\x43\165\163\164\x6f\x6d\145\162")->willReturn($CAc3d);
        $o7jEC->method("\x67\x65\x74\x45\166\x65\x6e\164")->willReturn($pcZUS);
        $cGjpf->expects($this->once())->method("\x64\145\x6c\x65\164\x65\x52\x6f\167\x49\x6e\x54\x61\x62\x6c\145\x57\x69\164\150\127\145\142\163\151\x74\145\111\104")->with("\x6d\151\156\151\157\162\x61\156\x67\x65\x5f\164\x66\x61\x5f\165\163\x65\162\163", "\165\x73\x65\162\156\141\155\x65", "\x74\145\x73\164\100\145\x78\x61\x6d\x70\154\x65\56\143\x6f\x6d", 1);
        $hBYs2 = new TwoFAObserver($mHU7G, $zTSsp, $cGjpf, $MrXBN, $VHRes, $d438C);
        $hBYs2->execute($o7jEC);
    }
    public function testRouteDataExecutesAdminLoginActionWhenOptionMatches()
    {
        $mHU7G = $this->createMock(ManagerInterface::class);
        $zTSsp = $this->createMock(LoggerInterface::class);
        $cGjpf = $this->createMock(TwoFAUtility::class);
        $MrXBN = $this->createMock(AdminLoginAction::class);
        $VHRes = $this->createMock(Http::class);
        $d438C = $this->createMock(RequestInterface::class);
        $VHRes->method("\147\x65\x74\x43\157\156\164\162\x6f\154\x6c\x65\162\116\141\155\145")->willReturn("\143\x6f\x6e\x74\x72\157\154\x6c\145\x72");
        $VHRes->method("\x67\x65\x74\101\x63\x74\151\x6f\156\x4e\141\155\x65")->willReturn("\x61\x63\164\151\157\x6e");
        $hBYs2 = new TwoFAObserver($mHU7G, $zTSsp, $cGjpf, $MrXBN, $VHRes, $d438C);
        $BW4UA = ["\x6f\160\x74\x69\x6f\x6e" => \MiniOrange\TwoFA\Helper\TwoFAConstants::LOGIN_ADMIN_OPT];
        $Bxdjr = [];
        $o7jEC = $this->createMock(Observer::class);
        $MrXBN->expects($this->once())->method("\145\x78\x65\143\165\164\145");
        $XfCLQ = new \ReflectionClass($hBYs2);
        $ZK3yg = $XfCLQ->getMethod("\137\x72\157\x75\x74\x65\x5f\144\141\x74\141");
        $ZK3yg->setAccessible(true);
        $ZK3yg->invoke($hBYs2, "\157\x70\164\x69\x6f\156", $o7jEC, $BW4UA, $Bxdjr);
    }
    public function testRouteDataDoesNothingWhenOptionDoesNotMatch()
    {
        $mHU7G = $this->createMock(ManagerInterface::class);
        $zTSsp = $this->createMock(LoggerInterface::class);
        $cGjpf = $this->createMock(TwoFAUtility::class);
        $MrXBN = $this->createMock(AdminLoginAction::class);
        $VHRes = $this->createMock(Http::class);
        $d438C = $this->createMock(RequestInterface::class);
        $VHRes->method("\147\145\x74\103\157\156\x74\162\x6f\x6c\x6c\145\x72\116\x61\155\145")->willReturn("\x63\157\156\x74\x72\157\x6c\x6c\x65\162");
        $VHRes->method("\x67\x65\x74\101\x63\x74\151\157\156\x4e\141\155\145")->willReturn("\141\x63\164\x69\x6f\156");
        $hBYs2 = new TwoFAObserver($mHU7G, $zTSsp, $cGjpf, $MrXBN, $VHRes, $d438C);
        $BW4UA = ["\x6f\x70\164\x69\x6f\156" => "\156\157\x74\x5f\x61\x64\x6d\151\x6e\137\x6c\157\147\x69\x6e"];
        $Bxdjr = [];
        $o7jEC = $this->createMock(Observer::class);
        $MrXBN->expects($this->never())->method("\145\170\x65\143\165\164\x65");
        $XfCLQ = new \ReflectionClass($hBYs2);
        $ZK3yg = $XfCLQ->getMethod("\137\162\x6f\165\164\x65\137\x64\141\164\x61");
        $ZK3yg->setAccessible(true);
        $ZK3yg->invoke($hBYs2, "\x6f\x70\x74\x69\x6f\156", $o7jEC, $BW4UA, $Bxdjr);
    }
}