
   <?php

/*
Template Name: E Shop Html 

*/
?>
<?php get_header();?>

<div class="wr-content" id="temp-page-shop">
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
$numberpost = isset($_GET['numberpost']) ? $_GET['numberpost'] : 4;
$args = array(
    'posts_per_page' => $numberpost,
    'post_type' => 'product',
    'order'=>'DESC',
    'orderby' => 'title',
    'paged' => $paged    ,   
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => 'tshirt'
        )
    ),
);
$products = new WP_Query( $args );
$max_page = $products->max_num_pages;
?>

    <div class="tab-item active" id="tab-grid" style="position: relative;">
        <div class="arrow-wrapper">
            <span class="arrow-left">
                <img src="https://www.dervalart.com/wp-content/themes/anotte-wp/images/left-arrow.svg" alt="">
            </span>
            <span class="arrow-right">
                <img src="https://www.dervalart.com/wp-content/themes/anotte-wp/images/right-arrow.svg" alt="">
            </span>
        </div>
        <div class="content">
            <div class="wrap-title-page">
                <div class="carousel-item-text">
                    <div class="wr-title">
                        <p class="title-description-up">VISUALS</p>
                        <ul class="nav-tab">                        
                            <li class="tab-click tab-grid active" data-tab="tab-grid">
                                <img class="menu-icon" src="<?php echo get_template_directory_uri() . '/images/menu.png';?>" alt="">
                                <img class="menu-white-icon" src="<?php echo get_template_directory_uri() . '/images/menu-white.png';?>" alt="">
                            </li>
                            <li class="tab-click tab-listing " data-tab="tab-listing">
                                <img class="list-icon" src="<?php echo get_template_directory_uri() . '/images/list.png';?>" alt="">
                                <img class="list-white-icon" src="<?php echo get_template_directory_uri() . '/images/list-white.png';?>" alt="">
                            </li>
                        </ul>
                    </div>
                   <?php echo do_shortcode('[breadcrum name="page"]'); ?>
                    <h1 class="entry-title big-text">Online Shop</h1><div class="carousel-content"> "Our admiration for the creator's handiwork should not be limited to those things he has provided us with for our daily needs, but should include all that is good and beautiful."  - by Haile Selassie</div>
                </div>
                <div class="wrapper-pagination">
                    <div class="show-product">
                        <label for="">Show:</label>
                        <select name="" id="">
                            <option value="4" <?php selected($numberpost,4)?>>4</option>
                            <option value="8"  <?php selected($numberpost,8)?>>8</option>
                            <option value="16" <?php selected($numberpost,16)?>>16</option>
                        </select>
                    </div>
                    <div class="pagination-area text-center pt-50 pb-50 pb-lg-none">
                        <?php 
                            echo paginate_links( array(
                                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                                'total'        => $products->max_num_pages,
                                'current'      => max( 1, get_query_var( 'paged' ) ),
                                'format'       => '?paged=%#%',
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
                    </div>
                </div> 
            </div>
            <div class="wr-slider">
                <div class="product-slider-grid">
                    <div class="swiper-wrapper image-slider slider">    
                            <?php while ( $products->have_posts() ) {
                                $products->the_post();
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
                            }
                        ?>                                 
                    </div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-item has-product-slider all-loaded" id="tab-listing">
        <div class="arrow-wrapper">
            <span class="arrow-left"><img src="https://www.dervalart.com/wp-content/themes/anotte-wp/images/left-arrow.svg" alt=""></span>
            <span class="arrow-right"><img src="https://www.dervalart.com/wp-content/themes/anotte-wp/images/right-arrow.svg" alt=""></span>
        </div>
        <div class="product-slider2 product-slider image-slider-wrapper relative swiper-container" style="transform: translate3d(0px, 0px, 0px);">
            <div class="swiper-wrapper image-slider slider">
                <div class="swiper-slide text-slide animate-done"><div class="carousel-item-text">
                    <div class="wr-title">
                        <p class="title-description-up">VISUALS</p>
                        <ul class="nav-tab">                        
                            <li class="tab-click tab-grid active" data-tab="tab-grid">
                                <img class="menu-icon" src="<?php echo get_template_directory_uri() . '/images/menu.png';?>" alt="">
                                <img class="menu-white-icon" src="<?php echo get_template_directory_uri() . '/images/menu-white.png';?>" alt="">
                            </li>
                            <li class="tab-click tab-listing " data-tab="tab-listing">
                                <img class="list-icon" src="<?php echo get_template_directory_uri() . '/images/list.png';?>" alt="">
                                <img class="list-white-icon" src="<?php echo get_template_directory_uri() . '/images/list-white.png';?>" alt="">
                            </li>
                        </ul>
                    </div>
                    <?php echo do_shortcode('[breadcrum name="page"]'); ?>
                    <h1 class="entry-title big-text">Online Shop</h1>
                    <div class="carousel-content"> "Our admiration for the creator's handiwork should not be limited to those things he has provided us with for our daily needs, but should include all that is good and beautiful."  - by Haile Selassie</div></div>
                </div>            
                <?php
                global $i;
                $i = 0;
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
                
                $products = new WP_Query( $args );
                $count = $products->found_posts;     
                $total_product = $count < 10 ? '0'.$count : $count;      
                $max_num_pages = $products  -> max_num_pages;          
                    while ( $products->have_posts() ) {
                        $products->the_post();
                        ?>                         
                            <?php 
                            $i++;      
                            $i = $i < 10 ? '0'.$i : $i;?>
                            <div class="swiper-slide">                           
                                <div class="carousel-item-image products">
                                    <a href="" class="image-zoom"><img src="<?php echo get_template_directory_uri() .'/images/plus.svg'; ?>" alt=""></a>
                                    <a href="<?php the_permalink(); ?>" class="img-thumb">
                                        <?php echo get_the_post_thumbnail($post->ID); ?>
                                    </a>
                                    <div class="carousel-item-info product_by_term">
                                        <div class="carousel-cat-links">
                                            <ul>
                                                <li class="portfolio-enquiry">
                                                    <a class="enquiry-btn redirect" href="<?php echo home_url("/?add-to-cart=$post->ID"); ?>">Add To Cart</a>
                                                </li>
                                                <li class="portfolio-category">
                                                <a href="<?php the_permalink(); ?>" title="Click here to visit the product page."><?php echo the_title(); ?></a>
                                                </li>
                                                <li class="portfolio-description">
                                                    <p><?php //echo $description; ?></p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="post-num"><span><?php echo $i; ?></span><span class="total-num"><?php echo $total_product; ?></span></p>
                                </div>
                            </div>
                        <?php
                    }
                ?>          
            <div class="swiper-slide more-product-categoies swiper-slide-next" data-type="product" data-term="49">
                <div class="product-slider-load-more">
                    <span class="more-product-categoies-posts">LOAD MORE</span>
                    <span class="more-product-categoies-loading">LOADING</span>
                    <span class="no-more-product-categoies">NO MORE</span>
                </div>
            </div>
        </div>
        </div>
        <div class="enquiry-wrap">
            <div>
                <img id="close-enquiry" src="<?php echo get_template_directory_uri() .'/images/close.svg'; ?>" alt="">
                <p class="form-name">Product Enquiry</p>
                <?php
                echo do_shortcode('[contact-form-7 id="607" title="Enquiry form"]');
                ?>
            </div>
        </div>
        <div id="img-zoom" class="img-zoom">
            <a id="zoom-close" href="" class=""><img src="<?php echo get_template_directory_uri() .'/images/close-white.svg'; ?>" alt=""></a>
            <span class="zoom">
                <img id="img" class="is-magic wp-post-image"  src="" alt="Product image">
            </span>
            <div class="zoom-el"><img src="" alt=""></div>
        </div> 
    </div>
    </div>
</div>

<?php get_footer(); ?>
