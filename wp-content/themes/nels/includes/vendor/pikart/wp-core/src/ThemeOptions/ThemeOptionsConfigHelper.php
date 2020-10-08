<?php

namespace Pikart\WpThemeCore\ThemeOptions;

use Pikart\WpThemeCore\ThemeOptions\ConfigBuilder\ControlConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeOptionsConfigHelper' ) ) {
	/**
	 * Class ThemeOptionsConfigHelper
	 * @package Pikart\WpThemeCore\ThemeOptions
	 */
	class ThemeOptionsConfigHelper {

		/**
		 * @param ControlConfigBuilder $controlConfigBuilder
		 *
		 * @return ControlConfigBuilder
		 */
		public function buildAddGoogleFontConfig( ControlConfigBuilder $controlConfigBuilder ) {
			return $controlConfigBuilder
				->text( ThemeCoreOption::GOOGLE_FONT )
				->persist( false )
				->label( esc_html__( 'Google Fonts', 'nels' ) )
				->description( esc_html__( '_example: Ubuntu+Mono:400,400i,700', 'nels' ) )
				->transportTypePostMessage()
				// ----------------------------------------------------- \\
				->button( ThemeCoreOption::ADD_GOOGLE_FONT )
				->persist( false )
				->defaultVal( esc_html__( 'Add font', 'nels' ) )
				->transportTypePostMessage();
		}

		/**
		 * @param ControlConfigBuilder $controlConfigBuilder
		 *
		 * @return ControlConfigBuilder
		 */
		public function buildHeaderLogoConfig( ControlConfigBuilder $controlConfigBuilder ) {
			return $controlConfigBuilder
				->image( ThemeCoreOption::LOGO )
				->label( esc_html__( 'Logo', 'nels' ) );
		}

		/**
		 * @param ControlConfigBuilder $controlConfigBuilder
		 *
		 * @return ControlConfigBuilder
		 */
		public function buildHeaderInvertedLogoConfig( ControlConfigBuilder $controlConfigBuilder ) {
			return $controlConfigBuilder
				->image( ThemeCoreOption::LOGO_INVERTED )
				->label( esc_html__( 'Inverted Logo', 'nels' ) );
		}

		/**
		 * @param ControlConfigBuilder $controlConfigBuilder
		 *
		 * @since 1.5.0
		 *
		 * @return ControlConfigBuilder
		 */
		public function buildCroppedInvertedLogoConfig( ControlConfigBuilder $controlConfigBuilder ) {
			$customLogoArgs = get_theme_support( 'custom-logo' );

			$controlProperties = array(
				'height'        => $customLogoArgs[0]['height'],
				'width'         => $customLogoArgs[0]['width'],
				'flex_height'   => $customLogoArgs[0]['flex-height'],
				'flex_width'    => $customLogoArgs[0]['flex-width'],
				'button_labels' => array(
					'select'       => esc_html__( 'Select inverted logo', 'nels' ),
					'change'       => esc_html__( 'Change inverted logo', 'nels' ),
					'placeholder'  => esc_html__( 'No inverted logo selected', 'nels' ),
					'frame_title'  => esc_html__( 'Select inverted logo', 'nels' ),
					'frame_button' => esc_html__( 'Choose inverted logo', 'nels' ),
				)
			);

			return $controlConfigBuilder
				->croppedImage( ThemeCoreOption::LOGO_INVERTED )
				->label( esc_html__( 'Inverted Logo', 'nels' ) )
				->priority( 9 )
				->additionalConfigAttributes( $controlProperties );
		}

		/**
		 * @param ControlConfigBuilder $controlConfigBuilder
		 *
		 * @return ControlConfigBuilder
		 */
		public function buildResetOptionsConfig( ControlConfigBuilder $controlConfigBuilder ) {
			return $controlConfigBuilder
				->button( ThemeCoreOption::RESET_OPTIONS )
				->persist( false )
				->defaultVal( esc_html__( 'Reset', 'nels' ) )
				->label( esc_html__( 'Reset Theme Options', 'nels' ) )
				->description( esc_html__( '_reset all the custom Theme Options to default values', 'nels' ) );
		}

		/**
		 * @param ControlConfigBuilder $controlConfigBuilder
		 *
		 * @return ControlConfigBuilder
		 */
		public function buildCustomJsConfig( ControlConfigBuilder $controlConfigBuilder ) {
			return $controlConfigBuilder
				->textArea( ThemeCoreOption::CUSTOM_JS_HEADER )
				->label( esc_html__( 'JavaScript Header', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->textArea( ThemeCoreOption::CUSTOM_JS_FOOTER )
				->label( esc_html__( 'JavaScript Footer ', 'nels' ) );
		}

		/**
		 * @param ControlConfigBuilder $controlConfigBuilder
		 *
		 * @since 1.6.0
		 *
		 * @return ControlConfigBuilder
		 */
		public function buildCopyParentThemeOptionsConfig( ControlConfigBuilder $controlConfigBuilder ) {
			return $controlConfigBuilder
				->button( ThemeCoreOption::COPY_PARENT_THEME_OPTIONS )
				->persist( false )
				->enabled( is_child_theme() )
				->defaultVal( esc_html__( 'Copy', 'nels' ) )
				->label( esc_html__( 'Copy Parent Theme Options', 'nels' ) )
				->description( esc_html__( '_copy all the custom Parent Theme Options', 'nels' ) );
		}
	}
}