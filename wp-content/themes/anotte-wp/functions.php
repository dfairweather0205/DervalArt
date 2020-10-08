<?php

// <editor-fold defaultstate="collapsed" desc="Setup theme">

if (!function_exists('cocobasic_theme_setup')) {



    function cocobasic_theme_setup() {



        $lang_dir = get_template_directory() . '/languages';

        load_theme_textdomain('anotte-wp', $lang_dir);



        global $content_width;

        if (!isset($content_width))

            $content_width = 1170;



        

        add_theme_support( 'align-wide' );

        add_action('wp_enqueue_scripts', 'cocobasic_load_scripts_and_style');

        add_action('admin_print_styles', 'cocobasic_options_admin_styles');

        add_action('wp_ajax_infinite_scroll_index', 'cocobasic_infinitepaginateindex');

        add_action('wp_ajax_nopriv_infinite_scroll_index', 'cocobasic_infinitepaginateindex');



        add_theme_support('post-thumbnails', array('post'));

        add_filter('get_search_form', 'cocobasic_search_form');

        add_action('widgets_init', 'cocobasic_wp_widgets_init');

        add_theme_support('title-tag');



        require get_parent_theme_file_path('/admin/custom-admin.php');



        if (function_exists('automatic-feed-links')) {

            add_theme_support('automatic-feed-links');

        }



        add_action('init', 'cocobasic_register_menu');



        add_editor_style('css/custom-editor-style.css');



        if (current_theme_supports('custom-header')) {

            $default_custom_header_settings = array(

                'default-image' => '',

                'random-default' => false,

                'width' => 0,

                'height' => 0,

                'flex-height' => false,

                'flex-width' => false,

                'default-text-color' => '',

                'header-text' => true,

                'uploads' => true,

                'wp-head-callback' => '',

                'admin-head-callback' => '',

                'admin-preview-callback' => '',

            );

            add_theme_support('custom-header', $default_custom_header_settings);

        }



        if (current_theme_supports('custom-background')) {

            $default_custom_background_settings = array(

                'default-color' => '',

                'default-image' => '',

                'wp-head-callback' => '_custom_background_cb',

                'admin-head-callback' => '',

                'admin-preview-callback' => ''

            );

            add_theme_support('custom-background', $default_custom_background_settings);

        }





        /**

         * Include the TGM_Plugin_Activation class.

         */

        require get_parent_theme_file_path('/admin/class-tgm-plugin-activation.php');

        add_action('tgmpa_register', 'cocobasic_wp_register_required_plugins');

    }



}



add_action('after_setup_theme', 'cocobasic_theme_setup');



//</editor-fold>

// <editor-fold defaultstate="collapsed" desc="Load Google Fonts">

if (!function_exists('cocobasic_google_fonts_url')) {



    function cocobasic_google_fonts_url() {

        $font_url = '';



        if ('off' !== _x('on', 'Google font: on or off', 'anotte-wp')) {

            $font_url = add_query_arg('family', urlencode('Poppins:400,500,700,800|Playfair Display:700|PT Serif:400i'), "//fonts.googleapis.com/css");

        }

        return $font_url;

    }



}

//</editor-fold>

// <editor-fold defaultstate="collapsed" desc="Load CSS and JS">

if (!function_exists('cocobasic_load_scripts_and_style')) {



    function cocobasic_load_scripts_and_style() {



        wp_enqueue_style('anotte-google-fonts', cocobasic_google_fonts_url(), array(), '1.0.0');





//Initialize once to optimize number of cals to get template directory url method

        $base_theme_url = get_template_directory_uri();



//register and load styles which is used on every pages       

        wp_enqueue_style('anotte-clear-style', $base_theme_url . '/css/clear.css');

        wp_enqueue_style('anotte-common-style', $base_theme_url . '/css/common.css');

        wp_enqueue_style('font-awesome', $base_theme_url . '/css/font-awesome.min.css');

        wp_enqueue_style('sm-cleen', $base_theme_url . '/css/sm-clean.css');

        wp_enqueue_style('anotte-main-theme-style', $base_theme_url . '/style.css');
        
        // Add by Ben
        wp_enqueue_style('magic-css', $base_theme_url . '/css/magictool.ben.css');





//JavaScript



        wp_enqueue_script('jquery-js', $base_theme_url . '/js/jquery.min.js', array('jquery'), false, true);
        wp_enqueue_script('html5shiv', $base_theme_url . '/js/html5shiv.js');

        wp_script_add_data('html5shiv', 'conditional', 'lt IE 9');

        wp_enqueue_script('respond', $base_theme_url . '/js/respond.min.js');

        wp_script_add_data('respond', 'conditional', 'lt IE 9');

        wp_enqueue_script('smartmenus', $base_theme_url . '/js/jquery.smartmenus.min.js', array('jquery'), false, true);

        wp_enqueue_script('fitvids', $base_theme_url . '/js/jquery.fitvids.js', array('jquery'), false, true);

        wp_enqueue_script('tipper', $base_theme_url . '/js/tipper.js', array('jquery'), false, true);

        wp_enqueue_script('sticky-kit', $base_theme_url . '/js/jquery.sticky-kit.min.js', array('jquery'), false, true);
        
        // Add by Ben
        wp_enqueue_script('is_magic', $base_theme_url . '/js/magictool.ben.js', array('jquery'), false, true);

        wp_enqueue_script('imagesloaded');
        
        // Add by Emily
        wp_enqueue_script('anotte-main', $base_theme_url . '/js/main.js', array('jquery'), false, true);
        
        if (is_singular()) {

            if (get_option('thread_comments')) {

                wp_enqueue_script('comment-reply');

            }

        }



        $count_posts_index = wp_count_posts('post');

        $published_posts_index = $count_posts_index->publish;

        $posts_per_page_index = get_option('posts_per_page');

        $num_pages_index = ceil($published_posts_index / $posts_per_page_index);



        wp_localize_script('anotte-main', 'ajax_var', array(

            'url' => esc_url(admin_url('admin-ajax.php')),

            'nonce' => wp_create_nonce('ajax-cocobasic-posts-load-more'),

            'posts_per_page_index' => $posts_per_page_index,

            'total_index' => $published_posts_index,

            'num_pages_index' => $num_pages_index

        ));



        $inlineHeaderCss = new CocoBasicLiveCSS();

        wp_add_inline_style('anotte-main', $inlineHeaderCss->cocobasic_theme_customized_style());

    }



}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Admin CSS"> 

