(function ($) {

    "use strict";

    var count = 1;



    

    //$(".site-content").fitVids();

    loadMoreArticleIndex();

    menuWidthHeightFix();

    setToltip();

	fixPullquoteClass();

$('.title-description-up')

//Placeholder show/hide

    $('input, textarea').on('focus', function () {

        $(this).data('placeholder', $(this).attr('placeholder'));

        $(this).attr('placeholder', '');

    });

    $('input, textarea').on('blur', function () {

        $(this).attr('placeholder', $(this).data('placeholder'));

    });



    $(".single-post .entry-info").stick_in_parent({offset_top: 64, parent: ".single-content-wrapper", spacer: ".sticky-spacer"});



//Fix for default menu

    $(".default-menu ul:first").addClass('sm sm-clean main-menu');





    $(window).on('load', function () {



        // Animate the elemnt if is allready visible on load

        animateElement();



//Set menu

        // $('.main-menu').smartmenus({

        //     subMenusSubOffsetX: 1,

        //     subMenusSubOffsetY: -8,

        //     markCurrentItem: true

        // });



        // var $mainMenu = $('.main-menu').on('click', 'span.sub-arrow', function (e) {

        //     var obj = $mainMenu.data('smartmenus');

        //     if (obj.isCollapsible()) {

        //         var $item = $(this).parent(),

        //         $sub = $item.parent().dataSM('sub');

        //         $sub.dataSM('arrowClicked', true);

        //     }

        // }).bind({

        //     'beforeshow.smapi': function (e, menu) {

        //         var obj = $mainMenu.data('smartmenus');

        //         if (obj.isCollapsible()) {

        //             var $menu = $(menu);

        //             if (!$menu.dataSM('arrowClicked')) {

        //                 return false;

        //             }

        //             $menu.removeDataSM('arrowClicked');

        //         }

        //     }

        // });



        //Blog show feature image

        showFirstBlogPostFeatureImge();

        showBlogPostFeatureImge();



        //Show-Hide header sidebar

        $('#toggle').on("click", multiClickFunctionStop);



        $('.site-content, #toggle').addClass('all-loaded');

        $('.doc-loader').fadeOut();

        $('body').removeClass('wait-preloader');

    });





    $(window).on('resize', function () {



        //Fix for blog item info

        $(".blog-item-holder.has-post-thumbnail").not('.gif').each(function () {

            $(this).find(".item-text").css("margin-top", 0 - $(this).find(".item-info").outerHeight());

        });



    });



    $(window).on('scroll', function () {

        animateElement();

    });









//------------------------------------------------------------------------

//Helper Methods -->

//------------------------------------------------------------------------



    function animateElement(e) {

        $(".animate").each(function (i) {

            var top_of_object = $(this).offset().top;

            var bottom_of_window = $(window).scrollTop() + $(window).height();

            if ((bottom_of_window - 70) > top_of_object) {

                $(this).addClass('show-it');

            }

        });

    }    



    function multiClickFunctionStop(e) {

        e.preventDefault();

        $('#toggle').off("click");

        $('#toggle').toggleClass("on");



        $('html, body, .sidebar, .menu-left-part, .menu-right-part, .site-content').toggleClass("open").delay(500).queue(function (next) {

            $(this).toggleClass("done");

            next();

        });

        $('#toggle').on("click", multiClickFunctionStop);

    }    



    function loadMoreArticleIndex() {

        if (parseInt(ajax_var.posts_per_page_index) < parseInt(ajax_var.total_index)) {

            $('.more-posts').css('visibility', 'visible');

            $('.more-posts').animate({opacity: 1}, 1500);

        } else {

            $('.more-posts').css('display', 'none');

        }



        $('.more-posts:visible').on('click', function () {

            $('.more-posts').css('display', 'none');

            $('.more-posts-loading').css('display', 'inline-block');

            count++;

            loadArticleIndex(count);

        });

    }



    function loadArticleIndex(pageNumber) {

        $.ajax({

            url: ajax_var.url,

            type: 'POST',

            data: "action=infinite_scroll_index&page_no_index=" + pageNumber + '&loop_file_index=loop-index&security='+ajax_var.nonce,

            success: function (html) {

                $('.blog-holder').imagesLoaded(function () {

                    $(".blog-holder .more-posts-index-holder").before(html);

                    setTimeout(function () {

                        animateElement();

                        showBlogPostFeatureImge();

                        if (count == ajax_var.num_pages_index)

                        {

                            $('.more-posts').css('display', 'none');

                            $('.more-posts-loading').css('display', 'none');

                            $('.no-more-posts').css('display', 'inline-block');

                        } else

                        {

                            $('.more-posts').css('display', 'inline-block');

                            $('.more-posts-loading').css('display', 'none');

                            $(".more-posts-index-holder").removeClass('stop-loading');

                        }

                    }, 100);

                });

            }

        });

        return false;

    }



    function showFirstBlogPostFeatureImge() {

        $(".blog-item-holder .entry-holder").first().addClass('active-post');

    }



    function showBlogPostFeatureImge() {

        $(".blog-item-holder .entry-holder").on('hover', function () {

            $(".blog-item-holder .entry-holder").removeClass('active-post');

            $(this).addClass('active-post');

        });

    }



    function menuWidthHeightFix() {

        if (!$(".menu-right-text").length)

        {

            $('#header-main-menu').addClass('no-right-text');

        }

        if (!$("#sidebar").length)

        {

            $('.menu-left-part').addClass('no-sidebar');

        }

    }



    function setToltip() {

        $(".tooltip").tipper({

            direction: "left",

            follow: true

        });

    }

	

	function fixPullquoteClass() {

		$("figure.wp-block-pullquote").find('blockquote').first().addClass('cocobasic-block-pullquote');

	}



    function is_touch_device() {

        return !!('ontouchstart' in window);

    }

    var $mySwiper1 = undefined;
    var $mySwiper2 = undefined;
    var $mySwiper3 = undefined;
    /* code by Emily */
    $('.tab-click').click(function(e) {
        var tab = $(this).data('tab');
        $(this).parents('.tab-item').removeClass('active');
        $('.tab-click').removeClass('active');
        $('#' + tab).addClass('active');
        $(this).addClass('active');
        

        if ($('#tab-grid .product-slider-grid').length) {
            if ($(window).width() >= 1281 && $mySwiper1 == undefined)
            {
                // if ($(window).width() > 1280) {
                    $('#tab-grid .product-slider-grid .swiper-wrapper').removeClass('no-product-slider');
                    $mySwiper1 = new Swiper('#tab-grid .product-slider-grid', {
                        direction: 'vertical',
                        slidesPerView: 2,
                        slidesPerColumn: 2,
                        loop:false,
                        autoHeight: true,
                        slidesPerView: 'auto',
                        
                        mousewheel: {
                            releaseOnEdges: true
                        },
                        keyboard: true,
                        simulateTouch: false,
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true
                        },
                        navigation: {
                            nextEl: '.arrow-right',
                            prevEl: '.arrow-left',
                        },
                        observer: true, 
                        observeParents: true,
                        freeMode: true,
                    });
                // }

                // if ($(window).width() <= 1280) {
                //     $('#tab-grid .product-slider-grid .swiper-wrapper').removeClass('no-product-slider');
                //     $mySwiper1 = new Swiper('#tab-grid .product-slider-grid', {
                //         direction: 'vertical',
                //         slidesPerView: 1,
                //         slidesPerColumn: 1,
                //         loop:false,
                //         autoHeight: true,
                //         slidesPerView: 'auto',
                        
                //         mousewheel: {
                //             releaseOnEdges: true
                //         },
                //         keyboard: true,
                //         simulateTouch: false,
                //         pagination: {
                //             el: '.swiper-pagination',
                //             clickable: true
                //         },
                //         navigation: {
                //             nextEl: '.arrow-right',
                //             prevEl: '.arrow-left',
                //         },
                //         observer: true, 
                //         observeParents: true,
                //         freeMode: true,
                //     });
                // }
            }
            
            if ($(window).width() < 1281 && $mySwiper1 !== undefined)
            {
                $mySwiper1.destroy();
                $mySwiper1 = undefined;
                $('#tab-grid .product-slider-grid .swiper-wrapper').removeAttr('style').addClass('no-product-slider');
                $('#tab-grid .product-slider-grid .swiper-slide').removeAttr('style');
            }
        }

        if ($('#tab-listing .product-slider2').length) {
            if ($(window).width() >= 1021 && $mySwiper2 == undefined)
            {
                $('#tab-listing .product-slider2 .swiper-wrapper').removeClass('no-product-slider');
               $mySwiper = new Swiper('#tab-listing .product-slider2', {
                    slidesPerView: 'auto',
                    spaceBetween: 0,
                    mousewheel: {
                        releaseOnEdges: true
                    },
                    keyboard: true,
                    simulateTouch: false,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                    navigation: {
                        nextEl: '.arrow-right',
                        prevEl: '.arrow-left',
                    },
                    freeMode: true

                });
            }

            if ($(window).width() < 1021 && $mySwiper2 !== undefined)
            {

                $mySwiper2.destroy();
                $mySwiper2 = undefined;
                $('#tab-listing .product-slider2 .swiper-wrapper').removeAttr('style').addClass('no-product-slider');
                $('#tab-listing .product-slider2 .swiper-slide').removeAttr('style');
            }
        }

        $('#tab-listing .product-slider .swiper-wrapper').removeAttr('style').addClass('no-product-slider');

        $('.show-product').on('change', function() {            
            var data_show_number = $(this).find('option:selected').val();
            console.log(data_show_number);
            $.ajax({ 
                url: ajax_var.url,
                method: 'post',
                dataType : "json",
                data : {
                        action: 'filter_show',
                        'show_number': data_show_number
                },
                beforeSend: function(){
                },
                success: function(response) {
                    $(window).scrollTop(0);
                    $('.product-slider-grid .swiper-wrapper').html(response.data.products);
                    $('.product-slider-grid .swiper-wrapper').addClass("scrolltop");
                    $('.pagination-area').html(response.data.pagenavi);

                },
                error: function( jqXHR, textStatus, errorThrown ){
                }
            });
        });

    })
    $('.tab-click:first').click();

    // Code By Ben
    var count = 1;
    var currentProductCategories = $(".carousel-item-image").length;
    var $mySwiper = undefined;
    var $mySwiper1 = undefined;

    productSliderContentWidth();

    function productSliderContentWidth() {
        if ($('.product-slider').length)
        {
            $('.site-content').addClass('has-product-slider');
            $('.portfolio-content').removeClass('content-1170 center-relative');
            //Fix for Custom Slider Number Of Slide
            if ($('.product-slider').hasClass('is-custom'))
            {
                var total = $('.product-slider.is-custom .custom-image-slide').length;
                total = (total < 10) ? ("0" + total) : total;
                $('.total-num').html(total);
                $('.custom-image-slide').each(function (n) {
                    n++;
                    n = (n < 10) ? ("0" + n) : n;
                    $(this).find('.post-num span').first().html(n);
                });
            }
        }
    }

    


    $('.more-product-categoies').on('click', function () {
        if (!$(this).hasClass('click-off')) {
            $('.more-product-categoies-posts').css('display', 'none');
            $('.more-product-categoies-loading').css('display', 'block');
            const type = $(this).data('type');
            const term_id = $(this).data('term');
            const number = $(this).data('show');
            count++;
            loadProductCategoryItems(count, currentProductCategories,type,term_id,number);
        }
    });

    function loadProductCategoryItems(pageNumber,currentProductCategories,type,term_id,show) {
        switch(type) {
            case 'category': 
                $.ajax({
                    url: ajax_var.url,
                    data: {
                        action: 'product_categories_loadmore',
                        page_number: pageNumber,
                        current_categories: currentProductCategories,
                        show: show
                    },
                    dataType: 'json',
                    method: 'post'
                }).done(function(msg) {
                    if(msg.success) {
                        var html = msg.data['html'];
                        var $newItems = $(html);
                        var totalNumberOfPortfolioPages = msg.data['count'];
                        $('.more-product-categoies').imagesLoaded(function () {
                            $($newItems).insertBefore('.more-product-categoies');
                            setTimeout(function () {
                                const ajaxLoaded = document.querySelectorAll('.ajax-loaded');
                                var loadedCheck = true;
                                var loaded = setInterval(function() {
                                    ajaxLoaded.forEach(function(item) {
                                        const completed = item.complete;
                                        if(!completed) {
                                            loadedCheck = false
                                        }
                                    });
                                    if(loadedCheck) {
                                        if (count == totalNumberOfPortfolioPages)
                                        {
                                            $('.more-product-categoies-posts').css('display', 'none');
                                            $('.more-product-categoies-loading').css('display', 'none');
                                            $('.no-more-product-categoies').css('display', 'block');
                                            $('.more-product-categoies').addClass('click-off');
                                        } else
                                        {
                                            $('.more-product-categoies-posts').css('display', 'block');
                                            $('.more-product-categoies-loading').css('display', 'none');
                                        }
                                        if ($(window).width() > 1024)
                                        {
                                            $mySwiper.update();
                                        }
                                        $('.swiper-slide').addClass("animate-done");
                                        clearInterval(loaded);
                                    } else {
                                        loadedCheck = true;
                                    }
                                },100);
                            }, 500);
                        });
                    }
                });
            break;
            case 'product': 
                $.ajax({
                    url: ajax_var.url,
                    data: {
                        action: 'product_loadmore',
                        page_number: pageNumber,
                        current_categories: currentProductCategories,
                        term_id: term_id
                    },
                    dataType: 'json',
                    method: 'post'
                }).done(function(msg) {
                    if(msg.success) {
                        var html = msg.data['html'];
                        var $newItems = $(html);
                        var totalNumberOfPortfolioPages = msg.data['count'];
                        $('.more-product-categoies').imagesLoaded(function () {
                            $($newItems).insertBefore('.more-product-categoies');
                            setTimeout(function () {
                                const ajaxLoaded = document.querySelectorAll('.ajax-loaded');
                                var loadedCheck = true;
                                var loaded = setInterval(function() {
                                    ajaxLoaded.forEach(function(item) {
                                        const completed = item.complete;
                                        if(!completed) {
                                            loadedCheck = false
                                        }
                                    });
                                    if(loadedCheck) {
                                        if (count == totalNumberOfPortfolioPages)
                                        {
                                            $('.more-product-categoies-posts').css('display', 'none');
                                            $('.more-product-categoies-loading').css('display', 'none');
                                            $('.no-more-product-categoies').css('display', 'block');
                                            $('.more-product-categoies').addClass('click-off');
                                        } else
                                        {
                                            $('.more-product-categoies-posts').css('display', 'block');
                                            $('.more-product-categoies-loading').css('display', 'none');
                                        }
                                        if ($(window).width() > 1024)
                                        {
                                            $mySwiper.update();
                                        }
                                        $('.swiper-slide').addClass("animate-done");
                                        clearInterval(loaded);
                                    } else {
                                        loadedCheck = true;
                                    }
                                },100);
                            }, 500);
                        });
                    }
                });
            break;
        }
    }

    document.querySelectorAll('.ajax-loaded').forEach(function(item) {
        console.log(item);
    });

    $(window).on('load', function () {
        //Set Carousel Slider
        setUpCarouselSlider();
        //Set Image Slider
        imageSliderSettings();
        menuBtnClass();
    });

    $(window).on('resize', function () {
        //Set Carousel Slider
        setUpCarouselSlider();
        menuBtnClass();
    });

    function setUpCarouselSlider() {
        if ($('.product-slider').length) {
            if ($(window).width() >= 1021 && $mySwiper == undefined)
            {
                $('.swiper-wrapper').removeClass('no-product-slider');
                $mySwiper = new Swiper('.product-slider', {
                    slidesPerView: 'auto',
                    spaceBetween: 0,
                    mousewheel: {
                        releaseOnEdges: true
                    },
                    keyboard: true,
                    simulateTouch: false,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                    navigation: {
                        nextEl: '.arrow-right',
                        prevEl: '.arrow-left',
                    },
                    freeMode: true

                });
            }

            if ($(window).width() < 1021 && $mySwiper !== undefined)
            {
                $mySwiper.destroy();
                $mySwiper = undefined;
                $('.swiper-wrapper').removeAttr('style').addClass('no-product-slider');
                $('.swiper-slide').removeAttr('style');
            }
        }

        if ($('#tab-grid .product-slider-grid').length) {
            if ($(window).width() >= 1281 && $mySwiper1 == undefined)
            {
                // if ($(window).width() > 1280) {
                    $('#tab-grid .product-slider-grid .swiper-wrapper').removeClass('no-product-slider');
                    $mySwiper1 = new Swiper('#tab-grid .product-slider-grid', {
                        direction: 'vertical',
                        slidesPerView: 2,
                        slidesPerColumn: 2,
                        loop:false,
                        autoHeight: true,
                        slidesPerView: 'auto',
                        
                        mousewheel: {
                            releaseOnEdges: true
                        },
                        keyboard: true,
                        simulateTouch: false,
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true
                        },
                        navigation: {
                            nextEl: '.arrow-right',
                            prevEl: '.arrow-left',
                        },
                        observer: true, 
                        observeParents: true,
                        freeMode: true,
                    });
                // }
             
            }
            
            if ($(window).width() < 1281 && $mySwiper1 !== undefined)
            {
                $mySwiper1.destroy();
                $mySwiper1 = undefined;
                $('#tab-grid .product-slider-grid .swiper-wrapper').removeAttr('style').addClass('no-product-slider');
                $('#tab-grid .product-slider-grid .swiper-slide').removeAttr('style');
            }
        }

        if ($('#tab-listing .product-slider2').length) {
            if ($(window).width() >= 1021 && $mySwiper2 == undefined)
            {
                $('#tab-listing .product-slider2 .swiper-wrapper').removeClass('no-product-slider');
               $mySwiper = new Swiper('#tab-listing .product-slider2', {
                    slidesPerView: 'auto',
                    spaceBetween: 0,
                    mousewheel: {
                        releaseOnEdges: true
                    },
                    keyboard: true,
                    simulateTouch: false,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                    navigation: {
                        nextEl: '.arrow-right',
                        prevEl: '.arrow-left',
                    },
                    freeMode: true

                });
            }

            if ($(window).width() < 1021 && $mySwiper2 !== undefined)
            {

                $mySwiper2.destroy();
                $mySwiper2 = undefined;
                $('#tab-listing .product-slider2 .swiper-wrapper').removeAttr('style').addClass('no-product-slider');
                $('#tab-listing .product-slider2 .swiper-slide').removeAttr('style');
            }
        }

        //slider gallery
        if ($('#temp-new-page .gallery-slider').length) {
            $mySwiper3 = new Swiper('#temp-new-page .gallery-slider', {
                centeredSlides: true,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                  },
                observer: true, 
                observeParents: true,
                freeMode: true,
            });
        }
            

    }


    function imageSliderSettings() {
        $(".simple-image-slider-wrapper").each(function () {
            var id = $(this).attr('id');
            var auto_value = window[id + '_auto'];
            var speed_value = window[id + '_speed'];
            auto_value = (auto_value === 'true') ? true : false;
            if (auto_value === true)
            {
                var mySwiper = new Swiper('#' + id, {
                    autoplay: {
                        delay: speed_value
                    },
                    slidesPerView: 1,
                    pagination: {
                        el: '.swiper-pagination-' + id,
                        clickable: true
                    }
                });
                $('#' + id).hover(function () {
                    mySwiper.autoplay.stop();
                }, function () {
                    mySwiper.autoplay.start();
                    ;
                });
            } else {
                var mySwiper = new Swiper('#' + id, {
                    slidesPerView: 1,
                    pagination: {
                        el: '.swiper-pagination-' + id,
                        clickable: true
                    }
                });
            }
        });
    }

    $(document).on('click','.enquiry-btn',function(e) {
        if(!($(this).hasClass('redirect'))) {
            e.preventDefault();
            $('.enquiry-wrap').addClass('open');
        }
    });
    $(document).on('click','#close-enquiry',function(e) {
        e.preventDefault();
        $('.enquiry-wrap').removeClass('open');
    });

    $(document).on('click','.image-zoom',function(e) {
        e.preventDefault();
        var imgUrl = $(this).parents('.carousel-item-image').find('.img-thumb').find('img').attr('src');
        $('#img-zoom').find('#img').attr('src',imgUrl);
        $('.zoom-el img').attr('src',imgUrl);
        $('#img-zoom').addClass('open');
    });
    $(document).on('click','#zoom-close',function(e) {
        e.preventDefault();
        $('#img-zoom').removeClass('open');
        $('#example').trigger('zoom.destroy');
    });

    $('.preview-show').click(function(e) {
        e.preventDefault();
        const clicked = $(this).hasClass('open');
        if(clicked) {
            $(this).removeClass('open');
            $(this).parent().find('.preview').removeClass('open');
        } else {
            $(this).addClass('open');
            $(this).parent().find('.preview').addClass('open');
        }
    });

    $(document).on('submit','.woocommerce-cart-form',function(e) {
        const qtyInput = $('input.qty');
        var totalProduct = 0;
        qtyInput.each(function(e) {
            if(!isNaN(Number($(this).val()))) {
                totalProduct += Number($(this).val());
            }
        });
        $('.cart-count').text(totalProduct);
    });


    $(document).on('input','.product-quantity input[type="number"]',function(e) {
        if (e.originalEvent.detail == undefined) {
            setTimeout(function() {
                $('button[type="submit"]').click();
            },200);
        }
    });

    $(document).on('keypress','.product-quantity input[type="number"]',function(e) {
        if(e.which === 13) {
            const qtyInput = $('input.qty');
            var totalProduct = 0;
            qtyInput.each(function(e) {
                if(!isNaN(Number($(this).val()))) {
                    totalProduct += Number($(this).val());
                }
            });
            $('.cart-count').text(totalProduct);
        }
    });

    $('input.qty').focusout(function(e) {
        setTimeout(function() {
            console.log('dsssdsd');
            $('button[name="update_cart"]').click();
        },200);
    });
    // Single product gallery images cta
    $(document).on('click','.custom-gallery-item',function(e) {
        e.preventDefault();
        const url = $(this).find('img').attr('src');
        $('.page-split-right').css('background-image','url('+url+')');
        $('.split-image').attr('src',url);
    });

    var mouseHold = {
        status: false,
        hold: undefined
    }

    var gallery = {
        wrapWidth: $('.custom-gallery-wrap').width(),
        wrapTransform: $('.custom-galerry-transform').width(),
        transform: 0
    }

    $(document).on('mousedown','.custom-gallery-wrap',function(e) {
        mouseHold.status = true;
        mouseHold.hold = e.clientX;
    });


    $(document).on('mouseup','.custom-gallery-wrap',function(e) {
        $('.custom-gallery-item').removeClass('no-hover');
        mouseHold.status = false;
        mouseHold.hold = undefined;
    });

    $(document).on('mouseleave','.custom-gallery-wrap',function(e) {
        e.preventDefault();
        $('.custom-gallery-item').removeClass('no-hover');
        mouseHold.status = false;
        mouseHold.hold = undefined;
    });

    $(document).on('mousemove','.custom-gallery-wrap',function(e) {
        if(mouseHold.hold !== undefined && mouseHold.status == true && gallery.wrapWidth < gallery.wrapTransform) {
            $('.custom-gallery-item').addClass('no-hover');
            var mouseX = e.clientX,
                mouseMove = mouseHold.hold - mouseX,
                transform = gallery.wrapWidth - gallery.wrapTransform;
                
            if(mouseMove < 0) {
                if(gallery.transform <= 0) {
                    gallery.transform += 1;
                    $('.custom-galerry-transform').css('transform','translateX('+gallery.transform+'px)');
                }
            } else {
                if(gallery.transform >= transform) {
                    gallery.transform = gallery.transform -  1;
                    $('.custom-galerry-transform').css('transform','translateX('+gallery.transform+'px)');
                }
            }
            
            mouseHold.hold = mouseX;
        }
    });

    function getProductCount() {
        var loop = setInterval(function() {
            const overlay  = $('.blockUI.blockOverlay').length;
            if(overlay <= 0) {
                $.ajax({
                    url: ajax_var.url,
                    method: 'post',
                    dataType: 'json',
                    data: {
                        action: 'cart_product_count'
                    }
                })
                .done(function(msg) {
                    if(msg.success) {
                            $('.cart-count').text(msg.data);
                    }
                });
                clearInterval(loop);
            }
        },20);
    }
    function menuBtnClass() {
        if(window.innerWidth < 1020) {
            $('.menu-btn').addClass('mb-menu');
        } else {
            $('.menu-btn').removeClass('mb-menu');
        }
    }
    $(document).on('click','.mb-menu > a',function(e) {
        e.preventDefault();
        if(window.innerWidth < 1020) {
            return false;
        } 
    });

    $(".product-name").change(function() {
        var value = $(this).val();
        if (value != '') {
            $(this).addClass("active");
        } else {
            $(this).removeClass("active");
        }
    });

    $(document).on('click','.custom-gallery-item',function(e) {
        $('.custom-gallery-item').removeClass('selected');
        $(this).addClass('selected');
    });
    





    // edit submenu
    $('.menu-item-has-children').find('> a').addClass('has-children').append('<span class="sub-arrow"></span>');

    $(document).on('click','.sub-arrow',function(e) {
        e.preventDefault();
        const menuItem = $(this).parents('.menu-item');
        if(menuItem.hasClass('focused')) {
            menuItem.removeClass('focused');
            menuItem.find('.sub-menu').slideUp();
        } else {
            menuItem.addClass('focused');
            menuItem.find('.sub-menu').slideDown();
        }
    });
})(jQuery);

