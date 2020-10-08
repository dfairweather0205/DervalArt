<?php get_header(); ?>
<div <?php post_class('content-right'); ?> >    
    <?php
    global $post;

    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
    query_posts('post_type=post&paged=' . $page);

    if (have_posts()) :
        echo '<div class="blog-holder">';
        require get_parent_theme_file_path('loop-index.php');
        echo '<div class="block more-posts-index-holder"><div class="more-posts-index-wrapper"><a target="_self" class="more-posts">' . esc_html__('LOAD MORE', 'anotte-wp') . '</a><a class="more-posts-loading">' . esc_html__('LOADING', 'anotte-wp') . '</a><a class="no-more-posts">' . esc_html__('NO MORE', 'anotte-wp') . '</a></div></div></div>';
    endif;
    echo '<div class="clear"></div>';
    ?>   
</div>
<div class="clear"></div>
</div> 
<!-- End Page Content Holder -->
<?php get_footer(); ?>