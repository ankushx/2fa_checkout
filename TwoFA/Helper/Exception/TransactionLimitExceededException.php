<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class TransactionLimitExceededException extends \Exception
{
    public function __construct()
    {
        $cJEdV = TwoFAMessages::parse("\124\x52\x41\x4e\123\x41\103\124\x49\x4f\116\x5f\114\111\115\111\x54\x5f\105\130\103\105\x45\104\105\104");
        $rO_JU = 117;
        parent::__construct($cJEdV, $rO_JU, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\x3a\40\x5b{$this->code}\135\x3a\x20{$this->message}\xa";
    }
}