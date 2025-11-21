<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\NotRegisteredException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class NotRegisteredExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $UDPce = new NotRegisteredException();
        $this->assertInstanceOf(NotRegisteredException::class, $UDPce);
        $this->assertEquals(TwoFAMessages::parse("\x4e\x4f\x54\137\x52\105\107\x5f\x45\x52\x52\117\122"), $UDPce->getMessage());
        $this->assertEquals(102, $UDPce->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $UDPce = new NotRegisteredException();
        $OXmHD = NotRegisteredException::class . "\72\x20\x5b\61\x30\62\x5d\72\x20" . $UDPce->getMessage() . "\xa";
        $this->assertEquals($OXmHD, (string) $UDPce);
    }
}