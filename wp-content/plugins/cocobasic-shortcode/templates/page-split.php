<?php
/*
  Template Name: Split
 */
?>

<?php
get_header();
$splitImage = get_post_meta($post->ID, "page_split_img", true);
?>

<div <?php post_class('content-right'); ?>>      
    <div class="page-split-left">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                the_content();
            endwhile;
        endif;
        ?>       
    </div>
    <div class="page-split-right" style="background-image: url(<?php echo esc_url($splitImage); ?>);">
        <img class="split-image" src="<?php echo esc_url($splitImage); ?>" alt="" />
    </div>
</div>
<div class="clear"></div>
</div> <!-- End Page Content Holder -->

<?php get_footer(); ?>