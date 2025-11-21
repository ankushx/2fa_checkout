<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class InvalidPhoneException extends \Exception
{
    public function __construct($ZAzEt)
    {
        $ceHRi = TwoFAMessages::parse("\x45\x52\122\x4f\x52\x5f\120\110\x4f\x4e\x45\x5f\106\x4f\x52\x4d\x41\x54", ["\x70\150\157\x6e\145" => $ZAzEt]);
        $oDvCd = 112;
        parent::__construct($ceHRi, $oDvCd, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\72\x20\x5b{$this->code}\135\x3a\x20{$this->message}\12";
    }
}