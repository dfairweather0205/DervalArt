(function ($) {
    'use strict';

    $(document).ready(function () {

        manageMultiSelect();
        manageTabs();

        function manageMultiSelect() {
            $('.pikart-metabox-multi-select').multipleSelect({
                //placeholder: "search me",
                width: '100%',
                //multiple: true,
                //multipleWidth: 55,
                filter: true
            });

            $('.pikart-metabox-wp-color-picker').each(function () {
                $(this).wpColorPicker();
            });

            $('.meta-box-custom-field').find('input[type="number"]').each(function () {
                window.pikartAdminUtil.validateInputNumberRange(this);
            });

        }

        function manageTabs() {
            $('.meta-box-tabs').each(function () {
                var tabs = $(this).find('li'),
                    tabContents = $(this).parent().find('.meta-box-tab__content');

                if (tabs.length < 1 || tabContents.length < 1) {
                    return;
                }

                tabs.on('click', function (e) {
                    e.preventDefault();

                    tabContents.hide();
                    tabs.removeClass('meta-box-tab__active');
                    $(tabContents[$(this).index()]).show();
                    $(this).addClass('meta-box-tab__active');
                });

                tabs.first().click();
            });
        }
    });
})(jQuery);