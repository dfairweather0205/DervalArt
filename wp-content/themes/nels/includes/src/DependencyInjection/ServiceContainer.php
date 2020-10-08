<?php

namespace Pikart\Nels\DependencyInjection;

use Pikart\WpThemeCore\Common\ThemePathsUtil;
use Pikart\WpThemeCore\DependencyInjection\CoreServiceContainer;

if ( ! class_exists( __NAMESPACE__ . '\ServiceContainer' ) ) {

	/**
	 * Class ServiceContainer
	 * @package Pikart\Nels\DependencyInjection
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
			return ThemePathsUtil::getResourcesDir();
		}

		/**
		 * @inheritdoc
		 */
		protected function getContainerCacheFile() {
			return ThemePathsUtil::getCacheDir( self::CORE_CONTAINER_CACHE_FILE );
		}

		protected function getContainerNamespace() {
			return __NAMESPACE__;
		}
	}
}