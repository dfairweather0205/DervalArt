<?php
/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( empty( $tabs ) ) :
	return;
endif;

$tabsId = 'woocommerce-product-tabs';
$i      = 0;
?>

<div class="pikode--tabs pikode--tabs--woocommerce">

	<ul class="pikode--tabs__branding" role="tablist" data-tabs id="<?php echo esc_attr( $tabsId ) ?>">

		<?php foreach ( $tabs as $key => $tab ) :
			$isActive = $i ++ ? '' : 'is-active';
			$tabTitleClass = sprintf( 'tabs__title %s_tab %s', $key, $isActive );
			$tabTitleFilterName = sprintf( 'woocommerce_product_%s_tab_title', $key ); ?>

			<li class="<?php echo esc_attr( $tabTitleClass ) ?>" id="tab-title-<?php echo esc_attr( $key ) ?>"
				role="tab"
				aria-controls="tab-<?php echo esc_attr( $key ) ?>">
				<a href="#tab-<?php echo esc_attr( $key ) ?>">
					<?php echo wp_kses_post( apply_filters( $tabTitleFilterName, esc_html( $tab['title'] ), $key ) ); ?>
				</a>
			</li>

		<?php endforeach; ?>

	</ul>

	<div class="pikode--tabs__content" data-tabs-content="<?php echo esc_attr( $tabsId ) ?>">

		<?php
		$i = 0;

		foreach ( $tabs as $key => $tab ) :
			$isActive = $i ++ ? '' : 'is-active';
			$tabsPanelClass = sprintf(
				'tabs__panel woocommerce-Tabs-panel woocommerce-Tabs-panel--%s panel wc-tab %s', $key, $isActive ); ?>

			<div class="<?php echo esc_attr( $tabsPanelClass ) ?>" id="tab-<?php echo esc_attr( $key ) ?>"
				 role="tabpanel"
				 aria-labelledby="tab-title-<?php echo esc_attr( $key ) ?>">
				<?php if ( isset( $tab['callback'] ) ) :
					call_user_func( $tab['callback'], $key, $tab );
				endif; ?>
			</div>

		<?php endforeach; ?>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>

</div>

