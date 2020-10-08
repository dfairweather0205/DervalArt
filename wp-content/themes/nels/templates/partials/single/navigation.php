<?php

isset( $singleNavigationAttributes ) || $singleNavigationAttributes = array(
	'previousPostText' => esc_html__( 'Previous item', 'nels' ),
	'nextPostText'     => esc_html__( 'Next item', 'nels' ),
	'allItemsText'     => esc_html__( 'All Items', 'nels' ),
	'allItemsLink'     => home_url( '/' ),
);

$prevPost = get_previous_post();
$nextPost = get_next_post();

$prevPostNoneClass = empty( $prevPost ) ? 'nav__direction--none' : '';
$nextPostNoneClass = empty( $nextPost ) ? 'nav__direction--none' : '';
?>

<nav class="entry-footer__item nav nav--single">
	<div class="nav__wrapper">

		<a class="nav__link"
			<?php echo( ! empty( $prevPost ) ? sprintf( 'href="%s"', esc_url( get_permalink( $prevPost->ID ) ) ) : '' ) ?> >
			<i class="icon-arrow-left-circle"></i>
			<section class="nav__prev">

				<?php
				if ( ! empty( $prevPost ) ) : ?>

					<h5 class="nav__prev__post-title">
						<span class="nav__prev__post-title-inner">
							<?php echo esc_html( $prevPost->post_title ) ?>
						</span>
					</h5>

				<?php endif; ?>

				<span class="nav__prev__direction <?php echo esc_attr( $prevPostNoneClass ) ?>">
					<span class="direction__text">
						<?php echo esc_html( $singleNavigationAttributes['previousPostText'] ) ?>
					</span>
				</span>

			</section>
		</a>

		<?php if ( $singleNavigationAttributes['allItemsLink'] ): ?>

			<a class="nav__button"
			   href="<?php echo esc_url( $singleNavigationAttributes['allItemsLink'] ) ?>"
			   title="<?php echo esc_attr( $singleNavigationAttributes['allItemsText'] ) ?>" data-tooltip>
				<i class="icon-grid"></i>
			</a>

		<?php endif; ?>

		<a class="nav__link"
			<?php echo( ! empty( $nextPost ) ? sprintf( 'href="%s"', esc_url( get_permalink( $nextPost->ID ) ) ) : '' ) ?> >
			<section class="nav__next">

				<?php
				if ( ! empty( $nextPost ) ) : ?>

					<h5 class="nav__next__post-title">
						<span class="nav__next__post-title-inner">
							<?php echo esc_html( $nextPost->post_title ) ?>
						</span>
					</h5>

				<?php endif; ?>

				<span class="nav__next__direction <?php echo esc_attr( $nextPostNoneClass ) ?>">
					<span class="direction__text">
						<?php echo esc_html( $singleNavigationAttributes['nextPostText'] ) ?>
					</span>
				</span>

			</section>
			<i class="icon-arrow-right-circle"></i>
		</a>

	</div>
</nav>