<?php
/**
 * The template for displaying all single posts.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Nels
 */

use Pikart\Nels\DependencyInjection\Service;

if ( post_password_required() ) :
	Service::util()->partial( 'password-protected' );

	return;
endif;

get_header();

$postOptions = Service::postOptionsLoader()->loadCommonPostOptions( get_the_ID() );
?>

<?php if ( $postOptions->isFeaturedBranding() ) :
	Service::util()->partial( 'header-area' );
endif; ?>

<div id="content-area" class="content-area">
	<main class="site-main site-main--single site-main--post" role="main">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php while ( have_posts() ) :
				the_post();
				Service::util()->partial( 'single/post/post', get_post_format() );
			endwhile; ?>
		</article>

	</main>
</div>

<?php
get_footer();
