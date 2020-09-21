<?php

namespace Pikart\WpCore\DependencyInjection;

use Pikart\WpCore\Common\CorePathsUtil;

if ( ! class_exists( __NAMESPACE__ . '\\CoreServiceContainer' ) ) {
	/**
	 * Class CoreServiceContainer
	 * @package Pikart\WpCore\DependencyInjection
	 */
	class CoreServiceContainer {
		const CORE_SERVICES_FILE = 'core-services.xml';
		const CORE_CONTAINER_CACHE_FILE = 'container.php';

		/**
		 * @var ProjectServiceContainer
		 */
		private $container;

		/**
		 * @param string $serviceName
		 *
		 * @return object
		 */
		public function getService( $serviceName ) {
			$this->loadContainer();

			return $this->container->get( $serviceName );
		}

		/**
		 * override this method to add your own service files
		 *
		 * @return string|array
		 */
		protected function getServiceFiles() {
			return array();
		}

		/**
		 * override this method to add your own service folders
		 *
		 * string|array
		 */
		protected function getServiceDirs() {
			return array();
		}

		/**
		 * override this method only when you want to have multiple subclasses of this container
		 *
		 * @return string
		 */
		protected function getContainerCacheFile() {
			return CorePathsUtil::getCacheDir( self::CORE_CONTAINER_CACHE_FILE );
		}

		/**
		 * override this method only when you want to have multiple subclasses of this container
		 *
		 * @return string
		 */
		protected function getContainerNamespace() {
			return __NAMESPACE__;
		}

		private function loadContainer() {
			if ( null !== $this->container ) {
				return;
			}

			$containerCacheFile = $this->getContainerCacheFile();
			$containerNamespace = $this->getContainerNamespace();

			require_once $containerCacheFile;
			$containerClass = $containerNamespace . '\ProjectServiceContainer';

			$this->container = new $containerClass();
		}

		/**
		 * @return array
		 */
		private function getAllServiceDirs() {
			return $this->addItemToData( $this->getServiceDirs(), CorePathsUtil::getResourcesDir() );
		}

		/**
		 * @return array
		 */
		private function getAllServiceFiles() {
			return $this->addItemToData( $this->getServiceFiles(), self::CORE_SERVICES_FILE );
		}

		/**
		 * @param $data
		 * @param $item
		 *
		 * @return array
		 */
		private function addItemToData( $data, $item ) {
			if ( ! is_array( $data ) ) {
				$data = empty( $data ) ? array() : array( $data );
			}

			$data[] = $item;

			return $data;
		}
	}
}