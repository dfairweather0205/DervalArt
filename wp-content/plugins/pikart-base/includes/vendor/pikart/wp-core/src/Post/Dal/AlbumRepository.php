<?php

namespace Pikart\WpCore\Post\Dal;

use Pikart\WpCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\AlbumRepository' ) ) {

	/**
	 * Class AlbumRepository
	 * @package Pikart\WpCore\Post\Dal
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