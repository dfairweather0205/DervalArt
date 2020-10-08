<?php



/*

  Plugin Name: CocoBasic - Anotte WP

  Description: User interface used in Anotte WP theme.

  Version: 1.5

  Author: CocoBasic

  Author URI: https://www.cocobasic.com

 */





if (!defined('ABSPATH'))

    die("Can't load this file directly");



class cocobasic_shortcodes {



    function __construct() {

        add_action('init', array($this, 'myplugin_load_textdomain'));

        add_action('admin_init', array($this, 'cocobasic_admin_enqueue_script'));

        add_action('wp_enqueue_scripts', array($this, 'cocobasic_enqueue_script'));

        add_action('init', array('cocobasicPageTemplater', 'get_instance'));

        if ((version_compare(get_bloginfo('version'), '5.0', '<')) || (class_exists( 'Classic_Editor' )) ) {

            add_action('admin_init', array($this, 'cocobasic_action_admin_init'));

        }

    }



    function cocobasic_action_admin_init() {

        // only hook up these filters if the current user has permission

        // to edit posts and pages

        if (current_user_can('edit_posts') && current_user_can('edit_pages')) {

            add_filter('mce_buttons', array($this, 'cocobasic_filter_mce_button'));

            add_filter('mce_external_plugins', array($this, 'cocobasic_filter_mce_plugin'));

        }

    }



    function cocobasic_filter_mce_button($buttons) {

        // add a separation before the new button

        array_push($buttons, '|', 'cocobasic_shortcodes_button');

        return $buttons;

    }



    function cocobasic_filter_mce_plugin($plugins) {

        // this plugin file will work the magic of our button

        $plugins['shortcodes_options'] = plugin_dir_url(__FILE__) . 'editor_plugin.js';

        return $plugins;

    }



    function myplugin_load_textdomain() {

        load_plugin_textdomain('cocobasic-shortcode', false, dirname(plugin_basename(__FILE__)) . '/languages/');

    }



    function cocobasic_admin_enqueue_script() {

        wp_enqueue_style('admin-style', plugins_url('css/admin-style.css', __FILE__));

        wp_enqueue_script('cocobasic-admin-main-js', plugins_url('js/admin-main.js', __FILE__), array('jquery'), '', true);

    }



    function cocobasic_enqueue_script() {



        wp_enqueue_style('prettyPhoto', plugins_url('css/prettyPhoto.css', __FILE__));

        wp_enqueue_style('swiper', plugins_url('css/swiper.min.css', __FILE__));

        wp_enqueue_style('style', plugins_url('css/style.css', __FILE__));





        wp_enqueue_script('jquery-prettyPhoto', plugins_url('/js/jquery.prettyPhoto.js', __FILE__), array('jquery'), '', true);

        wp_enqueue_script('swiper', plugins_url('js/swiper.min.js', __FILE__), array('jquery'), '', true);

        wp_enqueue_script('cocobasic-main', plugins_url('js/main.js', __FILE__), array('jquery'), '', true);



        //Infinite Loading JS variables for portfolio

        $portfolio_count_posts = wp_count_posts('portfolio');

        $portfolio_count_posts = $portfolio_count_posts->publish;



        wp_localize_script('cocobasic-main', 'ajax_var_portfolio', array(

            'url' => admin_url('admin-ajax.php'),

            'nonce' => wp_create_nonce('ajax-cocobasic-portfolio-load-more'),

            'total' => $portfolio_count_posts

        ));

    }



}



$cocobasic_shortcodes = new cocobasic_shortcodes();



add_image_size('thumb-gallery', 9999, 500);

add_theme_support('post-thumbnails', array('portfolio'));

add_action('init', 'cocobasic_allowed_plugin_html');

add_action('add_meta_boxes', 'cocobasic_add_page_custom_meta_box');

add_action('add_meta_boxes', 'cocobasic_add_post_custom_meta_box');

add_action('save_post', 'cocobasic_save_page_custom_meta');

add_action('save_post', 'cocobasic_save_post_custom_meta');

add_filter("the_content", "cocobasic_the_content_filter");

add_action('wp_ajax_portfolio_ajax_load_more', 'cocobasic_portfolio_load_more_item');

add_action('wp_ajax_nopriv_portfolio_ajax_load_more', 'cocobasic_portfolio_load_more_item');

add_filter('body_class', 'cocobasic_browserBodyClass');

add_filter('single_template', 'cocobasic_custom_single_post');

