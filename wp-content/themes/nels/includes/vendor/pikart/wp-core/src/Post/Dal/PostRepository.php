<?php

namespace Pikart\WpThemeCore\Post\Dal;

use Pikart\WpThemeCore\Post\Type\PostTypeSlug;
use WP_Post;
use WP_Query;

if ( ! class_exists( __NAMESPACE__ . '\\PostRepository' ) ) {

	/**
	 * Class PostRepository
	 * @package Pikart\WpThemeCore\Post\Dal
	 */
	class PostRepository extends GenericPostTypeRepository {

		/**
		 * @param int    $nbPostsPerPage
		 * @param int    $page
		 * @param string $orderBy
		 * @param string $order
		 * @param array  $params
		 *
		 * @return WP_Post[]
		 */
		public function getPaginatedItems(
			$nbPostsPerPage = 10, $page = 1, $orderBy = 'date', $order = 'desc', $params = array()
		) {
			$query = $this->getPostsQuery( $nbPostsPerPage, $page, $orderBy, $order, $params );

			return $query->posts;
		}

		/**
		 * @param int    $nbPostsPerPage
		 * @param int    $page
		 * @param string $orderBy
		 * @param string $order
		 * @param array  $params
		 *
		 * @return WP_Query
		 */
		public function getPostsQuery(
			$nbPostsPerPage = 10, $page = 1, $orderBy = 'date', $order = 'desc', $params = array()
		) {
			$args = array(
				'orderby'        => $orderBy,
				'order'          => $order,
				'posts_per_page' => $this->calculateNbItemsLimit( $nbPostsPerPage ),
				'paged'          => $page,
				//'ignore_sticky_posts' => true,
			);

			if ( ! empty( $params['category_ids'] ) ) {
				$args['category__in'] = $params['category_ids'];
			}

			if ( ! empty( $params['tag_ids'] ) ) {
				$args['tag__in'] = $params['tag_ids'];
			}

			if ( ! empty( $params['post_ids'] ) ) {
				$args['post__in'] = $params['post_ids'];
			}

			return new WP_Query( $args );
		}

		/**
		 * @inheritdoc
		 */
		protected function getItemSlug() {
			return PostTypeSlug::POST;
		}

		/**
		 * @inheritdoc
		 */
		protected function getItemCategorySlug() {
			return PostTypeSlug::POST_CATEGORY;
		}
	}
}