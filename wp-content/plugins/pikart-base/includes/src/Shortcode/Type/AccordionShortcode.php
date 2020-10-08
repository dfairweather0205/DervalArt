<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeConfig;
use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\AccordionShortcode' ) ) {
	/**
	 * Class AccordionShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class AccordionShortcode extends AbstractShortcode {

		const ITEM_SHORTCODE_KEY = 'accordion-item';

		/**
		 * AccordionShortcode constructor.
		 *
		 * @param AccordionItemShortcode $shortcode
		 */
		public function __construct( AccordionItemShortcode $shortcode ) {
			parent::__construct();

			$this->addChildShortcode( $shortcode, self::ITEM_SHORTCODE_KEY );
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
			$itemShortcode = $this->getChildShortcode( self::ITEM_SHORTCODE_KEY );

			$builder
				->tabs( 'items', esc_html__( 'Items', 'pikart-base' ), array(
					'id'          => ShortcodeConfig::NAME_PREFIX. 'items',
					'newTabLabel' => esc_html__( 'New item', 'pikart-base' ),
					'tabLabel'    => esc_html__( 'Item', 'pikart-base' ),
					'tabItems'    => $itemShortcode->getAttributesConfig(),
					'shortcode'   => $this->getJsShortcodeConfig( $itemShortcode )
				) )
				->checkBox( 'multi_expand', esc_html__( 'Multi expand', 'pikart-base' ), array(
					'tooltip' => esc_html__( 'It allows to open more than one accordion at a time', 'pikart-base' ),
					'default' => true
				) )
				->checkBox( 'allow_all_closed', esc_html__( 'Allow all closed', 'pikart-base' ), array(
					'tooltip' => esc_html__( 'It allows to close all the accordions', 'pikart-base' ),
					'default' => true
				) )
				->cssClass();
		}
	}
}