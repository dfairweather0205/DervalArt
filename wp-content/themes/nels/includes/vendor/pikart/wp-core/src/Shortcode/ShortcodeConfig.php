<?php

namespace Pikart\WpThemeCore\Shortcode;

if ( ! class_exists( __NAMESPACE__ . '\\ShortcodeConfig' ) ) {

	/**
	 * Class ShortcodeConfig
	 * @package Pikart\WpThemeCore\Shortcode
	 */
	class ShortcodeConfig {
		const NAME_PREFIX = 'pkrt_';
		const FONT_FAMILY_LIST_POST_OPTION = 'font_family_list';
	}
}