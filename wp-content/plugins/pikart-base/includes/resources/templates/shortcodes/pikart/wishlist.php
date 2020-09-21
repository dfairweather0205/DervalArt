<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 *
 * @since 1.3.0
 */

$wishlist       = $data['wishlist'];
$containerClass = 'pikode pikode--wishlist woocommerce' . $this->format( ' %s', $data['css_class'] );
?>

<div class="<?php echo esc_attr( $containerClass ) ?>">

	<?php if ( empty( $wishlist ) ):
		$this->partial( 'wishlist/empty' );
	else:
		$this->partial( 'wishlist/products', $data );
	endif; ?>

</div>
