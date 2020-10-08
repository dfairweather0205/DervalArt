<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$themeOptionsUtil = Service::themeOptionsUtil();

if ( ! $themeOptionsUtil->isHeaderSearchAreaEnabled() ):
	return;
endif;

$headerSearchAreaType = $themeOptionsUtil->getOption( ThemeOption::HEADER_SEARCH_AREA_TYPE );

$asideClasses = sprintf(
	'site-search-area site-search-area--%s search-area--skin-%s',
	$headerSearchAreaType,
	$themeOptionsUtil->getOption( ThemeOption::HEADER_SEARCH_AREA_COLOR_SKIN ) );
?>

<aside class="<?php echo esc_attr( $asideClasses ) ?>">
	<div class="site-search-area-inner">

		<button class="search-form-close-button">
			<svg width="20px" height="20px" viewBox="0 0 20 20">
				<path d="M19 2.414L17.586 1 10 8.586 2.414 1 1 2.414 8.586 10 1 17.586 2.414 19 10 11.414 17.586 19 19 17.586 11.414 10z"/>
			</svg>
		</button>

		<div class="site-search-area__text">
			<div class="site-search-area__text-inner">
				<?php Service::util()->partial( 'forms/searchform-alt' ) ?>
			</div>
		</div>

	</div>
</aside>