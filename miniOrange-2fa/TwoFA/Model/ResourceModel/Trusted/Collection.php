<?php

namespace MiniOrange\TwoFA\Model\ResourceModel\Trusted;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use MiniOrange\TwoFA\Model\ResourceModel\Trusted;
class Collection extends AbstractCollection
{
    protected $_idFieldName = "\x74\162\x75\163\x74\x65\x64\x5f\x69\144";
    protected function _construct()
    {
        $this->_init(\MiniOrange\TwoFA\Model\Trusted::class, Trusted::class);
    }
}