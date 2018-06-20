<?php

namespace Custom\AuthUser\Model\ResourceModel\Login;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{ 
    protected $_idFieldName = 'logged_id';
    
    protected function _construct()
    {
        $this->_init('Custom\AuthUser\Model\Login', 'Custom\AuthUser\Model\ResourceModel\Login');
    }
}