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
 * @version       3.3.1
 */

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Shop\ShopTemplateHelper;

$total   = isset( $total ) ? $total : ShopTemplateHelper::wcGetTotalPages();

if ( $total <= 1 ) :
	return;
endif;

$current = isset( $current ) ? $current : ShopTemplateHelper::wcGetCurrentPage();
$base    = isset( $base ) ? $base : esc_url_raw(
	str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

$templatesUtil = Service::templatesUtil();
$isFirstPage   = $templatesUtil->isFirstPage( $current );
$isLastPage    = $templatesUtil->isLastPage( $current, $total );

$prevLink = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
$prevLink = str_replace( '%#%', $current - 1, $prevLink );

$nextLink = str_replace( '%_%', $args['format'], $args['base'] );
$nextLink = str_replace( '%#%', $current + 1, $nextLink );
?>

<nav class="nav nav--archive">
    <h2 class="screen-reader-text"><?php esc_html_e( 'Shop navigation', 'nels' ) ?></h2>
    <div class="nav__wrapper">

        <?php if ( $isFirstPage ) : ?>
            <div class="nav__link">
        <?php else : ?>
            <a class="nav__link" href="<?php echo esc_url( $prevLink ) ?>">
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
			<?php
			echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
				'base'      => $base,
				'format'    => $format,
				'add_args'  => false,
				'current'   => max( 1, $current ),
				'total'     => $total,
				'prev_next' => false,
				'prev_text' => '',
				'next_text' => '',
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3,
			) ) );
			?>
        </div>

	    <?php if ( $isLastPage ) : ?>
            <div class="nav__link">
        <?php else : ?>
            <a class="nav__link" href="<?php echo esc_url( $nextLink ) ?>">
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
