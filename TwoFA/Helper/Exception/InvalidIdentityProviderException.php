<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class InvalidIdentityProviderException extends \Exception
{
    public function __construct()
    {
        $iWTB9 = TwoFAMessages::parse("\x49\x4e\x56\x41\114\111\x44\137\x49\x44\120");
        $IDeSo = 119;
        parent::__construct($iWTB9, $IDeSo, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\72\x20\133{$this->code}\x5d\x3a\40{$this->message}\12";
    }
}