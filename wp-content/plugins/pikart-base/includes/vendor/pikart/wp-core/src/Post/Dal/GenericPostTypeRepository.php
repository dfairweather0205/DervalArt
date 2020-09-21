<?php

namespace Pikart\WpCore\Post\Dal;

use Pikart\WpCore\Post\Type\PostTypeSlug;
use WP_Post;

if ( ! class_exists( __NAMESPACE__ . '\\GenericPostTypeRepository' ) ) {

	/**
	 * Class GenericPostTypeRepository
	 * @package Pikart\WpCore\Post\Dal
	 */
	abstract class GenericPostTypeRepository implements PostTypeRepository {

		const MAX_NB_ITEMS_QUERY_LIMIT = 1000;

		/**
		 * @inheritdoc
		 */
		public function getTags( $tagIndexField = 'term_id', $tagField = 'name' ) {
			return $this->getTermsForCustomPostType(
				$this->getItemSlug(), $this->getItemTagSlug(), '', array(), $tagIndexField, $tagField );
		}

		/**
		 * @inheritdoc
		 */
		public function getItems( $nbItems = 10, $orderBy = 'date', $order = 'desc', $params = array() ) {
			return $this->getItemsForCustomPostType(
				$this->getItemSlug(), $this->getItemCategorySlug(), $nbItems, $orderBy, $order, $params );
		}

		/**
		 * should be implemented by child class if required
		 *
		 * @inheritdoc
		 */
		public function getPaginatedItems(
			$nbPostsPerPage = 10, $page = 1, $orderBy = 'date', $order = 'desc', $params = array()
		) {
			return array();
		}

		/**
		 * @inheritdoc
		 */
		public function getCategoriesByItemId( $itemId ) {
			return $this->getCategoriesByItemIdForCustomPostType( $this->getItemCategorySlug(), $itemId );
		}

		/**
		 * @inheritdoc
		 */
		public function getCategories(
			$parent = '', $categoryIds = array(), $categoryIndexField = 'term_id', $categoryFiled = 'name'
		) {
			return $this->getTermsForCustomPostType( $this->getItemSlug(), $this->getItemCategorySlug(), $parent,
				$categoryIds, $categoryIndexField, $categoryFiled );
		}

		/**
		 * @inheritdoc
		 */
		public function getRelatedItems( $itemId, $nbItems = 5 ) {
			return $this->getRelatedItemsForCustomPostType(
				$this->getItemSlug(), $this->getItemCategorySlug(), $itemId, $nbItems );
		}

		/**
		 * @param $itemCategorySlug
		 * @param $itemId
		 *
		 * @return array
		 */
		protected function getCategoriesByItemIdForCustomPostType( $itemCategorySlug, $itemId ) {
			$terms = get_the_terms( $itemId, $itemCategorySlug );

			if ( ! is_array( $terms ) ) {
				return array();
			}

			$categories = array();

			foreach ( $terms as $term ) {
				$categories[ $term->term_id ] = $term->name;
			}

			return $categories;
		}

		/**
		 * `$termIndexField` @since 1.3.0
		 * `$termField` @since 1.3.0
		 *
		 * @param        $itemSlug
		 * @param        $taxonomy
		 * @param string $parent
		 * @param array $termIds
		 * @param string $termIndexField
		 * @param string $termField
		 *
		 * @return array
		 */
		protected function getTermsForCustomPostType(
			$itemSlug, $taxonomy, $parent = '', $termIds = array(), $termIndexField = 'term_id', $termField = 'name'
		) {
			$args = array(
				'type'     => $itemSlug,
				'taxonomy' => $taxonomy,
				'parent'   => $parent,
				'include'  => $termIds
			);

			return $this->getTerms( $args, $termIndexField, $termField );
		}

		/**
		 * @param        $itemSlug
		 * @param        $itemCategorySlug
		 * @param int $nbItems
		 * @param string $orderBy
		 * @param string $order
		 * @param array $params
		 *
		 * @return array
		 */
		protected function getItemsForCustomPostType(
			$itemSlug, $itemCategorySlug, $nbItems = 10, $orderBy = 'date', $order = 'desc', $params = array()
		) {
			$args = array(
				'post_type'      => $itemSlug,
				'orderby'        => $orderBy,
				'order'          => $order,
				'posts_per_page' => $this->calculateNbItemsLimit( $nbItems )
			);

			if ( isset( $params['tax_query'] ) ) {
				$args['tax_query'] = $params['tax_query'];
			}

			if ( ! empty( $params['category_ids'] ) ) {
				if ( ! isset( $args['tax_query'] ) ) {
					$args['tax_query'] = array();
				}

				$args['tax_query'][] = array(
					'taxonomy'         => $itemCategorySlug,
					'field'            => 'term_id',
					'terms'            => $params['category_ids'],
					'include_children' => false

				);
			}

			if ( ! empty( $params['tag_ids'] ) ) {
				$args['tag__in'] = $params['tag_ids'];
			}

			if ( ! empty( $params['item_ids'] ) ) {
				$args['post__in'] = $params['item_ids'];
			}

			/**
			 * @since 1.3.0
			 */
			if ( ! empty( $params['fields'] ) ) {
				$args['fields'] = $params['fields'];
			}

			return get_posts( $args );
		}

		/**
		 * `$termIndexField` @since 1.3.0
		 * `$termField` @since 1.3.0
		 *
		 * @param array $args
		 * @param string $termIndexField
		 * @param string $termField
		 *
		 * @return array
		 */
		protected function getTerms( $args = array(), $termIndexField = 'term_id', $termField = 'name' ) {

			if ( ( isset( $args['taxonomy'] ) && ! taxonomy_exists( $args['taxonomy'] ) )
			     || ( isset( $args['type'] ) && ! post_type_exists( $args['type'] ) ) ) {
				return array();
			}

			$defaultArgs = array(
				'orderby' => 'name',
				'order'   => 'ASC',
			);

			$terms = get_terms( array_merge( $defaultArgs, $args ) );

			$termList = array();

			foreach ( $terms as $term ) {
				$termList[ $term->{$termIndexField} ] = $term->{$termField};
			}

			return $termList;
		}

		/**
		 * @param int $nbItems
		 *
		 * @return int
		 */
		protected function calculateNbItemsLimit( $nbItems ) {
			return max( 1, min( self::MAX_NB_ITEMS_QUERY_LIMIT, (int) $nbItems ) );
		}

		/**
		 * gets the related items of the current item
		 *
		 * first it tries to find related items by item tags
		 * if it cannot find sufficient items by tags it gets by item categories
		 *
		 * @param string $itemSlug
		 * @param string $itemCategorySlug
		 * @param int $itemId
		 * @param int $nbItems
		 *
		 * @return WP_Post[]
		 */
		protected function getRelatedItemsForCustomPostType( $itemSlug, $itemCategorySlug, $itemId, $nbItems = 5 ) {
			$relatedItems = array();
			$nbItems      = (int) $nbItems;

			$tags = wp_get_post_tags( $itemId );

			if ( $tags ) {
				$tagIds = array_map( function ( $tag ) {
					return $tag->term_id;
				}, $tags );

				$relatedItems = get_posts( array(
					'post_type'        => $itemSlug,
					'posts_per_page'   => $nbItems,
					'exclude'          => array( $itemId ),
					'suppress_filters' => false,
					'tax_query'        => array(
						array(
							'taxonomy' => 'post_tag',
							'field'    => 'term_id',
							'terms'    => $tagIds,
						),
					)
				) );

				if ( count( $relatedItems ) === $nbItems ) {
					return $relatedItems;
				}
			}

			$categoryIds = wp_get_object_terms( $itemId, $itemCategorySlug, array( 'fields' => 'ids' ) );

			if ( ! $categoryIds ) {
				return $relatedItems;
			}

			$tagRelatedItemIds = array( $itemId );

			foreach ( $relatedItems as $relatedItem ) {
				$tagRelatedItemIds[] = $relatedItem->ID;
			}

			return array_merge(
				$relatedItems,
				get_posts( array(
					'post_type'        => $itemSlug,
					'posts_per_page'   => $nbItems - count( $relatedItems ),
					'exclude'          => $tagRelatedItemIds,
					'suppress_filters' => false,
					'tax_query'        => array(
						array(
							'taxonomy'         => $itemCategorySlug,
							'field'            => 'term_id',
							'terms'            => $categoryIds,
							'include_children' => false,
						),
					)
				) )
			);
		}

		/**
		 * @since 1.3.0
		 *
		 * @return string
		 */
		protected function getItemTagSlug() {
			return PostTypeSlug::POST_TAG;
		}

		/**
		 * @return string
		 */
		abstract protected function getItemSlug();

		/**
		 * @return string
		 */
		abstract protected function getItemCategorySlug();
	}
}