if (!function_exists('cocobasic_options_admin_styles')) {



    function cocobasic_options_admin_styles() {

        wp_enqueue_style('cocobasic-wp-custom-admin-layout-css', get_template_directory_uri() . '/admin/css/layout.css');

    }



}



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Custom Search form">

if (!function_exists('cocobasic_search_form')) {



    function cocobasic_search_form($form) {

        $form = '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">

    <label>     

    <input autocomplete="off" type="search" class="search-field" placeholder="' . esc_attr__('Search', 'anotte-wp') . '" value="" name="s" title="' . esc_attr__('Search for:', 'anotte-wp') . '" /> 

</label>    

</form>';



        return $form;

    }



}



//</editor-fold>

// <editor-fold defaultstate="collapsed" desc="Register theme menu">

if (!function_exists('cocobasic_register_menu')) {



    function cocobasic_register_menu() {

        register_nav_menu('custom_menu', 'Main Menu');

    }



}



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Custom menu Walker">

if (!class_exists('cocobasic_header_menu')) {



    class cocobasic_header_menu extends Walker_Nav_Menu {



        var $number = 1;



        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {

            $indent = ( $depth ) ? str_repeat("\t", $depth) : '';



            $class_names = $value = '';



            $classes = empty($item->classes) ? array() : (array) $item->classes;

            $classes[] = 'menu-item-' . $item->ID;



            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));

            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';



            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);

            $id = $id ? ' id="' . esc_attr($id) . '"' : '';



            $output .= $indent . '<li' . $id . $value . $class_names . '>';



            $atts = array();

            $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';

            $atts['target'] = !empty($item->target) ? $item->target : '';

            $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';

            $atts['href'] = !empty($item->url) ? $item->url : '';



            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);



            $attributes = '';

            foreach ($atts as $attr => $value) {

                if (!empty($value)) {

                    $value = ( 'href' === $attr ) ? esc_url($value) : esc_attr($value);

                    $attributes .= ' ' . $attr . '="' . $value . '"';

                }

            }



            $item_output = $args->before;

            $item_output .= '<a' . $attributes . '>';

            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;

            $item_output .= '</a>';

            $item_output .= $args->after;



            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

        }



    }



}



//</editor-fold>

// <editor-fold defaultstate="collapsed" desc="TGM Plugin">

if (!function_exists('cocobasic_wp_register_required_plugins')) {



    function cocobasic_wp_register_required_plugins() {



        $plugins = array(

            array(

                'name' => esc_html('CocoBasic - Anotte WP'),

                'slug' => 'cocobasic-shortcode',

                'source' => get_template_directory() . '/plugins/cocobasic-shortcode.zip',

                'required' => true, 

                'version' => '1.5',

            ),

            array(

                'name' => esc_html('Contact Form 7'),

                'slug' => 'contact-form-7',

                'required' => true

            )

        );





        $config = array(

            'id' => 'anotte-wp',

            'default_path' => '',

            'menu' => 'tgmpa-install-plugins',

            'has_notices' => true,

            'dismissable' => true,

            'dismiss_msg' => '',

            'is_automatic' => false,

            'message' => '',

        );



        tgmpa($plugins, $config);

    }



}



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Sidebar and Widget">

if (!function_exists('cocobasic_wp_widgets_init')) {



    function cocobasic_wp_widgets_init() {

        register_sidebar(array(

            'name' => esc_html__('Menu Sidebar', 'anotte-wp'),

            'id' => 'menu-sidebar',

            'description' => esc_html__('Widgets in this area will be shown in sidebar menu on all pages and posts', 'anotte-wp'),

            'before_widget' => '<li id="%1$s" class="widget %2$s">',

            'after_widget' => '</li>',

            'before_title' => '<h4 class="widgettitle">',

            'after_title' => '</h4>',

        ));

    }



}



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Infinite pagination index">

if (!function_exists('cocobasic_infinitepaginateindex')) {



    function cocobasic_infinitepaginateindex() {

        check_ajax_referer('ajax-cocobasic-posts-load-more', 'security');

        

        $loopFileIndex = sanitize_text_field($_POST['loop_file_index']);

        $pagedIndex = sanitize_text_field($_POST['page_no_index']);

        $posts_per_page = get_option('posts_per_page');



# Load the posts  

        query_posts(array('paged' => $pagedIndex, 'post_status' => 'publish', 'posts_per_page' => $posts_per_page));

        require get_parent_theme_file_path($loopFileIndex . '.php');



        exit;

    }



}



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Archive title filter">

if (!function_exists('cocobasic_archive_title')) {



    function cocobasic_archive_title($title) {

        if (is_category()) {

            $title = single_cat_title('', false);

        } elseif (is_tag()) {

            $title = single_tag_title('', false);

        } elseif (is_author()) {

            $title = get_the_author();

        } elseif (is_post_type_archive()) {

            $title = post_type_archive_title('', false);

        } elseif (is_tax()) {

            $title = single_term_title('', false);

        }



        return $title;

    }



}



