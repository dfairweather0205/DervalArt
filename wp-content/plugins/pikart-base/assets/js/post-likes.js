(function ($) {
    'use strict';

    /* defined in \Pikart\WpBase\Post\PostLikesFacade */
    var postLikesConfig = window.hasOwnProperty('pikartPostLikesConfig') ? window.pikartPostLikesConfig : {};

    $(document).ready(function () {
        var localStorageSupported = isLocalStorageSupported(),
            likesArea = $('.likes-area__link'),
            postId = likesArea.data('post-id'),
            nbLikes = parseInt(likesArea.data('nb-likes'), 10),
            postLikeKey = 'post_like_' + postId,
            likeIcon = likesArea.find('i'),
            spinnerIconClass = likeIcon.data('spinner-icon-class'),
            likePostIconClass = likeIcon.data('like-post-icon-class'),
            postLikedIconClass = likeIcon.data('post-liked-icon-class');

        if (localStorageSupported && localStorage.getItem(postLikeKey) && nbLikes) {
            likeIcon.removeClass(likePostIconClass).addClass(postLikedIconClass);
        }

        likesArea.on('click', function (event) {
            event.preventDefault();

            if (localStorageSupported && localStorage.getItem(postLikeKey) && nbLikes) {
                return;
            }

            likeIcon.removeClass(likePostIconClass).addClass(spinnerIconClass);

            $.ajax({
                method: 'POST',
                url: postLikesConfig.ajaxurl,
                data: {
                    action: 'pikart_like_post',
                    postId: postId,
                    nonce: postLikesConfig.nonce
                },
                success: function (response) {
                    if (response.success) {
                        if (response.data.hasOwnProperty('alreadyLiked') && response.data.alreadyLiked) {
                            return;
                        }

                        var nbLikesItem = $('.likes-area__number');

                        nbLikes = response.data.nbLikes;
                        nbLikesItem.html(response.data.nbLikesText);

                        if (localStorageSupported) {
                            localStorage.setItem(postLikeKey, true);
                        }
                    }
                },
                complete: function () {
                    likeIcon.removeClass(spinnerIconClass).addClass(postLikedIconClass);
                }
            });
        });

    });

    function isLocalStorageSupported() {
        var test = 'test';
        try {
            localStorage.setItem(test, test);
            localStorage.removeItem(test);
            return true;
        } catch (e) {
            return false;
        }
    }

})(jQuery);