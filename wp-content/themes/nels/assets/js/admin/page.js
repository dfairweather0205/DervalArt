(function ($) {
    'use strict';

    $(document).ready(function () {
        var templateSelector = '.editor-page-attributes__template select',
            oldTemplateSelector = '#page_template';


        setTimeout(function () {
            managePageMetaBoxes();
            managePageMetaBoxesForOldWpVersion();

            $(document.body).on('change', templateSelector + ', ' + oldTemplateSelector, function () {
                managePageMetaBoxes();
                managePageMetaBoxesForOldWpVersion();
            });
        });

        function managePageMetaBoxes() {
            if (!wp.hasOwnProperty('data') || !wp.data.hasOwnProperty('select')) {
                return;
            }

            var allTemplates = Object.keys(wp.data.select('core/editor').getEditorSettings().availableTemplates),
                templateItem = $(templateSelector),
                currentTemplate = templateItem.val();

            if (!templateItem.length) {
                currentTemplate = wp.data.select('core/editor').getEditedPostAttribute('template');
            }

            allTemplates.forEach(function (template) {
                var templateName = template.replace(/\s+/g, '_').replace(/-/g, '_')
                        .replace(/templates\//g, '').replace(/\.php/g, '').toLowerCase(),
                    metaBox = $('#page_' + templateName + '_options');

                if (currentTemplate === template) {
                    metaBox.show();
                } else {
                    metaBox.hide();
                }
            });
        }

        function managePageMetaBoxesForOldWpVersion() {
            var templateItem = $(oldTemplateSelector);

            templateItem.find('option').each(function () {
                var templateName = $(this).text().replace(/\s+/g, '_').replace(/-/g, '_').toLowerCase(),
                    metaBox = $('#page_' + templateName + '_options');

                if (templateItem.val() === $(this).val()) {
                    metaBox.show();
                } else {
                    metaBox.hide();
                }
            });
        }
    });
})(jQuery);