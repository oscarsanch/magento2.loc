var config = {
    map: {
        '*': {
            "Magento_Checkout/js/view/shipping-address/address-renderer/default":
                "Custom_ExtraAddress/js/view/shipping-address/address-renderer/default-override",
            "Magento_Checkout/js/view/shipping-information/address-renderer/default":
                "Custom_ExtraAddress/js/view/shipping-information/address-renderer/default-override",
            "Magento_Checkout/js/view/billing-address":
                "Custom_ExtraAddress/js/view/billing-address-override"
        }
    },
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Custom_ExtraAddress/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/action/create-billing-address': {
                'Custom_ExtraAddress/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/create-shipping-address': {
                'Custom_ExtraAddress/js/action/create-shipping-address-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                'Custom_ExtraAddress/js/action/place-order-mixin': true
            }
        }
    }
};