<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 * @var string $content
 */

$cssClasses = $this->textIfValTrue( 'with-borders', ! empty ( $data['borders_width'] ) )
              . $this->textIfValTrue( ' is-positioned', $data['enable_position'] )
              . $this->format( ' custom-content--%s', $data['font_size'] )
              . $this->format( ' %s', esc_attr( $data['css_class'] ) );

$styleElements = array(
	$this->styleItem( 'font-family', esc_attr( $this->extractFontFamilyName( $data['font_family'] ) ) ),
	$this->styleItem( 'font-weight', esc_attr( $data['font_weight'] ) ),
	$this->styleItem( 'letter-spacing', $this->format( '%spx', esc_attr( $data['letter_spacing'] ) ) ),
	$this->styleItem( 'line-height', esc_attr( $data['line_height'] ) ),
	$this->styleItem( 'text-decoration', esc_attr( $data['text_decoration'] ) ),
	$this->styleItem( 'color', esc_attr( $data['text_color'] ) ),
	$this->styleItem( 'padding', esc_attr( $data['paddings'] ) ),
	$this->styleItem( 'margin', esc_attr( $data['margins'] ) ),
	$this->styleItem( 'border-width', esc_attr( $data['borders_width'] ) ),
	$this->styleItem( 'border-color', esc_attr( $data['borders_color'] ) ),
	$this->styleItem( 'background-color', esc_attr( $data['background_color'] ) ),
	$this->styleItem( 'top', $this->format( '%spx', esc_attr( $data['position_top'] ) ) ),
	$this->styleItem( 'right', $this->format( '%spx', esc_attr( $data['position_right'] ) ) ),
	$this->styleItem( 'bottom', $this->format( '%spx', esc_attr( $data['position_bottom'] ) ) ),
	$this->styleItem( 'left', $this->format( '%spx', esc_attr( $data['position_left'] ) ) ),
	$this->styleItem( 'z-index', $this->textIfValTrue(
		esc_attr( $this->util->getValidNumberInRange( $data['z_index'], - 90, 90 ) ), $data['enable_position'] ) )
);

$contentStyle = $this->style( $styleElements );

echo <<<HTML
<div class="pikode pikode--custom-content $cssClasses" $contentStyle>$content</div>
HTML;
