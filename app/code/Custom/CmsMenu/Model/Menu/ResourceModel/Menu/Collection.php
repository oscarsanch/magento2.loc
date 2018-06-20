<?php

namespace Custom\CmsMenu\Model\Menu\ResourceModel\Menu;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'link_id';
    protected $_eventPrefix = 'custom_cmsmenu_menu_collection';
    protected $_eventObject = 'link_collection';


    protected function _construct()
    {
        $this->_init('Custom\CmsMenu\Model\Menu\Menu', 'Custom\CmsMenu\Model\Menu\ResourceModel\Menu');
    }

    public function getFullCollection($linkPages, $gridPages, $pageId)
    {
        $this->addFieldToSelect(['url_key','text','status'])
            ->addFieldToFilter('main_table.status', $linkPages->getEnableStatus())
            ->getSelect()
            ->join(
                array('link' => $gridPages->getResource()->getMainTable()),
                'main_table.link_id = link.link_id',
                array('page_id')
            )->where('link.page_id = '.$pageId);
        return $this;
    }
}