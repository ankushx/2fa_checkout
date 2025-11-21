<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\OtpSentFailureException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class OtpSentFailureExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $Zwd8y = new OtpSentFailureException();
        $this->assertInstanceOf(OtpSentFailureException::class, $Zwd8y);
        $this->assertEquals(TwoFAMessages::parse("\x4f\x54\x50\x5f\123\x45\x4e\x54\x5f\106\x41\111\114\105\x44"), $Zwd8y->getMessage());
        $this->assertEquals(141, $Zwd8y->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $Zwd8y = new OtpSentFailureException();
        $E3Jwc = OtpSentFailureException::class . "\x3a\40\133\61\64\61\x5d\72\40" . $Zwd8y->getMessage() . "\12";
        $this->assertEquals($E3Jwc, (string) $Zwd8y);
    }
}