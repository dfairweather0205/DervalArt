<?php

namespace Pikart\WpBase\Post\Type;

use Pikart\WpCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\Album' ) ) {

	/**
	 * Class Album
	 * @package Pikart\WpBase\Post\Type
	 */
	class Album extends GenericPostType {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostTypeSlug::ALBUM;
		}

		/**
		 * @inheritdoc
		 */
		public function getTaxonomySlug() {
			return PostTypeSlug::ALBUM_CATEGORY;
		}

		/**
		 * @inheritdoc
		 */
		public function getConfig() {
			return array(
				'label'               => esc_html__( 'Album', 'pikart-base' ),
				'description'         => esc_html__( 'Album items', 'pikart-base' ),
				'supports'            => array(
					'title',
					//'editor',
					'thumbnail',
					//'comments',
					//'custom-fields',
					'post-formats'
				),
				'taxonomies'          => array( PostTypeSlug::ALBUM_CATEGORY ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => false,
				'show_in_admin_bar'   => false,
				'show_in_rest'        => true,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-images-alt2',
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'capability_type'     => 'post',
				'rewrite'             => array(
					'slug'       => esc_html_x( 'album', 'Permalink structure slug', 'pikart-base' ),
					'with_front' => true,
				),
				'labels'              => array(
					'name'               => esc_html_x( 'Album', 'Post type general name', 'pikart-base' ),
					'singular_name'      => esc_html_x( 'Album', 'Post type singular name', 'pikart-base' ),
					'menu_name'          => esc_html__( 'Album', 'pikart-base' ),
					'parent_item_colon'  => esc_html__( 'Parent:', 'pikart-base' ),
					'all_items'          => esc_html__( 'All Items', 'pikart-base' ),
					'view_item'          => esc_html__( 'View Item', 'pikart-base' ),
					'add_new_item'       => esc_html__( 'Add New Item', 'pikart-base' ),
					'new_item'           => esc_html__( 'New Item', 'pikart-base' ),
					'add_new'            => esc_html__( 'Add New Item', 'pikart-base' ),
					'edit_item'          => esc_html__( 'Edit Item', 'pikart-base' ),
					'update_item'        => esc_html__( 'Update Item', 'pikart-base' ),
					'search_items'       => esc_html__( 'Search Item', 'pikart-base' ),
					'not_found'          => esc_html__( 'No items found', 'pikart-base' ),
					'not_found_in_trash' => esc_html__( 'No items found in Trash', 'pikart-base' ),
				),
			);
		}

		/**
		 * @inheritdoc
		 */
		public function getTaxonomyConfig() {
			return array(
				'hierarchical'      => true,
				'public'            => false,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => false,
				'show_in_rest'      => true,
				'show_tagcloud'     => true,
				'rewrite'           => array(
					'slug'         => esc_html_x( 'album-category', 'Permalink structure slug', 'pikart-base' ),
					'with_front'   => true,
					'hierarchical' => false,
				),
				'labels'            => array(
					'name'                       => esc_html_x(
						'Album Categories', 'Taxonomy general name', 'pikart-base' ),
					'singular_name'              => esc_html_x(
						'Album Category', 'Taxonomy singular name', 'pikart-base' ),
					'menu_name'                  => esc_html__( 'Album Categories', 'pikart-base' ),
					'all_items'                  => esc_html__( 'All Categories', 'pikart-base' ),
					'parent_item'                => esc_html__( 'Parent Category', 'pikart-base' ),
					'parent_item_colon'          => esc_html__( 'Parent Category:', 'pikart-base' ),
					'new_item_name'              => esc_html__( 'New Category', 'pikart-base' ),
					'add_new_item'               => esc_html__( 'Add New Category', 'pikart-base' ),
					'edit_item'                  => esc_html__( 'Edit Category', 'pikart-base' ),
					'view_item'                  => esc_html__( 'View Category', 'pikart-base' ),
					'update_item'                => esc_html__( 'Update Category', 'pikart-base' ),
					'separate_items_with_commas' => esc_html__( 'Separate Categories with commas', 'pikart-base' ),
					'search_items'               => esc_html__( 'Search Categories', 'pikart-base' ),
					'add_or_remove_items'        => esc_html__( 'Add or remove Categories', 'pikart-base' ),
					'popular_items'              => esc_html__( 'Popular Categories', 'pikart-base' ),
					'choose_from_most_used'      => esc_html__( 'Choose from the most used categories', 'pikart-base' ),
					'not_found'                  => esc_html__( 'Not categories found', 'pikart-base' ),
				),
			);
		}

		/**
		 * @inheritdoc
		 */
		public function supportsPostFormats() {
			return true;
		}
	}
}