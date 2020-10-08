<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array                                      $data
 */

$isNormalType = 'normal' === $data['type'];

$styleItems = $this->style( array(
	$this->styleItem( 'font-size', $this->format( '%spx', esc_attr( $data['text_size'] ) ) ),
	$this->styleItem( 'font-weight', esc_attr( $data['font_weight'] ) ),
	$this->textIfValTrue( $this->format( ' height: %spx;', esc_attr( $data['square_size'] ) ), ! $isNormalType ),
	$this->textIfValTrue( $this->format( ' width: %spx;', esc_attr( $data['square_size'] ) ), ! $isNormalType ),
	$this->textIfValTrue( $this->format( ' line-height: %spx;', esc_attr( $data['square_size'] ) ), ! $isNormalType ),
	$this->styleItem( 'color', esc_attr( $data['text_color'] ) ),
	$this->textIfValTrue( $this->styleItem( 'border-color', esc_attr( $data['border_color'] ) ), ! $isNormalType ),
	$this->textIfValTrue(
		$this->styleItem( 'background-color', esc_attr( $data['background_color'] ) ), ! $isNormalType ),
) );

$cssClasses = esc_attr( trim( sprintf( 'dropcap--%s %s', $data['type'], $data['css_class'] ) ) );
$label      = esc_html( $data['label'] );

echo <<<HTML
<span class="pikode pikode--dropcap $cssClasses" $styleItems >$label</span>
HTML;
