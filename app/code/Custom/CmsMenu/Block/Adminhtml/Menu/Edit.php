<?php

namespace Custom\CmsMenu\Block\Adminhtml\Menu;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected function _construct()
    {
        $this->_objectId = 'link_id';
        $this->_blockGroup = 'Custom_CmsMenu';
        $this->_controller = 'adminhtml_menu';
        parent::_construct();
    }

    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', ['_current' => true, 'back' => null]);
    }
}
