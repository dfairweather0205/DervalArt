<?php

namespace Pikart\WpThemeCore\Common;

if ( ! class_exists( __NAMESPACE__ . '\\DataSanitizer' ) ) {
	/**
	 * Class DataSanitizer
	 * @package Pikart\WpThemeCore\Common
	 */
	class DataSanitizer {

		const DEFAULT_SANITIZE_TYPE = 'text';

		/**
		 * @param mixed $value
		 * @param string $type
		 *
		 * @return mixed
		 */
		public function sanitize( $value, $type = 'text' ) {
			$sanitizeMethod = is_string( $type ) && method_exists( $this, $type ) ? $type : self::DEFAULT_SANITIZE_TYPE;

			return $this->$sanitizeMethod( $value );
		}

		/**
		 * @param number $range
		 *
		 * @return int
		 */
		public function range( $range ) {
			return $this->number( $range );
		}

		/**
		 * @param number $number
		 *
		 * @return int
		 */
		public function number( $number ) {
			return 0 + $number;
		}

		/**
		 * @param string $image
		 *
		 * @return string
		 */
		public function image( $image ) {
			return $this->url( $image );
		}

		/**
		 * @param string $url
		 *
		 * @return string
		 */
		public function url( $url ) {
			return esc_url_raw( $url );
		}

		/**
		 * @param string $value
		 *
		 * @return string
		 */
		public function checkbox( $value ) {
			if ( $value === 'on' ) {
				return $value;
			}

			return $value ? 1 : 0;
		}

		/**
		 * @param string $text
		 *
		 * @return string
		 */
		public function text( $text ) {
			return sanitize_text_field( $text );
		}

		/**
		 * @param string $text
		 *
		 * @return string
		 */
		public function wpKsesWithIframe( $text ) {
			$allowedHtml           = wp_kses_allowed_html( 'post' );
			$allowedHtml['iframe'] = array(
				'align'                 => true,
				'width'                 => true,
				'height'                => true,
				'frameborder'           => true,
				'name'                  => true,
				'src'                   => true,
				'id'                    => true,
				'class'                 => true,
				'style'                 => true,
				'scrolling'             => true,
				'marginwidth'           => true,
				'marginheight'          => true,
				'allowfullscreen'       => true,
				'webkitallowfullscreen' => true,
				'mozallowfullscreen'    => true,
			);

			return wp_kses( $text, $allowedHtml );
		}

		/**
		 * @param string $text
		 *
		 * @return string
		 */
		public function textArea( $text ) {
			return $this->wpKsesWithIframe( $text );
		}

		/**
		 * @param string $color
		 *
		 * @return string
		 */
		public function color( $color ) {
			return sanitize_hex_color( $color );
		}

		/**
		 * @param string $color
		 *
		 * @return string
		 */
		public function wpColorPicker( $color ) {
			return $this->color( $color );
		}

		/**
		 * @param string $text
		 *
		 * @return string
		 */
		public function wpEditor( $text ) {
			return $this->wpKsesWithIframe( $text );
		}

		/**
		 * @param array|string $input
		 *
		 * @return array
		 */
		public function multiselect( $input ) {
			return array_map( array( $this, 'text' ), $this->stringToArray( $input ) );
		}

		/**
		 * @param array|string $input
		 *
		 * @return array
		 */
		public function checkboxMultiple( $input ) {
			return $this->multiselect( $input );
		}

		/**
		 * @param array|string $input
		 *
		 * @return array
		 */
		public function multiCheckbox( $input ) {
			return $this->checkboxMultiple( $input );
		}

		/**
		 * @param string $email
		 *
		 * @since 1.1.0
		 *
		 * @return string
		 */
		public function email( $email ) {
			return sanitize_email( $email );
		}

		/**
		 * @param string $string
		 * @param string $separator
		 *
		 * @return array|string
		 */
		private function stringToArray( $string, $separator = ',' ) {
			if ( is_array( $string ) ) {
				return $string;
			}

			$string = (string) $string;

			return $string === '' ? array() : explode( $separator, $string );
		}
	}
}