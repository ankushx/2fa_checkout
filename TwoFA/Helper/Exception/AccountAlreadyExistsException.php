<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class AccountAlreadyExistsException extends \Exception
{
    public function __construct()
    {
        $XvWqt = TwoFAMessages::parse("\101\x43\103\x4f\x55\x4e\124\137\105\130\x49\x53\x54\x53");
        $PRq2u = 108;
        parent::__construct($XvWqt, $PRq2u, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\72\40\133{$this->code}\135\72\40{$this->message}\xa";
    }
}