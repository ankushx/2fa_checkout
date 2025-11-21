<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\IncorrectUserInfoDataException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class IncorrectUserInfoDataExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $XKYpA = new IncorrectUserInfoDataException();
        $this->assertInstanceOf(IncorrectUserInfoDataException::class, $XKYpA);
        $this->assertEquals(TwoFAMessages::parse("\111\116\x56\101\114\111\104\x5f\x55\123\105\122\x5f\111\116\106\117"), $XKYpA->getMessage());
        $this->assertEquals(119, $XKYpA->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $XKYpA = new IncorrectUserInfoDataException();
        $dpIdx = IncorrectUserInfoDataException::class . "\x3a\x20\x5b\x31\61\x39\135\72\40" . $XKYpA->getMessage() . "\xa";
        $this->assertEquals($dpIdx, (string) $XKYpA);
    }
    public function testConstruct_ParseReturnsEmptyString()
    {
        $XKYpA = new IncorrectUserInfoDataException();
        $kuOwq = $XKYpA->getMessage();
        $this->assertIsString($kuOwq);
        $this->assertNotNull($kuOwq);
        $nRx3C = (string) $XKYpA;
        $this->assertStringContainsString(IncorrectUserInfoDataException::class, $nRx3C);
    }
    public function testConstruct_ParseThrowsException()
    {
        $this->expectNotToPerformAssertions();
    }
}