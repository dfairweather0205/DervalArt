<?php get_header(); ?>

<div <?php post_class('content-right'); ?> >      
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            echo '<div class="content-right-holder center-relative content-1170">';
            if (get_post_meta($post->ID, "page_show_title", true) !== 'no'):
                the_title('<h1 class="entry-title page-title">', '</h1>');
            endif;

            the_content();
            $defaults = array(
                'before' => '<p class="clear"></p><p class="wp-link-pages top-50">' . esc_html__('Pages:', 'anotte-wp'),
                'after' => '</p>',
                'link_before' => '<span class="page-link-number">',
                'link_after' => '</span>'
            );
            wp_link_pages($defaults);
            echo '</div>';

            comments_template();
        endwhile;
    endif;
    ?>    
</div>
<div class="clear"></div>
</div>
<!-- End Page Content Holder -->

<?php get_footer(); ?>