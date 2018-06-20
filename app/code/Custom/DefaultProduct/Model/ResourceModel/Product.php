<?php

namespace Custom\DefaultProduct\Model\ResourceModel;

class Product extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('mgcustom_default_product', 'entity_id');
        $this->_isPkAutoIncrement=false;
    }
}