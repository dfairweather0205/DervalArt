<?php

namespace Pikart\WpThemeCore\Admin\Media;

use Pikart\WpThemeCore\Post\Type\Format\PostFormatSlug;
use WP_Post;

if ( ! class_exists( __NAMESPACE__ . '\AttachmentsUtil' ) ) {

	/**
	 * Class AttachmentsUtil
	 * @package Pikart\WpThemeCore\Admin\Media
	 */
	class AttachmentsUtil {

		const DB_PREFIX = 'pikart_meta_';

		/**
		 * @param int $attachmentId
		 * @param string $fieldId
		 *
		 * @return string
		 */
		public function getMetaField( $attachmentId, $fieldId ) {
			// we use underscore to save the fields in order to not display them in the custom fields dropdown, hence
			// we need to prepend it before getting the meta value
			return get_post_meta( $attachmentId, '_' . self::DB_PREFIX . $fieldId, true );
		}

		/**
		 * @param int $attachmentId
		 * @param array $attributes
		 *
		 * @return string
		 */
		public function getEmbeddedAudio( $attachmentId = 0, $attributes = array() ) {
			return $this->getEmbeddedAudioBySrc( wp_get_attachment_url( $attachmentId ), $attributes );
		}

		/**
		 * @param int $attachmentId
		 * @param array $attributes
		 *
		 * @return string
		 */
		public function getEmbeddedVideo( $attachmentId = 0, $attributes = array() ) {
			return $this->getEmbeddedVideoBySrc( wp_get_attachment_url( $attachmentId ), $attributes );
		}

		/**
		 * @param string $src
		 * @param array $attributes
		 *
		 * @return string
		 */
		public function getEmbeddedAudioBySrc( $src, $attributes = array() ) {
			return do_shortcode(
				sprintf( '[audio src="%s" %s][/audio]', esc_url( $src ),
					$this->getShortcodeAttributesText( $attributes ) )
			);
		}

		/**
		 * @param string $src
		 * @param array $attributes
		 *
		 * @return string
		 */
		public function getEmbeddedVideoBySrc( $src, $attributes = array() ) {
			return do_shortcode(
				sprintf( '[video src="%s" %s][/video]', esc_url( $src ),
					$this->getShortcodeAttributesText( $attributes ) )
			);
		}

		/**
		 * @param int $attachmentId
		 * @param array $attributes
		 *
		 * @return string
		 */
		public function getMediaHtml( $attachmentId, $attributes = array() ) {
			$defaultAttributes = array(
				PostFormatSlug::IMAGE => array(),
				PostFormatSlug::AUDIO => array(),
				PostFormatSlug::VIDEO => array()
			);

			$attributes = wp_parse_args( $attributes, $defaultAttributes );

			if ( wp_attachment_is_image( $attachmentId ) ) {
				return wp_get_attachment_image( $attachmentId, 'full', false, $attributes[ PostFormatSlug::IMAGE ] );
			}

			if ( $this->isAttachmentAudio( $attachmentId ) ) {
				return $this->getEmbeddedAudio( $attachmentId, $attributes[ PostFormatSlug::AUDIO ] );
			}

			if ( $this->isAttachmentVideo( $attachmentId ) ) {
				return $this->getEmbeddedVideo( $attachmentId, $attributes[ PostFormatSlug::VIDEO ] );
			}

			return '';
		}

		/**
		 * @param int|WP_Post $attachment
		 *
		 * @since 1.8.1
		 *
		 * @return bool
		 */
		public function isAttachmentAudio( $attachment ) {
			return wp_attachment_is( PostFormatSlug::AUDIO, $attachment );
		}

		/**
		 * @param int|WP_Post $attachment
		 *
		 * @since 1.8.1
		 *
		 * @return bool
		 */
		public function isAttachmentVideo( $attachment ) {
			return wp_attachment_is( PostFormatSlug::VIDEO, $attachment );
		}

		/**
		 * @param int $postId
		 *
		 * @since 1.8.1
		 *
		 * @return string
		 */
		public function getPostAudioSource( $postId ) {
			return $this->getPostMediaSource( $postId, 'audio', 'audio' );
		}

		/**
		 * @param int $postId
		 *
		 * @return string
		 */
		public function getPostVideoSource( $postId ) {
			return $this->getPostMediaSource( $postId, 'video', 'video' );
		}

		public function extractFirstShortcodeAttributes( $shortcode, $content ) {
			if ( ! has_shortcode( $content, $shortcode ) ) {
				return array();
			}

			if ( preg_match( '/' . get_shortcode_regex( array( $shortcode ) ) . '/s', $content, $matches ) ) {
				return shortcode_parse_atts( $matches[3] );
			}

			return array();
		}

		/**
		 * @param int $postId
		 * @param string $mediaType
		 * @param string $shortcode
		 *
		 * @return string
		 */
		private function getPostMediaSource( $postId, $mediaType, $shortcode = null ) {
			$post = get_post( $postId );

			if ( $shortcode ) {
				$attributes = $this->extractFirstShortcodeAttributes( $shortcode, $post->post_content );

				if ( ! empty( $attributes['src'] ) ) {
					return $attributes['src'];
				}
			}

			$media = get_attached_media( $mediaType, $postId );

			if ( empty( $media ) ) {
				return null;
			}

			$mediaIds = array_keys( $media );

			return wp_get_attachment_url( $mediaIds[0] );
		}

		/**
		 * @param $attributes
		 *
		 * @since 1.8.1
		 *
		 * @return string
		 */
		private function getShortcodeAttributesText( $attributes ) {
			return implode( ' ', array_map( function ( $value, $attribute ) {
				return sprintf( '%s="%s"', $attribute, $value );
			}, $attributes, array_keys( $attributes ) ) );
		}
	}
}