<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nels
 */

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$themeOptionsUtil = Service::themeOptionsUtil();

$postId = Service::templatesUtil()->getItemId();

$postOptions = null;
$siteContentBackgroundColor = '';

if ( $postId ) :
	$postOptions                = Service::postOptionsLoader()->loadCommonPostOptions( $postId );
	$siteContentBackgroundColor = sprintf( 'background-color: %s; ', $postOptions->getSiteContentBackground() );
endif;

$isLogoSide       = $themeOptionsUtil->getOption( ThemeOption::MAIN_NAVIGATION_TYPE ) === 'side';

// Site Header Customizations
$siteHeaderClasses = sprintf( 'logo-%s site-header--skin-%s site-header--%s %s %s',
	$themeOptionsUtil->getOption( ThemeOption::MAIN_NAVIGATION_TYPE ),
	Service::templatesUtil()->getSiteHeaderColorSkinCssClass( $postOptions ),
	$themeOptionsUtil->getOption( ThemeOption::HEADER_BEHAVIOUR ),
	Service::templatesUtil()->getSiteHeaderTransparencyCssClass( $postOptions ),
	$isLogoSide ? 'main-navigation--' . $themeOptionsUtil->getOption( ThemeOption::HEADER_LOGO_SIDE_MENU_POSITION ) : ''
);

$wpAdminBarIsActive = is_user_logged_in() && is_admin_bar_showing();
?><!DOCTYPE html>
<html <?php language_attributes(); ?>
	<?php if ( $wpAdminBarIsActive ):
		echo ' class="wp-admin-bar-is-active"';
	endif; ?>>

<?php Service::util()->partial( 'header/head' ) ?>

<body <?php body_class() ?> style="<?php echo esc_attr( $siteContentBackgroundColor ) ?>">

<?php
Service::util()->partial( 'loader/loader-wrapper' );
Service::util()->partial( 'scroll-top' );
Service::util()->partial( 'header/search-area/search-area' );
Service::util()->partial( 'header/sidebar/content' );
Service::util()->partial( 'header/popups/shop-cart-popup' );
Service::util()->partial( 'header/mobile' );
?>

<div class="blur-background-layer"></div>

<div class="site-wrapper">

	<?php Service::util()->partial( 'header/above-area/above-area' ) ?>

	<header id="site-header" class="site-header <?php echo esc_attr( $siteHeaderClasses ) ?>" role="banner">
		<div class="site-header__wrapper">
			<?php Service::util()->partial( 'header/header-main' ) ?>
		</div>
	</header>

	<div id="site-content" class="site-content">