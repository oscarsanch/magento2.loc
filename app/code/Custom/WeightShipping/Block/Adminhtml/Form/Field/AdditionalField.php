<?php

namespace Custom\WeightShipping\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\Data\Form\Element\AbstractElement;

class AdditionalField extends AbstractFieldArray
{
    protected $_template = 'Custom_WeightShipping::system/config/form/field/array.phtml';
    
    protected function _prepareToRender()
    {
        $this->addColumn('weight', ['label' => __('Weight'), 'class' => 'required-entry']);
        $this->addColumn('price', ['label' => __('Price'), 'class' => 'required-entry']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add new pair');
    }
}