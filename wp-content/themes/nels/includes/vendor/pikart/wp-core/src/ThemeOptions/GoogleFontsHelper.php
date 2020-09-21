<?php

namespace Pikart\WpThemeCore\ThemeOptions;

use Pikart\WpThemeCore\Common\CoreAssetHandle;

if ( ! class_exists( __NAMESPACE__ . '\\GoogleFontsHelper' ) ) {

	/**
	 * Class GoogleFontsHelper
	 * @package Pikart\WpThemeCore\ThemeOptions
	 */
	class GoogleFontsHelper {

		const GOOGLE_FONTS_URL = '//fonts.googleapis.com/css';
		const ADD_FONT_NONCE_ACTION = 'pikart_add_google_font';

		/**
		 * @var bool
		 */
		private static $googleFontsEnqueued = false;

		/**
		 * @var string
		 */
		private $optionKey;

		public function __construct() {
			$this->optionKey = sprintf( '%s_%s', PIKART_THEME_SLUG, ThemeCoreOption::GOOGLE_FONTS );

			$this->registerAddGoogleFontAjax();
		}

		/**
		 * @return array
		 */
		public function getGoogleFonts() {
			$fonts              = get_option( $this->optionKey );
			$defaultGoogleFonts = $this->getDefaultGoogleFonts();

			if ( $fonts ) {
				$fonts = $this->formatFonts( array_merge( $defaultGoogleFonts, $fonts ) );
			} else {
				$defaultGoogleFonts = $this->formatFonts( $defaultGoogleFonts );
				add_option( $this->optionKey, $defaultGoogleFonts );
				$fonts = $defaultGoogleFonts;
			}

			return apply_filters( ThemeOptionsFilterName::googleFonts(), array_combine( $fonts, $fonts ) );
		}

		public function enqueueGoogleFonts() {
			if ( static::$googleFontsEnqueued ) {
				return;
			}

			$googleFonts                    = $this->getGoogleFonts();
			$generateGoogleFontsUrlCallback = $this->generateGoogleFontsUrlCallback();

			add_action( 'wp_enqueue_scripts', function () use ( $googleFonts, $generateGoogleFontsUrlCallback ) {
				if ( wp_style_is( CoreAssetHandle::googleFonts(), 'enqueued' ) ) {
					return;
				}

				$fontsToEnqueue = is_customize_preview() ? $googleFonts : array();

				$fontsToEnqueue = apply_filters( ThemeOptionsFilterName::registeredGoogleFonts(), $fontsToEnqueue );

				if ( empty( $fontsToEnqueue ) ) {
					return;
				}

				wp_enqueue_style(
					CoreAssetHandle::googleFonts(),
					$generateGoogleFontsUrlCallback( $fontsToEnqueue ),
					array(),
					null
				);
			} );

			static::$googleFontsEnqueued = true;
		}

		/**
		 * @return array
		 * @deprecated not used anymore and not recommended
		 */
		public function getGoogleFontToNameList() {
			$fonts = $this->getGoogleFonts();

			$fontToNameList = array();

			foreach ( $fonts as $font ) {
				$fontData                    = explode( ':', $font );
				$fontData                    = explode( '&amp;', $fontData[0] );
				$fontName                    = str_replace( '+', ' ', $fontData[0] );
				$fontToNameList[ $fontName ] = $font;
			}

			return array_flip( $fontToNameList );
		}

		/**
		 * @return \Closure
		 */
		private function generateGoogleFontsUrlCallback() {
			$subsets = $this->getDefaultGoogleFontsSubsets();

			return function ( array $fontsToEnqueue ) use ( $subsets ) {
				$fontsToEnqueue = array_unique( $fontsToEnqueue );

				$fontsToEnqueue = array_map( function ( $font ) use ( &$subsets ) {
					// extract and remove the subset from the font, ex: Rokkitt:400,700:latin-ext,cyrillic
					if ( substr_count( $font, ':' ) === 2 ) {
						$parts = explode( ':', $font );

						if ( isset( $parts[2] ) ) {
							$subsets = array_merge( $subsets, explode( ',', $parts[2] ) );
						}

						$font = sprintf( '%s:%s', $parts[0], $parts[1] );
					}

					// extract and remove the subset from the font, ex: Rokkitt:400,700&amp;subset=latin-ext,cyrillic
					if ( preg_match( '/[&amp;]+subset=([-\w,]*)(&|$)/', $font, $matches ) ) {
						$subsets = array_merge( $subsets, explode( ',', $matches[1] ) );
						$font    = str_ireplace( $matches[0], '', $font );
					}

					return $font;
				}, $fontsToEnqueue );

				$queryArgs = array(
					'family' => str_replace( '%2B', '+', urlencode( implode( '|', $fontsToEnqueue ) ) ),
					'subset' => urlencode( implode( ',', array_unique( $subsets ) ) ),
				);

				return add_query_arg( $queryArgs, GoogleFontsHelper::GOOGLE_FONTS_URL );
			};
		}

		private function registerAddGoogleFontAjax() {
			$fonts                = $this->getGoogleFonts();
			$formatFontsCallback  = $this->formatFontsCallback();
			$optionKey            = $this->optionKey;
			$googleFontsUrlPrefix = ( \is_ssl() ? 'https' : 'http' ) . ':'
			                        . GoogleFontsHelper::GOOGLE_FONTS_URL;

			add_action( 'wp_ajax_' . PIKART_SLUG . '_add_google_font', function () use (
				$fonts, $formatFontsCallback, $optionKey, $googleFontsUrlPrefix
			) {
				if ( ! check_ajax_referer( GoogleFontsHelper::ADD_FONT_NONCE_ACTION, 'nonce', false ) ) {
					wp_send_json_error();
				}

				$encodedGoogleFont = filter_input( INPUT_POST, 'googleFont', FILTER_SANITIZE_STRING );
				$errorMessage      = esc_html__( 'Invalid font. Retype it carefully again.', 'nels' );

				if ( empty( $encodedGoogleFont ) ) {
					wp_send_json_error( $errorMessage );

					return;
				}

				$decodedFont = urldecode( $encodedGoogleFont );

				// keep consistent format for the font, ex: Old+Standard+TT:400,400i,700:cyrillic,latin-ext
				// using double colons in case variations are missing, ex: Old+Standard+TT::cyrillic,latin-ext
				$googleFont = str_ireplace(
					array( ' ', '&amp;subset=', '&subset=' ),
					array( '+', '::', '::' ),
					$decodedFont
				);

				// if variations are present, we replace double colons with one colon
				// Old+Standard+TT:400,400i,700::cyrillic,latin-ext -> Old+Standard+TT:400,400i,700:cyrillic,latin-ext
				if ( substr_count( $googleFont, ':' ) > 2 ) {
					$googleFont = str_replace( '::', ':', $googleFont );
				}

				if ( in_array( $googleFont, $fonts ) ) {
					wp_send_json_error(
						esc_html__( 'Font already exists. See font family dropdown-lists', 'nels' ) );

					return;
				}

				$response = wp_remote_get( add_query_arg(
						'family', str_replace( '%2B', '+', $decodedFont ), $googleFontsUrlPrefix )
				);

				if ( 200 !== $response['response']['code'] ) {
					wp_send_json_error( $errorMessage );

					return;
				}

				if ( strpos( $googleFont, '|' ) !== false ) {
					wp_send_json_error( esc_html__( 'Please add only one font at once', 'nels' ) );

					return;
				}

				$fonts[] = $googleFont;
				$fonts   = $formatFontsCallback( $fonts );
				update_option( $optionKey, $fonts );

				wp_send_json_success( array(
					'message'     => esc_html__( 'Font was added. See font family dropdown-lists', 'nels' ),
					'fontContent' => $response['body'],
					'font'        => $googleFont
				) );

			} );
		}

		/**
		 * @param array $fonts
		 *
		 * @return array
		 */
		private function formatFonts( array $fonts ) {
			$formatFontsCallback = $this->formatFontsCallback();

			return $formatFontsCallback( $fonts );
		}

		/**
		 * @return \Closure
		 */
		private function formatFontsCallback() {
			return function ( array $fonts ) {
				$fonts = array_unique( $fonts );
				natsort( $fonts );

				return $fonts;
			};
		}

		/**
		 * @return array
		 */
		private function getDefaultGoogleFonts() {
			$fonts = array(
				'Arimo:400,400i,700,700i',
				'Arvo:400,400i,700,700i',
				'Bitter:400,400i,700',
				'Cabin:400,400i,500,500i,600,600i,700,700i',
				'Cabin+Condensed:400,500,600,700',
				'Cabin+Sketch:400,700',
				'Denk+One',
				'Droid+Sans:400,700',
				'Droid+Serif:400,400i,700,700i',
				'Heebo:100,300,400,500,700,800,900',
				'Hind:300,400,500,600,700',
				'Hind+Guntur:300,400,500,600,700',
				'Hind+Madurai:300,400,500,600,700',
				'Hind+Siliguri:300,400,500,600,700',
				'Hind+Vadodara:300,400,500,600,700',
				'Inconsolata:400,700',
				'Josefin+Sans:300,300i,400,400i,700,700i',
				'Josefin+Slab:300,300i,400,400i,700,700i',
				'Lato:300,300i,400,400i,700,700i',
				'Libre+Baskerville:400,400i,700',
				'Lobster',
				'Lobster+Two:400,400i,700,700i',
				'Lora:400,400i,700,700i',
				'Montserrat:300,300i,400,400i,700,700i',
				'Montserrat+Alternates:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i',
				'Montserrat+Subrayada:400,700',
				'Open+Sans:300,300i,400,400i,700,700i',
				'Open+Sans+Condensed:300,300i,700',
				'Oswald:300,400,700',
				'Playfair+Display:400,400i,700,700i',
				'Playfair+Display+SC:400,400i,700,700i,900,900i',
				'Poppins:300,400,500,600,700',
				'PT+Sans:400,400i,700,700i',
				'PT+Sans+Caption:400,700',
				'PT+Sans+Narrow:400,700',
				'Quattrocento:400,700',
				'Quattrocento+Sans:400,400i,700,700i',
				'Raleway:300,300i,400,400i,700,700i',
				'Roboto:300,300i,400,400i,500,500i,700,700i,900,900i',
				'Roboto+Condensed:300,300i,400,400i,700,700i',
				'Roboto+Mono:100,100i,300,300i,400,400i,500,500i,700,700i',
				'Roboto+Slab:100,300,400,700',
				'Rokkitt:400,700',
				'Rubik:300,300i,400,400i,500,500i,700,700i,900,900i',
				'Rubik+Mono+One',
				'Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i',
				'Titillium+Web:300,300i,400,400i,700,700i',
				'Ubuntu:300,300i,400,400i,500,500i,700,700i',
				'Ubuntu+Condensed',
				'Ubuntu+Mono:400,400i,700,700i',
			);

			return apply_filters( ThemeOptionsFilterName::defaultGoogleFonts(), $fonts );
		}

		/**
		 * @return array
		 */
		private function getDefaultGoogleFontsSubsets() {
			return apply_filters( ThemeOptionsFilterName::googleFontsSubsets(), array(
				'latin-ext',
				'cyrillic',
				'cyrillic-ext'
			) );
		}
	}
}