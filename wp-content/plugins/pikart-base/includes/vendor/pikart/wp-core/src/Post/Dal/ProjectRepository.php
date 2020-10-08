<?php

namespace Pikart\WpCore\Post\Dal;

use Pikart\WpCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\ProjectRepository' ) ) {

	/**
	 * Class ProjectRepository
	 * @package Pikart\WpCore\Post\Dal
	 */
	class ProjectRepository extends GenericPostTypeRepository {

		/**
		 * @inheritdoc
		 */
		protected function getItemSlug() {
			return PostTypeSlug::PROJECT;
		}

		/**
		 * @inheritdoc
		 */
		protected function getItemCategorySlug() {
			return PostTypeSlug::PROJECT_CATEGORY;
		}
	}
}