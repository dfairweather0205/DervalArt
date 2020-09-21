<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

isset( $postOptions ) || $postOptions = Service::postOptionsLoader()->loadStandardOptions( get_the_ID() );

$title      = $postOptions->getTitleArea();
$cssClasses = empty( $title ) ? '' : 'reset-font-weight';

$masonryItemOptions = Service::postOptionsLoader()->loadCommonPostOptions( get_the_ID() );
$titleStyle         = ShopUtil::isShop()
	? sprintf( 'font-size: %dpx;', $masonryItemOptions->getMasonryTitleFontSize() ) : '';

$title = empty( $title ) ? esc_html( get_the_title() ) : wp_kses_post( $title );
?>

<a class="card-branding" href="<?php the_permalink(); ?>">

	<h4 class="branding__title <?php echo esc_attr( $cssClasses ) ?>" style="<?php echo esc_attr( $titleStyle ) ?>">
		<?php echo wp_kses_post( $title ) ?>
	</h4>

	<?php
	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );
	?>

	<div class="branding__meta">
		<div class="branding__meta__item branding__meta__taxonomies">
			<?php echo esc_html( Service::templatesUtil()->joinTermNames( get_the_ID(), 'product_cat' ) ) ?>
		</div>
	</div>

</a>