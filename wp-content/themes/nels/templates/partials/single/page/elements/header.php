<?php
/* @var \Pikart\Nels\Post\Options\Type\PageOptions $pageOptions */

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

$pageId = ShopUtil::isShop() ? ShopUtil::getShopPageId() : get_the_ID();

$pageOptions = Service::postOptionsLoader()->loadPageOptions( $pageId );

if ( $pageOptions->getHeroHeader() ) : ?>

	<div class="entry-header__item entry-thumbnail hero-header">
		<?php echo Service::templatesUtil()->filterContent( $pageOptions->getHeroHeader() ); ?>
	</div>

<?php endif;