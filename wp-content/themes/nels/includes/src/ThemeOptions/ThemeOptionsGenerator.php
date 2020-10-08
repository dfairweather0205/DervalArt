<?php

namespace Pikart\Nels\ThemeOptions;

use Pikart\Nels\Common\AssetHandle;
use Pikart\WpThemeCore\ThemeOptions\ThemeOptionsFacade;

if ( ! class_exists( __NAMESPACE__ . '\ThemeOptionsGenerator' ) ) {

	/**
	 * Class ThemeOptionsGenerator
	 * @package Pikart\Nels\ThemeOptions
	 */
	class ThemeOptionsGenerator {

		/**
		 * @var ThemeOptionsFacade
		 */
		private $themeOptionsFacade;

		/**
		 * @var CustomThemeOptionsProvider
		 */
		private $customThemeOptionsProvider;

		/**
		 * @var ThemeOptionsJsHelper
		 */
		private $themeOptionsJsHelper;

		/**
		 * @var ThemeOptionsUtil
		 */
		private $themeOptionsUtil;

		/**
		 * ThemeOptionsGenerator constructor.
		 *
		 * @param ThemeOptionsFacade $themeOptionsFacade
		 * @param CustomThemeOptionsProvider $customThemeOptionsProvider
		 * @param ThemeOptionsJsHelper $themeOptionsJsHelper
		 * @param ThemeOptionsUtil $themeOptionsUtil
		 */
		public function __construct(
			ThemeOptionsFacade $themeOptionsFacade,
			CustomThemeOptionsProvider $customThemeOptionsProvider,
			ThemeOptionsJsHelper $themeOptionsJsHelper,
			ThemeOptionsUtil $themeOptionsUtil
		) {
			$this->themeOptionsFacade         = $themeOptionsFacade;
			$this->customThemeOptionsProvider = $customThemeOptionsProvider;
			$this->themeOptionsJsHelper       = $themeOptionsJsHelper;
			$this->themeOptionsUtil           = $themeOptionsUtil;
		}

		public function generate() {
			$this->themeOptionsFacade->loadAdminCssFile(
				AssetHandle::adminThemeCustomizerStyle(), AssetHandle::adminThemeCustomizerRtlStyle() );

			$this->themeOptionsFacade->addCustomizerScriptHandle( AssetHandle::adminThemeCustomizer() );
			$this->themeOptionsFacade->registerThemeOptionsProvider( $this->customThemeOptionsProvider );
			$this->themeOptionsJsHelper->injectHeaderJsConfigForCustomizer();
			$this->themeOptionsUtil->setupPostExcerptLength();
		}
	}
}