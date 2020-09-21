<?php

namespace Pikart\WpThemeCore\ThemeOptions;

use Pikart\WpThemeCore\ThemeOptions\CustomizeControlType\CustomizeCheckBoxMultipleControl;
use Pikart\WpThemeCore\ThemeOptions\CustomizeControlType\CustomizeFontFamilyControl;
use Pikart\WpThemeCore\ThemeOptions\CustomizeControlType\CustomizeNoInputControl;
use WP_Customize_Color_Control;
use WP_Customize_Cropped_Image_Control;
use WP_Customize_Image_Control;
use WP_Customize_Manager;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeOptionsControlWrapper' ) ) {

	/**
	 * Class ThemeOptionsControlWrapper
	 * @package Pikart\WpThemeCore\ThemeOptions
	 */
	class ThemeOptionsControlWrapper {

		/**
		 * @var GoogleFontsHelper
		 */
		private $googleFontsHelper;

		/**
		 * @var \WP_Customize_Manager
		 */
		private $wpCustomizeManager;

		/**
		 * ThemeOptionsControlWrapper constructor.
		 *
		 * @param GoogleFontsHelper $googleFontsHelper
		 */
		public function __construct( GoogleFontsHelper $googleFontsHelper ) {
			$this->googleFontsHelper = $googleFontsHelper;
		}

		/**
		 * @param \WP_Customize_Manager $wpCustomizeManager
		 */
		public function setWpCustomizeManager( WP_Customize_Manager $wpCustomizeManager ) {
			$this->wpCustomizeManager = $wpCustomizeManager;
		}

		/**
		 * @param string $id
		 * @param string $type
		 * @param array $options
		 */
		public function add( $id, $type, array $options = array() ) {
			if ( method_exists( $this, $type ) ) {
				$this->$type( $id, $options );

				return;
			}

			$options['type'] = $type;

			$this->wpCustomizeManager->add_control( $id, $options );
		}

		/**
		 * @param string $id
		 * @param array $options
		 */
		private function color( $id, array $options = array() ) {
			$this->wpCustomizeManager->add_control(
				new WP_Customize_Color_Control( $this->wpCustomizeManager, $id, $options )
			);
		}

		/**
		 * @param string $id
		 * @param array $options
		 */
		private function image( $id, array $options = array() ) {
			$this->wpCustomizeManager->add_control(
				new WP_Customize_Image_Control( $this->wpCustomizeManager, $id, $options )
			);
		}

		/**
		 * @param string $id
		 * @param array $options
		 *
		 * @since 1.5.0
		 */
		private function croppedImage( $id, array $options = array() ) {
			$options['type'] = 'cropped_image';

			$this->wpCustomizeManager->add_control(
				new WP_Customize_Cropped_Image_Control( $this->wpCustomizeManager, $id, $options )
			);
		}

		/**
		 * @param string $id
		 * @param array $options
		 */
		private function fontFamily( $id, array $options = array() ) {
			$this->wpCustomizeManager->add_control(
				new CustomizeFontFamilyControl( $this->googleFontsHelper, $this->wpCustomizeManager, $id, $options )
			);
		}

		/**
		 * @param string $id
		 * @param array $options
		 */
		private function checkBoxMultiple( $id, array $options = array() ) {
			$this->wpCustomizeManager->add_control(
				new CustomizeCheckBoxMultipleControl( $this->wpCustomizeManager, $id, $options )
			);
		}

		/**
		 * @param string $id
		 * @param array $options
		 */
		private function noInput( $id, array $options = array() ) {
			$this->wpCustomizeManager->add_control(
				new CustomizeNoInputControl( $this->wpCustomizeManager, $id, $options )
			);
		}
	}
}