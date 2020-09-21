<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 * @var string $content
 */

$cssClasses = 'pikode pikode--row ' . $this->textIfValTrue( 'parallax', $data['parallax'] )
              . $this->textIfValTrue( ' is-positioned', $data['enable_position'] )
              . $this->textIfValTrue( ' with-borders', ! empty ( $data['borders_width'] ) )
              . $this->format( ' %s', $data['css_class'] );

$mainStyleItems = $this->styleItems( array(
	$this->styleItem( 'top', $this->format( '%spx', esc_attr( $data['position_top'] ) ) ),
	$this->styleItem( 'right', $this->format( '%spx', esc_attr( $data['position_right'] ) ) ),
	$this->styleItem( 'bottom', $this->format( '%spx', esc_attr( $data['position_bottom'] ) ) ),
	$this->styleItem( 'left', $this->format( '%spx', esc_attr( $data['position_left'] ) ) ),
	$this->styleItem( 'z-index', $this->textIfValTrue(
		esc_attr( $this->util->getValidNumberInRange( $data['z_index'], - 90, 90 ) ), $data['enable_position'] ) ),
	$this->styleItem( 'padding', esc_attr( $data['padding'] ) ),
	$this->styleItem( 'margin', esc_attr( $data['margin'] ) ),
	$this->styleItem( 'border-width', esc_attr( $data['borders_width'] ) ),
	$this->styleItem( 'border-color', esc_attr( $data['borders_color'] ) )
) );

$heightIsFixed  = $data['height'] === 'fixed_values';
$heightIsCustom = $data['height'] === 'custom';

$mainInnerCssClasses = 'pikode--row__wrapper'
                       . $this->textIfValTrue( ' pikode--row--height-auto', $data['height'] === 'auto' )
                       . $this->textIfValTrue( ' pikode--row--height-custom', $heightIsFixed || $heightIsCustom )
                       . $this->textIfValTrue( ' pikode--row--height-fixed-value', $heightIsFixed )
                       . $this->textIfValTrue( sprintf( ' pikode--%s', $data['height_fixed_values'] ), $heightIsFixed );

$mainInnerStyleItems = $heightIsCustom
	? $this->styleItem( 'height', $this->format( '%spx', esc_attr( $data['height_custom'] ) ) ) : '';

$hasAnimation   = $data['animation'] !== 'none';
$animationDelay = 1000 * $data['animation_delay'];

$backgroundImageIsSetUp = ! empty ( $data['background_image'] );
$backgroundColorIsSetUp = ! empty ( $data['background_color'] );
$backgroundIsSetUp      = $backgroundImageIsSetUp || $backgroundColorIsSetUp;

$backgroundImageStyleItems = $this->styleItem(
	'background-image', $this->format( 'url(%s)', esc_url( $data['background_image'] ) ) );

$backgroundOverlayStyleItems = $this->styleItems( array(
	$this->styleItem( 'opacity', esc_attr( $data['background_color_opacity'] ) ),
	$this->styleItem( 'background-color', esc_attr( $data['background_color'] ) )
) );

$contentCssClasses = 'pikode--row__content--skin-' . $data['color_skin']
                     . $this->textIfValTrue( ' animated not-visible', $hasAnimation );

$contentStyleItems = $this->styleItem( 'vertical-align', esc_attr( $data['vertical_position'] ) );

$contentWrapperCssClass = 'pikode--row__content__wrapper pikode--row__content--'
                          . esc_attr( $data['horizontal_position'] );

$contentWrapperStyleItems = $data['width'] === 'custom'
	? $this->styleItem( 'max-width', $this->format( '%spx', esc_attr( $data['width_custom'] ) ) ) : '';

$contentInnerCssClass = 'pikode--row__content-inner'
                        . $this->textIfValTrue( ' with-borders', ! empty ( $data['borders_width_content'] ) )
                        . $this->textIfValTrue( ' pikode--row--width-auto', $data['width'] === 'auto' );

$contentInnerStyleItems = $this->styleItems( array(
	$this->styleItem( 'padding', esc_attr( $data['padding_content'] ) ),
	$this->styleItem( 'margin', esc_attr( $data['margin_content'] ) ),
	$this->styleItem( 'border-width', esc_attr( $data['borders_width_content'] ) ),
	$this->styleItem( 'border-color', esc_attr( $data['borders_color_content'] ) ),
) );

/**
 * @param string $styleItemsString
 */
$printStyle = function ( $styleItemsString ) {
	if ( $styleItemsString ) {
		printf( ' style="%s"', esc_attr( $styleItemsString ) );
	}
};
?>

<div <?php echo( ! empty ( $data['anchor_id'] ) ? sprintf( 'id="%s"', esc_attr( $data['anchor_id'] ) ) : '' ) ?>
		class="<?php echo esc_attr( $cssClasses ) ?>" <?php $printStyle( $mainStyleItems ); ?> >

	<div class="<?php echo esc_attr( $mainInnerCssClasses ) ?>" <?php $printStyle( $mainInnerStyleItems ); ?> >

		<div class="pikode--row-inner">

			<?php if ( $backgroundIsSetUp ) : ?>

				<div class="pikode--row__background">

					<?php if ( $backgroundImageIsSetUp ) : ?>
						<div class="background-image" <?php $printStyle( $backgroundImageStyleItems ); ?> ></div>
					<?php endif; ?>

					<?php if ( $backgroundColorIsSetUp ) : ?>
						<div class="color-overlay" <?php $printStyle( $backgroundOverlayStyleItems ) ?> ></div>
					<?php endif; ?>

				</div>

			<?php endif; ?>

			<div class="pikode--row__content <?php echo esc_attr( $contentCssClasses ) ?>"
				<?php
				$printStyle ( $contentStyleItems );

				if ( $hasAnimation && $data['animation'] ) :
					printf( ' data-animation="%s"', esc_attr( $data['animation'] ) );
				endif;

				if ( $hasAnimation && $animationDelay ) :
					printf( ' data-animation-delay="%s"', esc_attr( $animationDelay ) );
				endif; ?> >

				<div class="<?php echo esc_attr( $contentWrapperCssClass ) ?>" <?php $printStyle( $contentWrapperStyleItems ) ?> >
					<div class="<?php echo esc_attr( $contentInnerCssClass ) ?>" <?php $printStyle( $contentInnerStyleItems ) ?> >
						<?php $this->printContent( $content ) ?>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>