add_filter('template_include', 'taxonomy_template');



function taxonomy_template($template) {

    if (is_tax('portfolio-category')):

        if (file_exists(get_stylesheet_directory() . '/taxonomy-portfolio-category.php')) {

            return get_stylesheet_directory() . '/taxonomy-portfolio-category.php';

        } else {

            return plugin_dir_path(__FILE__) . 'templates/taxonomy-portfolio-category.php';

        }

    endif;

    return $template;

}



// <editor-fold defaultstate="collapsed" desc="Include Custom Single Post Templates">

function cocobasic_custom_single_post($template) {

    global $post;



    $arr = array("portfolio");

    foreach ($arr as $value) {

        // Is this a "my-custom-post-type" post?

        if ($post->post_type == $value) {



            //Your plugin path 

            $plugin_path = plugin_dir_path(__FILE__);



            // The name of custom post type single template

            $template_name = 'single-' . $value . '.php';



            // A specific single template for my custom post type exists in theme folder?

            if ($template === get_stylesheet_directory() . '/' . $template_name) {



                //Then return "single.php" or "single-my-custom-post-type.php" from theme directory.

                return $template;

            }



            // If not, return my plugin custom post type template.

            return $plugin_path . 'templates/' . $template_name;

        }

    }



    //This is not my custom post type, do nothing with $template

    return $template;

}



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Include Custom Page Templates">

class cocobasicPageTemplater {



    /**

     * A reference to an instance of this class.

     */

    private static $instance;



    /**

     * The array of templates that this plugin tracks.

     */

    protected $templates;



    /**

     * Returns an instance of this class. 

     */

    public static function get_instance() {

        if (null == self::$instance) {

            self::$instance = new cocobasicPageTemplater();

        }

        return self::$instance;

    }



    /**

     * Initializes the plugin by setting filters and administration functions.

     */

    private function __construct() {

        $this->templates = array();

        // Add a filter to the attributes metabox to inject template into the cache.

        if (version_compare(get_bloginfo('version'), '4.7', '<')) {

            // 4.6 and older

            add_filter(

                    'page_attributes_dropdown_pages_args', array($this, 'register_project_templates')

            );

        } else {

            // Add a filter to the wp 4.7 version attributes metabox

            add_filter(

                    'theme_page_templates', array($this, 'add_new_template')

            );

        }

        // Add a filter to the save post to inject out template into the page cache

        add_filter(

                'wp_insert_post_data', array($this, 'register_project_templates')

        );

        // Add a filter to the template include to determine if the page has our 

        // template assigned and return it's path

        add_filter(

                'template_include', array($this, 'view_project_template')

        );

        // Add your templates to this array.

        $this->templates = array(

            'page-carousel.php' => 'Carousel',

            'page-split.php' => 'Split',

        );

    }



    /**

     * Adds our template to the page dropdown for v4.7+

     *

     */

    public function add_new_template($posts_templates) {

        $posts_templates = array_merge($posts_templates, $this->templates);

        return $posts_templates;

    }



    /**

     * Adds our template to the pages cache in order to trick WordPress

     * into thinking the template file exists where it doens't really exist.

     */

    public function register_project_templates($atts) {

        // Create the key used for the themes cache

        $cache_key = 'page_templates-' . md5(get_theme_root() . '/' . get_stylesheet());

        // Retrieve the cache list. 

        // If it doesn't exist, or it's empty prepare an array

        $templates = wp_get_theme()->get_page_templates();

        if (empty($templates)) {

            $templates = array();

        }

        // New cache, therefore remove the old one

        wp_cache_delete($cache_key, 'themes');

        // Now add our template to the list of templates by merging our templates

        // with the existing templates array from the cache.

        $templates = array_merge($templates, $this->templates);

        // Add the modified cache to allow WordPress to pick it up for listing

        // available templates

        wp_cache_add($cache_key, $templates, 'themes', 1800);

        return $atts;

    }



    /**

     * Checks if the template is assigned to the page

     */

    public function view_project_template($template) {



        // Get global post

        global $post;

        // Return template if post is empty

        if (!$post) {

            return $template;

        }



        if (is_page_template()) {

            if (get_post_meta($post->ID, '_wp_page_template', true)) {

                if (file_exists(get_stylesheet_directory() . '/' . get_post_meta($post->ID, '_wp_page_template', true))) {

                    return get_stylesheet_directory() . '/' . get_post_meta($post->ID, '_wp_page_template', true);

                } elseif (file_exists(plugin_dir_path(__FILE__) . 'templates/' . get_post_meta($post->ID, '_wp_page_template', true))) {

                    return plugin_dir_path(__FILE__) . 'templates/' . get_post_meta($post->ID, '_wp_page_template', true);

                } else {

                    return $template;

                }

            }

        }

        return $template;

    }



}



