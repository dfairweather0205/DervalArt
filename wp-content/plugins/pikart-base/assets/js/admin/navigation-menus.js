/**
 * @since 1.1.0
 */
(function ($) {
    'use strict';

    $(document).ready(function () {
        var menu = $('#menu-to-edit'),
            topLevelOptions = ['wide-menu', 'nb-columns', 'background-image'],
            subItemOptions = ['custom-widget-area'],
            menuItemOptions = topLevelOptions.concat(subItemOptions),
            pikartCustomGalleryImageUtils = window.hasOwnProperty('pikartCustomGalleryImageUtils') ?
                window.pikartCustomGalleryImageUtils : {
                    openMediaLibrary: function () {
                    },
                    removeImage: function () {

                    }
                };

        function setupWideMenuOptions(menuItem) {
            var isTopItem = menuItem.hasClass('menu-item-depth-0');

            menuItemOptions.forEach(function (option) {
                var optionField = menuItem.find('.field-' + option),
                    isTopLevelOption = topLevelOptions.indexOf(option) !== -1;

                if ((isTopItem && isTopLevelOption) || (!isTopItem && !isTopLevelOption)) {
                    optionField.show();
                } else {
                    optionField.hide();
                }
            });
        }

        function updateWideMenuOptionsForAllMenuItems() {
            var menuItems = menu.find('.menu-item');

            menuItems.each(function (index, menuItem) {
                setupWideMenuOptions($(menuItem));
            });
        }

        updateWideMenuOptionsForAllMenuItems();

        $(document).on('menu-item-added', function (event, menuItem) {
            setupWideMenuOptions(menuItem);
            menuItem.find('.pikart-gallery-image-select').on('click', pikartCustomGalleryImageUtils.openMediaLibrary);
            menuItem.find('.pikart-gallery-image-remove').on('click', pikartCustomGalleryImageUtils.removeImage);
        });

        menu.on('mouseup', '.menu-item', function (event) {
            if (jQuery(event.target).is('a')) {
                return;
            }

            setTimeout(function () {
                updateWideMenuOptionsForAllMenuItems();
            }, 300);
        });
    });
})(jQuery);