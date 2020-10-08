(function ($) {

    "use stict";

    // COLORS                         
    wp.customize('preloader_background_color', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;
            inlineStyle = '<style class="custom-color-css1">';

            inlineStyle += '.site-wrapper .doc-loader { background-color: ' + to + '; }';            

            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css1');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });

    wp.customize('menu_background_color', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;
            inlineStyle = '<style class="custom-color-css2">';
            
            inlineStyle += '.site-wrapper .menu-left-part { background-color: ' + to + '; }';            

            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css2');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });

    wp.customize('single_pagination_hover_background', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;
            inlineStyle = '<style class="custom-color-css3">';

            inlineStyle += '.single .site-wrapper .nav-links > a:hover { background-color: ' + to + '; }';                        

            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css3');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });

    wp.customize('global_select_color', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;
            inlineStyle = '<style class="custom-color-css4">';

            inlineStyle += '.site-wrapper .page-numbers:hover, .site-wrapper .tags-holder a:hover, .site-wrapper .wp-link-pages > a:hover, body .site-wrapper #sidebar a:hover, .site-wrapper h4.widgettitle, .site-wrapper .replay-at-author, .site-wrapper .error-text-404, .site-wrapper .menu-right-text .menu-text a, .site-wrapper p.menu-text-title { color: ' + to + '; }';
            inlineStyle += '.site-wrapper .page-numbers.current, .site-wrapper .sm-clean > li > a:after, .single-post .site-wrapper .post-info-wrapper .entry-info:after, .site-wrapper .tags-holder a, .single .site-wrapper .nav-links > a, .site-wrapper .wp-link-pages > span, .site-wrapper .gallery-item-text, .site-wrapper .horizontal-slider .carousel-cat-links ul li a { background-color: ' + to + '; }';
            inlineStyle += '.site-wrapper .page-numbers.current, .site-wrapper #header-main-menu .search-field:focus, .site-wrapper .tags-holder a, .site-wrapper .search-field:focus { border-color: ' + to + '; }';

            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css4');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });

})(jQuery);