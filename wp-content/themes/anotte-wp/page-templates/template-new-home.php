
<?php

/*
Template Name: New Homepage

*/
?>
<?php get_header();?>

<div class="main-content" id="temp-new-page" style="position: relative;">
        <div class="content">
            <div class="wrap-title-page">
                <div class="carousel-item-text">
                    <div class="wr-title">
                        <p class="title-description-up">VISUALS</p>                       
                    </div>
                   <?php echo do_shortcode('[breadcrum name="page"]'); ?>
                    <h1 class="entry-title big-text">Arts from the heart</h1><div class="carousel-content"> "A purely materialistic art would be like a tree which is expected to bear fruit without flowering, and to sacrifice grace and beauty for mere utility. Those who learn here should from the beginning, assidulously avoid this spirit of utilitarianism."  - by <b>Haile Selassie</b></div>
                </div>                
            </div>
            <div class="wr-slider">
                <div class="gallery-slider">
                    <div class="swiper-wrapper image-slider slider">    
                    <?php 
                        $images = get_field('gallery_new_page'); ?>                                    
                        <?php foreach( $images as $image ): ?>
                            <div class="swiper-slide">
                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                            </div>
                        <?php endforeach; ?>                  
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>                
            </div>
        </div>
    </div>


<?php get_footer(); ?>