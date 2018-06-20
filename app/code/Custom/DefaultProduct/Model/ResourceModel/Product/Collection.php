<?php

namespace Custom\DefaultProduct\Model\ResourceModel\Product;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Custom\DefaultProduct\Model\Product', 'Custom\DefaultProduct\Model\ResourceModel\Product');
    }

}