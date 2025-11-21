<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\PasswordResetFailedException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class PasswordResetFailedExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $j5EZx = new PasswordResetFailedException();
        $this->assertInstanceOf(PasswordResetFailedException::class, $j5EZx);
        $this->assertEquals(TwoFAMessages::parse("\105\122\x52\117\122\x5f\x4f\x43\103\x55\122\x52\x45\x44"), $j5EZx->getMessage());
        $this->assertEquals(116, $j5EZx->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $j5EZx = new PasswordResetFailedException();
        $e1yTp = PasswordResetFailedException::class . "\72\40\x5b\61\61\x36\x5d\x3a\40" . $j5EZx->getMessage() . "\12";
        $this->assertEquals($e1yTp, (string) $j5EZx);
    }
}