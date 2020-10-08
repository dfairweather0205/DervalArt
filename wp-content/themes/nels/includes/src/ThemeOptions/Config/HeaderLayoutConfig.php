<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\WpThemeCore\ThemeOptions\ThemeOptionsCoreUtil;

if ( ! class_exists( __NAMESPACE__ . '\HeaderLayoutConfig' ) ) {

	/**
	 * Class HeaderLayoutConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class HeaderLayoutConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$verticalSpacing   = sprintf( 'border-top-width: %1$spx; border-bottom-width: %1$spx', self::DELIMITER );
			$horizontalSpacing = sprintf( 'border-right-width: %1$spx; border-left-width: %1$spx', self::DELIMITER );
			$borderBottomWidth = sprintf( 'border-bottom-width: %spx;', self::DELIMITER );

			return $this->controlConfigBuilder
				->noInput( 'header_color_style_title' )
				->label( esc_html__( 'Color style', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::HEADER_BACKGROUND_COLOR )
				->defaultVal( '#ffffff' )
				->description( esc_html__( '_background', 'nels' ) )
				->cssCallback( $this->getHeaderBackgroundColorCallback() )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::HEADER_BACKGROUND_TRANSPARENCY )
				->defaultVal( 0 )
				->description( esc_html__( '_background transparency (%)', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
					'max' => 100,
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::HEADER_COLOR_SKIN )
				->defaultVal( 'dark' )
				->description( esc_html__( '_color skin', 'nels' ) )
				->choices( array(
					'light' => esc_html__( 'Light', 'nels' ),
					'dark'  => esc_html__( 'Dark', 'nels' ),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::HEADER_COLOR_SKIN_LIGHT )
				->defaultVal( '#ffffff' )
				->description( esc_html__( '_light color skin', 'nels' ) )
				->cssCallback( $this->getHeaderColorSkinLightCallback() )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::HEADER_COLOR_SKIN_DARK )
				->defaultVal( '#2a2a2a' )
				->description( esc_html__( '_dark color skin', 'nels' ) )
				->cssCallback( $this->getHeaderColorSkinDarkCallback() )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'header_spacing_title' )
				->label( esc_html__( 'Spacing (pixels)', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::HEADER_SPACING_VERTICAL )
				->defaultVal( 0 )
				->description( esc_html__( '_top & bottom', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
				) )
				->css( array(
					$verticalSpacing => array(
						'.site-header__main__wrapper',
					)
				) )
				->transportTypeRefresh()
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::HEADER_SPACING_HORIZONTAL )
				->defaultVal( 0 )
				->description( esc_html__( '_left & right', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
				) )
				->css( array(
					$horizontalSpacing => array(
						'.site-header__main__wrapper',
					)
				) )
				->transportTypeRefresh()
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'header_border_bottom_title' )
				->label( esc_html__( 'Border bottom', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::HEADER_BORDER_BOTTOM_COLOR )
				->defaultVal( '#e1e1e1' )
				->description( esc_html__( '_color', 'nels' ) )
				->css( array(
					'border-bottom-color' => array(
						'.site-header__wrapper'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::HEADER_BORDER_BOTTOM_WIDTH )
				->defaultVal( 1 )
				->description( esc_html__( '_width (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
				) )
				->css( array(
					$borderBottomWidth => array(
						'.site-header__wrapper'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::HEADER_SHADOW_ENABLED )
				->defaultVal( 1 )
				->label( esc_html__( 'Enable shadow', 'nels' ) )
				->cssCallback( $this->getShadowEnabledCallback() )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'header_top_behaviour_title' )
				->label( esc_html__( 'Behaviour', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::HEADER_BEHAVIOUR )
				->defaultVal( 'regular' )
				->description( esc_html__( '_type', 'nels' ) )
				->choices( array(
					'regular' => esc_html__( 'Regular', 'nels' ),
					'fixed'   => esc_html__( 'Fixed', 'nels' ),
					'sticky'  => esc_html__( 'Sticky', 'nels' ),
				) )
				->build();
		}

		/**
		 * @return \Closure
		 */
		private function getHeaderBackgroundColorCallback() {
			$templatesUtil = $this->templatesUtil;

			return function ( $option, ThemeOptionsCoreUtil $util ) use ( $templatesUtil ) {
				$transparency = $util->getOption( ThemeOption::HEADER_BACKGROUND_TRANSPARENCY );

				$backgroundColor = 'background-color: '
				                   . $templatesUtil->hexWithTransparencyToRgbaString( $option, $transparency );

				return array(
					$backgroundColor => array(
						'.site-header__wrapper'
					)
				);
			};
		}

		/**
		 * @return \Closure
		 */
		private function getHeaderColorSkinLightCallback() {
			return function ( $option ) {
				$backgroundColor = sprintf( 'background-color: %s', $option );
				$color = sprintf( 'color: %s', $option );
				$borderRightColor = sprintf( 'border-right-color: %s', $option );
				$borderBottomColor = sprintf( 'border-bottom-color: %s', $option );

				return array(
					$backgroundColor => array(
						'.site-header--skin-light .toggle-button hr',
						'.site-header--skin-light .site-header__main #primary-menu > .current-menu-item > a .menu-item__span:after',
					),
					$color => array(
						'.site-header--skin-light .site-title',
						'.site-header--skin-light .site-header__main #primary-menu > .menu-item > a .menu-item__span',
						'.site-header--skin-light .site-header__main #social-primary-menu > li > a',
						'.site-header--skin-light .site-header__main .tool-icons > div > a'
					),
					$borderRightColor => array(
						'.site-header--skin-light .site-header__main #primary-menu > .menu-item > a:before'
					),

					$borderBottomColor  => array(
						'.site-header--skin-light .site-header__main #primary-menu > .menu-item > a:before'
					)
				);
			};
		}

		/**
		 * @return \Closure
		 */
		private function getHeaderColorSkinDarkCallback() {
			return function ( $option ) {
				$backgroundColor = sprintf( 'background-color: %s', $option );
				$color = sprintf( 'color: %s', $option );
				$borderRightColor = sprintf( 'border-right-color: %s', $option );
				$borderBottomColor = sprintf( 'border-bottom-color: %s', $option );

				return array(
					$backgroundColor => array(
						'.site-header--skin-dark .toggle-button hr',
						'.site-header--skin-dark .site-header__main #primary-menu > .current-menu-item > a .menu-item__span:after',
					),
					$color => array(
						'.site-header--skin-dark .site-title',
						'.site-header--skin-dark .site-header__main #primary-menu > .menu-item > a .menu-item__span',
						'.site-header--skin-dark .site-header__main #social-primary-menu > li > a',
						'.site-header--skin-dark .site-header__main .tool-icons > div > a'
					),
					$borderRightColor => array(
						'.site-header--skin-dark .site-header__main #primary-menu > .menu-item > a:before'
					),
					$borderBottomColor  => array(
						'.site-header--skin-dark .site-header__main #primary-menu > .menu-item > a:before'
					)
				);
			};
		}

		/**
		 * @return \Closure
		 */
		private function getShadowEnabledCallback() {
			return function ( $option ) {
				$enableShadow      = sprintf( 'box-shadow: 0 0 5px 0 rgba(0,0,0,0.12);');

				if ( $option ) {
					return array(
						$enableShadow => array(
							'.site-header__wrapper'
						)
					);
				}

				return array();
			};
		}
	}
}