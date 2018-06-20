define([
    'jquery',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/shipping-rate-registry',
    'Magento_Checkout/js/model/shipping-rate-processor/new-address',
    'Magento_Customer/js/customer-data',
    'Magento_Checkout/js/model/cart/totals-processor/default',
    'jquery/ui',
    'mage/cookies'
], function($, quote, rateRegistry, newAddressProcessor, customerData, totalsProcessor) {
    "use strict";

    $.widget('custom.ajaxcart', {
        options : {
            qty : '[data-role="cart-item-qty"]'
        },

        _create: function() {
            this._bind();
        },

        _bind: function() {
            var self = this;
            var inputQty, data, count, arr;
            var customer = customerData.get('cart')()['items'];
            var url =  window.checkout.baseUrl + 'cartcount/cart/updatecart';
            inputQty = this.options.qty;
            $(inputQty).on('change', function(){
                data = $(this);
                self._ajax(data, url);
            });

            customerData.get('cart').subscribe(function(){
                arr = customerData.get('cart')().items;
                $.each(arr, function( index, value ) {
                    count = parseInt($('#cart-' + value.item_id +'-qty').val());
                    if (parseInt(value.qty) != count && $('#cart-' + value.item_id +'-qty').attr('name') == 'cart['+value.item_id + '][qty]'){
                        $('#cart-' + value.item_id +'-qty').val(value.qty);
                        data = $('#cart-' + value.item_id +'-qty');
                        self._ajax(data, url);
                    }
                });
            });
        },

        _ajax: function(data, url) {
            var val, name;
            val = $(data).val();
            name= $(data).attr('name');
            data = {};
            data[name] = val;

            $.extend(data, {
                'form_key': $.mage.cookies.get('form_key'),
                "update_cart_action":"update_qty"
            });

            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',

                success: function(response) {
                    $('[name="' + name + '"]').parents('tr').find('.subtotal .price').replaceWith(response);
                    totalsProcessor.estimateTotals(customerData.get('checkout-data')());

                    var address = quote.shippingAddress();
                    // clearing cached rates to retrieve new ones
                    rateRegistry.set(address.getCacheKey(), null);
                    var type = quote.shippingAddress().getType();
                    if (type == 'new-customer-address') {
                        newAddressProcessor.getRates(address);
                    }
                }
            });
        }

    });

    return $.custom.ajaxcart;
});