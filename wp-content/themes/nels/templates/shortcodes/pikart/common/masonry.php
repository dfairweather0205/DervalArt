<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var \Pikart\Nels\Post\Options\Type\CommonPostOptions $options
 * @var array $data
 */

use Pikart\Nels\DependencyInjection\Service;

$masonryColumnsSpacing = max( 0, (int) $data['masonry_columns_spacing'] );

$dataAnimationDelay = 1000 * Service::util()->getValidNumberInRange( $data['animation_delay'], 0, 3 );
$hasAnimation       = $data['animation'] !== 'none';

$animation      = $hasAnimation ? $data['animation'] : '';
$animationDelay = $hasAnimation && ! empty ( $dataAnimationDelay ) ? $dataAnimationDelay : '';


$archiveItemsCssClasses = Service::templatesUtil()->getArchiveItemsCssClasses(
	$data['masonry_nb_columns'],
	$masonryColumnsSpacing
);

$archiveItemsCssClassForWooCommerce = $data['shortcode_name'] === 'products' ? 'woocommerce ' : '';

$innerMargins = sprintf(
	'margin-right: %spx;', - $masonryColumnsSpacing );

$articlePadding = sprintf(
	'padding-right: %1$dpx; padding-bottom: %1$dpx;', $masonryColumnsSpacing );

$articleCssClasses = sprintf(
	'card card--masonry card--%s column',
	$data['masonry_display'] );
?>

<div class="<?php echo esc_attr( $data['container_css_classes'] ) ?>"
	 data-index="<?php echo esc_attr( $this->getIndex() ) ?>">

	<?php if ( $data['categories_display'] !== 'none' ) :
		$this->partial( 'common/categories-filter', $data );
	endif;

	$data['shortcode']->beforeLoop();
	?>

	<div class="<?php echo esc_attr( $archiveItemsCssClassForWooCommerce . $archiveItemsCssClasses ) ?>"
	     style="<?php echo esc_attr( $innerMargins ) ?>">

		<?php
		$animationProgressDelayCounter = $dataAnimationDelay;
		$animationProgressDelay        = 1000 * Service::util()->getValidNumberInRange(
				$data['animation_progress_delay'], 0, 1 );

		foreach ( $data['items'] as $itemId ) :
			$data['shortcode']->beforeItem( $itemId );

			$data['item'] = $itemId;

			$categoriesIds = array_keys( $data['items_categories'][ $itemId ] );

			$categoryClasses = implode( ' ', array_map( function ( $categoryId ) {
				return 'item-category-' . $categoryId;
			}, $categoriesIds ) );

			$options = $data['options'][ $itemId ];

			$masonrySize       = $options->isMasonryLargeSize() ? 'card--large' : '';
			$cardSpacingAround = $options->getMasonrySpacing() === 'none'
				? '' : 'spacing-' . $options->getMasonrySpacing();

			$isHoverCard = Service::templatesUtil()->isTransparencyAllowed( $data['masonry_display'] );
			$cardSkin    = $isHoverCard ? sprintf( 'card-skin--%s', $data['text_color_skin'] ) : '';

			$itemCssClasses = trim( sprintf( '%s %s %s %s %s',
					$articleCssClasses,
					$categoryClasses,
					$masonrySize,
					$cardSkin,
					$this->textIfValTrue( 'animated not-visible', $hasAnimation ) )
			);

			if ( $data['type'] === 'masonry' && $hasAnimation && $data['animation_effect'] === 'per_unit' ) :
				$animationDelay = $animationProgressDelay ? $animationProgressDelayCounter : '';

				$animationProgressDelayCounter += $animationProgressDelay;
			endif; ?>

			<article class="<?php echo esc_attr( $itemCssClasses ) ?>"
				<?php
				if ( $animation ) :
					printf( ' data-animation="%s"', esc_attr( $animation ) );
				endif;

				if ( $dataAnimationDelay ) :
					printf( ' data-animation-delay="%s"', esc_attr( $dataAnimationDelay ) );
				endif; ?>
					 style="<?php echo esc_attr( $articlePadding ) ?>">

				<div class="card-body <?php echo esc_attr( $cardSpacingAround ) ?>">
					<?php
					$this->partial( $data['shortcode_name'] . '/featured-image/container', $data );
					$this->partial( $data['shortcode_name'] . '/header-branding', $data ); ?>
				</div>

			</article>

			<?php

			$data['shortcode']->afterItem();
		endforeach; ?>

	</div>

	<?php $data['shortcode']->afterLoop(); ?>

</div>
