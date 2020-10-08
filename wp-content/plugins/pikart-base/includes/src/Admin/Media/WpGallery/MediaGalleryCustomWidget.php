<?php

namespace Pikart\WpBase\Admin\Media\WpGallery;

/** Media Gallery Widget is available @since 4.9 */
if ( ! class_exists( __NAMESPACE__ . '\\MediaGalleryCustomWidget' )
     && version_compare( $GLOBALS['wp_version'], '4.9', '>=' ) ) {

	/**
	 * Class MediaGalleryCustomWidget
	 * @package Pikart\Ombra\Widgets
	 */
	class MediaGalleryCustomWidget extends \WP_Widget_Media_Gallery {

		/**
		 * @var WpGalleryShortcodeContentFilter
		 */
		private $wpGalleryShortcodeContentFilter;

		/**
		 * MediaGalleryCustomWidget constructor.
		 *
		 * @param WpGalleryShortcodeContentFilter $wpGalleryShortcodeContentFilter
		 */
		public function __construct( WpGalleryShortcodeContentFilter $wpGalleryShortcodeContentFilter ) {
			parent::__construct();
			$this->wpGalleryShortcodeContentFilter = $wpGalleryShortcodeContentFilter;
		}

		/**
		 * @inheritdoc
		 */
		public function render_media( $instance ) {
			$instance = array_merge( wp_list_pluck( $this->get_instance_schema(), 'default' ), $instance );

			$attributes = array_merge(
				$instance,
				array(
					'link' => $instance['link_type'],
				)
			);

			if ( $instance['orderby_random'] ) {
				$attributes['orderby'] = 'rand';
			}

			$content = gallery_shortcode( $attributes );

			print( $this->wpGalleryShortcodeContentFilter->filter( $content, $attributes ) );
		}
	}
}
