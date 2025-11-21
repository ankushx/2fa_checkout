<?php

namespace MiniOrange\TwoFA\Model;

use Magento\Framework\Model\AbstractModel;
class Trusted extends AbstractModel
{
    const CACHE_TAG = "\115\151\x6e\x69\117\x72\x61\156\147\x65\137\164\x77\157\146\141\143\164\157\x72\x61\165\164\150\137\164\x72\x75\x73\164\x65\144";
    protected $_cacheTag = "\115\x69\x6e\x69\x4f\x72\x61\x6e\x67\x65\x5f\164\x77\x6f\x66\x61\x63\x74\157\162\141\165\164\x68\x5f\164\x72\165\x73\164\x65\144";
    protected $_eventPrefix = "\x4d\x69\x6e\x69\x4f\x72\141\x6e\x67\145\137\164\x77\x6f\146\141\x63\x74\x6f\x72\x61\x75\x74\x68\137\164\162\165\163\164\145\144";
    protected $_idFieldName = "\164\x72\x75\163\x74\145\x64\x5f\151\x64";
    public function getIdentities()
    {
        return [self::CACHE_TAG . "\137" . $this->getId()];
    }
    protected function _construct()
    {
        $this->_init(ResourceModel\Trusted::class);
    }
}