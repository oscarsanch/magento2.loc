define(
    [
        'Magento_Checkout/js/view/payment/default',
        'Magento_Checkout/js/view/estimation'
    ],
    function (Component, estimation) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Custom_PaymentMethod/payment/bonuspayment'
            },

            /** Returns send check to info */
            getMailingAddress: function() {
                return window.checkoutConfig.payment.checkmo.mailingAddress;
            },

            getCustomerBonuses: function () {
                var customerData, bonuses;
                customerData = window.customerData;
                bonuses = customerData.custom_attributes.bonuses.value;

                return bonuses;
            },
            
            getPriceBonuses: function() {
                var priceTotal;
                priceTotal = estimation().getFormattedPrice(this.getCustomerBonuses());
                
                return priceTotal;
            }
        });
    }
);