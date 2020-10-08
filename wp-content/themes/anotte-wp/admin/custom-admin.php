<?php
/*
 * Register Theme Customizer
 */
add_action('customize_register', 'cocobasictheme_customize_register');

function cocobasictheme_customize_register($wp_customize) {    

    function cocobasic_clean_html($value) {
        $allowed_html_array = cocobasic_allowed_html();
        $value = wp_kses($value, $allowed_html_array);
        return $value;
    }

    class CocoBasic_Customize_Textarea_Control extends WP_Customize_Control {

        public $type = 'textarea';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label>
            <?php
        }

    }

    //------------------------- WELCOME TEXT SECTION ---------------------------------------------

    $wp_customize->add_section('cocobasic_welocme_text', array(
        'title' => esc_html__('Menu Text & Search', 'anotte-wp'),
        'priority' => 30
    ));


    $wp_customize->add_setting('cocobasic_menu_text', array(
        'default' => '',
        'sanitize_callback' => 'cocobasic_clean_html'
    ));

    $wp_customize->add_control(new CocoBasic_Customize_Textarea_Control($wp_customize, 'cocobasic_menu_text', array(
        'label' => esc_html__('Welcome Text', 'anotte-wp'),
        'section' => 'cocobasic_welocme_text',
        'settings' => 'cocobasic_menu_text'
    )));


    $wp_customize->add_setting('cocobasic_show_search', array(
        'default' => 'no',
        'sanitize_callback' => 'cocobasic_clean_html'
    ));

    $wp_customize->add_control('cocobasic_show_search', array(
        'label' => esc_html__('Show Search in Menu', 'anotte-wp'),
        'section' => 'cocobasic_welocme_text',
        'settings' => 'cocobasic_show_search',
        'type' => 'radio',
        'choices' => array(
            'yes' => esc_html__('Yes', 'anotte-wp'),
            'no' => esc_html__('No', 'anotte-wp'),
    )));

    //------------------------- END MENU TEXT SECTION ---------------------------------------------
    //
    //
    //
    //
    //
    //----------------------------- IMAGE SECTION  ---------------------------------------------

    $wp_customize->add_section('cocobasic_image_section', array(
        'title' => esc_html__('Images Section', 'anotte-wp'),
        'priority' => 33
    ));


    $wp_customize->add_setting('cocobasic_preloader', array(
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'cocobasic_preloader', array(
        'label' => esc_html__('Preloader Gif', 'anotte-wp'),
        'section' => 'cocobasic_image_section',
        'settings' => 'cocobasic_preloader'
    )));

    $wp_customize->add_setting('cocobasic_header_logo', array(
        'default' => get_template_directory_uri() . '/images/logo.png',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'cocobasic_header_logo', array(
        'label' => esc_html__('Header Logo', 'anotte-wp'),
        'section' => 'cocobasic_image_section',
        'settings' => 'cocobasic_header_logo'
    )));

    $wp_customize->add_setting('cocobasic_logo_width', array(
        'default' => "100px",
        'sanitize_callback' => 'cocobasic_clean_html'
    ));

    $wp_customize->add_control('cocobasic_logo_width', array(
        'label' => esc_html__('Logo Width:', 'anotte-wp'),
        'section' => 'cocobasic_image_section',
        'settings' => 'cocobasic_logo_width',
        'priority' => 999
    ));

    $wp_customize->add_setting('cocobasic_logo_height', array(
        'default' => "70px",
        'sanitize_callback' => 'cocobasic_clean_html'
    ));

    $wp_customize->add_control('cocobasic_logo_height', array(
        'label' => esc_html__('Logo Height:', 'anotte-wp'),
        'section' => 'cocobasic_image_section',
        'settings' => 'cocobasic_logo_height',
        'priority' => 999
    ));


    //----------------------------- END IMAGE SECTION  ---------------------------------------------
    //
    //
    //
    //----------------------------------COLORS SECTION--------------------

    $wp_customize->add_setting('preloader_background_color', array(
        'default' => '#ffffff',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'preloader_background_color', array(
        'label' => esc_html__('Preloader Background Color', 'anotte-wp'),
        'section' => 'colors',
        'settings' => 'preloader_background_color'
    )));

    $wp_customize->add_setting('menu_background_color', array(
        'default' => '#000000',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'menu_background_color', array(
        'label' => esc_html__('Menu Background Color', 'anotte-wp'),
        'section' => 'colors',
        'settings' => 'menu_background_color'
    )));

    $wp_customize->add_setting('single_pagination_hover_background', array(
        'default' => '#c0ec2e',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'single_pagination_hover_background', array(
        'label' => esc_html__('Single Pagination Hover Background Color', 'anotte-wp'),
        'section' => 'colors',
        'settings' => 'single_pagination_hover_background'
    )));

    $wp_customize->add_setting('global_select_color', array(
        'default' => '#b6df1e',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'global_select_color', array(
        'label' => esc_html__('Select Color', 'anotte-wp'),
        'section' => 'colors',
        'settings' => 'global_select_color'
    )));


    //----------------------------------------------------------------------------------------------
    //
    //
    //
    //--------------------------------------------------------------------------
    $wp_customize->get_setting('preloader_background_color')->transport = 'postMessage';
    $wp_customize->get_setting('menu_background_color')->transport = 'postMessage';
    $wp_customize->get_setting('single_pagination_hover_background')->transport = 'postMessage';
    $wp_customize->get_setting('global_select_color')->transport = 'postMessage';
    //--------------------------------------------------------------------------
    /*
     * If preview mode is active, hook JavaScript to preview changes
     */
    if ($wp_customize->is_preview() && !is_admin()) {
        add_action('customize_preview_init', 'cocobasictheme_customize_preview_js');
    }
}

