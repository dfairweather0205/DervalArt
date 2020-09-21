<?php

namespace Pikart\WpThemeCore\Admin\Media;

use Pikart\WpThemeCore\Common\CoreAssetHandle;

if ( ! class_exists( __NAMESPACE__ . '\CustomGallery' ) ) {
	/**
	 * Class CustomGallery
	 * @package Pikart\WpThemeCore\Admin\Media
	 */
	class CustomGallery {

		const NONCE_ACTION = 'update_pikart_gallery';
		const NONCE_NAME = 'pikart_gallery_nonce';

		/**
		 * @var bool
		 */
		private $setupDone = false;

		/**
		 * @var AttachmentsMetaFacade
		 */
		private $attachmentsMetaFacade;

		/**
		 * @var AttachmentsMetaConfigBuilder
		 */
		private $metaConfigBuilder;

		/**
		 * CustomGallery constructor.
		 *
		 * @param AttachmentsMetaFacade $attachmentsMetaFacade
		 * @param AttachmentsMetaConfigBuilder $metaConfigBuilder
		 */
		public function __construct(
			AttachmentsMetaFacade $attachmentsMetaFacade, AttachmentsMetaConfigBuilder $metaConfigBuilder
		) {
			$this->attachmentsMetaFacade = $attachmentsMetaFacade;
			$this->metaConfigBuilder     = $metaConfigBuilder;
		}

		public function setup() {
			if ( $this->setupDone ) {
				return;
			}


			$this->registerGalleryUpdateAjax();
			$this->enqueueScripts();
			$this->setupMetaFields();

			$this->setupDone = true;
		}

		/**
		 * @param string $id id of the gallery
		 * @param array $imageIds list of image ids, ex: [10, 2, 34]
		 *
		 * @return string
		 */
		public function generateGalleryHtml( $id, array $imageIds ) {
			$html =
				'<div class="pikart-gallery-container">
					<a href="#" class="pikart-gallery-open">%s</a>
					<a href="#" class="pikart-gallery-reset">%s</a>
					<i class="icon-refresh" style="display: none"></i>
					<input type="hidden" name="%s" id="%s" value="%s"/>
					<ul class="pikart-gallery-images" %s >%s</ul>
				</div>';

			$html .= wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME, true, false );

			return sprintf(
				$html,
				esc_html__( 'Open', 'nels' ),
				esc_html__( 'Reset', 'nels' ),
				$id,
				$id,
				implode( ',', $imageIds ),
				empty( $imageIds ) ? 'style="display: none"' : '',
				$this->generateImageListHtml( $imageIds )
			);
		}

		/**
		 * @return array
		 */
		private function buildMetaFields() {
			return $this->metaConfigBuilder
				->text( CustomGalleryMeta::VIDEO_URL )
				->label( esc_html__( 'Video URL', 'nels' ) )
				->description( esc_html__( 'Enter Youtube or Vimeo link', 'nels' ) )
				->build();
		}

		private function registerGalleryUpdateAjax() {
			$nonceName   = self::NONCE_NAME;
			$nonceAction = self::NONCE_ACTION;

			$generateImageListHtmlCallback = $this->generateImageListHtmlCallback();

			add_action( 'wp_ajax_' . PIKART_SLUG . '_gallery_update_ajax', function () use (
				$nonceName, $nonceAction, $generateImageListHtmlCallback
			) {
				$nonceValue = filter_input( INPUT_POST, $nonceName, FILTER_SANITIZE_STRING );
				$imageIds   = filter_input( INPUT_POST, 'galleryIds', FILTER_UNSAFE_RAW, FILTER_REQUIRE_ARRAY );

				if ( ! $nonceValue || ! wp_verify_nonce( $nonceValue, $nonceAction ) || ! $imageIds ) {
					wp_send_json_error();
				}

				wp_send_json_success( $generateImageListHtmlCallback( $imageIds ) );
			} );
		}

		private function enqueueScripts() {
			add_action( 'admin_enqueue_scripts', function ( $hook ) {
				$allowedHooks = apply_filters(
					MediaFilter::customGalleryHooks(), array( 'post-new.php', 'post.php' ) );

				if ( in_array( $hook, $allowedHooks ) ) {
					wp_enqueue_media();
					wp_enqueue_script( CoreAssetHandle::customGallery() );
				}
			} );
		}

		/**
		 * @return \Closure
		 */
		private function generateImageListHtmlCallback() {
			return function ( $imageIds ) {
				return implode( '', array_map( function ( $imgId ) {
					return sprintf( '<li>%s</li>', wp_get_attachment_image( $imgId, 'thumbnail' ) );
				}, $imageIds ) );
			};
		}

		/**
		 * @param $imageIds
		 *
		 * @return mixed
		 */
		private function generateImageListHtml( $imageIds ) {
			$generateImageListHtmlCallback = $this->generateImageListHtmlCallback();

			return $generateImageListHtmlCallback( $imageIds );
		}

		/**
		 * @since 1.8.0
		 */
		private function setupMetaFields() {
			$attachmentsMetaFacade = $this->attachmentsMetaFacade;
			$metaFields            = $this->buildMetaFields();

			add_action( 'init', function () use ( $attachmentsMetaFacade, $metaFields ) {
				if ( apply_filters( MediaFilter::customGalleryVideoUrlEnabled(), true ) ) {
					$attachmentsMetaFacade->registerMetaFields( $metaFields, 'image' );
				}
			} );
		}
	}
}