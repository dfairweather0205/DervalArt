<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Shop\ShopTemplateHelper;
use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\WpThemeCore\Shop\ShopUtil;

$productOptions = Service::postOptionsLoader()->loadProductOptions( get_the_ID() );

$cssClasses = sprintf(
	'card card--masonry card--%s column %s',
	Service::themeOptionsUtil()->getOption( ThemeOption::SHOP_DISPLAY ),
	$productOptions->isMasonryLargeSize() && ShopUtil::isShop() ? 'card--large' : '' );

$productClasses = join( ' ', ShopTemplateHelper::wcGetProductClass( $cssClasses ) );

$cardSpacingAround = $productOptions->getMasonrySpacing() === 'none' || ! ShopUtil::isShop()
	? '' : 'spacing-' . $productOptions->getMasonrySpacing();
?>

<li class="<?php echo esc_attr( $productClasses ) ?>">

	<div class="card-body <?php echo esc_attr( $cardSpacingAround ) ?>">
		<?php Service::util()->partial( 'shop/article/content' ) ?>
	</div>

</li>