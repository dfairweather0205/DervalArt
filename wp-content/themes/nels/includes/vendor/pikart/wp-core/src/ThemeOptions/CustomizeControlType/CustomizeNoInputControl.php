<?php

namespace Pikart\WpThemeCore\ThemeOptions\CustomizeControlType;

use WP_Customize_Control;
use WP_Customize_Manager;

if ( ! class_exists( __NAMESPACE__ . '\\CustomizeNoInputControl' ) ) {

	/**
	 * Class CustomizeNoInputControl
	 * @package Pikart\WpThemeCore\ThemeOptions\CustomizeControlType
	 */
	class CustomizeNoInputControl extends WP_Customize_Control {

		const CONTROL_TYPE = 'no_input';

		/**
		 * CustomizeFontFamilyControl constructor.
		 *
		 * @param WP_Customize_Manager $manager
		 * @param string               $id
		 * @param array                $args
		 */
		public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
			$args['type'] = self::CONTROL_TYPE;
			parent::__construct( $manager, $id, $args );
		}

		public function render_content() {
			?>
            <label>
				<?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif;
				if ( ! empty( $this->description ) ) : ?>
                    <span class="description customize-control-description"><?php echo esc_html( $this->description ) ?></span>
				<?php endif; ?>
            </label>
			<?php
		}
	}
}
