<?php

$searchFieldIndex = isset( $index ) ? absint( $index ) : 0;
?>

<form role="search" method="get" class="woocommerce-product-search search-form"
      action='<?php echo esc_url( home_url( '/' ) ); ?>'>

	<label class="screen-reader-text"
	       for="woocommerce-product-search-field-<?php echo esc_attr( $searchFieldIndex ) ?>">
		<?php esc_html_e( 'Search for:', 'nels' ); ?>
	</label>

	<input type="search" id="woocommerce-product-search-field-<?php echo esc_attr( $searchFieldIndex ) ?>"
	       class="search-field search-form__input"
	       placeholder="<?php esc_attr_e( 'Search products&hellip;', 'nels' ) ?>"
	       value="<?php echo esc_attr( get_search_query( false ) ) ?>" name="s" autocomplete="off"/>

	<button class="search-form__button"></button>
	<input type="hidden" name="post_type" value="product" />

</form>
