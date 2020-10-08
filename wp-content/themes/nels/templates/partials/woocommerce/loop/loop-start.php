<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Shop\ShopTemplateHelper;
use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\WpThemeCore\Shop\ShopUtil;

$columnsSpacing = Service::themeOptionsUtil()->getOption( ThemeOption::SHOP_COLUMNS_SPACING );
$nbColumns      = ShopTemplateHelper::wcGetColumns();

$archiveItemsCssClasses = Service::templatesUtil()->getArchiveItemsCssClasses( $nbColumns, $columnsSpacing );

if ( isset( $productsUseCarousel ) && $productsUseCarousel ): ?>

	<ul class="woocommerce archive-items owl-carousel <?php echo esc_attr( $archiveItemsCssClasses ) ?>"
	data-nb-slides="<?php echo esc_attr( $nbColumns ) ?>"
	data-slides-spacing="<?php echo esc_attr( $columnsSpacing ) ?>">

<?php else:
	$categoriesClass = ShopUtil::shopPageDisplayIsSubcategories() || ShopUtil::categoryDisplayIsSubcategories()
		? ' archive-items--categories' : ''; ?>

<ul class="woocommerce <?php echo esc_attr( $archiveItemsCssClasses . $categoriesClass ) ?>">

<?php endif;



