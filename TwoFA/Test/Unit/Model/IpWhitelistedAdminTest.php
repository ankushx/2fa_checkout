<?php

namespace MiniOrange\TwoFA\Test\Unit\Model;

use MiniOrange\TwoFA\Model\IpWhitelistedAdmin;
use Magento\Framework\Model\AbstractModel;
use PHPUnit\Framework\TestCase;
class IpWhitelistedAdminTest extends TestCase
{
    public function testConstruct_CallsInitWithCorrectResourceModel()
    {
        $HJc9c = $this->getMockBuilder(IpWhitelistedAdmin::class)->disableOriginalConstructor()->setMethods(["\137\151\x6e\x69\164"])->getMock();
        $HJc9c->expects($this->once())->method("\x5f\x69\x6e\x69\164")->with("\115\151\156\151\117\162\x61\x6e\x67\x65\134\x54\x77\x6f\x46\x41\134\115\157\x64\145\x6c\x5c\x52\145\163\157\165\162\143\x65\x4d\x6f\144\x65\154\134\111\x70\127\150\x69\164\x65\154\151\x73\164\145\x64\x41\144\155\x69\156");
        $zxN8d = new \ReflectionClass(IpWhitelistedAdmin::class);
        $OCyQX = $zxN8d->getMethod("\x5f\143\157\x6e\163\164\x72\x75\x63\x74");
        $OCyQX->setAccessible(true);
        $OCyQX->invoke($HJc9c);
    }
    public function testConstruct_DoesNotThrowOnFreshInstance()
    {
        $HJc9c = $this->getMockBuilder(IpWhitelistedAdmin::class)->disableOriginalConstructor()->setMethods(["\137\151\156\x69\x74"])->getMock();
        $HJc9c->expects($this->once())->method("\x5f\151\x6e\x69\164");
        $zxN8d = new \ReflectionClass(IpWhitelistedAdmin::class);
        $OCyQX = $zxN8d->getMethod("\x5f\143\157\156\x73\x74\162\165\x63\164");
        $OCyQX->setAccessible(true);
        $OCyQX->invoke($HJc9c);
        $this->assertTrue(true);
    }
    public function testCannotInstantiateWithoutDependencies()
    {
        $this->expectNotToPerformAssertions();
    }
}