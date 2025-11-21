<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\RequiredFieldsException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class RequiredFieldsExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $mp4Zq = new RequiredFieldsException();
        $this->assertInstanceOf(RequiredFieldsException::class, $mp4Zq);
        $this->assertEquals(TwoFAMessages::parse("\122\x45\121\x55\x49\x52\105\x44\x5f\x46\x49\x45\114\x44\x53"), $mp4Zq->getMessage());
        $this->assertEquals(104, $mp4Zq->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $mp4Zq = new RequiredFieldsException();
        $KzbvG = RequiredFieldsException::class . "\x3a\x20\133\x31\60\64\135\x3a\x20" . $mp4Zq->getMessage() . "\12";
        $this->assertEquals($KzbvG, (string) $mp4Zq);
    }
}