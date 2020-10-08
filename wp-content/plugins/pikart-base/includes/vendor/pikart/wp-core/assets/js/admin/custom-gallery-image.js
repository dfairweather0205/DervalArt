jQuery(function ($) {
    'use strict';

    var galleryImageContainer = $('.pikart-gallery-image-container'),
        inputFieldSelector = 'input[type="hidden"]',
        removeImageSelector = '.pikart-gallery-image-remove';

    window.pikartCustomGalleryImageUtils = {
        openMediaLibrary: function (event) {
            event.preventDefault();

            var inputField = $(this).siblings(inputFieldSelector),
                removeImageItem = $(this).siblings(removeImageSelector);

            var mediaFrame = wp.media({
                title: 'Image',
                library: {
                    type: 'image'
                },
                multiple: false
            });

            mediaFrame.on('select', function () {
                var attachment = mediaFrame.state().get('selection').first().toJSON(),
                    imgItem = inputField.siblings('img'),
                    imgHasThumnail = attachment.hasOwnProperty('sizes') && attachment.sizes.hasOwnProperty('thumbnail'),
                    imgUrl = imgHasThumnail ? attachment.sizes.thumbnail.url : attachment.url;

                if (imgItem.length) {
                    imgItem.attr('src', imgUrl);
                } else {
                    inputField.after(
                        '<img src="' + imgUrl + '" class="attachment-thumbnail size-thumbnail" height="100px" />');
                }

                inputField.val(attachment.id);
                removeImageItem.show();
            });

            mediaFrame.open();
        },
        removeImage: function (event) {
            event.preventDefault();

            $(this).siblings('img').remove();
            $(this).hide();
            $(this).siblings(inputFieldSelector).val('');
        }
    };

    galleryImageContainer.find('.pikart-gallery-image-select')
        .on('click', window.pikartCustomGalleryImageUtils.openMediaLibrary);

    galleryImageContainer.find(removeImageSelector).on('click', window.pikartCustomGalleryImageUtils.removeImage);


});
