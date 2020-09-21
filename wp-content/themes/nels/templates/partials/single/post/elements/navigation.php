<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

set_query_var( 'singleNavigationAttributes', array(
	'previousPostText' => esc_html__( 'Previous post', 'nels' ),
	'nextPostText'     => esc_html__( 'Next post', 'nels' ),
	'allItemsText'     => esc_html__( 'All Posts', 'nels' ),
	'allItemsLink'     => Service::themeOptionsUtil()->getOption( ThemeOption::SINGLE_POST_ALL_POSTS_LINK ),
) );