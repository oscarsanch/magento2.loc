<?php

namespace Custom\CmsMenu\Model\Menu\ResourceModel\Grid;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'link_dependence_id';
    protected $_eventPrefix = 'custom_cmsmenu_grid_collection';
    protected $_eventObject = 'link_dependence_collection';

    protected function _construct()
    {
        $this->_init('Custom\CmsMenu\Model\Menu\Grid', 'Custom\CmsMenu\Model\Menu\ResourceModel\Grid');
    }

}