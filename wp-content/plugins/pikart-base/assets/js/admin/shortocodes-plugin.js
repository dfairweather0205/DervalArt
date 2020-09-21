(function ($) {
    'use strict';

    /* global tinymce, pikartAdminUtil */

    /**
     * generated by Pikart\WpBase\Shortcode\ShortcodesInitializer php class
     */
    var pikartShortcodes = window.hasOwnProperty('pikartShortcodes') ? window.pikartShortcodes : {},
        shortcodePrefix = window.hasOwnProperty('pikartShortcodePrefix') ? window.pikartShortcodePrefix : '',
        /** @since 1.5.7 */
        pikartDummyEditorId = window.hasOwnProperty('pikartDummyEditorId') ? window.pikartDummyEditorId : '';

    $(document).ready(function () {
        var shortcodeGenerationFunctions = (function () {
            var generateItemListShortcodes = function (shortcodeConfig, itemsData) {
                var contentList = [];

                iterateObject(itemsData, function (index, itemData) {
                    contentList.push(generateShortcode(shortcodeConfig, itemData));
                });

                return contentList.join('');
            };

            return {
                columns: {
                    columns_slider: function (shortcodeConfig, values) {
                        var maxSliderVal = pikartShortcodes[shortcodePrefix + 'columns']
                                .attributes.columns_slider.items[0].sliderOptions.max,
                            contentList = [],
                            prevSize = 0,
                            colSizes = [];

                        for (var i = 0; i < values.length; i++) {
                            colSizes.push(values[i] - prevSize);
                            prevSize = values[i];
                        }

                        colSizes.push(maxSliderVal - prevSize);

                        colSizes.forEach(function (value) {
                            var data = {
                                size: value
                            };

                            contentList.push(generateShortcode(shortcodeConfig, data));
                        });

                        return contentList.join('');
                    }
                },
                defaultFunction: generateItemListShortcodes
            };
        })();


        var generateShortcode = function (shortcodeConfig, data) {
            var shortcodeName = shortcodeConfig.name,
                shortName = shortcodeName.replace(shortcodePrefix, ''),
                selfClosingShortcodePattern = '<p>[' + shortcodeName + ' %attributes% /]</p>',
                enclosedShortcodePattern =
                    '<p>[' + shortcodeName + ' %attributes%]</p><p>%content%</p><p>[/' + shortcodeName + ']</p>',
                attributePattern = '%key%="%value%"',
                attributeItems = [],
                shortcodeContent = '';

            iterateObject(shortcodeConfig.attributes, function (attributeName, config) {
                // ignore label type, because it's only used as a text separator in the shortcode admin area
                if (config.type.toLowerCase() === 'label') {
                    return;
                }

                var shortAttrName = attributeName.replace(shortcodePrefix, ''),
                    attributeValue = data.hasOwnProperty(attributeName) ?
                        data[attributeName] : (config.hasOwnProperty('default') ? config['default'] : '');

                if (config.hasOwnProperty('shortcode')) {
                    var shortcodeFunc = shortcodeGenerationFunctions.hasOwnProperty(shortName) &&
                    shortcodeGenerationFunctions[shortName].hasOwnProperty(shortAttrName) ?
                        shortcodeGenerationFunctions[shortName][shortAttrName] :
                        shortcodeGenerationFunctions.defaultFunction;

                    shortcodeContent = shortcodeFunc(config.shortcode, attributeValue);
                } else if (config.hasOwnProperty('is_content')) {
                    shortcodeContent = attributeValue;
                } else {
                    attributeItems.push(
                        attributePattern.replace('%key%', attributeName)
                            .replace('%value%', attributeValue));
                }
            });

            var shortCodePattern = shortcodeConfig.isSelfClosing ?
                selfClosingShortcodePattern : enclosedShortcodePattern;

            return shortCodePattern.replace('%attributes%', attributeItems.join(' '))
                .replace('%content%', shortcodeContent);
        };

        tinymce.PluginManager.add(shortcodePrefix + 'shortcodes', function (editor) {

            var updateMultiRangeSliderForColumns = function (event) {
                var sliderValues = [],
                    currentNbCols = this.value(),
                    formFields = event.control._parent._parent._parent._parent.items(),
                    sliderContainer = null,
                    columnsSliderContainerId = shortcodePrefix + 'columns_slider_container';

                formFields.each(function (formField) {
                    if (formField.items()[1]._id === columnsSliderContainerId) {
                        sliderContainer = formField.items()[1];
                    }
                });

                if (!sliderContainer) {
                    return;
                }

                var sliderCtrl = sliderContainer.items()[0],
                    maxNbCols = sliderCtrl.settings.sliderOptions.max;

                for (var i = 1; i < currentNbCols; i++) {
                    sliderValues.push(maxNbCols * i / currentNbCols);
                }

                sliderCtrl.buildSlider(sliderValues);
            };

            var updateTooltipsForColumnsSlider = function (event, values, slider) {

                if (!slider || !slider._parent) {
                    return;
                }

                var domUtils = tinymce.dom.DOMUtils.DOM,
                    tooltipsContainer = slider._parent.items()[1],
                    maxNbCols = slider.settings.sliderOptions.max,
                    nbCols = values.length + 1,
                    tooltips = [];

                if (!tooltipsContainer) {
                    return;
                }

                updateTooltipsForColumnsSlider.slider = slider;
                updateTooltipsForColumnsSlider.sliderValues = values;

                tooltipsContainer.items().remove();

                for (var i = 1; i <= nbCols; i++) {
                    tooltips.push({
                        type: 'tooltip',
                        classes: shortcodePrefix + 'columns_tooltip',
                        text: (maxNbCols / nbCols) + 'x'
                    });
                }

                tooltipsContainer.add(tooltips).renderNew();

                var prevHandleVal = 0,
                    sliderWidth = domUtils.getSize(slider.getEl()).w,
                    unitWidth = sliderWidth / maxNbCols;

                tooltipsContainer.items().each(function (tooltip, index) {
                    var handleVal = typeof values[index] === 'undefined' ? maxNbCols : values[index],
                        coeff = (prevHandleVal + handleVal) / 2,
                        posX = unitWidth * coeff;

                    tooltip.moveBy(posX - 20, 13).text((handleVal - prevHandleVal) + 'x');

                    prevHandleVal = handleVal;
                });
            };

            var columnsScroll = function (event) {
                updateTooltipsForColumnsSlider(
                    event,
                    updateTooltipsForColumnsSlider.sliderValues,
                    updateTooltipsForColumnsSlider.slider);
            };

            var shortcodesConfig = {
                columns: {
                    attributes: {
                        number: {
                            onselect: updateMultiRangeSliderForColumns
                        },
                        columns_slider: {
                            items: [
                                {
                                    onupdate: updateTooltipsForColumnsSlider
                                }
                            ]
                        }
                    },
                    windowEvents: {
                        onopen: function () {
                            $(window).on('scroll', columnsScroll);
                        },
                        onsubmit: function () {
                            $(window).off('scroll', columnsScroll);
                        },
                        onclose: function () {
                            $(window).off('scroll', columnsScroll);
                        }
                    }
                }
            };

            updatePikartShortcodesConfig(shortcodesConfig);

            var prepareAttributes = function (shortcodeName, attributes) {
                var items = [],
                    shortName = shortcodeName.replace(shortcodePrefix, ''),
                    shortcodeAttributesConfig = shortcodesConfig.hasOwnProperty(shortName) &&
                    shortcodesConfig[shortName].hasOwnProperty('attributes') ?
                        shortcodesConfig[shortName].attributes : {};

                iterateObject(attributes, function (attributeName, config) {
                    var item = {
                        name: attributeName
                    };

                    if (shortcodeAttributesConfig.hasOwnProperty(attributeName)) {
                        item = mergeObjects(shortcodeAttributesConfig[attributeName], item);
                    }

                    if (config.hasOwnProperty('default')) {
                        item.value = config['default'];
                        item.checked = config['default'];
                    }

                    if (config.hasOwnProperty('options')) {
                        var options = [];

                        iterateObject(config.options, function (value, text) {
                            options.push({text: text, value: value});
                        });

                        item.values = options;
                    }

                    item = mergeObjects(config, item);

                    items.push(item);
                });

                return items;
            };

            var addButton = function (shortcodeName, shortcodeConfig) {
                var shortName = shortcodeName.replace(shortcodePrefix, ''),
                    normalizedShortcodeName = snakeCaseToWords(shortName.capitalizeFirstLetter());

                var fireShortcodeEvent = function (shortcodeName, event) {

                    if (!shortcodesConfig.hasOwnProperty(shortName) ||
                        !shortcodesConfig[shortName].hasOwnProperty('windowEvents')) {
                        return;
                    }

                    var windowEvents = shortcodesConfig[shortName].windowEvents;

                    if (windowEvents.hasOwnProperty(event)) {
                        windowEvents[event]();
                    }
                };

                editor.addButton(shortcodeName, {
                    title: normalizedShortcodeName,
                    //cmd: shortcodeName + '_cmd',
                    //text: normalizedShortcodeName,
                    classes: 'pikode pikode-' + shortcodeName.replace(shortcodePrefix, '').replace('_', '-'),
                    icon: 'dashicons dashicons-before',
                    onClick: function () {

                        fireShortcodeEvent(shortcodeName, 'onopen');

                        editor.windowManager.open({
                            title: normalizedShortcodeName,
                            maxHeight: $(window).height() * 90 / 100,
                            id: shortcodePrefix + 'shortcode-form',
                            classes: 'shortcode-' + shortcodeName.replace(shortcodePrefix, '').replace('_', '-'),
                            body: prepareAttributes(shortcodeName, shortcodeConfig.attributes),
                            onOpen: function () {
                              $('input.mce-textbox[type=number]').each(function () {
                                  pikartAdminUtil.validateInputNumberRange(this);
                              });
                            },
                            onsubmit: function (e) {
                                fireShortcodeEvent(shortcodeName, 'onsubmit');
                                editor.insertContent(generateShortcode(shortcodeConfig, e.data));
                            },
                            onclose: function () {
                                fireShortcodeEvent(shortcodeName, 'onclose');
                            }
                        });
                    }
                });
            };

            iterateObject(pikartShortcodes, addButton);
        });

        manageDummyMetaBox();
    });

    /**
     * @since 1.5.7
     */
    function manageDummyMetaBox() {
        var dummyMetaBox = $('#' + pikartDummyEditorId).closest('.postbox');

        dummyMetaBox.hide();

        $(document).on('tinymce-editor-init', function (event, editor) {
            if (editor.id !== pikartDummyEditorId) {
                return;
            }

            setTimeout(function () {
                tinymce.get(pikartDummyEditorId).remove();
                dummyMetaBox.remove();
            });
        });
    }

    String.prototype.capitalizeFirstLetter = function () {
        return this.charAt(0).toUpperCase() + this.slice(1);
    };

    String.prototype.snakeCaseToCamelCase = function () {
        return this.replace(/_\w/g, function (word) {
            return word[1].toUpperCase();
        });
    };

    var mergeObjects = function (obj1, obj2) {
        return $.extend(true, obj1, obj2);
    };

    var iterateObject = function (obj, callback) {
        for (var property in obj) {
            if (obj.hasOwnProperty(property)) {
                callback(property, obj[property]);
            }
        }
    };

    var snakeCaseToWords = function (str) {
        return str.replace(/_/g, ' ');
    };

    var updatePikartShortcodesConfig = function (config) {

        var iconTypeFields = ['background_color', 'background_hover_color', 'border_color', 'border_hover_color'];

        var shortcodesFieldsMap = {
            custom_content: {
                enable_position: {
                    'true': ['z_index', 'position_top', 'position_right', 'position_bottom', 'position_left']
                }
            },
            dropcap: {
                type: {
                    square: ['square_size', 'background_color', 'border_color']
                }
            },
            icon: {
                type: {
                    square: iconTypeFields,
                    circle: iconTypeFields
                }
            },
            row: {
                enable_position: {
                    'true': ['z_index', 'position_top', 'position_right', 'position_bottom', 'position_left']
                },
                height: {
                    custom: ['height_custom'],
                    fixed_values: ['height_fixed_values']
                },
                width: {
                    custom: ['width_custom']
                }
            }
        };

        var addShortcodeAttributeIfMissing = function (config, shortcodeName, attribute) {
            if (!config.hasOwnProperty(shortcodeName)) {
                config[shortcodeName] = {};
            }

            if (!config[shortcodeName].hasOwnProperty('attributes')) {
                config[shortcodeName].attributes = {};
            }

            if (!config[shortcodeName].attributes.hasOwnProperty(attribute)) {
                config[shortcodeName].attributes[attribute] = {};
            }
        };

        var handleItemFields = function (shortcodeConfig, attribute, event, inputValue) {
            var showCallback = function (item) {
                item.show();
            };

            var hideCallback = function (item) {
                item.hide();
            };

            var attributeConfig = shortcodeConfig[attribute],
                formFieldsByName = {},
                formFieldsVisibility = {},
                formFields = event.type === 'select' ?
                    event.control.parent().parent().parent().parent().items() : event.control.parent().parent().items();

            var getFormItem = function (formField) {
                return formField.type === 'formitem' ? formField.items()[1] : formField;
            };

            formFields.each(function (formField) {
                if (formField.type === 'label') {
                    return;
                }

                var fieldName = getFormItem(formField).name();

                formFieldsByName[fieldName] = formField;
            });

            var processAttributeConfig = function (attributeConfig, inputValue, parentIsVisible) {
                Object.keys(attributeConfig).forEach(function (attributeValue) {
                    var fields = attributeConfig[attributeValue],
                        displayCallback = hideCallback,
                        isVisible = false,
                        isSameValue = attributeValue === inputValue ||
                            (typeof inputValue === 'boolean' && JSON.parse(attributeValue) === inputValue);

                    if (parentIsVisible && isSameValue) {
                        displayCallback = showCallback;
                        isVisible = true;
                    }

                    fields.forEach(function (field) {
                        // if form field already displayed, do not process it
                        if (formFieldsVisibility.hasOwnProperty(field) && formFieldsVisibility[field]) {
                            return;
                        }

                        displayCallback(formFieldsByName[field]);
                        formFieldsVisibility[field] = isVisible;

                        if (shortcodeConfig.hasOwnProperty(field)) {
                            processAttributeConfig(
                                shortcodeConfig[field], getFormItem(formFieldsByName[field]).value(), isVisible);
                        }
                    });

                });
            };

            processAttributeConfig(attributeConfig, inputValue, true);
        };

        var updateShortcodesConfig = function (shortcodesFieldsConfig) {
            Object.keys(shortcodesFieldsConfig).forEach(function (shortcodeType) {
                var shortcodeFieldsConfig = shortcodesFieldsConfig[shortcodeType],
                    configFields = [];

                Object.keys(shortcodeFieldsConfig).forEach(function (attribute) {
                    Object.keys(shortcodeFieldsConfig[attribute]).forEach(function (attributeValue) {
                        configFields = configFields.concat(shortcodeFieldsConfig[attribute][attributeValue]);
                    });
                });

                Object.keys(shortcodeFieldsConfig).forEach(function (attribute) {
                    addShortcodeAttributeIfMissing(config, shortcodeType, attribute);

                    var handleAttributeSpecificFields = function (event) {
                        handleItemFields(shortcodeFieldsConfig, attribute, event, this.value());
                    };

                    config[shortcodeType].attributes[attribute].onselect = handleAttributeSpecificFields;
                    config[shortcodeType].attributes[attribute].onchange = handleAttributeSpecificFields;

                    if (configFields.indexOf(attribute) < 0) {
                        config[shortcodeType].attributes[attribute].onPostRender = handleAttributeSpecificFields;
                    }
                });

            });
        };

        updateShortcodesConfig(shortcodesFieldsMap);

        if (window.hasOwnProperty('getPikartThemeShortcodesFieldsMap')) {
            updateShortcodesConfig(window.getPikartThemeShortcodesFieldsMap());
        }
    };

})(jQuery);