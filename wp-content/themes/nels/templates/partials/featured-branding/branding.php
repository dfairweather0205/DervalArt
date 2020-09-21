<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;


if ( is_singular() ) :

	Service::util()->partial( 'featured-branding/branding-single' );

elseif ( ShopUtil::isShop() ) :

	Service::util()->partial( 'shop/elements/branding' );

elseif ( have_posts() ) : ?>

	<h1 class="branding__title"><?php echo wp_kses_post( Service::templatesUtil()->getArchiveTitle() ); ?></h1>

<?php else : ?>

	<h1 class="branding__title"><?php esc_html_e( 'Nothing Found', 'nels' ); ?></h1>

<?php endif;