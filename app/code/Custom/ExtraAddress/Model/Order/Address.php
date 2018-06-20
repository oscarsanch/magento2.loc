<?php

namespace Custom\ExtraAddress\Model\Order;

class Address extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Custom\ExtraAddress\Model\Order\ResourceModel\Address');
    }
}