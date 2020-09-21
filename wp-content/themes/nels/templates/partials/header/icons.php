<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Misc\PikartBaseUtil;
?>

<div class="site-icons">
	<?php Service::util()->partial( 'header/menus/menu-social' ) ?>

	<div class="tool-icons">
		<?php
		Service::util()->partial( 'header/search-area/search-button' );
		PikartBaseUtil::wishlistPartial( 'header/shop-icons/wishlist' );
		PikartBaseUtil::productsComparePartial( 'header/shop-icons/products-compare' );
		Service::util()->partial( 'header/shop-icons/account' );
		Service::util()->partial( 'header/shop-icons/shop-cart' );
		Service::util()->partial( 'header/sidebar/sidebar-button' );
		?>
		<div class="site-mobile-button">
			<?php Service::util()->partial( 'header/toggle-button' ) ?>
		</div>
	</div>
</div>