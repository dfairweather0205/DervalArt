<?php

namespace Pikart\Nels\Blog\Options;

use Pikart\Nels\Post\Options\Processor\BlogPageOptionsProcessor;
use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\Nels\ThemeOptions\ThemeOptionsUtil;
use Pikart\WpThemeCore\Post\Dal\PostRepository;
use Pikart\WpThemeCore\Post\PostUtil;

if ( ! class_exists( __NAMESPACE__ . '\\BlogOptionsLoader' ) ) {

	/**
	 * Class BlogOptionsLoader
	 * @package Pikart\Nels\Blog\Options
	 */
	class BlogOptionsLoader {

		/**
		 * @var ThemeOptionsUtil
		 */
		private $themeOptionsUtil;

		/**
		 * @var PostUtil
		 */
		private $postUtil;

		/**
		 * @var PostRepository
		 */
		private $postRepository;

		/**
		 * @var BlogPageOptionsProcessor
		 */
		private $blogPageOptionsProcessor;

		/**
		 * BlogOptionsLoader constructor.
		 *
		 * @param ThemeOptionsUtil $themeOptionsUtil
		 * @param PostUtil $postUtil
		 * @param PostRepository $postRepository
		 * @param BlogPageOptionsProcessor $blogPageOptionsProcessor
		 */
		public function __construct(
			ThemeOptionsUtil $themeOptionsUtil,
			PostUtil $postUtil,
			PostRepository $postRepository,
			BlogPageOptionsProcessor $blogPageOptionsProcessor
		) {
			$this->themeOptionsUtil         = $themeOptionsUtil;
			$this->postUtil                 = $postUtil;
			$this->postRepository           = $postRepository;
			$this->blogPageOptionsProcessor = $blogPageOptionsProcessor;
		}

		/**
		 * @param int $pageId
		 *
		 * @return BlogOptions
		 */
		public function load( $pageId = null ) {
			$blogOptions = new BlogOptions();

			$blogOptions
				->setCategoryId( filter_input( INPUT_GET, 'categ', FILTER_SANITIZE_NUMBER_INT ) )
				->setPostExcerptWordsNb(
					$this->themeOptionsUtil->getOption( ThemeOption::BLOG_POST_EXCERPT_WORDS_NB ) );

			if ( $pageId === null ) {
				$this->loadDefaultOptions( $blogOptions );
			} else {
				$this->loadOptions( $pageId, $blogOptions );
			}

			set_query_var( 'blogOptions', $blogOptions );

			return $blogOptions;
		}

		/**
		 * @param BlogOptions $blogOptions
		 */
		private function loadDefaultOptions( BlogOptions $blogOptions ) {
			$blogOptions
				->setCategoriesDisplay( 'all' )
				->setCategoryFilterList( $this->postRepository->getCategories() );
		}

		/**
		 * @param int $pageId
		 * @param BlogOptions $blogOptions
		 */
		private function loadOptions( $pageId, BlogOptions $blogOptions ) {
			$blogOptions->setOptions( $this->postUtil->getOptions( $pageId ) );
			$this->blogPageOptionsProcessor->process( $blogOptions );
		}
	}
}