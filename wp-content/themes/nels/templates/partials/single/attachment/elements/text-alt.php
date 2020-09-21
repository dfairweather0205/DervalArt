<?php

$alternativeText = get_post_meta( get_the_ID(), '_wp_attachment_image_alt', true );

if ( ! empty ( $alternativeText ) ) : ?>

	<div class="text-alt">
		<div class="attachment__title">
			<?php echo esc_html__( 'Alternative text', 'nels' ) ?>
		</div>
		<div class="attachment__content">
			<?php echo esc_html( $alternativeText ) ?>
		</div>
	</div>

<?php endif;