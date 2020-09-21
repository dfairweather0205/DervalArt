<?php
use Pikart\Nels\DependencyInjection\Service;

$themeOptionsUtil = Service::themeOptionsUtil();

Service::util()->partial( 'single/project/elements/meta' );

if ( $themeOptionsUtil->projectHasElement( 'related_projects' ) ) :
	Service::util()->partial( 'single/project/elements/related-projects' );
endif;

if ( $themeOptionsUtil->projectHasElement( 'comments' ) ) :
	Service::templatesUtil()->loadCommentsTemplate();
endif;

if ( $themeOptionsUtil->projectHasElement( 'navigation' ) ) :
	Service::util()->partial( 'single/project/elements/navigation' );
	Service::util()->partial( 'single/navigation' );
endif;
