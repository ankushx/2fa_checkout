<?php

namespace MiniOrange\TwoFA\Test\Unit\Model;

use MiniOrange\TwoFA\Model\Trusted;
use PHPUnit\Framework\TestCase;
class TrustedTest extends TestCase
{
    public function testGetIdentitiesReturnsCorrectTag()
    {
        $xi8oa = $this->getMockBuilder(Trusted::class)->disableOriginalConstructor()->setMethods(["\x67\x65\x74\111\144"])->getMock();
        $xi8oa->method("\147\145\x74\x49\x64")->willReturn(42);
        $E6crR = [Trusted::CACHE_TAG . "\137\x34\62"];
        $this->assertEquals($E6crR, $xi8oa->getIdentities());
    }
    public function testGetIdentitiesWithNullId()
    {
        $xi8oa = $this->getMockBuilder(Trusted::class)->disableOriginalConstructor()->setMethods(["\147\x65\x74\111\144"])->getMock();
        $xi8oa->method("\147\145\x74\x49\x64")->willReturn(null);
        $E6crR = [Trusted::CACHE_TAG . "\137"];
        $this->assertEquals($E6crR, $xi8oa->getIdentities());
    }
    public function testConstructCallsInitWithCorrectResourceModel()
    {
        $xi8oa = $this->getMockBuilder(Trusted::class)->disableOriginalConstructor()->setMethods(["\137\151\x6e\x69\x74"])->getMock();
        $xi8oa->expects($this->once())->method("\137\x69\x6e\x69\x74")->with("\x4d\151\x6e\x69\117\x72\x61\156\x67\145\x5c\x54\167\157\x46\101\134\115\x6f\144\145\154\x5c\x52\145\x73\157\x75\x72\143\145\x4d\x6f\144\x65\154\134\124\162\165\x73\164\x65\144");
        $xJOle = new \ReflectionClass(Trusted::class);
        $kgXkk = $xJOle->getMethod("\x5f\143\157\156\163\x74\162\165\143\x74");
        $kgXkk->setAccessible(true);
        $kgXkk->invoke($xi8oa);
    }
    public function testConstructCanBeCalledMultipleTimes()
    {
        $xi8oa = $this->getMockBuilder(Trusted::class)->disableOriginalConstructor()->setMethods(["\x5f\x69\156\x69\x74"])->getMock();
        $xi8oa->expects($this->exactly(2))->method("\137\x69\x6e\x69\x74")->with("\115\x69\156\x69\117\x72\x61\156\x67\145\134\124\167\x6f\106\x41\x5c\x4d\157\144\x65\154\134\122\145\163\157\x75\162\143\145\x4d\x6f\x64\145\x6c\x5c\x54\162\x75\x73\164\x65\x64");
        $xJOle = new \ReflectionClass(Trusted::class);
        $kgXkk = $xJOle->getMethod("\x5f\x63\x6f\x6e\163\x74\x72\x75\143\164");
        $kgXkk->setAccessible(true);
        $kgXkk->invoke($xi8oa);
        $kgXkk->invoke($xi8oa);
    }
    public function testConstructWorksInSubclass()
    {
        $xi8oa = $this->getMockBuilder(Trusted::class)->disableOriginalConstructor()->setMethods(["\137\x69\x6e\x69\x74"])->getMock();
        $xi8oa->expects($this->once())->method("\x5f\x69\156\x69\x74")->with("\x4d\x69\156\151\117\162\x61\156\147\145\134\x54\x77\x6f\106\101\134\115\x6f\x64\145\x6c\x5c\x52\x65\x73\x6f\x75\x72\x63\145\115\x6f\x64\145\154\134\124\x72\165\x73\x74\145\144");
        $xJOle = new \ReflectionClass(Trusted::class);
        $kgXkk = $xJOle->getMethod("\137\x63\157\156\x73\164\162\165\x63\164");
        $kgXkk->setAccessible(true);
        $kgXkk->invoke($xi8oa);
    }
    public function testGetIdentitiesWithGetIdException()
    {
        $xi8oa = $this->getMockBuilder(Trusted::class)->disableOriginalConstructor()->setMethods(["\147\x65\x74\x49\x64"])->getMock();
        $xi8oa->method("\x67\x65\164\x49\x64")->will($this->throwException(new \Exception("\146\141\x69\154")));
        $this->expectException(\Exception::class);
        $xi8oa->getIdentities();
    }
    public function testConstructWithInitException()
    {
        $xi8oa = $this->getMockBuilder(Trusted::class)->disableOriginalConstructor()->setMethods(["\137\x69\x6e\151\x74"])->getMock();
        $xi8oa->method("\x5f\151\156\x69\x74")->will($this->throwException(new \Exception("\146\141\151\154")));
        $xJOle = new \ReflectionClass(Trusted::class);
        $kgXkk = $xJOle->getMethod("\137\x63\157\x6e\163\x74\162\x75\x63\164");
        $kgXkk->setAccessible(true);
        $this->expectException(\Exception::class);
        $kgXkk->invoke($xi8oa);
    }
    public function testClassProperties()
    {
        $xi8oa = $this->getMockBuilder(Trusted::class)->disableOriginalConstructor()->getMock();
        $xJOle = new \ReflectionClass(Trusted::class);
        $VAVD_ = $xJOle->getProperty("\x5f\x63\x61\x63\x68\x65\x54\141\x67");
        $VAVD_->setAccessible(true);
        $Oql_b = $xJOle->getProperty("\x5f\x65\166\145\x6e\x74\120\162\145\146\151\x78");
        $Oql_b->setAccessible(true);
        $F19CS = $xJOle->getProperty("\x5f\151\144\106\x69\x65\154\x64\116\141\x6d\145");
        $F19CS->setAccessible(true);
        $this->assertEquals("\115\x69\x6e\151\117\162\141\156\147\145\137\164\167\157\146\x61\x63\x74\x6f\162\x61\165\x74\x68\137\x74\x72\x75\163\164\x65\144", $VAVD_->getValue($xi8oa));
        $this->assertEquals("\115\x69\156\x69\x4f\x72\141\x6e\147\x65\137\164\167\x6f\146\141\x63\164\157\x72\141\165\164\x68\x5f\164\162\x75\163\x74\145\x64", $Oql_b->getValue($xi8oa));
        $this->assertEquals("\x74\x72\165\163\164\x65\x64\137\151\x64", $F19CS->getValue($xi8oa));
    }
}