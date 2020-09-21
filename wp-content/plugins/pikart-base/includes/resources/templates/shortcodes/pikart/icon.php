<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array                                      $data
 */

$href       = $this->attribute( 'href', $data['link'] );
$target     = $this->textIfValTrue( 'target="_blank"', $data['new_tab'] );
$cssClasses = esc_attr( trim(
	$data['icon'] . ' icon-' . $data['type'] . ' icon-' . $data['size'] . ' icon-position-'
	. $data['position'] . ' icon-flip-' . $data['flip'] . ' ' . $data['css_class']
) );

$isBasicType = 'basic' === $data['type'];

$styleItems = array(
	$this->styleItem( 'color', $data['text_color'] ),
	$this->textIfValTrue( $this->styleItem( 'border-color', $data['border_color'] ), ! $isBasicType ),
	$this->textIfValTrue( $this->styleItem( 'background-color', $data['background_color'] ), ! $isBasicType ),
);

$hoverAttributes = array(
	$this->attribute( 'data-text-hover-color', $data['text_hover_color'] ),
	$this->textIfValTrue( $this->attribute( 'data-border-hover-color', $data['border_hover_color'] ), ! $isBasicType ),
	$this->textIfValTrue(
		$this->attribute( 'data-background-hover-color', $data['background_hover_color'] ), ! $isBasicType ),
);

$dataAttributes = $this->attributes( $hoverAttributes );
$style          = $this->style( $styleItems );

$linkStart = $this->textIfValNotEmpty( sprintf( '<a class="pikode--icon-link" %s %s>', $href, $target ), $href );
$linkEnd   = $this->textIfValNotEmpty( '</a>', $href );

echo <<<HTML
$linkStart
	<i class="pikode pikode--icon fa-$cssClasses" $style $dataAttributes></i>
$linkEnd
HTML;
