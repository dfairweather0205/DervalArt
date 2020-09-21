<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 */

$isFillType      = 'fill' === $data['type'];
$isShadowType    = 'shadow' === $data['type'];
$backgroundColor = esc_attr( $data['background_color'] );

$style = $this->style( array(
	$this->format( ' background-image: linear-gradient(to top, %s 35%%, rgba(0, 0, 0, 0) 35%%);', $backgroundColor ),
	$this->textIfValTrue( sprintf( ' background-image: linear-gradient(to top, %s 35%%, rgba(0, 0, 0, 0) 35%%);',
		$backgroundColor ), $isShadowType ),
	$this->format( ' color: %s;', esc_attr( $data['text_color'] ) ),
	$this->textIfValTrue( sprintf( ' background-color: %1$s; box-shadow: 0.21em 0px 0px %1$s, -0.21em 0px 0px %1$s;',
		$backgroundColor ), $isFillType ),
) );

$cssClasses = esc_attr( trim( 'highlight--' . $data['type'] . ' ' . $data['css_class'] ) );
$label      = esc_html( $data['label'] );

echo <<<HTML
<span class="pikode pikode--highlight $cssClasses" $style >$label</span>
HTML;
