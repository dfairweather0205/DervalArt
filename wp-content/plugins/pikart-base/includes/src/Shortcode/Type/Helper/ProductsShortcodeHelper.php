<?php

namespace Pikart\WpBase\Shortcode\Type\Helper;

use Pikart\WpCore\Post\Type\PostTypeSlug;
use WC_Shortcode_Products;

if ( ! class_exists( __NAMESPACE__ . '\\ProductsShortcodeQuery' ) ) {

	/**
	 * Class ProductsShortcodeQuery
	 * @package Pikart\WpBase\Shortcode\Type\Helper
	 *
	 * @since 1.3.0
	 */
	class ProductsShortcodeHelper extends WC_Shortcode_Products {

		/**
		 * @var ProductsShortcodeQueryResult
		 */
		private $queryResult;

		/**
		 * ProductsShortcodeQuery constructor.
		 *
		 * @param array $attributes
		 */
		public function __construct( array $attributes = array() ) {
			$productsType = empty( $attributes['products_type'] ) ? 'products' : $attributes['products_type'];

			$this->replaceTermIdsWithSkus( $attributes, 'categories', PostTypeSlug::PRODUCT_CATEGORY );
			$this->replaceTermIdsWithSkus( $attributes, 'tags', PostTypeSlug::PRODUCT_TAG );
			$this->mapProductsToWcAttributes( $attributes );
			$this->checkAttributes( $attributes );

			parent::__construct( $attributes, $productsType );
		}

		/**
		 * @return ProductsShortcodeQueryResult
		 */
		public function getProductQueryResult() {
			if ( null !== $this->queryResult ) {
				return $this->queryResult;
			}

			$result = $this->get_query_results();

			if ( $result && $result->ids ) {
				$this->queryResult = new ProductsShortcodeQueryResult(
					$result->ids,
					$result->total,
					$result->total_pages,
					$result->per_page,
					$result->current_page
				);
			} else {
				$this->queryResult = new ProductsShortcodeQueryResult();
			}

			return $this->queryResult;
		}

		public function beforeLoop() {
			$queryResult = $this->getProductQueryResult();

			if ( ! $queryResult->getTotalItems() ) {
				return;
			}

			wc_setup_loop( array(
				'columns'      => absint( $this->attributes['columns'] ),
				'name'         => $this->type,
				'is_shortcode' => true,
				'is_search'    => false,
				'is_paginated' => wc_string_to_bool( $this->attributes['paginate'] ),
				'total'        => $queryResult->getTotalItems(),
				'total_pages'  => $queryResult->getTotalPages(),
				'per_page'     => $queryResult->getItemsPerPage(),
				'current_page' => $queryResult->getCurrentPage(),
			) );

			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_before_shop_loop' );
			}
		}

		public function afterLoop() {
			$queryResult = $this->getProductQueryResult();

			if ( ! $queryResult->getTotalItems() ) {
				return;
			}

			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_after_shop_loop' );
			}

			wc_reset_loop();
		}

		public function beforeItem() {
			add_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );
		}

		public function afterItem() {
			remove_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );
		}

		/**
		 * @param array $attributes
		 */
		private function mapProductsToWcAttributes( array &$attributes ) {
			$attributesMap = array(
				'items'      => 'ids',
				'nb_items'   => 'limit',
				'order_by'   => 'orderby',
				'categories' => 'category',
				'tags'       => 'tag'
			);

			foreach ( $attributesMap as $productsAttribute => $wcAttribute ) {
				if ( isset( $attributes[ $productsAttribute ] ) ) {
					$attributes[ $wcAttribute ] = $attributes[ $productsAttribute ];
				}
			}
		}

		/**
		 * @param array $attributes
		 * @param string $attributeName
		 * @param string $taxonomy
		 */
		private function replaceTermIdsWithSkus( array &$attributes, $attributeName, $taxonomy ) {
			if ( empty( $attributes[ $attributeName ] ) ) {
				return;
			}

			$termList = explode( ',', $attributes[ $attributeName ] );

			$termIds = array_filter( $termList, 'is_numeric' );

			if ( empty( $termIds ) ) {
				return;
			}

			$termSlugs = $this->getTermSlugsByIds( $taxonomy, $termIds );

			$attributes[ $attributeName ] = implode( ',',
				array_merge( array_diff( $termList, $termIds ), $termSlugs ) );
		}

		/**
		 * @param string $taxonomy
		 * @param array $termIds
		 *
		 * @return array
		 */
		private function getTermSlugsByIds( $taxonomy, array $termIds ) {
			$args = array(
				'type'     => PostTypeSlug::PRODUCT,
				'taxonomy' => $taxonomy,
				'include'  => array_unique( $termIds )
			);

			$terms          = get_terms( $args );
			$termIdsToSlugs = array();

			foreach ( $terms as $term ) {
				$termIdsToSlugs[ $term->term_id ] = $term->slug;
			}

			return $termIdsToSlugs;
		}

		/**
		 * @param array $attributes
		 */
		private function checkAttributes( array &$attributes ) {
			if ( isset( $_GET['orderby'] ) ) {
				$attributes['order']   = '';
				$attributes['orderby'] = '';
			}
		}
	}
}