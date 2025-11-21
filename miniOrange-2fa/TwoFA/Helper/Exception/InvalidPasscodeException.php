<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class InvalidPasscodeException extends \Exception
{
    public function __construct()
    {
        $b3Ezk = TwoFAMessages::parse("\111\116\x56\101\x4c\111\x44\137\120\101\x53\x53\x43\117\x44\x45");
        $zibHT = 140;
        parent::__construct($b3Ezk, $zibHT, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\x3a\x20\x5b{$this->code}\x5d\72\x20{$this->message}\xa";
    }
}