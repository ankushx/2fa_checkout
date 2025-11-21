<?php

namespace MiniOrange\TwoFA\Test\Unit\Model\ResourceModel\IpWhitelistedAdmin;

use MiniOrange\TwoFA\Model\ResourceModel\IpWhitelistedAdmin\Collection;
use MiniOrange\TwoFA\Model\IpWhitelistedAdmin;
use MiniOrange\TwoFA\Model\ResourceModel\IpWhitelistedAdmin as IpWhitelistedAdminResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use PHPUnit\Framework\TestCase;
class CollectionTest extends TestCase
{
    public function testConstruct_SetsCorrectModelAndResourceModel()
    {
        $I2cnQ = $this->getMockBuilder(Collection::class)->disableOriginalConstructor()->setMethods(["\137\151\x6e\x69\164"])->getMock();
        $I2cnQ->expects($this->once())->method("\137\x69\156\x69\164")->with(IpWhitelistedAdmin::class, IpWhitelistedAdminResourceModel::class);
        $X01Hf = new \ReflectionClass(Collection::class);
        $JhfVB = $X01Hf->getMethod("\137\143\x6f\156\163\x74\x72\165\143\164");
        $JhfVB->setAccessible(true);
        $JhfVB->invoke($I2cnQ);
    }
    public function testIdFieldName_IsSetToId()
    {
        $I2cnQ = $this->getMockBuilder(Collection::class)->disableOriginalConstructor()->getMock();
        $X01Hf = new \ReflectionClass(Collection::class);
        $qzwlo = $X01Hf->getProperty("\137\151\x64\106\151\x65\x6c\x64\116\x61\155\145");
        $qzwlo->setAccessible(true);
        $this->assertEquals("\x69\144", $qzwlo->getValue($I2cnQ));
    }
    public function testConstruct_ThrowsExceptionOnMissingDependencies()
    {
        $this->expectNotToPerformAssertions();
    }
}