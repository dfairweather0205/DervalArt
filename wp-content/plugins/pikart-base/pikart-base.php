<?php
/**
 * Plugin Name:       Pikart Base
 * Plugin URI:        https://pikarthouse.com/
 * Description:       Base plugin for Pikart themes
 * Version:           1.7.1
 * Author:            Pikarthouse
 * Author URI:        https://pikarthouse.com/
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pikart-base
 * Domain Path:       /languages
 */

use Pikart\WpBase\DependencyInjection\Service;
use Pikart\WpCore\Common\CorePathsUtil;

// PIKART_BASE_VERSION constant is used as a version for the static files while enqueueing,
// when debugging is enabled we don't want the browser to cache the static files, that's why in this case we append
// a new suffix every time
defined( 'PIKART_BASE_VERSION' ) || define( 'PIKART_BASE_VERSION', '1.7.1' . ( WP_DEBUG ? '.' . uniqid() : '' ) );
defined( 'PIKART_BASE_SLUG' ) || define( 'PIKART_BASE_SLUG', 'pikart-base' );
defined( 'PIKART_BASE_PLUGIN_FILE' ) || define( 'PIKART_BASE_PLUGIN_FILE', __FILE__ );
defined( 'PIKART_BASE_PATH' ) || define( 'PIKART_BASE_PATH', plugin_dir_path( PIKART_BASE_PLUGIN_FILE ) );
defined( 'PIKART_BASE_URL' ) || define( 'PIKART_BASE_URL', plugins_url( '/', PIKART_BASE_PLUGIN_FILE ) );
defined( 'PIKART_PLUGIN_BASE_NAME' ) || define( 'PIKART_PLUGIN_BASE_NAME', plugin_basename( PIKART_BASE_PLUGIN_FILE ) );


require_once PIKART_BASE_PATH . '/includes/vendor/autoload.php';

CorePathsUtil::registerBaseDirAndUrl( PIKART_BASE_PATH, PIKART_BASE_URL );

Service::bootstrap()->run();