//</editor-fold>

// <editor-fold defaultstate="collapsed" desc="Allowed HTML Tags">

if (!function_exists('cocobasic_allowed_html')) {



    function cocobasic_allowed_html() {

        $allowed_tags = array(

            'a' => array(

                'class' => array(),

                'href' => array(),

                'rel' => array(),

                'title' => array(),

                'target' => array(),

                'data-rel' => array(),

            ),

            'abbr' => array(

                'title' => array(),

            ),

            'b' => array(),

            'blockquote' => array(

                'cite' => array(),

            ),

            'cite' => array(

                'title' => array(),

            ),

            'code' => array(),

            'del' => array(

                'datetime' => array(),

                'title' => array(),

            ),

            'dd' => array(),

            'div' => array(

                'class' => array(),

                'title' => array(),

                'style' => array(),

                'id' => array(),

            ),

            'br' => array(),

            'dl' => array(),

            'dt' => array(),

            'em' => array(),

            'h1' => array(

                'class' => array(),

            ),

            'h2' => array(

                'class' => array(),

            ),

            'h3' => array(

                'class' => array(),

            ),

            'h4' => array(

                'class' => array(),

            ),

            'h5' => array(

                'class' => array(),

            ),

            'h6' => array(

                'class' => array(),

            ),

            'i' => array(),

            'img' => array(

                'alt' => array(),

                'class' => array(),

                'height' => array(),

                'src' => array(),

                'width' => array(),

            ),

            'li' => array(

                'class' => array(),

            ),

            'ol' => array(

                'class' => array(),

            ),

            'p' => array(

                'class' => array(),

            ),

            'q' => array(

                'cite' => array(),

                'title' => array(),

            ),

            'span' => array(

                'class' => array(),

                'title' => array(),

                'style' => array(),

            ),

            'strike' => array(),

            'strong' => array(),

            'ul' => array(

                'class' => array(),

            ),

            'iframe' => array(

                'class' => array(),

                'src' => array(),

                'allowfullscreen' => array(),

                'width' => array(),

                'height' => array(),

            )

        );



        return $allowed_tags;

    }



}

// Custom by Redsand Ben



function arrow_shortcode() {
    ob_start();
    ?>
        <div class="arrow-wrapper">
            <span class="arrow-left"><img src="<?php echo get_template_directory_uri() . '/images/left-arrow.svg'; ?>" alt=""></span>
            <span class="arrow-right"><img src="<?php echo get_template_directory_uri() . '/images/right-arrow.svg'; ?>" alt=""></span>
        </div>
    <?php
    $html = ob_get_contents();
    ob_clean();
    ob_end_clean();
    return $html;
}

add_shortcode('arrow_button','arrow_shortcode');

function product_categories_carousel($attrs,$content) {

    extract(shortcode_atts(array(
        'name' => 'slider',
        'portfolio' => 'false',
        'show' => '5'
    ),$attrs));

    if ($portfolio == 'true'):

        $slider_type = 'is-portfolio';

    else:

        $slider_type = 'is-custom';

    endif;

    $args = array(
        'taxonomy'     => 'product_cat',
        'orderby'      => 'id',
        'pad_counts'   => false,
        'hierarchical' => 1,
        'hide_empty'   => false
    );

    $categories = get_categories($args);

    $cat_number = 1;
    $total = count($categories) < 10 ? '0'.count($categories) : count($categories);

    $html = '<div class="product-slider image-slider-wrapper relative swiper-container "><div class = "swiper-wrapper image-slider slider no-product-slider">';
    if(!empty($content)) {
        $html .= do_shortcode($content);
    }
    
    foreach($categories as $category) {

        $cat_id = $category->term_id;
        $cat_name = $category->name;
        $cat_slug = $category->slug;
        
        $cat_number = $cat_number < 10 ? '0'.$cat_number : $cat_number;
        $cat_excerpt = get_term_meta($cat_id,'product_cat_excerpt',true);
        $description = !empty($cat_excerpt) ? $cat_excerpt : $category->name;
        $thumbnail_id = get_woocommerce_term_meta( $cat_id, 'thumbnail_id', true );
        $thumbnail = wp_get_attachment_url( $thumbnail_id ); 
        $html .= '<div class="swiper-slide">';
        $html .= '<div class="carousel-item-image">';
        $html .= '<a href="'. home_url("/product-category/$cat_slug") .'" class="img-thumb">';
        if(!empty($thumbnail)) {
            $html .= '<img src="' . $thumbnail .'" alt="' . $cat_name . '"/>';
        } else {
            $html .= '<img src="' . get_template_directory_uri() .'/images/no-photo.png" alt="No Thumbnail"/>';
        }
        $html .= '</a>';
        $html .= '<div class="carousel-item-info">';
        $html .= '<div class="carousel-cat-links"><ul>';
        $html .= '<li class="portfolio-category">';
        $html .= '<a href="'. home_url("/product-category/$cat_slug") .'">'. $category->name . '</a>';
        $html .= '</li>';
        $html .= '</ul></div>';
        $html .= '<h2><a href="'. home_url("/product-category/$cat_slug") .'">'. $description .'</a></h2></div>';
        $html .= '<p class="post-num"><span>'.$cat_number.'</span><span class="total-num">' . $total . '</span></p>';
        $html .= '</div>';
        $html .= '</div>';
        if($cat_number == $show) {
            break;
        }
        $cat_number++;
    }

    //Add Load More Button at the End
    if($total > $show) {
        $html .= '<div class="swiper-slide more-product-categoies" data-type="category" data-show="'.$show.'"><div class="product-slider-load-more"><span class="more-product-categoies-posts">' . esc_html__('LOAD MORE', 'cocobasic-shortcode') . '</span><span class="more-product-categoies-loading">' . esc_html__('LOADING', 'cocobasic-shortcode') . '</span><span class="no-more-product-categoies">' . esc_html__('NO MORE', 'cocobasic-shortcode') . '</span></div></div>';
    }
    $html .= '</div></div>';
    return $html;
}

