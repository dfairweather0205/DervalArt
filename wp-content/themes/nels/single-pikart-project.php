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

$options = Service::postOptionsLoader()->loadProjectOptions( get_the_ID() );
set_query_var( 'projectOptions', $options );

$detailsPositionClass = 'details-position details-position--' . esc_attr( $options->getProjectDetailsPosition() );

if ( $options->isFeaturedBranding() ) :
	Service::util()->partial( 'header-area' );
endif; ?>

<div id="content-area" class="content-area">
	<main class="site-main site-main--single site-main--project" role="main">

		<article id="post-<?php the_ID(); ?>" <?php post_class( $detailsPositionClass ); ?>>
			<?php while ( have_posts() ) :
				the_post();
				Service::util()->partial( 'single/project/project' );
			endwhile; ?>
		</article>

	</main>
</div>

<?php
get_footer();
