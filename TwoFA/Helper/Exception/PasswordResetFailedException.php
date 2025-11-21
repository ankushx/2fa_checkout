<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class PasswordResetFailedException extends \Exception
{
    public function __construct()
    {
        $rW2BE = TwoFAMessages::parse("\x45\122\122\x4f\122\137\x4f\103\x43\125\x52\122\105\x44");
        $Lioeo = 116;
        parent::__construct($rW2BE, $Lioeo, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\x3a\40\133{$this->code}\135\x3a\40{$this->message}\12";
    }
}