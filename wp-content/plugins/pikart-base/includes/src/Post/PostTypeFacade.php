<?php

namespace Pikart\WpBase\Post;

use Pikart\WpBase\Post\Type\Album;
use Pikart\WpBase\Post\Type\Page;
use Pikart\WpBase\Post\Type\Post;
use Pikart\WpBase\Post\Type\PostType;
use Pikart\WpBase\Post\Type\Product;
use Pikart\WpBase\Post\Type\Project;

if ( ! class_exists( __NAMESPACE__ . '\\PostTypeFacade' ) ) {

	/**
	 * Class PostTypeFacade
	 * @package Pikart\WpBase\Post
	 */
	class PostTypeFacade {

		/**
		 * @var PostTypeRegister
		 */
		private $postTypeRegister;

		/**
		 * @var Project
		 */
		private $project;

		/**
		 * @var Post
		 */
		private $post;

		/**
		 * @var Page
		 */
		private $page;

		/**
		 * @var Album
		 */
		private $album;

		/**
		 * @var Product
		 */
		private $product;

		/**
		 * PostTypeFacade constructor.
		 *
		 * @param PostTypeRegister $postTypeRegister
		 * @param Project $project
		 * @param Post $post
		 * @param Page $page
		 * @param Album $album
		 * @param Product $product
		 */
		public function __construct(
			PostTypeRegister $postTypeRegister, Project $project, Post $post, Page $page, Album $album, Product $product
		) {
			$this->postTypeRegister = $postTypeRegister;
			$this->project          = $project;
			$this->post             = $post;
			$this->page             = $page;
			$this->album            = $album;
			$this->product          = $product;
		}

		public function initProject() {
			$this->initPostType( $this->project );
		}

		public function initPost() {
			$this->initPostType( $this->post );
		}

		public function initPage() {
			$this->initPostType( $this->page );
		}

		public function initAlbum() {
			$this->initPostType( $this->album );
		}

		public function initProduct() {
			$this->initPostType( $this->product );
		}

		private function initPostType( PostType $postType ) {
			$this->postTypeRegister->register( $postType );
		}
	}
}