<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 */

use Pikart\Nels\Post\Options\Type\ProjectOptions;

$data['container_css_classes'] = 'pikode pikode--projects archive-list' . $this->format( ' %s', $data['css_class'] );
$data['shortcode_name']        = 'projects';

foreach ( $data['options'] as $itemId => $options ) :
	$data['options'][ $itemId ] = new ProjectOptions( $itemId, $options );
endforeach;

$this->partial( 'common/' . $data['type'], $data, 'projects/masonry' );