add_shortcode('product_slider', 'product_categories_carousel');

function product_categories_loadmore() {
    $page_number = isset($_POST['page_number']) ? $_POST['page_number'] : '';
    $current_categories = isset($_POST['current_categories']) ? $_POST['current_categories'] : '';
    $show = isset($_POST['show']) ? $_POST['show'] : 0;
    $end = (int)$page_number * (int)$show;
    $start = $end - (int)$show;

    $args = array(
        'taxonomy'     => 'product_cat',
        'orderby'      => 'id',
        'pad_counts'   => false,
        'hierarchical' => 1,
        'hide_empty'   => false
    );

    $cat_number = $start + 1;
    $categories = get_categories($args);
    $total = count($categories) < 10 ? '0'.count($categories) : count($categories);
    $html = '';
    for($i = $start; $i < $end; $i++) {
        if(!empty($categories[$i])) {
            $category = $categories[$i];
            $cat_id = $category->term_id;
            $cat_name = $category->name;
            $cat_slug = $category->slug;


            $cat_number = $cat_number < 10 ? '0'.$cat_number : $cat_number;
            $description = !empty($category->description) ? $category->description : $category->name;

            
            $thumbnail_id = get_woocommerce_term_meta( $cat_id, 'thumbnail_id', true );
            $thumbnail = wp_get_attachment_url( $thumbnail_id ); 

            $html .= '<div class="swiper-slide animate-slide">';
            $html .= '<div class="carousel-item-image">';
            $html .= '<a href="'. home_url("/product-category/$cat_slug") .'" class="img-thumb">';

            if(!empty($thumbnail)) {
                $html .= '<img class="ajax-loaded" src="' . esc_url($thumbnail) .'" alt="' . $cat_name . '"/>';
            } else {
                $html .= '<img class="ajax-loaded" src="' . get_template_directory_uri() .'/images/no-photo.png" alt="No Thumbnail"/>';
            }
            $html .= '</a>';
            $html .= '<div class="carousel-item-info">';
            $html .= '<div class="carousel-cat-links"><ul>';
            $html .= '<li class="portfolio-category">';
            $html .= '<a href="'. home_url("/product-category/$cat_slug") .'">'. $category->name . '</a>';
            $html .= '</li>';
            $html .= '</ul></div>';
            $html .= '<h2><a href="'. home_url("/product-category/$cat_slug") .'">'. $description .'</a></h2></div>';
            $html .= '<p class="post-num"><span>'.$cat_number.'</span><span class="total-num">' . $total . '</span></p>';
            $html .= '</div>';
            $html .= '</div>';
            $cat_number++;
        }
    }
    wp_send_json_success(array('html' => $html , 'count' => ceil(count($categories)/$show)));
}

add_action('wp_ajax_product_categories_loadmore','product_categories_loadmore');
add_action('wp_ajax_nopriv_product_categories_loadmore','product_categories_loadmore'); 

function product_loadmore() {
    $term_id = isset($_POST['term_id']) ? $_POST['term_id'] : '';
    $page = isset($_POST['page_number']) ? $_POST['page_number'] : '';
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
        'tax_query' => [
            [
                'taxonomy' => 'product_cat',
                'terms' => (int)$term_id,
                'include_children' => false // Remove if you need posts from term 7 child terms
            ],
        ],
    );
    $end = $page * 5;
    $start = $end - 5;
    $query = new WP_Query($args);
    $posts = $query->posts;
    $product_number = $start + 1;
    $total = count($posts) < 10 ? '0'.count($posts) : count($posts);
    for($i = $start; $i < $end; $i++) {
        if(!empty($posts[$i])) {

            $product_number = $product_number < 10 ? '0'.$product_number : $product_number;
            $post = $posts[$i];
            $post_id = $post->ID;
            $post_url = $post->guid;
            $post_name = $post->post_title;
            $post_excerpt = $post->post_excerpt;
            $post_thumbnail = get_the_post_thumbnail_url($post_id);
            $html .= '<div class="swiper-slide animate-slide">';
            $html .= '<div class="carousel-item-image">';
            $html .= '<a href="" class="image-zoom"><img src="'. get_template_directory_uri() .'/images/plus.svg" alt=""></a>';
            $html .= '<a href="'.$post_url.'" class="img-thumb">';
        
            if(!empty($post_thumbnail)) {
                $html .= '<img class="ajax-loaded" src="' . $post_thumbnail .'" alt="' . $post_name . '"/>';
            } else {
                $html .= '<img class="ajax-loaded" src="' . get_template_directory_uri() .'/images/no-photo.png" alt="No Thumbnail"/>';
            }
            $html .= '</a>';
            $html .= '<div class="carousel-item-info product_by_term">';
            $html .= '<div class="carousel-cat-links"><ul>';
            $html .= '<li class="portfolio-enquiry"><a class="enquiry-btn" href="">ENQUIRY</a></li>';
            $html .= '<li class="portfolio-category"><a href="'. $post_url .'">'. $post_name . '</a></li>';
            $html .= '<li class="portfolio-description">'.$post_excerpt.'</li>';
            $html .= '</ul></div></div>';
            $html .= '<p class="post-num"><span>'.$product_number.'</span><span class="total-num">' . $total . '</span></p>';
            $html .= '</div>';
            $html .= '</div>';
            $product_number++;
        }
    }
    wp_send_json_success(array('html' => $html , 'count' => ceil(count($posts)/5)));
}
add_action('wp_ajax_product_loadmore','product_loadmore');
add_action('wp_ajax_nopriv_product_loadmore','product_loadmore');

