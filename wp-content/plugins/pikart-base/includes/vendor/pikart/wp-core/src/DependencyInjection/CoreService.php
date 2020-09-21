<?php

namespace Pikart\WpCore\DependencyInjection;

use Pikart\WpCore\Admin\Media\AttachmentsUtil;
use Pikart\WpCore\Admin\Media\CustomGalleryImage;
use Pikart\WpCore\Admin\MetaBoxes\MetaBoxFacade;
use Pikart\WpCore\Admin\Sidebars\SidebarUtil;
use Pikart\WpCore\Common\CoreAssetsRegister;
use Pikart\WpCore\Common\DataSanitizer;
use Pikart\WpCore\Common\ThemeUtil;
use Pikart\WpCore\Common\Util;
use Pikart\WpCore\Post\Dal\PostRepository;
use Pikart\WpCore\Post\Dal\ProjectRepository;
use Pikart\WpCore\Post\PostUtil;
use Pikart\WpCore\ThemeOptions\ThemeOptionsCoreUtil;
use Pikart\WpCore\ThemeOptions\ThemeOptionsFacade;

if ( ! class_exists( __NAMESPACE__ . '\\CoreService' ) ) {

	/**
	 * Service container wrapper used for service type hinting
	 *
	 * Class CoreService
	 * @package Pikart\WpCore\Common
	 */
	class CoreService {

		/**
		 * @return Util
		 */
		public static function util() {
			return static::getService( 'util' );
		}

		/**
		 * @return DataSanitizer
		 */
		public static function dataSanitizer() {
			return static::getService( 'dataSanitizer' );
		}

		/**
		 * @return CoreAssetsRegister
		 */
		public static function coreAssetsRegister() {
			return static::getService( 'coreAssetsRegister' );
		}

		/**
		 * @return MetaBoxFacade
		 */
		public static function metaBoxFacade() {
			return static::getService( 'metaBoxFacade' );
		}

		/**
		 * @return ThemeOptionsFacade
		 */
		public static function themeOptionsFacade() {
			return static::getService( 'themeOptionsFacade' );
		}

		/**
		 * @return ThemeOptionsCoreUtil
		 */
		public static function themeOptionsCoreUtil() {
			return static::getService( 'themeOptionsCoreUtil' );
		}

		/**
		 * @return PostUtil
		 */
		public static function postUtil() {
			return static::getService( 'postUtil' );
		}

		/**
		 * @return AttachmentsUtil
		 */
		public static function attachmentsUtil() {
			return static::getService( 'attachmentsUtil' );
		}

		/**
		 * @return ProjectRepository
		 */
		public static function projectRepository() {
			return static::getService( 'projectRepository' );
		}

		/**
		 * @return PostRepository
		 */
		public static function postRepository() {
			return static::getService( 'postRepository' );
		}

		/**
		 * @return ThemeUtil
		 */
		public static function themeUtil() {
			return static::getService( 'themeUtil' );
		}

		/**
		 * @since 1.1.0
		 *
		 * @return SidebarUtil
		 */
		public static function sidebarUtil() {
			return static::getService( 'sidebarUtil' );
		}

		/**
		 * @since 1.1.0
		 *
		 * @return CustomGalleryImage
		 */
		public static function customGalleryImage() {
			return static::getService( 'customGalleryImage' );
		}

		/**
		 * @param string $service
		 *
		 * @return object
		 */
		protected static function getService( $service ) {
			static $container;

			if ( null === $container ) {
				$container = new CoreServiceContainer();
			}

			return $container->getService( $service );
		}
	}
}