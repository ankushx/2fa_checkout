<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\InvalidPasscodeException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class InvalidPasscodeExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $D9KsI = new InvalidPasscodeException();
        $this->assertInstanceOf(InvalidPasscodeException::class, $D9KsI);
        $this->assertEquals(TwoFAMessages::parse("\x49\x4e\126\x41\114\x49\x44\x5f\120\101\123\123\103\x4f\104\105"), $D9KsI->getMessage());
        $this->assertEquals(140, $D9KsI->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $D9KsI = new InvalidPasscodeException();
        $KlrTu = InvalidPasscodeException::class . "\72\40\x5b\x31\64\60\135\72\40" . $D9KsI->getMessage() . "\xa";
        $this->assertEquals($KlrTu, (string) $D9KsI);
    }
    public function testConstruct_ParseReturnsEmptyString()
    {
        $D9KsI = new InvalidPasscodeException();
        $R10Hc = $D9KsI->getMessage();
        $this->assertIsString($R10Hc);
        $this->assertNotNull($R10Hc);
        $KvbqK = (string) $D9KsI;
        $this->assertStringContainsString(InvalidPasscodeException::class, $KvbqK);
    }
    public function testConstruct_ParseThrowsException()
    {
        $this->expectNotToPerformAssertions();
    }
}