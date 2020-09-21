<?php

namespace Pikart\WpThemeCore\Admin\Media;

if ( ! class_exists( __NAMESPACE__ . '\AttachmentsMetaFacade' ) ) {
	/**
	 * Class AttachmentsMetaFacade
	 * @package Pikart\WpThemeCore\Admin\Media
	 */
	class AttachmentsMetaFacade {
		/**
		 * @param array  $customFields
		 * @param string $attachmentType
		 */
		public function registerMetaFields( array $customFields, $attachmentType = null ) {
			$this->prepareCustomFields( $customFields );
			$this->registerMetaFieldsGeneration( $customFields, $attachmentType );
			$this->registerMetaFieldsUpdate( $customFields, $attachmentType );
		}

		/**
		 * @param array $customFields
		 */
		private function prepareCustomFields( array &$customFields ) {
			$fields = array();

			foreach ( $customFields as $fieldId => $fieldConfig ) {
				$fields[ AttachmentsUtil::DB_PREFIX . $fieldId ] = $fieldConfig;
			}

			$customFields = $fields;
		}

		/**
		 * @param array  $customFields
		 * @param string $attachmentType
		 */
		private function registerMetaFieldsUpdate( array $customFields, $attachmentType = null ) {

			add_filter( 'attachment_fields_to_save', function ( $post, $attachment ) use (
				$customFields, $attachmentType
			) {
				if ( ! empty ( $attachmentType ) && stripos( $post['post_mime_type'], $attachmentType ) === false ) {
					return $post;
				}

				foreach ( $customFields as $fieldId => $fieldConfig ) {
					// we use underscore to save the fields in order to not display them in the custom fields dropdown
					$dbFieldId = '_' . $fieldId;

					if ( isset( $attachment[ $fieldId ] ) ) {
						update_post_meta( $post['ID'], $dbFieldId, $attachment[ $fieldId ] );
					} else {
						delete_post_meta( $post['ID'], $dbFieldId );
					}
				}

				return $post;
			}, 10, 2 );
		}

		/**
		 * @param array  $customFields
		 * @param string $attachmentType
		 */
		private function registerMetaFieldsGeneration( array $customFields, $attachmentType = null ) {

			add_filter( 'attachment_fields_to_edit', function ( $formFields, $post ) use (
				$customFields, $attachmentType
			) {

				if ( ! empty ( $attachmentType ) && stripos( $post->post_mime_type, $attachmentType ) === false ) {
					return $formFields;
				}

				foreach ( $customFields as $fieldId => &$fieldConfig ) {
					$dbFieldId            = '_' . $fieldId;
					$metaValue            = get_post_meta( $post->ID, $dbFieldId, true );
					$fieldConfig['value'] = isset( $fieldConfig['default'] ) && empty( $metaValue )
						? $fieldConfig['default'] : $metaValue;
				}

				return array_merge( $formFields, $customFields );
			}, 10, 2 );
		}
	}
}