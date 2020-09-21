<?php
/**
 * The header Above Area for our theme.
 *
 * @package Nels
 */

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$themeOptionsUtil = Service::themeOptionsUtil();

$fullWidthHeaderClass = $themeOptionsUtil->layoutHasElement( 'header' ) ? 'fullwidth' : '';
$colorSkin            = $themeOptionsUtil->getOption( ThemeOption::HEADER_ABOVE_COLOR_SKIN );
$itemId               = Service::templatesUtil()->getItemId();

if ( $itemId ) :
	$options            = Service::postOptionsLoader()->loadCommonPostOptions( $itemId );
	$isAboveAreaEnabled = $options->getAboveArea();
else:
	$isAboveAreaEnabled = $themeOptionsUtil->isAboveAreaEnabled();
endif;

if ( ! $isAboveAreaEnabled ) :
	return;
endif;
?>

<div class="above-area above-area--skin-<?php echo esc_attr( $colorSkin ) ?>">
	<div class="above-area__wrapper <?php echo esc_attr( $fullWidthHeaderClass ) ?>">

		<?php
		Service::util()->partial( 'header/above-area/site-notice' );
		Service::util()->partial( 'header/above-area/menu' );
		Service::util()->partial( 'header/above-area/menu-social' );
		?>

	</div>
</div>