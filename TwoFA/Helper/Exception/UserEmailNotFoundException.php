<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class UserEmailNotFoundException extends \Exception
{
    public function __construct()
    {
        $fHIh7 = TwoFAMessages::parse("\x45\x4d\x41\x49\x4c\137\101\124\124\122\x49\102\125\x54\x45\137\116\117\124\x5f\122\105\124\x55\122\x4e\105\x44");
        $FXkuF = 120;
        parent::__construct($fHIh7, $FXkuF, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\x3a\40\x5b{$this->code}\x5d\x3a\40{$this->message}\xa";
    }
}