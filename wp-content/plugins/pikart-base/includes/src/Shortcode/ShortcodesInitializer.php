<?php

namespace Pikart\WpBase\Shortcode;

use Pikart\WpBase\Common\AssetHandle;
use Pikart\WpBase\Common\PluginPathsUtil;
use Pikart\WpBase\OptionsPages\OptionsPagesUtil;
use Pikart\WpCore\Shortcode\ShortcodeConfig;
use Pikart\WpCore\Shortcode\ShortcodeFilterName;

if ( ! class_exists( __NAMESPACE__ . '\\ShortcodesInitializer' ) ) {

	/**
	 * Class ShortcodesInitializer
	 * @package Pikart\WpBase\Shortcode
	 */
	class ShortcodesInitializer {

		const SHORTCODES_JS_CONFIG_PATTERN =
			'<script type="text/javascript">var pikartShortcodes={%s}, pikartShortcodePrefix="%s", pikartDummyEditorId = "%s"</script>';
		const JS_OBJECT_PROPERTY_PATTERN = '"%s": %s';

		/**
		 * @since 1.5.7
		 */
		const DUMMY_EDITOR_ID = 'pikart_dummy_editor';

		/**
		 * @var ShortcodeRegister
		 */
		private $shortcodeRegister;

		/**
		 * @var ShortcodesProvider
		 */
		private $shortcodesProvider;

		/**
		 * @var OptionsPagesUtil
		 */
		private $optionsPagesUtil;

		/**
		 * @var \Closure
		 */
		private $shortcodesEnabledCallback;

		/**
		 * ShortcodesInitializer constructor.
		 *
		 * @param ShortcodeRegister $shortcodeRegister
		 * @param ShortcodesProvider $shortcodesProvider
		 * @param OptionsPagesUtil $optionsPagesUtil
		 */
		public function __construct(
			ShortcodeRegister $shortcodeRegister,
			ShortcodesProvider $shortcodesProvider,
			OptionsPagesUtil $optionsPagesUtil
		) {
			$this->shortcodeRegister  = $shortcodeRegister;
			$this->shortcodesProvider = $shortcodesProvider;
			$this->optionsPagesUtil   = $optionsPagesUtil;

			$this->shortcodesEnabledCallback = function () {
				return apply_filters( ShortcodeFilterName::shortcodesEnabled(), true );
			};
		}

		public function initialize() {
			$this->registerShortcodes();
			$this->initAdmin();

			$optionsPagesUtil          = $this->optionsPagesUtil;
			$shortcodesEnabledCallback = $this->shortcodesEnabledCallback;

			add_action( 'init', function () use ( $optionsPagesUtil, $shortcodesEnabledCallback ) {
				if ( ! $shortcodesEnabledCallback() ) {
					return;
				}

				add_action( 'wp_enqueue_scripts', function () use ( $optionsPagesUtil ) {
					wp_enqueue_script( AssetHandle::shortcodes() );

					wp_localize_script( AssetHandle::shortcodes(),
						PIKART_SLUG . 'ShortcodesOptions', array(
							'googleMapsPinImage' => esc_url( $optionsPagesUtil->getGoogleMapsPinImageUrl() )
						)
					);
				} );

				add_filter( 'widget_text', 'do_shortcode' );

				add_filter( 'widget_text_content', function ( $text ) {

					$patterns = array(
						'/^<p>/i',
						'/<\/p>$/i',
					);

					return trim( preg_replace( $patterns, '', $text ) );
				} );
			} );

			$this->addDummyMetaBox();
		}

		private function registerShortcodes() {
			$shortcodesProvider        = $this->shortcodesProvider;
			$shortcodeRegister         = $this->shortcodeRegister;
			$shortcodesEnabledCallback = $this->shortcodesEnabledCallback;

			add_action( 'init', function () use ( $shortcodesProvider, $shortcodeRegister, $shortcodesEnabledCallback ) {
				if ( ! $shortcodesEnabledCallback() ) {
					return;
				}

				$shortcodes = $shortcodesProvider->getShortcodes();

				foreach ( $shortcodes as $shortcode ) {
					$shortcodeRegister->register( $shortcode );
				}
			} );
		}

		private function initAdmin() {
			if ( ! is_admin() ) {
				return;
			}

			$mceButtonsCallback         = $this->generateMceButtonsCallback();
			$shortcodesConfigJsCallback = $this->generateShortcodesConfigJsCallback();
			$enqueueAdminAssetsCallback = $this->enqueueAdminAssetsCallback();
			$shortcodesEnabledCallback  = $this->shortcodesEnabledCallback;

			add_action( 'init', function () use (
				$mceButtonsCallback, $shortcodesConfigJsCallback, $enqueueAdminAssetsCallback, $shortcodesEnabledCallback
			) {
				if ( ! $shortcodesEnabledCallback() ) {
					return;
				}

				if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
					return;
				}

				if ( get_user_option( 'rich_editing' ) !== 'true' ) {
					return;
				}

				add_filter( 'mce_external_plugins', function ( $plugins ) {
					$plugins['custom_ui_types'] =
						PluginPathsUtil::getJsUrl( 'tinymce/custom-ui-types.js?ver=' . PIKART_BASE_VERSION );

					$plugins[ ShortcodeConfig::NAME_PREFIX . 'shortcodes' ] =
						PluginPathsUtil::getJsUrl( 'admin/shortocodes-plugin.js?ver=' . PIKART_BASE_VERSION );

					return $plugins;
				} );

				add_filter( 'mce_buttons_3', $mceButtonsCallback );

				foreach ( array( 'post.php', 'post-new.php' ) as $hook ) {
					add_action( 'admin_head-' . $hook, $shortcodesConfigJsCallback );
				}

				$enqueueAdminAssetsCallback();
			} );
		}

		private function enqueueAdminAssetsCallback() {
			return function () {
				// admin_enqueue_scripts is not working
				add_action( 'admin_head', function () {

					wp_enqueue_style( AssetHandle::jqueryUi() );
					wp_enqueue_style( AssetHandle::adminShortcodesStyle() );
					wp_enqueue_style( AssetHandle::fontAwesome() );
					wp_enqueue_style( AssetHandle::multipleSelect() );

					if ( is_rtl() ) {
						wp_enqueue_style( AssetHandle::adminShortcodesRtlStyle() );
					}
				} );

				add_action( 'admin_enqueue_scripts', function () {
					wp_enqueue_script( AssetHandle::limitSlider() );
					wp_enqueue_script( AssetHandle::jqueryUiTabs() );
					wp_enqueue_script( AssetHandle::multipleSelect() );
				} );
			};
		}

		private function generateMceButtonsCallback() {
			$shortcodesProvider = $this->shortcodesProvider;

			return function ( $buttons ) use ( $shortcodesProvider ) {
				$shortcodes = $shortcodesProvider->getShortcodes();
				ksort( $shortcodes );

				foreach ( $shortcodes as $shortcode ) {
					$buttons[] = $shortcode->getName();
				}

				return $buttons;
			};
		}

		private function generateShortcodesConfigJsCallback() {
			$shortcodesProvider        = $this->shortcodesProvider;
			$shortcodesJsConfigPattern = static::SHORTCODES_JS_CONFIG_PATTERN;
			$jsObjectPropertyPattern   = static::JS_OBJECT_PROPERTY_PATTERN;

			return function () use (
				$shortcodesProvider, $shortcodesJsConfigPattern, $jsObjectPropertyPattern
			) {
				$shortcodes = array();

				foreach ( $shortcodesProvider->getShortcodes() as $shortcode ) {
					$shortcodeConfig = array(
						'name'          => $shortcode->getName(),
						'isSelfClosing' => $shortcode->isSelfClosing(),
						'attributes'    => $shortcode->getAttributesConfig()
					);

					$shortcodes[] = sprintf(
						$jsObjectPropertyPattern,
						$shortcode->getName(),
						wp_json_encode( $shortcodeConfig )
					);
				}

				printf( $shortcodesJsConfigPattern,
					implode( ',', $shortcodes ),
					ShortcodeConfig::NAME_PREFIX,
					ShortcodesInitializer::DUMMY_EDITOR_ID
				);
			};
		}

		/**
		 * @since 1.5.7
		 */
		private function addDummyMetaBox() {
			$shortcodesEnabledCallback = $this->shortcodesEnabledCallback;

			add_action( 'wp_enqueue_editor', function () use ( $shortcodesEnabledCallback ) {
				if ( ! $shortcodesEnabledCallback() ) {
					return;
				}

				add_action( 'add_meta_boxes', function () {
					add_meta_box( 'pikart_dummy_meta_box', 'dummy', function () {
						wp_editor( '', ShortcodesInitializer::DUMMY_EDITOR_ID );
					}, null, 'normal', 'high' );
				} );
			} );
		}
	}
}