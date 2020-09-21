<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array                                      $data
 */

$locations = $this->getShortcodeData( 'geolocation' );

$positions    = array();
$titles       = array();
$descriptions = array();

foreach ( $locations as $location ) :
	$attributes = $location['attributes'];

	$titles[]       = esc_html( $attributes['title'] );
	$descriptions[] = esc_html( $attributes['description'] );
	$positions[]    = array(
		'lat'  => esc_attr( $attributes['lat'] ),
		'long' => esc_attr( $attributes['long'] )
	);
endforeach;


$cssClasses   = esc_attr( $data['css_class'] );
$zoom         = (int) $data['zoom'];
$positions    = json_encode( $positions );
$titles       = json_encode( $titles );
$descriptions = json_encode( $descriptions );

$linkStart = $this->textIfValTrue( '<div class="parallax">', $data['parallax'] );
$linkEnd   = $this->textIfValTrue( '</div>', $data['parallax'] );

$style = $this->style( array(
	$this->styleItem( 'height', $this->format( '%dpx', (int) $data['height'] ) )
) );

echo <<<HTML
$linkStart
	<div class="pikode pikode--map $cssClasses" data-zoom="$zoom" data-positions='$positions' data-titles='$titles'
	     data-descriptions='$descriptions' $style></div>
$linkEnd
HTML;

