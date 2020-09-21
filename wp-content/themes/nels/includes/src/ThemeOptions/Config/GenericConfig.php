<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\Misc\TemplatesUtil;
use Pikart\Nels\ThemeOptions\ThemeOptionsUtil;
use Pikart\WpThemeCore\Common\ThemeUtil;
use Pikart\WpThemeCore\Common\Util;
use Pikart\WpThemeCore\ThemeOptions\ConfigBuilder\ControlConfigBuilder;
use Pikart\WpThemeCore\ThemeOptions\ThemeCoreOptionsConfig;
use Pikart\WpThemeCore\ThemeOptions\ThemeOptionsConfigHelper;

if ( ! class_exists( __NAMESPACE__ . '\GenericConfig' ) ) {

	/**
	 * Class GenericConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	abstract class GenericConfig {

		const DELIMITER = ThemeCoreOptionsConfig::OPTION_DELIMITER;

		/**
		 * @var ControlConfigBuilder
		 */
		protected $controlConfigBuilder;

		/**
		 * @var ThemeOptionsUtil
		 */
		protected $themeOptionsUtil;

		/**
		 * @var ThemeOptionsConfigHelper
		 */
		protected $configHelper;

		/**
		 * @var TemplatesUtil
		 */
		protected $templatesUtil;

		/**
		 * @var ThemeUtil
		 */
		protected $themeUtil;

		/**
		 * @var Util
		 */
		protected $util;

		/**
		 * GenericConfig constructor.
		 *
		 * @param ControlConfigBuilder $controlConfigBuilder
		 * @param ThemeOptionsUtil $themeOptionsUtil
		 * @param ThemeOptionsConfigHelper $configHelper
		 * @param TemplatesUtil $templatesUtil
		 * @param ThemeUtil $themeUtil
		 * @param Util $util
		 */
		public function __construct(
			ControlConfigBuilder $controlConfigBuilder,
			ThemeOptionsUtil $themeOptionsUtil,
			ThemeOptionsConfigHelper $configHelper,
			TemplatesUtil $templatesUtil,
			ThemeUtil $themeUtil,
			Util $util
		) {
			$this->controlConfigBuilder = $controlConfigBuilder;
			$this->themeOptionsUtil     = $themeOptionsUtil;
			$this->configHelper         = $configHelper;
			$this->templatesUtil        = $templatesUtil;
			$this->themeUtil            = $themeUtil;
			$this->util                 = $util;
		}

		/**
		 * @return array
		 */
		abstract public function getConfig();
	}
}