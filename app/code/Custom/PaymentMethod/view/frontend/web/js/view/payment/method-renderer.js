define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'bonuspayment',
                component: 'Custom_PaymentMethod/js/view/payment/method-renderer/bonuspayment'
            }
        );
        return Component.extend({});
    }
);