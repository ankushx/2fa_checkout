<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class IncorrectUserInfoDataException extends \Exception
{
    public function __construct()
    {
        $jEgOU = TwoFAMessages::parse("\111\116\x56\101\x4c\111\x44\137\125\123\x45\122\137\x49\x4e\x46\117");
        $F9WPs = 119;
        parent::__construct($jEgOU, $F9WPs, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\72\x20\x5b{$this->code}\135\x3a\40{$this->message}\12";
    }
}