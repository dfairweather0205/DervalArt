<?php

namespace Pikart\WpThemeCore\ThemeOptions\ConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\SectionConfigBuilder' ) ) {

	/**
	 * Class SectionConfigBuilder
	 * @package Pikart\WpThemeCore\ThemeOptions\ConfigBuilder
	 */
	class SectionConfigBuilder extends ItemConfigBuilder {

		/**
		 * @var ControlConfigBuilder
		 */
		protected $childConfigBuilder;

		/**
		 * @var PanelConfigBuilder
		 */
		protected $parentConfigBuilder;

		/**
		 * SectionConfigBuilder constructor.
		 *
		 * @param ControlConfigBuilder $childConfigBuilder
		 */
		public function __construct( ControlConfigBuilder $childConfigBuilder ) {
			$this->childConfigBuilder = $childConfigBuilder;
		}

		/**
		 * @param string $id
		 * @param PanelConfigBuilder $panelConfigBuilder
		 *
		 * @return SectionConfigBuilder
		 */
		public function section( $id = '', $panelConfigBuilder = null ) {
			return $this->newItem( $id, $panelConfigBuilder );
		}

		/**
		 * @param array $controls
		 *
		 * @return SectionConfigBuilder
		 */
		public function controls( array $controls ) {
			return $this->updateItem( $this->getChildrenItemsKeyName(), $controls );
		}

		/**
		 * @param string $id
		 *
		 * @return PanelConfigBuilder
		 */
		public function panel( $id = '' ) {
			return $this->parentConfigBuilder->panel( $id );
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function control( $id = '' ) {
			return $this->childConfigBuilder->control( $id, $this );
		}

		/**
		 * @return string
		 */
		protected function getChildrenItemsKeyName() {
			return 'controls';
		}
	}
}
