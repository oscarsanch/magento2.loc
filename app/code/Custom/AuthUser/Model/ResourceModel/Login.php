<?php

namespace Custom\AuthUser\Model\ResourceModel;

class Login extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('mglogin_as_customer', 'logged_id');
    }
}