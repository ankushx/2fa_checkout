<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\OtpValidateFailureException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class OtpValidateFailureExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $fKDXz = new OtpValidateFailureException();
        $this->assertInstanceOf(OtpValidateFailureException::class, $fKDXz);
        $this->assertEquals(TwoFAMessages::parse("\117\x54\120\137\123\x45\116\124\x5f\x46\x41\x49\x4c\105\x44"), $fKDXz->getMessage());
        $this->assertEquals(143, $fKDXz->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $fKDXz = new OtpValidateFailureException();
        $DnLe3 = OtpValidateFailureException::class . "\72\40\x5b\x31\x34\x33\135\72\x20" . $fKDXz->getMessage() . "\12";
        $this->assertEquals($DnLe3, (string) $fKDXz);
    }
}