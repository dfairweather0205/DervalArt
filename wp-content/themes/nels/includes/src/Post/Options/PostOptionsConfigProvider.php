<?php

namespace Pikart\Nels\Post\Options;

use Pikart\Nels\Post\Options\Config\AlbumOptionsConfig;
use Pikart\Nels\Post\Options\Config\PageOptionsConfig;
use Pikart\Nels\Post\Options\Config\PostOptionsConfig;
use Pikart\Nels\Post\Options\Config\ProductOptionsConfig;
use Pikart\Nels\Post\Options\Config\ProjectOptionsConfig;
use Pikart\WpThemeCore\Post\Options\Config\PostTypeOptionsConfig;

if ( ! class_exists( __NAMESPACE__ . '\\PostOptionsConfigProvider' ) ) {

	/**
	 * Class PostOptionsConfigProvider
	 * @package Pikart\Nels\Post\Options
	 */
	class PostOptionsConfigProvider {

		/**
		 * @var PostTypeOptionsConfig[]
		 */
		private $postOptionsConfigList = array();

		/**
		 * PostOptionsConfigProvider constructor.
		 *
		 * @param ProjectOptionsConfig $projectOptionsConfig
		 * @param ProductOptionsConfig $productOptionsConfig
		 * @param AlbumOptionsConfig $albumOptionsConfig
		 * @param PostOptionsConfig $postOptionsConfig
		 * @param PageOptionsConfig $pageOptionsConfig
		 */
		public function __construct(
			ProjectOptionsConfig $projectOptionsConfig,
			ProductOptionsConfig $productOptionsConfig,
			AlbumOptionsConfig $albumOptionsConfig,
			PostOptionsConfig $postOptionsConfig,
			PageOptionsConfig $pageOptionsConfig
		) {
			$this->postOptionsConfigList = array(
				$projectOptionsConfig,
				$productOptionsConfig,
				$albumOptionsConfig,
				$postOptionsConfig,
				$pageOptionsConfig
			);
		}

		/**
		 * @return PostTypeOptionsConfig[]
		 */
		public function getPostOptionsConfigList() {
			return $this->postOptionsConfigList;
		}
	}
}