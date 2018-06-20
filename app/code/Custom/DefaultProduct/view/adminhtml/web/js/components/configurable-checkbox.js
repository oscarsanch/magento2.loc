define([
    'Magento_Ui/js/form/element/single-checkbox',
    'uiRegistry'
], function (Checkbox, registry) {
    'use strict';

    return Checkbox.extend({

        setInitialValue: function () {
            if (_.isEmpty(this.valueMap)) {
                this.on('value', this.onUpdate.bind(this));
            } else {
                this._super();
                var confMatrix = this.source.data['configurable-matrix'],
                    defaultVal = this.source.data['default-checked-product'],
                    indexMatrix;
                if (defaultVal != '') {
                    confMatrix.forEach(function(item, i, confMatrix) {
                        if(item.id == defaultVal){
                            indexMatrix = i;
                        }
                    });
                }
                if (this.parentScope == "data.configurable-matrix." + indexMatrix) {
                    this.checked(true);
                }
            }

            return this;
        },

        onUpdate: function () {
            if (this.prefer === 'radio' && this.checked() && !this.clearing) {
                this.valueMap.true = this.source.get(this.parentScope + '.id');
                this.clearValues();
            }

            this._super();
        },

        clearValues: function () {
            var records = registry.get(this.parentContainer),
                index = this.index,
                uid = this.uid;

            records.elems.each(function (record) {
                record.elems.filter(function (comp) {
                    return comp.index === index && comp.uid !== uid;
                }).each(function (comp) {
                    comp.clearing = true;
                    comp.clear();
                    comp.clearing = false;
                });
            });
        }
    });
});