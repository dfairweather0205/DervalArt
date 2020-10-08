<?php

namespace Pikart\Nels\Post\Options\Config\Template;

use Pikart\Nels\Post\Options\PostOptionsMetaBoxId;
use Pikart\Nels\Post\Options\Type\BlogPageOptions;
use Pikart\Nels\ThemeOptions\Config\ThemeOptionsConfigHelper;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Post\Dal\GenericPostTypeRepository;
use Pikart\WpThemeCore\Post\Dal\PostRepository;

if ( ! class_exists( __NAMESPACE__ . '\\BlogTemplateOptionsConfig' ) ) {

	/**
	 * Class BlogTemplateOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config\Template
	 */
	class BlogTemplateOptionsConfig {

		/**
		 * @var PostRepository
		 */
		private $postRepository;

		/**
		 * BlogTemplateOptionsConfig constructor.
		 *
		 * @param PostRepository $postRepository
		 */
		public function __construct( PostRepository $postRepository ) {
			$this->postRepository = $postRepository;
		}

		/**
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 */
		public function buildMetaBoxesConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->metaBox( PostOptionsMetaBoxId::PAGE_BLOG_OPTIONS, esc_html__( 'Blog Options', 'nels' ) )
				->select( BlogPageOptions::BLOG_DISPLAY, esc_html__( 'Display', 'nels' ),
					esc_html__( 'The type of posts cards', 'nels' ), array(
						'default' => 'default',
						'options' => ThemeOptionsConfigHelper::getDisplayTypes()
					) )
				->number( BlogPageOptions::OVERLAY_TRANSPARENCY,
					esc_html__( 'Overlay transparency (%)', 'nels' ),
					esc_html__( 'Overlay color transparency while hovering by mouse', 'nels' ), array(
						'default' => 50,
					) )
				->select( BlogPageOptions::NB_COLUMNS, esc_html__( 'Columns', 'nels' ),
					esc_html__( 'Choose how many columns of posts to showcase', 'nels' ), array(
						'default' => 3,
						'options' => ThemeOptionsConfigHelper::getItemColumnsNumber()
					) )
				->number( BlogPageOptions::COLUMNS_SPACING, esc_html__( 'Columns spacing', 'nels' ),
					esc_html__( 'Enter the spacing between columns (pixels)', 'nels' ), array(
						'default'    => 36,
						'attributes' => array(
							'min' => 0
						),
					) )
				->select( BlogPageOptions::CATEGORIES_DISPLAY, esc_html__( 'Categories filter', 'nels' ),
					esc_html__( 'Decide if you want to display categories filter or not', 'nels' ), array(
						'default' => 'main',
						'options' => array(
							'none' => esc_html__( 'None', 'nels' ),
							'all'  => esc_html__( 'All categories', 'nels' ),
							'main' => esc_html__( 'Main categories', 'nels' ),
						),
					) )
				->select( BlogPageOptions::CATEGORIES_FILTER_POSITION, esc_html__( 'Filter position', 'nels' ),
					esc_html__( 'Choose a position for Categories Filter', 'nels' ), array(
						'default' => 'left',
						'options' => array(
							'left'   => esc_html__( 'Left', 'nels' ),
							'center' => esc_html__( 'Center', 'nels' ),
							'right'  => esc_html__( 'Right', 'nels' ),
						),
					) )
				->multiSelect( BlogPageOptions::POST_CATEGORY_IDS, esc_html__( 'Posts categories', 'nels' ),
					esc_html__( 'Filter posts by categories', 'nels' ), array(
						'options' => $this->postRepository->getCategories(),
					) )
				->multiSelect( BlogPageOptions::POST_TAG_IDS, esc_html__( 'Posts tags', 'nels' ),
					esc_html__( 'Filter posts by tags', 'nels' ), array(
						'options' => $this->postRepository->getTags(),
					) )
				->textArea( BlogPageOptions::POST_IDS, esc_html__( 'Posts', 'nels' ),
					esc_html__( 'Choose posts you want to display (comma separated Posts IDs)', 'nels' ) )
				->select( BlogPageOptions::ORDER_BY, esc_html__( 'Order by', 'nels' ),
					esc_html__( 'Select the field by which to order the posts', 'nels' ), array(
						'default' => 'date',
						'options' => array(
							'date'     => esc_html__( 'Date', 'nels' ),
							'title'    => esc_html__( 'Title', 'nels' ),
							'author'   => esc_html__( 'Author', 'nels' ),
							'ID'       => esc_html__( 'Id', 'nels' ),
							'modified' => esc_html__( 'Last modified date', 'nels' ),
							'parent'   => esc_html__( 'Parent id', 'nels' ),
						)
					) )
				->select( BlogPageOptions::ORDER, esc_html__( 'Order', 'nels' ),
					esc_html__( 'Select the display order', 'nels' ), array(
						'default' => 'desc',
						'options' => array(
							'asc'  => esc_html__( 'Ascending', 'nels' ),
							'desc' => esc_html__( 'Descending', 'nels' ),
						)
					) )
				->number( BlogPageOptions::NB_POSTS_PER_PAGE, esc_html__( 'Number of posts per page', 'nels' ),
					esc_html__( 'Select number of posts per page', 'nels' ), array(
						'default'    => get_option( 'posts_per_page' ),
						'attributes' => array(
							'min' => 1,
							'max' => GenericPostTypeRepository::MAX_NB_ITEMS_QUERY_LIMIT,
						)
					) )
				->wpEditor( BlogPageOptions::ADDITIONAL_CONTENT, esc_html__( 'Additional content', 'nels' ),
					esc_html__( 'Enter additional content here, that is displayed below the blog', 'nels' ), array(
						'editor_settings' => array(
							'editor_height' => 300,
							'textarea_rows' => 8,
						)
					) );
		}
	}
}