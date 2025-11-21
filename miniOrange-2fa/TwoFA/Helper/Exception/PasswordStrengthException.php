<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class PasswordStrengthException extends \Exception
{
    public function __construct()
    {
        $o1fWv = TwoFAMessages::parse("\111\116\126\101\x4c\111\104\137\120\x41\x53\123\x5f\123\x54\122\x45\116\107\x54\x48");
        $q2gJX = 110;
        parent::__construct($o1fWv, $q2gJX, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\72\40\x5b{$this->code}\135\x3a\40{$this->message}\12";
    }
}