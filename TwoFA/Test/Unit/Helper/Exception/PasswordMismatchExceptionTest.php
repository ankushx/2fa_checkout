<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\PasswordMismatchException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class PasswordMismatchExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $TyhX1 = new PasswordMismatchException();
        $this->assertInstanceOf(PasswordMismatchException::class, $TyhX1);
        $this->assertEquals(TwoFAMessages::parse("\120\x41\x53\x53\137\115\x49\x53\115\101\x54\103\110"), $TyhX1->getMessage());
        $this->assertEquals(122, $TyhX1->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $TyhX1 = new PasswordMismatchException();
        $JaZ1Y = PasswordMismatchException::class . "\72\x20\x5b\61\62\x32\x5d\72\40" . $TyhX1->getMessage() . "\xa";
        $this->assertEquals($JaZ1Y, (string) $TyhX1);
    }
}