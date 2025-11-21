<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\UserEmailNotFoundException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class UserEmailNotFoundExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $QDK0E = new UserEmailNotFoundException();
        $this->assertInstanceOf(UserEmailNotFoundException::class, $QDK0E);
        $this->assertEquals(TwoFAMessages::parse("\x45\x4d\101\111\114\x5f\101\124\x54\x52\111\102\x55\x54\x45\137\116\x4f\124\137\122\105\124\125\122\116\x45\104"), $QDK0E->getMessage());
        $this->assertEquals(120, $QDK0E->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $QDK0E = new UserEmailNotFoundException();
        $F5GiS = UserEmailNotFoundException::class . "\72\x20\133\x31\62\60\x5d\72\x20" . $QDK0E->getMessage() . "\12";
        $this->assertEquals($F5GiS, (string) $QDK0E);
    }
}