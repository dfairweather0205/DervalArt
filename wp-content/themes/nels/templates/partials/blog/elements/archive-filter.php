<?php
/* @var \Pikart\Nels\Blog\Options\BlogOptions $blogOptions */

use Pikart\Nels\DependencyInjection\Service;

isset( $blogOptions ) || $blogOptions = Service::blogOptionsLoader()->load();

$allCategoriesLinkClass   = $blogOptions->getCategoryId() ? 'btn--not-selected' : 'is-active';
$categoriesFilterPosition = 'archive-filter--' . $blogOptions->getCategoriesFilterPosition();
?>

<nav class="archive-filter">
	<ul class="archive-filter__list <?php echo esc_attr( $categoriesFilterPosition ) ?>">

		<li class="archive-filter__item">
			<a class="<?php echo esc_attr( $allCategoriesLinkClass ) ?>" href="<?php the_permalink() ?>">
				<?php esc_html_e( 'Show all', 'nels' ) ?>
			</a>
		</li>

		<?php foreach ( $blogOptions->getCategoryFilterList() as $categoryId => $categoryName ) :
			$linkClass = $categoryId === $blogOptions->getCategoryId() ? 'is-active' : 'btn--not-selected'; ?>

			<li class="archive-filter__item">
				<a class="<?php echo esc_attr( $linkClass ) ?>"
				   href="<?php echo esc_url( add_query_arg( 'categ', $categoryId, get_permalink() ) ) ?>">
					<?php echo esc_html( $categoryName ) ?>
				</a>
			</li>

		<?php endforeach; ?>

	</ul>
</nav>