//</editor-fold>

// <editor-fold defaultstate="collapsed" desc="Load Portfolio More Items with Ajax">

function cocobasic_portfolio_load_more_item() {

    check_ajax_referer('ajax-cocobasic-portfolio-load-more', 'security');

    if (isset($_POST["action"]) && ($_POST["action"] === 'portfolio_ajax_load_more')) {

        $args = array(

            'post_type' => 'portfolio',

            'post_status' => 'publish',

            'posts_per_page' => sanitize_text_field($_POST['portfolio_posts_per_page']),

            'paged' => sanitize_text_field($_POST['portfolio_page_number'])

        );



        $portfolio_load_more_query = new WP_Query($args);

        if (file_exists(get_stylesheet_directory() . '/load-more-portfolio.php')) {

            require (get_stylesheet_directory() . '/load-more-portfolio.php');

        } else {

            require ('templates/load-more-portfolio.php');

        }

        exit;

    }

}



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Gallery Item shortcode">

function cocobasic_gallery_item($atts, $content = null) {

    extract(shortcode_atts(array(

        "img" => '',

        "title" => ''

                    ), $atts));

    $img500 = [];

    $imageID = cocobasic_get_attachment_id_from_src($img);

    if ($imageID != '') {

        $img500 = wp_get_attachment_image_src($imageID, 'thumb-gallery');

        if ($img500[3] == false) {

            $img500[0] = $img;

        }

    } else {

        $img500[0] = $img;

    }



    $return = '<li class="coco-gallery-item"><a href="' . $img . '" data-rel="prettyPhoto[gallerySlider]" title="' . $title . '"><img alt="' . $title . '" src="' . $img500[0] . '"/></a><p class="gallery-item-text">' . $title . '</p></li>';



    return $return;

}



add_shortcode("gallery_item", "cocobasic_gallery_item");



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Get Image by SRC">

function cocobasic_get_attachment_id_from_src($image_src) {

    global $wpdb;

    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";

    $id = $wpdb->get_var($query);

    return $id;

}



//</editor-fold>

//<editor-fold defaultstate="collapsed" desc="Columns short code">

function cocobasic_col($atts, $content = null) {

    extract(shortcode_atts(array(

        "size" => 'one',

        "class" => ''

                    ), $atts));



    switch ($size) {

        case "one":

            $return = '<div class = "one ' . $class . '">

    ' . do_shortcode($content) . '

    </div><div class = "clear"></div>';

            break;

        case "one_half_last":

            $return = '<div class = "one_half last ' . $class . '">' . do_shortcode($content) . '</div><div class = "clear"></div>';

            break;

        case "one_third_last":

            $return = '<div class = "one_third last ' . $class . '">' . do_shortcode($content) . '</div><div class = "clear"></div>';

            break;

        case "two_third_last":

            $return = '<div class = "two_third last ' . $class . '">' . do_shortcode($content) . '</div><div class = "clear"></div>';

            break;

        case "one_fourth_last":

            $return = '<div class = "one_fourth last ' . $class . '">' . do_shortcode($content) . '</div><div class = "clear"></div>';

            break;

        case "three_fourth_last":

            $return = '<div class = "three_fourth last ' . $class . '">' . do_shortcode($content) . '</div><div class = "clear"></div>';

            break;

        default:

            $return = '<div class = "' . $size . ' ' . $class . '">' . do_shortcode($content) . '</div>';

    }



    return $return;

}



add_shortcode("col", "cocobasic_col");



// </editor-fold>

//<editor-fold defaultstate="collapsed" desc="Menu Text short code">

function cocobasic_menu_text($atts, $content = null) {

    extract(shortcode_atts(array(

        "title" => ''

                    ), $atts));



    return '<p class="menu-text-title">' . $title . '</p><div class="menu-text">' . do_shortcode($content) . '</div>';

}



add_shortcode("menu_text", "cocobasic_menu_text");



//</editor-fold>

//<editor-fold defaultstate="collapsed" desc="Social short code">

function cocobasic_social($atts, $content = null) {

    extract(shortcode_atts(array(

        "href" => '#',

        "target" => '_self'

                    ), $atts));



    return '<a class="socail-text" href="' . $href . '" target="' . $target . '">' . do_shortcode($content) . '</a>';

}



