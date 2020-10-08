<?php

use Pikart\Nels\DependencyInjection\Service;

if ( ! Service::themeOptionsUtil()->headerHasShopIcon( 'products_compare' ) ) :
	return;
endif;

/**
 * @global int $compareListItemsNumber
 */
isset( $compareListItemsNumber ) || $compareListItemsNumber = 0;
?>

<div class="products-compare-icon">
	<a href="#" title="<?php esc_attr_e( 'Products Compare', 'nels' ); ?>">
		<i class="icon-shuffle"></i>
		<span class="products-compare__items"
			<?php if ( ! $compareListItemsNumber ):
				echo ' style="display: none"';
			endif; ?>>
			<span class="products-compare-icon__background"></span>
			<span class="products-compare-icon__items-number">
				<?php echo esc_html( $compareListItemsNumber ) ?>
			</span>
		</span>
	</a>
</div>