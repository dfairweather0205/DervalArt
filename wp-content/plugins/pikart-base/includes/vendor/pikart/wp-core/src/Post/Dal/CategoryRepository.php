<?php

namespace Pikart\WpCore\Post\Dal;

use WP_Term;

if ( ! class_exists( __NAMESPACE__ . '\\CategoryRepository' ) ) {

	/**
	 * Class CategoryRepository
	 * @package Pikart\WpCore\Post\Dal
	 */
	class CategoryRepository {

		/**
		 * @param int   $categoryId
		 * @param array $visitedCategories
		 *
		 * @return WP_Term[]
		 */
		public function getCategoryHierarchy( $categoryId, $visitedCategories = array() ) {
			$categories = array();

			if ( ! $categoryId ) {
				return $categories;
			}

			$category = get_term( $categoryId );

			if ( is_wp_error( $category ) || ! $category ) {
				return array();
			}

			if ( $category->parent && ( $category->parent != $category->term_id )
			     && ! in_array( $category->parent, $visitedCategories )
			) {
				$visitedCategories[] = $category->parent;
				$categories          = $this->getCategoryHierarchy( $category->parent, $visitedCategories );
			}

			$categories[] = $category;

			return $categories;
		}
	}
}