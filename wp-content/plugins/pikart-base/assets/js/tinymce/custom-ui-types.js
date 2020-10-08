(function ($) {
    'use strict';

    /* global tinymce, tb_show, tb_remove */

    var CORE_ASSETS_URL = tinymce.PluginManager.urls.custom_ui_types + '/../../';

    setTimeout(addCustomUiTypes, 100);

    function addCustomUiTypes() {
        tinymce.ui.Factory.add('Icon', tinymce.ui.Widget.extend({
            init: function (settings) {
                var self = this,
                    selectedIcon = null;

                self._super(settings);

                self.on('click', function (e) {
                    if (selectedIcon) {
                        selectedIcon.css('color', '#444');
                        selectedIcon.css('background-color', '#fff');
                    }

                    selectedIcon = $(e.target);

                    selectedIcon.css('color', '#fff');
                    selectedIcon.css('background-color', '#0085ba');

                    self.state.set('value', e.target.dataset.icon);
                });
            },

            renderHtml: function () {
                var self = this,
                    iconList = self.settings.icon_list,
                    iconHtmlText = [];

                self.classes.add('icon');

                iconList.forEach(function (icon) {
                    iconHtmlText.push(
                        '<i id="' + icon + '" class="fa fa-' + icon + '" data-icon="' + icon + '" title="' + icon + '"></i>'
                    );
                });

                return '<div id="' + self._id + '" class="' + self.classes + '" style="width: 300px;">' +
                    iconHtmlText.join('') + '</div>';
            }
        }));

        tinymce.ui.Factory.add('WpGallery', tinymce.ui.Widget.extend({
            init: function (settings) {
                var self = this;

                self._super(settings);

                self.on('click', function () {
                    tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
                    $('#TB_overlay, #TB_window, #TB_load').css('z-index', '999999');

                    window.original_send_to_editor = window.send_to_editor;

                    window.send_to_editor = function (content) {
                        var imgSrc = $(content).html(content).find('img').attr('src');
                        $('#' + self.getImgId()).css('background-image', 'url(' + imgSrc + ')').show();
                        tb_remove();

                        self.state.set('value', imgSrc);

                        window.send_to_editor = window.original_send_to_editor;
                    };

                    return false;
                });
            },

            renderHtml: function () {
                var self = this,
                    default_image_url = CORE_ASSETS_URL + 'images/shortcodes/camera.png';

                self.classes.add('wp-gallery');

                return '<div id="' + self._id + '" class="' + self.classes + '" >' +
                    '<div id="' + self.getImgId() +
                    '" class="mce-wp-gallery__img" style="background-image: url(' + default_image_url + ')"></div>' +
                    '</div>';
            },

            getImgId: function () {
                return this._id + '-img';
            }
        }));

        tinymce.ui.Factory.add('MultiRangeSlider', tinymce.ui.Widget.extend({
            renderHtml: function () {
                var self = this;
                self.classes.add(self.getCssClass());
                return '<div id="' + self._id + '" class="' + self.classes + '"></div>';
            },

            postRender: function () {
                var self = this;

                self.buildSlider(self.settings.sliderOptions.initialValues);

                return self._super();
            },

            buildSlider: function (handleValues) {
                var self = this,
                    settings = self.settings,
                    sliderElement = $('#' + self._id),
                    sliderOptions = settings.sliderOptions,
                    sliderValues = handleValues.slice(0),
                    sliderUpdateCallback = settings.onupdate || function () {
                    };

                var updateValue = function (event, ui) {
                    var values = ui && ui.hasOwnProperty('values') ? ui.values : sliderValues;
                    self.state.set('value', values);
                    self._parent.state.set('value', values);

                    sliderUpdateCallback(event, values, self);
                };

                sliderOptions.create = updateValue;
                sliderOptions.change = updateValue;
                sliderOptions.stop = updateValue;

                if (sliderElement.hasClass('ui-slider')) {
                    sliderElement.limitslider('destroy');
                }

                sliderOptions.values = sliderValues;

                sliderElement.limitslider(sliderOptions);
            },

            getCssClass: function () {
                return 'multi-range-slider';
            }
        }));

        tinymce.ui.Factory.add('CustomColorPicker', tinymce.ui.Container.extend({
            init: function (settings) {
                var self = this, colorText, colorButton,
                    textBoxSettings = settings.hasOwnProperty('textBoxSettings') ? settings.textBoxSettings : {},
                    buttonSettings = settings.hasOwnProperty('buttonSettings') ? settings.buttonSettings : {};

                if (settings.hasOwnProperty('tooltip')) {
                    textBoxSettings.tooltip = settings.tooltip;
                    buttonSettings.tooltip = settings.tooltip;
                }

                var openColorPicker = function () {
                    var colorPickerCallback = tinymce.activeEditor.settings.color_picker_callback;

                    colorPickerCallback(
                        function (color) {
                            self.state.set('value', color);
                            colorText.value(color);
                        },
                        colorText.value()
                    );
                };

                var textChange = function () {
                    self.state.set('value', this.value());
                };

                buttonSettings = $.extend(true, {text: 'Select color'}, buttonSettings);
                buttonSettings.onclick = openColorPicker;
                textBoxSettings.onkeyup = textChange;

                if (settings.hasOwnProperty('default')) {
                    textBoxSettings.value = settings['default'];
                }

                colorText = tinymce.ui.Factory.create('TextBox', textBoxSettings);
                colorButton = tinymce.ui.Factory.create('Button', buttonSettings);

                settings.items = [colorButton, colorText];

                self._super(settings);
            }
        }));

        tinymce.ui.Factory.add('Tabs', tinymce.ui.Control.extend({
            init: function (settings) {
                var self = this;

                self._super(settings);
                self.state.set('value', []);
            },

            postRender: function () {
                var self = this,
                    tabsElement = $('#' + self._id),
                    newTabId = self._id + '-new-tab',
                    newTabEl = $('#' + newTabId),
                    tabIndex = 0;

                self._super();

                tabsElement.tabs({
                    beforeActivate: function (event, ui) {
                        if (ui.newTab.context.id === newTabId) {
                            event.preventDefault();
                        }
                    }
                }).addClass('ui-tabs-vertical ui-helper-clearfix');

                newTabEl.on('click', function (event) {
                    event.preventDefault();

                    $(this).parent().before(self.genTabHtml(tabIndex));

                    var elements = [],
                        tabItems = self.settings.hasOwnProperty('tabItems') ? self.settings.tabItems : {};

                    Object.keys(tabItems).forEach(function (fieldName) {
                        var item = tabItems[fieldName];
                        item.fieldName = fieldName;

                        elements.push(tinymce.ui.Factory.create(item));
                    });

                    $('#' + self._id + '-last').before(self.genTabContentHtml(tabIndex, elements));

                    tabsElement.tabs('refresh');

                    elements.forEach(function (element) {
                        element.postRender();
                        self.onChangeElement(element, tabIndex);
                    });

                    tabIndex++;
                });

                newTabEl.trigger('click');
                tabsElement.tabs('option', 'active', 0);
            },

            onChangeElement: function (control, index) {
                var self = this;

                var updateValue = function (e) {
                    if (self.getEl().value !== e.target.value) {
                        var value = self.state.get('value');

                        value[index][control.settings.fieldName] = e.target.value;

                        self.state.set('value', value);
                    }
                };

                control.on('keyup', updateValue);
                control.on('change', updateValue);
            },

            genTabHtml: function (index) {
                var self = this,
                    tabLabel = self.settings.hasOwnProperty('tabLabel') ? self.settings.tabLabel : 'Tab';

                return '<li><a href="#' + self._id + '-' + index + '">' + tabLabel + ' ' + (index + 1) + '</a></li>';
            },

            genTabContentHtml: function (index, items) {
                var self = this;

                var value = self.state.get('value'),
                    itemsContent = [];

                value[index] = {};

                items.forEach(function (item) {
                    value[index][item.settings.fieldName] = '';
                    itemsContent.push(item.renderHtml());
                });

                self.state.set('value', value);

                return '<div id="' + self._id + '-' + index + '">' + itemsContent.join('') + '</div>';
            },

            renderHtml: function () {
                var self = this,
                    newTabLabel = self.settings.hasOwnProperty('newTabLabel') ? self.settings.newTabLabel : 'New tab';

                return '<div id="' + self._id + '" class="' + self.classes + '" >' +
                    '<ul>' +
                    '<li><a href="#' + self._id + '-last" id="' + self._id + '-new-tab">' + newTabLabel + '</a></li></ul>' +
                    '<div id="' + self._id + '-last"></div>' +
                    '</div>';
            }
        }));

        tinymce.ui.Factory.add('MultiSelect', tinymce.ui.SelectBox.extend({
            renderOptions: function (options) {
                var optionItems = [];

                if (!options) {
                    return '';
                }

                Object.keys(options).forEach(function (optionKey) {
                    optionItems.push('<option value="' + optionKey + '">' + options[optionKey] + '</option>');
                });

                return optionItems.join('');
            },

            renderHtml: function () {
                var self = this, options, size = '';

                options = self.renderOptions(self._options);

                if (self.size) {
                    size = ' size = "' + self.size + '"';
                }

                return (
                    '<div id="' + self._id + '" class="' + self.classes + '" style="">' +
                    '<select ' + size + ' multiple="multiple" >' + options + '</select>' +
                    '</div>'
                );
            },

            bindStates: function () {
                var self = this;

                self.state.on('change:options', function (e) {
                    self.getEl().innerHTML = self.renderOptions(e.value);
                });

                return self._super();
            },

            postRender: function () {
                var self = this,
                    multiSelectElement = $('#' + self._id + ' select');

                var updateElementState = function () {
                    var val = multiSelectElement.val() ? multiSelectElement.val() : '';
                    self.state.set('value', val);
                };

                //http://wenzhixin.net.cn/p/multiple-select/
                multiSelectElement.multipleSelect({
                    //placeholder: "search me",
                    width: '100%',
                    //multiple: true,
                    //multipleWidth: 55,
                    filter: true,
                    onCheckAll: updateElementState,
                    onUncheckAll: updateElementState,
                    onClick: updateElementState
                });

                return self._super();
            }
        }));
    }

})(jQuery);