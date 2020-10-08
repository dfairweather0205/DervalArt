<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var \Pikart\Nels\Post\Options\Type\ProductOptions $options
 * @var array $data
 */

$item       = $data['item'];
$options    = $data['options'][ $item ];
$itemTitle  = $options->getTitleArea();
$cssClasses = empty( $itemTitle ) ? '' : 'reset-font-weight';

?>
<h4 class="branding__title <?php echo esc_attr( $cssClasses ) ?>"
	<?php printf( 'style="font-size: %dpx;"', esc_attr( $options->getMasonryTitleFontSize() ) ) ?> >
	<?php echo (empty( $itemTitle ) ? esc_html( get_the_title( $item ) ) : wp_kses_post( $itemTitle )) ?>
</h4>

<?php
/**
 * Hook: woocommerce_shop_loop_item_title.
 *
 * @hooked woocommerce_template_loop_product_title - 10
 */
do_action( 'woocommerce_shop_loop_item_title' );

if ( ! empty( $data['items_categories'][ $item ] ) ) : ?>
	<div class="branding__meta">
		<div class="branding__meta__item branding__meta__taxonomies">
			<?php echo esc_html( implode( ', ', $data['items_categories'][ $item ] ) ); ?>
		</div>
	</div>
<?php endif;