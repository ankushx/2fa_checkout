<?php

namespace MiniOrange\TwoFA\Test\Unit\Plugin\Adminhtml\Block\System\Account\Edit;

use MiniOrange\TwoFA\Plugin\Adminhtml\Block\System\Account\Edit\Form;
use PHPUnit\Framework\TestCase;
use Magento\Config\Model\Config\Source\Enabledisable;
use Magento\Framework\Registry;
use Magento\Framework\View\LayoutInterface;
use Magento\Backend\Model\Auth\Session;
use Magento\User\Model\UserFactory;
use Magento\User\Model\User;
class FormTest extends TestCase
{
    private $formPlugin;
    private $enableDisable;
    private $coreRegistry;
    private $layout;
    private $authSession;
    private $userFactory;
    protected function setUp() : void
    {
        $this->enableDisable = $this->createMock(Enabledisable::class);
        $this->coreRegistry = $this->createMock(Registry::class);
        $this->layout = $this->createMock(LayoutInterface::class);
        $this->authSession = $this->getMockBuilder(Session::class)->disableOriginalConstructor()->addMethods(["\147\145\164\x55\163\145\162"])->getMock();
        $this->userFactory = $this->createMock(UserFactory::class);
        $this->formPlugin = new Form($this->enableDisable, $this->coreRegistry, $this->layout, $this->authSession, $this->userFactory);
    }
    public function testGetTrustedDeviceHtmlReturnsHtml()
    {
        $user = $this->createMock(User::class);
        $MWSzi = $this->getMockBuilder(\stdClass::class)->addMethods(["\x73\145\164\x55\x73\x65\x72\x4f\x62\x6a\x65\x63\164", "\x74\157\110\x74\x6d\154"])->getMock();
        $MWSzi->expects($this->once())->method("\163\145\x74\x55\x73\145\162\117\x62\x6a\145\143\164")->with($user)->willReturnSelf();
        $MWSzi->expects($this->once())->method("\x74\x6f\110\164\155\x6c")->willReturn("\x3c\144\151\x76\76\x54\x72\x75\163\164\x65\144\x20\x44\145\166\x69\x63\x65\x73\x3c\57\144\151\x76\x3e");
        $this->layout->expects($this->once())->method("\143\x72\145\141\164\145\x42\154\x6f\143\x6b")->willReturn($MWSzi);
        $jFxnJ = $this->formPlugin->getTrustedDeviceHtml($user);
        $this->assertEquals("\74\x64\151\x76\76\124\x72\x75\163\164\145\x64\x20\104\145\166\x69\143\x65\163\74\57\x64\151\166\76", $jFxnJ);
    }
    public function testAroundGetFormHtmlCallsProceed()
    {
        $kPO5U = $this->getMockBuilder("\115\141\x67\145\x6e\x74\157\x5c\x42\x61\143\153\x65\156\144\x5c\102\x6c\157\x63\153\134\123\x79\163\x74\145\x6d\x5c\x41\143\x63\x6f\x75\x6e\x74\134\x45\144\151\164\x5c\x46\x6f\162\155")->disableOriginalConstructor()->getMock();
        $TU454 = function () {
            return "\x66\x6f\x72\155\110\x74\155\154";
        };
        $user = $this->getMockBuilder(\stdClass::class)->addMethods(["\147\x65\164\111\144", "\165\156\x73\x65\x74\x44\x61\x74\141", "\154\157\141\x64"])->getMock();
        $user->method("\x67\x65\x74\x49\x64")->willReturn(1);
        $user->method("\x75\x6e\163\x65\x74\x44\x61\164\x61")->willReturnSelf();
        $user->method("\154\x6f\x61\x64")->willReturn($user);
        $this->authSession->method("\147\145\x74\125\163\x65\162")->willReturn($user);
        $this->userFactory->method("\143\162\x65\141\x74\x65")->willReturn($user);
        $this->coreRegistry->expects($this->once())->method("\x72\145\x67\x69\163\164\x65\162")->with("\x6d\160\137\x70\145\x72\155\x69\163\163\151\157\156\163\137\x75\163\x65\162", $user);
        $jFxnJ = $this->formPlugin->aroundGetFormHtml($kPO5U, $TU454);
        $this->assertEquals("\146\157\162\155\x48\164\155\x6c", $jFxnJ);
    }
    public function testGetTrustedDeviceHtmlThrowsOnCreateBlockFailure()
    {
        $user = $this->createMock(\Magento\User\Model\User::class);
        $this->layout->expects($this->once())->method("\x63\162\x65\141\x74\x65\102\x6c\x6f\143\153")->willReturn(null);
        $this->expectException(\Error::class);
        $this->formPlugin->getTrustedDeviceHtml($user);
    }
    public function testAroundGetFormHtmlRegistersUserInRegistryWithDifferentId()
    {
        $kPO5U = $this->getMockBuilder("\115\x61\x67\145\156\164\157\134\102\141\x63\153\x65\156\144\x5c\x42\x6c\157\143\x6b\134\x53\171\x73\x74\x65\155\134\x41\143\143\x6f\x75\156\164\x5c\x45\x64\151\164\134\x46\x6f\x72\x6d")->disableOriginalConstructor()->getMock();
        $TU454 = function () {
            return "\x68\x74\x6d\154";
        };
        $user = $this->getMockBuilder(\stdClass::class)->addMethods(["\x67\145\x74\x49\144", "\x75\x6e\x73\x65\x74\104\141\164\x61", "\154\x6f\x61\144"])->getMock();
        $user->method("\x67\x65\x74\x49\x64")->willReturn(99);
        $user->method("\x75\156\x73\145\x74\104\141\x74\141")->willReturnSelf();
        $user->method("\x6c\157\141\x64")->willReturn($user);
        $this->authSession->method("\147\x65\164\125\x73\145\x72")->willReturn($user);
        $this->userFactory->method("\x63\162\145\x61\164\x65")->willReturn($user);
        $this->coreRegistry->expects($this->once())->method("\162\x65\x67\151\163\x74\x65\x72")->with("\155\160\x5f\x70\145\x72\x6d\x69\x73\x73\151\x6f\x6e\x73\x5f\x75\163\145\162", $user);
        $jFxnJ = $this->formPlugin->aroundGetFormHtml($kPO5U, $TU454);
        $this->assertEquals("\x68\x74\155\x6c", $jFxnJ);
    }
    public function testAroundGetFormHtmlWithUserWithoutGetId()
    {
        $kPO5U = $this->getMockBuilder("\115\x61\147\x65\x6e\x74\157\134\102\141\x63\153\145\x6e\144\134\102\154\157\143\x6b\x5c\123\x79\163\x74\x65\155\134\101\x63\143\x6f\165\x6e\164\x5c\105\144\x69\164\x5c\106\x6f\162\x6d")->disableOriginalConstructor()->getMock();
        $TU454 = function () {
            return "\x68\164\155\x6c";
        };
        $user = new \stdClass();
        $this->authSession->method("\x67\x65\x74\x55\163\x65\x72")->willReturn($user);
        $this->userFactory->method("\143\162\145\141\x74\x65")->willReturn($user);
        $this->expectException(\Error::class);
        $this->formPlugin->aroundGetFormHtml($kPO5U, $TU454);
    }
    public function testGetTrustedDeviceHtmlReturnsEmptyStringIfToHtmlEmpty()
    {
        $user = $this->createMock(\Magento\User\Model\User::class);
        $MWSzi = $this->getMockBuilder(\stdClass::class)->addMethods(["\163\145\164\x55\x73\145\x72\117\x62\152\x65\143\164", "\x74\157\x48\x74\x6d\154"])->getMock();
        $MWSzi->expects($this->once())->method("\163\x65\x74\125\163\145\162\x4f\x62\152\x65\143\x74")->with($user)->willReturnSelf();
        $MWSzi->expects($this->once())->method("\164\x6f\x48\x74\x6d\x6c")->willReturn('');
        $this->layout->expects($this->once())->method("\143\162\x65\x61\x74\x65\x42\154\157\143\153")->willReturn($MWSzi);
        $jFxnJ = $this->formPlugin->getTrustedDeviceHtml($user);
        $this->assertEquals('', $jFxnJ);
    }
}