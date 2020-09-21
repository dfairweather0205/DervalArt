<?php
set_query_var( 'singleNavigationAttributes', array(
	'previousPostText' => esc_html__( 'Previous attachment', 'nels' ),
	'nextPostText'     => esc_html__( 'Next attachment', 'nels' ),
	'allItemsText'     => esc_html__( 'All Attachments', 'nels' ),
	'allItemsLink'     => false,
) );