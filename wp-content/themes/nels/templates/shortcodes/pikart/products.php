<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 */

use Pikart\Nels\Post\Options\Type\ProductOptions;

$data['container_css_classes'] = 'pikode pikode--products archive-list woocommerce' . $this->format( ' %s', $data['css_class'] );
$data['shortcode_name']        = 'products';

foreach ( $data['options'] as $itemId => $options ) :
	$data['options'][ $itemId ] = new ProductOptions( $itemId, $options );
endforeach;

$this->partial( 'common/' . $data['type'], $data, 'products/masonry' );
