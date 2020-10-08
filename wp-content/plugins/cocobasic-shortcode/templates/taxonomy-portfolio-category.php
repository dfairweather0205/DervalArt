<?php
get_header();
$queried_object = get_queried_object();
$allowed_html_array = cocobasic_allowed_html();
$big = 99999;
?>	

<?php get_header(); ?>

<div <?php post_class('content-right'); ?>>      
    <?php
    $slider_content = '<div class="horizontal-slider image-slider-wrapper relative swiper-container">
    <div class = "swiper-wrapper image-slider slider no-horizontal-slider">
    <div class="swiper-slide">
        <div class="carousel-item-text">        
        <h1 class="entry-title big-text">' . esc_html($queried_object->name) . '</h1>
        <div class="carousel-content">' . term_description($queried_object->term_id, 'portfolio-category') . '</div>
        </div>
     </div>';
    $total = $queried_object->count;
    $total = $total < 10 ? '0' . $total : $total;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $k = ($paged - 1) * get_option('posts_per_page');

    if (have_posts()) :
        while (have_posts()) : the_post();
            $k++;
            $k = $k < 10 ? '0' . $k : $k;
            $slider_content .= '<div class="swiper-slide">';


            $slider_content .= '<div class="carousel-item-image">';
            $slider_content .= '<a href="' . get_permalink() . '" class="img-thumb">';

            if (has_post_thumbnail($post->ID)) {
                $slider_content .= get_the_post_thumbnail();
            } else {
                $slider_content .= '<img src = "' . get_template_directory_uri() . '/images/no-photo.png" alt = "" />';
            }
            $slider_content.='</a>';
            $slider_content .= '<div class="carousel-item-info">';
            $slider_content .= '<div class="carousel-cat-links"><ul>';
            $slider_content .= cocobasic_get_cat($post->ID);
            $slider_content .= '</ul></div>';
            $slider_content .= '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2></div>';
            $slider_content .= '<p class="post-num"><span>' . $k . '</span><span class="total-num">' . $total . '</span></p>';
            $slider_content .= '</div>';
            $slider_content .= '</div>';
        endwhile;
    endif;
   
    $slider_content .= '<div class="swiper-slide portfolio-category-pagination-holder center-text"><div class="portfolio-category-pagination">';
    $slider_content .= paginate_links(array(
        'base' => str_replace($big, '%#%', html_entity_decode(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_next' => false
    ));
    $slider_content .= '</div></div>';
    
    //End Slider
    $slider_content .= '</div></div>';

    echo wp_kses($slider_content, $allowed_html_array);
    ?>       
       
</div>
<div class="clear"></div>
</div> <!-- End Page Content Holder -->

<?php get_footer(); ?>