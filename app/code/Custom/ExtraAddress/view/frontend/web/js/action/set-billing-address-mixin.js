define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper,quote) {
    'use strict';

    return function (setBillingAddressAction) {
        return wrapper.wrap(setBillingAddressAction, function (originalAction, messageContainer) {

            var billingAddress = quote.billingAddress();

            if(billingAddress != undefined) {

                if (billingAddress['extension_attributes'] === undefined) {
                    billingAddress['extension_attributes'] = {};
                }

                if (billingAddress.customAttributes != undefined) {
                    $.each(billingAddress.customAttributes, function (key, value) {

                        if($.isPlainObject(value)){
                            value = value['value'];
                        }

                        billingAddress['extension_attributes'][key] = value;
                    });
                }
                if (messageContainer.custom_attributes.type.value == undefined) {
                    $.each(messageContainer.custom_attributes , function( key, value ) {
                        messageContainer['custom_attributes']['type'] = {'attribute_code':key,'value':value};
                    });
                }

            }
            return originalAction(messageContainer);
        });
    };
});