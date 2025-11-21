<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\InvalidOperationException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class InvalidOperationExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $klDrs = new InvalidOperationException();
        $this->assertInstanceOf(InvalidOperationException::class, $klDrs);
        $this->assertEquals(TwoFAMessages::parse("\x49\x4e\x56\101\114\111\104\137\117\x50"), $klDrs->getMessage());
        $this->assertEquals(105, $klDrs->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $klDrs = new InvalidOperationException();
        $cT6GX = InvalidOperationException::class . "\x3a\x20\x5b\61\60\x35\x5d\x3a\x20" . $klDrs->getMessage() . "\12";
        $this->assertEquals($cT6GX, (string) $klDrs);
    }
    public function testConstruct_ParseReturnsEmptyString()
    {
        $klDrs = new InvalidOperationException();
        $Fci29 = $klDrs->getMessage();
        $this->assertIsString($Fci29);
        $this->assertNotNull($Fci29);
        $X1tj7 = (string) $klDrs;
        $this->assertStringContainsString(InvalidOperationException::class, $X1tj7);
    }
    public function testConstruct_ParseThrowsException()
    {
        $this->expectNotToPerformAssertions();
    }
}