function product_shop_loadmore() {
    $term_id = isset($_POST['term_id']) ? $_POST['term_id'] : '';
    $page = isset($_POST['page_number']) ? $_POST['page_number'] : '';
    $args = array(
        'posts_per_page' => 5,
        'post_type' => 'product',
        'orderby' => 'title',
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => 'tshirt'
            )
        ),
    );
    $end = $page * 5;
    $start = $end - 5;
    $query = new WP_Query($args);
    $posts = $query->posts;
    $product_number = $start + 1;
    $total = count($posts) < 10 ? '0'.count($posts) : count($posts);
    for($i = $start; $i < $end; $i++) {
        if(!empty($posts[$i])) {

            $product_number = $product_number < 10 ? '0'.$product_number : $product_number;
            $post = $posts[$i];
            $post_id = $post->ID;
            $post_url = $post->guid;
            $post_name = $post->post_title;
            $post_excerpt = $post->post_excerpt;
            $post_thumbnail = get_the_post_thumbnail_url($post_id);
            $html .= '<div class="swiper-slide animate-slide">';
            $html .= '<div class="carousel-item-image">';
            $html .= '<a href="" class="image-zoom"><img src="'. get_template_directory_uri() .'/images/plus.svg" alt=""></a>';
            $html .= '<a href="'.$post_url.'" class="img-thumb">';
        
            if(!empty($post_thumbnail)) {
                $html .= '<img src="' . $post_thumbnail .'" alt="' . $post_name . '"/>';
            } else {
                $html .= '<img src="' . get_template_directory_uri() .'/images/no-photo.png" alt="No Thumbnail"/>';
            }
            $html .= '</a>';
            $html .= '<div class="carousel-item-info product_by_term">';
            $html .= '<div class="carousel-cat-links"><ul>';
            $html .= '<li class="portfolio-enquiry"><a class="enquiry-btn" href="">ENQUIRY</a></li>';
            $html .= '<li class="portfolio-category"><a href="'. $post_url .'">'. $post_name . '</a></li>';
            $html .= '<li class="portfolio-description">'.$post_excerpt.'</li>';
            $html .= '</ul></div></div>';
            $html .= '<p class="post-num"><span>'.$product_number.'</span><span class="total-num">' . $total . '</span></p>';
            $html .= '</div>';
            $html .= '</div>';
            $product_number++;
        }
    }
    wp_send_json_success(array('html' => $html , 'count' => ceil(count($posts)/5)));
}
add_action('wp_ajax_product_shop_loadmore','product_shop_loadmore');
add_action('wp_ajax_nopriv_product_shop_loadmore','product_shop_loadmore');

// Woo custom function
function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );
function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 5;
  return $cols;
}

function product_by_product_category_id($term_id) {
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'tax_query' => [
            [
                'taxonomy' => 'product_cat',
                'terms' => (int)$term_id,
                'include_children' => false // Remove if you need posts from term 7 child terms
            ],
        ],
        // Rest of your arguments
    );
    $products = new WP_Query( $args );
    return  $products->posts;
}

add_filter('product_by_category_id','product_by_product_category_id',1,5);

add_theme_support('post-thumbnails', array('product'));

function product_dropdown_shortcode($attrs = [],$content = null) {
    $attr = shortcode_atts(
        array(),
        $atts
    );
    $term = get_queried_object();
    $posts = product_by_product_category_id($term->term_id);
    $data_type = '';
    if($term->post_type == 'product') {
        $posts = $term;
        $data_type = 'single-product';
    }
    return '<div id="product-data" data-type="'.$data_type.'">'.json_encode($posts).'</div>';
}

add_shortcode('product_dropdown','product_dropdown_shortcode');

add_filter( 'wpcf7_form_elements', 'mycustom_wpcf7_form_elements' );
 

function mycustom_wpcf7_form_elements( $form ) {
    $form = do_shortcode( $form );
 
    return $form;
}

function right_page($atts, $content = null) {
    extract(shortcode_atts(array(
        'url' => str_replace('http:','https:',get_post_meta($page_id, "page_split_img", true)),
        'gallery' => '',
        'right' => ''
    ),$atts));

    $page = get_page_by_title('contact');
    $page_id = $page->ID;
    $right_url = !empty($url) ? $url :  str_replace('http:','https:',get_post_meta($page_id, "page_split_img", true));
    if(!empty($right)) {
        $right_url = get_option("page_$right");
    }
    $gallery_array = json_decode($gallery);

    $html .= '<div class="page-split-right" style="background-image: url('.$right_url.');">';
    $html .= '<img class="split-image" src="'. $right_url .'" alt="">';
    // If gallery equal true display product gallery
    if($gallery) {
        global $product;
        $gallery_ids = $product->get_gallery_image_ids();
        if(count($gallery_ids) > 0):
            $html .= '<div class="custom-gallery-wrap">';
            $html .= '<div class="custom-galerry-transform">';
            foreach($gallery_ids as $gallery_id) {
            $gallery_url = wp_get_attachment_url( $gallery_id);
            $html .= '<div class="custom-gallery-item" style="background-image: url('.$gallery_url.')">';
            $html .= '<img src="'.$gallery_url.'" atl="'.$gallery_url.'">';
            $html .= '</div>';
            }
            $html .= '</div></div>';
        endif;
    }

    $html .= '</div>';
    echo $html;
}

