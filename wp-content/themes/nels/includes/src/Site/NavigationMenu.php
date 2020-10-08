<?php

namespace Pikart\Nels\Site;

if ( ! class_exists( __NAMESPACE__ . '\NavigationMenu' ) ) {

	/**
	 * Class NavigationMenu
	 * @package Pikart\Nels\Site
	 */
	final class NavigationMenu {
		const PRIMARY             = 'primary';
		const SOCIAL_PRIMARY      = 'social_primary';
		const ABOVE_MENU          = 'above_menu';
		const SOCIAL_HEADER_ABOVE = 'social_header_above';
		const FOOTER_MENU         = 'footer_menu';
		const SOCIAL_FOOTER_BELOW = 'social_footer_below';
	}

}