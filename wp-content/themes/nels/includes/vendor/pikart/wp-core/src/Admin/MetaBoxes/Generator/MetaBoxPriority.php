<?php

namespace Pikart\WpThemeCore\Admin\MetaBoxes\Generator;

if ( ! class_exists( __NAMESPACE__ . '\\MetaBoxPriority' ) ) {

	/**
	 * Class MetaBoxPriority
	 * @package Pikart\WpThemeCore\Admin\MetaBoxes\Generator
	 *
	 * @since 1.3.0
	 */
	final class MetaBoxPriority {
		const HIGH = 'high';
		const CORE = 'core';
		const LOW = 'low';
		const DEFAULT_VAL = 'default';
	}
}