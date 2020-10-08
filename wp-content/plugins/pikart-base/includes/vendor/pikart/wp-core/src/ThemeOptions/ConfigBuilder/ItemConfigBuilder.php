<?php

namespace Pikart\WpCore\ThemeOptions\ConfigBuilder;

use Pikart\WpCore\Common\HierarchicalConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\ItemConfigBuilder' ) ) {
	/**
	 * Class ItemConfigBuilder
	 * @package Pikart\WpCore\ThemeOptions\ConfigBuilder
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

		/**
		 * @param $priority
		 *
		 * @return $this
		 */
		public function priority( $priority ) {
			return $this->updateItem( 'priority', $priority );
		}

		/**
		 * @param bool $builtIn
		 *
		 * @return $this
		 */
		public function builtIn( $builtIn ) {
			return $this->updateItem( 'built-in', $builtIn );
		}
	}
}
