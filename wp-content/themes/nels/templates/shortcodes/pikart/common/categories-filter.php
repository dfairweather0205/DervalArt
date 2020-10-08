<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array                                      $data
 */

if ( empty( $data['category_filter_list'] ) ) :
	return;
endif;

$urlHashPattern           = '#!item_cat=%s&idx=%s';
$categoriesFilterPosition = 'archive-filter--' . $data['categories_filter_position'];
?>

<nav class="archive-filter">
	<ul class="archive-filter__list <?php echo esc_attr( $categoriesFilterPosition ) ?>">

		<li class="archive-filter__item">
			<a class="is-active"
			   href="<?php echo esc_attr( sprintf( $urlHashPattern, 'all', $this->getIndex() ) ) ?>"
			   data-filter-value="*" data-category-id="all">
				<?php esc_html_e( 'Show all', 'nels' ) ?>
			</a>
		</li>

		<?php foreach ( $data['category_filter_list'] as $categoryId => $categoryName ) : ?>

			<li class="archive-filter__item">
				<a class="btn--not-selected"
				   href="<?php echo esc_attr( sprintf( $urlHashPattern, $categoryId, $this->getIndex() ) ) ?>"
				   data-category-id="<?php echo esc_attr( $categoryId ) ?>"
				   data-filter-value=".item-category-<?php echo esc_attr( $categoryId ) ?>">
					<?php echo esc_html( $categoryName ) ?>
				</a>
			</li>

		<?php endforeach; ?>

	</ul>
</nav>
