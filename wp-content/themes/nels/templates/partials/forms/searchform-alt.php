<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\WpThemeCore\Shop\ShopUtil;

$headerSearchAreaText = Service::themeOptionsUtil()->getOption( ThemeOption::HEADER_SEARCH_AREA_TEXT );
?>

<form class="search-form" action='<?php echo esc_url( home_url( '/' ) ); ?>' method='get' role='search'>

	<div class="search-form__field">
		<input type="search" name="s" class="search-form__input" value="<?php the_search_query() ?>"
		       autocomplete="off" placeholder="<?php echo esc_attr( $headerSearchAreaText ) ?>"/>

		<button class="search-form__button"></button>

		<?php if ( Service::themeOptionsUtil()->isHeaderProductSearchModeEnabled() ) : ?>
			<input type="hidden" name="post_type" value="product" />
		<?php endif; ?>

	</div>

	<div class="search-form__text">
		<?php esc_html_e(
			'Type anything to search, then press enter or Search Button', 'nels' ) ?>
	</div>

</form>