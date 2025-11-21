<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class RequiredFieldsException extends \Exception
{
    public function __construct()
    {
        $Uvr9s = TwoFAMessages::parse("\122\x45\x51\125\111\122\x45\x44\x5f\x46\111\105\114\104\x53");
        $UfgRu = 104;
        parent::__construct($Uvr9s, $UfgRu, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\x3a\x20\133{$this->code}\135\72\40{$this->message}\xa";
    }
}