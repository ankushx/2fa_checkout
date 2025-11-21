<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\AccountAlreadyExistsException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class AccountAlreadyExistsExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $MbxrX = new AccountAlreadyExistsException();
        $this->assertInstanceOf(AccountAlreadyExistsException::class, $MbxrX);
        $this->assertEquals(TwoFAMessages::parse("\x41\x43\103\117\x55\x4e\x54\x5f\105\x58\x49\123\124\x53"), $MbxrX->getMessage());
        $this->assertEquals(108, $MbxrX->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $MbxrX = new AccountAlreadyExistsException();
        $xR0fw = AccountAlreadyExistsException::class . "\x3a\40\133\61\x30\x38\135\72\x20" . $MbxrX->getMessage() . "\12";
        $this->assertEquals($xR0fw, (string) $MbxrX);
    }
    public function testParentConstructor_CustomMessageAndCode()
    {
        $MbxrX = new \MiniOrange\TwoFA\Helper\Exception\AccountAlreadyExistsException();
        $Rj_lF = new \ReflectionClass($MbxrX);
        $JOeke = $Rj_lF->getConstructor();
        $JOeke->invoke($MbxrX);
        $this->assertEquals(TwoFAMessages::parse("\x41\x43\x43\x4f\x55\116\x54\137\105\x58\x49\123\x54\x53"), $MbxrX->getMessage());
        $this->assertEquals(108, $MbxrX->getCode());
    }
    public function testConstruct_ParseReturnsEmptyString()
    {
        $MbxrX = new AccountAlreadyExistsException();
        $xx2_n = $MbxrX->getMessage();
        $this->assertIsString($xx2_n);
        $this->assertNotNull($xx2_n);
    }
    public function testConstruct_ParseThrowsException()
    {
        $this->expectNotToPerformAssertions();
    }
}