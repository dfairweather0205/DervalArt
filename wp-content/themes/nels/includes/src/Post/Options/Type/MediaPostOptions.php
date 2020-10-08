<?php

namespace Pikart\Nels\Post\Options\Type;

use Pikart\WpThemeCore\Common\Util;

if ( ! class_exists( __NAMESPACE__ . '\\MediaPostOptions' ) ) {

	/**
	 * Class MediaPostOptions
	 * @package Pikart\Nels\Post\Options\Type
	 */
	abstract class MediaPostOptions extends CommonPostOptions {

		/**
		 * @return bool
		 */
		public function hasSource() {
			$source = $this->getSource();

			return ! empty( $source );
		}

		/**
		 * @return bool
		 */
		public function hasUrl() {
			return $this->hasSource() && Util::isUrl( $this->getSource() );
		}

		/**
		 * @return bool
		 */
		public function hasEmbedded() {
			return $this->hasSource() && ! Util::isUrl( $this->getSource() );
		}

		/**
		 * @return string
		 */
		abstract public function getSource();
	}
}