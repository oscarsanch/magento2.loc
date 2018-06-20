<?php

namespace Custom\ExtraAddress\Model\Order\ResourceModel;


class Address extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('mgcustom_order_address', 'entity_id');
        $this->_isPkAutoIncrement=false;
    }
}