(function ($) {
    'use strict';

    window.pikartAdminUtil = {
        validateInputNumberRange: function (item) {
            var input = $(item),
                itemMax = item.hasAttribute('max') ? parseInt(input.attr('max'), 10) : null,
                itemMin = item.hasAttribute('min') ? parseInt(input.attr('min'), 10) : null,
                previousVal = input.val();

            if (itemMax === null && itemMin === null) {
                return;
            }

            input.on('input', function () {
                var val = input.val();

                if (itemMin !== null && val < itemMin) {
                    input.val(previousVal);
                    return;
                }

                if (itemMax !== null && val > itemMax) {
                    input.val(previousVal);
                    return;
                }

                previousVal = val;
            });
        }
    };
})(jQuery);