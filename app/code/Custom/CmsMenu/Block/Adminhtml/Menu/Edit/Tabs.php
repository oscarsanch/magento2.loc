<?php

namespace Custom\CmsMenu\Block\Adminhtml\Menu\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('menu_main_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Main Menu'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab(
            'main',
            [
                'label' => __('Link'),
                'title' => __('Link'),
                'content' => $this->getLayout()->createBlock(\Custom\CmsMenu\Block\Adminhtml\Menu\Edit\Tab\Link::class)->toHtml(),
                'active' => true
            ]
        );
        
        $grid = $this->getLayout()->createBlock(\Custom\CmsMenu\Block\Adminhtml\Menu\Edit\Tab\Grid::class); 

        $serializer = $this->getLayout()->createBlock(
            \Magento\Backend\Block\Widget\Grid\Serializer::class,
            '',
            [
                'data' => [
                    'grid_block' => $grid,
                    'callback' => 'getSelectedPages',
                    'input_element_name' => 'selected_pages',
                    'reload_param_name' => 'pages',
                ]
            ]
        );

        $this->addTab(
            'grid',
            [
                'label' => __('Grid'),
                'title' => __('Grid'),
                'content' => ($grid->toHtml().$serializer->toHtml())
            ]
        );
        return parent::_beforeToHtml();
    }
}