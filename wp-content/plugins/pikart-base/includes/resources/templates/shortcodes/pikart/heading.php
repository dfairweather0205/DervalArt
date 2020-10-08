<?php
/** @var array $data */

$title      = esc_html( $data['title'] );
$subtitle   = esc_html( $data['subtitle'] );
$cssClasses = esc_attr( trim( 'heading--align-' . $data['alignment'] . ' ' . $data['css_class'] ) );

echo <<<HTML
<div class="pikode pikode--heading $cssClasses">
	<h1>$title</h1>
	<h3>$subtitle</h3>
</div>
HTML;
