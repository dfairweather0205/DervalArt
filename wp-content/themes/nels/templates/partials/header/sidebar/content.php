<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! Service::themeOptionsUtil()->isHeaderSidebarEnabled() ):
	return;
endif;

$headerSidebarColorSkin = 'sidebar--skin-'
                          . Service::themeOptionsUtil()->getOption( ThemeOption::HEADER_SIDEBAR_COLOR_SKIN );
?>

<aside class="widget-sidebar sidebar--site-header <?php echo esc_attr( $headerSidebarColorSkin ) ?>">

	<?php Service::util()->partial( 'header/sidebar/inner-content' ); ?>

</aside>