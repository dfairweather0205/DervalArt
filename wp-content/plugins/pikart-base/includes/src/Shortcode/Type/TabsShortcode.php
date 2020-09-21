<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeConfig;
use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\TabsShortcode' ) ) {
	/**
	 * Class TabsShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class TabsShortcode extends AbstractShortcode {

		const TAB_SHORTCODE_KEY = 'tab';

		/**
		 * Tabs_Shortcode constructor.
		 *
		 * @param TabShortcode $shortcode
		 */
		public function __construct( TabShortcode $shortcode ) {
			parent::__construct();

			$this->addChildShortcode( $shortcode, self::TAB_SHORTCODE_KEY );
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
		protected function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder ) {
			$tabShortcode = $this->getChildShortcode( self::TAB_SHORTCODE_KEY );

			$builder->tabs( 'tabs', esc_html__( 'Tabs', 'pikart-base' ), array(
				'id'          => ShortcodeConfig::NAME_PREFIX . 'tabs',
				'newTabLabel' => esc_html__( 'New tab', 'pikart-base' ),
				'tabLabel'    => esc_html__( 'Tab', 'pikart-base' ),
				'tabItems'    => $tabShortcode->getAttributesConfig(),
				'shortcode'   => $this->getJsShortcodeConfig( $tabShortcode )
			) )->cssClass();
		}
	}
}