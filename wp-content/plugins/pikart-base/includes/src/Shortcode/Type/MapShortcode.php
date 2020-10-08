<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpBase\Common\AssetHandle;
use Pikart\WpCore\Shortcode\ShortcodeConfig;
use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\MapShortcode' ) ) {
	/**
	 * Class MapShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class MapShortcode extends AbstractShortcode {

		const LOCATION_SHORTCODE_KEY = 'location';

		/**
		 * Contact_Map_Shortcode constructor.
		 *
		 * @param GeolocationShortcode $shortcode
		 */
		public function __construct( GeolocationShortcode $shortcode ) {
			parent::__construct();

			$this->addChildShortcode( $shortcode, self::LOCATION_SHORTCODE_KEY );
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
		 * @return array
		 */
		protected function getJsAssetHandles() {
			return array(
				AssetHandle::gmapApi()
			);
		}

		/**
		 * @inheritdoc
		 */
		protected function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder ) {
			$locationShortcode = $this->getChildShortcode( self::LOCATION_SHORTCODE_KEY );

			$builder
				->tabs( 'locations', esc_html__( 'Locations', 'pikart-base' ), array(
					'id'          => ShortcodeConfig::NAME_PREFIX . 'locations',
					'newTabLabel' => esc_html__( 'New location', 'pikart-base' ),
					'tabLabel'    => esc_html__( 'Location', 'pikart-base' ),
					'tabItems'    => $locationShortcode->getAttributesConfig(),
					'shortcode'   => $this->getJsShortcodeConfig( $locationShortcode )
				) )
				->number( 'height', esc_html__( 'Map height', 'pikart-base' ), array(
					'tooltip'     => esc_html__( 'pixels', 'pikart-base' ),
					'min'         => 0,
					'default'     => 400,
					'placeholder' => esc_html__( 'Enter the height for the map (pixels)', 'pikart-base' ),
				) )
				->number( 'zoom', esc_html__( 'Map zoom', 'pikart-base' ), array(
					'default'     => 8,
					'min'         => 0,
					'max'         => 20,
					'placeholder' => esc_html__(
						'Enter a zoom factor for Google Map (0 = whole world, 20 = specific buildings)', 'pikart-base' ),
				) )
				->checkBox( 'parallax', esc_html__( 'Parallax effect', 'pikart-base' ), array(
					'default' => false
				) )
				->cssClass();
		}
	}
}