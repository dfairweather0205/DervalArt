(function ($) {
    "use stict";
    var $mySwiper = undefined;
    var count = 1;
    var portfolioPostsPerPage = $(".carousel-item-image").length;
    var totalNumberOfPortfolioPages = Math.ceil(parseInt(ajax_var_portfolio.total) / portfolioPostsPerPage);

    //Fix for Horizontal Slider
    horizontalSliderContentWidth();
    //Gallery Image Slider Fix    
    galleryImage();
    //PrettyPhoto initial    
    setPrettyPhoto();
    //Hide Portfolio Load More Button
    showHidePortfolioLoadMoreButton();
    //Load more articles in Portfolio
    loadMorePortfolioOnClick();
    //Fix fot Hover Image Slide if no Title
    fixHoverImageNoTitle();

    $(window).on('load', function () {
        //Set Carousel Slider
        setUpCarouselSlider();
        //Set Image Slider
        imageSliderSettings();
    });

    $(window).on('resize', function () {
        //Set Carousel Slider
        setUpCarouselSlider();
    });

    function showHidePortfolioLoadMoreButton() {
        if (portfolioPostsPerPage >= parseInt(ajax_var_portfolio.total)) {
            $('.more-posts-portfolio').remove();
        }
    }

    function loadMorePortfolioOnClick() {
        $('.more-posts-portfolio').on('click', function () {
            if (!$(this).hasClass('click-off')) {
                $('.more-portfolio-posts').css('display', 'none');
                $('.more-portfolio-loading').css('display', 'block');
                count++;
                loadPortfolioMoreItems(count, portfolioPostsPerPage);
            }
        });
    }

    function loadPortfolioMoreItems(pageNumber, portfolioPostsPerPage) {
        $.ajax({
            url: ajax_var_portfolio.url,
            type: 'POST',
            data: "action=portfolio_ajax_load_more&portfolio_page_number=" + pageNumber + "&portfolio_posts_per_page=" + portfolioPostsPerPage + "&total_portfolio_posts=" + ajax_var_portfolio.total + "&security=" + ajax_var_portfolio.nonce,
                    success: function (html) {
                        var currentPosition = $('.more-posts-portfolio').position().left;
                        var $newItems = $(html);
                        $('.more-posts-portfolio').imagesLoaded(function () {
                            $($newItems).insertBefore('.more-posts-portfolio');
                            if (count == totalNumberOfPortfolioPages)
                            {
                                $('.more-portfolio-posts').css('display', 'none');
                                $('.more-portfolio-loading').css('display', 'none');
                                $('.no-more-portfolio').css('display', 'block');
                                $('.more-posts-portfolio').addClass('click-off');
                            } else
                            {
                                $('.more-portfolio-posts').css('display', 'block');
                                $('.more-portfolio-loading').css('display', 'none');
                            }
                            setTimeout(function () {
                                if ($(window).width() > 1024)
                                {
                                    $mySwiper.update();
                                }
                                $('.swiper-slide').addClass("animate-done");
                            }, 500);
                        });
                    }
        });
        return false;
    }

    function setUpCarouselSlider() {
        if ($('.horizontal-slider').length) {
            if ($(window).width() >= 1007 && $mySwiper == undefined)
            {
                $('.swiper-wrapper').removeClass('no-horizontal-slider');
                $mySwiper = new Swiper('.horizontal-slider', {
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
                    freeMode: true

                });
            }

            if ($(window).width() < 1007 && $mySwiper !== undefined)
            {
                $mySwiper.destroy();
                $mySwiper = undefined;
                $('.swiper-wrapper').removeAttr('style').addClass('no-horizontal-slider');
                $('.swiper-slide').removeAttr('style');
            }
        }
    }

    function galleryImage() {
        $('.coco-gallery-item:eq(' + Math.ceil($('.coco-gallery-item').length / 2) + ')').addClass('split-gallery');
        $(".inverse-black-white .coco-gallery-item").hover(function () {
            $(".inverse-black-white .coco-gallery-item").not(this).addClass('b-w');
        }, function () {
            $(".inverse-black-white .coco-gallery-item").removeClass('b-w');
        });
    }

    function setPrettyPhoto() {
        $('a[data-rel]').each(function () {
            $(this).attr('rel', $(this).data('rel'));
        });
        $("a[rel^='prettyPhoto']").prettyPhoto({
            slideshow: false, /* false OR interval time in ms */
            overlay_gallery: false, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
            default_width: 1280,
            default_height: 720,
            deeplinking: false,
            social_tools: false,
            iframe_markup: '<iframe src ="{path}" width="{width}" height="{height}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'
        });
    }

    function horizontalSliderContentWidth() {
        if ($('.horizontal-slider').length)
        {
            $('.site-content').addClass('has-horizontal-slider');
            $('.portfolio-content').removeClass('content-1170 center-relative');
            //Fix for Custom Slider Number Of Slide
            if ($('.horizontal-slider').hasClass('is-custom'))
            {
                var total = $('.horizontal-slider.is-custom .custom-image-slide').length;
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

    function fixHoverImageNoTitle() {
        $(".horizontal-slider .carousel-item-image").each(function () {
            if ($(this).find('h2').text() == '')
            {
                $(this).addClass('no-title-on-slide');
            }
        });
    }

    function setToltip() {
        $(".tooltip").tipper({
            direction: "left",
            follow: true
        });
    }
})(jQuery);