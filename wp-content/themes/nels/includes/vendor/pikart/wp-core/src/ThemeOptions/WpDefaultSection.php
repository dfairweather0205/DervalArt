<?php

namespace Pikart\WpThemeCore\ThemeOptions;

if ( ! class_exists( __NAMESPACE__ . '\\WpDefaultSection' ) ) {

	/**
	 * Class WpDefaultSection
	 * @package Pikart\WpThemeCore\ThemeOptions
	 */
	final class WpDefaultSection {
		const COLORS = 'colors';
		const WP_HEADER_IMAGE = 'header_image';
		const WP_BACKGROUND_IMAGE = 'background_image';
		const STATIC_FRONT_PAGE = 'static_front_page';
		const CUSTOM_CSS = 'custom_css';
		const TITLE_TAGLINE = 'title_tagline';
		const INSTALLED_THEMES = 'installed_themes';
		const WPORG_THEMES = 'wporg_themes';
	}
}