add_shortcode("social", "cocobasic_social");



//</editor-fold>

//<editor-fold defaultstate="collapsed" desc="Medium Text shortcode">

function cocobasic_med_text($atts, $content = null) {

    return '<div class="medium-text">' . do_shortcode($content) . '</div>';

}



add_shortcode("med_text", "cocobasic_med_text");



//</editor-fold>

////<editor-fold defaultstate="collapsed" desc="Big Text shortcode">

function cocobasic_big_text($atts, $content = null) {

    extract(shortcode_atts(array(

        "up" => ''

                    ), $atts));

    $return = '';

    if ("up" !== ''):

        $return .= '<p class="title-description-up">' . $up . '</p>';

    endif;

    $return .= '<h1 class="entry-title big-text">' . do_shortcode($content) . '</h1>';

    return $return;

}



add_shortcode("big_text", "cocobasic_big_text");



//</editor-fold>

// <editor-fold defaultstate="collapsed" desc="Info short code">

function cocobasic_info($atts, $content = null) {

    extract(shortcode_atts(array(

        "class" => '',

        "title" => ''

                    ), $atts));



    $return = '<div class="info-code ' . $class . '">

               <p class="info-code-title">' . $title . '</p>               

               <p class="info-code-content">' . do_shortcode($content) . '</p>

               </div>';

    return $return;

}



add_shortcode("info", "cocobasic_info");



// </editor-fold>

//<editor-fold defaultstate="collapsed" desc="BR short code">

function cocobasic_br($atts, $content = null) {

    return '<br />';

}



add_shortcode("br", "cocobasic_br");



//</editor-fold>

// <editor-fold defaultstate="collapsed" desc="Image Slider holder short code">

function cocobasic_image_slider($atts, $content = null) {

    extract(shortcode_atts(array(

        "name" => 'slider',

        "auto" => 'true',

        "gap" => '0',

        "items" => '1',

        "speed" => '2000'

                    ), $atts));





    $return = '<script> var ' . $name . '_speed = "' . $speed . '";

                var ' . $name . '_auto = "' . $auto . '";                                

                var ' . $name . '_items = "' . $items . '";                

                var ' . $name . '_gap = "' . $gap . '";                

    </script>

    <div id = "' . $name . '" class="simple-image-slider-wrapper relative swiper-container">

    <div class = "swiper-wrapper image-slider slider">

            ' . do_shortcode($content) . '

        </div>';





    $return .= '<div class = "clear"></div></div>';



    $return .= '<div class="swiper-pagination simple-image-slider-pagination  swiper-pagination-' . $name . '"></div>';



    return $return;

}



add_shortcode("image_slider", "cocobasic_image_slider");



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Image Slide short code">

function cocobasic_image_slide($atts, $content = null) {

    extract(shortcode_atts(array(

        "img" => '',

        "href" => '',

        "alt" => '',

        "target" => '_self'

                    ), $atts));

    if ($href != '') {

        return '<div class="swiper-slide"><a href="' . $href . '" target="' . $target . '"><img src = "' . $img . '" alt = "' . $alt . '" /></a></div>';

    } else {

        return '<div class="swiper-slide"><img src = "' . $img . '" alt = "' . $alt . '" /></div>';

    }

}



add_shortcode("image_slide", "cocobasic_image_slide");



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Carousel slider short code">

