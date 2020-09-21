<?php

namespace Pikart\WpThemeCore\ThemeOptions\CustomizeControlType;

use Pikart\WpThemeCore\ThemeOptions\GoogleFontsHelper;
use WP_Customize_Control;
use WP_Customize_Manager;

if ( ! class_exists( __NAMESPACE__ . '\\CustomizeFontFamilyControl' ) ) {

	/**
	 * Class CustomizeFontFamilyControl
	 * @package Pikart\WpThemeCore\ThemeOptions\CustomizeControlType
	 */
	class CustomizeFontFamilyControl extends WP_Customize_Control {

		const CONTROL_TYPE = 'select';

		/**
		 * CustomizeFontFamilyControl constructor.
		 *
		 * @param GoogleFontsHelper $googleFontsHelper
		 * @param WP_Customize_Manager $manager
		 * @param string $id
		 * @param array $args
		 */
		public function __construct(
			GoogleFontsHelper $googleFontsHelper, WP_Customize_Manager $manager, $id, array $args = array()
		) {
			$args['type']    = self::CONTROL_TYPE;
			$args['choices'] = $googleFontsHelper->getGoogleFonts();

			parent::__construct( $manager, $id, $args );
		}
	}
}
