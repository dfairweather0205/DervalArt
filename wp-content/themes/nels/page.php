<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nels
 */

use Pikart\Nels\DependencyInjection\Service;

if ( post_password_required() ) :
	Service::util()->partial( 'password-protected' );

	return;
endif;

get_header();

$pageOptions = Service::postOptionsLoader()->loadPageOptions( get_the_ID() );

if ( $pageOptions->isFeaturedBranding() ) :
	Service::util()->partial( 'header-area' );
endif; ?>

<div id="content-area" class="content-area">
	<main class="site-main site-main--single site-main--page site-main--default-page" role="main">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php while ( have_posts() ) :
				the_post();
				Service::util()->partial( 'single/page/page' );
			endwhile; ?>
		</article>

	</main>
</div>

<?php
get_footer();
