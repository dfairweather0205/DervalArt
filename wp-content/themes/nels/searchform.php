<form class="search-form" action='<?php echo esc_url( home_url( '/' ) ); ?>' method="get" role="search">

	<input type="search" class="search-form__input"
		   placeholder="<?php esc_attr_e( 'Search for', 'nels' ) ?>"
		   value="<?php echo get_search_query() ?>" name="s" autocomplete="off"/>

	<button class="search-form__button"></button>

</form>
