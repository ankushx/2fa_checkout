<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\MissingAttributesException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class MissingAttributesExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $Q0kPF = new MissingAttributesException();
        $this->assertInstanceOf(MissingAttributesException::class, $Q0kPF);
        $this->assertEquals(TwoFAMessages::parse("\x4d\111\x53\123\x49\116\x47\137\x41\124\124\x52\111\x42\x55\124\x45\x53\137\105\x58\x43\x45\x50\x54\x49\117\116"), $Q0kPF->getMessage());
        $this->assertEquals(125, $Q0kPF->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $Q0kPF = new MissingAttributesException();
        $ppvuU = MissingAttributesException::class . "\x3a\40\x5b\x31\62\65\135\x3a\x20" . $Q0kPF->getMessage() . "\xa";
        $this->assertEquals($ppvuU, (string) $Q0kPF);
    }
}