<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nels
 */

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Site\SidebarId;
use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\WpThemeCore\Shop\ShopUtil;

$themeOptionsUtil = Service::themeOptionsUtil();

$postId = is_singular() ? get_the_ID() : ( ShopUtil::isShop() ? ShopUtil::getShopPageId() : null );

if ( $postId ) :
	$postOptions      = Service::postOptionsLoader()->loadCommonPostOptions( $postId );
	$isSidebarEnabled = $postOptions->isSiteContentSidebar();
	$customSidebar    = $postOptions->getCustomSidebar();
	$sidebar          = is_registered_sidebar( $customSidebar ) ? $customSidebar : SidebarId::content();
else :
	$isSidebarEnabled = $themeOptionsUtil->isArchiveSidebarEnabled();
	$sidebar          = SidebarId::archive();
endif;

$sidebarClasses = $isSidebarEnabled
	? sprintf( 'small-12 large-%d sidebar--skin-%s sidebar--position-%s',
		$themeOptionsUtil->getSidebarNbCols(),
		$themeOptionsUtil->getOption( ThemeOption::CONTENT_SIDEBAR_COLOR_SKIN ),
		$themeOptionsUtil->getOption( ThemeOption::CONTENT_SIDEBAR_POSITION ) ) : '';

if ( is_active_sidebar( $sidebar ) ) : ?>

	<aside class="entry-content__item widget-sidebar sidebar--site-content <?php echo esc_attr( $sidebarClasses ) ?>">
		<div class="sidebar--site-content-inner">
			<?php dynamic_sidebar( $sidebar ); ?>
		</div>
	</aside>

	<?php
endif;