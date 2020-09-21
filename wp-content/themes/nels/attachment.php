<?php
/**
 * The template for displaying all attachments.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#attachment
 *
 * @package Nels
 */

use Pikart\Nels\DependencyInjection\Service;

get_header();

if ( Service::themeOptionsUtil()->isFeaturedBrandingEnabled() ):
	Service::util()->partial( 'header-area' );
endif; ?>

<div id="content-area" class="content-area">
	<main class="site-main site-main--attachment" role="main">

		<article id="post-<?php the_ID(); ?>"
			<?php post_class( 'details-position details-position--bottom' ); ?> >

			<?php while ( have_posts() ) :
				the_post();
				Service::util()->partial( 'single/attachment/attachment' );
			endwhile; ?>

		</article>

	</main>
</div>

<?php
get_footer();
