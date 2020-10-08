(function ($) {
    'use strict';

    $(document).ready(function () {
        setTimeout(managePostMetaBoxes);


        setTimeout(function () {
            $(document.body).on('change', '.editor-post-format__content select', function () {
                managePostMetaBoxes();
            });
        });

        $(document.body).on('change', '#_pikart_meta_video_type', function () {
            manageVideoMetaBoxes('video');
        });

        managePostMetaBoxesForOldWpVersion();

        $(document.body).on('change', 'input:radio[name="post_format"]', function () {
            managePostMetaBoxesForOldWpVersion();
        });


        function managePostMetaBoxes() {
            if (!wp.hasOwnProperty('data') || !wp.data.hasOwnProperty('select')) {
                return;
            }

            var currentPostFormat = $('.editor-post-format__content select').val(),
                allPostFormats = wp.data.select('core').getThemeSupports('formats').formats;

            if (typeof currentPostFormat === 'undefined') {
                currentPostFormat = wp.data.select('core/editor').getEditedPostAttribute('format');
            }

            allPostFormats.forEach(function (format) {
                var metaBox = $('#post_' + format + '_options');

                if (format === currentPostFormat) {
                    metaBox.show();
                    manageVideoMetaBoxes(currentPostFormat);
                } else {
                    metaBox.hide();
                }
            });
        }

        function manageVideoMetaBoxes(postFormat) {
            var selectedVideoType = $('#_pikart_meta_' + postFormat + '_type').val();

            ['online_service', 'self_hosted'].forEach(function (videoType) {
                var metaBox = $('#video_' + videoType + '_options');

                if (selectedVideoType === videoType) {
                    metaBox.show();
                } else {
                    metaBox.hide();
                }
            });
        }

        function managePostMetaBoxesForOldWpVersion() {
            $('input:radio[name="post_format"]').each(function () {
                var postFormatValue = $(this).val(),
                    postFormat = postFormatValue === '0' ? 'standard' : postFormatValue,
                    metaBox = $('#post_' + postFormat + '_options');

                if ($(this).is(':checked')) {
                    metaBox.show();
                    manageVideoMetaBoxes(postFormatValue);
                } else {
                    metaBox.hide();
                }
            });
        }
    });
})(jQuery);