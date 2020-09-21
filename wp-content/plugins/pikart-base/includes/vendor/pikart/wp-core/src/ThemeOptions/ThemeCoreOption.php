<?php

namespace Pikart\WpCore\ThemeOptions;

if ( ! class_exists( __NAMESPACE__ . '\\CoreThemeOption' ) ) {

	/**
	 * Class CoreThemeOption
	 * @package Pikart\WpCore\ThemeOptions
	 */
	final class ThemeCoreOption {
		const GOOGLE_FONTS = 'google_fonts';
		const GOOGLE_FONT = 'google_font';
		const ADD_GOOGLE_FONT = 'add_google_font';

		const LOGO = 'logo';
		const LOGO_INVERTED = 'logo_inverted';

		const RESET_OPTIONS = 'reset_options';

		const CUSTOM_JS_HEADER = 'custom_js_header';
		const CUSTOM_JS_FOOTER = 'custom_js_footer';

		/**
		 * @since 1.6.0
		 */
		const COPY_PARENT_THEME_OPTIONS = 'copy_parent_theme_options';
	}
}