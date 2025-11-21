<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class SupportQueryRequiredFieldsException extends \Exception
{
    public function __construct()
    {
        $I28Zo = TwoFAMessages::parse("\122\105\x51\x55\111\x52\x45\104\137\121\x55\x45\x52\x59\137\x46\111\x45\x4c\x44\123");
        $MHVci = 109;
        parent::__construct($I28Zo, $MHVci, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\72\40\133{$this->code}\x5d\x3a\40{$this->message}\xa";
    }
}