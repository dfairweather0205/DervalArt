<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 */

set_query_var( PIKART_SLUG . 'ShopDisplay', $data['masonry_display'] );
?>

<div class="card-header header-standard">
	<?php $this->partial( 'products/featured-image/container-inner', $data ); ?>
</div>
