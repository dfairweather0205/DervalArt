<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\SliderShortcode' ) ) {
	/**
	 * Class SliderShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class SliderShortcode extends AbstractShortcode {

		/**
		 * SliderShortcode constructor.
		 *
		 * @param SlideShortcode $slide_shortcode
		 */
		public function __construct( SlideShortcode $slide_shortcode ) {
			parent::__construct();
			$this->addChildShortcode( $slide_shortcode );
		}

		/**
		 * @inheritdoc
		 */
		public function isSelfClosing() {
			return false;
		}

		/**
		 * @inheritdoc
		 */
		public function isFinal() {
			return true;
		}

		/**
		 * @inheritdoc
		 */
		public function enabled() {
			return false;
		}

		/**
		 * @inheritdoc
		 */
		protected function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder ) {
			return array(
				'navigation_style' => array(
					'type'    => 'select',
					'default' => 'arrows'
				),
				'transition'       => array(
					'type'    => 'select',
					'default' => 'move',
				),
			);
		}
	}
}