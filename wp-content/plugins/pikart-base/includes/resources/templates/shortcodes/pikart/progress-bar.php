<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array                                      $data
 */
?>

<div class="pikode pikode--progressbar progressbar <?php echo esc_attr( $data['css_class'] ) ?>">
	<div class="progressbar__branding">
		<?php if ( ! empty( $data['title'] ) ) : ?>
			<h4 class="progressbar__branding__title"><?php echo esc_html( $data['title'] ) ?></h4>
		<?php endif; ?>
		<div class="progressbar__branding__number">
			<span>0</span>%
		</div>
	</div>

	<div class="progressbar__full">
		<div class="progressbar__progress" data-pro-bar-percent="<?php echo esc_attr( $data['progress'] ) ?>"></div>
	</div>
</div>