<?php

namespace Custom\ExtraAddress\Model\Quote;

class Address extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Custom\ExtraAddress\Model\Quote\ResourceModel\Address');
    }
}