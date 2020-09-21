<?php
/**
 * Template Name: Blog
 */

use Pikart\Nels\DependencyInjection\Service;

get_header();

if ( have_posts() ) :

	while ( have_posts() ) :
		the_post();

		$options = Service::blogOptionsLoader()->load( get_the_ID() );

		set_query_var( 'pageOptions', $options );

		if ( $options->isFeaturedBranding() ) :
			Service::util()->partial( 'header-area' );
		endif; ?>

		<div id="content-area" class="content-area">
			<main class="site-main site-main--single site-main--page site-main--blog-template" role="main">

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php Service::util()->partial( 'blog/blog' ); ?>
				</article>

			</main>
		</div>

		<?php
	endwhile;
endif;

get_footer();
