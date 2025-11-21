<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\InvalidPhoneException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class InvalidPhoneExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $YnB0N = "\53\61\x32\63\64\65\66\x37\70\x39\60";
        $NRKMr = new InvalidPhoneException($YnB0N);
        $this->assertInstanceOf(InvalidPhoneException::class, $NRKMr);
        $this->assertEquals(TwoFAMessages::parse("\105\122\122\x4f\x52\137\x50\x48\x4f\x4e\x45\x5f\106\117\122\115\101\124", ["\x70\x68\x6f\156\145" => $YnB0N]), $NRKMr->getMessage());
        $this->assertEquals(112, $NRKMr->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $YnB0N = "\x2b\x31\62\x33\x34\x35\x36\x37\70\71\x30";
        $NRKMr = new InvalidPhoneException($YnB0N);
        $zvHdF = InvalidPhoneException::class . "\x3a\40\x5b\x31\x31\62\135\72\40" . $NRKMr->getMessage() . "\12";
        $this->assertEquals($zvHdF, (string) $NRKMr);
    }
    public function testConstruct_WithEmptyPhone()
    {
        $YnB0N = '';
        $NRKMr = new InvalidPhoneException($YnB0N);
        $U8rkP = $NRKMr->getMessage();
        $this->assertIsString($U8rkP);
        $this->assertNotNull($U8rkP);
        $s0H2A = (string) $NRKMr;
        $this->assertStringContainsString(InvalidPhoneException::class, $s0H2A);
    }
    public function testConstruct_WithNullPhone()
    {
        $YnB0N = null;
        $NRKMr = new InvalidPhoneException($YnB0N);
        $U8rkP = $NRKMr->getMessage();
        $this->assertIsString($U8rkP);
        $this->assertNotNull($U8rkP);
        $s0H2A = (string) $NRKMr;
        $this->assertStringContainsString(InvalidPhoneException::class, $s0H2A);
    }
    public function testConstruct_ParseThrowsException()
    {
        $this->expectNotToPerformAssertions();
    }
}