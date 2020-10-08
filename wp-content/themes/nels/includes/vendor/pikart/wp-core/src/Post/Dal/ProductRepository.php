<?php

namespace Pikart\WpThemeCore\Post\Dal;

use Pikart\WpThemeCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\ProductRepository' ) ) {

	/**
	 * Class ProductRepository
	 * @package Pikart\WpThemeCore\Post\Dal
	 *
	 * @since 1.1.0
	 */
	class ProductRepository extends GenericPostTypeRepository {

		/**
		 * @inheritdoc
		 */
		protected function getItemSlug() {
			return PostTypeSlug::PRODUCT;
		}

		/**
		 * @inheritdoc
		 */
		protected function getItemCategorySlug() {
			return PostTypeSlug::PRODUCT_CATEGORY;
		}

		/**
		 * @inheritdoc
		 *
		 * @since 1.3.0
		 */
		protected function getItemTagSlug() {
			return PostTypeSlug::PRODUCT_TAG;
		}

		/**
		 * @inheritdoc
		 */
		protected function getItemsForCustomPostType(
			$itemSlug, $itemCategorySlug, $nbItems = 10, $orderBy = 'date', $order = 'desc', $params = array()
		) {
			if ( empty( $params ) ) {
				$params = array();
			}

			if ( ! isset( $params['tax_query'] ) ) {
				$params['tax_query'] = array();
			}

			// exclude hidden products
			$params['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'exclude-from-catalog',
				'operator' => 'NOT IN',
			);

			return parent::getItemsForCustomPostType(
				$itemSlug, $itemCategorySlug, $nbItems, $orderBy, $order, $params );
		}
	}
}