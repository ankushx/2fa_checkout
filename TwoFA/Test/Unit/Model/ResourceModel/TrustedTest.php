<?php

namespace MiniOrange\TwoFA\Test\Unit\Model\ResourceModel;

use MiniOrange\TwoFA\Model\ResourceModel\Trusted;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\AbstractModel;
use PHPUnit\Framework\TestCase;
use Magento\Framework\Exception\LocalizedException;
class TrustedTest extends TestCase
{
    private $contextMock;
    private $dateTimeMock;
    private $trusted;
    protected function setUp() : void
    {
        $this->contextMock = $this->createMock(Context::class);
        $this->dateTimeMock = $this->createMock(DateTime::class);
        $this->trusted = $this->getMockBuilder(Trusted::class)->setConstructorArgs([$this->contextMock, $this->dateTimeMock])->setMethods(["\147\145\164\x43\157\x6e\x6e\x65\x63\x74\x69\x6f\x6e", "\x67\145\x74\115\x61\151\156\x54\141\142\x6c\145"])->getMock();
    }
    public function testConstruct_SetsCorrectTableAndIdField()
    {
        $Y5wHp = $this->getMockBuilder(Trusted::class)->disableOriginalConstructor()->setMethods(["\137\x69\x6e\151\x74"])->getMock();
        $Y5wHp->expects($this->once())->method("\x5f\x69\x6e\151\164")->with("\x4d\x69\x6e\x69\x4f\162\141\156\x67\145\x5f\x74\167\x6f\146\141\x63\164\x6f\x72\141\x75\164\150\137\164\x72\x75\163\164\x65\144", "\164\162\165\163\164\145\x64\137\x69\144");
        $mns3T = new \ReflectionClass(Trusted::class);
        $Qexaf = $mns3T->getMethod("\137\143\x6f\156\x73\164\162\x75\143\x74");
        $Qexaf->setAccessible(true);
        $Qexaf->invoke($Y5wHp);
    }
    public function testGetExistTrusted_ReturnsTrustedId()
    {
        $I9nSq = $this->createMock(AdapterInterface::class);
        $i1Zna = $this->getMockBuilder("\x73\164\144\x43\154\x61\163\163")->setMethods(["\x66\x72\157\x6d", "\x77\150\x65\x72\145"])->getMock();
        $i1Zna->expects($this->once())->method("\146\162\157\155")->willReturnSelf();
        $i1Zna->expects($this->exactly(3))->method("\x77\150\x65\x72\x65")->willReturnSelf();
        $I9nSq->expects($this->once())->method("\x73\145\154\145\143\x74")->willReturn($i1Zna);
        $I9nSq->expects($this->once())->method("\146\145\x74\x63\150\x4f\156\x65")->willReturn("\64\62");
        $this->trusted->method("\x67\145\164\x43\x6f\156\156\145\143\164\151\x6f\x6e")->willReturn($I9nSq);
        $this->trusted->method("\x67\x65\164\x4d\141\151\156\124\141\x62\x6c\x65")->willReturn("\x4d\151\x6e\x69\117\x72\x61\156\147\145\x5f\164\167\x6f\146\141\143\164\157\x72\141\165\x74\x68\x5f\x74\x72\165\x73\164\145\x64");
        $l3lFZ = $this->trusted->getExistTrusted(1, "\x64\145\x76\151\143\x65", "\61\x32\67\56\x30\x2e\60\x2e\x31");
        $this->assertEquals("\64\x32", $l3lFZ);
    }
    public function testGetExistTrusted_ReturnsNullWhenNotFound()
    {
        $I9nSq = $this->createMock(AdapterInterface::class);
        $i1Zna = $this->getMockBuilder("\163\164\x64\x43\154\141\x73\163")->setMethods(["\x66\162\x6f\155", "\167\x68\145\162\x65"])->getMock();
        $i1Zna->expects($this->once())->method("\x66\162\x6f\155")->willReturnSelf();
        $i1Zna->expects($this->exactly(3))->method("\167\x68\145\162\145")->willReturnSelf();
        $I9nSq->expects($this->once())->method("\163\x65\x6c\x65\x63\x74")->willReturn($i1Zna);
        $I9nSq->expects($this->once())->method("\146\145\x74\143\x68\x4f\156\145")->willReturn(false);
        $this->trusted->method("\147\145\164\x43\x6f\x6e\156\x65\143\164\x69\x6f\156")->willReturn($I9nSq);
        $this->trusted->method("\147\x65\164\115\x61\x69\x6e\124\141\142\154\145")->willReturn("\115\151\156\151\x4f\162\x61\x6e\147\x65\x5f\164\167\157\x66\x61\143\164\x6f\x72\x61\x75\x74\x68\x5f\164\x72\165\163\164\145\x64");
        $l3lFZ = $this->trusted->getExistTrusted(1, "\144\145\x76\151\143\x65", "\61\x32\x37\56\60\x2e\x30\x2e\x31");
        $this->assertFalse($l3lFZ);
    }
    public function testBeforeSave_SetsCreatedAtIfNotSet()
    {
        $vxuD9 = $this->getMockBuilder(AbstractModel::class)->disableOriginalConstructor()->addMethods(["\147\x65\164\103\162\x65\141\164\145\144\101\x74", "\x73\x65\164\x43\x72\145\x61\x74\x65\144\x41\164"])->getMock();
        $vxuD9->expects($this->once())->method("\147\145\x74\103\162\x65\141\164\145\x64\101\x74")->willReturn(false);
        $this->dateTimeMock->expects($this->once())->method("\144\141\x74\x65")->willReturn("\x32\60\62\x34\55\60\x31\x2d\60\x31\x20\60\60\x3a\60\60\72\60\60");
        $vxuD9->expects($this->once())->method("\x73\x65\164\x43\162\x65\141\x74\145\x64\101\164")->with("\62\60\x32\64\x2d\x30\61\x2d\60\61\40\60\60\72\x30\60\72\x30\60");
        $mns3T = new \ReflectionClass(Trusted::class);
        $Qexaf = $mns3T->getMethod("\137\142\145\x66\x6f\162\145\123\x61\166\x65");
        $Qexaf->setAccessible(true);
        $l3lFZ = $Qexaf->invoke($this->trusted, $vxuD9);
        $this->assertSame($this->trusted, $l3lFZ);
    }
    public function testBeforeSave_DoesNotOverwriteCreatedAtIfSet()
    {
        $vxuD9 = $this->getMockBuilder(AbstractModel::class)->disableOriginalConstructor()->addMethods(["\x67\x65\x74\103\162\x65\x61\164\145\x64\101\x74", "\x73\x65\x74\x43\162\x65\141\164\x65\x64\x41\x74"])->getMock();
        $vxuD9->expects($this->once())->method("\x67\x65\164\103\x72\145\141\x74\145\x64\x41\x74")->willReturn("\62\x30\62\64\x2d\60\x31\x2d\x30\x31\x20\x30\x30\x3a\x30\x30\72\x30\x30");
        $this->dateTimeMock->expects($this->never())->method("\x64\x61\164\x65");
        $vxuD9->expects($this->never())->method("\x73\145\164\103\162\145\x61\164\x65\x64\x41\164");
        $mns3T = new \ReflectionClass(Trusted::class);
        $Qexaf = $mns3T->getMethod("\x5f\x62\145\146\157\162\145\x53\x61\166\145");
        $Qexaf->setAccessible(true);
        $l3lFZ = $Qexaf->invoke($this->trusted, $vxuD9);
        $this->assertSame($this->trusted, $l3lFZ);
    }
    public function testGetExistTrusted_WithInvalidParams()
    {
        $I9nSq = $this->createMock(AdapterInterface::class);
        $i1Zna = $this->getMockBuilder("\163\x74\x64\103\154\141\x73\x73")->setMethods(["\146\162\x6f\155", "\167\x68\145\162\x65"])->getMock();
        $i1Zna->expects($this->once())->method("\146\x72\x6f\155")->willReturnSelf();
        $i1Zna->expects($this->exactly(3))->method("\x77\150\x65\x72\x65")->willReturnSelf();
        $I9nSq->expects($this->once())->method("\163\x65\x6c\145\143\x74")->willReturn($i1Zna);
        $I9nSq->expects($this->once())->method("\146\145\x74\143\150\x4f\156\145")->willReturn(false);
        $this->trusted->method("\147\145\164\103\157\156\x6e\145\x63\x74\x69\157\156")->willReturn($I9nSq);
        $this->trusted->method("\x67\145\164\115\141\151\156\124\141\142\x6c\x65")->willReturn("\x4d\151\x6e\151\x4f\162\141\x6e\147\145\137\x74\167\x6f\x66\141\143\164\x6f\x72\x61\165\164\x68\137\x74\x72\165\x73\164\x65\x64");
        $l3lFZ = $this->trusted->getExistTrusted(null, null, null);
        $this->assertFalse($l3lFZ);
    }
    public function testBeforeSave_WithMissingDateTime()
    {
        $vxuD9 = $this->getMockBuilder(AbstractModel::class)->disableOriginalConstructor()->addMethods(["\147\x65\x74\103\162\145\141\x74\x65\144\101\164", "\163\145\x74\x43\x72\145\141\x74\145\x64\101\164"])->getMock();
        $vxuD9->expects($this->once())->method("\x67\145\164\103\162\x65\x61\164\x65\144\x41\164")->willReturn(false);
        $this->dateTimeMock->expects($this->once())->method("\x64\x61\x74\145")->willReturn(null);
        $vxuD9->expects($this->once())->method("\x73\145\164\103\162\145\x61\x74\145\x64\x41\164")->with(null);
        $mns3T = new \ReflectionClass(Trusted::class);
        $Qexaf = $mns3T->getMethod("\137\x62\145\146\x6f\162\x65\123\141\166\x65");
        $Qexaf->setAccessible(true);
        $l3lFZ = $Qexaf->invoke($this->trusted, $vxuD9);
        $this->assertSame($this->trusted, $l3lFZ);
    }
}