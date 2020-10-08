<?php

namespace Pikart\Nels\Post\Options;

use Pikart\Nels\Post\Options\Type\CommonPostOptions;
use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\Nels\ThemeOptions\ThemeOptionsUtil;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxFilterName;
use Pikart\WpThemeCore\Post\Options\PostOptionsConfigRegister;
use Pikart\WpThemeCore\Post\PostFilterName;
use Pikart\WpThemeCore\ThemeOptions\WpOption;

if ( ! class_exists( __NAMESPACE__ . '\\PostOptionsConfigInitializer' ) ) {

	/**
	 * Class PostOptionsConfigInitializer
	 * @package Pikart\Nels\Post\Options
	 */
	class PostOptionsConfigInitializer {

		/**
		 * @var ThemeOptionsUtil
		 */
		private $themeOptionsUtil;

		/**
		 * @var PostOptionsConfigRegister
		 */
		private $postOptionsConfigRegister;

		/**
		 * @var PostOptionsConfigProvider
		 */
		private $postOptionsConfigProvider;

		/**
		 * PostOptionsConfigInitializer constructor.
		 *
		 * @param PostOptionsConfigRegister $postOptionsConfigRegister
		 * @param PostOptionsConfigProvider $postOptionsConfigProvider
		 * @param ThemeOptionsUtil $themeOptionsUtil
		 */
		public function __construct(
			PostOptionsConfigRegister $postOptionsConfigRegister,
			PostOptionsConfigProvider $postOptionsConfigProvider,
			ThemeOptionsUtil $themeOptionsUtil
		) {
			$this->themeOptionsUtil          = $themeOptionsUtil;
			$this->postOptionsConfigRegister = $postOptionsConfigRegister;
			$this->postOptionsConfigProvider = $postOptionsConfigProvider;
		}

		public function initialize() {
			$this->customizeGeneralOptions();
			$this->initPostOptionsConfig();
		}

		private function initPostOptionsConfig() {
			$postOptionsConfigList = $this->postOptionsConfigProvider->getPostOptionsConfigList();

			foreach ( $postOptionsConfigList as $postOptionsConfig ) {
				$this->postOptionsConfigRegister->register( $postOptionsConfig );
			}
		}

		private function customizeGeneralOptions() {

			$postToThemeOptions = array(
				CommonPostOptions::SITE_WIDTH              => ThemeOption::SITE_WIDTH,
				CommonPostOptions::SITE_HEADER_ABOVE_AREA  => ThemeOption::HEADER_ABOVE_AREA_ENABLED,
				CommonPostOptions::FEATURED_BRANDING       => ThemeOption::FEATURED_BRANDING_ENABLED,
				CommonPostOptions::SITE_CONTENT_SIDEBAR    => ThemeOption::CONTENT_SIDEBAR_ENABLED,
				CommonPostOptions::SITE_CONTENT_BACKGROUND => WpOption::WP_BACKGROUND_COLOR,
				CommonPostOptions::SITE_FOOTER_SIDEBAR     => ThemeOption::FOOTER_SIDEBAR_ENABLED,
				CommonPostOptions::SITE_FOOTER_BELOW_AREA  => ThemeOption::FOOTER_BELOW_AREA_ENABLED,
			);

			foreach ( $postToThemeOptions as $postOption => $themeOption ) {
				$this->setPostOptionMetaBoxDefaultValue(
					$postOption, $themeOption, PostOptionsMetaBoxId::COMMON_OPTIONS );
				$this->setPostOptionDefaultValue( $postOption, $themeOption );
			}
		}

		/**
		 * @param string $postOption
		 * @param string $themeOption
		 * @param string $metaBoxId
		 */
		private function setPostOptionMetaBoxDefaultValue( $postOption, $themeOption, $metaBoxId ) {
			$themeOptionsUtil = $this->themeOptionsUtil;

			add_filter( MetaBoxFilterName::fieldConfig( $metaBoxId, $postOption ),
				function ( $settings ) use ( $themeOptionsUtil, $themeOption ) {
					$settings['default'] = $themeOptionsUtil->getOption( $themeOption );

					return $settings;
				}
			);
		}

		/**
		 * @param $postOption
		 * @param $themeOption
		 */
		private function setPostOptionDefaultValue( $postOption, $themeOption ) {
			$themeOptionsUtil = $this->themeOptionsUtil;

			add_filter( PostFilterName::postOptionDefaultValue( $postOption ),
				function () use ( $themeOptionsUtil, $themeOption ) {
					return $themeOptionsUtil->getOption( $themeOption );
				}, 15
			);
		}
	}

}