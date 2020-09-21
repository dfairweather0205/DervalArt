(function () {
    'use strict';

    window.getPikartThemeShortcodesFieldsMap = function () {

        var customPostTypeConfig = {
            type: {
                masonry: ['categories_display', 'categories_filter_position', 'animation_effect',
                    'animation_progress_delay'],
                carousel: ['carousel_autoplay', 'carousel_autoplay_speed']
            },
            animation: {
                fadeIn: ['animation_delay'],
                fadeFromUp: ['animation_delay'],
                fadeFromRight: ['animation_delay'],
                fadeFromDown: ['animation_delay'],
                fadeFromLeft: ['animation_delay'],
                zoomIn: ['animation_delay']
            }
        };

        return {
            projects: customPostTypeConfig,
            products: customPostTypeConfig,
            album: customPostTypeConfig
        };
    };
})();
