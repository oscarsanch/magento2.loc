define([
    'jquery',
    'Magento_Swatches/js/swatch-renderer',
    'jquery/ui'
], function ($, SwatchRenderer) {
    'use strict';

    $.widget('custom.defaultProduct', {
        options: {
            swatchOptions: null,
            selectors: {
                formSelector: '#product_addtocart_form',
                swatchSelector: '.swatch-opt'
            },
            swatchWidgetName: 'mageSwatchRenderer',
            widgetInitEvent: 'swatch.initialized',
            clickEventName: 'emulateClick',
            configurableWidgetName: 'mageConfigurable'

        },

        _init: function () {
            var swatchWidget = $(this.options.selectors.swatchSelector).data(this.options.swatchWidgetName),
                defaultId = this.options.jsonDefault;
            if (!swatchWidget || !swatchWidget._EmulateSelectedByAttributeId) {
                var configurableProduct = $(this.options.selectors.formSelector).data(this.options.configurableWidgetName),
                    settings = configurableProduct.options.settings,
                    gallery = $(configurableProduct.options.mediaGallerySelector);
                $.each(settings, function (index, element) {
                    $.each(element, function (key,item) {
                        if (item.config){
                            if (item.config.id == defaultId[element.attributeId]){
                                element.value = item.config.id;
                                gallery.on('gallery:loaded', function(){
                                    configurableProduct._configureElement(element);
                                });
                            }
                        }
                    })
                });
                return;
            }
            swatchWidget._EmulateSelectedByAttributeId(
                this.options.jsonDefault, this.options.clickEventName
            );
        }
    });

    return $.custom.defaultProduct;
});
