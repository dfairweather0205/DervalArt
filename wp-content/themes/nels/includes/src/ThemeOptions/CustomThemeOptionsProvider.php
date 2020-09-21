<?php

namespace Pikart\Nels\ThemeOptions;

use Pikart\Nels\ThemeOptions\Config\ThemeOptionsConfigBase;
use Pikart\WpThemeCore\ThemeOptions\ConfigBuilder\ThemeOptions;
use Pikart\WpThemeCore\ThemeOptions\ThemeOptionsProvider;

if ( ! class_exists( __NAMESPACE__ . '\CustomThemeOptionsProvider' ) ) {

	/**
	 * Class CustomThemeOptionsProvider
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class CustomThemeOptionsProvider implements ThemeOptionsProvider {

		/**
		 * @var ThemeOptions
		 */
		private $themeOptions;

		/**
		 * @var ThemeOptionsConfigBase
		 */
		private $themeOptionsConfigBase;

		/**
		 * @var ThemeOptionsJsHelper
		 */
		private $themeOptionsJsHelper;

		/**
		 * ThemeOptionsConfig constructor.
		 *
		 * @param ThemeOptionsConfigBase $themeOptionsConfigBase
		 * @param ThemeOptionsJsHelper $themeOptionsJsHelper
		 */
		public function __construct(
			ThemeOptionsConfigBase $themeOptionsConfigBase,
			ThemeOptionsJsHelper $themeOptionsJsHelper
		) {
			$this->themeOptionsConfigBase = $themeOptionsConfigBase;
			$this->themeOptionsJsHelper   = $themeOptionsJsHelper;
		}

		/**
		 * @inheritdoc
		 */
		public function getOptionsForCustomJs() {
			return $this->themeOptionsJsHelper->getOptionsForCustomJs();
		}

		/**
		 * @inheritdoc
		 */
		public function getThemeOptions() {
			if ( null === $this->themeOptions ) {
				$this->themeOptions = $this->themeOptionsConfigBase->buildThemeOptions();
			}

			return $this->themeOptions;
		}
	}
}