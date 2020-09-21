<?php

namespace Pikart\Nels\Post\Options\Processor;

use Pikart\Nels\Post\Options\Type\BlogPageOptions;
use Pikart\WpThemeCore\Post\Dal\PostRepository;

if ( ! class_exists( __NAMESPACE__ . '\\BlogPageOptionsProcessor' ) ) {

	/**
	 * Class BlogPageOptionsProcessor
	 * @package Pikart\Nels\Post\Options\Processor
	 */
	class BlogPageOptionsProcessor {

		/**
		 * @var PostRepository
		 */
		private $postRepository;

		/**
		 * BlogPageOptionsProcessor constructor.
		 *
		 * @param PostRepository $postRepository
		 */
		public function __construct( PostRepository $postRepository ) {
			$this->postRepository = $postRepository;
		}

		/**
		 * @param BlogPageOptions $options
		 */
		public function process( BlogPageOptions $options ) {
			$inputCategoryId = filter_input( INPUT_GET, 'categ', FILTER_SANITIZE_NUMBER_INT );
			$page            = $this->calculateCurrentPage();

			$query = $this->postRepository->getPostsQuery(
				$options->getNbPostsPerPage(),
				$page,
				$options->getOrderBy(),
				$options->getOrder(),
				array(
					'category_ids' => $inputCategoryId ? array( $inputCategoryId ) : $options->getPostCategoryIds(),
					'tag_ids'      => $options->getPostTagIds(),
					'post_ids'     => $options->getPostIds()
				)
			);

			$posts           = $query->posts;
			$postsCategories = array();

			foreach ( $posts as $post ) {
				$postsCategories[ $post->ID ] = $this->postRepository->getCategoriesByItemId( $post->ID );
			}

			$categoryFilterList = array();

			if ( $options->getCategoriesDisplay() !== 'none' ) {
				$parentCategory = $options->getCategoriesDisplay() === 'main' ? 0 : '';

				$categoryFilterList = $this->postRepository->getCategories(
					$parentCategory, $options->getPostCategoryIds() );
			}

			$options
				->setPostsCurrentPage( $page )
				->setPostsNbPages( $query->max_num_pages )
				->setPosts( $posts )
				->setPostsCategories( $postsCategories )
				->setCategoryFilterList( $categoryFilterList );
		}

		/**
		 * @return int
		 */
		private function calculateCurrentPage() {
			$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );

			return $page ? $page : 1;
		}
	}
}