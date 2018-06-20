define([
    'jquery',
    'underscore'
], function ($, _) {
    'use strict';

      return function (widget) {

        $.widget('mage.SwatchRenderer', widget, {

            _EventListener: function () {
                var $widget = this,
                    options = this.options.classes,
                    target;

                $widget.element.on('click', '.' + options.optionClass, function () {
                    return $widget._OnClick($(this), $widget);
                });

                $widget.element.on('emulateClick', '.' + options.optionClass, function () {
                    return $widget._OnClick($(this), $widget, 'emulateClick');
                });

                $widget.element.on('change', '.' + options.selectClass, function () {
                    return $widget._OnChange($(this), $widget, 'change');
                });

                $widget.element.on('click', '.' + options.moreButton, function (e) {
                    e.preventDefault();

                    return $widget._OnMoreClick($(this));
                });

                $widget.element.on('keydown', function (e) {
                    if (e.which === 13) {
                        target = $(e.target);

                        if (target.is('.' + options.optionClass)) {
                            return $widget._OnClick(target, $widget);
                        } else if (target.is('.' + options.selectClass)) {
                            return $widget._OnChange(target, $widget);
                        } else if (target.is('.' + options.moreButton)) {
                            e.preventDefault();

                            return $widget._OnMoreClick(target);
                        }
                    }
                });
            },

            _loadMedia: function (eventName) {
                var $main = this.inProductList ?
                        this.element.parents('.product-item-info') :
                        this.element.parents('.column.main'),
                    images;

                if (this.options.useAjax) {
                    this._debouncedLoadProductMedia();
                }  else {
                    images = this.options.jsonConfig.images[this.getProduct()];

                    if (!images) {
                        images = this.options.mediaGalleryInitial;
                    }

                    this.updateBaseImage(images, $main, !this.inProductList, eventName);
                }
            },


            _OnChange: function ($this, $widget, eventName) {
                var $parent = $this.parents('.' + $widget.options.classes.attributeClass),
                    attributeId = $parent.attr('attribute-id'),
                    $input = $parent.find('.' + $widget.options.classes.attributeInput);

                if ($widget.productForm.length > 0) {
                    $input = $widget.productForm.find(
                        '.' + $widget.options.classes.attributeInput + '[name="super_attribute[' + attributeId + ']"]'
                    );
                }

                if ($this.val() > 0) {
                    $parent.attr('option-selected', $this.val());
                    $input.val($this.val());
                } else {
                    $parent.removeAttr('option-selected');
                    $input.val('');
                }

                $widget._Rebuild();
                $widget._UpdatePrice();
                $widget._loadMedia(eventName);
                $input.trigger('change');
            },


            updateBaseImage: function (images, context, isInProductView, eventName) {
                var gallery = context.find(this.options.mediaGallerySelector).data('gallery');

                if (eventName === undefined) {
                    this.processUpdateBaseImage(images, context, isInProductView, gallery);
                } else {
                    context.find(this.options.mediaGallerySelector).on('gallery:loaded', function (loadedGallery) {
                        loadedGallery = context.find(this.options.mediaGallerySelector).data('gallery');
                        this.processUpdateBaseImage(images, context, isInProductView, loadedGallery);
                    }.bind(this));
                }
            },

            processUpdateBaseImage: function (images, context, isInProductView, gallery) {
                var justAnImage = images[0],
                    initialImages = this.options.mediaGalleryInitial,
                    imagesToUpdate,
                    isInitial;

                if (isInProductView) {
                    imagesToUpdate = images.length ? this._setImageType($.extend(true, [], images)) : [];
                    isInitial = _.isEqual(imagesToUpdate, initialImages);

                    if (this.options.gallerySwitchStrategy === 'prepend' && !isInitial) {
                        imagesToUpdate = imagesToUpdate.concat(initialImages);
                    }

                    imagesToUpdate = this._setImageIndex(imagesToUpdate);
                    gallery.updateData(imagesToUpdate);

                    if (isInitial) {
                        $(this.options.mediaGallerySelector).AddFotoramaVideoEvents();
                    } else {
                        $(this.options.mediaGallerySelector).AddFotoramaVideoEvents({
                            selectedOption: this.getProduct(),
                            dataMergeStrategy: this.options.gallerySwitchStrategy
                        });
                    }

                    gallery.first();

                } else if (justAnImage && justAnImage.img) {
                    context.find('.product-image-photo').attr('src', justAnImage.img);
                }
            },

            _EmulateSelectedByAttributeId: function (selectedAttributes, triggerClick) {
                $.each(selectedAttributes, $.proxy(function (attributeId, optionId) {
                    var elem = this.element.find('.' + this.options.classes.attributeClass +
                            '[attribute-id="' + attributeId + '"] [option-id="' + optionId + '"]'),
                        parentInput = elem.parent();

                    if (triggerClick === null || triggerClick === '') {
                        triggerClick = 'click';
                    }

                    if (elem.hasClass('selected')) {
                        return;
                    }

                    if (parentInput.hasClass(this.options.classes.selectClass)) {
                        parentInput.val(optionId);
                        parentInput.trigger('change');
                    } else {
                        elem.trigger(triggerClick);
                    }
                }, this));
            },

            _setImageIndex: function (images) {
                var length = images.length,
                    i;

                for (i = 0; length > i; i++) {
                    images[i].i = i + 1;
                }

                return images;
            }
        });
        return $.mage.SwatchRenderer;
    }
});