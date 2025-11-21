<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class NotRegisteredException extends \Exception
{
    public function __construct()
    {
        $U05Qh = TwoFAMessages::parse("\x4e\x4f\x54\137\122\105\107\137\105\122\x52\117\x52");
        $exJbx = 102;
        parent::__construct($U05Qh, $exJbx, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\72\x20\x5b{$this->code}\135\x3a\40{$this->message}\12";
    }
}