add_shortcode('right_page','right_page');

add_filter('woocommerce_login_redirect', 'login_redirect');

function login_redirect($redirect_to) {

    return home_url();

}

add_filter( 'wc_stripe_show_payment_request_on_checkout', '__return_true' );


function cart_product_count() {
    $result = WC()->cart->get_cart_contents_count();
    wp_send_json_success($result);
}

add_action('wp_ajax_cart_product_count','cart_product_count');
add_action('wp_ajax_nopriv_cart_product_count','cart_product_count');


function product_category_edit_custom_field($term) {
    $product_execerpt = get_term_meta($term->term_id, 'product_cat_excerpt', true);
    var_dump($product_execerpt);
    ?>
    <tr class="form-field form-required term-excerpt-wrap">
        <th scope="row"><label for="product_cat_excerpt">Excerpt</label></th>
        <td><input name="product_cat_excerpt" id="product_cat_excerpt" type="text" value="<?php echo $product_execerpt; ?>" size="40" aria-required="true">
        <p class="description">The excerpt is how it appears on your site.</p></td>
    </tr>
    <?php
}
function product_category_add_custom_field($term) {
    ?>
    <div class="form-field form-required term-excerpt-wrap">
        <label for="product_cat_excerpt">Excerpt</label>
        <input name="product_cat_excerpt" id="product_cat_excerpt" type="text" value="" size="40" aria-required="true">
        <p class="description">The excerpt is how it appears on your site.</p>
    </div>
    <?php
}

add_action('product_cat_add_form_fields', 'product_category_add_custom_field', 10, 2);
add_action('product_cat_edit_form_fields', 'product_category_edit_custom_field', 10, 2);

function wcr_save_category_fields($term_id) {
    if (isset($_POST['product_cat_excerpt'])) {
        update_term_meta($term_id, 'product_cat_excerpt', sanitize_text_field($_POST['product_cat_excerpt']));
    }
}

// Save the fields values, using our callback function
// if you have other taxonomy name, replace category with the name of your taxonomy. ex: edited_book, create_book
add_action('edited_product_cat', 'wcr_save_category_fields', 10, 2);
add_action('create_product_cat', 'wcr_save_category_fields', 10, 2);


add_action( 'wpcf7_init', 'wpcf7_add_form_tag_mycustomfield' );

function wpcf7_add_form_tag_mycustomfield() {
    wpcf7_add_form_tag( array( 'myCustomField', 'myCustomField*'),
        'wpcf7_mycustomfield_form_tag_handler', array( 'name-attr' => true ) );
}

function wpcf7_mycustomfield_form_tag_handler( $tag ) {
    $tag = new WPCF7_FormTag( $tag );

    if ( empty( $tag->name ) ) {
        return '';
    }

    $atts = array();

    $class = wpcf7_form_controls_class( $tag->type );
    $atts['class'] = $tag->get_class_option( $class );
    $atts['id'] = $tag->get_id_option();

    $atts['name'] = $tag->name;
    $atts = wpcf7_format_atts( $atts );

    $html = sprintf( '<select %s></select>', $atts );
    return $html;
}

function format_woo_endpoint_name($end_point) {
    $string = $end_point;
    switch($end_point) {
        case 'orders': 
            $string = 'My Orders';
        break;
        case 'view-order':
            $string = "View Order";
        break;
        case 'Downloads':
            $string = 'Downloads';
        break;
        case 'edit-account': 
            $string = 'Edit Account';
        break;
        case 'edit-address':
            $string = 'Edit Address';
        break;
        case 'payment-methods': 
            $string = 'Payment Methods';
        break;
        case 'lost-password':
            $string = 'Lost Password';
        break;
        case 'customer-logout': 
            $string = 'Customer Logout';
        break;
    }
    return $string;
}

function create_breadcrum($atts, $content = null) {
    extract(shortcode_atts(array(
        'name' => '',
        'post_id' => ''
    ),$atts));
    $html = '<div class="breadcrums-wrap"><p class="title-description-up breadcrums">';
    switch($name) {
        case 'home': 
            $html .= '<a class="disable" href="'.home_url().'">Home</a>';
        break;
        case 'product_by_category': 
            $term = get_queried_object();
            $term_slug = $term->slug;
            $html .= '<a href="'.home_url().'">Home</a>';
            $html .= '<a class="disable" href="'.home_url("/product-category/$term_slug").'"> '.$term->name.'</a>';
        break;
        case 'single_post': 
            $post_id = $post_id;
            $term = (get_the_terms($post_id, 'product_cat'))[0];
            $html .= '<a href="'.home_url().'">Home</a>';
            $html .= '<a href="'.home_url("/product-category/$term->slug").'"> '.$term->name.'</a>';
            $html .= '<a class="disable" href="'.get_post_permalink($post_id).'"> '.get_the_title($post_id).'</a>';
        break;
        case 'page': 
            global $wp_query;
            $end_point =  WC()->query->get_current_endpoint();
            $post = $wp_query->get_queried_object();
            $pagename = $post->post_title;
            $page_slug = $post->post_name;
            $html .= '<a href="'.home_url().'">Home</a>';
            if(empty($end_point)) {
                $html .= '<a class="disable" href="'.home_url("/$page_slug").'"> '.$pagename.'</a>';
            } else {
                $end_point_name = format_woo_endpoint_name($end_point);
                $html .= '<a href="'.home_url("/$page_slug").'"> '.$pagename.'</a>';
                $html .= '<a class="disable" href="'.home_url("/$page_slug/$end_point").'"> '.$end_point_name.'</a>'; 
            }
        break;
    }
    $html .= '</p></div>';
    return $html;
}

