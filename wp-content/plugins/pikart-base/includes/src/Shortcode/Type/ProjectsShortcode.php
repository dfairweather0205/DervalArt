<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Post\Dal\GenericPostTypeRepository;
use Pikart\WpCore\Post\Dal\ProjectRepository;
use Pikart\WpCore\Post\PostUtil;
use Pikart\WpCore\Post\Type\PostTypeSlug;
use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\ProjectsShortcode' ) ) {

	/**
	 * Class ProjectsShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class ProjectsShortcode extends GenericCustomPostTypeShortcode {

		/**
		 * ProjectsShortcode constructor.
		 *
		 * @param ProjectRepository $projectRepository
		 * @param PostUtil $postUtil
		 */
		public function __construct( ProjectRepository $projectRepository, PostUtil $postUtil ) {
			parent::__construct( $projectRepository, $postUtil );
		}

		/**
		 * @inheritdoc
		 *
		 * @since 1.3.0
		 */
		protected function getItemPostType() {
			return PostTypeSlug::PROJECT;
		}

		/**
		 * @inheritdoc
		 */
		protected function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder ) {
			$builder
				->label( esc_html__( 'General Properties', 'pikart-base' ), array(
					'classes' => 'pikode-inner-title',
				) )
				->multiSelect( 'categories', esc_html__( 'Projects categories', 'pikart-base' ), array(
					'tooltip' => esc_html__(
						'Filter projects by categories. Leave empty to select all projects', 'pikart-base' ),
					'options' => $this->getCategories()
				) )
				->multiSelect( 'tags', esc_html__( 'Projects tags', 'pikart-base' ), array(
					'tooltip' => esc_html__(
						'Filter projects by tags. Leave empty to select all projects', 'pikart-base' ),
					'options' => $this->getTags()
				) )
				->textArea( 'items', esc_html__( 'Projects', 'pikart-base' ), array(
					'tooltip' => esc_html__(
						'Choose projects you want to display (comma separated Projects IDs)', 'pikart-base' ),
					'rows'    => 3,
				) )
				->listBox( 'categories_display', esc_html__( 'Categories filter', 'pikart-base' ), array(
					'default' => 'main',
					'tooltip' => esc_html__( 'Decide if you want to display categories filter or not', 'pikart-base' ),
					'options' => $this->getCategoriesDisplayOptions()
				) )
				->listBox( 'order_by', esc_html__( 'Order by', 'pikart-base' ), array(
					'default' => 'date',
					'tooltip' => esc_html__( 'Select the field by which to order the projects', 'pikart-base' ),
					'options' => $this->getOrderByOptions()
				) )
				->listBox( 'order', esc_html__( 'Order', 'pikart-base' ), array(
					'default' => 'desc',
					'tooltip' => esc_html__( 'Select the display order', 'pikart-base' ),
					'options' => $this->getOrderOptions()
				) )
				->number( 'nb_items', esc_html__( 'Number of projects', 'pikart-base' ), array(
					'default' => 20,
					'min'     => 1,
					'max'     => GenericPostTypeRepository::MAX_NB_ITEMS_QUERY_LIMIT,
					'tooltip' => esc_html__( 'Select number of projects', 'pikart-base' )
				) )
				->cssClass();
		}

		/**
		 * @inheritdoc
		 *
		 * @since 1.4.0
		 */
		protected function getItemPostTypeCategory() {
			return PostTypeSlug::PROJECT_CATEGORY;
		}

		/**
		 * @inheritdoc
		 *
		 * @since 1.4.0
		 */
		protected function getItemPostTypeTag() {
			return PostTypeSlug::POST_TAG;
		}
	}
}