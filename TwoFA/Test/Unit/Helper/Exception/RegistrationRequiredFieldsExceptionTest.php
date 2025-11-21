<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\RegistrationRequiredFieldsException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class RegistrationRequiredFieldsExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $N5QgO = new RegistrationRequiredFieldsException();
        $this->assertInstanceOf(RegistrationRequiredFieldsException::class, $N5QgO);
        $this->assertEquals(TwoFAMessages::parse("\122\105\x51\125\x49\x52\105\104\137\122\x45\107\x49\123\124\122\101\124\111\x4f\x4e\137\106\111\x45\114\104\123"), $N5QgO->getMessage());
        $this->assertEquals(111, $N5QgO->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $N5QgO = new RegistrationRequiredFieldsException();
        $jGZq2 = RegistrationRequiredFieldsException::class . "\x3a\40\133\61\x31\61\135\72\x20" . $N5QgO->getMessage() . "\xa";
        $this->assertEquals($jGZq2, (string) $N5QgO);
    }
}