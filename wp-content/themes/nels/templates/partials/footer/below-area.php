<?php
/**
 * The footer Below Area for our theme.
 *
 * @package Nels
 */

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$themeOptionsUtil = Service::themeOptionsUtil();

$fullWidthFooter = $themeOptionsUtil->layoutHasElement( 'footer' ) ? 'fullwidth' : '';
$colorSkin       = $themeOptionsUtil->getOption( ThemeOption::FOOTER_BELOW_COLOR_SKIN );
?>

<div class="site-footer__meta site-footer__meta--skin-<?php echo esc_attr( $colorSkin ) ?>">
	<div class="site-footer__meta__wrapper <?php echo esc_attr( $fullWidthFooter ) ?>">

		<?php
		Service::util()->partial( 'footer/copyright' );
		Service::util()->partial( 'footer/menu' );
		Service::util()->partial( 'footer/menu-social' );
		?>

	</div>
</div>