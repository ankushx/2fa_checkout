<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class OtpValidateFailureException extends \Exception
{
    public function __construct()
    {
        $EG6RU = TwoFAMessages::parse("\x4f\x54\x50\x5f\123\105\116\124\x5f\106\x41\111\114\105\x44");
        $azX3s = 143;
        parent::__construct($EG6RU, $azX3s, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\72\x20\133{$this->code}\135\72\40{$this->message}\xa";
    }
}