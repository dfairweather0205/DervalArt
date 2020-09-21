<?php

namespace Pikart\WpBase\Post\Type;

use Pikart\WpCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\Project' ) ) {

	/**
	 * Class Project
	 * @package Pikart\WpBase\Post\Type
	 */
	class Project extends GenericPostType {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostTypeSlug::PROJECT;
		}

		/**
		 * @inheritdoc
		 */
		public function getTaxonomySlug() {
			return PostTypeSlug::PROJECT_CATEGORY;
		}

		/**
		 * @inheritdoc
		 */
		public function getConfig() {
			return array(
				'label'               => esc_html__( 'Projects', 'pikart-base' ),
				'description'         => esc_html__( 'Portfolio projects', 'pikart-base' ),
				'supports'            => array( 'title', 'editor', 'thumbnail', 'comments', 'custom-fields' ),
				'taxonomies'          => array( PostTypeSlug::PROJECT_CATEGORY, 'post_tag' ),
				'hierarchical'        => false,
				'show_in_rest'        => true,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-portfolio',
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				'rewrite'             => array(
					'slug'       => esc_html_x( 'project', 'Permalink structure slug', 'pikart-base' ),
					'with_front' => true,
				),
				'labels'              => array(
					'name'               => esc_html_x( 'Projects', 'Post type general name', 'pikart-base' ),
					'singular_name'      => esc_html_x( 'Project', 'Post type singular name', 'pikart-base' ),
					'menu_name'          => esc_html__( 'Projects', 'pikart-base' ),
					'parent_item_colon'  => esc_html__( 'Parent Project:', 'pikart-base' ),
					'all_items'          => esc_html__( 'All Projects', 'pikart-base' ),
					'view_item'          => esc_html__( 'View Project', 'pikart-base' ),
					'add_new_item'       => esc_html__( 'Add New Project', 'pikart-base' ),
					'new_item'           => esc_html__( 'New Project', 'pikart-base' ),
					'add_new'            => esc_html__( 'Add New', 'pikart-base' ),
					'edit_item'          => esc_html__( 'Edit Project', 'pikart-base' ),
					'update_item'        => esc_html__( 'Update Project', 'pikart-base' ),
					'search_items'       => esc_html__( 'Search Project', 'pikart-base' ),
					'not_found'          => esc_html__( 'No projects found', 'pikart-base' ),
					'not_found_in_trash' => esc_html__( 'No projects found in Trash', 'pikart-base' ),
				),
			);
		}

		/**
		 * @inheritdoc
		 */
		public function getTaxonomyConfig() {
			return array(
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_in_rest'      => true,
				'show_tagcloud'     => true,
				'rewrite'           => array(
					'slug'         => esc_html_x( 'project-category', 'Permalink structure slug', 'pikart-base' ),
					'with_front'   => true,
					'hierarchical' => false,
				),
				'labels'            => array(
					'name'                       => esc_html_x(
						'Project Categories', 'Taxonomy general name', 'pikart-base' ),
					'singular_name'              => esc_html_x(
						'Project Category', 'Taxonomy singular name', 'pikart-base' ),
					'menu_name'                  => esc_html__( 'Project Categories', 'pikart-base' ),
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
		public function supportsTags() {
			return true;
		}
	}
}