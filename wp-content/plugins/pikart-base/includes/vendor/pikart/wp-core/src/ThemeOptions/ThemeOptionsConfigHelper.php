<?php

namespace Pikart\WpCore\ThemeOptions;

use Pikart\WpCore\ThemeOptions\ConfigBuilder\ControlConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeOptionsConfigHelper' ) ) {
	/**
	 * Class ThemeOptionsConfigHelper
	 * @package Pikart\WpCore\ThemeOptions
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
				->label( esc_html__( 'Google Fonts', 'pikart-base' ) )
				->description( esc_html__( '_example: Ubuntu+Mono:400,400i,700', 'pikart-base' ) )
				->transportTypePostMessage()
				// ----------------------------------------------------- \\
				->button( ThemeCoreOption::ADD_GOOGLE_FONT )
				->persist( false )
				->defaultVal( esc_html__( 'Add font', 'pikart-base' ) )
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
				->label( esc_html__( 'Logo', 'pikart-base' ) );
		}

		/**
		 * @param ControlConfigBuilder $controlConfigBuilder
		 *
		 * @return ControlConfigBuilder
		 */
		public function buildHeaderInvertedLogoConfig( ControlConfigBuilder $controlConfigBuilder ) {
			return $controlConfigBuilder
				->image( ThemeCoreOption::LOGO_INVERTED )
				->label( esc_html__( 'Inverted Logo', 'pikart-base' ) );
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
					'select'       => esc_html__( 'Select inverted logo', 'pikart-base' ),
					'change'       => esc_html__( 'Change inverted logo', 'pikart-base' ),
					'placeholder'  => esc_html__( 'No inverted logo selected', 'pikart-base' ),
					'frame_title'  => esc_html__( 'Select inverted logo', 'pikart-base' ),
					'frame_button' => esc_html__( 'Choose inverted logo', 'pikart-base' ),
				)
			);

			return $controlConfigBuilder
				->croppedImage( ThemeCoreOption::LOGO_INVERTED )
				->label( esc_html__( 'Inverted Logo', 'pikart-base' ) )
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
				->defaultVal( esc_html__( 'Reset', 'pikart-base' ) )
				->label( esc_html__( 'Reset Theme Options', 'pikart-base' ) )
				->description( esc_html__( '_reset all the custom Theme Options to default values', 'pikart-base' ) );
		}

		/**
		 * @param ControlConfigBuilder $controlConfigBuilder
		 *
		 * @return ControlConfigBuilder
		 */
		public function buildCustomJsConfig( ControlConfigBuilder $controlConfigBuilder ) {
			return $controlConfigBuilder
				->textArea( ThemeCoreOption::CUSTOM_JS_HEADER )
				->label( esc_html__( 'JavaScript Header', 'pikart-base' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->textArea( ThemeCoreOption::CUSTOM_JS_FOOTER )
				->label( esc_html__( 'JavaScript Footer ', 'pikart-base' ) );
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
				->defaultVal( esc_html__( 'Copy', 'pikart-base' ) )
				->label( esc_html__( 'Copy Parent Theme Options', 'pikart-base' ) )
				->description( esc_html__( '_copy all the custom Parent Theme Options', 'pikart-base' ) );
		}
	}
}