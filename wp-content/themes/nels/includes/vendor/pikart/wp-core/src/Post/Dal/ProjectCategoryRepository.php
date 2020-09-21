<?php

namespace Pikart\WpThemeCore\Post\Dal;

use Pikart\WpThemeCore\Post\Type\PostTypeSlug;
use WP_Term;

if ( ! class_exists( __NAMESPACE__ . '\\ProjectCategoryRepository' ) ) {

	/**
	 * Class ProjectCategoryRepository
	 * @package Pikart\WpThemeCore\Post\Dal
	 */
	class ProjectCategoryRepository {

		/**
		 * @return bool
		 */
		public function isProjectCategory() {
			$queriedObject = get_queried_object();

			return $queriedObject instanceof WP_Term && $queriedObject->taxonomy === PostTypeSlug::PROJECT_CATEGORY;
		}
	}
}