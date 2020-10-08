<?php

namespace Pikart\WpThemeCore\Post\Dal;

use Pikart\WpThemeCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\AlbumRepository' ) ) {

	/**
	 * Class AlbumRepository
	 * @package Pikart\WpThemeCore\Post\Dal
	 */
	class AlbumRepository extends GenericPostTypeRepository {

		/**
		 * @inheritdoc
		 */
		protected function getItemSlug() {
			return PostTypeSlug::ALBUM;
		}

		/**
		 * @inheritdoc
		 */
		protected function getItemCategorySlug() {
			return PostTypeSlug::ALBUM_CATEGORY;
		}
	}
}