add_shortcode('breadcrum','create_breadcrum');


function custom_big_text($atts, $content = null) {
    extract(shortcode_atts(array(
        "up" => ''
        ), $atts));
    $return = '';
    if ("up" !== ''):
        $return .= '<p class="title-description-up">' . $up . '</p>';
    endif;
    $return .= do_shortcode('[breadcrum name="page"]');
    $return .= '<h1 class="entry-title big-text">' . do_shortcode($content) . '</h1>';
    return $return;
}



add_shortcode("custom_big_text", "custom_big_text");


function custom_carousel_slide($atts, $content = null) {
    extract(shortcode_atts(array(
        "img" => get_template_directory_uri() . '/images/no-photo.png"',
        "type" => '',
        "title" => '',
        "des" => '',
        "alt" => '',
        "link" => '#',
        "target" => '_self',
        "class" => '',
        'breadcrum' => ''
        ), $atts));
    $slide_content = '';
    if ($type === 'text'):
        $slide_content .= '<div class="swiper-slide text-slide ' . $class . '">';
        $slide_content .= '<div class="carousel-item-text">';

        $slide_content .= '<p class="title-description-up">' . $des . '</p>';
        $slide_content .= do_shortcode('[breadcrum name="'.$breadcrum.'"]');
        $slide_content .= '<h1 class="entry-title big-text">' . $title . '</h1>';
        $slide_content .= '<div class="carousel-content">' . do_shortcode($content) . '</div>';
        $slide_content .= '</div></div>';
    elseif ($type === 'gallery'):
        $slide_content .= '<div class="swiper-slide gallery-slide  ' . $class . '">';
        $slide_content .= '<div class="carousel-item-gallery">';
        $slide_content .= '<div class="carousel-content"><ul class="coco-image-gallery">' . do_shortcode($content) . '</ul></div>';
        $slide_content .= '</div>';
        $slide_content .= '</div>';
    else:
        $slide_content .= '<div class="swiper-slide custom-image-slide  ' . $class . '">';
        $slide_content .= '<div class="carousel-item-image">';
        if ($link !== '#') {
            $slide_content .= '<a class="img-thumb" href="' . $link . '" targer="' . $target . '"><img src = "' . $img . '" alt = "' . $alt . '" /></a>';
        } else {
            $slide_content .= '<div class="carousel-item-image-shadow">';
            $slide_content .= '<img src = "' . $img . '" alt = "' . $title . '" />';
            $slide_content .= '</div>';
        }
        $slide_content .= '<div class="carousel-item-info"><h2>';
        if ($link !== '#') {
            $slide_content .= '<a href="' . $link . '" targer="' . $target . '">' . $title . '</a>';
        } else {
            $slide_content .= $title;
        }
        $slide_content .= '</h2></div>';
        $slide_content .= '<p class="post-num"><span>0</span><span class="total-num">0</span></p>';
        $slide_content .= '</div></div>';
    endif;
    return $slide_content;

}



add_shortcode("custom_carousel_slide", "custom_carousel_slide");


add_filter('woocommerce_general_settings', 'general_settings_page_right_section');
function general_settings_page_right_section($settings) {

     $settings['title_custom-page'] = array(
        'name' => __('Page Right Section Image', 'woocommerce-custom-discount-tab'),
        'type' => 'title',
        'desc' => '',
        'id' => 'title_custom',
        'class' => 'start'
    );
    $settings['page_right_cart'] = array(
        'name' => __('Cart Page', 'woo'),
        'type' => 'text',
        'desc' => '',
        'id' => 'page_cart', 
        'class' => 'jfdkfja'            
    );

    $settings['page_right_acount'] = array(
        'name' => __('Acount Page', 'woo'),
        'type' => 'text',
        'desc' => '',
        'id' => 'page_acount', 
        'class' => 'jfdkfja'            
    );
    $settings['page_right_login'] = array(
        'name' => __('Login Page', 'woo'),
        'type' => 'text',
        'desc' => '',
        'id' => 'page_login', 
        'class' => 'jfdkfja'            
    );
    $settings['page_right_register'] = array(
        'name' => __('Register Page', 'woo'),
        'type' => 'text',
        'desc' => '',
        'id' => 'page_register', 
        'class' => 'jfdkfja'            
    );

    $settings['section_end_custom_page'] = array(
        'type' => 'sectionend',
        'id' => 'section_end_custom_giftcard',
        'class' => 'end'
    );
    return $settings;
}

/* End By Ben */
//</editor-fold>

/* add new  */

function all_term_product_cat() {
    $arr_show = array();
    $terms =  get_terms( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'fields' => 'ids'
    ) );

    if (count($terms) > 0) {
        foreach ($terms as $key => $term_id) {
           
        if (get_field('show_add_to_cart','term_' . $term_id)) {
            $arr_show[] = $term_id;
        }
    }
    
}
return $arr_show;
}
// The custom replacement button function
function custom_product_button(){
    // HERE your custom button text and link
    $button_text = __( "Enquiry", "woocommerce" );
    $button_link = '#';

    // Display button
   // echo '<a class="button" href="'.$button_link.'">' . $button_text . '</a>';
    echo '<div class="portfolio-enquiry"><a class="enquiry-btn enquiry-btn-single" href="">ENQUIRY</a></div>';
    echo    '<div class="enquiry-wrap">';
     echo '  <div>';
       echo ' <img id="close-enquiry" src="'.get_template_directory_uri() .'/images/close.svg" alt="">';
      echo '  <p class="form-name">Product Enquiry</p>';
       
        echo do_shortcode('[contact-form-7 id="607" title="Enquiry form"]');
        
    echo '</div>';
}

