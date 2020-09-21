<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array                                      $data
 * @var string                                     $content
 */

$name   = esc_attr( $data['author'] );
$title  = esc_attr( $data['title'] );
$href   = $this->attribute( 'href', $data['author_link'] );
$target = $this->textIfValTrue( 'target="_blank"', $data['new_tab'] );

$linkStart = $this->textIfValNotEmpty(
	sprintf( '<a class="testimonials__item__branding__link" %s %s>', $href, $target ), $href );
$linkEnd   = $this->textIfValNotEmpty( '</a>', $href );

echo <<<HTML
<li class="testimonials__item">
	<div class="testimonials__item__content">
		<div class="testimonials__item__content__inner">$content</div>
	</div>
	<div class="testimonials__item__branding">
		$linkStart
			<span class="testimonials__item__branding__name">$name</span>
		$linkEnd
		<span class="testimonials__item__branding__title">$title</span>
	</div>
</li>
HTML;
