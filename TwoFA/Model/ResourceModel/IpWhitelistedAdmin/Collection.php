<?php

namespace MiniOrange\TwoFA\Model\ResourceModel\IpWhitelistedAdmin;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use MiniOrange\TwoFA\Model\IpWhitelistedAdmin;
use MiniOrange\TwoFA\Model\ResourceModel\IpWhitelistedAdmin as IpWhitelistedAdminResourceModel;
class Collection extends AbstractCollection
{
    protected $_idFieldName = "\151\144";
    protected function _construct()
    {
        $this->_init(IpWhitelistedAdmin::class, IpWhitelistedAdminResourceModel::class);
    }
}