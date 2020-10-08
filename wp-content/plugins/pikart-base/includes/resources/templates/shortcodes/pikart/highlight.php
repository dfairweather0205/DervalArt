<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array                                      $data
 */

$isFillType = 'fill' === $data['type'];

$style = $this->style( array(
	$this->format( ' background-color: %s;', $data['background_color'] ),
	$this->format( ' color: %s;', $data['text_color'] ),
	$this->textIfValTrue(
		sprintf( ' box-shadow: 0.21em 0px 0px %s, -0.21em 0px 0px %s;',
			$data['background_color'], $data['background_color'] ),
		$isFillType ),
) );

$cssClasses = esc_attr( trim( 'highlight--' . $data['type'] . ' ' . $data['css_class'] ) );
$label      = esc_html( $data['label'] );

echo <<<HTML
<span class="pikode pikode--highlight $cssClasses" $style >$label</span>
HTML;
