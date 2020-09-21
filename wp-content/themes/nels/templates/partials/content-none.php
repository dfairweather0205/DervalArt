<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nels
 */

use Pikart\Nels\DependencyInjection\Service;

if ( Service::themeOptionsUtil()->isFeaturedBrandingEnabled() ) :
	Service::util()->partial( 'header-area' );
endif; ?>

<div id="content-area" class="content-area">
	<main class="site-main site-main--no-results site-main--not-found" role="main">

		<div id="page" class="main-page">
			<?php Service::util()->partial( 'main-archive/no-results' ); ?>
		</div>

	</main>
</div>