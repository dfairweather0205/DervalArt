<?php

use Pikart\Nels\DependencyInjection\Service;

/* @var \Pikart\Nels\Post\Options\Type\ProjectOptions $projectOptions */

$projectDate = $projectOptions->getProjectDate();
// exclude `slide_template` as it's a revolution slider custom field which should not be displayed
$customFields = Service::postUtil()->getCustomFields( get_the_ID(), array( 'slide_template' ) );

if ( empty( $projectDate ) && empty( $customFields ) ) :
	return;
endif; ?>

<div class="entry-custom-fields">
	<div class="custom-fields">

		<?php if ( ! empty( $projectDate ) ): ?>

			<div class="custom-fields__item">
				<span class="custom-fields__item__title"><?php esc_html_e( 'Date', 'nels' ); ?></span>
				<div class="custom-fields__item__value"><?php echo esc_html( $projectDate ) ?></div>
			</div>

		<?php endif;

		foreach ( $customFields as $fieldName => $fieldValue ) : ?>

			<div class="custom-fields__item">
				<span class="custom-fields__item__title"><?php echo esc_html( $fieldName ); ?></span>
				<div class="custom-fields__item__value"><?php echo wp_kses_post( $fieldValue ) ?></div>
			</div>

		<?php endforeach; ?>

	</div>
</div>

