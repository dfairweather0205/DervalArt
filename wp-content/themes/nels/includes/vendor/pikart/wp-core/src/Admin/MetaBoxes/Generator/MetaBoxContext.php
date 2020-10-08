<?php

namespace Pikart\WpThemeCore\Admin\MetaBoxes\Generator;

if ( ! class_exists( __NAMESPACE__ . '\\MetaBoxContext' ) ) {

	/**
	 * Class MetaBoxContext
	 * @package Pikart\WpThemeCore\Admin\MetaBoxes\Generator
	 *
	 * @since 1.3.0
	 */
	final class MetaBoxContext {
		const NORMAL = 'normal';
		const SIDE = 'side';
		const ADVANCED = 'advanced';
	}
}