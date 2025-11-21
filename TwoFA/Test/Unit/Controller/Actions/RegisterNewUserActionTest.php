<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Actions;

use MiniOrange\TwoFA\Controller\Actions\RegisterNewUserAction;
use MiniOrange\TwoFA\Helper\Exception\AccountAlreadyExistsException;
use MiniOrange\TwoFA\Helper\Exception\PasswordMismatchException;
use MiniOrange\TwoFA\Helper\Exception\TransactionLimitExceededException;
use MiniOrange\TwoFA\Helper\Exception\RequiredFieldsException;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
use PHPUnit\Framework\TestCase;
class RegisterNewUserActionTest extends TestCase
{
    private $twofautility;
    private $messageManager;
    private $logger;
    private $loginExistingUserAction;
    protected function setUp() : void
    {
        $this->twofautility = $this->createMock(\MiniOrange\TwoFA\Helper\TwoFAUtility::class);
        $this->messageManager = $this->createMock(\Magento\Framework\Message\ManagerInterface::class);
        $this->logger = $this->createMock(\Psr\Log\LoggerInterface::class);
        $this->loginExistingUserAction = $this->getMockBuilder(\MiniOrange\TwoFA\Controller\Actions\LoginExistingUserAction::class)->disableOriginalConstructor()->getMock();
    }
    private function getAction($qMqpR = array())
    {
        $CXo8k = $this->getMockBuilder(RegisterNewUserAction::class)->setConstructorArgs([$this->createMock(\Magento\Backend\App\Action\Context::class), $this->createMock(\Magento\Framework\View\Result\PageFactory::class), $this->twofautility, $this->messageManager, $this->logger, $this->loginExistingUserAction]);
        if (empty($qMqpR)) {
            goto CdnEH;
        }
        $CXo8k->onlyMethods($qMqpR);
        CdnEH:
        $STylp = $CXo8k->getMock();
        return $STylp;
    }
    public function testExecuteThrowsOnMissingFields()
    {
        $STylp = $this->getAction(["\143\x68\x65\143\153\111\146\x52\x65\161\x75\x69\162\x65\144\106\151\x65\x6c\144\163\105\x6d\x70\164\171"]);
        $wW9Su = ["\145\x6d\x61\151\154" => "\165\x73\145\162\x40\145\170\141\x6d\160\x6c\x65\x2e\143\157\155"];
        $STylp->setRequestParam($wW9Su);
        $STylp->expects($this->once())->method("\143\150\145\143\x6b\x49\146\x52\x65\161\x75\151\162\145\144\106\151\x65\x6c\x64\163\x45\155\x70\x74\171")->will($this->throwException(new RequiredFieldsException()));
        $this->expectException(RequiredFieldsException::class);
        $STylp->execute();
    }
    public function testExecuteThrowsOnPasswordMismatch()
    {
        $STylp = $this->getAction(["\143\150\x65\x63\x6b\111\x66\125\163\x65\x72\105\170\151\x73\164\x73", "\x63\x68\x65\143\x6b\111\x66\122\145\161\x75\x69\162\x65\144\x46\x69\145\154\144\x73\x45\155\x70\x74\x79"]);
        $wW9Su = ["\145\x6d\x61\x69\154" => "\x75\x73\145\x72\x40\x65\x78\x61\x6d\x70\x6c\145\56\143\157\155", "\x70\141\163\163\167\x6f\162\144" => "\160\x61\163\x73\x31", "\x63\157\156\146\x69\x72\x6d\120\141\163\x73\167\157\162\144" => "\x70\141\x73\163\62", "\x63\x6f\x6d\x70\x61\x6e\x79\x4e\x61\155\145" => "\x43\x6f\155\x70\x61\156\x79", "\x66\x69\162\x73\164\116\x61\x6d\x65" => "\x46\151\162\163\x74", "\x6c\x61\163\x74\x4e\x61\155\145" => "\x4c\x61\x73\x74"];
        $STylp->setRequestParam($wW9Su);
        $STylp->expects($this->once())->method("\143\150\145\x63\153\x49\x66\x52\145\161\165\x69\162\145\x64\106\x69\145\154\144\x73\105\x6d\160\164\171");
        $this->expectException(PasswordMismatchException::class);
        $STylp->execute();
    }
    public function testConfigureUserInMagentoSetsConfigAndAddsMessage()
    {
        $STylp = $this->getMockBuilder(RegisterNewUserAction::class)->setConstructorArgs([$this->createMock(\Magento\Backend\App\Action\Context::class), $this->createMock(\Magento\Framework\View\Result\PageFactory::class), $this->twofautility, $this->messageManager, $this->logger, $this->loginExistingUserAction])->onlyMethods(["\147\145\x74\x4d\145\163\163\x61\147\145\x4d\x61\x6e\x61\x67\145\x72"])->getMock();
        $STylp->method("\147\x65\x74\x4d\145\163\x73\x61\x67\145\115\x61\156\141\x67\145\162")->willReturn($this->messageManager);
        $F8RPK = ["\x69\144" => "\151\144", "\141\160\x69\x4b\145\x79" => "\x61\x70\x69", "\x74\x6f\x6b\145\156" => "\x74\x6f\153"];
        $a05eE = ["\x69\x64" => "\143\x69\x64", "\x61\160\x69\x4b\x65\x79" => "\x63\x61\x70\151", "\x74\x6f\x6b\145\x6e" => "\143\x74\x6f\x6b"];
        $this->twofautility->expects($this->exactly(4))->method("\163\x65\x74\123\164\x6f\162\x65\x43\157\x6e\x66\151\147");
        $this->messageManager->expects($this->once())->method("\141\144\x64\x53\165\143\x63\x65\163\163\x4d\145\163\x73\141\147\x65")->with(\MiniOrange\TwoFA\Helper\TwoFAMessages::REG_SUCCESS);
        $OGO47 = new \ReflectionClass($STylp);
        $PVANz = $OGO47->getMethod("\143\157\156\146\x69\147\x75\162\145\x55\163\145\x72\111\156\x4d\141\147\145\156\x74\157");
        $PVANz->setAccessible(true);
        $PVANz->invokeArgs($STylp, [$F8RPK, $a05eE]);
    }
    private function invokePrivate($HAR5I, $S1UER, array $f5e66 = array())
    {
        $OGO47 = new \ReflectionClass($HAR5I);
        $PVANz = $OGO47->getMethod($S1UER);
        $PVANz->setAccessible(true);
        return $PVANz->invokeArgs($HAR5I, $f5e66);
    }
}