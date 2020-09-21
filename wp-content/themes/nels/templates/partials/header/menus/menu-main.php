<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Misc\PikartBaseUtil;
use Pikart\Nels\Site\NavigationMenu;
use Pikart\Nels\ThemeOptions\ThemeOption;

$themeOptionsUtil = Service::themeOptionsUtil();
$isLogoSide       = $themeOptionsUtil->getOption( ThemeOption::MAIN_NAVIGATION_TYPE ) === 'side';

$colorSkin   = $themeOptionsUtil->getOption( ThemeOption::HEADER_SUBMENU_COLOR_SKIN );
$submenuSkin = ' dropdown-submenu--skin-' . $colorSkin;
$sidebarSkin = ' sidebar--skin-' . $colorSkin;

$mainNavigationPosition = $isLogoSide
	? 'navigation--' . $themeOptionsUtil->getOption( ThemeOption::HEADER_LOGO_SIDE_MENU_POSITION ) : '';

$itemsWrap = '<ul id="%1$s" class="%2$s" data-responsive-menu="dropdown">%3$s</ul>';
?>

<nav id="site-navigation" class="navigation navigation--main <?php echo esc_attr( $mainNavigationPosition ) ?>"
	 role="navigation">
	<?php wp_nav_menu( array(
		'theme_location' => NavigationMenu::PRIMARY,
		'menu_class'     => 'menu menu-horizontal primary-menu dropdown' . esc_attr( $submenuSkin . $sidebarSkin ),
		'menu_id'        => 'primary-menu',
		'container'      => '',
		'items_wrap'     => $itemsWrap,
		'link_before'    => '<span class="menu-item__span">',
		'link_after'     => '</span>',
		'fallback_cb'    => false,
		'walker'         => PikartBaseUtil::getCustomWalkerNavMenu()
	) ); ?>
</nav>