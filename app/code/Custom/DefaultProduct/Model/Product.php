<?php

namespace Custom\DefaultProduct\Model;

class Product extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Custom\DefaultProduct\Model\ResourceModel\Product');
    }
}