<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 */

use Pikart\Nels\DependencyInjection\Service;

/**
 * Hook: woocommerce_before_shop_loop_item.
 *
 * @hooked woocommerce_template_loop_product_link_open - 10
 */
do_action( 'woocommerce_before_shop_loop_item' );
?>

<a class="card-thumbnail" href="<?php the_permalink( $data['item'] ); ?>">

	<?php if ( Service::templatesUtil()->isTransparencyAllowed( $data['masonry_display'] ) ) :
		$this->partial( 'common/header-overlay', $data );
	endif;

	Service::util()->partial( 'shop/article/elements/ribbons' );

	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
</a>

<?php Service::util()->partial( 'shop/article/elements/card-icons' );