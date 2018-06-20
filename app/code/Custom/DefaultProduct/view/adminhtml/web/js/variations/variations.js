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
            },

            serializeData: function () {
                this.source.data["product"]["configurable-matrix-serialized"] =
                    JSON.stringify(this.source.data["configurable-matrix"]);

                this.source.data["product"]["associated_product_ids_serialized"] =
                    JSON.stringify(this.source.data["associated_product_ids"]);

                this.source.data['configurable-matrix-serialized'] =
                    JSON.stringify(this.source.data['configurable-matrix']);

                delete this.source.data['configurable-matrix'];

                this.source.data['associated_product_ids_serialized'] =
                    JSON.stringify(this.source.data['associated_product_ids']);

                delete this.source.data['associated_product_ids'];
            }
        };

        return function (Configurable) {
            return Configurable.extend(mixin);
        };
    }
);