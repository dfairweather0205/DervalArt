<?php
/**
 * The partial for main template file.
 */

use Pikart\Nels\DependencyInjection\Service;

get_header();

if ( have_posts() ) :

	if ( Service::themeOptionsUtil()->isFeaturedBrandingEnabled() ) :
		Service::util()->partial( 'header-area' );
	endif; ?>

	<div id="content-area" class="content-area">
		<main class="site-main site-main--archive" role="main">

			<div id="page" class="main-page">
				<?php Service::util()->partial( 'main-archive/main-archive' ); ?>
			</div>

		</main>
	</div>

<?php else :
	Service::util()->partial( 'content', 'none' );
endif;

get_footer();