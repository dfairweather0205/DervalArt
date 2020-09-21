<?php

namespace Pikart\WpCore\OptionsPages\ConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\PageConfigBuilder' ) ) {
	/**
	 * Class PageConfigBuilder
	 * @package Pikart\WpCore\OptionsPages\ConfigBuilder
	 */
	class PageConfigBuilder extends ItemConfigBuilder {

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
		 * @return PageConfigBuilder
		 */
		public function page( $id = '' ) {
			return $this->newItem( $id );
		}

		/**
		 * @param array $sections
		 *
		 * @return PageConfigBuilder
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
		 * @param string $capability
		 *
		 * @return $this
		 */
		public function capability( $capability ) {
			return $this->updateItem( 'capability', $capability );
		}

		/**
		 * @param string $menuTitle
		 *
		 * @return $this
		 */
		public function menuTitle( $menuTitle ) {
			return $this->updateItem( 'menu_title', $menuTitle );
		}

		/**
		 * @param string $titleTagText
		 *
		 * @return $this
		 */
		public function titleTagText( $titleTagText ) {
			return $this->updateItem( 'title_tag_text', $titleTagText );
		}

		/**
		 * @param string $menuParentId
		 *
		 * @return $this
		 */
		public function menuParentId( $menuParentId ) {
			return $this->updateItem( 'menu_parent_id', $menuParentId );
		}

		/**
		 * @param callable $callback
		 *
		 * @return $this
		 */
		public function callback( $callback ) {
			return $this->updateItem( 'callback', $callback );
		}

		/**
		 * @param string $iconUrl
		 *
		 * @return $this
		 */
		public function iconUrl( $iconUrl ) {
			return $this->updateItem( 'icon_url', $iconUrl );
		}

		/**
		 * @param int $position
		 *
		 * @return $this
		 */
		public function position( $position ) {
			return $this->updateItem( 'position', (int) $position );
		}

		/**
		 * @param string $partial
		 *
		 * @return $this
		 */
		public function themePartial( $partial, $partialDataVarName = 'pikartOptionsPageData' ) {
			return $this->updateItem( 'theme_partial', $partial )
			            ->updateItem( 'partial_data_var', $partialDataVarName );
		}

		/**
		 * @param string $partial
		 * @param string $pluginBaseDir
		 *
		 * @return $this
		 */
		public function pluginPartial( $partial, $pluginBaseDir, $partialDataVarName = 'pikartOptionsPageData' ) {
			return $this->updateItem( 'plugin_partial', $partial )
			            ->updateItem( 'plugin_base_dir', $pluginBaseDir )
			            ->updateItem( 'partial_data_var', $partialDataVarName );
		}

		/**
		 * @return string
		 */
		protected function getChildrenItemsKeyName() {
			return 'sections';
		}
	}
}
