(function ($) {
    'use strict';

    $(document).ready(function () {
        var formatIsChecked = false,
            postFormatInputs = $('input:radio[name="post_format"]');

        postFormatInputs.each(function () {
            var allowedFormats = ['image', 'video'],
                format = $(this).val() === '0' ? 'standard' : $(this).val();

            if ($.inArray(format, allowedFormats) === -1) {
                $(this).hide();
                $(this).siblings('.post-format-' + format).hide();
                $(this).nextAll('br').first().hide();
            } else if (!formatIsChecked && $(this).prop('checked')) {
                formatIsChecked = true;
            }
        });

        if (!formatIsChecked) {
            $('#post-format-image').prop('checked', true);
        }

        manageAlbumMetaBoxes();

        postFormatInputs.on('change', function () {
            manageAlbumMetaBoxes();
        });

        $('#_pikart_meta_album_video_type').on('change', function () {
            manageVideoMetaBoxes('video');
        });

        function manageAlbumMetaBoxes() {
            postFormatInputs.each(function () {
                var postFormatValue = $(this).val(),
                    postFormat = postFormatValue === '0' ? 'standard' : postFormatValue,
                    metaBox = $('#album_' + postFormat + '_options');

                if ($(this).is(':checked')) {
                    metaBox.show();
                    manageVideoMetaBoxes(postFormatValue);
                } else {
                    metaBox.hide();
                }
            });
        }

        function manageVideoMetaBoxes(postFormat) {
            var selectedVideoType = $('#_pikart_meta_album_' + postFormat + '_type').val();

            ['online_service', 'self_hosted'].forEach(function (videoType) {
                var metaBox = $('#video_' + videoType + '_options');

                if (selectedVideoType === videoType) {
                    metaBox.show();
                } else {
                    metaBox.hide();
                }
            });
        }
    });
})(jQuery);