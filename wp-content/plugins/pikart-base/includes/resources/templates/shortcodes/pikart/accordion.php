<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array                                      $data
 * @var string                                     $content
 */

$multiExpand    = $this->textIfValTrue( 'true', $data['multi_expand'], 'false' );
$allowAllClosed = $this->textIfValTrue( 'true', $data['allow_all_closed'], 'false' );
$cssClasses     = esc_attr( $data['css_class'] );

echo <<<HTML
<ul class="accordion $cssClasses" data-accordion data-multi-expand="$multiExpand"
    data-allow-all-closed="$allowAllClosed">$content</ul>
HTML;
