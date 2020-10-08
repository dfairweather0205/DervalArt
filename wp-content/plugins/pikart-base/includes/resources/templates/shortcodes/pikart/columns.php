<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 */

$columnsData     = $this->getShortcodeData( 'column' );
$data['spacing'] = is_numeric( $data['spacing'] ) ? $data['spacing'] : 0;
$columnsContents = array();
$columnStyle     = $this->style( array(
	$this->styleItem( 'border-left-width', $this->format( '%spx', esc_attr( $data['spacing'] ) ) )
) );

foreach ( $columnsData as $columnData ):
	$columnCssClasses = esc_attr(
		$columnData['attributes']['size'] . $this->format( ' %s', $columnData['attributes']['css_class'] ) );

	$columnsContents[] = sprintf( '<div class="pikode--column pikode--column--%s" %s>%s</div>',
		$columnCssClasses, $columnStyle, $columnData['content']
	);
endforeach;

$style = $this->style( array(
	$this->styleItem( 'margin-left', $this->format( '%spx', - $data['spacing'] ) )
) );

$cssClasses      = esc_attr( $data['css_class'] );
$columnsContents = implode( '', $columnsContents );

echo <<<HTML
<div class="pikode pikode--cols cols $cssClasses" $style >$columnsContents</div>
HTML;
