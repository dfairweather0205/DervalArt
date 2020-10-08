<?php
/**
 * @var array  $data
 * @var string $content
 */

$title = esc_html( $data['title'] );

echo <<<HTML
<li class="accordion-item" data-accordion-item>
	<a href="#" class="accordion-title">$title</a>
	<div class="accordion-content" data-tab-content>$content</div>
</li>
HTML;
