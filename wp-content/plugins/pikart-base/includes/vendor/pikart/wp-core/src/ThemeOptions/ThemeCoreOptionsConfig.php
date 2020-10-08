<?php

namespace Pikart\WpCore\ThemeOptions;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeCoreOptionsConfig' ) ) {
	/**
	 * Class ThemeCoreOptionsConfig
	 * @package Pikart\WpCore\ThemeOptions
	 */
	final class ThemeCoreOptionsConfig {
		const PERSIST_SETTING_DEFAULT = true;
		const CONTROL_TRANSPORT_TYPE_REFRESH = 'refresh';
		const CONTROL_TRANSPORT_TYPE_POST_MESSAGE = 'postMessage';
		const DEFAULT_CONTROL_TRANSPORT_TYPE = self::CONTROL_TRANSPORT_TYPE_REFRESH;
		const FALLBACK_FONT_FAMILY = 'PT Sans, sans-serif';
		const OPTION_DELIMITER = '__OPTION__';
	}
}