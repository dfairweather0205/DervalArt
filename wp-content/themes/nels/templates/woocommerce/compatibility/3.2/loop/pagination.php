<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.2.2
 */

$wpQuery = $GLOBALS['wp_query'];

if ( $wpQuery->max_num_pages <= 1 ) :
	return;
endif; ?>

<nav class="nav nav--archive">
	<h2 class="screen-reader-text"><?php esc_html_e( 'Shop navigation', 'nels' ) ?></h2>
	<div class="nav__wrapper">

		<a class="nav__link" href="<?php echo esc_url( get_previous_posts_page_link() ) ?>" >
			<section class="nav__prev">
				<span class="nav__prev__direction">
					<span class="direction__text">
						<?php echo esc_html__( 'Previous', 'nels' ) ?>
					</span>
				</span>
			</section>
		</a>

		<div class="nav-links">
			<?php
			echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
				'base'      => esc_url_raw( str_replace(
					999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
				'format'    => '',
				'add_args'  => false,
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'total'     => $wpQuery->max_num_pages,
				'prev_text' => '',
				'next_text' => '',
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3,
			) ) ); ?>
		</div>

		<a class="nav__link" href="<?php echo esc_url( get_next_posts_page_link() ) ?>" >
			<section class="nav__next">
				<span class="nav__next__direction">
					<span class="direction__text">
						<?php echo esc_html__( 'Next', 'nels' ) ?>
					</span>
				</span>
			</section>
		</a>

	</div>
</nav>
