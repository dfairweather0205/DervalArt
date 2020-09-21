<?php
use Pikart\Nels\DependencyInjection\Service;

$themeOptionsUtil = Service::themeOptionsUtil();

if ( $themeOptionsUtil->postHasElement( 'author' ) ) :
	Service::util()->partial( 'single/post/elements/author' );
endif;

Service::util()->partial( 'single/post/elements/meta' );

if ( $themeOptionsUtil->postHasElement( 'related_posts' ) ) :
	Service::util()->partial( 'single/post/elements/related-posts' );
endif;

if ( $themeOptionsUtil->postHasElement( 'comments' ) ) :
	Service::templatesUtil()->loadCommentsTemplate();
endif;

if ( $themeOptionsUtil->postHasElement( 'navigation' ) ) :
	Service::util()->partial( 'single/post/elements/navigation' );
	Service::util()->partial( 'single/navigation' );
endif;
