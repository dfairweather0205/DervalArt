<?php

use Pikart\Nels\DependencyInjection\Service;

$output = Service::util()->getPikartBasePartialContent( 'single/addthis-social-share' )
          . Service::util()->getPikartBasePartialContent( 'single/likes-area' );

if ( empty( $output ) ) :
	return;
endif;

echo <<<HTML
<div class="entry-social-area">
	<div class="social-area">$output</div>
</div>
HTML;
