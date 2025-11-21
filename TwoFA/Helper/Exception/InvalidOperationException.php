<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class InvalidOperationException extends \Exception
{
    public function __construct()
    {
        $B6WQL = TwoFAMessages::parse("\111\116\x56\x41\x4c\111\x44\137\117\x50");
        $UgKpm = 105;
        parent::__construct($B6WQL, $UgKpm, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\72\x20\x5b{$this->code}\135\72\x20{$this->message}\xa";
    }
}