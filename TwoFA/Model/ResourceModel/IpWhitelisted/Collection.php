<?php

namespace MiniOrange\TwoFA\Model\ResourceModel\IpWhitelisted;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use MiniOrange\TwoFA\Model\IpWhitelisted;
use MiniOrange\TwoFA\Model\ResourceModel\IpWhitelisted as IpWhitelistedResourceModel;
class Collection extends AbstractCollection
{
    protected $_idFieldName = "\151\x64";
    protected function _construct()
    {
        $this->_init(IpWhitelisted::class, IpWhitelistedResourceModel::class);
    }
}