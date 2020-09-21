<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array                                      $data
 */

use Pikart\Nels\DependencyInjection\Service;

$overlayColorTransparency = Service::util()->getValidNumberInRange( $data['overlay_color_transparency'], 0, 100 );

$styleItems = array(
	$this->styleItem( 'opacity', Service::util()->transparencyToOpacity( $overlayColorTransparency ), '', false ),
	$this->styleItem( 'background-color', $data['overlay_color'] ),
);

$innerStyle = sprintf( 'style="%s"', esc_attr( implode( ' ', $styleItems ) ) );

echo <<<HTML
<div class="color-overlay">
    <div class="color-overlay-inner" $innerStyle ></div>
</div>
HTML;
