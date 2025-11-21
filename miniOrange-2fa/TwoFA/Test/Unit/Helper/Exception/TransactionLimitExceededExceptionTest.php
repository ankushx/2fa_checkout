<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper\Exception;

use MiniOrange\TwoFA\Helper\Exception\TransactionLimitExceededException;
use PHPUnit\Framework\TestCase;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class TransactionLimitExceededExceptionTest extends TestCase
{
    public function testConstruct_SetsCorrectMessageAndCode()
    {
        $it9Gz = new TransactionLimitExceededException();
        $this->assertInstanceOf(TransactionLimitExceededException::class, $it9Gz);
        $this->assertEquals(TwoFAMessages::parse("\124\x52\101\116\x53\101\103\x54\111\117\116\x5f\x4c\x49\115\111\124\x5f\105\x58\103\105\105\x44\x45\104"), $it9Gz->getMessage());
        $this->assertEquals(117, $it9Gz->getCode());
    }
    public function testToString_ReturnsExpectedFormat()
    {
        $it9Gz = new TransactionLimitExceededException();
        $wN_y4 = TransactionLimitExceededException::class . "\x3a\40\133\x31\61\67\135\72\40" . $it9Gz->getMessage() . "\12";
        $this->assertEquals($wN_y4, (string) $it9Gz);
    }
}