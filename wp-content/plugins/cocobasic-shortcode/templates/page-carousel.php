<?php
/*
  Template Name: Carousel
 */
?>

<?php get_header(); ?>

<div <?php post_class('content-right');?>>      
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            the_content();
        endwhile;
    endif;
    ?>       
</div>
<div class="clear"></div>
</div> <!-- End Page Content Holder -->

<?php get_footer(); ?>