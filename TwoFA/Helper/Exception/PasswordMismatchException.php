<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class PasswordMismatchException extends \Exception
{
    public function __construct()
    {
        $v0ia0 = TwoFAMessages::parse("\120\101\x53\x53\137\115\111\123\x4d\x41\x54\x43\x48");
        $B4_5O = 122;
        parent::__construct($v0ia0, $B4_5O, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\x3a\x20\x5b{$this->code}\135\72\40{$this->message}\12";
    }
}