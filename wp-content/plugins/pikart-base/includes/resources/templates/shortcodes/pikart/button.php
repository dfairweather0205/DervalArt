<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array                                      $data
 */

$href   = $this->attribute( 'href', $data['link'] );
$target = $this->textIfValTrue( 'target="_blank"', $data['new_tab'] );

$cssClasses = $this->format( ' button--%s', $data['size'] )
              . $this->format( ' button--txt--%s', $data['text_size'] )
              . $this->format( ' %s', $data['css_class'] );

$styleItems = array(
	$this->styleItem( 'color', $data['text_color'] ),
	$this->styleItem( 'border-color', $data['border_color'] ),
	$this->styleItem( 'background-color', $data['background_color'] ),
);

$hoverAttributes = array(
	$this->attribute( 'data-text-hover-color', $data['text_hover_color'] ),
	$this->attribute( 'data-border-hover-color', $data['border_hover_color'] ),
	$this->attribute( 'data-background-hover-color', $data['background_hover_color'] ),
);

$dataAttributes = $this->attributes( $hoverAttributes );

$cssClasses = esc_attr( $cssClasses );
$style      = $this->style( $styleItems );
$label      = esc_html( $data['label'] );

echo <<<HTML
<a class="pikode pikode--button $cssClasses" $href $target $style $dataAttributes>$label</a>
HTML;
