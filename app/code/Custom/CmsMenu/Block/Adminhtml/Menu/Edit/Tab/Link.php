<?php

namespace Custom\CmsMenu\Block\Adminhtml\Menu\Edit\Tab;

class Link extends \Magento\Backend\Block\Widget\Form\Generic
{
    public function getMenu()
    {
        return $this->_coreRegistry->registry('menu_link');
    }

    protected function _prepareForm()
    {
        $menu = $this->getMenu();

        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Link')]);

        if ($menu->getId()) {
            $fieldset->addField('link_id', 'hidden', ['name' => 'link_id']);
        }

        $this->_addElementTypes($fieldset);

        $fieldset->addField(
            'url_key',
            'text',
            [
                'name' => 'url_key',
                'label' => __('URL'),
                'title' => __('Url'),
                'class' => '',
                'required' => true
            ]
        );

        $fieldset->addField(
            'text',
            'textarea',
            [
                'name' => 'text',
                'label' => __('Text'),
                'title' => __('Text'),
                'class' => '',
                'required' => true
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'required' => true,
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')]
            ]
        );

        $form->setValues($menu->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}