<?php

namespace Custom\CmsMenu\Model\Menu;

class Menu extends \Magento\Framework\Model\AbstractModel
{
    const STATUS_ENABLED   = 1;
    const STATUS_DISABLED  = 0;
    const IS_ACTIVE        = 'status';
    const URL              = 'url_key';

    protected $_eventPrefix = 'custom_cmsmenu_menu';
    
    protected function _construct()
    {
        $this->_init('Custom\CmsMenu\Model\Menu\ResourceModel\Menu');
    }

    public function getUrlKey()
    {
        return $this->getData(self::URL);
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    public function getEnableStatus()
    {
        return self::STATUS_ENABLED;
    }

    public function getDisableStatus()
    {
        return self::STATUS_DISABLED;
    }
}