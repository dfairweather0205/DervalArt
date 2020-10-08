<?php

namespace Pikart\WpThemeCore\ThemeOptions;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeOptionsCssFilter' ) ) {
	/**
	 * Class ThemeOptionsCssFilter
	 * @package Pikart\WpThemeCore\ThemeOptions
	 */
	class ThemeOptionsCssFilter {

		/**
		 * @since 1.5.0
		 */
		const COLOR = 'color';
		const FONT_FAMILY = 'fontFamily';
		const SIZE_UNIT_EM = 'sizeUnitEm';
		const SIZE_UNIT_PX = 'sizeUnitPx';
		const REVERSE_PERCENTAGE = 'reversePercentage';

		/**
		 * @param mixed $value
		 * @param string $filterType
		 *
		 * @return mixed
		 */
		public function filter( $value, $filterType = null ) {
			if ( ! empty( $filterType ) && method_exists( $this, $filterType ) ) {
				return $this->$filterType( $value );
			}

			return $value;
		}

		/**
		 * @param string $value
		 *
		 * @return string
		 */
		public function sizeUnitEm( $value ) {
			return $value . 'em';
		}

		/**
		 * @param string $value
		 *
		 * @return string
		 */
		public function sizeUnitPx( $value ) {
			return $value . 'px';
		}

		/**
		 * @param string $value
		 *
		 * @return string
		 */
		public function reversePercentage( $value ) {
			return ( 100 / $value ) . '%';
		}

		/**
		 * @param string $value
		 *
		 * @return string
		 */
		public function fontFamily( $value ) {
			$fontData = explode( ':', $value );

			if ( empty( $value ) || empty( $fontData[0] ) ) {
				return '';
			}

			return sprintf(
				"'%s', %s", str_replace( '+', ' ', $fontData[0] ), ThemeCoreOptionsConfig::FALLBACK_FONT_FAMILY );
		}

		/**
		 * @param string $value
		 *
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public function color( $value ) {
			return '#' . sanitize_hex_color_no_hash( $value );
		}
	}
}