<?php

namespace Custom\DefaultProduct\Ui\DataProvider\Product\Form\Modifier;

use Magento\ConfigurableProduct\Ui\DataProvider\Product\Form\Modifier\ConfigurablePanel as ParentPanel;
use Magento\Ui\Component\Form;

class ConfigurablePanel extends ParentPanel
{

    protected function getRows()
    {
        $recordsParent = parent::getRows();
        $default = [
            'is_default' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'formElement' => Form\Element\Checkbox::NAME,
                            'componentType' => Form\Field::NAME,
                            'component' => 'Custom_DefaultProduct/js/components/configurable-checkbox',
                            'parentContainer' => 'product_form.product_form.configurable.configurable-matrix',
                            'dataType' => Form\Element\DataType\Boolean::NAME,
                            'label' => __('Is Default'),
                            'dataScope' => 'is_default',
                            'prefer' => 'radio',
                            'value' => '0',
                            'valueMap' => ['false' => '0', 'true' => '1']
                        ]
                    ]
                ]
            ]
        ];
        
        $metaChildren = $recordsParent['record']['children'];
        $newMeta = array_merge($default,$metaChildren);
        $recordsParent['record']['children'] = $newMeta;
        return $recordsParent;
    }
}