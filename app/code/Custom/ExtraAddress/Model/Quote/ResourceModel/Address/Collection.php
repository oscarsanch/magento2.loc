<?php

namespace Custom\ExtraAddress\Model\Quote\ResourceModel\Address;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Custom\ExtraAddress\Model\Quote\Address', 'Custom\ExtraAddress\Model\Quote\ResourceModel\Address');
    }

}