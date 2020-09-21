<?php

namespace Pikart\Nels\ThemeOptions;

use Pikart\WpThemeCore\ThemeOptions\ConfigBuilder\ThemeOptions;
use Pikart\WpThemeCore\ThemeOptions\ThemeOptionsFilterName;

if ( ! class_exists( __NAMESPACE__ . '\ThemeOptionsJsHelper' ) ) {

	/**
	 * Class ThemeOptionsJsHelper
	 * @package Pikart\Nels\ThemeOptions
	 */
	class ThemeOptionsJsHelper {

		const THEME_OPTIONS_GROUP_SLIDERS = 'sliders';

		/**
		 * @var ThemeOptionsUtil
		 */
		private $themeOptionsUtil;

		/**
		 * ThemeOptionsJsHelper constructor.
		 *
		 * @param ThemeOptionsUtil $themeOptionsUtil
		 */
		public function __construct( ThemeOptionsUtil $themeOptionsUtil ) {
			$this->themeOptionsUtil = $themeOptionsUtil;
		}

		public function injectHeaderJsConfigForCustomizer() {
			$getBuildHeaderJsConfigCallback = $this->getBuildHeaderJsConfigCallback();

			add_filter( ThemeOptionsFilterName::customizerJsData(),
				function ( $jsConfig, $themeOptions ) use ( $getBuildHeaderJsConfigCallback ) {
					/* @var ThemeOptions $themeOptions */
					$headerJsConfig = $getBuildHeaderJsConfigCallback( $themeOptions->getCustomOptions() );

					$jsConfig['headerConfig'] = $headerJsConfig;

					return $jsConfig;
				}, 10, 2 );
		}

		/**
		 * @return array
		 */
		public function getOptionsForCustomJs() {
			$options = array();

			$this->populateOptionList( $options, array(
				ThemeOption::FEATURE_COLOR,
				ThemeOption::PARALLAX_SPEED,
				ThemeOption::HEADER_BACKGROUND_COLOR,
				ThemeOption::HEADER_BACKGROUND_TRANSPARENCY,
				ThemeOption::HEADER_COLOR_SKIN,
				ThemeOption::HEADER_SIDEBAR_WIDTH,
				ThemeOption::ADD_TO_CART_POPUP,
				ThemeOption::SHOP_CROSS_SELLS_PRODUCTS_AUTOPLAY,
				ThemeOption::SHOP_UPSELLS_PRODUCTS_AUTOPLAY,
				ThemeOption::SHOP_RELATED_PRODUCTS_AUTOPLAY,
				ThemeOption::SHOP_CROSS_SELLS_PRODUCTS_NB_COLUMNS,
				ThemeOption::SHOP_UPSELLS_PRODUCTS_NB_COLUMNS,
				ThemeOption::SHOP_RELATED_PRODUCTS_NB_COLUMNS,
				ThemeOption::SHOP_COLUMNS_SPACING
			) );

			return $options;
		}

		/**
		 * @param array  $options
		 * @param        $optionNames
		 * @param string $group
		 */
		private function populateOptionList( array &$options, array $optionNames, $group = '' ) {

			foreach ( $optionNames as $optionName ) {
				if ( empty( $group ) ) {
					$options[ $optionName ] = esc_js( $this->themeOptionsUtil->getOption( $optionName ) );
				} else {
					$options[ $group ][ $this->removeOptionGroup( $optionName, $group ) ] =
						esc_js( $this->themeOptionsUtil->getOption( $optionName ) );
				}
			}
		}

		/**
		 * @param $optionName
		 * @param $group
		 *
		 * @return mixed
		 */
		private function removeOptionGroup( $optionName, $group ) {
			return preg_replace( '/^' . $group . '_/', '', $optionName );
		}

		/**
		 * @return callback that generates array in this format:
		 *
		 * array(
		 *      'top'  => array(
		 *          'sectionsId' => array(id1, id2, ...),
		 *          'controlsId' => array(id1, id2, ...),
		 *      ),
		 *      'left' => array(
		 *          'sectionsId' => array(id1, id2, ...),
		 *          'controlsId' => array(id1, id2, ...),
		 *      )
		 * )
		 */
		private function getBuildHeaderJsConfigCallback() {
			return function ( array $customOptions ) {
				if ( ! isset( $customOptions['panels'] ) ) {
					return array();
				}

				$headerPanel = current( array_filter( $customOptions['panels'], function ( $panel ) {
					return $panel['id'] === 'header';
				} ) );

				$typologies   = array( 'classic', 'branding' );
				$headerConfig = array();

				$checkItemsId = function ( $items, $itemsKey ) use ( &$headerConfig, $typologies ) {
					foreach ( $items as $item ) {
						if ( preg_match( '/^header_(left|top)_.+/', $item['id'], $matches ) ) {
							$navigationPosition = $matches[1];
							$typologyFound      = false;

							foreach ( $typologies as $typology ) {
								if ( preg_match( sprintf( '/_%s_/', $typology ), $item['id'] ) ) {
									$typologyFound = true;

									$headerConfig[ $navigationPosition ][ $typology ][ $itemsKey ][] = $item['id'];
								}
							}

							if ( ! $typologyFound ) {
								$headerConfig[ $navigationPosition ][ $itemsKey ][] = $item['id'];
							}

						}
					}
				};

				array_walk( $headerPanel['sections'], function ( $section ) use ( &$headerConfig, $checkItemsId ) {
					$checkItemsId( $section['controls'], 'controlsId' );
				} );

				$checkItemsId( $headerPanel['sections'], 'sectionsId' );

				return $headerConfig;
			};
		}
	}
}