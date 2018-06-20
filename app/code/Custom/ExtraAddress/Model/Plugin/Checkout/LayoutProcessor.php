<?php

namespace Custom\ExtraAddress\Model\Plugin\Checkout;

use Custom\ExtraAddress\Model\Address\TypeFactory;

class LayoutProcessor
{
    protected $type;

    public function __construct(
        TypeFactory $type
    ) {
        $this->type = $type;
    }

    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        $options = $this->type->create();
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['type'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'options' => $options->getAllOptions(),
                'id' => 'type'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.type',
            'label' => 'Address Type',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => ['required-entry' => true],
            'sortOrder' => 250,
            'id' => 'type'
        ];

        $configuration = $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'];
        foreach ($configuration as $paymentGroup => $groupConfig) {
            if (isset($groupConfig['component']) AND $groupConfig['component'] === 'Magento_Checkout/js/view/billing-address') {
                $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
                ['payment']['children']['payments-list']['children'][$paymentGroup]['children']['form-fields']['children']['type'] = [
                    'component' => 'Magento_Ui/js/form/element/select',
                    'config' => [
                        'customScope' => 'billingAddresscheckmo.custom_attributes',
                        'template' => 'ui/form/field',
                        'elementTmpl' => 'ui/form/element/select',
                        'options' => $options->getAllOptions(),
                        'id' => 'type'
                    ],
                    'dataScope' => 'billingAddresscheckmo.custom_attributes.type',
                    'label' => 'Address Type',
                    'provider' => 'checkoutProvider',
                    'visible' => true,
                    'validation' => ['required-entry' => true],
                    'sortOrder' => 250,
                    'id' => 'type'
                ];
            }
        }

        return $jsLayout;
    }
}