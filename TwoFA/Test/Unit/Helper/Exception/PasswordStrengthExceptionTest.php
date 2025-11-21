<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\PasswordStrengthException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class PasswordStrengthExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $TtrgM = new PasswordStrengthException();
        $this->assertInstanceOf(PasswordStrengthException::class, $TtrgM);
        $this->assertEquals(TwoFAMessages::parse("\x49\116\x56\x41\x4c\x49\104\x5f\x50\x41\x53\x53\137\123\124\122\x45\116\x47\124\110"), $TtrgM->getMessage());
        $this->assertEquals(110, $TtrgM->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $TtrgM = new PasswordStrengthException();
        $HSIIF = PasswordStrengthException::class . "\x3a\x20\133\61\61\x30\135\x3a\40" . $TtrgM->getMessage() . "\xa";
        $this->assertEquals($HSIIF, (string) $TtrgM);
    }
}