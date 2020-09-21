<?php

// WP_DEBUG && error_reporting( - 1 );

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Common\CorePathsUtil;

$wpTheme = wp_get_theme();

// PIKART_THEME_VERSION constant is used as a version for the static files while enqueueing,
// when debugging is enabled we don't want the browser to cache the static files, that's why in this case we append
// a new suffix every time
defined( 'PIKART_THEME_VERSION' )
|| define( 'PIKART_THEME_VERSION', '1.2.5' . ( WP_DEBUG ? '.' . uniqid() : '' ) );

defined( 'PIKART_THEME_SLUG' ) || define( 'PIKART_THEME_SLUG', $wpTheme->get( 'TextDomain' ) );

defined( 'PIKART_BASE_ENABLED' ) || define( 'PIKART_BASE_ENABLED', defined( 'PIKART_BASE_SLUG' ) );
defined( 'PIKART_BASE_SLUG' ) || define( 'PIKART_BASE_SLUG', 'pikart-base' );
defined( 'PIKART_THEME_ACTIVE' ) || define( 'PIKART_THEME_ACTIVE', true );
defined( 'PIKART_NELS_URL' ) || define( 'PIKART_NELS_URL', 'https://nels.pikarthouse.com/' );

require_once get_template_directory() . '/includes/vendor/autoload.php';

CorePathsUtil::registerBaseDirAndUrl( get_template_directory(), get_template_directory_uri() );

Service::bootstrap()->run();
