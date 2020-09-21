<?php

namespace Pikart\WpThemeCore\Admin\MetaBoxes;

use Pikart\WpThemeCore\Post\PostUtil;
use Pikart\WpThemeCore\ThemeOptions\ThemeCoreOptionsConfig;
use Pikart\WpThemeCore\ThemeOptions\ThemeOptionsCssFilter;

if ( ! class_exists( __NAMESPACE__ . '\\MetaBoxCustomizedCssGenerator' ) ) {
	/**
	 * Class MetaBoxCustomizedCssGenerator
	 *
	 * @since 1.8.0
	 *
	 * @package Pikart\WpThemeCore\Admin\MetaBoxes
	 */
	class MetaBoxCustomizedCssGenerator {

		/**
		 * @var PostUtil
		 */
		private $postUtil;

		/**
		 * @var ThemeOptionsCssFilter
		 */
		private $themeOptionsCssFilter;


		/**
		 * MetaBoxCustomizedCssGenerator constructor.
		 *
		 * @param PostUtil $postUtil
		 * @param ThemeOptionsCssFilter $themeOptionsCssFilter
		 */
		public function __construct( PostUtil $postUtil, ThemeOptionsCssFilter $themeOptionsCssFilter ) {
			$this->postUtil              = $postUtil;
			$this->themeOptionsCssFilter = $themeOptionsCssFilter;
		}

		/**
		 * @param array $metaBoxesConfig
		 *
		 * @return string
		 */
		public function generate( array $metaBoxesConfig ) {
			$options   = $this->postUtil->getOptions( get_the_ID() );
			$styleData = array();

			foreach ( $metaBoxesConfig as $metaBoxConfig ) {
				foreach ( $metaBoxConfig['fields'] as $fieldConfig ) {
					if ( MetaBoxConfigBuilder::TAB === $fieldConfig['type'] ) {
						foreach ( $fieldConfig['fields'] as $tabFieldConfig ) {
							$this->getFieldCustomizedCss( $tabFieldConfig, $options, $styleData );
						}
					} else {
						$this->getFieldCustomizedCss( $fieldConfig, $options, $styleData );
					}
				}
			}

			return implode( PHP_EOL, $styleData );
		}

		/**
		 * @param array $fieldConfig
		 * @param array $options
		 * @param array $styleData
		 */
		private function getFieldCustomizedCss( $fieldConfig, $options, &$styleData ) {
			if ( ! isset( $fieldConfig['css'] ) && ! isset( $fieldConfig['css_callback'] ) ) {
				return;
			}

			$fieldId = str_replace( MetaBoxConfigBuilder::DB_PREFIX, '', $fieldConfig['id'] );

			if ( empty( $options[ $fieldId ] ) ) {
				return;
			}

			$cssFilter = isset( $fieldConfig['css_filter'] ) ? $fieldConfig['css_filter'] : null;
			$option    = $this->themeOptionsCssFilter->filter( $options[ $fieldId ], $cssFilter );

			if ( isset( $fieldConfig['css'] ) ) {
				foreach ( $fieldConfig['css'] as $cssProperty => $cssElements ) {
					$styleData[] = $this->getCssString( $cssElements, $cssProperty, $option );
				}
			}

			if ( isset( $fieldConfig['css_callback'] ) && is_callable( $fieldConfig['css_callback'] ) ) {
				$items = $fieldConfig['css_callback']( $option );

				foreach ( $items as $cssProperty => $cssElements ) {
					$styleData[] = $this->getSimpleCssString( $cssElements, $cssProperty );
				}
			}
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
	}
}
