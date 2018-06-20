define(['jquery'],
    function ($) {
        'use strict';

        var mixin = {
            saveFormHandler: function () {
                var matrix = this.source.data['configurable-matrix'],
                    defaultValue = {};
                $.each( matrix, function( key, value ) {
                    if (value.is_default != ""){
                        value.newProduct == 1 ? defaultValue = {id:key, newProduct:true} : defaultValue = {id:value.id, newProduct:false};
                    }
                });
                this.source.data['default'] =  JSON.stringify(defaultValue);
                this.serializeData();

                if (this.checkForNewAttributes()) {
                    this.formSaveParams = arguments;
                    this.attributeSetHandlerModal().openModal();
                } else {
                    this.formElement().save(arguments[0], arguments[1]);
                }
            }
        };

        return function (Configurable) {
            return Configurable.extend(mixin);
        };
    }
);