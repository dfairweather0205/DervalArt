<?php

namespace Pikart\Nels\Blog\Options;

use Pikart\Nels\Post\Options\Type\BlogPageOptions;

if ( ! class_exists( __NAMESPACE__ . '\\BlogOptions' ) ) {

	/**
	 * Class BlogOptions
	 * @package Pikart\Nels\Blog\Options
	 */
	class BlogOptions extends BlogPageOptions {

		/**
		 * @var int
		 */
		private $postExcerptWordsNb;

		/**
		 * @var int
		 */
		private $categoryId;

		/**
		 * BlogOptions constructor.
		 *
		 * @param int $postId
		 * @param array $options
		 */
		public function __construct( $postId = null, $options = array() ) {
			parent::__construct( $postId, $options );
		}

		/**
		 * @return int
		 */
		public function getPostExcerptWordsNb() {
			return $this->postExcerptWordsNb;
		}

		/**
		 * @param int $postExcerptWordsNb
		 *
		 * @return BlogOptions
		 */
		public function setPostExcerptWordsNb( $postExcerptWordsNb ) {
			$this->postExcerptWordsNb = (int) $postExcerptWordsNb;

			return $this;
		}

		/**
		 * @return int
		 */
		public function getCategoryId() {
			return $this->categoryId;
		}

		/**
		 * @param int $categoryId
		 *
		 * @return BlogOptions
		 */
		public function setCategoryId( $categoryId ) {
			$this->categoryId = (int) $categoryId;

			return $this;
		}

		/**
		 * @param string $categoriesDisplay
		 *
		 * @return $this
		 */
		public function setCategoriesDisplay( $categoriesDisplay ) {
			$this->setOption( self::CATEGORIES_DISPLAY, $categoriesDisplay );

			return $this;
		}
	}
}