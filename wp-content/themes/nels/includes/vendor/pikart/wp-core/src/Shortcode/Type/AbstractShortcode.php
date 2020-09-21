<?php

namespace Pikart\WpThemeCore\Shortcode\Type;

use Pikart\WpThemeCore\Shortcode\ShortcodeActionName;
use Pikart\WpThemeCore\Shortcode\ShortcodeConfig;
use Pikart\WpThemeCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpThemeCore\Shortcode\ShortcodeFilterName;

if ( ! class_exists( __NAMESPACE__ . '\\AbstractShortcode' ) ) {

	/**
	 * Class AbstractShortcode
	 * @package Pikart\WpThemeCore\Shortcode\Type
	 */
	abstract class AbstractShortcode implements Shortcode {

		/**
		 * @var string
		 */
		private $name;

		/**
		 * @var string
		 */
		private $shortName;

		/**
		 * @var bool
		 */
		private $enabled = true;

		/**
		 * @var Shortcode[]
		 */
		private $childrenShortcodes = array();

		/**
		 * @var $attributesConfig
		 */
		private $attributesConfig = array();

		/**
		 * @var bool
		 */
		private $assetsEnqueued = false;

		/**
		 * AbstractShortcode constructor.
		 */
		public function __construct() {
			$this->name = $this->buildName();
		}

		/**
		 * @inheritdoc
		 */
		public function getName() {
			return $this->name;
		}

		/**
		 * @return string
		 */
		public function getShortName() {
			return $this->shortName;
		}

		/**
		 * @inheritdoc
		 */
		public function getAttributesConfig() {
			if ( empty( $this->attributesConfig ) ) {
				$builder = ShortcodeFieldConfigBuilder::instance();
				$this->buildDefaultAttributesConfig( $builder );

				do_action( ShortcodeActionName::attributesConfigBuild( $this->shortName ), $builder );

				$this->attributesConfig = apply_filters(
					ShortcodeFilterName::attributesConfig( $this->shortName ), $builder->build() );
			}

			return $this->attributesConfig;
		}

		/**
		 * @inheritdoc
		 */
		public function enabled() {
			return $this->enabled;
		}

		/**
		 * @inheritdoc
		 */
		public function getChildrenShortcodes() {
			return $this->childrenShortcodes;
		}

		public function enqueueAssets() {
			$cssAssetHandles = $this->getCssAssetHandles();
			$jsAssetHandles  = $this->getJsAssetHandles();

			if ( $this->assetsEnqueued || ( empty( $cssAssetHandles ) && empty( $jsAssetHandles ) ) ) {
				return;
			}

			array_walk( $cssAssetHandles, function ( $assetHandle ) {
				wp_enqueue_style( $assetHandle );
			} );

			array_walk( $jsAssetHandles, function ( $assetHandle ) {
				wp_enqueue_script( $assetHandle );
			} );

			$this->assetsEnqueued = true;
		}

		/**
		 * @inheritdoc
		 */
		public function processTemplateData( array &$data ) {
			//process data for template if needed
		}

		/**
		 * @return array
		 */
		protected function getCssAssetHandles() {
			return array();
		}

		/**
		 * @return array
		 */
		protected function getJsAssetHandles() {
			return array();
		}

		protected abstract function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder );

		protected function addChildShortcode( Shortcode $shortcode, $key = null ) {
			$key = $key ? $key : $shortcode->getName();

			$this->childrenShortcodes[ $key ] = $shortcode;

			if ( ! $shortcode->enabled() ) {
				$this->enabled = false;
			}
		}

		/**
		 * @param $key
		 *
		 * @return Shortcode
		 */
		protected function getChildShortcode( $key ) {
			return isset( $this->childrenShortcodes[ $key ] ) ? $this->childrenShortcodes[ $key ] : null;
		}

		/**
		 * @param Shortcode $shortcode
		 *
		 * @return array
		 */
		protected function getJsShortcodeConfig( Shortcode $shortcode ) {
			return array(
				'name'          => $shortcode->getName(),
				'isSelfClosing' => $shortcode->isSelfClosing(),
				'attributes'    => $shortcode->getAttributesConfig(),
			);
		}

		private function buildName() {
			$fullClassNameParts = explode( '\\', get_class( $this ) );

			$classNameParts = explode(
				'_', preg_replace( '/([a-z0-9])([A-Z])/', '$1_$2', $fullClassNameParts[4] ) );

			array_pop( $classNameParts );

			$this->shortName = strtolower( implode( '_', $classNameParts ) );

			return ShortcodeConfig::NAME_PREFIX. $this->shortName;
		}
	}
}