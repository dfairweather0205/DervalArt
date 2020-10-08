<?php

namespace Pikart\WpCore\Common;

if ( ! class_exists( __NAMESPACE__ . '\\HierarchicalConfigBuilder' ) ) {

	/**
	 * Class HierarchicalConfigBuilder
	 * @package Pikart\WpCore\Common
	 */
	abstract class HierarchicalConfigBuilder {

		/**
		 * @var array
		 */
		private $config = array();

		/**
		 * @var array
		 */
		private $item = array();

		/**
		 * @var HierarchicalConfigBuilder
		 */
		protected $childConfigBuilder;

		/**
		 * @var HierarchicalConfigBuilder
		 */
		protected $parentConfigBuilder;

		/**
		 * @param $id
		 *
		 * @return $this
		 */
		public function id( $id ) {
			return $this->updateItem( 'id', $id );
		}

		/**
		 * @param bool $enabled
		 *
		 * @return $this
		 */
		public function enabled( $enabled ) {
			return $this->updateItem( 'enabled', (bool) $enabled );
		}

		/**
		 * @param bool $ignoreParentConfigBuilder
		 *
		 * @return array
		 */
		public function build( $ignoreParentConfigBuilder = false ) {
			$this->saveItem();

			if ( ! $ignoreParentConfigBuilder && null !== $this->parentConfigBuilder ) {
				$config                    = $this->parentConfigBuilder->build( false );
				$this->parentConfigBuilder = null;

				return $config;
			}

			$config       = $this->config;
			$this->config = array();

			return $config;
		}

		/**
		 * @return string
		 */
		protected function getChildrenItemsKeyName() {
			return null;
		}

		/**
		 * @param                   $id
		 * @param HierarchicalConfigBuilder $parentConfigBuilder
		 *
		 * @return $this
		 */
		protected function newItem( $id, $parentConfigBuilder = null ) {
			$this->saveItem();
			$this->id( $id );
			$this->enabled( true );

			if ( null === $this->parentConfigBuilder ) {
				$this->parentConfigBuilder = $parentConfigBuilder;
			}

			return $this;
		}

		/**
		 * @param string $key
		 * @param mixed $val
		 *
		 * @return $this
		 */
		protected function updateItem( $key, $val ) {
			$this->item[ $key ] = $val;

			return $this;
		}

		/**
		 * @param string $key
		 * @param string $subKey
		 * @param mixed $val
		 *
		 * @return $this
		 */
		protected function updateSubItem( $key, $subKey, $val ) {

			if ( ! isset( $this->item[ $key ] ) ) {
				$this->item[ $key ] = array();
			}

			$this->item[ $key ][ $subKey ] = $val;

			return $this;
		}

		/**
		 * @param string $key
		 * @param mixed $default
		 *
		 * @return mixed
		 */
		protected function getItem( $key, $default ) {
			if ( ! isset( $this->item[ $key ] ) ) {
				$this->updateItem( $key, $default );
			}

			return $this->item[ $key ];
		}

		private function saveItem() {
			if ( empty( $this->item ) || ! isset( $this->item['enabled'] ) || ! $this->item['enabled'] ) {
                $this->item = array();
				return;
			}

			if ( null !== $this->childConfigBuilder ) {
				$childConfig = $this->childConfigBuilder->build( true );

				if ( ! empty( $childConfig ) ) {
					$this->item[ $this->getChildrenItemsKeyName() ] = $childConfig;
				}
			}

			$this->config[ $this->item['id'] ] = $this->item;
			$this->item                        = array();
		}

	}
}
