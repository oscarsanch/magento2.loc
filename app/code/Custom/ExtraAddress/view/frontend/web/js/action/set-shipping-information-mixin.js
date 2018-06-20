define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';
    
    return function (setShippingInformationAction) {
        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();
    
            if (shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }

            var tp = shippingAddress.customAttributes['type'];
    
            if (typeof tp=='object'){
                tp = tp.value;
            }
    
            shippingAddress['extension_attributes']['type'] = tp;
    
            return originalAction();
        });
    };
});