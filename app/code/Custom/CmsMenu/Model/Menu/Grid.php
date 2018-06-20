<?php

namespace Custom\CmsMenu\Model\Menu;

class Grid extends \Magento\Framework\Model\AbstractModel
{
    protected $_eventPrefix = 'custom_cmsmenu_grid';

    protected function _construct()
    {
        $this->_init('Custom\CmsMenu\Model\Menu\ResourceModel\Grid');
    }
}