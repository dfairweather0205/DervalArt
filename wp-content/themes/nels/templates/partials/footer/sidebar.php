<?php
/**
 * The footer sidebar for our theme.
 *
 * @package Nels
 */

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$themeOptionsUtil = Service::themeOptionsUtil();

$colorSkin       = $themeOptionsUtil->getOption( ThemeOption::FOOTER_SIDEBAR_COLOR_SKIN );
$fullWidthFooter = $themeOptionsUtil->layoutHasElement( 'footer' ) ? ' fullwidth' : '';

$backgroundImageUrl = $themeOptionsUtil->getOption( ThemeOption::FOOTER_SIDEBAR_BACKGROUND_IMAGE );
$backgroundImageUrl = empty( $backgroundImageUrl )
	? '' : sprintf( 'background-image:url(%s)', esc_url( $backgroundImageUrl ) );

$nbColumns             = $themeOptionsUtil->getFooterSidebarNbColumns();
$sidebarColumnsClasses = sprintf( 'small-up-12 medium-up-%d large-up-%d', (int) round( $nbColumns / 2 ), $nbColumns );
?>

<aside class="widget-sidebar sidebar--site-footer sidebar--skin-<?php echo esc_attr( $colorSkin ) ?>"
	   style="<?php echo esc_attr( $backgroundImageUrl ) ?>">
	<div class="sidebar--site-footer__wrapper <?php echo esc_attr( $sidebarColumnsClasses . $fullWidthFooter ) ?>">

		<?php Service::util()->partial( 'footer/dynamic-sidebars' ) ?>

	</div>

	<div class="color-overlay"></div>
</aside>