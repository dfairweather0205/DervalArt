<?php

namespace Pikart\WpCore\ThemeOptions\CustomizeControlType;

use Pikart\WpCore\Common\CoreAssetHandle;
use WP_Customize_Control;
use WP_Customize_Manager;

if ( ! class_exists( __NAMESPACE__ . '\\CustomizeCheckBoxMultipleControl' ) ) {

	/**
	 * Class CustomizeCheckBoxMultipleControl
	 * @package Pikart\WpCore\ThemeOptions\CustomizeControlType
	 */
	class CustomizeCheckBoxMultipleControl extends WP_Customize_Control {

		const CONTROL_TYPE = 'checkbox_multiple';

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

		public function enqueue() {
			wp_enqueue_script( CoreAssetHandle::adminCustomizeControls() );
		}

		public function render_content() {
			if ( empty( $this->choices ) ) {
				return;
			}

			if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ) ?></span>
			<?php endif; ?>

			<?php $values = is_array( $this->value() ) ? $this->value() : explode( ',', $this->value() ); ?>

            <ul>
				<?php foreach ( $this->choices as $value => $label ) : ?>

                    <li>
                        <label>
                            <input type="checkbox"
                                   value="<?php echo esc_attr( $value ); ?>"
								<?php checked( in_array( $value, $values ) ); ?> />
							<?php echo esc_html( $label ); ?>
                        </label>
                    </li>

				<?php endforeach; ?>
            </ul>

            <input type="hidden" <?php $this->link(); ?>
                   value="<?php echo esc_attr( implode( ',', $values ) ); ?>"/>
			<?php
		}
	}
}
