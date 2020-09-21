<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Shop\ProductQuickViewInitializer;
use Pikart\WpThemeCore\Shop\ShopUtil;

$productQuickViewAction = ProductQuickViewInitializer::PRODUCT_QUICK_VIEW_ACTION;
$productQuickViewUrl    = add_query_arg( array(
	'action'    => $productQuickViewAction,
	'productId' => ShopUtil::getGlobalProduct()->get_id(),
	'nonce'     => wp_create_nonce( $productQuickViewAction ),
), admin_url( 'admin-ajax.php' ) );

?>
<a class="<?php echo esc_attr( Service::templatesUtil()->getShopCardIconCssClasses( 'quick-view-button' ) ) ?>"
   href="<?php echo esc_url( $productQuickViewUrl ) ?>"
   title="<?php esc_attr_e( 'Quick View', 'nels' ) ?>" data-tooltip>
	<i class="icon-magnifier"></i>
</a>
