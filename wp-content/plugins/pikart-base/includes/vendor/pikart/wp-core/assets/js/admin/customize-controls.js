(function ($) {
    'use strict';

    $(document).ready(function () {
        $('.customize-control-checkbox_multiple input[type="checkbox"]').on('change', function () {
                var checkboxValues = $(this).parents('.customize-control')
                    .find('input[type="checkbox"]:checked')
                    .map(function () {
                        return this.value;
                    }).get().join(',');

                $(this).parents('.customize-control')
                    .find('input[type="hidden"]')
                    .val(checkboxValues)
                    .trigger('change');
            }
        );
    });
})(jQuery);
