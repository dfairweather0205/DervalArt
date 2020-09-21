<?php
$metadata = wp_get_attachment_metadata();
?>

<div class="branding__meta">

	<span class="branding__meta__item branding__meta__date"><?php echo esc_html( get_the_date() ) ?></span>

	<?php if ( wp_attachment_is_image() ) : ?>
		<span class="branding__meta__item branding__meta__dimensions">
			<?php printf( '%d &times; %d', (int) $metadata['width'], (int) $metadata['height'] ) ?>
		</span>
	<?php endif; ?>

</div>