function cocobasic_carousel_slider($atts, $content = null) {

    extract(shortcode_atts(array(

        "name" => 'slider',

        "portfolio" => 'false',

        "show" => '5'

                    ), $atts));

    global $post;



    if ($portfolio == 'true'):

        $slider_type = 'is-portfolio';

    else:

        $slider_type = 'is-custom';

    endif;



    $slider_content = '<div class="horizontal-slider image-slider-wrapper relative swiper-container ' . $slider_type . '">

    <div class = "swiper-wrapper image-slider slider no-horizontal-slider">';





    if ($portfolio == 'true'):

        global $wp_query;

        $temp_query = $wp_query;



        $args = array('post_type' => 'portfolio', 'post__not_in' => get_option("sticky_posts"), 'posts_per_page' => $show);

        $loop = new WP_Query($args);

        $total = $loop->found_posts;

        $total = $total < 10 ? '0' . $total : $total;

        $k = 1;



        //If there is  a text slide before portfolio images

        $slider_content .= do_shortcode($content);



        while ($loop->have_posts()) : $loop->the_post();

            $k = $k < 10 ? '0' . $k : $k;

            $slider_content .= '<div class="swiper-slide">';





            $slider_content .= '<div class="carousel-item-image">';

            $slider_content .= '<a href="' . get_permalink() . '" class="img-thumb">';



            if (has_post_thumbnail($post->ID)) {

                $slider_content .= get_the_post_thumbnail();

            } else {

                $slider_content .= '<img src = "' . get_template_directory_uri() . '/images/no-photo.png" alt = "" />';

            }

            $slider_content .= '</a>';

            $slider_content .= '<div class="carousel-item-info">';

            $slider_content .= '<div class="carousel-cat-links"><ul>';

            $slider_content .= cocobasic_get_cat($post->ID);

            $slider_content .= '</ul></div>';

            $slider_content .= '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2></div>';

            $slider_content .= '<p class="post-num"><span>' . $k . '</span><span class="total-num">' . $total . '</span></p>';

            $slider_content .= '</div>';

            $slider_content .= '</div>';

            $k++;

        endwhile;



        //Add Load More Button at the End

        $slider_content .= '<div class="swiper-slide more-posts-portfolio"><div class="portfolio-slider-load-more"><span class="more-portfolio-posts">' . esc_html__('LOAD MORE', 'cocobasic-shortcode') . '</span><span class="more-portfolio-loading">' . esc_html__('LOADING', 'cocobasic-shortcode') . '</span><span class="no-more-portfolio">' . esc_html__('NO MORE', 'cocobasic-shortcode') . '</span></div></div>';



        wp_reset_postdata();

        $wp_query = $temp_query;

    else:

        $slider_content .= do_shortcode($content);

    endif;



    $slider_content .= '</div>                         

			</div>';



    return $slider_content;

}



add_shortcode("carousel_slider", "cocobasic_carousel_slider");



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Carousel slide short code">

