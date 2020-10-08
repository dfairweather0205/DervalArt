<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 * @var string $content
 */
?>

<div class="pikartslider pikartslider--quote" <?php echo esc_attr( $data['navigation_style'] ) ?>
	 data-slidertransition="<?php echo esc_attr( $data['transition'] ) ?>">
	<?php print( $content ) ?>
</div>