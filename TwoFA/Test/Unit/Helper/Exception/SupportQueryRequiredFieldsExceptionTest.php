<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\SupportQueryRequiredFieldsException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class SupportQueryRequiredFieldsExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $OFBbs = new SupportQueryRequiredFieldsException();
        $this->assertInstanceOf(SupportQueryRequiredFieldsException::class, $OFBbs);
        $this->assertEquals(TwoFAMessages::parse("\122\x45\x51\x55\x49\x52\105\x44\x5f\121\125\105\122\131\x5f\106\x49\105\114\x44\123"), $OFBbs->getMessage());
        $this->assertEquals(109, $OFBbs->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $OFBbs = new SupportQueryRequiredFieldsException();
        $ROM3p = SupportQueryRequiredFieldsException::class . "\x3a\x20\x5b\61\x30\71\x5d\72\40" . $OFBbs->getMessage() . "\12";
        $this->assertEquals($ROM3p, (string) $OFBbs);
    }
}