<?php

namespace MiniOrange\TwoFA\Helper\Exception;

class JSErrorException extends \Exception
{
    public function __construct($NYakS)
    {
        $NYakS = $NYakS;
        $m1pru = 103;
        parent::__construct($NYakS, $m1pru, null);
    }
    public function __toString()
    {
        return __CLASS__ . "\x3a\x20\133{$this->code}\x5d\x3a\x20{$this->message}\12";
    }
}