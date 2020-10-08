<?php

namespace Pikart\WpBase\Admin\Media\WpGallery;

use Pikart\WpCore\Common\Util;

if ( ! class_exists( __NAMESPACE__ . '\WpGalleryShortcodeContentFilter' ) ) {

	/**
	 * Class WpGalleryShortcodeContentFilter
	 * @package Pikart\WpCore\Admin\Media
	 */
	class WpGalleryShortcodeContentFilter {

		const GALLERY_SHORTCODE_NAME = 'gallery';

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * WpGalleryShortcodeContentFilter constructor.
		 *
		 * @param Util $util
		 */
		public function __construct( Util $util ) {
			$this->util = $util;
		}

		/**
		 * @param string $output
		 * @param array  $attributes
		 *
		 * @return string
		 */
		public function filter( $output, $attributes ) {
			$columnsSpacing = $this->getColumnsSpacing( $attributes );

			$output = $this->setGalleryMargins( $output, $columnsSpacing );
			$output = $this->setColumnsSpacingClassForMobile( $output, $columnsSpacing );

			return $this->setImagesPaddings( $output, $columnsSpacing );
		}

		/**
		 * @param $attributes
		 *
		 * @return int
		 */
		private function getColumnsSpacing( $attributes ) {
			$columnsSpacingConfig = WpGalleryConfig::getColumnsSpacingConfig();

			if ( isset( $attributes[ WpGalleryConfig::COLUMNS_SPACING_SETTING ] ) ) {
				return $this->util->getValidNumberInRange(
					$attributes[ WpGalleryConfig::COLUMNS_SPACING_SETTING ],
					$columnsSpacingConfig['minimum'],
					$columnsSpacingConfig['maximum']
				);
			}

			return $columnsSpacingConfig['default'];
		}

		/**
		 * @param string $output
		 * @param int    $columnsSpacing
		 *
		 * @return mixed
		 */
		private function setImagesPaddings( $output, $columnsSpacing ) {
			$imagesPaddings             = sprintf( 'padding-right: %1$spx; padding-bottom: %1$dpx;', $columnsSpacing );
			$addStylePropertiesCallback = $this->addStylePropertiesCallback();

			$replaceCallback = function ( $matches ) use ( $imagesPaddings, $addStylePropertiesCallback ) {
				return '<' . $matches[1] . $addStylePropertiesCallback( $matches[2], $imagesPaddings ) . '>';
			};

			return preg_replace_callback( '/\<(figure|dl)([^\>]*)\>/i', $replaceCallback, $output );
		}

		/**
		 * @param string $output
		 * @param int    $columnsSpacing
		 *
		 * @return string
		 */
		private function setColumnsSpacingClassForMobile( $output, $columnsSpacing ) {
			$addCssClassesCallback        = $this->addCssClassesCallback();
			$columnsSpacingClassForMobile = $this->getColumnsSpacingCssClassForMobile( $columnsSpacing );

			$replaceCallback = function ( $matches ) use ( $addCssClassesCallback, $columnsSpacingClassForMobile ) {
				return $addCssClassesCallback( $matches[0], $columnsSpacingClassForMobile );
			};

			return preg_replace_callback(
				'/<div[^>]*\s+class\s*=\s*[\'""]\s*gallery\s+[^>]+/i', $replaceCallback, $output );
		}

		/**
		 * @return \Closure
		 */
		private function addCssClassesCallback() {
			return function ( $text, $cssClasses ) {
				if ( preg_match( '/(class\s*=[\"\'])/', $text, $result ) ) {
					return str_replace( $result[1], $result[1] . $cssClasses . ' ', $text );
				}

				return $text . sprintf( ' class="%s"', $cssClasses );
			};
		}

		/**
		 * @param string $output
		 * @param int    $columnsSpacing
		 *
		 * @return string
		 */
		private function setGalleryMargins( $output, $columnsSpacing ) {
			$galleryMargins             = sprintf( 'margin-right: %dpx;', - $columnsSpacing );
			$addStylePropertiesCallback = $this->addStylePropertiesCallback();

			$replaceCallback = function ( $matches ) use ( $addStylePropertiesCallback, $galleryMargins ) {
				return $addStylePropertiesCallback( $matches[0], $galleryMargins );
			};

			return preg_replace_callback(
				'/<[div|ul][^>]*\s+class\s*=\s*[\'""]\s*(wp\-block\-)?gallery\s+[^>]+/i', $replaceCallback, $output );
		}

		/**
		 * @return \Closure
		 */
		private function addStylePropertiesCallback() {
			return function ( $text, $cssProperties ) {
				if ( preg_match( '/(style\s*=[\"\'])/', $text, $result ) ) {
					return str_replace( $result[1], $result[1] . $cssProperties, $text );
				}

				return $text . sprintf( ' style="%s"', $cssProperties );
			};
		}

		/**
		 * @param int $columnsSpacing
		 *
		 * @return string
		 */
		private function getColumnsSpacingCssClassForMobile( $columnsSpacing ) {
			if ( $columnsSpacing === 0 ) {
				return 'no-gutter';
			}

			if ( $columnsSpacing > 0 && $columnsSpacing <= 2 ) {
				return 'pixel-gutter';
			}

			if ( $columnsSpacing > 2 && $columnsSpacing <= 6 ) {
				return 'small-gutter';
			}

			if ( $columnsSpacing > 6 && $columnsSpacing <= 24 ) {
				return 'medium-gutter';
			}

			if ( $columnsSpacing > 24 ) {
				return 'large-gutter';
			}

			return 'medium-gutter';
		}
	}
}