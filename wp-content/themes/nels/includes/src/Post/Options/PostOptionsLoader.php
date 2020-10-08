<?php

namespace Pikart\Nels\Post\Options;

use Pikart\Nels\Post\Options\Processor\BlogPageOptionsProcessor;
use Pikart\Nels\Post\Options\Type\AlbumOptions;
use Pikart\Nels\Post\Options\Type\AsidePostOptions;
use Pikart\Nels\Post\Options\Type\AudioPostOptions;
use Pikart\Nels\Post\Options\Type\BlogPageOptions;
use Pikart\Nels\Post\Options\Type\CommonPostOptions;
use Pikart\Nels\Post\Options\Type\GalleryPostOptions;
use Pikart\Nels\Post\Options\Type\ImagePostOptions;
use Pikart\Nels\Post\Options\Type\LinkPostOptions;
use Pikart\Nels\Post\Options\Type\PageOptions;
use Pikart\Nels\Post\Options\Type\ProductOptions;
use Pikart\Nels\Post\Options\Type\ProjectOptions;
use Pikart\Nels\Post\Options\Type\QuotePostOptions;
use Pikart\Nels\Post\Options\Type\StandardPostOptions;
use Pikart\Nels\Post\Options\Type\VideoPostOptions;
use Pikart\WpThemeCore\Post\PostUtil;

if ( ! class_exists( __NAMESPACE__ . '\\PostOptionsLoader' ) ) {

	/**
	 * Class PostOptionsLoader
	 * @package Pikart\Nels\Post\Options
	 */
	class PostOptionsLoader {

		/**
		 * @var PostUtil
		 */
		private $postUtil;

		/**
		 * @var BlogPageOptionsProcessor
		 */
		private $blogPageOptionsProcessor;

		/**
		 * PostOptionsGenericBuilder constructor.
		 *
		 * @param PostUtil $postUtil
		 * @param BlogPageOptionsProcessor $blogPageOptionsProcessor
		 */
		public function __construct( PostUtil $postUtil, BlogPageOptionsProcessor $blogPageOptionsProcessor ) {
			$this->postUtil                 = $postUtil;
			$this->blogPageOptionsProcessor = $blogPageOptionsProcessor;
		}

		/**
		 * @param int $postId
		 *
		 * @return ProjectOptions
		 */
		public function loadProjectOptions( $postId ) {
			return new ProjectOptions( $postId, $this->getOptions( $postId ) );
		}

		/**
		 * @param int $postId
		 *
		 * @return CommonPostOptions
		 */
		public function loadCommonPostOptions( $postId ) {
			return new CommonPostOptions( $postId, $this->getOptions( $postId ) );
		}

		/**
		 * @param int $postId
		 *
		 * @return PageOptions
		 */
		public function loadPageOptions( $postId ) {
			return new PageOptions( $postId, $this->getOptions( $postId ) );
		}

		/**
		 * @param int $postId
		 *
		 * @return ProductOptions
		 */
		public function loadProductOptions( $postId ) {
			return new ProductOptions( $postId, $this->getOptions( $postId ) );
		}

		/**
		 * @param int $postId
		 *
		 * @return AsidePostOptions
		 */
		public function loadAsideOptions( $postId ) {
			return new AsidePostOptions( $postId, $this->getOptions( $postId ) );
		}

		/**
		 * @param int $postId
		 *
		 * @return QuotePostOptions
		 */
		public function loadQuoteOptions( $postId ) {
			return new QuotePostOptions( $postId, $this->getOptions( $postId ) );
		}

		/**
		 * @param int $postId
		 *
		 * @return LinkPostOptions
		 */
		public function loadLinkOptions( $postId ) {
			return new LinkPostOptions( $postId, $this->getOptions( $postId ) );
		}

		/**
		 * @param int $postId
		 *
		 * @return GalleryPostOptions
		 */
		public function loadGalleryOptions( $postId ) {
			return new GalleryPostOptions( $postId, $this->getOptions( $postId ) );
		}

		/**
		 * @param int $postId
		 *
		 * @return AudioPostOptions
		 */
		public function loadAudioOptions( $postId ) {
			return new AudioPostOptions( $postId, $this->getOptions( $postId ) );
		}

		/**
		 * @param int $postId
		 *
		 * @return VideoPostOptions
		 */
		public function loadVideoOptions( $postId ) {
			return new VideoPostOptions( $postId, $this->getOptions( $postId ) );
		}

		/**
		 * @param int $postId
		 *
		 * @return StandardPostOptions
		 */
		public function loadStandardOptions( $postId ) {
			return new StandardPostOptions( $postId, $this->getOptions( $postId ) );
		}

		/**
		 * @param $postId
		 *
		 * @return BlogPageOptions
		 */
		public function loadBlogPageOptions( $postId ) {
			$options = new BlogPageOptions( $postId, $this->getOptions( $postId ) );
			$this->blogPageOptionsProcessor->process( $options );

			return $options;
		}

		/**
		 * @param $postId
		 *
		 * @return AlbumOptions
		 */
		public function loadAlbumOptions( $postId ) {
			return new AlbumOptions( $postId, $this->getOptions( $postId ) );
		}

		/**
		 * @param int $postId
		 *
		 * @return ImagePostOptions
		 */
		public function loadImageOptions( $postId ) {
			return new ImagePostOptions( $postId, $this->getOptions( $postId ) );
		}

		/**
		 * @param int $postId
		 *
		 * @return array
		 */
		private function getOptions( $postId ) {
			return $this->postUtil->getOptions( $postId );
		}
	}

}