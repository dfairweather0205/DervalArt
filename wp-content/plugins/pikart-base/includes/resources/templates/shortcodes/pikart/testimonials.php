<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array                                      $data
 * @var string                                     $content
 */

$contentAlignment = sprintf( ' testimonials--%s', $data['alignment'] );
$cssClasses       = esc_attr( $data['css_class'] . $contentAlignment );
$transition       = esc_attr( $data['transition'] );

echo <<<HTML
<div class="pikode pikode--testimonials $cssClasses">
	<ul class="testimonials__list" data-transition="$transition">
		$content
	</ul>
</div>
HTML;
