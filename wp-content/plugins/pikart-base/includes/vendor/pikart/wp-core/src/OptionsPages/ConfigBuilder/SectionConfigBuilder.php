<?php

namespace Pikart\WpCore\OptionsPages\ConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\SectionConfigBuilder' ) ) {
	/**
	 * Class SectionConfigBuilder
	 * @package Pikart\WpCore\OptionsPages\ConfigBuilder
	 */
	class SectionConfigBuilder extends ItemConfigBuilder {

		/**
		 * @var PageConfigBuilder
		 */
		protected $parentConfigBuilder;

		/**
		 * @var ControlConfigBuilder
		 */
		protected $childConfigBuilder;

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
		 * @param PageConfigBuilder $pageConfigBuilder
		 *
		 * @return SectionConfigBuilder
		 */
		public function section( $id = '', $pageConfigBuilder = null ) {
			return $this->newItem( $id, $pageConfigBuilder );
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
		 * @return PageConfigBuilder
		 */
		public function page( $id = '' ) {
			return $this->parentConfigBuilder->page( $id );
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
