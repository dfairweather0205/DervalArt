<?php

namespace Pikart\WpThemeCore\ThemeOptions\ConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\PanelConfigBuilder' ) ) {
	/**
	 * Class PanelConfigBuilder
	 * @package Pikart\WpThemeCore\ThemeOptions\ConfigBuilder
	 */
	class PanelConfigBuilder extends ItemConfigBuilder {

		/**
		 * @var SectionConfigBuilder
		 */
		protected $childConfigBuilder;

		/**
		 * PanelConfigBuilder constructor.
		 *
		 * @param SectionConfigBuilder $childConfigBuilder
		 */
		public function __construct( SectionConfigBuilder $childConfigBuilder ) {
			$this->childConfigBuilder = $childConfigBuilder;
		}

		/**
		 * @param string $id
		 *
		 * @return PanelConfigBuilder
		 */
		public function panel( $id = '' ) {
			return $this->newItem( $id );
		}

		/**
		 * @param array $sections
		 *
		 * @return PanelConfigBuilder
		 */
		public function sections( array $sections ) {
			return $this->updateItem( $this->getChildrenItemsKeyName(), $sections );
		}

		/**
		 * @param string $id
		 *
		 * @return SectionConfigBuilder
		 */
		public function section( $id = '' ) {
			return $this->childConfigBuilder->section( $id, $this );
		}

		/**
		 * @return string
		 */
		protected function getChildrenItemsKeyName() {
			return 'sections';
		}
	}
}
