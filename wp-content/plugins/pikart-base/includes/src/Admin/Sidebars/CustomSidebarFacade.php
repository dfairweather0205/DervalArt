<?php

namespace Pikart\WpBase\Admin\Sidebars;

use Pikart\WpBase\Common\AssetHandle;
use Pikart\WpCore\Admin\Sidebars\CustomSidebarConfig;
use Pikart\WpCore\Admin\Sidebars\SidebarFilterName;
use Pikart\WpCore\Admin\Sidebars\SidebarUtil;
use Pikart\WpCore\Common\Util;

if ( ! class_exists( __NAMESPACE__ . '\\CustomSidebarFacade' ) ) {

	/**
	 * Class CustomSidebarFacade
	 * @package Pikart\WpBase\Admin\Sidebars
	 */
	class CustomSidebarFacade {

		const NONCE_ACTION = 'manage_custom_sidebar';
		const NONCE_NAME = 'pikart_custom_sidebar_nonce';

		/**
		 * @var string[]
		 */
		private $customSidebars;

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * SidebarFacade constructor.
		 *
		 * @param Util $util
		 * @param SidebarUtil $sidebarUtil
		 */
		public function __construct( Util $util, SidebarUtil $sidebarUtil ) {
			$this->util           = $util;
			$this->customSidebars = $sidebarUtil->getCustomSidebars();
		}

		public function manageCustomSidebars() {
			$this->generateSidebarForm();
			$this->processAddCustomSidebarRequest();
			$this->registerCustomSidebars();
			$this->enqueueAssets();
			$this->addDeleteCustomSidebarButton();
			$this->processDeleteCustomSidebarCall();
		}

		private function processAddCustomSidebarRequest() {
			$customSidebars = &$this->customSidebars;

			add_action( 'widgets_init', function () use ( &$customSidebars ) {
				if ( ! filter_input( INPUT_POST, 'add_custom_sidebar', FILTER_SANITIZE_STRING ) ) {
					return;
				}

				$nonceValue   = filter_input( INPUT_POST, CustomSidebarFacade::NONCE_NAME, FILTER_SANITIZE_STRING );
				$isValidNonce = $nonceValue && wp_verify_nonce( $nonceValue, CustomSidebarFacade::NONCE_ACTION );
				$sidebarName  = trim( filter_input( INPUT_POST, 'sidebar_name', FILTER_SANITIZE_STRING ) );

				if ( current_user_can( 'edit_theme_options' ) && $isValidNonce && $sidebarName ) {
					$sidebarId = CustomSidebarConfig::getSidebarNamePrefix() . uniqid();

					$customSidebars[ $sidebarId ] = $sidebarName;

					update_option( CustomSidebarConfig::getSidebarsOptionKey(), $customSidebars );
				}
			} );
		}

		private function registerCustomSidebars() {
			$customSidebars = &$this->customSidebars;

			add_action( 'widgets_init', function () use ( &$customSidebars ) {
				foreach ( $customSidebars as $sidebarId => $sidebarName ) {

					$arguments = apply_filters( SidebarFilterName::customSidebarArguments(), array(
						'name'        => $sidebarName,
						'description' => esc_html__( 'Add widgets here.', 'pikart-base' )
					), $sidebarId );

					$arguments['id'] = $sidebarId;

					register_sidebar( $arguments );
				}
			}, 11 );
		}

		private function generateSidebarForm() {
			$util = $this->util;

			add_action( 'widgets_admin_page', function () use ( $util ) {
				$util->pluginPartial( PIKART_BASE_PATH, 'sidebars/custom-sidebar-form' );
			} );
		}

		private function enqueueAssets() {
			add_action( 'admin_enqueue_scripts', function ( $hook ) {

				if ( $hook !== 'widgets.php' ) {
					return;
				}

				wp_enqueue_style( AssetHandle::adminCustomSidebarsStyle() );

				if ( is_rtl() ) {
					wp_enqueue_style( AssetHandle::adminCustomSidebarsRtlStyle() );
				}

				wp_enqueue_script( AssetHandle::adminCustomSidebars() );

				wp_localize_script( AssetHandle::adminCustomSidebars(), PIKART_SLUG . 'CustomSidebarsOptions', array(
					'messages' => array(
						'confirmationMessage' => esc_html__( 'Do you really want to delete the sidebar?', 'pikart-base' )
					)
				) );
			} );
		}

		private function addDeleteCustomSidebarButton() {
			$sidebarNamePrefix = CustomSidebarConfig::getSidebarNamePrefix();

			add_action( 'dynamic_sidebar_before', function ( $sidebarId ) use ( $sidebarNamePrefix ) {
				if ( ! is_admin() || strpos( $sidebarId, $sidebarNamePrefix ) !== 0 ) {
					return;
				}

				printf( '<button class="custom-sidebar-delete-button" value="%s" >%s</button>',
					esc_attr( $sidebarId ), esc_html__( 'Delete', 'pikart-base' ) );
			} );

		}

		private function processDeleteCustomSidebarCall() {
			$customSidebars    = &$this->customSidebars;
			$sidebarsOptionKey = CustomSidebarConfig::getSidebarsOptionKey();

			add_action( 'wp_ajax_' . PIKART_SLUG . '_custom_sidebar_delete_ajax', function () use (
				&$customSidebars, $sidebarsOptionKey
			) {
				$nonceValue = filter_input( INPUT_POST, CustomSidebarFacade::NONCE_NAME, FILTER_SANITIZE_STRING );
				$sidebarId  = filter_input( INPUT_POST, 'custom_sidebar_id', FILTER_SANITIZE_STRING );

				if ( ! $nonceValue || ! wp_verify_nonce( $nonceValue, CustomSidebarFacade::NONCE_ACTION )
				     || ! $sidebarId ) {
					wp_send_json_error();
				}

				if ( isset( $customSidebars[ $sidebarId ] ) ) {
					unset( $customSidebars[ $sidebarId ] );
					update_option( $sidebarsOptionKey, $customSidebars );
				}

				wp_send_json_success();
			} );
		}
	}
}