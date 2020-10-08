<?php
// PIKART_VERSION constant is used as a version for the static files while enqueueing,
// when debugging is enabled we don't want the browser to cache the static files, that's why in this case we append
// a new suffix every time
defined( 'PIKART_VERSION' ) || define( 'PIKART_VERSION', '1.8.4' . ( WP_DEBUG ? '.' . uniqid() : '' ) );
defined( 'PIKART_SLUG' ) || define( 'PIKART_SLUG', 'pikart' );
defined( 'PIKART_CORE_SLUG' ) || define( 'PIKART_CORE_SLUG', 'pikart-core' );
defined( 'PIKART_BASE_SLUG' ) || define( 'PIKART_BASE_SLUG', 'pikart-base' );
defined( 'PIKART_THEME_SLUG' )
|| define( 'PIKART_THEME_SLUG', str_replace( '-child', '', wp_get_theme()->get( 'TextDomain' ) ) );

defined( 'PIKARTHOUSE_URL' ) || define( 'PIKARTHOUSE_URL', 'https://pikarthouse.com/' );
