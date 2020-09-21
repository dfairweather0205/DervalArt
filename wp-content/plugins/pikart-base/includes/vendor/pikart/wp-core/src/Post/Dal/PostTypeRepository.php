<?php

namespace Pikart\WpCore\Post\Dal;

use WP_Post;

if ( ! interface_exists( __NAMESPACE__ . '\\PostTypeRepository' ) ) {

	/**
	 * Interface Repository
	 * @package Pikart\WpCore\Post\Dal
	 */
	interface PostTypeRepository {

		/**
		 * @param int $nbItems
		 * @param string $orderBy
		 * @param string $order
		 * @param array $params
		 *
		 * @return WP_Post[]|int[]
		 */
		public function getItems( $nbItems = 10, $orderBy = 'date', $order = 'desc', $params = array() );

		/**
		 * @param int $nbPostsPerPage
		 * @param int $page
		 * @param string $orderBy
		 * @param string $order
		 * @param array $params
		 *
		 * @return array
		 */
		public function getPaginatedItems(
			$nbPostsPerPage = 10, $page = 1, $orderBy = 'date', $order = 'desc', $params = array()
		);

		/**
		 * @param int $itemId
		 *
		 * @return array
		 */
		public function getCategoriesByItemId( $itemId );

		/**
		 * `$categoryIndexField` @since 1.3.0
		 * `$categoryFiled` @since 1.3.0
		 *
		 * @param int|string $parent
		 * @param array $categoryIds
		 * @param string $categoryIndexField
		 * @param string $categoryFiled
		 *
		 * @return array
		 */
		public function getCategories(
			$parent = '', $categoryIds = array(), $categoryIndexField = 'term_id', $categoryFiled = 'name'
		);

		/**
		 * gets the related items of the current item
		 *
		 * first it tries to find related items by item tags
		 * if it cannot find sufficient items by tags it gets by item categories
		 *
		 * @param int $itemId
		 * @param int $nbItems
		 *
		 * @return WP_Post[]
		 */
		public function getRelatedItems( $itemId, $nbItems = 5 );

		/**
		 * `$tagIndexField` @since 1.3.0
		 * `$tagField` @since 1.3.0
		 *
		 * @param string $tagIndexField
		 * @param string $tagField
		 *
		 * @return array
		 */
		public function getTags( $tagIndexField = 'term_id', $tagField = 'name' );

	}
}