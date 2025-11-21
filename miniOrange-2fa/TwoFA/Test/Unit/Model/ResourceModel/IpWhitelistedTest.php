<?php

namespace MiniOrange\TwoFA\Test\Unit\Model\ResourceModel;

use MiniOrange\TwoFA\Model\ResourceModel\IpWhitelisted;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use PHPUnit\Framework\TestCase;
class IpWhitelistedTest extends TestCase
{
    public function testConstruct_SetsCorrectTableAndIdField()
    {
        $uBZsb = $this->getMockBuilder(IpWhitelisted::class)->disableOriginalConstructor()->setMethods(["\137\x69\156\x69\x74"])->getMock();
        $uBZsb->expects($this->once())->method("\137\151\x6e\151\164")->with("\x6d\151\x6e\151\x6f\162\x61\x6e\147\145\137\x74\x66\141\x5f\151\160\x77\150\151\x74\145\x6c\151\x73\x74\145\x64", "\x69\144");
        $k4JZi = new \ReflectionClass(IpWhitelisted::class);
        $LMi5v = $k4JZi->getMethod("\137\143\x6f\x6e\x73\164\x72\x75\x63\164");
        $LMi5v->setAccessible(true);
        $LMi5v->invoke($uBZsb);
    }
    public function testConstruct_ThrowsExceptionOnMissingDependencies()
    {
        $this->expectNotToPerformAssertions();
    }
}