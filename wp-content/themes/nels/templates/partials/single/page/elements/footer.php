<?php

use Pikart\Nels\DependencyInjection\Service;

$themeOptionsUtil = Service::themeOptionsUtil();

Service::util()->partial( 'single/page/elements/meta' );

if ( $themeOptionsUtil->pageHasElement( 'comments' ) ) :
	Service::templatesUtil()->loadCommentsTemplate();
endif;

if ( $themeOptionsUtil->pageHasElement( 'navigation' ) ) :
	Service::util()->partial( 'single/page/elements/navigation' );
	Service::util()->partial( 'single/navigation' );
endif;
