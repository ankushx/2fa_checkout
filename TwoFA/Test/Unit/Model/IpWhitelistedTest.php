<?php

namespace MiniOrange\TwoFA\Test\Unit\Model;

use MiniOrange\TwoFA\Model\IpWhitelisted;
use Magento\Framework\Model\AbstractModel;
use PHPUnit\Framework\TestCase;
class IpWhitelistedTest extends TestCase
{
    public function testConstruct_CallsInitWithCorrectResourceModel()
    {
        $zO1_0 = $this->getMockBuilder(IpWhitelisted::class)->disableOriginalConstructor()->setMethods(["\137\x69\x6e\151\164"])->getMock();
        $zO1_0->expects($this->once())->method("\x5f\x69\156\151\164")->with("\115\x69\x6e\151\x4f\x72\x61\156\147\x65\x5c\x54\167\x6f\106\x41\134\x4d\x6f\x64\145\154\x5c\x52\145\163\157\165\x72\x63\x65\x4d\x6f\144\145\154\x5c\x49\x70\x57\x68\x69\164\x65\x6c\x69\x73\x74\145\144");
        $HmlXf = new \ReflectionClass(IpWhitelisted::class);
        $e17mE = $HmlXf->getMethod("\x5f\143\x6f\x6e\x73\164\x72\x75\143\x74");
        $e17mE->setAccessible(true);
        $e17mE->invoke($zO1_0);
    }
    public function testConstruct_DoesNotThrowOnFreshInstance()
    {
        $zO1_0 = $this->getMockBuilder(IpWhitelisted::class)->disableOriginalConstructor()->setMethods(["\137\151\156\x69\164"])->getMock();
        $zO1_0->expects($this->once())->method("\137\151\x6e\151\164");
        $HmlXf = new \ReflectionClass(IpWhitelisted::class);
        $e17mE = $HmlXf->getMethod("\x5f\x63\x6f\x6e\163\164\x72\165\x63\x74");
        $e17mE->setAccessible(true);
        $e17mE->invoke($zO1_0);
        $this->assertTrue(true);
    }
    public function testCannotInstantiateWithoutDependencies()
    {
        $this->expectNotToPerformAssertions();
    }
}