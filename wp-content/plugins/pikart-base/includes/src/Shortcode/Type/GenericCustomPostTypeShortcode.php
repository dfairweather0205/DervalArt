<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Post\Dal\PostTypeRepository;
use Pikart\WpCore\Post\PostUtil;
use Pikart\WpCore\Post\Type\PostTypeSlug;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;
use WP_Post;

if ( ! class_exists( __NAMESPACE__ . '\\GenericCustomPostTypeShortcode' ) ) {

	/**
	 * Class GenericCustomPostTypeShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	abstract class GenericCustomPostTypeShortcode extends AbstractShortcode {

		/**
		 * @var WP_Post
		 *
		 * @since 1.3.0
		 */
		protected $originalPost;

		/**
		 * @var array
		 *
		 * @since 1.3.0
		 */
		protected $items = array();

		/**
		 * @var PostTypeRepository
		 */
		protected $repository;

		/**
		 * @var PostUtil
		 */
		protected $postUtil;

		/**
		 * GenericCustomPostTypeShortcode constructor.
		 *
		 * @param PostTypeRepository $repository
		 * @param PostUtil $postUtil
		 */
		public function __construct( PostTypeRepository $repository, PostUtil $postUtil ) {
			$this->repository = $repository;
			$this->postUtil   = $postUtil;
			parent::__construct();
		}


		/**
		 * @inheritdoc
		 */
		public function isSelfClosing() {
			return true;
		}

		/**
		 * @inheritdoc
		 */
		public function isFinal() {
			return true;
		}

		/**
		 * @inheritdoc
		 */
		public function processTemplateData( array &$data ) {
			$data['items'] = $this->getItems( $data );
			$this->items   = $data['items'];

			$data['shortcode']        = $this;
			$data['items_categories'] = array();
			$data['options']          = array();
			$categoryIds              = array();

			foreach ( $data['items'] as $itemId ) {
				$this->setupItemData( $itemId, $data, $categoryIds );
			}

			$this->setupCategoryFilterList( $data, $categoryIds );
			$this->filterItemsByRequestCategoryId( $data );
		}

		/**
		 * @since 1.3.0
		 */
		public function beforeLoop() {
			if ( ! is_array( $this->items ) || count( $this->items ) < 1 ) {
				return;
			}

			update_meta_cache( PostTypeSlug::POST, $this->items );
			update_object_term_cache( $this->items, $this->getItemPostType() );

			$this->originalPost = $GLOBALS['post'];
		}

		/**
		 * @since 1.3.0
		 */
		public function afterLoop() {
			if ( ! is_array( $this->items ) || count( $this->items ) < 1 ) {
				return;
			}

			$GLOBALS['post'] = $this->originalPost;

			wp_reset_postdata();
		}

		/**
		 * @param int $itemId
		 *
		 * @since 1.3.0
		 */
		public function beforeItem( $itemId ) {
			$GLOBALS['post'] = get_post( $itemId );
			setup_postdata( $GLOBALS['post'] );
		}

		/**
		 * @since 1.3.0
		 */
		public function afterItem() {

		}

		/**
		 * @param array $data
		 *
		 * @since 1.6.1
		 */
		protected function filterItemsByRequestCategoryId( &$data ) {
			$categoryId = filter_input( INPUT_GET, 'item_cat', FILTER_SANITIZE_NUMBER_INT );

			if ( ! $categoryId ) {
				return;
			}

			$filteredItemList = array();
			$itemsCategories  = $data['items_categories'];


			foreach ( $data['items'] as $itemId ) {
				if ( isset( $itemsCategories[ $itemId ][ $categoryId ] ) ) {
					$filteredItemList[] = $itemId;
				}
			}

			$data['active_category'] = (int) $categoryId;
			$data['items']           = $filteredItemList;
		}

		/**
		 * @param int $itemId
		 * @param array $data
		 * @param array $categoryIds
		 *
		 * @since 1.3.0
		 */
		protected function setupItemData( $itemId, array &$data, array &$categoryIds ) {
			$data['items_categories'][ $itemId ] =
				$this->repository->getCategoriesByItemId( $itemId );

			$this->mergeCategories( $categoryIds, $data['items_categories'], $itemId );

			$data['options'][ $itemId ] = $this->postUtil->getOptions( $itemId );
		}

		/**
		 * @param array $categoryIds
		 * @param array $itemCategories
		 * @param int $itemId
		 */
		protected function mergeCategories( array &$categoryIds, array $itemCategories, $itemId ) {
			$categoryIds = array_merge( $categoryIds, array_keys( $itemCategories[ $itemId ] ) );
		}

		/**
		 * @param array $data
		 * @param array $itemCategories
		 */
		protected function setupCategoryFilterList( array &$data, array $itemCategories ) {
			$data['category_filter_list'] = array();
			$categoriesDisplay            = isset( $data['categories_display'] ) ? $data['categories_display'] : '';

			if ( empty( $itemCategories ) || $categoriesDisplay === 'none' ) {
				return;
			}

			$parentCategory = $categoriesDisplay === 'main' ? 0 : '';
			$itemCategories = array_unique( $itemCategories );

			if ( empty( $data['categories'] ) ) {
				$data['category_filter_list'] = $this->repository->getCategories( $parentCategory, $itemCategories );

				return;
			}

			$categoryList = $this->strToIntArray( $data['categories'] );

			if ( count( $categoryList ) ) {
				$itemCategories               = array_intersect( $categoryList, $itemCategories );
				$data['category_filter_list'] = $this->repository->getCategories( $parentCategory, $itemCategories );

				return;
			}

			$categoryIdToNameList = $this->repository->getCategories( $parentCategory, $itemCategories );
			$categoryIdToSlugList = $this->repository->getCategories(
				$parentCategory, $itemCategories, 'term_id', 'slug' );
			$categoryIdToSlugList = array_intersect( $categoryIdToSlugList, explode( ',', $data['categories'] ) );

			$data['category_filter_list'] = array_intersect_key( $categoryIdToNameList, $categoryIdToSlugList );
		}

		/**
		 * @param array $data
		 * @param string $type
		 *
		 * @return array
		 */
		protected function getDataItemIds( $data, $type ) {
			return empty( $data[ $type ] ) ? array() : $this->strToIntArray( $data[ $type ] );
		}

		/**
		 * @param array $data
		 *
		 * @return array
		 */
		protected function getDataCategories( $data ) {
			return empty( $data['categories'] ) ? array() : $this->strToIntArray( $data['categories'] );
		}

		/**
		 * @param string $str
		 * @param string $separator
		 *
		 * @return array
		 */
		protected function strToIntArray( $str, $separator = ',' ) {
			return array_filter( array_map( function ( $value ) {
				return (int) trim( $value );
			}, explode( $separator, $str ) ) );
		}

		/**
		 * @since 1.3.0 the following orderBy fields were added: relevance, menu_order, comment_count, rand
		 *
		 * @return array
		 */
		protected function getOrderByOptions() {
			return array(
				'relevance'     => esc_html__( 'Relevance', 'pikart-base' ),
				'date'          => esc_html__( 'Date', 'pikart-base' ),
				'title'         => esc_html__( 'Title', 'pikart-base' ),
				'author'        => esc_html__( 'Author', 'pikart-base' ),
				'ID'            => esc_html__( 'Id', 'pikart-base' ),
				'modified'      => esc_html__( 'Last modified date', 'pikart-base' ),
				'menu_order'    => esc_html__( 'Menu order', 'pikart-base' ),
				'parent'        => esc_html__( 'Parent id', 'pikart-base' ),
				'comment_count' => esc_html__( 'Number of comments', 'pikart-base' ),
				'rand'          => esc_html__( 'Random', 'pikart-base' ),
			);
		}

		/**
		 * @return array
		 */
		protected function getCategoriesDisplayOptions() {
			return array(
				'none' => esc_html__( 'None', 'pikart-base' ),
				'all'  => esc_html__( 'All categories', 'pikart-base' ),
				'main' => esc_html__( 'Main categories', 'pikart-base' ),
			);
		}

		/**
		 * @return array
		 */
		protected function getOrderOptions() {
			return array(
				'asc'  => esc_html__( 'Ascending', 'pikart-base' ),
				'desc' => esc_html__( 'Descending', 'pikart-base' ),
			);
		}

		/**
		 * @param array $data
		 *
		 * @return int[]
		 */
		protected function getItems( array $data ) {
			$params = array(
				'item_ids'  => $this->getDataItemIds( $data, 'items' ),
				'fields'    => 'ids',
				'tax_query' => array()
			);

			$this->setupTaxQuery( $this->getItemPostTypeCategory(), $data, 'categories', $params );
			$this->setupTaxQuery( $this->getItemPostTypeTag(), $data, 'tags', $params );

			return $this->repository->getItems(
				$data['nb_items'],
				$data['order_by'],
				$data['order'],
				$params
			);
		}

		/**
		 * @param string $taxonomy
		 * @param array $data
		 * @param string $fieldName
		 * @param array $params
		 *
		 * @since 1.4.0
		 */
		protected function setupTaxQuery( $taxonomy, array $data, $fieldName, array &$params ) {
			if ( empty( $data[ $fieldName ] ) ) {
				return;
			}

			$termList    = explode( ',', $data[ $fieldName ] );
			$termIds     = array_filter( $termList, 'is_numeric' );
			$useTermSlug = empty( $termIds );
			$terms       = $useTermSlug
				? array_map( 'sanitize_title', $termList ) : $this->strToIntArray( $data[ $fieldName ] );


			$params['tax_query'][] = array(
				'taxonomy' => $taxonomy,
				'terms'    => $terms,
				'field'    => $useTermSlug ? 'slug' : 'term_id'
			);
		}

		/**
		 * @since 1.4.0
		 *
		 * @return array
		 */
		protected function getCategories() {
			return $this->repository->getCategories( '', array(), 'slug' );
		}

		/**
		 * @since 1.4.0
		 *
		 * @return array
		 */
		protected function getTags() {
			return $this->repository->getTags( 'slug' );
		}

		/**
		 * @since 1.3.0
		 *
		 * @return string
		 */
		abstract protected function getItemPostType();

		/**
		 * @since 1.4.0
		 *
		 * @return string
		 */
		abstract protected function getItemPostTypeTag();

		/**
		 * @since 1.4.0
		 *
		 * @return string
		 */
		abstract protected function getItemPostTypeCategory();
	}
}