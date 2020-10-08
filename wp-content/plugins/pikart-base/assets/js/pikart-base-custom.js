(function ($) {
    'use strict';

    $(document).ready(function () {
        manageFlickrWidget();
        manageInstagramWidget();
        manageWishlist();
        manageProductsComparison();

        setTimeout(initAddThis);

        /*******************************************************/
        function initAddThis() {
            if (!window.hasOwnProperty('addthis')) {
                return;
            }

            try {
                window.addthis.init();

                $(document.body).on('pikart_addthis_toolbox_init', function () {
                    window.addthis.toolbox('.addthis-toolbox');
                });
            } catch (error) {
                window.console.warn(error);
            }
        }

        /*******************************************************/
        /**
         * @since 1.3.0
         */
        function manageFlickrWidget() {
            $('.widget_pikart_flickr_photos').each(function () {
                var widgetItem = $(this),
                    photosTypeId = widgetItem.data('photos-type') === 'group' ? 'group_id' : 'user_id',
                    photosSize = widgetItem.data('photos-size') === '' ? 's' : widgetItem.data('photos-size');

                var apiParams = {
                    format: 'json',
                    method: 'flickr.photos.search',
                    privacy_filter: 1,
                    nojsoncallback: 1,
                    media: 'photos',
                    per_page: widgetItem.data('photos-number'),
                    api_key: widgetItem.data('api-key')
                };

                apiParams[photosTypeId] = widgetItem.data('flickr-id');

                $.getJSON('https://api.flickr.com/services/rest/?', apiParams).done(function (data) {
                    if (data.stat !== 'ok') {
                        widgetItem.parent().remove();
                        return;
                    }

                    $.each(data.photos.photo, function (index, photo) {
                        var linkUrl = 'https://www.flickr.com/photos/' + photo.owner + '/' + photo.id,
                            imageUrl = 'https://farm' + photo.farm + '.static.flickr.com/' + photo.server +
                                '/' + photo.id + '_' + photo.secret + '_' + photosSize + '.jpg';

                        var photoItem = '<li><a href="' + linkUrl + '" target="_blank" title="' + photo.title + '">' +
                            '<img alt="' + photo.title + '" src="' + imageUrl + '"/></a></li>';

                        widgetItem.append(photoItem);
                    });
                }).fail(function () {
                    widgetItem.parent().remove();
                });
            });
        }

        /*******************************************************/
        /**
         * @since 1.3.0
         */
        function manageInstagramWidget() {
            $('.widget_pikart_instagram_photos').each(function () {
                var widgetItem = $(this),
                    isHashTag = widgetItem.data('is-hash-tag'),
                    baseUrl = isHashTag ? 'https://instagram.com/explore/tags/' : 'https://instagram.com/',
                    userIdHashTag = widgetItem.data('user-id-hash-tag'),
                    endpoint = baseUrl + userIdHashTag + '/' + (isHashTag ? '?__a=1' : ''),
                    photosNumber = Math.max(1, parseInt(widgetItem.data('photos-number'), 10));

                var getUserDataFromResponse = function (response) {
                    var data = response.split('window._sharedData = ');

                    if (data.length < 2) {
                        return false;
                    }

                    data = $.parseJSON(data[1].split(';</script>')[0]);

                    if (!data.hasOwnProperty('entry_data') || !data.entry_data.hasOwnProperty('ProfilePage')) {
                        return false;
                    }

                    return data.entry_data.ProfilePage[0];
                };

                $.get(endpoint).done(function (data) {
                    if (!isHashTag) {
                        data = getUserDataFromResponse(data);

                        if (!data) {
                            window.console.warn('No data fetched for user ' + userIdHashTag);
                            widgetItem.parent().remove();
                            return;
                        }
                    }

                    var photos = [];

                    try {
                        photos = isHashTag ? data.graphql.hashtag.edge_hashtag_to_media.edges
                            : data.graphql.user.edge_owner_to_timeline_media.edges;
                    } catch (error) {
                        widgetItem.parent().remove();
                    }

                    if (!photos.length) {
                        widgetItem.parent().remove();
                        return;
                    }

                    if (photos.length > photosNumber) {
                        photos = photos.slice(0, photosNumber);
                    }

                    $.each(photos, function (index, photo) {
                        if (photo.is_video) {
                            return;
                        }

                        var linkUrl = 'https://instagram.com/p/' + photo.node.shortcode,
                            thumbnails = photo.node.thumbnail_resources,
                            thumbnailsCount = thumbnails.length,
                            imageUrl = '';

                        for (var i = 0; i < thumbnailsCount; i++) {
                            if (thumbnails[i].config_width === 150) {
                                imageUrl = thumbnails[i].src;
                                break;
                            }
                        }

                        if (!imageUrl) {
                            return;
                        }

                        var caption = '';

                        try {
                            caption = photo.node.edge_media_to_caption.edges[0].node.text.replace(/\n/g, ' ');
                        } catch (error) {
                        }

                        var photoItem = '<li><a href="' + linkUrl + '" target="_blank" title="' + caption + '">' +
                            '<img alt="' + caption + '" src="' + imageUrl + '"/></a></li>';

                        widgetItem.append(photoItem);
                    });

                }).fail(function () {
                    widgetItem.parent().remove();
                });
            });
        }

        /*******************************************************/
        /**
         * @since 1.3.0
         */
        function manageWishlist() {
            /* defined in \Pikart\WpBase\Shop\Wishlist\WishlistFacade */
            var wishlistConfig;

            if (window.hasOwnProperty('pikartWishlistConfig')) {
                wishlistConfig = window.pikartWishlistConfig;
            } else {
                return;
            }

            $(document.body).on('click', '.wishlist-button', function (event) {
                var wishlistArea = $(this),
                    productId = wishlistArea.data('product-id'),
                    wishlistIcon = wishlistArea.find('i'),
                    spinnerIconClass = wishlistIcon.data('spinner-icon-class'),
                    addProductIconClass = wishlistIcon.data('add-product-icon-class'),
                    addedProductIconClass = wishlistIcon.data('added-product-icon-class');

                if (wishlistIcon.hasClass(addedProductIconClass)) {
                    return;
                }

                event.preventDefault();

                if (wishlistIcon.hasClass(spinnerIconClass)) {
                    return;
                }

                wishlistIcon.removeClass(addProductIconClass).addClass(spinnerIconClass);

                $.post(wishlistConfig.ajaxurl, {
                    action: 'pikart_add_product_to_wishlist',
                    productId: productId,
                    nonce: wishlistConfig.nonce
                }).done(function (response) {
                    if (!response.success) {
                        wishlistIcon.removeClass(spinnerIconClass).addClass(addProductIconClass);
                        return;
                    }

                    wishlistIcon.removeClass(spinnerIconClass).addClass(addedProductIconClass);

                    $(document.body).trigger('pikart_product_added_to_wishlist', [response.data.wishlist]);

                }).fail(function () {
                    wishlistIcon.removeClass(spinnerIconClass).addClass(addProductIconClass);
                });
            });

            $(document.body).on('click', '.wishlist-button-remove', function (event) {
                var removeButton = $(this),
                    productId = removeButton.data('product-id'),
                    wishlistTable = removeButton.closest('table');

                event.preventDefault();

                wishlistTable.block({
                    message: null,
                    overlayCSS: {
                        opacity: 0.6,
                        background: '#fff'
                    }
                });

                $.post(wishlistConfig.ajaxurl, {
                    action: 'pikart_remove_product_from_wishlist',
                    productId: productId,
                    nonce: wishlistConfig.nonce
                }).done(function (response) {
                    wishlistTable.unblock();

                    if (!response.success) {
                        return;
                    }

                    var data = response.data,
                        wishlistHtml = $(data.wishlistHtml);

                    removeButton.parents('.pikode--wishlist').html(wishlistHtml.html());

                    $(document.body).trigger('pikart_product_removed_from_wishlist', [data.wishlist]);

                }).fail(function () {
                    wishlistTable.unblock();
                });
            });

            $(document.body).on('wc_cart_button_updated', function (event, button) {
                // hide 'View Cart' link on wishlist page
                if (button.parents('.pikode--wishlist').length) {
                    button.next().remove();
                }
            });

            $(document.body).on('pikart_theme_loaded', function () {
                var wishlist = getItemFromCookie('pikart_wishlist');

                if (wishlist) {
                    $(document.body).trigger('pikart_refresh_wishlist', [objectStringToArrayList(wishlist)]);
                }
            });
        }

        /*******************************************************/
        /**
         * @since 1.3.0
         */
        function manageProductsComparison() {
            /* defined in \Pikart\WpBase\Shop\ProductsCompare\ProductsCompareHelper*/
            var compareConfig,
                compareListData = {
                    productsCompareList: [],
                    productsCompareHtml: ''
                };

            if (window.hasOwnProperty('pikartProductsCompareListConfig')) {
                compareConfig = window.pikartProductsCompareListConfig;
                compareListData = compareConfig.compareListData;
            } else {
                return;
            }

            var compareListHasProduct = function (productId) {
                return compareListData.productsCompareList.indexOf(parseInt(productId, 10)) > -1;
            };

            var triggerProductAddedEvent = function () {
                $(document.body).trigger('pikart_product_added_to_compare_list', compareListData);
            };

            var triggerProductRemovedEvent = function () {
                $(document.body).trigger('pikart_product_removed_from_compare_list', compareListData);
            };

            var updateCompareListData = function (data) {
                compareListData = data;
                window.pikartProductsCompareListConfig.compareListData = data;
            };

            $(document.body).on('click', '.products-compare-button', function (event) {
                var compareArea = $(this),
                    productId = compareArea.data('product-id'),
                    compareIcon = compareArea.find('i'),
                    spinnerIconClass = compareIcon.data('spinner-icon-class'),
                    addProductIconClass = compareIcon.data('add-product-icon-class'),
                    addedProductIconClass = compareIcon.data('added-product-icon-class');

                event.preventDefault();

                if (compareListHasProduct(productId)) {
                    triggerProductAddedEvent();
                    return;
                }

                if (compareIcon.hasClass(spinnerIconClass)) {
                    return;
                }

                compareIcon.removeClass(addProductIconClass).addClass(spinnerIconClass);

                $.post(compareConfig.ajaxurl, {
                    action: 'pikart_add_product_to_compare_list',
                    productId: productId,
                    nonce: compareConfig.nonce
                }).done(function (response) {
                    if (!response.success) {
                        compareIcon.removeClass(spinnerIconClass).addClass(addProductIconClass);
                        return;
                    }

                    compareIcon.removeClass(spinnerIconClass).addClass(addedProductIconClass);
                    updateCompareListData(response.data);

                    triggerProductAddedEvent();
                }).fail(function () {
                    compareIcon.removeClass(spinnerIconClass).addClass(addProductIconClass);
                });
            });

            $(document.body).on('click', '.products-compare-button-remove', function (event) {
                var removeButton = $(this),
                    productId = removeButton.data('product-id'),
                    compareTable = removeButton.closest('table');

                event.preventDefault();

                if (!compareListHasProduct(productId)) {
                    triggerProductRemovedEvent();
                    return;
                }

                compareTable.block({
                    message: null,
                    overlayCSS: {
                        opacity: 0.6,
                        background: '#fff'
                    }
                });

                $.post(compareConfig.ajaxurl, {
                    action: 'pikart_remove_product_from_compare_list',
                    productId: productId,
                    nonce: compareConfig.nonce
                }).done(function (response) {
                    if (!response.success) {
                        return;
                    }

                    updateCompareListData(response.data);

                    $('.products-compare-button[data-product-id="' + productId + '"]').each(function () {
                        var compareArea = $(this),
                            compareIcon = compareArea.find('i');

                        compareIcon.removeClass(compareIcon.data('added-product-icon-class'))
                            .addClass(compareIcon.data('add-product-icon-class'));
                    });

                    triggerProductRemovedEvent();
                }).always(function () {
                    compareTable.unblock();
                });
            });

            $(document.body).on('pikart_theme_loaded', function () {
                var compareList = getItemFromCookie('pikart_products_compare_list');

                if (compareList) {
                    $(document.body).trigger('pikart_refresh_compare_list', [objectStringToArrayList(compareList)]);
                }
            });
        }
    });

    function getItemFromCookie(itemName) {
        var match = document.cookie.match(new RegExp('(^| )' + itemName + '=([^;]+)'));
        return match ? decodeURIComponent(match[2].replace(/\+/g, ' ')) : null;
    }

    function objectStringToArrayList(str) {
        try {
            return Object.values(JSON.parse(str));
        } catch (e) {
            return [];
        }
    }
})(jQuery);