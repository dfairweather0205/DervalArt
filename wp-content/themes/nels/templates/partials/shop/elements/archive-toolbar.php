<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Shop\ShopTemplateHelper;
use Pikart\Nels\Site\SidebarId;
use Pikart\Nels\ThemeOptions\ThemeOption;

$isShopFilterActive = is_active_sidebar( SidebarId::shopFilter() );
$shopColumnsNumber  = ShopTemplateHelper::wcGetColumns();

$nbColumnsData = array(
	2 => 'two',
	3 => 'three',
	4 => 'four',
);

$filterWidgetColumns = Service::themeOptionsUtil()->getOption( ThemeOption::SHOP_FILTER_NB_COLUMNS );
?>

<div class="shop-filter">

	<div class="shop-filter__toolbar">
		<div class="row">
			<div class="columns medium-4 large-4">
				<ul class="shop-filter__toolbar__column shop-filter__toolbar__results">
					<li class="archive-toolbar__results">
						<?php woocommerce_result_count(); ?>
					</li>
				</ul>
			</div>
			<div class="columns medium-8 large-8">
				<ul class="shop-filter__toolbar__column shop-filter__toolbar__controls">
					<li class="shop-products-size">
						<?php
						foreach ( $nbColumnsData as $nbColumns => $nbColumnsOrdinal ):
							$isActive = $shopColumnsNumber === $nbColumns ? 'active' : '';
							$columnText = 'column' . ( $nbColumns > 1 ? 's' : '' );
							$linkClass = trim( sprintf( '%s-%s %s', $nbColumnsOrdinal, $columnText, $isActive ) );
							$partial = sprintf( 'shop/elements/product-size-icons/%s-%s', $nbColumns, $columnText ); ?>

							<a href="#" class="<?php echo esc_attr( $linkClass ) ?>"
							   data-nb-columns="<?php echo esc_attr( $nbColumns ) ?>">
								<?php Service::util()->partial( $partial ); ?>
							</a>

						<?php endforeach; ?>
					</li>
					<li class="shop-filter__toolbar__sorting">
						<?php woocommerce_catalog_ordering(); ?>
					</li>
					<?php if ( $isShopFilterActive ) : ?>
						<li class="shop-filter__toolbar__filter">
							<a href="#">
								<?php esc_html_e( 'Filter', 'nels' ); ?>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>

	<?php if ( $isShopFilterActive ) : ?>
		<div class="shop-filter__sidebar widget-sidebar columns-<?php echo esc_attr( $filterWidgetColumns )?> sidebar--skin-dark">
			<div class="shop-filter__sidebar__wrapper">
				<?php dynamic_sidebar( SidebarId::shopFilter() ); ?>
			</div>
		</div>
	<?php endif; ?>

</div>