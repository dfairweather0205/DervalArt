<?php

namespace Pikart\WpThemeCore\Admin\Media;

use Pikart\WpThemeCore\Common\CoreAssetHandle;

if ( ! class_exists( __NAMESPACE__ . '\CustomGalleryImage' ) ) {

	/**
	 * Class CustomGalleryImage
	 * @package Pikart\WpThemeCore\Admin\Media
	 */
	class CustomGalleryImage {

		/**
		 * @var bool
		 */
		private $setupDone = false;

		/**
		 * @var AttachmentsMetaFacade
		 */
		private $attachmentsMetaFacade;

		/**
		 * CustomGalleryImage constructor.
		 *
		 * @param AttachmentsMetaFacade $attachmentsMetaFacade
		 */
		public function __construct( AttachmentsMetaFacade $attachmentsMetaFacade ) {
			$this->attachmentsMetaFacade = $attachmentsMetaFacade;
		}

		public function setup() {
			if ( $this->setupDone ) {
				return;
			}

			$this->enqueueScripts();
			$this->setupDone = true;
		}

		/**
		 * @param string $id id of the gallery
		 * @param int $imageId
		 * @param string $name name of the gallery
		 *
		 * @return string
		 */
		public function generateGalleryImageHtml( $id, $imageId, $name = '' ) {
			$imgTagPattern = '<img src="%s" class="attachment-thumbnail size-thumbnail" height="100px" />';

			$html =
				'<span class="pikart-gallery-image-container">
					<a href="#" class="pikart-gallery-image-select">%s</a>
					<a href="#" class="pikart-gallery-image-remove" style="display: %s">%s</a>
					<input type="hidden" name="%s" id="%s" value="%s"/>
					%s
				</span>';

			$name    = empty( $name ) ? $id : $name;
			$imgUrl  = wp_get_attachment_url( $imageId );
			$imgTag  = $imgUrl ? sprintf( $imgTagPattern, esc_url( $imgUrl ) ) : '';
			$display = empty( $imageId ) ? 'none' : '';

			return sprintf(
				$html,
				esc_html__( 'Select', 'nels' ),
				$display,
				esc_html__( 'Remove', 'nels' ),
				esc_attr( $name ),
				esc_attr( $id ),
				esc_attr( $imageId ),
				$imgTag
			);
		}

		private function enqueueScripts() {
			add_action( 'admin_enqueue_scripts', function ( $hook ) {
				$allowedHooks = apply_filters(
					MediaFilter::customGalleryImageHooks(), array( 'post-new.php', 'post.php' ) );

				if ( in_array( $hook, $allowedHooks ) ) {
					wp_enqueue_media();
					wp_enqueue_script( CoreAssetHandle::customGalleryImage() );
				}
			} );
		}
	}
}