<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 */

use Pikart\Nels\Post\Options\Type\AlbumOptions;

$data['container_css_classes'] = 'pikode pikode--album archive-list' . $this->format( ' %s', $data['css_class'] );
$data['shortcode_name']        = 'album';

foreach ( $data['options'] as $itemId => $options ) :
	$data['options'][ $itemId ] = new AlbumOptions( $itemId, $options );
endforeach;

$this->partial( 'common/' . $data['type'], $data, 'album/masonry' );