function cocobasic_carousel_slide($atts, $content = null) {

    extract(shortcode_atts(array(

        "img" => get_template_directory_uri() . '/images/no-photo.png"',

        "type" => '',

        "title" => '',

        "des" => '',

        "alt" => '',

        "link" => '#',

        "target" => '_self',

        "class" => ''

                    ), $atts));



    $slide_content = '';



    if ($type === 'text'):



        $slide_content .= '<div class="swiper-slide text-slide ' . $class . '">';

        $slide_content .= '<div class="carousel-item-text">';

        $slide_content .= '<p class="title-description-up">' . $des . '</p>';

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



add_shortcode("carousel_slide", "cocobasic_carousel_slide");



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Button shortcode">

function cocobasic_button($atts, $content = null) {

    extract(shortcode_atts(array(

        "class" => '',

        "target" => '_self',

        "href" => '#',

        "position" => 'left'

                    ), $atts));



    switch ($position) {

        case 'center':

            $position = "center-text";

            break;

        case 'right':

            $position = "text-right";

            break;

        default:

            $position = "text-left";

    }



    $return = '<div class="' . $position . '"><a href="' . $href . '" target="' . $target . '" class="button ' . $class . '">' . do_shortcode($content) . '</a></div>';



    return $return;

}



add_shortcode("button", "cocobasic_button");



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Register custom 'Portfolio' post type">

function create_portfolio() {

    $portfolio_args = array(

        'label' => esc_html__('Portfolio', 'cocobasic-shortcode'),

        'singular_label' => esc_html__('Portfolio', 'cocobasic-shortcode'),

        'public' => true,

        'show_ui' => true,

        'capability_type' => 'post',

        'hierarchical' => false,

        'rewrite' => true,

        'supports' => array('title', 'editor', 'comments', 'custom-fields', 'thumbnail'),

        'show_in_rest' => true

    );

    register_post_type('portfolio', $portfolio_args);

}



add_action('init', 'create_portfolio');



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Register Portfolio category">

function create_portfolio_taxonomies() {

    $labels = array(

        'name' => esc_html__('Portfolio Category', 'cocobasic-shortcode'),

        'singular_name' => esc_html__('Portfolio Category', 'cocobasic-shortcode'),

        'search_items' => esc_html__('Search Portfolio Category', 'cocobasic-shortcode'),

        'all_items' => esc_html__('All Categories', 'cocobasic-shortcode'),

        'parent_item' => esc_html__('Parent Category', 'cocobasic-shortcode'),

        'parent_item_colon' => esc_html__('Parent Category:', 'cocobasic-shortcode'),

        'edit_item' => esc_html__('Edit Portfolio Category', 'cocobasic-shortcode'),

        'update_item' => esc_html__('Update Portfolio Category', 'cocobasic-shortcode'),

        'add_new_item' => esc_html__('Add New Portfolio Category', 'cocobasic-shortcode'),

        'new_item_name' => esc_html__('New Portfolio Category', 'cocobasic-shortcode'),

        'menu_name' => esc_html__('Portfolio Category', 'cocobasic-shortcode'),

    );

    register_taxonomy('portfolio-category', array('portfolio'), array(

        'hierarchical' => true,

        'labels' => $labels,

        'show_ui' => true,

        'query_var' => true,

        'rewrite' => array('slug' => 'portfolio-category'),

		'show_in_rest' => true

    ));

}



add_action('init', 'create_portfolio_taxonomies');



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Add the Meta Box to 'Posts' regular"> 

function cocobasic_add_post_custom_meta_box() {

    add_meta_box(

            'cocobasic_post_custom_meta_box', // $id  

            esc_html__('Post Preference', 'cocobasic-shortcode'), // $title   

            'cocobasic_show_post_custom_meta_box', // $callback  

            'post', // $page  

            'normal', // $context  

            'high'); // $priority     

}



// Field Array Post Page 

$prefix = 'post_';

$post_custom_meta_fields = array(

    array(

        'label' => __('Blog Feature Image', 'cocobasic-shortcode'),

        'desc' => __('use different feature image on Blog page (default is Featured Image)', 'cocobasic-shortcode'),

        'id' => $prefix . 'blog_featured_image',

        'type' => 'text'

    ),

    array(

        'label' => __('Post Header Content', 'cocobasic-shortcode'),

        'desc' => esc_html__('set slider, vimeo or youtube iframe video in header', 'cocobasic-shortcode'),

        'id' => $prefix . 'header_content',

        'type' => 'textarea'

    )

);



// The Callback  

function cocobasic_show_post_custom_meta_box() {

    global $post_custom_meta_fields, $post;

    $allowed_plugin_tags = cocobasic_allowed_plugin_html();

// Use nonce for verification  

    echo '<input type="hidden" name="custom_meta_box_nonce" value="' . esc_attr(wp_create_nonce(basename(__FILE__))) . '" />';

// Begin the field table and loop  

    echo '<table class="form-table">';

    foreach ($post_custom_meta_fields as $field) {

// get value of this field if it exists for this post  

        $meta = get_post_meta($post->ID, $field['id'], true);

// begin a table row with  

        echo '<tr> 

                <th><label for="' . esc_attr($field['id']) . '">' . esc_attr($field['label']) . '</label></th> 

                <td>';

        switch ($field['type']) {

// case items will go here 

// select  

            case 'text':

                if ($field['id'] == 'post_blog_featured_image') {

                    echo '<label for="upload_image">

				<input id="' . esc_attr($field['id']) . '" class="image-url-input" type="text" size="36" name="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" /> 

				<input id="upload_image_button" class="button" type="button" value="' . esc_attr__('Upload Image', 'cocobasic-shortcode') . '" />

                                <br /><span class="image-upload-desc">' . esc_html($field['desc']) . '</span>                                                                    

                                <span id="small-background-image-preview" class="has-background"></span>				

				</label>';

                } else {

                    echo '<input type="text" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="50" /> 

						<br /><span class="description">' . esc_html($field['desc']) . '</span>';

                }

                break;

            // select  

            case 'select':

                echo '<select name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '">';

                foreach ($field['options'] as $option) {

                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="' . esc_attr($option['value']) . '">' . esc_html($option['label']) . '</option>';

                }

                echo '</select><br /><span class="description">' . esc_html($field['desc']) . '</span>';

                break;

            // textarea  

            case 'textarea':

                echo '<textarea name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" cols="60" rows="4">' . wp_kses($meta, $allowed_plugin_tags) . '</textarea> 

					<br /><span class="description">' . esc_html($field['desc']) . '</span>';

                break;

        } //end switch  

        echo '</td></tr>';

    } // end foreach  

    echo '</table>'; // end table  

}



// Save the Data  

function cocobasic_save_post_custom_meta($post_id) {

    global $post_custom_meta_fields;

    $allowed_plugin_tags = cocobasic_allowed_plugin_html();

// verify nonce  

    if (isset($_POST['custom_meta_box_nonce'])) {

        if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) {

            return $post_id;

        }

    }

// check autosave  

// Stop WP from clearing custom fields on autosave

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)

        return;

