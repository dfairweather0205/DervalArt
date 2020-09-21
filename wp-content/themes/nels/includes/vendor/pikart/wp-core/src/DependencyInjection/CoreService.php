<?php

namespace Pikart\WpThemeCore\DependencyInjection;

use Pikart\WpThemeCore\Admin\Media\AttachmentsUtil;
use Pikart\WpThemeCore\Admin\Media\CustomGalleryImage;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxFacade;
use Pikart\WpThemeCore\Admin\Sidebars\SidebarUtil;
use Pikart\WpThemeCore\Common\CoreAssetsRegister;
use Pikart\WpThemeCore\Common\DataSanitizer;
use Pikart\WpThemeCore\Common\ThemeUtil;
use Pikart\WpThemeCore\Common\Util;
use Pikart\WpThemeCore\Post\Dal\PostRepository;
use Pikart\WpThemeCore\Post\Dal\ProjectRepository;
use Pikart\WpThemeCore\Post\PostUtil;
use Pikart\WpThemeCore\ThemeOptions\ThemeOptionsCoreUtil;
use Pikart\WpThemeCore\ThemeOptions\ThemeOptionsFacade;

if ( ! class_exists( __NAMESPACE__ . '\\CoreService' ) ) {

	/**
	 * Service container wrapper used for service type hinting
	 *
	 * Class CoreService
	 * @package Pikart\WpThemeCore\Common
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