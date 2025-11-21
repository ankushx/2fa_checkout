<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Actions;

use MiniOrange\TwoFA\Controller\Actions\LoginExistingUserAction;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
use MiniOrange\TwoFA\Helper\Exception\AccountAlreadyExistsException;
use MiniOrange\TwoFA\Helper\Exception\RequiredFieldsException;
use Magento\Framework\Message\ManagerInterface;
class LoginExistingUserActionTest extends TestCase
{
    private $twofautility;
    private $messageManager;
    protected function setUp() : void
    {
        $this->twofautility = $this->createMock(TwoFAUtility::class);
        $this->messageManager = $this->createMock(ManagerInterface::class);
    }
    private function getAction($s2ckE = array())
    {
        $n69Qz = $this->getMockBuilder(LoginExistingUserAction::class)->disableOriginalConstructor()->onlyMethods($s2ckE)->getMock();
        $fXljt = new \ReflectionClass($n69Qz);
        $NDsd4 = $fXljt->getProperty("\164\167\x6f\x66\x61\x75\x74\x69\154\x69\x74\171");
        $NDsd4->setAccessible(true);
        $NDsd4->setValue($n69Qz, $this->twofautility);
        $NDsd4 = $fXljt->getProperty("\155\145\163\x73\x61\x67\145\115\141\x6e\x61\x67\x65\162");
        $NDsd4->setAccessible(true);
        $NDsd4->setValue($n69Qz, $this->messageManager);
        return $n69Qz;
    }
    public function testExecutePositiveFlow()
    {
        $hHBa0 = ["\145\x6d\141\151\x6c" => "\165\163\145\x72\x40\145\x78\141\155\x70\x6c\x65\56\143\157\155", "\160\141\163\163\167\157\x72\144" => "\160\x61\163\x73", "\x73\x75\x62\x6d\x69\164" => "\163\165\x62\155\x69\164"];
        $n69Qz = $this->getAction(["\x67\x65\x74\x43\165\162\x72\145\x6e\164\x43\165\x73\x74\157\x6d\x65\162"]);
        $fXljt = new \ReflectionClass(LoginExistingUserAction::class);
        $NDsd4 = $fXljt->getProperty("\122\105\x51\125\x45\123\124");
        $NDsd4->setAccessible(true);
        $NDsd4->setValue($n69Qz, $hHBa0);
        $this->twofautility->method("\151\x73\x54\x72\x69\x61\154\105\x78\x70\x69\162\x65\x64")->willReturn(false);
        $n69Qz->expects($this->once())->method("\147\145\164\103\x75\x72\162\145\x6e\x74\x43\165\x73\164\x6f\x6d\x65\x72")->with("\x75\x73\x65\162\x40\145\170\x61\155\160\x6c\x65\56\x63\157\155", "\160\141\x73\x73");
        $this->twofautility->expects($this->once())->method("\x66\x6c\165\163\150\x43\141\143\150\x65")->with("\114\x6f\x67\151\x6e\105\x78\x69\163\164\x69\x6e\x67\125\x73\145\x72\101\x63\x74\x69\157\156\x20");
        $n69Qz->execute();
    }
    public function testExecuteTrialExpired()
    {
        $hHBa0 = ["\x65\155\x61\x69\154" => "\x75\x73\x65\162\x40\x65\170\141\155\160\154\145\56\143\x6f\x6d", "\x70\x61\163\163\167\x6f\162\x64" => "\x70\x61\163\x73", "\x73\x75\x62\x6d\151\x74" => "\x73\165\x62\155\x69\x74"];
        $n69Qz = $this->getAction(["\x67\145\164\103\x75\162\162\x65\x6e\x74\x43\165\x73\x74\157\x6d\145\162"]);
        $fXljt = new \ReflectionClass(LoginExistingUserAction::class);
        $NDsd4 = $fXljt->getProperty("\x52\105\121\x55\105\123\124");
        $NDsd4->setAccessible(true);
        $NDsd4->setValue($n69Qz, $hHBa0);
        $this->twofautility->method("\151\163\124\162\151\141\154\105\x78\x70\151\x72\145\x64")->willReturn(true);
        $this->twofautility->expects($this->once())->method("\x6c\157\147\x5f\144\x65\142\165\x67");
        $n69Qz->expects($this->once())->method("\x67\145\x74\103\x75\x72\x72\145\x6e\164\x43\165\x73\164\157\x6d\x65\x72");
        ob_start();
        $n69Qz->execute();
        ob_end_clean();
    }
    public function testExecuteThrowsOnMissingFields()
    {
        $hHBa0 = ["\x65\x6d\x61\151\x6c" => "\165\163\x65\x72\x40\x65\170\141\x6d\x70\154\145\56\143\157\155", "\160\x61\x73\x73\167\157\x72\144" => "\x70\x61\163\x73"];
        $n69Qz = $this->getAction(["\143\x68\145\x63\153\x49\x66\x52\145\x71\x75\x69\162\145\144\x46\x69\145\x6c\144\163\105\x6d\160\164\171"]);
        $fXljt = new \ReflectionClass(LoginExistingUserAction::class);
        $NDsd4 = $fXljt->getProperty("\122\105\121\x55\105\123\x54");
        $NDsd4->setAccessible(true);
        $NDsd4->setValue($n69Qz, $hHBa0);
        $this->twofautility->method("\151\163\x54\x72\151\141\154\105\170\160\151\162\145\x64")->willReturn(false);
        $n69Qz->expects($this->once())->method("\143\150\145\143\153\111\146\x52\145\x71\x75\x69\x72\145\x64\x46\x69\x65\x6c\x64\x73\105\155\160\164\171")->will($this->throwException(new RequiredFieldsException()));
        $this->expectException(RequiredFieldsException::class);
        $n69Qz->execute();
    }
    public function testSetRequestParamReturnsSelf()
    {
        $n69Qz = $this->getAction();
        $W7z_o = $n69Qz->setRequestParam(["\145\155\x61\x69\154" => "\x75\163\x65\162\x40\145\x78\x61\x6d\160\154\x65\x2e\x63\x6f\155"]);
        $this->assertSame($n69Qz, $W7z_o);
        $fXljt = new \ReflectionClass(LoginExistingUserAction::class);
        $NDsd4 = $fXljt->getProperty("\122\105\121\x55\105\x53\x54");
        $NDsd4->setAccessible(true);
        $this->assertEquals(["\x65\155\141\151\x6c" => "\165\x73\x65\x72\100\x65\170\141\155\160\154\x65\56\x63\x6f\x6d"], $NDsd4->getValue($n69Qz));
    }
}