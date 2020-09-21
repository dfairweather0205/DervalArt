<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$themeOptionsUtil = Service::themeOptionsUtil();

if ( ! $themeOptionsUtil->isHeaderSidebarEnabled() ):
	return;
endif;

$sidebarMenuIconClasses = 'aside-button sidebar--site-header-button sidebar-menu-icon--'
                          . $themeOptionsUtil->getOption( ThemeOption::HEADER_SIDEBAR_MENU_ICON ); ?>

<div class="header-aside-button">
	<a href="#" class="<?php echo esc_attr( $sidebarMenuIconClasses ) ?>">
		<?php Service::util()->partial( 'header/toggle-button' ) ?>
	</a>
</div>