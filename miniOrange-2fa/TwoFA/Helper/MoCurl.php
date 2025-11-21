<?php

namespace MiniOrange\TwoFA\Helper;

class MoCurl extends \Magento\Framework\HTTP\Adapter\Curl
{
    protected $_header;
    protected $_body;
    public function __construct()
    {
        $iWyiq = \Magento\Framework\App\ObjectManager::getInstance();
        $dYEI5 = $iWyiq->get("\x4d\x61\x67\145\156\x74\157\x5c\106\162\x61\x6d\145\x77\157\x72\153\x5c\x41\x70\160\134\120\162\157\144\165\x63\x74\x4d\x65\x74\x61\x64\141\x74\x61\x49\x6e\164\x65\x72\x66\x61\143\x65");
        $kj2uK = $dYEI5->getVersion();
        $this->_config["\x76\145\x72\151\146\x79\x70\145\145\x72"] = false;
        $this->_config["\166\x65\162\x69\146\171\150\157\x73\x74"] = false;
        $this->_config["\x68\x65\x61\x64\x65\x72"] = false;
    }
}