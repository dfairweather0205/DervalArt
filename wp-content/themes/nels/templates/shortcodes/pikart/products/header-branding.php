<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer     $this
 * @var \Pikart\Nels\Post\Options\Type\ProductOptions $options
 * @var array                                          $data
 */

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

$item    = $data['item'];
$options = $data['options'][ $item ];

$isCatalogModeEnabled = Service::themeOptionsUtil()->isShopCatalogModeEnabled();

$product = ShopUtil::getGlobalProduct();
?>

<div class="card-content">

	<a class="card-branding" href="<?php the_permalink( $item ); ?>">
		<?php $this->partial( 'products/header-branding-titles', $data ); ?>
	</a>

	<?php if ( ! $isCatalogModeEnabled ) : ?>
		<div class="card-info">
			<?php if ( $product->get_price_html() ) : ?>
				<span class="card-info__item">
					<?php woocommerce_template_loop_price(); ?>
				</span>
			<?php endif;

			/**
			 * Hook: woocommerce_after_shop_loop_item_title.
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
			?>

			<span class="card-info__item">
				<span class="card-button">
					<?php
					/**
					 * woocommerce_after_shop_loop_item hook.
					 *
					 * @hooked woocommerce_template_loop_product_link_close - 5
					 * @hooked woocommerce_template_loop_add_to_cart - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item' );
					?>
				</span>
			</span>
		</div>
	<?php endif; ?>

</div>