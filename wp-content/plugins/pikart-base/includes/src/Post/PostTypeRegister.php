<?php

namespace Pikart\WpBase\Post;

use Pikart\WpBase\Post\Type\PostType;
use WP_Query;

if ( ! class_exists( __NAMESPACE__ . '\\PostTypeRegister' ) ) {

	/**
	 * Class PostTypeRegister
	 * @package Pikart\WpBase\Post
	 */
	class PostTypeRegister {

		/**
		 * PostTypeRegister constructor.
		 */
		public function __construct() {
			register_deactivation_hook( PIKART_BASE_PLUGIN_FILE, 'flush_rewrite_rules' );
			add_action( 'activate_' . PIKART_PLUGIN_BASE_NAME, 'flush_rewrite_rules', 99 );
			add_action( 'after_switch_theme', 'flush_rewrite_rules', 99 );
		}

		/**
		 * @param PostType $postType
		 */
		public function register( PostType $postType ) {
			$this->includePostTypesForTagsQuery( $postType );

			if ( ! $postType->isCustom() ) {
				return;
			}

			$registerPostType = function () use ( $postType ) {
				if ( ! $postType->enabled() ) {
					return;
				}

				register_post_type( $postType->getSlug(), $postType->getConfig() );

				register_taxonomy(
					$postType->getTaxonomySlug(),
					$postType->getSlug(),
					$postType->getTaxonomyConfig()
				);

				if ( $postType->supportsPostFormats() ) {
					register_taxonomy_for_object_type( 'post_format', $postType->getSlug() );
				}
			};

			// if using the default priority(10), Visual Composer frontendEditor will not recognise the CPT
			add_action( 'init', $registerPostType, 8 );
			add_action( 'after_switch_theme', $registerPostType );
			register_activation_hook( PIKART_BASE_PLUGIN_FILE, $registerPostType );
		}

		/**
		 * @param PostType $postType
		 */
		private function includePostTypesForTagsQuery( PostType $postType ) {
			add_action( 'pre_get_posts', function ( WP_Query $query ) use ( $postType ) {
				if ( ! is_admin() && $query->is_main_query() && $query->is_tag()
				     && $postType->enabled() && $postType->supportsTags() ) {

					$queryPostTypes = $query->get( 'post_type' );

					if ( ! is_array( $queryPostTypes ) ) {
						$queryPostTypes = array();
					}

					$queryPostTypes[] = $postType->getSlug();

					$query->set( 'post_type', array_unique( $queryPostTypes ) );
				}
			} );
		}
	}
}