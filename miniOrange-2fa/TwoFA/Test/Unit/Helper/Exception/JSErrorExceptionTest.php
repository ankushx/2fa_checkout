<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\JSErrorException;
use PHPUnit\Framework\TestCase;
class JSErrorExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $TOwOs = "\x41\x20\x4a\x53\40\x65\162\162\x6f\x72\40\x6f\143\x63\165\162\162\x65\144";
        $ZgUEw = new JSErrorException($TOwOs);
        $this->assertInstanceOf(JSErrorException::class, $ZgUEw);
        $this->assertEquals($TOwOs, $ZgUEw->getMessage());
        $this->assertEquals(103, $ZgUEw->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $TOwOs = "\x41\40\x4a\123\x20\x65\x72\162\157\x72\40\x6f\143\x63\165\x72\162\145\x64";
        $ZgUEw = new JSErrorException($TOwOs);
        $bBdEM = JSErrorException::class . "\72\x20\133\61\60\x33\x5d\72\x20" . $TOwOs . "\xa";
        $this->assertEquals($bBdEM, (string) $ZgUEw);
    }
    public function testConstruct_WithEmptyMessage()
    {
        $TOwOs = '';
        $ZgUEw = new JSErrorException($TOwOs);
        $this->assertEquals('', $ZgUEw->getMessage());
        $this->assertEquals(103, $ZgUEw->getCode());
        $DKLCo = (string) $ZgUEw;
        $this->assertStringContainsString(JSErrorException::class, $DKLCo);
    }
    public function testConstruct_WithNullMessage()
    {
        $TOwOs = null;
        $ZgUEw = new JSErrorException($TOwOs);
        $this->assertEquals('', $ZgUEw->getMessage());
        $this->assertEquals(103, $ZgUEw->getCode());
        $DKLCo = (string) $ZgUEw;
        $this->assertStringContainsString(JSErrorException::class, $DKLCo);
    }
}