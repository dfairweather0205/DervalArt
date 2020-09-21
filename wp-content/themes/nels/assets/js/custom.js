(function ($) {
    'use strict';

    /* global Foundation */

    var themeCustomOptions = window.hasOwnProperty('pikartThemeCustomOptions') ? window.pikartThemeCustomOptions : {};

    setupGMapConfig();

    $(document).ready(function () {

        // Global vars
        var windowHeight = $(window).height(),
            siteBody = $('body'),
            aboveArea = $('.above-area'),
            isAboveAreaEnabled = aboveArea.length > 0,
            siteHeader = $('#site-header'),
            siteContent = $('#site-content'),
            siteHeaderIsTransparent = siteHeader.is('.site-header--transparency'),
            isHeaderFixed = siteHeader.is('.site-header--fixed'),
            isHeaderSticky = siteHeader.is('.site-header--sticky'),
            isRTL = siteBody.is('.rtl'),
            isAdminBar = siteBody.is('.admin-bar'),
            isError404Page = siteBody.is('.error404'),
            owlCarouselClone = $('.owl-carousel-slides').clone();

        // Viewport
        var viewportHeight,
            viewportWidth,
            isPhoneScreen,
            isMobileScreen,
            isTabletUpScreen,
            isDesktopScreen;

        var sliderSettings = {
            common: {
                nav: true,
                navElement: 'div',
                navText: ['<i class="icon-arrow-left"></i>', '<i class="icon-arrow-right"></i>'],
                rtl: isRTL ? true : false
            },
            subcommon: {
                navElement: 'div',
                navText: ['<i class="icon-arrow-left"></i>', '<i class="icon-arrow-right"></i>'],
                rtl: isRTL ? true : false
            },
            'default': {
                dots: true,
                items: 1,
                loop: true
            },
            advanced: {
                autoplayHoverPause: true,
                loop: true,
                smartSpeed: 750,
                stagePadding: 3
            }
        };

        var magnificPopupCloseButton = '<button title="%title%" type="button" class="mfp-close">' +
            '<svg width="20px" height="20px" viewBox="0 0 20 20"> ' +
            '<path d="M19 2.414L17.586 1 10 8.586 2.414 1 1 2.414 8.586 10 1 17.586 2.414 19 10 11.414 17.586 19 19 17.586 11.414 10z"/>' +
            '</svg>' +
            '</button>';

        $(window).on('resize', initScreenParams);

        // Screen
        initScreenParams();

        // Foundation
        initFoundation();

        // Preloader
        runLoader();

        // Hooks
        adjustToIOS();
        addProperClassesToLinkedImages();
        wooCommerceHooks();
        addProperClassToWpmlSubmenu();
        positionAdminBar();

        // Scroll
        runScrollTop();
        scrollToAnchor();

        // Header
        pushHeaderTop();
        runFixedHeader();
        runStickyHeader();
        runSiteHeaderTransparency();
        runWideMenu();
        runDropdownMenu();
        runAccountIconPopup();
        runAsideButton();
        runAside();
        runSearch();
        runMobileHeader();

        // Content
        setupContentMinHeight();
        runCommentsSwitcher();
        removeHeroHeaderMarginBottomIfOnly();
        runFixedDetails();

        // Iframe
        runFlexIframe();

        // Isotope
        runIsotope();

        // Image & Video Slider
        runOwlCarousel();

        // Video
        playVideo();

        // Popups
        initPopupSingle();
        initPopupGallery();

        // Shortcodes
        animateProgressBars();

        // Parallax
        initParallax();

        // Animated Items
        runAnimatedItems();

        // Shop
        setupWishlistIconItemsNumberUpdate();
        addQuantityInputIncrementers();
        runShopPopups();
        runShopFilter();

        $(document.body).trigger('pikart_theme_loaded');

        //----------------------------------------------------------------------------------------------------//
        //
        //        Screen
        //
        //----------------------------------------------------------------------------------------------------//
        function initScreenParams() {
            var viewport = getViewport();

            viewportHeight = viewport.height;
            viewportWidth = viewport.width;
            isPhoneScreen = viewportWidth < 640;
            isTabletUpScreen = viewportWidth >= 640;
            isMobileScreen = viewportWidth < 1024;
            isDesktopScreen = viewportWidth >= 1024;
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Viewport
        //
        //----------------------------------------------------------------------------------------------------//
        function getViewport() {
            var element = window,
                dimensionPrefix = 'inner';

            if (!('innerWidth' in window)) {
                dimensionPrefix = 'client';
                element = document.documentElement || document.body;
            }

            return {
                width: element[dimensionPrefix + 'Width'],
                height: element[dimensionPrefix + 'Height']
            };
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Foundation
        //
        //----------------------------------------------------------------------------------------------------//
        function initFoundation() {
            // Enter the Foundation Plugins customizations before initializing Foundation JS
            // Example: Foundation.DropdownMenu.defaults.closingTime = 50;
            Foundation.DropdownMenu.defaults.closingTime = 50;
            Foundation.DropdownMenu.defaults.disableHover = true;
            Foundation.Tabs.defaults.linkClass = 'tabs__title';
            Foundation.Tabs.defaults.closlinkClassingTime = 'tabs__panel';
            Foundation.AccordionMenu.defaults.multiOpen = false;
            Foundation.Tooltip.defaults.clickOpen = false;
            Foundation.Tooltip.defaults.hoverDelay = 50;
            $(document).foundation();

            // Show after initializing foundation
            $('.is-dropdown-submenu, .sidebar--site-header, .menu-item-alt-label, .shop-cart-icon__items,' +
                '.wishlist__items, .products-compare__items').show();
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Preloader
        //
        //----------------------------------------------------------------------------------------------------//
        function runLoader() {
            $('.site-loader-bg').fadeOut(300);
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Hooks
        //
        //----------------------------------------------------------------------------------------------------//
        function adjustToIOS() {
            var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

            if (!isIOS) {
                return;
            }

            // let's deal with 'vh' units behaviour on iOS

            var fixedHeightWrappers = $('.pikode--row--height-fixed-value');

            fixedHeightWrappers.each(function () {
                $(this).css('height', $(this).height() + 'px')
                    .removeClass('pikode--one_third pikode--half pikode--two_thirds pikode--full_height');
            });

            var cachedViewportHeight = viewportHeight;

            var setUpFixedHeightWrappersHeight = function () {
                fixedHeightWrappers.each(function () {
                    var $this = $(this),
                        fixedHeightWrappersRatio,
                        fixedHeightWrappersNewHeight;

                    fixedHeightWrappersRatio = $this.height() / cachedViewportHeight;
                    cachedViewportHeight = viewportHeight;
                    fixedHeightWrappersNewHeight = fixedHeightWrappersRatio * cachedViewportHeight;

                    $this.css('height', fixedHeightWrappersNewHeight + 'px');
                });
            };

            resizeOnWindowWidthChange(setUpFixedHeightWrappersHeight);
        }

        function addProperClassesToLinkedImages() {
            $('[class*=wp-image]').each(function () {
                var wpImage = $(this),
                    wpImageAnchor = wpImage.parent('a'),
                    wpImageAnchorHasRelAttachment = $(wpImage.parent('a[href*=attachment]')).length &&
                        $(wpImage.parent('a[rel*=attachment]')).length,
                    wpImageIsNotInsideGallery = !wpImage.parents().is('[class*=gallery]'),
                    wpImageIsFromMediaLibrary = $(wpImage.parent('a[href*=uploads]')).length;

                if (wpImageAnchorHasRelAttachment) {
                    wpImageAnchor.addClass('wp-image-attachment');
                } else if (wpImageIsNotInsideGallery && wpImageIsFromMediaLibrary) {
                    wpImageAnchor.addClass('wp-image-link');
                } else {
                    wpImageAnchor.addClass('wp-image-custom-link');
                }
            });
        }

        function wooCommerceHooks() {

            wrapSpanInsideAnchorForProductsCategoriesWidget();
            changeCartTotalsHeadingWrapper();
            updateHeaderShoppingCart();
            runUpdateCart();

            function updateHeaderShoppingCart() {

                var updateCartTotalCount = function (totalCount) {
                    $('.shop-cart-icon__items-number').text(totalCount);
                };

                $(document.body).on('added_to_cart removed_from_cart', function (event, fragments) {
                    updateCartTotalCount(fragments.total_count);
                });

                $(document.body).on('wc_fragments_refreshed', function () {
                    if (!window.sessionStorage || !window.hasOwnProperty('wc_cart_fragments_params')) {
                        return;
                    }

                    /* global wc_cart_fragments_params */
                    // defined by woocommerce
                    var fragments = $.parseJSON(sessionStorage.getItem(wc_cart_fragments_params.fragment_name));

                    if (!fragments) {
                        return;
                    }

                    if (fragments.hasOwnProperty('total_count')) {
                        updateCartTotalCount(fragments.total_count);
                    }

                    if (!fragments.hasOwnProperty('pikart_cart_popup_details')) {
                        return;
                    }

                    $('.cart-popup .cart-popup__widget').html(fragments.pikart_cart_popup_details);
                });

                $(document.body).trigger('wc_fragments_refreshed');
            }

            function wrapSpanInsideAnchorForProductsCategoriesWidget() {
                $('.widget_product_categories').find('.cat-item').each(function () {
                    var $this = $(this),
                        $categoriesCount = $this.find('>.count'),
                        $span = $categoriesCount.clone();

                    $categoriesCount.remove();
                    $this.find('>a').append($span);
                });
            }

            function changeCartTotalsHeadingWrapper() {
                $('.cart_totals').find('>h2').contents().unwrap().wrapAll('<h3></h3>');
            }

            function runUpdateCart() {
                var shopCartPopup = $('.cart-popup');

                var openPopup = function () {
                    shopCartPopup.addClass('is-opened');
                };

                var closePopup = function () {
                    shopCartPopup.removeClass('is-opened');
                };

                $(document).on('click', '.cart-popup__close-button, .shop-cart-icon a[href="#"]', function (e) {
                    e.preventDefault();

                    if (shopCartPopup.is('.is-opened')) {
                        closePopup();
                    } else {
                        openPopup();
                    }
                });

                $(document).keydown(function (e) {
                    if (e.keyCode === 27) {
                        closePopup();
                    }
                });

                $('.blur-background-layer').on('click', closePopup);

                $(document).on('removed_from_cart', function () {
                    $( '.woocommerce-cart-form' ).submit();
                });

                $(document).on('added_to_cart removed_from_cart', function (e, fragments) {
                    if (!fragments.hasOwnProperty('pikart_cart_popup_details')) {
                        return;
                    }

                    $('.cart-popup .cart-popup__widget').html(fragments.pikart_cart_popup_details);

                });

                if (themeCustomOptions.add_to_cart_popup === '1') {
                    $(document).on('added_to_cart', function () {
                        var magnificPopup = $.magnificPopup.instance;

                        if (!magnificPopup.hasOwnProperty('isOpen') || !magnificPopup.isOpen) {
                            openPopup();
                        }
                    });
                }
            }
        }

        function addProperClassToWpmlSubmenu() {
            if ($('.wpml-ls-menu-item').length) {
                $('.wpml-ls-flag:only-child').closest('.wpml-ls-menu-item').find('.submenu').addClass('submenu--wpml');
            }
        }

        function positionAdminBar() {

            if (!siteBody.is('.admin-bar')) {
                return;
            }

            var adminBar = $('#wpadminbar');
            var setupPosition = function () {
                if (viewportWidth > 600) {
                    adminBar.css('position', '');
                } else {
                    adminBar.css('position', 'fixed');
                }
            };

            setupPosition();
            $(window).on('resize', setupPosition);
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Scroll
        //
        //----------------------------------------------------------------------------------------------------//
        function runScrollTop() {
            var scrollTopButton = $('.scroll-top-button');

            var initScroll = function () {
                $(window).scrollTop() > windowHeight * 0.75 ?
                    scrollTopButton.fadeIn(300) : scrollTopButton.fadeOut(300);
            };

            $(window).on('scroll', initScroll);
            initScroll();

            scrollTopButton.on('click', function (e) {
                e.preventDefault();
                $('html, body').animate({scrollTop: 0}, 500, 'linear');
            });
        }

        function scrollToAnchor() {
            $('body').on('click', 'a[href^="#"]', function (e) {
                e.preventDefault();

                var anchorId = $(this).attr('href').substr(1),
                    targetAnchor = $('[id="' + anchorId + '"]');

                if (anchorId.length && targetAnchor.length) {
                    var targetAnchorTop = targetAnchor.offset().top;
                    $('html, body').animate({scrollTop: targetAnchorTop}, 500, 'linear');
                }
            });
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Header
        //
        //----------------------------------------------------------------------------------------------------//
        function pushHeaderTop() {

            if (isError404Page) {
                return;
            }

            var setSiteContentPadding = function () {
                if (isHeaderFixed && !isAboveAreaEnabled) {
                    siteContent.css({'padding-top': siteHeader.outerHeight() + 'px'});
                }
            };

            setSiteContentPadding();
            $(window).on('resize', setSiteContentPadding);
        }

        function runFixedHeader() {
            var fixedHeader,
                fixedScrollHeight,
                scroll;

            if(!isHeaderFixed || !isAboveAreaEnabled) {
                return;
            }

            var checkScrollValue = function() {
                scroll = $(window).scrollTop();

                if (scroll > fixedScrollHeight) {
                    fixedHeader.addClass('on-scroll');
                } else {
                    fixedHeader.removeClass('on-scroll');
                }
            };

            var initFixedHeader = function () {
                fixedHeader = $('.site-header--fixed');
                fixedScrollHeight = aboveArea.outerHeight();
                checkScrollValue();

                $(window).on('scroll', function () {
                    checkScrollValue();
                });
            };

            initFixedHeader();
        }

        function runStickyHeader() {
            var stickyHeight,
                aboveAreaHeight,
                scroll;

            if (!isHeaderSticky) {
                return;
            }

            var checkScrollValue = function() {
                scroll = $(window).scrollTop();

                if (scroll > stickyHeight) {
                    siteHeader.css({height: siteHeaderIsTransparent ? 0 : $('.site-header__wrapper').outerHeight()});
                    siteHeader.addClass('on-sticky-mode');
                } else {
                    siteHeader.css({height: ''});
                    siteHeader.removeClass('on-sticky-mode');
                }
            };

            var initStickyHeight = function () {
                aboveAreaHeight = isAboveAreaEnabled ? aboveArea.outerHeight() : 0;
                stickyHeight = $('.site-header__wrapper').outerHeight() + aboveAreaHeight;
            };

            var initStickyHeader = function () {
                initStickyHeight();
                $(window).on('resize', initStickyHeight);

                checkScrollValue();
                $(window).on('scroll', function () {
                    checkScrollValue();
                });
            };

            initStickyHeader();
        }

        function runSiteHeaderTransparency() {
            var siteHeaderWrapper = $('.site-header__wrapper'),
                siteHeaderBgColor = themeCustomOptions.header_background_color,
                siteHeaderColorSkin = themeCustomOptions.header_color_skin,
                aboveAreaHeight,
                scroll;

            if (!siteHeaderIsTransparent) {
                return;
            }

            var initSiteHeaderHeight = function () {
                aboveAreaHeight = isAboveAreaEnabled ? aboveArea.outerHeight() : 0;

                return $('.site-header__wrapper').outerHeight() + aboveAreaHeight;
            };

            var initSiteTransparent = function () {
                scroll = $(window).scrollTop();

                if (scroll < initSiteHeaderHeight()) {
                    siteHeaderWrapper.css({
                        'border-bottom-style': 'none',
                        'background-color': 'transparent',
                        'box-shadow': 'none' });
                    siteHeader.removeClass('site-header--skin-dark').addClass('site-header--skin-light');
                } else {
                    var backgroundColor = hexWithTransparencyToRgbaString(
                        siteHeaderBgColor, themeCustomOptions.header_background_transparency);

                    siteHeaderWrapper.css({
                        'border-bottom-style': 'solid',
                        'background-color': backgroundColor,
                        'box-shadow': '0 0 5px 0 rgba(0,0,0,0.12)' });

                    if (siteHeaderColorSkin === 'dark') {
                        siteHeader.removeClass('site-header--skin-light')
                            .addClass('site-header--skin-' + siteHeaderColorSkin);
                    }
                }
            };

            initSiteTransparent();
            $(window).on('scroll', initSiteTransparent);
        }

        function runWideMenu() {

            var initMenu = function () {
                var menuWide = $('.primary-menu').find('.menu-wide'),
                    menuWideWidth = $('.site-header__main__wrapper').width(),
                    menuWideDropdownSubMenu = menuWide.find('>.is-dropdown-submenu');

                if (viewportWidth >= 1024) {
                    menuWideDropdownSubMenu.css('width', menuWideWidth);
                } else {
                    menuWideDropdownSubMenu.css('width', '');
                }
            };

            if (viewportWidth >= 1024) {
                initMenu();
            }

            $(window).on('resize', initMenu);
        }

        function runDropdownMenu() {

            var initDropdownMenu = function () {
                var mainMenu = $('#primary-menu.dropdown, #above-area-menu.dropdown'),
                    mainMenuItem = mainMenu.find('.menu-item-has-children'),
                    $isOriginLeft = !isRTL;

                mainMenuItem.find('>.is-dropdown-submenu').css({opacity: 0, display: 'none'});

                mainMenuItem.on('mouseenter', function () {
                    $(this).find('>.is-dropdown-submenu').stop().animate({opacity: 1}, 360)
                        .css({display: 'flex'}).addClass('js-dropdown-active');

                    // let's init isotope
                    $(this).find('.gallery').each(function () {
                        $(this).isotope({layoutMode: 'packery', isOriginLeft: $isOriginLeft});
                    });
                }).on('mouseleave', function () {
                    $(this).find('>.is-dropdown-submenu').stop().animate({opacity: 0}, 180, function () {
                        $(this).css({display: 'none'}).removeClass('js-dropdown-active');
                    });
                });
            };

            initDropdownMenu();
            $(window).on('resize', initDropdownMenu);
        }

        function runAccountIconPopup() {
            var accountIconButton = $('.my-account-icon'),
                accountIconDropdown = $('.account-icon-popup');

            accountIconDropdown.css({opacity: 0, display: 'none'});

            accountIconButton.on('mouseenter', function () {
                accountIconDropdown.stop().animate({opacity: 1}, 360).css({display: 'block'});
            }).on('mouseleave', function () {
                accountIconDropdown.stop().animate({opacity: 0}, 180, function () {
                    $(this).css({display: 'none'});
                });
            });
        }

        function runAsideButton() {
            var sidebarMenuItem = $('.header-aside-button');

            var initHover = function () {
                if(isDesktopScreen) {
                    sidebarMenuItem.on('mouseenter', function() {
                        setTimeout(function() {
                            sidebarMenuItem.removeClass('toggle-button--animated');
                        }, 600);

                        $(this).addClass('toggle-button--animated');
                    });
                }
            };

            initHover();
            $(window).on('resize', initHover);
        }

        function runAside() {
            var asidePosition = isRTL ? 'left' : 'right';

            //--------------------------------------------------------------------------------------------------------//
            //
            //        Sidebar Site Header
            //
            //--------------------------------------------------------------------------------------------------------//
            var initHeaderSidebar = function () {
                var sidebar = $('.sidebar--site-header'),
                    sidebarWidth = isTabletUpScreen ? themeCustomOptions.header_sidebar_width + 'px' : '81vw';

                var closeAside = function () {
                    // Initialize Sidebar position
                    sidebar.css(asidePosition, '-' + sidebarWidth);

                    // If sidebar is already closed, stop here and search for other fun
                    if (!sidebar.hasClass('is-opened')) {
                        return;
                    }

                    // In this case, let's close the sidebar
                    sidebar.removeClass('is-opened');
                };

                var opensAside = function () {
                    sidebar.addClass('is-opened');

                    sidebar.css(asidePosition, 0);
                };

                // first, initialize sidebar width on resize
                $(window).on('resize', function () {
                    sidebarWidth = isTabletUpScreen ? themeCustomOptions.header_sidebar_width + 'px' : '81vw';
                });

                resizeOnWindowWidthChange(closeAside);
                closeAside();

                $(document).on('click', '.header-aside-button, .sidebar--site-header__close-button', function (e) {
                    e.preventDefault();

                    if (sidebar.hasClass('is-opened')) {
                        closeAside();
                    } else {
                        opensAside();
                    }
                });

                $(document).keydown(function (e) {
                    if (e.keyCode === 27) {
                        closeAside();
                    }
                });

                $('.blur-background-layer').on('click', closeAside);
            };

            initHeaderSidebar();
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Site Search Area
        //
        //----------------------------------------------------------------------------------------------------//
        function runSearch() {
            var searchWrapper = $('.site-search-area'),
                searchCloseButton = searchWrapper.find('.search-form-close-button'),
                searchInput = searchWrapper.find('.search-form__input'),
                searchButton = $('.search-button-icon');

            var closeSearch = function () {
                searchInput.blur();

                setTimeout(function () {
                    searchWrapper.removeClass('is-opened');
                }, 100);
            };

            var openSearch = function () {
                searchWrapper.addClass('is-opened');

                setTimeout(function () {
                    searchInput.focus();
                }, 100);
            };

            var initSearch = function () {
                searchButton.on('click', function (e) {
                    e.preventDefault();

                    if (searchWrapper.is('.is-opened')) {
                        closeSearch();
                    } else {
                        openSearch();
                    }
                });

                searchCloseButton.on('click', closeSearch);

                $(document).keydown(function (e) {
                    if (e.keyCode === 27) {
                        closeSearch();
                    }
                });

                // close search just if the mobile device width changes
                resizeOnWindowWidthChange(closeSearch);
            };

            initSearch();

            if (searchWrapper.is('.site-search-area--above')) {
                $('.blur-background-layer').on('click', closeSearch);
            }
        }

        //------------------------------------------------------------------------------------------------------------//
        //
        //        Site Header: Mobile
        //
        //------------------------------------------------------------------------------------------------------------//
        function runMobileHeader() {
            var mobileNavigation = $('.mobile-navigation');

            if (!mobileNavigation.length) {
                return;
            }

            var openMenu = function () {
                mobileNavigation.addClass('mobile-navigation-is-opened');
            };

            var closeMenu = function () {
                mobileNavigation.removeClass('mobile-navigation-is-opened');
            };

            $(document).on('click', '.site-mobile-button', function (e) {
                e.preventDefault();

                if (mobileNavigation.is('.mobile-navigation-is-opened')) {
                    closeMenu();
                } else {
                    openMenu();
                }
            });

            $('.blur-background-layer').on('click', closeMenu);
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Content
        //
        //----------------------------------------------------------------------------------------------------//
        function setupContentMinHeight() {

            var initMinContent = function() {
                var siteContentPaddingTop = parseInt(siteContent.css('padding-top'), 10),
                    footerBelowAreaHeight = $('.site-footer__meta').height(),
                    wpAdminBarHeight = isAdminBar ? $('#wpadminbar').height() : 0,
                    minHeightForSite;

                minHeightForSite = viewportHeight + siteContentPaddingTop - siteHeader.height() -
                footerBelowAreaHeight - wpAdminBarHeight;

                siteContent.css('min-height', minHeightForSite);
            };

            initMinContent();
            $(window).on('resize', initMinContent);
        }

        function runCommentsSwitcher() {
            var comments = $('#comments'),
                commentsButton = $('.comments__switch-button'),
                commentsList = '.comments__list',
                commentsNav = '.nav--comments';

            var initCommentsButtonState = function () {
                commentsButton.find('.closed').show();
                commentsButton.find('.opened').hide();
            };

            comments.addClass('comments--opened');
            initCommentsButtonState();

            commentsButton.on('click', function (e) {
                e.preventDefault();

                if (comments.is('.comments--closed')) {
                    comments.removeClass('comments--closed').addClass('comments--opened');

                    initCommentsButtonState();

                    $(commentsList).show();
                    $(commentsNav).show();
                } else {
                    comments.removeClass('comments--opened').addClass('comments--closed');

                    commentsButton.find('.closed').hide();
                    commentsButton.find('.opened').show();

                    $(commentsList).hide();
                    $(commentsNav).hide();
                }
            });
        }

        function removeHeroHeaderMarginBottomIfOnly() {
            if ($('.entry-content').children().length < 1 && $('.entry-footer').children().length < 1) {
                $('.hero-header').css('margin-bottom', 0);
            }
        }

        function runFixedDetails() {
            var entryDetails = $('.entry-details');

            var initStickyDetails = function () {
                if (isDesktopScreen) {
                    if (entryDetails.is('.entry-details--sticky')) {
                        entryDetails.find('.entry-details__wrapper').stick_in_parent();
                    }
                }
            };

            initStickyDetails();
            $(window).on('resize', initStickyDetails);
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Iframe
        //
        //----------------------------------------------------------------------------------------------------//
        function runFlexIframe() {
            var iframes = $('iframe');

            iframes.each(function () {

                // Do not manage WPBakery iframes
                if ($(this).closest('[class^=vc]').length > 0 && $(this).closest('[class^=pikode]').length <= 0) {
                    return;
                }

                var iframe = this,
                    $iframe = $(this);

                /* Calculate the video ratio based on the iframe's w/h dimensions */
                var iframeRatio = (iframe.height / iframe.width) * 100;

                // Remove the hard coded width & height
                $iframe.removeAttr('height').removeAttr('width');

                /* Replace the iframe's dimensions and position the iframe absolute,
                 this is the trick to emulate the iframe ratio */
                $iframe.css({
                    'height': '100%',
                    'width': '100%',
                    'position': 'absolute',
                    'top': '0',
                    'left': '0'
                });

                // Avoid wrapping HTML embed (e.g. pingbacks) and style them accordingly
                if (iframes.hasClass('wp-embedded-content')) {
                    iframes.filter('.wp-embedded-content').each(function () {
                        this.setAttribute('width', '100%');
                    });
                    return;
                }

                /* Wrap the iframe in a new <div> which uses a dynamically fetched
                 padding-top property based on the iframe's w/h dimensions */
                $iframe.wrap('<div class="fluid-embed"></div>');

                $iframe.closest($('.fluid-embed')).css({
                    'width': '100%',
                    'position': 'relative',
                    'padding-top': iframeRatio + '%'
                });
            });
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Isotope
        //
        //----------------------------------------------------------------------------------------------------//
        function runIsotope() {
            var hashChanged = false,
                isOriginLeft = !isRTL;

            var activateCategoryLink = function (link) {
                link.closest('.archive-filter__list').find('.is-active').removeClass('is-active')
                    .addClass('btn--not-selected').animate(500);
                link.removeClass('btn--not-selected').addClass('is-active').animate(500);
            };

            var manageProjectsByUrlParams = function (projectsContainer, isotopeContainer, scroll) {

                var filterProjectsAndActivateCategory = function (projectCategory) {
                    var filterValue = projectCategory === 'all' ? '*' : '.item-category-' + projectCategory;

                    isotopeContainer.isotope({filter: filterValue});

                    var activeCategoryLink = projectsContainer.find('.archive-filter')
                        .find('a[data-category-id="' + projectCategory + '"]');

                    activateCategoryLink(activeCategoryLink);
                };

                if (!scroll && (location.hash === '' || location.hash === '#')) {
                    filterProjectsAndActivateCategory('all');
                    return;
                }

                var projectIndex = projectsContainer.data('index');

                if (projectIndex === undefined || projectIndex !== getLocationHashParam('idx')) {
                    return;
                }

                if (scroll) {
                    scrollToElement(projectsContainer);
                }

                var projectCategory = getLocationHashParam('item_cat');

                if (null !== projectCategory) {
                    filterProjectsAndActivateCategory(projectCategory);
                }
            };

            var filterProjects = function (projectsContainer) {
                projectsContainer.find('.archive-filter').find('a').on('click', function () {
                    hashChanged = true;

                    var link = $(this);

                    projectsContainer.find('.masonry-cards').isotope({filter: link.data('filter-value')});
                    activateCategoryLink(link);
                });
            };

            var initIsotope = function () {
                $('.gallery, .wp-block-gallery:not(.is-cropped)').each(function () {
                    var gallery = $(this).imagesLoaded(function() {
                        gallery.isotope({layoutMode: 'packery', isOriginLeft: isOriginLeft});
                    });
                });

                var archives = $('.archive-list');

                archives.each(function () {
                    var projectsContainer = $(this);

                    projectsContainer.find('.masonry-cards').each(function () {
                        var isotopeContainer = $(this);
                        var $this = isotopeContainer.imagesLoaded(function() {
                            $this.isotope({layoutMode: 'packery', isOriginLeft: isOriginLeft});
                        });

                        // let's assure video metadata has proper values, even when it doesn't manage to load
                        isotopeContainer.find('video').on('loadedmetadata', function () {
                            isotopeContainer.isotope({layoutMode: 'packery', isOriginLeft: isOriginLeft});
                        });

                        manageProjectsByUrlParams(projectsContainer, isotopeContainer, true);
                    });

                    filterProjects(projectsContainer);
                });

                if ('onhashchange' in window) {
                    window.onhashchange = function () {
                        if (hashChanged) {
                            hashChanged = false;
                            return;
                        }

                        archives.each(function () {
                            var projectsContainer = $(this);

                            projectsContainer.find('.masonry-cards').each(function () {
                                manageProjectsByUrlParams(projectsContainer, $(this), false);
                            });
                        });
                    };
                }
            };

            var manageItemsGridNbColumns = function () {
                $(document.body).on('click', '.shop-products-size a', function (event) {
                    event.preventDefault();

                    var button = $(this),
                        nbColumns = button.data('nb-columns'),
                        newCssClass = 'large-up-' + nbColumns,
                        content = button.closest('.shop-filter').siblings('.masonry-cards');

                    if(!button.is('.active')) {
                        button.siblings('a').removeClass('active');
                        button.addClass('active');
                    }

                    if (content.attr('class').indexOf(newCssClass) !== -1) {
                        return;
                    }

                    content.attr('class', function (i, cssClass) {
                        return cssClass.replace(/(^|\s)large-up-\S+/g, ' ' + newCssClass);
                    });

                    content.isotope('destroy');
                    content.isotope({layoutMode: 'packery', isOriginLeft: isOriginLeft});
                });
            };

            initIsotope();
            manageItemsGridNbColumns();
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Image & Video Slider
        //
        //----------------------------------------------------------------------------------------------------//
        function runOwlCarousel() {
            
            //----------------------------------------------------------------------------------------------------//
            //
            //        Product Slider
            //
            //----------------------------------------------------------------------------------------------------//
            var productSlider = $('.owl-carousel-slides'),
                thumbsSlider = '.owl-carousel-thumbnails',
                thumbsSliderNbSlides = parseInt($(thumbsSlider).data('nb-slides'), 10),
                thumbsSliderNbNavigation = $(thumbsSlider).data('navigation') === 1,
                thumbSliderHorizontal = $('.thumbnails-position--horizontal').find(thumbsSlider),
                thumbSliderVertical = $('.thumbnails-position--vertical').find(thumbsSlider),
                productSliderTransitionSpeed = 0,
                thumbsSliderTransitionSpeed = 250;

            // Main Slider
            var currentItem,
                previousItem,
                currentItemIsActive;

            productSlider.owlCarousel($.extend({}, sliderSettings.common, {
                dots: true,
                items: 1,
                loop: false,
                onChanged: function(e) {

                    if (!thumbSliderHorizontal.length && !thumbSliderVertical.length) {
                        return;
                    }

                    currentItem = e.item.index;
                    currentItemIsActive = thumbSliderHorizontal.find('.owl-item').eq(currentItem).hasClass('active');
                    previousItem = $(thumbSliderHorizontal).find('.is-clicked').data('position');

                    $(thumbsSlider).find('.owl-item, .slick-slide').siblings().removeClass('is-clicked');

                    if (thumbSliderHorizontal.length) {
                        thumbSliderHorizontal.find('.owl-item').eq(currentItem).addClass('is-clicked');
                    } else {
                        thumbSliderVertical.find('[data-slick-index="' + currentItem + '"]').addClass('is-clicked');
                    }
                },
                onTranslate: function(e) {

                    if (!thumbSliderHorizontal.length && !thumbSliderVertical.length) {
                        return;
                    }

                    if (thumbSliderHorizontal.length) {

                        // Remove extra active class
                        if(thumbSliderHorizontal.find('.owl-item').data('position') === 0 && currentItem === 0) {
                            thumbSliderHorizontal.find('.owl-item.active').eq(thumbsSliderNbSlides).removeClass('active');
                        }

                        if(previousItem > currentItem && !currentItemIsActive) {
                            thumbSliderHorizontal.trigger('prev.owl.carousel', [thumbsSliderTransitionSpeed]);
                        } else if (previousItem < currentItem && !currentItemIsActive) {
                            thumbSliderHorizontal.trigger('next.owl.carousel', [thumbsSliderTransitionSpeed]);
                        }

                    } else {
                        thumbSliderVertical.slick('slickGoTo', currentItem);
                    }
                }
            })).on('click', '.owl-item', function (e) {
                    e.preventDefault(); });

            // Thumbnails Slider Horizontal
            thumbSliderHorizontal.owlCarousel($.extend({}, sliderSettings.subcommon, {
                dots: false,
                loop: false,
                items: thumbsSliderNbSlides,
                margin: 3,
                nav: thumbsSliderNbNavigation,
                slideBy: thumbsSliderNbSlides
            })).on('click', '.owl-item', function (e) {
                e.preventDefault();
            }).on('mouseenter', '.owl-item', function (e) {
                e.preventDefault();

                productSlider.trigger('to.owl.carousel', [$(this).index(), productSliderTransitionSpeed, true]);
            });

            thumbSliderHorizontal.find('.owl-stage').children().each( function(index) {
                $(this).attr('data-position', index);
            });

            // Remove extra active class
            thumbSliderHorizontal.find('.owl-item.active').eq(thumbsSliderNbSlides).removeClass('active');

            // Thumbnails Slider Vertical
            thumbSliderVertical.slick({
                arrows: thumbsSliderNbNavigation,
                infinite: false,
                slidesToScroll: thumbsSliderNbSlides,
                slidesToShow: thumbsSliderNbSlides,
                speed: thumbsSliderTransitionSpeed,
                vertical: true,
                verticalSwiping: true
            }).on('click', '.slick-slide', function (e) {
                e.preventDefault();
            }).on('mouseenter', '.slick-slide', function (e) {
                e.preventDefault();

                productSlider.trigger('to.owl.carousel', [$(this).index(), productSliderTransitionSpeed, true]);
            });

            $(window).on('resize', function() {
                if (!thumbSliderVertical.length) {
                    return;
                }

                thumbSliderVertical[0].slick.refresh();
            });

            $(thumbsSlider).find('.owl-item, .slick-slide').first().addClass('is-clicked');

            // Product Slider Zoom
            var manageSliderZoom = function () {
                if(isDesktopScreen) {
                    productSlider.find('.owl-item').find('a').zoom({
                        duration: 30,
                        onZoomIn: function () {
                            $('.zoomImg-wrapper').css({opacity: 1, visibility: 'visible'});
                        },
                        onZoomOut: function () {
                            $('.zoomImg-wrapper').css({opacity: 1, visibility: 'hidden'});
                        },
                        target: $('.zoomImg-wrapper').get(0)
                    });
                } else {
                    productSlider.find('.owl-item').find('a').trigger('zoom.destroy');
                }
            };

            manageSliderZoom();
            $(window).on('resize', manageSliderZoom);

            // Variations
            $(document.body).on('change', '.variations select', function () {
                if ($(this).val() === '') {
                    productSlider.trigger('to.owl.carousel', [0, productSliderTransitionSpeed, true]);
                }
            });

            $(document.body).on('show_variation', function (e, variation) {
                if (!variation || !variation.image || !variation.image.src || !variation.image.src.length) {
                    productSlider.trigger('to.owl.carousel', [0, productSliderTransitionSpeed, true]);
                    return;
                }

                productSlider.find('.owl-item').each(function (index, item) {
                    if ($(item).find('div[data-thumb="' + variation.image.gallery_thumbnail_src + '"]').length) {
                        productSlider.trigger('to.owl.carousel', [index, productSliderTransitionSpeed, true]);
                    }
                });
            });

            //----------------------------------------------------------------------------------------------------//
            //
            //        Header Gallery Slider
            //
            //----------------------------------------------------------------------------------------------------//
            var headerGallerySlider = $('.header-gallery').find('.owl-carousel');

            headerGallerySlider.owlCarousel($.extend({}, sliderSettings.common, sliderSettings['default'], {
                onChanged: function () {
                    headerGallerySlider.find('.owl-dots').show();
                },
                onPlayVideo: function () {
                    headerGallerySlider.find('.owl-dots').hide();
                }
            }));

            //----------------------------------------------------------------------------------------------------//
            //
            //        Project Slider
            //
            //----------------------------------------------------------------------------------------------------//
            $('.header-carousel').find('.owl-carousel').each(function() {
                var slider = $(this),
                    nbSlides = parseInt(slider.data('nb-slides'), 10),
                    slidesSpacing = parseInt(slider.data('slides-spacing'), 10);

                var carouselOptions = $.extend({}, sliderSettings.common, {
                    dots: true,
                    loop: true,
                    margin: slidesSpacing,
                    responsive: {
                        0: {
                            items: 1
                        },
                        640: {
                            items: nbSlides >= 2 ? 2 : 1
                        },
                        1024: {
                            items: nbSlides
                        }
                    }
                });

                checkOwlCarouselOptions(slider, carouselOptions, nbSlides);

                slider.owlCarousel(carouselOptions);
            });

            //----------------------------------------------------------------------------------------------------//
            //
            //        Shortcodes Slider
            //
            //----------------------------------------------------------------------------------------------------//
            var shortcodeSlider = $('.pikode--album, .pikode--products, .pikode--projects').find('.owl-carousel');

            shortcodeSlider.each(function() {
                var slider = $(this),
                    shortcodeSliderAutoplay = slider.data('slides-autoplay'),
                    shortcodeSliderAutoplaySpeed = slider.data('slides-autoplay-speed') * 1000,
                    shortcodeSliderNbSlides = parseInt(slider.data('nb-slides'), 10),
                    shortcodeSliderSpacing = parseInt(slider.data('slides-spacing'), 10);

                var carouselOptions = $.extend({}, sliderSettings.common, sliderSettings.advanced, {
                    autoplay: shortcodeSliderAutoplay,
                    autoplayTimeout: shortcodeSliderAutoplaySpeed,
                    dots: false,
                    margin: shortcodeSliderSpacing,
                    responsive: {
                        0: {
                            items: 1
                        },
                        640: {
                            items: shortcodeSliderNbSlides >= 2 ? 2 : 1
                        },
                        1024: {
                            items: shortcodeSliderNbSlides
                        }
                    }
                });

                checkOwlCarouselOptions(slider, carouselOptions, shortcodeSliderNbSlides);

                slider.owlCarousel(carouselOptions);
            });

            //----------------------------------------------------------------------------------------------------//
            //
            //        Crosssells, Upsells & Related Products Slider
            //
            //---------------------------------------------------------------------------------------------------//
            var initSlider = function (selector, nbSlidesKey, autoplayKey) {
                var slider = $(selector);

                if (slider.length === 0) {
                    return;
                }

                var nbSlides = parseInt(themeCustomOptions[nbSlidesKey], 10),
                    slidesSpacing = parseInt(themeCustomOptions.shop_columns_spacing, 10);

                var sliderOptions = {
                    dots: true,
                    margin: slidesSpacing,
                    responsive: {
                        0: {
                            items: 1,
                            slideBy: 1
                        },
                        640: {
                            items: nbSlides >= 2 ? 2 : 1,
                            slideBy: nbSlides >= 2 ? 2 : 1
                        },
                        1024: {
                            items: nbSlides,
                            slideBy: nbSlides
                        }
                    }
                };

                var carouselOptions = $.extend({}, sliderSettings.common, sliderSettings.advanced, sliderOptions, {
                    autoplay: themeCustomOptions[autoplayKey] === '1'
                });

                var carousel = slider.find('.owl-carousel');

                checkOwlCarouselOptions(carousel, carouselOptions, nbSlides);

                carousel.owlCarousel(carouselOptions);
            };

            initSlider('.cross-sells', 'shop_cross_sells_products_nb_columns', 'shop_cross_sells_products_autoplay');
            initSlider('.upsells', 'shop_upsells_products_nb_columns', 'shop_upsells_products_autoplay');
            initSlider('.related-items--products', 'shop_related_products_nb_columns', 'shop_related_products_autoplay');
        }

        function checkOwlCarouselOptions(carousel, options, nbSlides) {
            var nbItems = carousel.children().length;

            options.loop = nbItems > nbSlides;
        }


        //----------------------------------------------------------------------------------------------------//
        //
        //        Video
        //
        //----------------------------------------------------------------------------------------------------//
        function playVideo() {
            var pauseVideo = function (video, controls, playButton) {
                video.get(0).pause();
                playButton.show();

                if (controls.hasAttribute('controls')) {
                    controls.removeAttribute('controls');
                }
            };

            var playVideo = function (video, controls, playButton) {
                video.get(0).play();
                playButton.hide();

                if (!controls.hasAttribute('controls')) {
                    controls.setAttribute('controls', 'controls');
                }
            };

            // Masonry Videos
            $('.fluid-video').find('.featured-video').each(function () {
                var video = $(this),
                    $this = this,
                    videoWrapper = video.closest('.fluid-video'),
                    playButton = videoWrapper.find('.video-play-button');

                if (video.data('autoplay') === 'on') {
                    playVideo(video, $this, playButton);
                }

                if ($this.hasAttribute('poster') && $this.hasAttribute('controls')) {
                    $this.removeAttribute('controls');
                }

                videoWrapper.on('click', function () {

                    if (video.get(0).paused) {
                        playVideo(video, $this, playButton);
                    } else {
                        pauseVideo(video, $this, playButton);
                    }
                });
            });
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Popups
        //
        //----------------------------------------------------------------------------------------------------//
        function initPopupSingle() {
            $('.wp-image-link').magnificPopup({
                autoFocusLast: false,
                disableOn: function () {
                    return !isPhoneScreen;
                },
                callbacks: {
                    open: function () {
                        setTimeout(function() {
                            $('.mfp-image-popup').addClass('animated');
                        });
                    }
                },
                closeBtnInside: false,
                closeMarkup: magnificPopupCloseButton,
                closeOnContentClick: true,
                fixedContentPos: true,
                image: {
                    markup:
                    '<div class="mfp-figure mfp-image-popup">' +
                        '<div class="mfp-top-bar">' +
                            '<div class="mfp-title"></div>' +
                        '</div>' +
                        '<div class="mfp-img"></div>' +
                    '</div>',
                    titleSrc: function (item) {
                        return '<span>' + item.el.next('figcaption').text() + '</span>';
                    }
                },
                mainClass: 'mfp-pikart',
                removalDelay: 500,
                tLoading: '',
                type: 'image'
            });
        }

        function initPopupGallery() {
            var imageMarkup = isRTL ?
                '<div class="mfp-figure mfp-image-popup">' +
                    '<div class="mfp-top-bar">' +
                        '<div class="mfp-title"></div>' +
                    '</div>' +
                    '<div class="mfp-img"></div>' +
                    '<div class="mfp-nav">' +
                        '<div class="mp-arrow mp-arrow-prev mfp-prevent-close">' +
                        '<svg width="11px" height="18px" viewBox="0 0 11 18">' +
                        '<polygon points="2,0 0.6,1.5 8.2,9 0.6,16.6 2,18 9.6,10.4 11,9 "/></svg></div>' +
                        '<div class="mp-arrow mp-arrow-next mfp-prevent-close">' +
                        '<svg width="11px" height="18px" viewBox="0 0 11 18">' +
                        '<polygon points="9,0 10.4,1.5 2.8,9 10.4,16.6 9,18 1.4,10.4 0,9 "/></svg></div>' +
                    '</div>' +
                    '<div class="mfp-bottom-bar">' +
                        '<div class="mfp-counter"></div>' +
                    '</div>' +
                '</div>' :
                '<div class="mfp-figure mfp-image-popup">' +
                    '<div class="mfp-top-bar">' +
                        '<div class="mfp-title"></div>' +
                    '</div>' +
                    '<div class="mfp-img"></div>' +
                    '<div class="mfp-nav">' +
                        '<div class="mp-arrow mp-arrow-prev mfp-prevent-close">' +
                        '<svg width="11px" height="18px" viewBox="0 0 11 18">' +
                        '<polygon points="9,0 10.4,1.5 2.8,9 10.4,16.6 9,18 1.4,10.4 0,9 "/></svg></div>' +
                        '<div class="mp-arrow mp-arrow-next mfp-prevent-close">' +
                        '<svg width="11px" height="18px" viewBox="0 0 11 18">' +
                        '<polygon points="2,0 0.6,1.5 8.2,9 0.6,16.6 2,18 9.6,10.4 11,9 "/></svg></div>' +
                    '</div>' +
                    '<div class="mfp-bottom-bar">' +
                        '<div class="mfp-counter"></div>' +
                    '</div>' +
                '</div>';

            var lightBox = {

                init: function () {
                    var self = this,
                        popupWrapper = $('.gallery, .wp-block-gallery');

                    popupWrapper.each(function () {
                        self.galleryBox($(this));
                    });
                },

                galleryBox: function (element) {
                    element.magnificPopup({
                        autoFocusLast: false,
                        callbacks: {
                            open: function () {
                                setTimeout(function() {
                                    $('.mfp-image-popup').addClass('animated');
                                });

                                var mfpPopup = this;
                                $('.mp-arrow-prev').on('click', function() {
                                    mfpPopup.prev();
                                });
                                $('.mp-arrow-next').on('click', function() {
                                    mfpPopup.next();
                                });
                            }
                        },
                        closeBtnInside: false,
                        closeMarkup: magnificPopupCloseButton,
                        closeOnContentClick: true,
                        delegate: 'a[href*=".jpg"], a[href*=".jpeg"], a[href*=".png"], a[href*=".gif"]',
                        disableOn: function () {
                            return !isPhoneScreen;
                        },
                        fixedContentPos: true,
                        gallery: {
                            enabled: true,
                            arrowMarkup: '',
                            tCounter: '<span class="current-count">%curr%</span>' +
                                      '<span class="separator">/</span>' +
                                      '<span class="total-count">%total%</span>',
                            tPrev: '',
                            tNext: ''
                        },
                        image: {
                            markup: imageMarkup,
                            titleSrc: function (item) {
                                return '<span>' + item.el.closest('.gallery-item, .blocks-gallery-item').find('figcaption').text() +
                                    '</span>';
                            }
                        },
                        mainClass: 'mfp-pikart',
                        removalDelay: 500,
                        tLoading: '',
                        type: 'image'
                    });
                }
            };

            lightBox.init();
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Progress Bar
        //
        //----------------------------------------------------------------------------------------------------//
        function animateProgressBars() {

            $('.pikode--progressbar').each(function () {
                var element = $(this),
                    proBarNumberProgress = function ($this) {
                        var percent = parseFloat($this.find('.progressbar__progress').data('pro-bar-percent')),
                            proBarNumber = $this.find('.progressbar__branding__number').find('span');

                        if (proBarNumber.length) {
                            proBarNumber.each(function () {
                                $(this).countTo({
                                    from: 0,
                                    to: percent,
                                    speed: 1500,
                                    refreshInterval: 50
                                });
                            });
                        }

                    };

                $(this).appear(function () {
                    var proBarProgress = element.find('.progressbar__progress'),
                        proBarPercent = proBarProgress.data('pro-bar-percent');

                    proBarProgress.css('width', '0%');
                    setTimeout(function () {
                        proBarNumberProgress(element);
                        proBarProgress.animate({'width': proBarPercent + '%'}, 1500);
                    }, 750);
                });

            });

            /* Function for number counter to a specific value */
            (function ($) {

                $.fn.countTo = function (options) {
                    // merge the default plugin settings with the custom options
                    options = $.extend({}, $.fn.countTo.defaults, options || {});

                    // how many times to update the value, and how much to increment the value on each update
                    var loops = Math.ceil(options.speed / options.refreshInterval),
                        increment = (options.to - options.from) / loops;

                    return $(this).each(function () {
                        var _this = this,
                            loopCount = 0,
                            value = options.from,
                            interval = setInterval(updateTimer, options.refreshInterval);

                        function updateTimer() {
                            value += increment;
                            loopCount++;
                            $(_this).html(value.toFixed(options.decimals));

                            if (typeof(options.onUpdate) === 'function') {
                                options.onUpdate.call(_this, value);
                            }

                            if (loopCount >= loops) {
                                clearInterval(interval);
                                value = options.to;

                                if (typeof(options.onComplete) === 'function') {
                                    options.onComplete.call(_this, value);
                                }
                            }
                        }
                    });
                };

                $.fn.countTo.defaults = {
                    from: 0,                // the number the element should start at
                    to: 100,                // the number the element should end at
                    speed: 1000,            // how long it should take to count between the target numbers
                    refreshInterval: 100,   // how often the element should be updated
                    decimals: 0,            // the number of decimal places to show
                    onUpdate: null,         // callback method for every time the element is updated,
                    onComplete: null        // callback method for when the element finishes updating
                };
            })(jQuery);
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Parallax
        //
        //----------------------------------------------------------------------------------------------------//
        function initParallax() {

            var parallaxWrapper = $('.parallax'),
                parallaxValue = Math.min(Math.max(1, parseFloat(themeCustomOptions.parallax_speed)), 6);

            //--------------------------------------------------------------------------------------------------------//
            //
            //        Top Setup
            //
            //--------------------------------------------------------------------------------------------------------//
            var setUpTopValueToParallax = function (parallaxWrapper, parallaxedItem, parallaxVal) {
                var topOffsetPageVisibleArea = $(window).scrollTop(),
                    bottomOffsetPageVisibleArea = topOffsetPageVisibleArea + viewportHeight,
                    topOffsetParallaxWrapper = parallaxWrapper.offset().top,
                    bottomOffsetParallaxWrapper = topOffsetParallaxWrapper + parallaxWrapper.height();

                if(viewportWidth <= 1024) {
                    parallaxedItem.css({top: 0});
                    return;
                }

                // let's act when parallaxed item is visible
                if (topOffsetPageVisibleArea <= bottomOffsetParallaxWrapper &&
                    bottomOffsetPageVisibleArea >= topOffsetParallaxWrapper) {
                    var itemTop = -viewportHeight / parallaxVal +
                        (bottomOffsetPageVisibleArea - topOffsetParallaxWrapper) / parallaxVal;

                    parallaxedItem.css({top: itemTop});
                }
            };

            //--------------------------------------------------------------------------------------------------------//
            //
            //        Size & Position Setup for Media Items
            //
            //--------------------------------------------------------------------------------------------------------//
            var setHeightForMediaItems = function (parallaxWrapper, parallaxedItem, parallaxValue) {

                if (!parallaxedItem) {
                    return;
                }

                var parallaxWrapperHeightInit = parallaxWrapper.height(),
                    parallaxedItemHeight =
                        (viewportHeight - parallaxWrapperHeightInit) / parallaxValue + parallaxWrapperHeightInit;

                parallaxedItem.css({
                    height: viewportWidth > 1024 ? parallaxedItemHeight : ''
                });
            };

            //--------------------------------------------------------------------------------------------------------//
            //
            //        Size & Position Setup for Maps
            //
            //--------------------------------------------------------------------------------------------------------//
            var setHeightForMaps = function (parallaxWrapper, parallaxedItem, parallaxValue) {

                if (!parallaxedItem) {
                    return;
                }

                var parallaxWrapperHeightInit = parallaxWrapper.height();

                parallaxedItem.css({
                    height: viewportWidth > 1024 ?
                        (viewportHeight - parallaxWrapperHeightInit) / parallaxValue + parallaxWrapperHeightInit :
                        parallaxWrapperHeightInit
                });

                // preserve initial height for Map Parallax Wrapper
                parallaxWrapper.css('height', parallaxWrapperHeightInit);
            };

            //--------------------------------------------------------------------------------------------------------//
            //
            //        Run Parallax for Media Items
            //
            //--------------------------------------------------------------------------------------------------------//
            var runParallaxForMediaItems = function (parallaxValue) {

                var parallaxItem = parallaxWrapper.find('.background-image'),
                    parallaxItemWrapper = parallaxItem.closest('.parallax');

                if (!parallaxItemWrapper.length) {
                    return;
                }

                parallaxItemWrapper.each(function () {
                    var self = $(this),
                        parallaxItem = self.find('.background-image');

                    setHeightForMediaItems(self, parallaxItem, parallaxValue);
                    setUpTopValueToParallax(self, parallaxItem, parallaxValue);

                    $(window).on('scroll', function () {
                        if (viewportWidth > 1024) {
                            setUpTopValueToParallax(self, parallaxItem, parallaxValue);
                        }
                    });

                    $(window).on('resize', function () {
                        setUpTopValueToParallax(self, parallaxItem, parallaxValue);
                        setHeightForMediaItems(self, parallaxItem, parallaxValue);
                    });
                });
            };

            //--------------------------------------------------------------------------------------------------------//
            //
            //        Run Parallax for Maps
            //
            //--------------------------------------------------------------------------------------------------------//
            var runParallaxForMaps = function (parallaxValue) {

                var parallaxMap = parallaxWrapper.find('>.pikode--map'),
                    parallaxMapWrapper = parallaxMap.closest('.parallax');

                if (!parallaxMap.length) {
                    return;
                }

                parallaxMapWrapper.each(function () {
                    var self = $(this),
                        parallaxItem = self.find('>.pikode--map');

                    setHeightForMaps(self, parallaxItem, parallaxValue);
                    setUpTopValueToParallax(self, parallaxItem, parallaxValue);

                    $(window).on('scroll resize', function () {
                        setUpTopValueToParallax(self, parallaxItem, parallaxValue);
                    });

                    resizeOnWindowWidthChange(function () {
                        setHeightForMaps(self, parallaxItem, parallaxValue);
                    });
                });
            };

            //--------------------------------------------------------------------------------------------------------//
            //
            //        Initialize Parallax
            //
            //--------------------------------------------------------------------------------------------------------//
            runParallaxForMediaItems(parallaxValue);
            runParallaxForMaps(parallaxValue);
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Animated Items
        //
        //----------------------------------------------------------------------------------------------------//
        function runAnimatedItems() {

            var animateElement = function () {
                var animatedElement = $(this),
                    animationClass = animatedElement.data('animation'),
                    animationDelay = animatedElement.data('animation-delay');

                if (animatedElement.is('.not-visible')) {
                    setTimeout(function () {
                        animatedElement.removeClass('not-visible').addClass(animationClass);
                    }, parseInt(animationDelay, 10));
                    setTimeout(function () {
                        animatedElement.removeClass(animationClass);
                    }, parseInt(animationDelay, 10) + 1000);
                }
            };

            var animatedItem = $('.animated');
            animatedItem.appear(animateElement);
        }

        //----------------------------------------------------------------------------------------------------//
        //
        //        Shop
        //
        //----------------------------------------------------------------------------------------------------//
        function setupWishlistIconItemsNumberUpdate() {
            $(document.body).on(
                'pikart_product_added_to_wishlist pikart_product_removed_from_wishlist pikart_refresh_wishlist',
                function (event, wishlist) {
                    var wishlistItems = $('.wishlist__items'),
                        wishlistIconItemsNumberElement = $('.wishlist-icon__items-number'),
                        wishlistItemsNumber = wishlist.length;

                    wishlistIconItemsNumberElement.html(wishlistItemsNumber);

                    if (wishlistItemsNumber) {
                        wishlistItems.show();
                    } else {
                        wishlistItems.hide();
                    }
                }
            );
        }

        function addQuantityInputIncrementers() {
            $(document.body).on('click', '.quantity .input-button', function () {
                var $button = $(this),
                    oldValue = $button.siblings('.input-text').val(),
                    newValue = oldValue === '' ? 0 : parseInt(oldValue, 10);

                if ($button.is('.plus')) {
                    newValue++;
                } else if (newValue > 0 && $button.is('.minus')) {
                    newValue--;
                }

                $button.siblings('.qty').val(newValue).trigger('change');
            });
        }

        function handleProductVariations(slider) {
            $(document.body).on('change', '.variations select', function () {
                if ($(this).val() === '') {
                    slider.trigger('to.owl.carousel', [0, 0, true]);
                }
            });

            $(document.body).on('show_variation', function (e, variation) {
                if (!variation || !variation.image || !variation.image.src || !variation.image.src.length) {
                    slider.trigger('to.owl.carousel', [0, 0, true]);
                    return;
                }

                slider.find('.owl-item').not('.cloned').each(function (index, item) {
                    if ($(item).find('div[data-thumb="' + variation.image.gallery_thumbnail_src + '"]').length) {
                        slider.trigger('to.owl.carousel', [index, 0, true]);
                    }
                });
            });
        }

        function runShopPopups() {

            initProductQuickView();
            runProductVideoInPopup();
            runProductGalleryInPopup();
            manageCompareList();

            function initProductQuickView() {
                var popupCommonSettings = {
                        autoFocusLast: false,
                        closeBtnInside: false,
                        closeMarkup: magnificPopupCloseButton,
                        fixedContentPos: true,
                        mainClass: 'mfp-quick-view',
                        removalDelay: 500,
                        tLoading: ''
                    };

                var runQuickViewFeatures = function (data) {
                    var quickViewPopup = $('.quick-view-popup');

                    // reinit Foundation
                    quickViewPopup.html(data).foundation();

                    $('.woocommerce-product-gallery__wrapper').on('click', 'a', function (e) {
                        e.preventDefault();
                    });

                    runQuickViewCarousel();

                    quickViewPopup.find('.owl-carousel').find('.owl-item').find('a').zoom();
                    quickViewPopup.addClass('animated');
                    $( '.variations_form' ).wc_variation_form();

                    $(document.body).trigger('pikart_addthis_toolbox_init');
                };

                $('.quick-view-button').each(function (index, item) {
                    var qvButton = $(item);

                    qvButton.magnificPopup($.extend(popupCommonSettings, {
                        type: 'ajax',
                        callbacks: {
                            open: function () {
                                runQuickViewFeatures();
                            },
                            ajaxContentAdded: function () {
                                runQuickViewFeatures();
                            }
                        },
                        ajax: {
                            settings: {
                                complete: function (jqXHR) {
                                    setTimeout(function () {
                                        qvButton.off('click');
                                        qvButton.removeData('magnificPopup');

                                        qvButton.magnificPopup($.extend(popupCommonSettings, {
                                            items: {
                                                src: jqXHR.responseText,
                                                type: 'inline'
                                            }
                                        }));
                                    }, 500);

                                }
                            }
                        }
                    }));
                });
            }

            function runQuickViewCarousel() {
                var quickViewCarousel = $('.quick-view-owl-carousel');

                quickViewCarousel.owlCarousel($.extend({}, sliderSettings.common, sliderSettings['default']))
                    .on('click', '.owl-item', function (e) {
                        e.preventDefault();
                    });

                handleProductVariations(quickViewCarousel);
            }

            function runProductVideoInPopup() {
                $('.product-video-button').find('a').magnificPopup({
                    autoFocusLast: false,
                    callbacks: {
                        open: function () {
                            setTimeout(function () {
                                $('.video-iframe-popup').addClass('animated');
                            });
                        }
                    },
                    closeBtnInside: false,
                    closeMarkup: magnificPopupCloseButton,
                    iframe: {
                        markup: '<div class="video-iframe-popup">' +
                        '<div class="mfp-iframe-scaler">' +
                        '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
                        '</div></div>'
                    },
                    mainClass: 'mfp-product-video',
                    removalDelay: 500,
                    tLoading: '',
                    type: 'iframe'
                });
            }

            function runProductGalleryInPopup() {
                var carouselSettings = $.extend({}, sliderSettings.common, {
                    dots: true,
                    items: 1,
                    loop: false
                });

                var productGallery = $('.owl-carousel-slides');

                var getOwlCarouselMaxWidth = function () {
                    return viewportHeight * (productGallery.width() / productGallery.height() - 0.1);
                };

                $('.product-popup-button').find('a').on('click', function () {
                    var popupProductGallery = owlCarouselClone.clone();
                    popupProductGallery.css('max-width', getOwlCarouselMaxWidth());

                    $.magnificPopup.open({
                        autoFocusLast: false,
                        callbacks: {
                            open: function () {
                                popupProductGallery.owlCarousel(carouselSettings);
                                popupProductGallery.wrapAll('<div class="product-gallery-popup"></div>');
                                popupProductGallery.trigger(
                                    'to.owl.carousel', [productGallery.find('.owl-item.active').index(), 1, true]);
                                $('.product-gallery-popup').addClass('animated');
                            },
                            close: function () {
                                productGallery.trigger(
                                    'to.owl.carousel', [popupProductGallery.find('.owl-item.active').index(), 1, true]);
                            },
                            resize: function () {
                                popupProductGallery.css('max-width', getOwlCarouselMaxWidth());
                            }
                        },
                        closeBtnInside: false,
                        closeMarkup: magnificPopupCloseButton,
                        items: {
                            src: popupProductGallery,
                            type: 'inline'
                        },
                        mainClass: 'mfp-product-gallery',
                        removalDelay: 500,
                        tLoading: ''
                    });
                });
            }

            function manageCompareList() {

                // set up Compare Table width
                var setCompareTableWidth = function () {
                    var compareTable = $('.products-compare__list').find('table'),
                        tableColumns = 0,
                        tableWidth;

                    compareTable.find('tbody').find('tr:first').find('td').each(function () {
                        tableColumns++;
                    });

                    tableWidth = 300 * (tableColumns - 1) + 180;
                    compareTable.css('width', tableWidth);
                };

                var updateIconNbItems = function (productsCompareList) {
                    $('.products-compare-icon__items-number').html(productsCompareList.length);
                };

                var openPopup = function (data) {
                    $.magnificPopup.open({
                        autoFocusLast: false,
                        callbacks: {
                            change: function () {
                                setTimeout(function () {
                                    $('.products-compare-popup').addClass('animated');
                                    setCompareTableWidth();
                                });
                            }
                        },
                        closeBtnInside: false,
                        closeMarkup: magnificPopupCloseButton,
                        fixedContentPos: true,
                        items: {
                            src: data.productsCompareHtml,
                            type: 'inline'
                        },
                        mainClass: 'mfp-compare',
                        removalDelay: 500,
                        tLoading: ''
                    });
                };


                $(document.body).on('click', '.products-compare-icon, .mobile-menu-products-compare',
                    function (event) {
                        event.preventDefault();

                        if (window.hasOwnProperty('pikartProductsCompareListConfig')
                            && window.pikartProductsCompareListConfig.hasOwnProperty('compareListData')) {
                            var compareListData = window.pikartProductsCompareListConfig.compareListData;
                            openPopup(compareListData);
                            updateIconNbItems(compareListData.productsCompareList);
                        }
                    }
                );

                $(document.body).on('pikart_product_added_to_compare_list pikart_product_removed_from_compare_list',
                    function (event, data) {
                        openPopup(data);
                        updateIconNbItems(data.productsCompareList);
                    }
                );

                $(document.body).on('pikart_refresh_compare_list', function (event, compareList) {
                    updateIconNbItems(compareList);
                });
            }
        }

        function runShopFilter() {
            var shopFilter = $('.shop-filter');

            var openFilter = function () {
                shopFilter.addClass('is-opened');
            };

            var closeFilter = function () {
                shopFilter.removeClass('is-opened');
            };

            $(document).on('click', '.shop-filter__toolbar__filter', function (e) {
                e.preventDefault();

                if (shopFilter.is('.is-opened')) {
                    closeFilter();
                } else {
                    openFilter();
                }
            });
        }
    });

    function setupGMapConfig() {
        var styles = [
            {
                'featureType': 'administrative',
                'elementType': 'labels.text',
                'stylers': [
                    {
                        'color': '#959595'
                    },
                    {
                        'visibility': 'simplified'
                    }
                ]
            },
            {
                'featureType': 'landscape.man_made',
                'elementType': 'geometry.fill',
                'stylers': [
                    {
                        'color': '#ebebeb'
                    }
                ]
            },
            {
                'featureType': 'landscape.man_made',
                'elementType': 'geometry.stroke',
                'stylers': [
                    {
                        'color': '#c2c2c2'
                    },
                    {
                        'weight': 1
                    }
                ]
            },
            {
                'featureType': 'landscape.natural',
                'elementType': 'geometry.fill',
                'stylers': [
                    {
                        'color': '#ffffff'
                    }
                ]
            },
            {
                'featureType': 'landscape.natural',
                'elementType': 'labels.text',
                'stylers': [
                    {
                        'color': '#959595 '
                    },
                    {
                        'visibility': 'simplified'
                    }
                ]
            },
            {
                'featureType': 'poi',
                'elementType': 'geometry.fill',
                'stylers': [
                    {
                        'color': '#c2c2c2'
                    }
                ]
            },
            {
                'featureType': 'poi',
                'elementType': 'labels.text',
                'stylers': [
                    {
                        'color': '#959595'
                    },
                    {
                        'visibility': 'simplified'
                    }
                ]
            },
            {
                'featureType': 'poi.park',
                'elementType': 'geometry.fill',
                'stylers': [
                    {
                        'color': '#c6daa7'
                    }
                ]
            },
            {
                'featureType': 'road.highway',
                'elementType': 'geometry.fill',
                'stylers': [
                    {
                        'color': '#ffffff'
                    }
                ]
            },
            {
                'featureType': 'road.highway',
                'elementType': 'geometry.stroke',
                'stylers': [
                    {
                        'color': '#c2c2c2'
                    }
                ]
            },
            {
                'featureType': 'road.highway',
                'elementType': 'labels.text',
                'stylers': [
                    {
                        'color': '#959595'
                    },
                    {
                        'visibility': 'simplified'
                    }
                ]
            },
            {
                'featureType': 'transit',
                'elementType': 'geometry.fill',
                'stylers': [
                    {
                        'color': '#c2c2c2'
                    }
                ]
            },
            {
                'featureType': 'water',
                'elementType': 'geometry.fill',
                'stylers': [
                    {
                        'color': themeCustomOptions.feature_color
                    }
                ]
            },
            {
                'featureType': 'water',
                'elementType': 'labels.text',
                'stylers': [
                    {
                        'color': '#c2c2c2'
                    }
                ]
            }
        ];

        if (window.hasOwnProperty('pikartSetupMapShortcodeConfig')) {
            window.pikartSetupMapShortcodeConfig(styles);
        }
    }

    function getLocationHashParam(param) {
        var paramIndex = location.hash.indexOf('#!' + param + '='),
            offset = 0;

        if (paramIndex === -1) {
            paramIndex = location.hash.indexOf('#' + param + '=');
        }

        if (paramIndex === -1) {
            paramIndex = location.hash.indexOf('&' + param + '=');
            offset++;
        }

        if (paramIndex === -1) {
            return null;
        }

        return location.hash.substr(paramIndex + offset).split('&')[0].split('=')[1];
    }

    function scrollToElement(element) {
        if (element.length) {
            $('html,body').animate({scrollTop: element.offset().top}, 'fast');
        }
    }

    function transparencyToOpacity(transparency) {
        return 1 - Math.min(Math.abs(transparency), 100) / 100;
    }

    function hexToRgbaColor(hexColor, opacity) {
        var r, g, b, rgbaColor;

        hexColor = hexColor.replace('#', '');

        r = parseInt(hexColor.substring(0, 2), 16);
        g = parseInt(hexColor.substring(2, 4), 16);
        b = parseInt(hexColor.substring(4, 6), 16);

        rgbaColor = 'rgba(' + r + ',' + g + ',' + b + ',' + opacity + ')';

        return rgbaColor;
    }

    function hexWithTransparencyToRgbaString(hexColor, transparency) {
        return hexToRgbaColor(hexColor, transparencyToOpacity(transparency));
    }

    function resizeOnWindowWidthChange(callback) {
        var currentWindowWidth = $(window).width();

        $(window).on('resize', function () {

            var newWindowWidth = $(window).width();

            if (newWindowWidth !== currentWindowWidth) {
                currentWindowWidth = newWindowWidth;

                callback();
            }
        });
    }

})(jQuery);