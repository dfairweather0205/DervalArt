<?php

namespace Pikart\WpThemeCore\WpBakery;

use Pikart\WpThemeCore\Post\PostFilterName;

if ( ! class_exists( __NAMESPACE__ . '\WpBakeryUtil' ) ) {

	/**
	 * Class WpBakeryUtil
	 * @package Pikart\WpThemeCore\WpBakery
	 *
	 * @since 1.3.0
	 */
	class WpBakeryUtil {

		/**
		 * @return bool
		 */
		public static function isWpBakeryActivated() {
			return defined( 'WPB_VC_VERSION' );
		}

		/**
		 * @return bool
		 */
		public static function isVcPageEditable() {
			return self::isWpBakeryActivated() && vc_is_page_editable();
		}

		/**
		 * save the_content hook in a new filter and use it later, because VC removes all the filters attached to it
		 * when using frontendEditor
		 */
		public static function setupContentFilterWhenFrontendEditorEnabled() {
			add_action( 'wp', function () {
				if ( ! WpBakeryUtil::isVcPageEditable() ) {
					return;
				}

				$contentFilter                          = 'the_content_saved';
				$GLOBALS['wp_filter'][ $contentFilter ] = clone $GLOBALS['wp_filter']['the_content'];

				add_filter( PostFilterName::contentFilterName(), function () use ( $contentFilter ) {
					return $contentFilter;
				} );
			} );
		}
	}
}
