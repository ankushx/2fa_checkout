<?php

namespace MiniOrange\TwoFA\Helper\Exception;

use MiniOrange\TwoFA\Helper\TwoFAMessages;
class OtpSentFailureException extends \Exception
{
    public function __construct()
    {
        $jGQo8 = TwoFAMessages::parse("\x4f\124\x50\137\x53\x45\x4e\124\137\x46\101\111\x4c\105\104");
        $OmOkh = 141;
        parent::__construct($jGQo8, $OmOkh, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\x3a\x20\133{$this->code}\135\72\x20{$this->message}\xa";
    }
}