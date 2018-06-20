<?php

namespace Custom\ExtraAddress\Model\Order\ResourceModel\Address;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Custom\ExtraAddress\Model\Order\Address', 'Custom\ExtraAddress\Model\Order\ResourceModel\Address');
    }

}