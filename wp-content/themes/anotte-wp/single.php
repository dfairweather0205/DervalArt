<?php
get_header();
$allowed_html_array = cocobasic_allowed_html();
?>

<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        ?>		

        <article <?php post_class(); ?>>
            <?php if (has_post_thumbnail() || (get_post_meta($post->ID, "post_header_content", true) != '')): ?>
                <div class="single-post-header-content content-1170 center-relative">    
                    <?php
                    if (get_post_meta($post->ID, "post_header_content", true) != '') :
                        echo do_shortcode(wp_kses(get_post_meta($post->ID, "post_header_content", true), $allowed_html_array));
                    else:
                        the_post_thumbnail();
                    endif;
                    ?>     
                </div>                                            
            <?php endif; ?>
            <div class="post-wrapper center-relative">                                                        
                <div class="single-content-wrapper content-960 center-relative">     
                    <h1 class="entry-title"><?php the_title(); ?></h1>                        
                    <div class="post-info-wrapper">     
                        <div class="sticky-spacer">
                            <div class="entry-info">
                                <div>
                                    <div class="text-holder"><?php echo esc_html__('AUTHOR', 'anotte-wp') ?></div>
                                    <div class="author-nickname">
                                        <?php the_author_posts_link(); ?>
                                    </div> 
                                </div> 
                                <div> 
                                    <div class="text-holder"><?php echo esc_html__('DATE', 'anotte-wp') ?></div>
                                    <div class="entry-date published"><?php echo get_the_date(); ?></div>
                                </div>
                                <div>
                                    <div class="text-holder"><?php echo esc_html__('CATEGORY', 'anotte-wp') ?></div>
                                    <div class="cat-links">
                                        <ul>
                                            <?php
                                            foreach ((get_the_category()) as $category) {
                                                echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
                                            }
                                            ?>
                                        </ul>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="entry-content"> 

                        <?php
                        the_content();

                        $defaults = array(
                            'before' => '<p class="wp-link-pages top-50">' . esc_html__('Pages:', 'anotte-wp'),
                            'after' => '</p>',
                            'link_before' => '<span class="page-link-number">',
                            'link_after' => '</span>'
                        );
                        wp_link_pages($defaults);

                        if (has_tag()):
                            ?>	
                            <div class="tags-holder">
                                <?php the_tags('', ''); ?>
                            </div>                              
                            <?php
                        endif;
                        ?>                          
                    </div>
                    <div class="clear"></div>
                </div>                                       
            </div>                
        </article> 
        <div class="nav-links">                                
            <?php
            $prev_post = get_previous_post();
            if (is_a($prev_post, 'WP_Post')):
                ?>                
                <a class="nav-previous tooltip" data-title="<?php echo esc_attr($prev_post->post_title); ?>" href="<?php echo get_permalink($prev_post->ID); ?>">
                    <span class="fa fa-chevron-left" aria-hidden="true"></span> 
                </a>                
            <?php endif; ?>
            <?php
            $next_post = get_next_post();
            if (is_a($next_post, 'WP_Post')):
                ?>                
                <a class="nav-next tooltip" data-title="<?php echo esc_attr($next_post->post_title); ?>" href="<?php echo get_permalink($next_post->ID); ?>">
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