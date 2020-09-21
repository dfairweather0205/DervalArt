<?php

namespace Pikart\WpCore\OptionsPages\ConfigBuilder;

use Pikart\WpCore\Common\HierarchicalConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\ItemConfigBuilder' ) ) {
	/**
	 * Class ItemConfigBuilder
	 * @package Pikart\WpCore\OptionsPages\ConfigBuilder
	 */
	abstract class ItemConfigBuilder extends HierarchicalConfigBuilder {

		/**
		 * @param $title
		 *
		 * @return $this
		 */
		public function title( $title ) {
			return $this->updateItem( 'title', $title );
		}

		/**
		 * @param $description
		 *
		 * @return $this
		 */
		public function description( $description ) {
			return $this->updateItem( 'description', $description );
		}
	}
}
