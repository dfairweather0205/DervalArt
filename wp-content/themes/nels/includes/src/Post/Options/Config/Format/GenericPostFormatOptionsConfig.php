<?php

namespace Pikart\Nels\Post\Options\Config\Format;

use Pikart\Nels\Post\Options\PostOptionsMetaBoxId;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Post\Options\Config\Format\PostFormatOptionsConfig;
use Pikart\WpThemeCore\Post\PostFilterName;

if ( ! class_exists( __NAMESPACE__ . '\\GenericPostFormatOptionsConfig' ) ) {

	/**
	 * Class GenericFormatOptionConfig
	 * @package Pikart\Nels\Post\Options\Config\Format
	 */
	abstract class GenericPostFormatOptionsConfig implements PostFormatOptionsConfig {

		/**
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 */
		public function buildMetaBoxesConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxId = PostOptionsMetaBoxId::postOptions( $this->getSlug() );

			$metaBoxConfigBuilder->metaBox( $metaBoxId, $this->getFormatSpecificMetaBoxTitle() );

			$this->buildFormatSpecificMetaBoxesConfig( $metaBoxConfigBuilder );
		}

		/**
		 * whether or not a format is enabled
		 *
		 * @return bool
		 */
		final public function enabled() {
			return apply_filters( PostFilterName::postFormatOptionsEnabled( $this->getSlug() ), true );
		}

		/**
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 */
		protected abstract function buildFormatSpecificMetaBoxesConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder );

		/**
		 * @return string
		 */
		protected abstract function getFormatSpecificMetaBoxTitle();
	}
}