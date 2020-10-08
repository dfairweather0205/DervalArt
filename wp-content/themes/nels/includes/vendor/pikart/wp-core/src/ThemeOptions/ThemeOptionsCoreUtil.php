<?php

namespace Pikart\WpThemeCore\ThemeOptions;

use Pikart\WpThemeCore\Common\Env;
use RuntimeException;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeOptionsCoreUtil' ) ) {
	/**
	 * Class ThemeOptionsCoreUtil
	 * @package Pikart\WpThemeCore\ThemeOptions
	 */
	class ThemeOptionsCoreUtil {

		const SECTION_ID_PATTERN = '%s_section_%s';
		const PANEL_ID_PATTERN = '%s_panel_%s';
		const SETTING_ID_PATTERN = '%s_setting_%s';

		/**
		 * @var array
		 */
		private static $controls = array();

		/**
		 * @var array
		 */
		private static $themeOptionsCache = array();

		/**
		 * @var ThemeOptionsCssFilter
		 */
		private $themeOptionsCssFilter;

		/**
		 * ThemeOptionsCoreUtil constructor.
		 *
		 * @param ThemeOptionsCssFilter $themeOptionsCssFilter
		 */
		public function __construct( ThemeOptionsCssFilter $themeOptionsCssFilter ) {
			$this->themeOptionsCssFilter = $themeOptionsCssFilter;
		}

		/**
		 * @param array $wpOptions
		 */
		public function initWpOptions( array $wpOptions ) {
			self::$controls = array_merge( self::$controls, $wpOptions );
		}

		/**
		 * @param array $customizations
		 */
		public function initControls( array $customizations ) {
			$sections = isset( $customizations['sections'] ) ? $customizations['sections'] : array();

			if ( isset( $customizations['panels'] ) ) {
				foreach ( $customizations['panels'] as $panel ) {
					if ( isset( $panel['sections'] ) ) {
						$sections = array_merge( $sections, $panel['sections'] );
					}
				}
			}

			foreach ( $sections as $section ) {
				if ( isset( $section['controls'] ) ) {
					foreach ( $section['controls'] as $control ) {
						self::$controls[ $control['id'] ] = $control;
					}
				}
			}

			$this->registerWebFonts();
		}

		/**
		 * @param string $id
		 * @param mixed $defaultValue @since 1.5.0
		 *
		 * @return string|array
		 */
		public function getOption( $id, $defaultValue = null ) {
			if ( isset( self::$themeOptionsCache[ $id ] ) ) {
				return self::$themeOptionsCache[ $id ];
			}

			if ( null === $defaultValue ) {
				$defaultValue = $this->getOptionDefaultValue( $id );
			}

			$option = $this->filterOption( $id, get_theme_mod( $this->buildSettingId( $id ), $defaultValue ) );

			$this->cacheOption( $id, $option );

			return $option;
		}

		/**
		 * @param string $id
		 * @param mixed $defaultValue @since 1.5.0
		 *
		 * @return bool
		 */
		public function getBoolOption( $id, $defaultValue = null ) {
			return (bool) $this->getOption( $id, $defaultValue );
		}

		/**
		 * @param string $id
		 * @param mixed $defaultValue @since 1.5.0
		 *
		 * @return int
		 */
		public function getIntOption( $id, $defaultValue = null ) {
			return (int) $this->getOption( $id, $defaultValue );
		}

		/**
		 * @param string $id
		 *
		 * @return string
		 */
		public function buildSettingId( $id ) {
			return isset( self::$controls[ $id ]['built-in'] ) && self::$controls[ $id ]['built-in']
				? $id : sprintf( self::SETTING_ID_PATTERN, PIKART_THEME_SLUG, $id );
		}

		/**
		 * @param string $id
		 *
		 * @return string
		 */
		public function buildPanelId( $id ) {
			return sprintf( self::PANEL_ID_PATTERN, PIKART_THEME_SLUG, $id );
		}

		/**
		 * @param string $id
		 *
		 * @return string
		 */
		public function buildSectionId( $id ) {
			return sprintf( self::SECTION_ID_PATTERN, PIKART_THEME_SLUG, $id );
		}

		/**
		 * @return array
		 */
		public function getCustomizedJs() {
			$jsData = array(
				'style'            => array(),
				'text'             => array(),
				'htmlAllowedItems' => array(),
				'cssFilters'       => array(),
				'fontFamily'       => array(),
				'htmlAttributes'   => array()
			);

			$addJsData = function ( $control, $controlAttribute, $jsOption, $settingId, &$jsData ) {
				if ( isset( $control[ $controlAttribute ] ) ) {
					$jsData[ $jsOption ][ $settingId ] = $control[ $controlAttribute ];
				}
			};

			foreach ( self::$controls as $controlId => $control ) {
				$settingId = $this->buildSettingId( $controlId );

				$addJsData( $control, 'css', 'style', $settingId, $jsData );
				$addJsData( $control, 'css_items', 'text', $settingId, $jsData );
				$addJsData( $control, 'css_filter', 'cssFilters', $settingId, $jsData );
				$addJsData( $control, 'html_attributes', 'htmlAttributes', $settingId, $jsData );

				if ( isset( $control['type'] ) && ThemeOptionsControlType::FONT_FAMILY === $control['type'] ) {
					$jsData['fontFamily'][] = $control['id'];
				}

				if ( isset( $control['html_allowed'] ) && $control['html_allowed'] ) {
					$jsData['htmlAllowedItems'][] = $settingId;
				}
			}

			return $jsData;
		}

		/**
		 * @return string
		 */
		public function getCustomizedCss() {
			$styleData = array();

			foreach ( self::$controls as $controlId => $control ) {
				if ( ! isset( $control['css'] ) && ! isset( $control['css_callback'] ) ) {
					continue;
				}

				$cssFilter = isset( $control['css_filter'] ) ? $control['css_filter'] : null;
				$option    = $this->themeOptionsCssFilter->filter( $this->getOption( $controlId ), $cssFilter );

				if ( isset( $control['css'] ) ) {
					foreach ( $control['css'] as $cssProperty => $cssElements ) {
						$styleData[] = $this->getCssString( $cssElements, $cssProperty, $option );
					}
				}

				if ( isset( $control['css_callback'] ) && is_callable( $control['css_callback'] ) ) {
					$items = $control['css_callback']( $option, $this );

					foreach ( $items as $cssProperty => $cssElements ) {
						$styleData[] = $this->getSimpleCssString( $cssElements, $cssProperty );
					}
				}
			}

			return implode( PHP_EOL, $styleData );
		}

		public function executeControlsActions() {
			$controls = &self::$controls;
			$self     = $this;

			add_action( 'wp_loaded', function () use ( &$controls, $self ) {
				foreach ( $controls as $controlId => $control ) {
					if ( isset( $control['action'] ) && is_callable( $control['action'] ) ) {
						$control['action']( $self->getOption( $controlId ), $self );
					}
				}
			} );
		}

		/**
		 * @param string $optionId
		 * @param string $value
		 *
		 * @return bool
		 */
		public function multiValueOptionHasValue( $optionId, $value ) {
			$option = $this->getOption( $optionId );

			return ! empty( $option ) && in_array( $value, $option, true );
		}

		/**
		 * @return array
		 */
		public function getResetOptionsJsConfig() {
			return array(
				'nonce'          => wp_create_nonce( $this->getResetOptionsNonceAction() ),
				'confirmMessage' => esc_html__(
					'Are you sure you want to reset all theme customizations?', 'nels' ),
			);
		}

		public function registerResetOptionsAjax() {
			$nonceAction = $this->getResetOptionsNonceAction();

			add_action( 'wp_ajax_' . PIKART_SLUG . '_reset_options', function () use ( $nonceAction ) {

				if ( ! check_ajax_referer( $nonceAction, 'nonce', false ) ) {
					wp_send_json_error();
				}

				remove_theme_mods();

				wp_send_json_success();
			} );
		}

		/**
		 * @since 1.6.0
		 */
		public function registerCopyParentThemeOptionsAjax() {
			$nonceAction = $this->getCopyParentThemeOptionsNonceAction();

			add_action( 'wp_ajax_' . PIKART_SLUG . '_copy_parent_theme_options', function () use ( $nonceAction ) {

				if ( ! is_child_theme() || ! check_ajax_referer( $nonceAction, 'nonce', false ) ) {
					wp_send_json_error();
				}

				$parentThemeSlug    = get_option( 'template' );
				$parentThemeOptions = get_option( 'theme_mods_' . $parentThemeSlug );

				if ( false === $parentThemeOptions ) {
					wp_send_json_success();
				}

				$themeSlug    = get_option( 'stylesheet' );
				$themeOptions = get_option( 'theme_mods_' . $themeSlug );

				if ( false !== $themeOptions ) {
					update_option( sprintf( 'theme_mods_%s_backup', $themeSlug ), $themeOptions );
				}

				update_option( 'theme_mods_' . $themeSlug, $parentThemeOptions );

				wp_send_json_success();
			} );
		}

		/**
		 * @since 1.6.0
		 *
		 * @return array
		 */
		public function getCopyParentThemeOptionsJsConfig() {
			return array(
				'nonce'          => wp_create_nonce( $this->getCopyParentThemeOptionsNonceAction() ),
				'confirmMessage' => esc_html__(
					'Are you sure you want to copy all parent theme customizations? This will override all the child theme customizer options?',
					'nels'
				),
			);
		}

		/**
		 * @param string $id
		 * @param mixed $value
		 *
		 * @since 1.5.0
		 *
		 * @return mixed
		 */
		private function filterOption( $id, $value ) {
			if ( ! isset( self::$controls[ $id ] ) ) {
				return $value;
			}

			$control = self::$controls[ $id ];

			if ( ( isset( $control['type'] ) && ThemeOptionsControlType::COLOR === $control['type'] )
			     || ( isset( $control['css_filter'] ) && ThemeOptionsCssFilter::COLOR === $control['css_filter'] ) ) {
				return $this->themeOptionsCssFilter->color( $value );
			}

			return $value;
		}

		/**
		 * @return string
		 */
		private function getResetOptionsNonceAction() {
			return PIKART_SLUG . '-reset-options';
		}

		/**
		 * @since 1.6.0
		 *
		 * @return string
		 */
		private function getCopyParentThemeOptionsNonceAction() {
			return PIKART_SLUG . '-copy-parent-theme-options';
		}

		private function registerWebFonts() {
			$fonts = array();

			foreach ( self::$controls as $id => $control ) {

				if ( ! isset( $control['type'] ) || ThemeOptionsControlType::FONT_FAMILY !== $control['type'] ) {
					continue;
				}

				$font = $this->getOption( $id );

				if ( ! empty( $font ) ) {
					$fonts[] = $font;
				}
			}

			add_filter( ThemeOptionsFilterName::registeredGoogleFonts(), function ( $fontList ) use ( $fonts ) {
				return array_merge( $fontList, $fonts );
			} );
		}

		/**
		 * @param array $cssElements
		 * @param string $cssProperty
		 * @param string $cssValue
		 *
		 * @return string
		 */
		private function getCssString( array $cssElements, $cssProperty, $cssValue ) {
			$cssElementsString = implode( ', ', $cssElements );

			if ( strpos( $cssProperty, ThemeCoreOptionsConfig::OPTION_DELIMITER ) !== false ) {
				//Ex: $cssProperty = background-image: linear-gradient(to right, __OPTION__ 50%, #ffffff 50%)
				return $this->getSimpleCssString(
					$cssElements, str_replace( ThemeCoreOptionsConfig::OPTION_DELIMITER, $cssValue, $cssProperty ) );
			}

			return sprintf(
				'%s {%s: %s}',
				$cssElementsString,
				$cssProperty,
				$cssValue );
		}

		/**
		 * @param array|string $cssElements
		 * @param string $cssProperty
		 *
		 * @return string
		 */
		private function getSimpleCssString( $cssElements, $cssProperty ) {
			$cssElementsString = is_array( $cssElements ) ? implode( ', ', $cssElements ) : $cssElements;

			return sprintf(
				'%s {%s}',
				$cssElementsString,
				$cssProperty );
		}

		/**
		 * @param string $option
		 *
		 * @return mixed
		 */
		private function getOptionDefaultValue( $option ) {
			if ( empty ( self::$controls ) && Env::isPikartThemeActive() && ( Env::isDev() || Env::isStage() ) ) {
				throw new RuntimeException( 'Theme Options Controls not yet initialized, option: ' . $option );
			}

			if ( ! isset( self::$controls[ $option ] ) ) {
				return null;
			}

			$control = self::$controls[ $option ];

			return isset( $control['default'] )
				? $control['default']
				: ( $control['type'] === ThemeOptionsControlType::CHECKBOX_MULTIPLE ? array() : false );
		}

		/**
		 * @param string $id
		 * @param mixed $value
		 */
		private function cacheOption( $id, $value ) {
			// do not cache when using customizer
			if ( isset( $_REQUEST['customize_changeset_uuid'] ) ) {
				return;
			}

			self::$themeOptionsCache[ $id ] = $value;
		}
	}
}