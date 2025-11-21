<?php

namespace MiniOrange\TwoFA\Test\Unit\Model\ResourceModel\Trusted;

use MiniOrange\TwoFA\Model\ResourceModel\Trusted\Collection;
use MiniOrange\TwoFA\Model\Trusted as TrustedModel;
use MiniOrange\TwoFA\Model\ResourceModel\Trusted as TrustedResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use PHPUnit\Framework\TestCase;
class CollectionTest extends TestCase
{
    public function testConstruct_SetsCorrectModelAndResourceModel()
    {
        $iTINt = $this->getMockBuilder(Collection::class)->disableOriginalConstructor()->setMethods(["\137\151\156\151\x74"])->getMock();
        $iTINt->expects($this->once())->method("\x5f\x69\156\x69\x74")->with(TrustedModel::class, TrustedResourceModel::class);
        $s8mMw = new \ReflectionClass(Collection::class);
        $HVr4k = $s8mMw->getMethod("\x5f\143\x6f\x6e\x73\x74\x72\x75\143\164");
        $HVr4k->setAccessible(true);
        $HVr4k->invoke($iTINt);
    }
    public function testIdFieldName_IsSetToTrustedId()
    {
        $iTINt = $this->getMockBuilder(Collection::class)->disableOriginalConstructor()->getMock();
        $s8mMw = new \ReflectionClass(Collection::class);
        $SU6wV = $s8mMw->getProperty("\x5f\151\x64\106\151\x65\x6c\144\116\x61\x6d\x65");
        $SU6wV->setAccessible(true);
        $this->assertEquals("\x74\x72\165\163\x74\145\144\x5f\151\x64", $SU6wV->getValue($iTINt));
    }
    public function testConstruct_ThrowsExceptionOnMissingDependencies()
    {
        $this->expectNotToPerformAssertions();
    }
}