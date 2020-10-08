<?php get_header(); ?>
<div  <?php post_class('portfolio-item-wrapper'); ?>>
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            echo '<div class="portfolio-content center-relative content-1170">';
            the_content();
            echo '</div>';
            ?>
            <div class="nav-links">                                
                <?php
                $prev_post = get_previous_post();
                if (is_a($prev_post, 'WP_Post')):
                    ?>                
                    <a class="nav-previous tooltip" data-title="<?php echo esc_html($prev_post->post_title); ?>" href="<?php echo get_permalink($prev_post->ID); ?>">
                        <span class="fa fa-chevron-left" aria-hidden="true"></span> 
                    </a>                
                <?php endif; ?>
                <?php
                $next_post = get_next_post();
                if (is_a($next_post, 'WP_Post')):
                    ?>                
                    <a class="nav-next tooltip" data-title="<?php echo esc_html($next_post->post_title); ?>" href="<?php echo get_permalink($next_post->ID); ?>">
                        <span class="fa fa-chevron-right" aria-hidden="true"></span> 
                    </a>       
                <?php endif; ?>                    
            </div>  
            <?php
            comments_template();
        endwhile;
    endif;
    ?>
</div>
<?php get_footer(); ?>