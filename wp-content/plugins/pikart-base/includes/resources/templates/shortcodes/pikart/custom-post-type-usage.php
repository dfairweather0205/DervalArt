<?php
/**
 * @since 1.1.0
 */
?>

<p></p>

<?php
echo sprintf( esc_html__(
	'The template for %s shortcode is theme specific, please check it for usage and implement it in your theme',
	'pikart-base'
), esc_html( $data['shortcode']->getShortName() ) );

/**
 * Copy the below code in yourThemePath/templates/shortcodes/pikart/{shortcodeName}.php and adapt it accordingly
 * where {shortcodeName} is one of products/projects/album
 */
?>

<p></p>

<div class="shortcode-container">

	<?php $data['shortcode']->beforeLoop(); ?>

	<div class="archive-container">

		<?php
		foreach ( $data['items'] as $itemId ) :
			$data['shortcode']->beforeItem( $itemId );
			?>

			<article class="item-container">
				<?php
				the_ID();
				echo ' - ';
				the_title(); ?>
			</article>

			<?php
			$data['shortcode']->afterItem();
		endforeach;

		$data['shortcode']->afterLoop(); ?>

	</div>

</div>