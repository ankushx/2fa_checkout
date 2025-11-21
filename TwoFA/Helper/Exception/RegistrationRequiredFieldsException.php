<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class RegistrationRequiredFieldsException extends \Exception
{
    public function __construct()
    {
        $r7eiR = TwoFAMessages::parse("\x52\x45\121\x55\111\x52\105\104\137\122\105\107\111\x53\124\x52\101\x54\111\x4f\x4e\137\106\111\x45\x4c\104\123");
        $nljTD = 111;
        parent::__construct($r7eiR, $nljTD, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\x3a\40\133{$this->code}\135\x3a\x20{$this->message}\12";
    }
}