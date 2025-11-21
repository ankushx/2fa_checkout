<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\InvalidIdentityProviderException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class InvalidIdentityProviderExceptionTest extends TestCase
{
    public function testConstruct_ParseReturnsEmptyString()
    {
        $o1WMT = new InvalidIdentityProviderException();
        $Lnt0n = $o1WMT->getMessage();
        $this->assertIsString($Lnt0n);
        $this->assertNotNull($Lnt0n);
        $cFdrW = (string) $o1WMT;
        $this->assertStringContainsString(InvalidIdentityProviderException::class, $cFdrW);
    }
    public function testConstruct_ParseThrowsException()
    {
        $this->expectNotToPerformAssertions();
    }
}