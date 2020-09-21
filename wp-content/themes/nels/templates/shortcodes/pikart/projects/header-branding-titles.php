<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var \Pikart\Nels\Post\Options\Type\ProjectOptions $options
 * @var array $data
 */

$item       = $data['item'];
$options    = $data['options'][ $item ];
$itemTitle  = $options->getTitleArea();
$cssClasses = empty( $itemTitle ) ? '' : 'reset-font-weight';

$nbComments = get_comments_number();
?>
<h4 class="branding__title <?php echo esc_attr( $cssClasses ) ?>"
	<?php printf( 'style="font-size: %dpx;"', esc_attr( $options->getMasonryTitleFontSize() ) ) ?>>
	<?php echo (empty( $itemTitle ) ? esc_html( get_the_title( $item ) ) : wp_kses_post( $itemTitle )) ?>
</h4>

<?php if ( ! empty( $data['items_categories'][ $item ] ) ) : ?>
	<div class="branding__meta">
		<div class="branding__meta__item branding__meta__taxonomies">
			<i class="icon-tag"></i>
			<span><?php echo esc_html( implode( ', ', $data['items_categories'][ $item ] ) ); ?></span>
		</div>

		<div class="branding__meta__item">
			<i class="icon-bubble"></i>
			<span><?php echo esc_html ( $nbComments ); ?></span>
		</div>
	</div>
<?php endif;