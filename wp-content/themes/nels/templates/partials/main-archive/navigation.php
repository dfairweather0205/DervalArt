<?php

use Pikart\Nels\DependencyInjection\Service;

if ( Service::templatesUtil()->getTotalPages() <= 1 ) :
	return;
endif;

$templatesUtil = Service::templatesUtil();
$isFirstPage   = $templatesUtil->isFirstPage();
$isLastPage    = $templatesUtil->isLastPage();
?>

<nav class="nav nav--archive" role="navigation">
	<h2 class="screen-reader-text"><?php esc_html_e( 'Blog navigation', 'nels' ) ?></h2>
	<div class="nav__wrapper">

		<?php if ( $isFirstPage ) : ?>
			<div class="nav__link">
		<?php else : ?>
			<a class="nav__link" href="<?php echo esc_url( get_previous_posts_page_link() ) ?>">
		<?php endif; ?>

				<section class="nav__prev">
					<span class="nav__prev__direction">
						<span class="direction__text">
							<?php echo esc_html__( 'Previous', 'nels' ) ?>
						</span>
					</span>
				</section>

		<?php if ( $isFirstPage ) : ?>
			</div>
		<?php else : ?>
			</a>
		<?php endif; ?>

		<div class="nav-links">
			<?php echo paginate_links( array(
				'prev_next' => false,
				'type'	  => 'list',
			) ); ?>
		</div>

		<?php if ( $isLastPage ) : ?>
			<div class="nav__link">
		<?php else : ?>
			<a class="nav__link" href="<?php echo esc_url( get_next_posts_page_link() ) ?>">
		<?php endif; ?>

				<section class="nav__next">
					<span class="nav__next__direction">
						<span class="direction__text">
							<?php echo esc_html__( 'Next', 'nels' ) ?>
						</span>
					</span>
				</section>

		<?php if ( $isLastPage) : ?>
			</div>
		<?php else : ?>
			</a>
		<?php endif; ?>

	</div>
</nav>