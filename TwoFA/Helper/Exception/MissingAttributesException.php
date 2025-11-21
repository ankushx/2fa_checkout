<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class MissingAttributesException extends \Exception
{
    public function __construct()
    {
        $MkJxA = TwoFAMessages::parse("\x4d\x49\123\x53\x49\116\107\137\x41\124\124\x52\111\102\125\x54\105\123\x5f\105\130\x43\x45\120\x54\x49\x4f\x4e");
        $s0crX = 125;
        parent::__construct($MkJxA, $s0crX, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\x3a\x20\133{$this->code}\x5d\x3a\x20{$this->message}\xa";
    }
}