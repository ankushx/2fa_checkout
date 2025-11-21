<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class NoIdentityProviderConfiguredException extends \Exception
{
    public function __construct()
    {
        $JwpUA = TwoFAMessages::parse("\x4e\x4f\x5f\111\104\120\137\103\x4f\116\106\111\107");
        $ey72B = 101;
        parent::__construct($JwpUA, $ey72B, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\72\40\133{$this->code}\x5d\x3a\x20{$this->message}\12";
    }
}