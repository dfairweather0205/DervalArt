<?php
set_query_var( 'singleNavigationAttributes', array(
	'previousPostText' => esc_html__( 'Previous page', 'nels' ),
	'nextPostText'     => esc_html__( 'Next page', 'nels' ),
	'allItemsText'     => esc_html__( 'All Pages', 'nels' ),
	'allItemsLink'     => false,
) );