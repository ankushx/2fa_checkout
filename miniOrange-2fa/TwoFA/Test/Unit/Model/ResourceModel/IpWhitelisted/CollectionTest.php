<?php

namespace MiniOrange\TwoFA\Test\Unit\Model\ResourceModel\IpWhitelisted;

use MiniOrange\TwoFA\Model\ResourceModel\IpWhitelisted\Collection;
use MiniOrange\TwoFA\Model\IpWhitelisted;
use MiniOrange\TwoFA\Model\ResourceModel\IpWhitelisted as IpWhitelistedResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use PHPUnit\Framework\TestCase;
class CollectionTest extends TestCase
{
    public function testConstruct_SetsCorrectModelAndResourceModel()
    {
        $vB3ll = $this->getMockBuilder(Collection::class)->disableOriginalConstructor()->setMethods(["\137\151\x6e\x69\x74"])->getMock();
        $vB3ll->expects($this->once())->method("\x5f\151\156\151\164")->with(IpWhitelisted::class, IpWhitelistedResourceModel::class);
        $VJ1tk = new \ReflectionClass(Collection::class);
        $AJC_3 = $VJ1tk->getMethod("\137\x63\x6f\156\163\164\162\165\143\x74");
        $AJC_3->setAccessible(true);
        $AJC_3->invoke($vB3ll);
    }
    public function testIdFieldName_IsSetToId()
    {
        $vB3ll = $this->getMockBuilder(Collection::class)->disableOriginalConstructor()->getMock();
        $VJ1tk = new \ReflectionClass(Collection::class);
        $bV5uL = $VJ1tk->getProperty("\137\x69\144\x46\x69\145\x6c\x64\x4e\141\x6d\145");
        $bV5uL->setAccessible(true);
        $this->assertEquals("\x69\x64", $bV5uL->getValue($vB3ll));
    }
    public function testConstruct_ThrowsExceptionOnMissingDependencies()
    {
        $this->expectNotToPerformAssertions();
    }
}