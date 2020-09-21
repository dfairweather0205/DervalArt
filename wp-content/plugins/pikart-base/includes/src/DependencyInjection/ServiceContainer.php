<?php

namespace Pikart\WpBase\DependencyInjection;

use Pikart\WpBase\Common\PluginPathsUtil;
use Pikart\WpCore\DependencyInjection\CoreServiceContainer;

if ( ! class_exists( __NAMESPACE__ . '\ServiceContainer' ) ) {

	/**
	 * Class ServiceContainer
	 * @package Pikart\WpBase\Common
	 */
	class ServiceContainer extends CoreServiceContainer {

		/**
		 * {@inheritdoc}
		 */
		protected function getServiceFiles() {
			return 'services.xml';
		}

		/**
		 * {@inheritdoc}
		 */
		protected function getServiceDirs() {
			return PluginPathsUtil::getResourcesDir();
		}

		/**
		 * @inheritdoc
		 */
		protected function getContainerCacheFile() {
			return PluginPathsUtil::getCacheDir( self::CORE_CONTAINER_CACHE_FILE );
		}

		protected function getContainerNamespace() {
			return __NAMESPACE__;
		}
	}
}