/**
 * Bind Theme Customizer JavaScript
 */
function cocobasictheme_customize_preview_js() {
    wp_enqueue_script('cocobasictheme-customizer', get_template_directory_uri() . '/admin/js/custom-admin.js', array('customize-preview'), '20120910', true);
}

/*
 * Generate CSS Styles
 */

class CocoBasicLiveCSS {

    public static function cocobasic_theme_customized_style() {
        echo '<style type="text/css">' .
        cocobasic_generate_css('.site-wrapper .doc-loader', 'background-color', 'preloader_background_color') .
        cocobasic_generate_css('.site-wrapper .menu-left-part', 'background-color', 'menu_background_color') .
        cocobasic_generate_css('.single .site-wrapper .nav-links > a:hover', 'background-color', 'single_pagination_hover_background') .
        cocobasic_generate_css('.site-wrapper .page-numbers:hover, .site-wrapper .tags-holder a:hover, .site-wrapper .wp-link-pages > a:hover, body .site-wrapper #sidebar a:hover, .site-wrapper h4.widgettitle, .site-wrapper .replay-at-author, .site-wrapper .error-text-404, .site-wrapper .menu-right-text .menu-text a, .site-wrapper p.menu-text-title', 'color', 'global_select_color') .
        cocobasic_generate_css('.site-wrapper .page-numbers.current, .site-wrapper .sm-clean > li > a:after, .single-post .site-wrapper .post-info-wrapper .entry-info:after, .site-wrapper .tags-holder a, .single .site-wrapper .nav-links > a, .site-wrapper .wp-link-pages > span, .site-wrapper .gallery-item-text, .site-wrapper .horizontal-slider .carousel-cat-links ul li a', 'background-color', 'global_select_color') .
        cocobasic_generate_css('.site-wrapper .page-numbers.current, .site-wrapper #header-main-menu .search-field:focus, .site-wrapper .tags-holder a, .site-wrapper .search-field:focus', 'border-color', 'global_select_color') .
        cocobasic_generate_logo_css() .
        '</style>';
    }

}

/*
 * Generate CSS Class - Helper Method
 */

function cocobasic_generate_css($selector, $style, $mod_name, $prefix = '', $postfix = '', $rgba = '') {
    $return = '';
    $mod = get_option($mod_name);
    if (!empty($mod)) {
        if ($rgba === true) {
            $mod = '0px 0px 50px 0px ' . cardea_hex2rgba($mod, 0.65);
        }
        $return = sprintf('%s { %s:%s; }', $selector, $style, $prefix . $mod . $postfix
        );
    }
    return $return;
}

function cocobasic_generate_logo_css() {
    if (get_theme_mod('cocobasic_logo_width') != '' && get_theme_mod('cocobasic_logo_height') != ''):
        $allowed_html_array = cocobasic_allowed_html();
        $return = '.site-wrapper .header-logo img{width: ' . get_theme_mod('cocobasic_logo_width') . '; height: ' . get_theme_mod('cocobasic_logo_height') . ';}';
        $return = wp_kses($return, $allowed_html_array);
        return $return;
    endif;
}
?>