<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\NoIdentityProviderConfiguredException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class NoIdentityProviderConfiguredExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $kpybX = new NoIdentityProviderConfiguredException();
        $this->assertInstanceOf(NoIdentityProviderConfiguredException::class, $kpybX);
        $this->assertEquals(TwoFAMessages::parse("\116\117\x5f\x49\x44\x50\x5f\x43\x4f\x4e\106\111\x47"), $kpybX->getMessage());
        $this->assertEquals(101, $kpybX->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $kpybX = new NoIdentityProviderConfiguredException();
        $cX30x = NoIdentityProviderConfiguredException::class . "\x3a\40\x5b\61\60\x31\135\x3a\40" . $kpybX->getMessage() . "\12";
        $this->assertEquals($cX30x, (string) $kpybX);
    }
}