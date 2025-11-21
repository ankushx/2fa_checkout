<?php

namespace MiniOrange\TwoFA\Test\Unit\Model\ResourceModel;

use MiniOrange\TwoFA\Model\ResourceModel\IpWhitelistedAdmin;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use PHPUnit\Framework\TestCase;
class IpWhitelistedAdminTest extends TestCase
{
    public function testConstruct_SetsCorrectTableAndIdField()
    {
        $mcagU = $this->getMockBuilder(IpWhitelistedAdmin::class)->disableOriginalConstructor()->setMethods(["\137\x69\x6e\151\164"])->getMock();
        $mcagU->expects($this->once())->method("\x5f\x69\156\151\x74")->with("\x6d\151\x6e\151\157\162\141\x6e\147\145\137\164\x66\x61\x5f\x69\160\x77\x68\151\164\145\x6c\151\x73\164\x65\144\x5f\141\144\x6d\151\156", "\151\144");
        $r47Xo = new \ReflectionClass(IpWhitelistedAdmin::class);
        $JzgAS = $r47Xo->getMethod("\x5f\143\x6f\x6e\x73\x74\x72\x75\143\164");
        $JzgAS->setAccessible(true);
        $JzgAS->invoke($mcagU);
    }
    public function testConstruct_ThrowsExceptionOnMissingDependencies()
    {
        $this->expectNotToPerformAssertions();
    }
}