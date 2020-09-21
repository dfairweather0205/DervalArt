(function ($) {
    'use strict';

    $(document).ready(function () {

        customizeWhenOptionUpdated('header_search_area_color_skin', function (to) {
            setCssClass('.site-search-area', to, ['light', 'dark'], 'search-area--skin-');
        });

        function customizeWhenOptionUpdated(optionId, callback) {
            window.pikartCoreCustomizer.customizeWhenOptionUpdated(optionId, callback);
        }

        function setCssClass(item, to, values, cssClassPrefix) {
            window.pikartCoreCustomizer.setCssClass(item, to, values, cssClassPrefix);
        }
    });
})(jQuery);