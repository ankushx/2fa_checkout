<?php

namespace MiniOrange\TwoFA\Test\Unit\Controller\Actions;

use MiniOrange\TwoFA\Controller\Actions\LKAction;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
use MiniOrange\TwoFA\Helper\AESEncryption;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
use Magento\Framework\Message\ManagerInterface;
class LKActionTest extends TestCase
{
    private $twofautility;
    private $messageManager;
    protected function setUp() : void
    {
        $this->twofautility = $this->createMock(TwoFAUtility::class);
        $this->messageManager = $this->createMock(ManagerInterface::class);
    }
    private function getAction()
    {
        $xd04q = $this->getMockBuilder(LKAction::class)->disableOriginalConstructor()->onlyMethods(["\143\150\x65\x63\x6b\111\146\122\145\x71\165\x69\x72\145\144\106\151\x65\x6c\144\x73\105\x6d\x70\164\x79"])->getMock();
        $VkvAi = new \ReflectionClass($xd04q);
        $N0VDf = $VkvAi->getProperty("\164\x77\157\x66\141\165\x74\x69\154\x69\164\x79");
        $N0VDf->setAccessible(true);
        $N0VDf->setValue($xd04q, $this->twofautility);
        $N0VDf = $VkvAi->getProperty("\155\145\x73\x73\141\x67\x65\115\x61\156\141\x67\145\162");
        $N0VDf->setAccessible(true);
        $N0VDf->setValue($xd04q, $this->messageManager);
        return $xd04q;
    }
    public function testRemoveAccountPositive()
    {
        $xd04q = $this->getAction();
        $this->twofautility->method("\x6d\151\143\162")->willReturn(true);
        $this->twofautility->method("\155\x63\x6c\x76")->willReturn(true);
        $this->twofautility->method("\147\145\x74\123\164\157\x72\145\x43\x6f\x6e\146\151\x67")->willReturnMap([[TwoFAConstants::TOKEN, "\164\157\153\x65\156"], [TwoFAConstants::SAMLSP_LK, "\x65\x6e\143\162\x79\160\164\x65\144\x5f\x63\x6f\144\x65"]]);
        $this->twofautility->method("\x75\160\144\141\164\145\x5f\163\x74\141\164\x75\163")->willReturn(json_encode(["\163\x74\141\x74\165\163" => "\123\125\x43\103\x45\x53\x53"]));
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\145\164\123\164\157\x72\x65\103\157\x6e\x66\x69\147");
        $this->twofautility->expects($this->once())->method("\162\x65\155\x6f\x76\145\x53\x65\164\164\x69\156\147\163\x41\146\164\x65\162\x41\x63\x63\x6f\165\156\164");
        $this->twofautility->expects($this->once())->method("\162\x65\151\156\151\x74\x63\157\x6e\146\151\x67");
        $this->twofautility->expects($this->once())->method("\155\x69\165\163");
        $this->twofautility->expects($this->once())->method("\146\x6c\165\x73\150\x43\141\x63\150\145");
        $xd04q->removeAccount();
    }
    public function testRemoveAccountMicrFalse()
    {
        $xd04q = $this->getAction();
        $this->twofautility->method("\x6d\151\143\162")->willReturn(false);
        $this->twofautility->expects($this->never())->method("\x67\x65\x74\x53\164\x6f\162\145\103\x6f\156\x66\x69\147");
        $this->twofautility->expects($this->once())->method("\x66\x6c\x75\163\x68\103\x61\x63\150\145");
        $xd04q->removeAccount();
    }
    public function testRemoveAccountMclvFalse()
    {
        $xd04q = $this->getAction();
        $this->twofautility->method("\155\151\x63\x72")->willReturn(true);
        $this->twofautility->method("\155\143\154\x76")->willReturn(false);
        $this->twofautility->method("\147\x65\x74\x53\x74\x6f\162\145\x43\157\156\x66\151\x67")->willReturnMap([[TwoFAConstants::TOKEN, "\x74\x6f\x6b\145\156"], [TwoFAConstants::SAMLSP_LK, "\x65\x6e\143\x72\171\160\164\x65\144\137\x63\157\x64\x65"]]);
        $this->twofautility->method("\165\x70\x64\141\164\145\137\x73\x74\x61\x74\x75\163")->willReturn(json_encode(["\x73\x74\141\x74\165\163" => "\123\125\x43\x43\105\123\x53"]));
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\x65\x74\123\164\157\162\145\x43\x6f\x6e\146\x69\x67");
        $this->twofautility->expects($this->once())->method("\x72\145\x6d\157\x76\145\123\145\164\x74\151\156\147\x73\x41\x66\164\x65\162\101\143\x63\157\165\x6e\164");
        $this->twofautility->expects($this->once())->method("\x72\x65\x69\156\151\x74\143\x6f\156\146\x69\x67");
        $this->twofautility->expects($this->never())->method("\155\151\165\x73");
        $this->twofautility->expects($this->once())->method("\146\154\x75\x73\x68\x43\141\x63\x68\x65");
        $xd04q->removeAccount();
    }
    public function testRemoveAccountStatusNotSuccess()
    {
        $xd04q = $this->getAction();
        $this->twofautility->method("\155\151\x63\x72")->willReturn(true);
        $this->twofautility->method("\x6d\143\154\166")->willReturn(false);
        $this->twofautility->method("\147\145\x74\x53\x74\x6f\x72\x65\x43\157\156\x66\151\x67")->willReturnMap([[TwoFAConstants::TOKEN, "\x74\157\153\x65\x6e"], [TwoFAConstants::SAMLSP_LK, "\145\x6e\143\x72\x79\x70\164\x65\144\137\x63\x6f\x64\x65"]]);
        $this->twofautility->method("\165\x70\x64\x61\164\145\x5f\163\x74\x61\x74\165\x73")->willReturn(json_encode(["\163\x74\141\164\x75\163" => "\x46\x41\x49\x4c\x45\x44"]));
        $this->twofautility->expects($this->never())->method("\x72\145\155\157\x76\145\123\x65\164\x74\x69\156\147\163\101\x66\164\145\x72\x41\143\143\157\165\x6e\x74");
        $this->twofautility->expects($this->once())->method("\146\x6c\x75\163\150\x43\141\x63\150\x65");
        $xd04q->removeAccount();
    }
    public function testSetRequestParamReturnsSelf()
    {
        $xd04q = $this->getAction();
        $HBz5f = $xd04q->setRequestParam(["\154\153" => "\x6b\145\x79"]);
        $this->assertSame($xd04q, $HBz5f);
        $VkvAi = new \ReflectionClass(LKAction::class);
        $N0VDf = $VkvAi->getProperty("\122\105\121\125\x45\x53\x54");
        $N0VDf->setAccessible(true);
        $this->assertEquals(["\x6c\153" => "\x6b\x65\x79"], $N0VDf->getValue($xd04q));
    }
    public function testExecuteSuccessFlow()
    {
        $xd04q = $this->getMockBuilder(LKAction::class)->disableOriginalConstructor()->onlyMethods(["\x63\150\x65\x63\153\x49\x66\x52\145\x71\x75\151\x72\x65\x64\x46\x69\x65\x6c\144\163\105\155\x70\164\171", "\137\166\x6c\153\137\x73\x75\x63\143\145\163\x73", "\x5f\166\154\x6b\x5f\x66\141\x69\154"])->getMock();
        $VkvAi = new \ReflectionClass($xd04q);
        $N0VDf = $VkvAi->getProperty("\164\167\157\146\141\165\164\151\x6c\151\164\x79");
        $N0VDf->setAccessible(true);
        $N0VDf->setValue($xd04q, $this->twofautility);
        $N0VDf = $VkvAi->getProperty("\155\145\163\x73\x61\147\x65\x4d\141\x6e\141\147\145\x72");
        $N0VDf->setAccessible(true);
        $N0VDf->setValue($xd04q, $this->messageManager);
        $X3Xob = new \ReflectionClass(LKAction::class);
        $N0VDf = $X3Xob->getProperty("\122\105\x51\x55\105\x53\124");
        $N0VDf->setAccessible(true);
        $N0VDf->setValue($xd04q, ["\x6c\153" => "\x6b\x65\171"]);
        $xd04q->expects($this->once())->method("\x63\x68\145\x63\x6b\111\x66\x52\x65\161\x75\151\x72\x65\144\106\151\145\154\x64\x73\105\155\x70\164\x79");
        $xd04q->expects($this->once())->method("\x5f\x76\x6c\x6b\x5f\163\x75\x63\x63\x65\163\163")->with("\x6b\145\171");
        $xd04q->expects($this->never())->method("\137\166\154\x6b\137\x66\141\151\x6c");
        $this->twofautility->method("\143\x63\x6c")->willReturn(["\x73\x74\x61\x74\x75\x73" => "\x53\x55\x43\x43\105\123\x53"]);
        $xd04q->execute();
    }
    public function testExecuteFailFlow()
    {
        $xd04q = $this->getMockBuilder(LKAction::class)->disableOriginalConstructor()->onlyMethods(["\x63\x68\x65\x63\x6b\111\146\122\145\161\165\151\162\x65\x64\x46\x69\145\154\144\163\105\x6d\160\164\171", "\137\x76\x6c\153\137\x73\x75\x63\143\145\x73\163", "\137\x76\154\x6b\x5f\x66\x61\x69\154"])->getMock();
        $VkvAi = new \ReflectionClass($xd04q);
        $N0VDf = $VkvAi->getProperty("\164\167\x6f\146\141\165\x74\x69\x6c\x69\164\x79");
        $N0VDf->setAccessible(true);
        $N0VDf->setValue($xd04q, $this->twofautility);
        $N0VDf = $VkvAi->getProperty("\x6d\x65\163\163\141\x67\145\x4d\x61\x6e\141\147\145\162");
        $N0VDf->setAccessible(true);
        $N0VDf->setValue($xd04q, $this->messageManager);
        $X3Xob = new \ReflectionClass(LKAction::class);
        $N0VDf = $X3Xob->getProperty("\x52\105\121\x55\x45\x53\x54");
        $N0VDf->setAccessible(true);
        $N0VDf->setValue($xd04q, ["\154\153" => "\153\145\171"]);
        $xd04q->expects($this->once())->method("\143\x68\145\x63\x6b\x49\x66\x52\x65\161\165\x69\162\x65\x64\x46\151\145\x6c\x64\163\105\x6d\x70\x74\x79");
        $xd04q->expects($this->never())->method("\137\166\x6c\153\x5f\x73\x75\x63\x63\145\x73\163");
        $xd04q->expects($this->once())->method("\x5f\x76\x6c\x6b\137\146\141\x69\x6c");
        $this->twofautility->method("\x63\143\154")->willReturn(["\x73\164\141\x74\x75\163" => "\106\101\x49\114\105\x44"]);
        $xd04q->execute();
    }
    public function testExecuteThrowsOnMissingRequest()
    {
        $xd04q = $this->getMockBuilder(LKAction::class)->disableOriginalConstructor()->onlyMethods(["\x63\150\145\x63\x6b\x49\x66\x52\145\161\x75\x69\162\145\x64\106\151\x65\x6c\x64\x73\105\155\160\x74\171"])->getMock();
        $VkvAi = new \ReflectionClass($xd04q);
        $N0VDf = $VkvAi->getProperty("\164\x77\157\146\x61\165\164\x69\154\x69\x74\171");
        $N0VDf->setAccessible(true);
        $N0VDf->setValue($xd04q, $this->twofautility);
        $N0VDf = $VkvAi->getProperty("\x6d\x65\163\x73\141\x67\145\x4d\x61\156\141\x67\x65\162");
        $N0VDf->setAccessible(true);
        $N0VDf->setValue($xd04q, $this->messageManager);
        $X3Xob = new \ReflectionClass(LKAction::class);
        $N0VDf = $X3Xob->getProperty("\x52\105\121\125\x45\123\x54");
        $N0VDf->setAccessible(true);
        $N0VDf->setValue($xd04q, []);
        $xd04q->expects($this->once())->method("\x63\x68\x65\x63\x6b\x49\x66\122\145\161\165\151\162\x65\144\106\151\x65\x6c\x64\163\x45\155\160\164\x79")->with(["\154\153" => []])->will($this->throwException(new \MiniOrange\TwoFA\Helper\Exception\RequiredFieldsException()));
        $this->expectException(\MiniOrange\TwoFA\Helper\Exception\RequiredFieldsException::class);
        $xd04q->execute();
    }
    public function testVlkSuccessWithSuccessStatus()
    {
        $xd04q = $this->getAction();
        $this->twofautility->method("\166\x6d\154")->willReturn(json_encode(["\163\x74\141\164\x75\163" => "\x53\x55\x43\x43\105\123\123"]));
        $this->twofautility->method("\147\x65\164\x53\x74\157\x72\145\x43\157\156\146\151\147")->willReturn("\x74\157\x6b\x65\x6e");
        $this->twofautility->expects($this->atLeastOnce())->method("\x73\145\x74\123\164\157\x72\145\103\157\156\x66\x69\147");
        $this->twofautility->expects($this->once())->method("\162\x65\x69\156\151\164\x43\x6f\x6e\x66\x69\x67");
        $this->messageManager->expects($this->once())->method("\141\x64\x64\x53\165\143\143\x65\163\x73\x4d\x65\163\x73\141\147\x65")->with(TwoFAMessages::LICENSE_VERIFIED);
        $xd04q->_vlk_success("\153\145\171");
    }
    public function testVlkSuccessWithFailedStatusExpired()
    {
        $xd04q = $this->getAction();
        $this->twofautility->method("\x76\x6d\x6c")->willReturn(json_encode(["\163\164\x61\x74\165\x73" => "\106\x41\111\114\105\x44", "\155\145\x73\163\x61\x67\x65" => "\x43\157\144\145\40\x68\x61\x73\40\x45\x78\x70\x69\162\145\x64"]));
        $this->messageManager->expects($this->once())->method("\x61\x64\x64\x45\x72\x72\x6f\162\x4d\145\x73\163\x61\147\145")->with(TwoFAMessages::LICENSE_KEY_IN_USE);
        $xd04q->_vlk_success("\x6b\145\171");
    }
    public function testVlkSuccessWithFailedStatusOther()
    {
        $xd04q = $this->getAction();
        $this->twofautility->method("\166\155\154")->willReturn(json_encode(["\163\x74\x61\x74\x75\x73" => "\106\101\111\114\x45\x44", "\x6d\145\x73\x73\141\x67\145" => "\x4f\x74\150\145\162\x20\x65\162\x72\157\162"]));
        $this->messageManager->expects($this->once())->method("\x61\144\144\105\x72\x72\x6f\162\115\x65\163\163\141\x67\x65")->with(TwoFAMessages::ENTERED_INVALID_KEY);
        $xd04q->_vlk_success("\153\x65\171");
    }
    public function testVlkSuccessWithInvalidArray()
    {
        $xd04q = $this->getAction();
        $this->twofautility->method("\x76\x6d\154")->willReturn(json_encode(["\146\x6f\x6f" => "\x62\141\162"]));
        $this->messageManager->expects($this->once())->method("\x61\x64\x64\x45\x72\x72\x6f\x72\115\145\x73\x73\141\x67\x65")->with(TwoFAMessages::ENTERED_INVALID_KEY);
        $xd04q->_vlk_success("\153\145\171");
    }
    public function testVlkFail()
    {
        $xd04q = $this->getAction();
        $this->twofautility->method("\x67\145\x74\x53\164\x6f\162\x65\x43\x6f\x6e\x66\x69\147")->willReturn("\164\157\153\145\156");
        $this->twofautility->expects($this->once())->method("\x73\x65\164\123\x74\x6f\x72\145\103\157\x6e\146\x69\x67");
        $this->messageManager->expects($this->once())->method("\x61\144\x64\105\x72\162\x6f\x72\x4d\x65\x73\x73\141\147\145")->with(TwoFAMessages::NOT_UPGRADED_YET);
        $xd04q->_vlk_fail();
    }
    public function testExtendTrial()
    {
        $xd04q = $this->getAction();
        $this->twofautility->expects($this->once())->method("\145\x78\x74\x65\x6e\x64\124\x72\x69\141\x6c");
        $xd04q->extendTrial();
    }
}