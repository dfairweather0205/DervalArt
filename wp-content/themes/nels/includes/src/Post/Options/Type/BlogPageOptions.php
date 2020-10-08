<?php

namespace Pikart\Nels\Post\Options\Type;

if ( ! class_exists( __NAMESPACE__ . '\\BlogPageOptions' ) ) {

	/**
	 * Class BlogPageOptions
	 * @package Pikart\Nels\Post\Options\Type
	 */
	class BlogPageOptions extends PageOptions {

		const CATEGORIES_DISPLAY = 'blog_categories_display';
		const CATEGORIES_FILTER_POSITION = 'blog_categories_filter_position';
		const POST_CATEGORY_IDS = 'blog_post_category_ids';
		const POST_TAG_IDS = 'blog_post_tag_ids';
		const POST_IDS = 'blog_post_ids';
		const ORDER = 'blog_order';
		const ORDER_BY = 'blog_order_by';
		const NB_POSTS_PER_PAGE = 'blog_nb_posts_per_page';
		const ADDITIONAL_CONTENT = 'blog_additional_content';

		const BLOG_DISPLAY = 'blog_display';
		const OVERLAY_TRANSPARENCY = 'blog_overlay_transparency';
		const NB_COLUMNS = 'blog_nb_columns';
		const COLUMNS_SPACING = 'blog_columns_spacing';

		/**
		 * @var array
		 */
		private $posts = array();

		/**
		 * @var array
		 */
		private $postsCategories = array();

		/**
		 * @var array
		 */
		private $categoryFilterList = array();

		/**
		 * @var int
		 */
		private $postsNbPages;

		/**
		 * @var int
		 */
		private $postsCurrentPage;

		/**
		 * @return string
		 */
		public function getCategoriesDisplay() {
			return $this->getOption( self::CATEGORIES_DISPLAY );
		}

		/**
		 * @return string
		 */
		public function getCategoriesFilterPosition() {
			return $this->getOption( self::CATEGORIES_FILTER_POSITION );
		}

		/**
		 * @return array
		 */
		public function getPostCategoryIds() {
			return $this->getArrayOption( self::POST_CATEGORY_IDS );
		}

		/**
		 * @return array
		 */
		public function getPostTagIds() {
			return $this->getArrayOption( self::POST_TAG_IDS );
		}

		/**
		 * @return array
		 */
		public function getPostIds() {
			return $this->getArrayOption( self::POST_IDS );
		}

		/**
		 * @return string
		 */
		public function getOrder() {
			return $this->getOption( self::ORDER );
		}

		/**
		 * @return string
		 */
		public function getOrderBy() {
			return $this->getOption( self::ORDER_BY );
		}

		/**
		 * @return int
		 */
		public function getNbPostsPerPage() {
			return $this->getIntOption( self::NB_POSTS_PER_PAGE );
		}

		/**
		 * @return string
		 */
		public function getAdditionalContent() {
			return $this->getOption( self::ADDITIONAL_CONTENT );
		}

		/**
		 * @return string
		 */
		public function getBlogDisplay() {
			return $this->getOption( self::BLOG_DISPLAY );
		}

		/**
		 * @return int
		 */
		public function getOverlayTransparency() {
			return $this->getIntOption( self::OVERLAY_TRANSPARENCY );
		}

		/**
		 * @return int
		 */
		public function getNbColumns() {
			return $this->getIntOption( self::NB_COLUMNS );
		}

		/**
		 * @return int
		 */
		public function getColumnsSpacing() {
			return $this->getIntOption( self::COLUMNS_SPACING );
		}

		/**
		 * @return array
		 */
		public function getPosts() {
			return $this->posts;
		}

		/**
		 * @param array $posts
		 *
		 * @return $this
		 */
		public function setPosts( array $posts ) {
			$this->posts = $posts;

			return $this;
		}

		/**
		 * @return array
		 */
		public function getPostsCategories() {
			return $this->postsCategories;
		}

		/**
		 * @param array $postsCategories
		 *
		 * @return $this
		 */
		public function setPostsCategories( array $postsCategories ) {
			$this->postsCategories = $postsCategories;

			return $this;
		}

		/**
		 * @return array
		 */
		public function getCategoryFilterList() {
			return $this->categoryFilterList;
		}

		/**
		 * @param array $categoryFilterList
		 *
		 * @return $this
		 */
		public function setCategoryFilterList( array $categoryFilterList ) {
			$this->categoryFilterList = $categoryFilterList;

			return $this;
		}

		/**
		 * @param int $postsNbPages
		 *
		 * @return $this
		 */
		public function setPostsNbPages( $postsNbPages ) {
			$this->postsNbPages = (int) $postsNbPages;

			return $this;
		}

		/**
		 * @return int
		 */
		public function getPostsNbPages() {
			return $this->postsNbPages;
		}

		/**
		 * @return int
		 */
		public function getPostsCurrentPage() {
			return $this->postsCurrentPage;
		}

		/**
		 * @param int $postsCurrentPage
		 *
		 * @return $this
		 */
		public function setPostsCurrentPage( $postsCurrentPage ) {
			$this->postsCurrentPage = (int) $postsCurrentPage;

			return $this;
		}
	}
}