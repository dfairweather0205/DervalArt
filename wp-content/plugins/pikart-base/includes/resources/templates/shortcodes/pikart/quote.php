<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 */

$cssClasses = $this->format( 'quote-text--%s ', $data['text_size'] )
              . $this->format( 'quote-text--%s ', $data['text_alignment'] ) . $data['css_class'];
$cssClasses = trim( $cssClasses );
$target     = $this->textIfValTrue( 'target="_blank"', $data['new_tab'] );
?>

<blockquote class="pikode pikode--quote <?php echo esc_attr( $cssClasses ) ?>">
	<div class="quote__content"><?php echo esc_html( $data['label'] ) ?></div>

	<?php if ( ! empty( $data['author'] ) ) : ?>

		<div class="quote__author-name">
			<?php
			echo( empty( $data['author_link'] ) ? '' : sprintf( '<a href="%s" %s class="quote__author-name-link">', esc_url( $data['author_link'] ), $target ) );
			echo esc_html( $data['author'] );
			echo( empty( $data['author_link'] ) ? '' : '</a>' );
			?>
		</div>

	<?php endif; ?>

</blockquote>
