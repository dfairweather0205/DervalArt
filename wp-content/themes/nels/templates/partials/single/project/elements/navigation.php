<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

set_query_var( 'singleNavigationAttributes', array(
	'previousPostText' => esc_html__( 'Previous project', 'nels' ),
	'nextPostText'     => esc_html__( 'Next project', 'nels' ),
	'allItemsText'     => esc_html__( 'All Projects', 'nels' ),
	'allItemsLink'     => Service::themeOptionsUtil()->getOption( ThemeOption::SINGLE_PROJECT_ALL_PROJECTS_LINK ),
) );