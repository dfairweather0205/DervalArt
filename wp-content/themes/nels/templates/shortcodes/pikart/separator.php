<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 */

$cssClasses = $this->format( ' separator--%s', $data['alignment'] )
              . $this->format( ' %s', esc_attr( $data['css_class'] ) );
?>

<div class="pikode pikode--separator <?php echo esc_attr( $cssClasses ) ?>"></div>