// Prevent quick edit from clearing custom fields

    if (defined('DOING_AJAX') && DOING_AJAX)

        return;

// check permissions  

    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {

        if (!current_user_can('edit_page', $post_id))

            return $post_id;

    } elseif (!current_user_can('edit_post', $post_id)) {

        return $post_id;

    }

// loop through fields and save the data  

    foreach ($post_custom_meta_fields as $field) {

        $old = get_post_meta($post_id, $field['id'], true);

        $new = null;

        if (isset($_POST[$field['id']])) {

            $new = $_POST[$field['id']];

        }

        if ($new && $new != $old) {

            $new = wp_kses($new, $allowed_plugin_tags);

            update_post_meta($post_id, $field['id'], $new);

        } elseif ('' == $new && $old) {

            delete_post_meta($post_id, $field['id'], $old);

        }

    } // end foreach  

}



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Add the Meta Box to 'Pages'"> 

function cocobasic_add_page_custom_meta_box() {

    add_meta_box(

            'cocobasic_page_custom_meta_box', // $id  

            esc_html__('Page Preference', 'cocobasic-shortcode'), // $title   

            'cocobasic_show_page_custom_meta_box', // $callback  

            'page', // $page  

            'normal', // $context  

            'high'); // $priority     

}



// Field Array Post Page 

$prefix = 'page_';

$page_custom_meta_fields = array(

    array(

        'label' => esc_html__('Show Page Title', 'cocobasic-shortcode'),

        'desc' => '',

        'id' => $prefix . 'show_title',

        'type' => 'select',

        'options' => array(

            'one' => array(

                'label' => esc_html__('Yes', 'cocobasic-shortcode'),

                'value' => 'yes'

            ),

            'two' => array(

                'label' => esc_html__('No', 'cocobasic-shortcode'),

                'value' => 'no'

            )

        )

    ),

    array(

        'label' => esc_html__('Split Image', 'cocobasic-shortcode'),

        'desc' => '',

        'id' => $prefix . 'split_img',

        'type' => 'text'

    )

);



// The Callback  

function cocobasic_show_page_custom_meta_box() {

    global $page_custom_meta_fields, $post;

    $allowed_plugin_tags = cocobasic_allowed_plugin_html();

// Use nonce for verification  

    echo '<input type="hidden" name="custom_meta_box_nonce" value="' . esc_attr(wp_create_nonce(basename(__FILE__))) . '" />';

// Begin the field table and loop  

    echo '<table class="form-table">';

    foreach ($page_custom_meta_fields as $field) {

// get value of this field if it exists for this post  

        $meta = get_post_meta($post->ID, $field['id'], true);

// begin a table row with  

        echo '<tr class="' . $field['id'] . '"> 

                <th><label for="' . esc_attr($field['id']) . '">' . esc_attr($field['label']) . '</label></th> 

                <td>';

        switch ($field['type']) {

// case items will go here  

// text  

            case 'text':

                if ($field['id'] == 'page_split_img') {

                    echo '<label for="upload_image">

				<input id="' . esc_attr($field['id']) . '" class="image-url-input" type="text" size="36" name="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" /> 

				<input id="upload_image_button" class="button" type="button" value="' . esc_attr__('Upload Image', 'cocobasic-shortcode') . '" />

                                <br /><span class="image-upload-desc">' . esc_html($field['desc']) . '</span>                                                                    

                                <span id="small-background-image-preview" class="has-background"></span>				

				</label>';

                } else {

                    echo '<input type="text" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="50" /> 

        <br /><span class="description">' . esc_html($field['desc']) . '</span>';

                }

                break;

// select  

            case 'select':

                echo '<select name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '">';

                foreach ($field['options'] as $option) {

                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="' . esc_attr($option['value']) . '">' . esc_html($option['label']) . '</option>';

                }

                echo '</select><br /><span class="description">' . esc_html($field['desc']) . '</span>';

                break;

        } //end switch  

        echo '</td></tr>';

    } // end foreach  

    echo '</table>'; // end table  

}



// Save the Data  

function cocobasic_save_page_custom_meta($post_id) {

    global $page_custom_meta_fields;

    $allowed_plugin_tags = cocobasic_allowed_plugin_html();

// verify nonce  

    if (isset($_POST['custom_meta_box_nonce'])) {

        if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) {

            return $post_id;

        }

    }

