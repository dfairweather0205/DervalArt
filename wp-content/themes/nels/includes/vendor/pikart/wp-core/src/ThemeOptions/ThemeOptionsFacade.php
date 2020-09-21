<?php

namespace Pikart\WpThemeCore\ThemeOptions;

use Pikart\WpThemeCore\Common\CoreAssetHandle;
use Pikart\WpThemeCore\Common\Util;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeOptionsFacade' ) ) {

	/**
	 * Class ThemeOptionsFacade
	 * @package Pikart\WpThemeCore\ThemeOptions
	 */
	class ThemeOptionsFacade {

		/**
		 * @var ThemeOptionsCoreUtil
		 */
		private $themeOptionsCoreUtil;

		/**
		 * @var ThemeOptionsBuilder
		 */
		private $themeOptionsBuilder;

		/**
		 * @var ThemeOptionsProvider
		 */
		private $themeOptionsProvider;

		/**
		 * @var array
		 */
		private $customizerScriptHandles = array();

		/**
		 * ThemeOptionsFacade constructor.
		 *
		 * @param ThemeOptionsCoreUtil $themeOptionsCoreUtil
		 * @param ThemeOptionsBuilder $themeOptionsBuilder
		 */
		public function __construct(
			ThemeOptionsCoreUtil $themeOptionsCoreUtil, ThemeOptionsBuilder $themeOptionsBuilder
		) {
			$this->themeOptionsCoreUtil = $themeOptionsCoreUtil;
			$this->themeOptionsBuilder  = $themeOptionsBuilder;

			$this->addCustomizerScriptHandle( CoreAssetHandle::adminCoreCustomizer() );
		}

		/**
		 * @param ThemeOptionsProvider $optionsProvider
		 */
		public function registerThemeOptionsProvider( ThemeOptionsProvider $optionsProvider ) {
			$this->themeOptionsProvider = $optionsProvider;

			$this->initOptions();
			$this->registerCustomOptions();
			$this->registerWpOptions();
			$this->enqueueScripts();
			$this->customizerPreviewInit();
			$this->addInlineJs();
			$this->themeOptionsCoreUtil->executeControlsActions();
			$this->themeOptionsCoreUtil->registerResetOptionsAjax();
			$this->localizeCustomizerData();

			if ( is_child_theme() ) {
				$this->themeOptionsCoreUtil->registerCopyParentThemeOptionsAjax();
			}
		}

		/**
		 * @param $handle
		 */
		public function addCustomizerScriptHandle( $handle ) {
			$this->customizerScriptHandles[] = $handle;
		}

		/**
		 * @param $handle
		 * @param $rtlHandle
		 */
		public function loadAdminCssFile( $handle, $rtlHandle = null ) {
			add_action( 'customize_controls_print_styles', function () use ( $handle, $rtlHandle ) {
				wp_enqueue_style( $handle );

				if ( is_rtl() && $rtlHandle ) {
					wp_enqueue_style( $rtlHandle );
				}
			} );
		}

		private function initOptions() {
			$optionsProvider      = $this->themeOptionsProvider;
			$themeOptionsCoreUtil = $this->themeOptionsCoreUtil;

			// priority 9 is used because it needs to be initialized before customize_preview_init action
			add_action( 'wp_loaded', function () use ( $optionsProvider, $themeOptionsCoreUtil ) {
				$options = $optionsProvider->getThemeOptions();

				$options->setCustomOptions(
					apply_filters( ThemeOptionsFilterName::themeCustomOptionsConfig(), $options->getCustomOptions() ) );

				$options->setWpOptions(
					apply_filters( ThemeOptionsFilterName::themeWpOptionsConfig(), $options->getWpOptions() ) );

				$themeOptionsCoreUtil->initControls( $options->getCustomOptions() );
				$themeOptionsCoreUtil->initWpOptions( $options->getWpOptions() );
			}, 9 );
		}

		private function localizeCustomizerData() {
			$themeOptionsProvider = $this->themeOptionsProvider;

			add_action( 'wp_enqueue_scripts', function () use ( $themeOptionsProvider ) {
				wp_localize_script( CoreAssetHandle::customScript(),
					PIKART_SLUG . 'ThemeCustomOptions', $themeOptionsProvider->getOptionsForCustomJs() );
			} );
		}

		private function registerCustomOptions() {
			$themeOptionsBuilder = $this->themeOptionsBuilder;
			$optionsProvider     = $this->themeOptionsProvider;

			$this->customizerRegister( function () use ( $optionsProvider, $themeOptionsBuilder ) {
				$themeOptionsBuilder->build( $optionsProvider->getThemeOptions()->getCustomOptions() );
			} );
		}

		private function registerWpOptions() {
			$optionsProvider = $this->themeOptionsProvider;

			$this->customizerRegister( function ( \WP_Customize_Manager $wpCustomizeManager ) use ( $optionsProvider ) {
				foreach ( $optionsProvider->getThemeOptions()->getWpOptions() as $option ) {
					$wpCustomizeManager->get_setting( $option['id'] )->transport = isset( $option['transport'] )
						? $option['transport'] : ThemeCoreOptionsConfig::DEFAULT_CONTROL_TRANSPORT_TYPE;
				}
			} );
		}

		/**
		 * @param \Closure $callback
		 */
		private function customizerRegister( \Closure $callback ) {
			add_action( 'customize_register', $callback, 11 );
		}

		private function enqueueScripts() {
			$themeOptionsUtils = $this->themeOptionsCoreUtil;
			add_action( 'wp_enqueue_scripts', function () use ( $themeOptionsUtils ) {
				wp_add_inline_style( Util::getThemeStyleHandle(), $themeOptionsUtils->getCustomizedCss() );
			}, 11 );
		}

		private function customizerPreviewInit() {
			$themeOptionsCoreUtil    = $this->themeOptionsCoreUtil;
			$customizerScriptHandles = $this->customizerScriptHandles;
			$optionsProvider         = $this->themeOptionsProvider;

			add_action( 'customize_preview_init', function () use (
				$themeOptionsCoreUtil, $customizerScriptHandles, $optionsProvider
			) {
				foreach ( $customizerScriptHandles as $scriptHandle ) {
					wp_enqueue_script( $scriptHandle );
				}

				$customizerData = array(
					'optionsConfig'                => $themeOptionsCoreUtil->getCustomizedJs(),
					'itemSlug'                     => PIKART_THEME_SLUG,
					'settingIdPrefix'              => sprintf(
						ThemeOptionsCoreUtil::SETTING_ID_PATTERN, PIKART_THEME_SLUG, '' ),
					'sectionIdPrefix'              => sprintf(
						ThemeOptionsCoreUtil::SECTION_ID_PATTERN, PIKART_THEME_SLUG, '' ),
					'resetOptionsConfig'           => $themeOptionsCoreUtil->getResetOptionsJsConfig(),
					'copyParentThemeOptionsConfig' => $themeOptionsCoreUtil->getCopyParentThemeOptionsJsConfig(),
					'googleFontNonceAction'        => wp_create_nonce( GoogleFontsHelper::ADD_FONT_NONCE_ACTION ),
					'optionDelimiter'              => ThemeCoreOptionsConfig::OPTION_DELIMITER
				);

				wp_localize_script(
					CoreAssetHandle::adminCoreCustomizer(),
					PIKART_SLUG . 'CustomizerData',
					apply_filters( ThemeOptionsFilterName::customizerJsData(),
						$customizerData, $optionsProvider->getThemeOptions() )
				);
			} );
		}

		private function addInlineJs() {
			$themeOptionsCoreUtil = $this->themeOptionsCoreUtil;

			$replaceScriptTag = function ( $content ) {
				return trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $content ) );
			};

			add_action( 'wp_enqueue_scripts', function () use ( $replaceScriptTag, $themeOptionsCoreUtil ) {
				$js = $replaceScriptTag( $themeOptionsCoreUtil->getOption( ThemeCoreOption::CUSTOM_JS_FOOTER ) );

				if ( empty( $js ) ) {
					return;
				}

				wp_add_inline_script( CoreAssetHandle::customScript(), $js );
			} );

			add_action( 'wp_head', function () use ( $replaceScriptTag, $themeOptionsCoreUtil ) {
				$js = $replaceScriptTag( $themeOptionsCoreUtil->getOption( ThemeCoreOption::CUSTOM_JS_HEADER ) );

				if ( empty( $js ) ) {
					return;
				}

				printf( "<script type='text/javascript'>\n%s\n</script>\n", $js );
			}, 999 );
		}
	}
}