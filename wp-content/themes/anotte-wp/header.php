<!DOCTYPE html>

<html <?php language_attributes(); ?>>

    <head>        

        <meta charset="<?php bloginfo('charset'); ?>" />        

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />  		

        <?php wp_head(); ?>

    </head>

    <body <?php body_class('wait-preloader'); ?>>

        <div class="site-wrapper">                  

            <div class="doc-loader">

                <!-- <?php //if (get_option('cocobasic_preloader') !== '' && get_option('cocobasic_preloader') !== false): ?>                 -->

                    <!-- <img src="<?php //echo esc_url(str_replace('http:','https:',get_option('cocobasic_preloader', get_template_directory_uri() . '/images/preloader.gif'))); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" /> -->

                <!-- <?php // endif; ?> -->

                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/paint-brush.gif'); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
            </div>  



            <!-- Left Part Sidebar -->

            <div class="menu-left-part">               



                <?php

                if (get_theme_mod('cocobasic_show_search') === 'yes') {

                    $menu_search = '<ul id="%1$s" class="%2$s">%3$s</ul>' . get_search_form(false);

                } else {

                    $menu_search = '<ul id="%1$s" class="%2$s">%3$s</ul>';

                }



                if (has_nav_menu("custom_menu")) {

                    wp_nav_menu(

                            array(

                                "container" => "nav",

                                "container_class" => "big-menu",

                                "container_id" => "header-main-menu",

                                "fallback_cb" => false,

                                "menu_class" => "main-menu sm sm-clean",

                                "theme_location" => "custom_menu",

                                "items_wrap" => $menu_search,

                                "walker" => new cocobasic_header_menu(),
                                "depth" => 2
                            )

                    );

                } else {

                    echo '<nav id="header-main-menu" class="big-menu default-menu"><ul>';

                    wp_list_pages(array("depth" => "3", 'title_li' => ''));

                    echo '</ul>';

                    if (get_theme_mod('cocobasic_show_search') === 'yes') {

                        get_search_form();

                    }

                    echo '</nav>';

                }

                ?>       



                <?php

                $allowed_html_array = cocobasic_allowed_html();

                if (get_theme_mod('cocobasic_menu_text') != ''):

                    echo '<div class="menu-right-text">';

                    echo do_shortcode(wp_kses(__(get_theme_mod('cocobasic_menu_text') ? get_theme_mod('cocobasic_menu_text') : 'Default Menu Text', 'anotte-wp'), $allowed_html_array));

                    echo '</div>';

                endif;

                ?>



                <?php get_sidebar(); ?>



            </div>



            <!-- Right Part Sidebar -->

            <div class="menu-right-part">    
                
                <div class="wr-menu">

                <div class="header-logo">

                    <?php if (get_option('cocobasic_header_logo') !== ''): ?>                                                   

                        <a href="<?php echo esc_url(site_url('/')); ?>">

                            <img src="<?php echo esc_url(str_replace('http:','https:',get_option('cocobasic_header_logo', get_template_directory_uri() . '/images/logo.png'))); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />

                        </a>               

                    <?php endif; ?>                                           

                </div>


                <?php 
                    $cart_count = WC()->cart->get_cart_contents_count();
                ?>
                <div class="toggle-holder">
                    <div id="cart-btn" class="menu-btn">
                        <a href="<?php echo home_url('/cart'); ?>" title="My Cart"><img class="menu-icon" src="<?php echo get_template_directory_uri() .'/images/cart.svg'; ?>" alt="My Cart Icon"><span class="cart-count"><?php echo $cart_count; ?></span></a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo home_url('/cart'); ?>">MY CART</a></li>
                            <li><a href="<?php echo home_url('/checkout'); ?>">CHECKOUT</a></li>
                        </ul>
                    </div>
                    <div id="account-btn" class="menu-btn">
                        <a href="<?php echo home_url('/my-account'); ?>" title="My Account"><img class="menu-icon" src="<?php echo get_template_directory_uri() .'/images/user.svg'; ?>" alt="My Account Icon"></a>
                        <ul class="sub-menu">
                            <?php if(is_user_logged_in()): ?>
                                <li><a href="<?php echo home_url('/my-account'); ?>">MY ACCOUNT</a></li>
                                <li><a href="<?php echo home_url('/my-account/orders'); ?>">MY ORDERS</a></li>
                                <li><a href="<?php echo wp_logout_url(); ?>">LOGOUT</a></li>
                            <?php else: ?>
                                <li><a href="<?php echo home_url('/my-account/?register'); ?>">REGISTER</a></li>
                                <li><a href="<?php echo home_url('/my-account'); ?>">LOGIN</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <!-- <?php if(is_user_logged_in()) : ?>   
                        <div id="logout-btn" class="menu-btn">
                            <a href="<?php echo wp_logout_url(home_url()); ?>" title="Logout"><img class="menu-icon" src="<?php echo get_template_directory_uri() .'/images/exit.svg'; ?>" alt="Logout Icon"></a>
                        </div>
                    <?php endif; ?> -->
                    <div id="toggle">

                        <div class="menu-line"></div>

                    </div>     

                </div>   
                </div>



            </div> 



            <!-- Page Content Holder -->

            <div id="content" class="site-content">

