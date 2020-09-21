<?php

use Pikart\Nels\DependencyInjection\Service;

$output = Service::util()->getPartialContent( 'single/elements/social-area' );

if ( empty( $output ) ) :
	return;
endif;

$pageOptions = Service::postOptionsLoader()->loadPageOptions( get_the_ID() );
$siteWidth   = sprintf( 'max-width: %spx', esc_attr( $pageOptions->getSiteWidth() ) );

echo <<<HTML
<div class="entry-footer__item entry-meta" style="$siteWidth">
	<div class="entry-meta__wrapper">
		$output
	</div>
</div>
HTML;