// check autosave  

// Stop WP from clearing custom fields on autosave

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)

        return;

// Prevent quick edit from clearing custom fields

    if (defined('DOING_AJAX') && DOING_AJAX)

        return;

// check permissions  

    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {

        if (!current_user_can('edit_page', $post_id))

            return $post_id;

    } elseif (!current_user_can('edit_post', $post_id)) {

        return $post_id;

    }

// loop through fields and save the data  

    foreach ($page_custom_meta_fields as $field) {

        $old = get_post_meta($post_id, $field['id'], true);

        $new = null;

        if (isset($_POST[$field['id']])) {

            $new = $_POST[$field['id']];

        }

        if ($new && $new != $old) {

            $new = wp_kses($new, $allowed_plugin_tags);

            update_post_meta($post_id, $field['id'], $new);

        } elseif ('' == $new && $old) {

            delete_post_meta($post_id, $field['id'], $old);

        }

    } // end foreach  

}



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Get Portfolio Item Categories"> 

function cocobasic_get_cat($postID) {

    $args = array('hide_empty=0');



    if ($postID !== 'all') {

        $terms = wp_get_post_terms($postID, 'portfolio-category', $args);

    } else {

        $terms = get_terms('portfolio-category', $args);

    }



    if (!empty($terms) && !is_wp_error($terms)) {

        $term_list = '';

        $count = count($terms);

        $i = 0;

        foreach ($terms as $term) {

            $i++;

            $term_list .= '<li class="portfolio-category">';

            $term_list .= '<a href="' . esc_url(get_term_link($term)) . '">' . $term->name . '</a>';

            $term_list .= '</li>';

        }

        return $term_list;

    }

}



// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Shortcodes p-tag fix">

function cocobasic_the_content_filter($content) {

    // array of custom shortcodes requiring the fix 

    $block = join("|", array("col", "image_slider", "button", "carousel_slider", "carousel_slide", "image_slide", "info", "social", "med_text", "big_text", "gallery_item"));

    // opening tag

    $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);



    // closing tag

    $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep);

    return $rep;

}



//</editor-fold>

// <editor-fold defaultstate="collapsed" desc="Allowed HTML Tags">

function cocobasic_allowed_plugin_html() {

    $allowed_tags = array(

        'a' => array(

            'class' => array(),

            'href' => array(),

            'rel' => array(),

            'title' => array(),

            'target' => array(),

            'data-rel' => array(),

            'data-id' => array(),

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

            'id' => array(),

            'class' => array(),

            'title' => array(),

            'style' => array(),

        ),

        'br' => array(),

        'dl' => array(),

        'dt' => array(),

        'em' => array(),

        'h1' => array(),

        'h2' => array(),

        'h3' => array(),

        'h4' => array(),

        'h5' => array(),

        'h6' => array(),

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



//</editor-fold>

// <editor-fold defaultstate="collapsed" desc="Return Name of Portfolio category">

function drop_cats_name($cat) {

    $category = '';

    $term_list = wp_get_post_terms($cat, 'portfolio-category', array("fields" => "names", 'orderby' => 'slug'));

    foreach ($term_list as $c) {

        $category .= $c . ', ';

    }

    $category .= ';';

    $category = explode(', ;', $category);

    if ($category[0] == ';') {

        $category[0] = '';

    }

    return $category[0];

}



// </editor-fold> 

// <editor-fold defaultstate="collapsed" desc="Browser Body Class">

function cocobasic_browserBodyClass($classes) {

    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

    if ($is_lynx)

        $classes[] = 'lynx';

    elseif ($is_gecko)

        $classes[] = 'gecko';

    elseif ($is_opera)

        $classes[] = 'opera';

    elseif ($is_NS4)

        $classes[] = 'ns4';

    elseif ($is_safari)

        $classes[] = 'safari';

    elseif ($is_chrome)

        $classes[] = 'chrome';

    elseif ($is_IE) {

        $classes[] = 'ie';

        if (preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))

            $classes[] = 'ie' . $browser_version[1];

    } else

        $classes[] = 'unknown';

    if ($is_iphone)

        $classes[] = 'iphone';

    if (stristr($_SERVER['HTTP_USER_AGENT'], "mac")) {

        $classes[] = 'osx';

    } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "linux")) {

        $classes[] = 'linux';

    } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "windows")) {

        $classes[] = 'windows';

    }

    return $classes;

}



// </editor-fold> 

?>