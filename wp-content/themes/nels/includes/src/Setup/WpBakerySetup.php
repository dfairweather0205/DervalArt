<?php

namespace Pikart\Nels\Setup;

use Pikart\WpThemeCore\WpBakery\WpBakeryUtil;

if ( ! class_exists( __NAMESPACE__ . '\\WpBakerySetup' ) ) {

	/**
	 * Class WpBakerySetup
	 * @package Pikart\Nels\Setup
	 */
	class WpBakerySetup {

		public function run() {
			if ( WpBakeryUtil::isWpBakeryActivated() ) {
				WpBakeryUtil::setupContentFilterWhenFrontendEditorEnabled();
			}
		}
	}
}
