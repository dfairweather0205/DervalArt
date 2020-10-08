<?php

global $post;

$allowed_html_array = cocobasic_allowed_plugin_html();
$slider_content;
if (isset($_POST["action"]) && ($_POST["action"] === 'portfolio_ajax_load_more')):

    $total = $_POST["total_portfolio_posts"];
    $total = $total < 10 ? '0' . $total : $total;

    $k = ($_POST["portfolio_page_number"] - 1) * $_POST["portfolio_posts_per_page"];

    if ($portfolio_load_more_query->have_posts()) :
        while ($portfolio_load_more_query->have_posts()) : $portfolio_load_more_query->the_post();
            $k++;
            $k = $k < 10 ? '0' . $k : $k;
            $slider_content .= '<div class="swiper-slide animate-slide">';
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
            $slider_content .= '<p class="post-num">' . $k . ' <span class="total-num">' . $total . '</span></p>';
            $slider_content .= '</div>';
            $slider_content .= '</div>';

        endwhile;
    endif;
    echo wp_kses($slider_content, $allowed_html_array);
endif;
?>