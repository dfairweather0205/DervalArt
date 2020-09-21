<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 */

$cssClasses = $this->format( ' separator--%s', $data['type'] )
              . $this->format( ' separator--%s', $data['alignment'] )
              . $this->format( ' %s', $data['css_class'] );

$svgPath = $data['type'] === 'down' ? '1,11 11,1 21,11 31,1 41,11 51,1 61,11'
	: '1,1 11,11 21,1 31,11 41,1 51,11 61,1';
?>

<span class="pikode pikode--separator <?php echo esc_attr( $cssClasses ) ?>">
	<svg width="62px" height="12px" viewBox="0 0 62 12">
		<polyline class="separator__stroke" points="<?php echo esc_attr( $svgPath ) ?>"/>
	</svg>
</span>