// Replacing the single product button add to cart by a custom button for a specific product category
add_action( 'woocommerce_single_product_summary', 'replace_single_add_to_cart_button', 1 );
function replace_single_add_to_cart_button() {
    global $product;

        $term_show = get_term_enquiry() ;
       
        
    // Only for product category ID 64
    if( has_term( $term_show, 'product_cat', $product->get_id() ) ){

        // For variable product types (keeping attribute select fields)
        if( $product->is_type( 'variable' ) ) {
            remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
            add_action( 'woocommerce_single_variation', 'custom_product_button', 20 );
        }
        // For all other product types
        else {
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
            add_action( 'woocommerce_single_product_summary', 'custom_product_button', 30 );
        }
    }
}

add_filter( 'woocommerce_is_purchasable', 'command', 10, 2 );

function command( $value, $product ) {
    $term_show = get_term_enquiry() ;
     if( has_term( $term_show, 'product_cat', $product->get_id() ) ){
        return false;
     }
    

    return $value;
}


add_filter('woocommerce_general_settings', 'general_settings_shop_phone');
function general_settings_shop_phone($settings) {

     $settings['title_custom-giftcard'] = array(
              'name' => __('Select Category Show Enquiry', 'woocommerce-custom-discount-tab'),
              'type' => 'title',
              'desc' => '',
              'id' => 'title_custom',
              'class' => '5555555555555'
          );

     $terms =  get_terms( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'fields' => 'ids'
    ) ); 
     foreach ($terms as $key => $term_id) {
       $term_show = 'equiry_'.$term_id;
       $term_item = get_term_by('id',$term_id,'product_cat');
       $name = $term_item -> name;
    
       $settings[$term_show] = array(
              'name' => __($name, 'woo'),
              'type' => 'checkbox',
              'desc' => '',
              'id' => $term_show, 
              'class' => 'jfdkfja'            
          );
    } 
        // $settings['section_ahaha'] = array(

        // );
    $settings['section_end_custom_giftcard'] = array(
            'type' => 'sectionend',
            'id' => 'section_end_custom_giftcard',
            'class' => 'kjkj'
    );
    return $settings;
}

function get_term_enquiry() {
     $terms =  get_terms( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'fields' => 'ids'
    ) ); 
    $arr_term = array();
    foreach ($terms as $key => $term_id) {

       $option_item = get_option('equiry_'.$term_id);

       if ($option_item == 'yes') {
        $arr_term[] = $term_id;
       }
    }
    return $arr_term;
}

function breadcrumbs($id = null){
    ?>
    <div id="breadcrumbs" class="clearfix">
        <a href="<?php bloginfo('url'); ?>">Home</a></span> >
        <?php if(!empty($id)): ?>
        <a href="<?php echo get_permalink( $id ); ?>" ><?php echo get_the_title( $id ); ?></a> >
        <?php endif; ?>
        <span class="breadcrumb_last"><?php the_title(); ?></span>
    </div>
<?php }


//code by Emily
function filter_show(){
    $data_show_post = $_POST['show_number'];
        $args = array(
            'posts_per_page' => $data_show_post,
            'post_type' => 'product',
            'order'=>'DESC',
            'orderby' => 'title',   
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => 'tshirt'
                )
            ),
        );
        $html= "";
        $posts = 'No posts found.';
        $the_query = new WP_Query( $args );
        
        if ( $the_query->have_posts() ) :  
            ob_start();      

            while ( $the_query->have_posts() ) : $the_query->the_post();  
                ?>    
                <div class="swiper-slide">
                    <a class="img-thumbnail" href="<?php the_permalink()?>">
                        <?php echo get_the_post_thumbnail($post->ID); ?>
                    </a>
                    <div class="product-info">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>  
                        <?php $price = get_post_meta( get_the_ID(), '_price', true ); ?>
                        <p><?php echo wc_price( $price ); ?></p>
                    </div>                                                         
                </div>
                <?php
            endwhile;
        endif;
        wp_reset_postdata();
        $products = ob_get_contents();
    ob_clean();
    ob_end_flush();
    ob_start();
            ?>
            
            <?php 
                echo paginate_links( array(
                    'base'         => '%_%',
                    'total'        => $the_query->max_num_pages,
                    'current'      => max( 1, get_query_var( 'paged' ) ),
                    'format'       => '?paged=%#%&numberpost='.$data_show_post,
                    'show_all'     => false,
                    'type'         => 'plain',
                    'end_size'     => 2,
                    'mid_size'     => 1,
                    'prev_next'    => true,
                    'prev_text'    => sprintf( '<i class="fa fa-long-arrow-left" aria-hidden="true"></i> %1$s', __( '', 'anotte-wp' ) ),
                    'next_text'    => sprintf( '%1$s <i class="fa fa-long-arrow-right" aria-hidden="true"></i>', __( '', 'anotte-wp' ) ),
                    'add_args'     => false,
                    'add_fragment' => '',
                ));
            ?>           
           
            <?php 
            $pagenavi = ob_get_contents();
            ob_clean();
            ob_end_flush(); 
            wp_send_json_success(array('products' => $products,'pagenavi' => $pagenavi));
       
    die();      
}
add_action('wp_ajax_filter_show','filter_show');
add_action('wp_ajax_nopriv_filter_show','filter_show');



