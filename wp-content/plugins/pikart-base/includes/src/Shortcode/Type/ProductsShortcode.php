<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpBase\Shortcode\Type\Helper\ProductsShortcodeHelper;
use Pikart\WpCore\Post\Dal\GenericPostTypeRepository;
use Pikart\WpCore\Post\Dal\ProductRepository;
use Pikart\WpCore\Post\PostUtil;
use Pikart\WpCore\Post\Type\PostTypeSlug;
use Pikart\WpCore\Shop\ShopUtil;
use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\ProductsShortcode' ) ) {

	/**
	 * Class ProductsShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 *
	 * @since 1.1.0
	 */
	class ProductsShortcode extends GenericCustomPostTypeShortcode {

		/**
		 * @var ProductsShortcodeHelper;
		 */
		private $helper;

		/**
		 * ProductsShortcode constructor.
		 *
		 * @param ProductRepository $productRepository
		 * @param PostUtil $postUtil
		 */
		public function __construct( ProductRepository $productRepository, PostUtil $postUtil ) {
			parent::__construct( $productRepository, $postUtil );
		}

		/**
		 * @inheritdoc
		 */
		public function enabled() {
			return ShopUtil::isShopActivated();
		}

		/**
		 * @inheritdoc
		 *
		 * @since 1.3.0
		 */
		public function beforeLoop() {
			parent::beforeLoop();
			$this->helper->beforeLoop();
		}

		/**
		 * @inheritdoc
		 *
		 * @since 1.3.0
		 */
		public function afterLoop() {
			$this->helper->afterLoop();
			parent::afterLoop();
		}

		/**
		 * @inheritdoc
		 *
		 * @since 1.3.0
		 */
		public function beforeItem( $itemId ) {
			parent::beforeItem( $itemId );
			$this->helper->beforeItem();
		}

		/**
		 * @inheritdoc
		 *
		 * @since 1.3.0
		 */
		public function afterItem() {
			$this->helper->afterItem();
			parent::afterItem();
		}

		/**
		 * @inheritdoc
		 *
		 * @since 1.3.0
		 */
		protected function getItemPostType() {
			return PostTypeSlug::PRODUCT;
		}

		/**
		 * @inheritdoc
		 *
		 * @since 1.3.0 the following attributes were added: products_type, visibility, cat_operator, skus
		 */
		protected function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder ) {
			$builder
				->label( esc_html__( 'General Properties', 'pikart-base' ), array(
					'classes' => 'pikode-inner-title',
				) )
				->listBox( 'products_type', esc_html__( 'Products type', 'pikart-base' ), array(
					'default' => 'products',
					'tooltip' => esc_html__( 'Choose your products type', 'pikart-base' ),
					'options' => array(
						'products'              => esc_html__( 'All', 'pikart-base' ),
						'top_rated_products'    => esc_html__( 'Top rated', 'pikart-base' ),
						'best_selling_products' => esc_html__( 'Best selling', 'pikart-base' ),
						'sale_products'         => esc_html__( 'Sale', 'pikart-base' )
					)
				) )
				->listBox( 'visibility', esc_html__( 'Products visibility', 'pikart-base' ), array(
					'default' => 'visible',
					'tooltip' => esc_html__( 'Choose products visibility', 'pikart-base' ),
					'options' => array(
						'visible'  => esc_html__( 'Visible', 'pikart-base' ),
						'catalog'  => esc_html__( 'Catalog', 'pikart-base' ),
						'search'   => esc_html__( 'Search', 'pikart-base' ),
						'hidden'   => esc_html__( 'Hidden', 'pikart-base' ),
						'featured' => esc_html__( 'Featured', 'pikart-base' ),
					)
				) )
				->multiSelect( 'categories', esc_html__( 'Product categories', 'pikart-base' ), array(
					'tooltip' => esc_html__(
						'Filter products by categories. Leave empty to select all products', 'pikart-base' ),
					'options' => $this->getCategories()
				) )
				->listBox( 'cat_operator', esc_html__( 'Categories usage', 'pikart-base' ), array(
					'default' => 'IN',
					'tooltip' => esc_html__( 'Choose how categories are used for products filtering', 'pikart-base' ),
					'options' => array(
						'IN'     => esc_html__( 'Products with at least one of the chosen categories', 'pikart-base' ),
						'AND'    => esc_html__( 'Products present in all the chosen categories', 'pikart-base' ),
						'NOT IN' => esc_html__( 'Products not present in the chosen categories', 'pikart-base' )
					)
				) )
				->multiSelect( 'tags', esc_html__( 'Product tags', 'pikart-base' ), array(
					'tooltip' => esc_html__(
						'Filter products by tags. Leave empty to select all products', 'pikart-base' ),
					'options' => $this->getTags()
				) )
				->textArea( 'items', esc_html__( 'Products', 'pikart-base' ), array(
					'tooltip' => esc_html__(
						'Choose products you want to display (comma separated Products IDs)', 'pikart-base' ),
					'rows'    => 3,
				) )
				->textArea( 'skus', esc_html__( 'SKUs', 'pikart-base' ), array(
					'tooltip' => esc_html__(
						'Choose products you want to display (comma separated Products SKUs)', 'pikart-base' ),
					'rows'    => 3,
				) )
				->listBox( 'categories_display', esc_html__( 'Categories filter', 'pikart-base' ), array(
					'default' => 'main',
					'tooltip' => esc_html__( 'Decide if you want to display categories filter or not', 'pikart-base' ),
					'options' => $this->getCategoriesDisplayOptions()
				) )
				->listBox( 'order_by', esc_html__( 'Order by', 'pikart-base' ), array(
					'default' => 'date',
					'tooltip' => esc_html__( 'Select the field by which to order the products', 'pikart-base' ),
					'options' => $this->getOrderByOptions()
				) )
				->listBox( 'order', esc_html__( 'Order', 'pikart-base' ), array(
					'default' => 'desc',
					'tooltip' => esc_html__( 'Select the display order', 'pikart-base' ),
					'options' => $this->getOrderOptions()
				) )
				->number( 'nb_items', esc_html__( 'Number of products', 'pikart-base' ), array(
					'default' => 20,
					'min'     => - 1,
					'max'     => GenericPostTypeRepository::MAX_NB_ITEMS_QUERY_LIMIT,
					'tooltip' => esc_html__( 'Select number of products', 'pikart-base' )
				) )
				->checkBox( 'paginate', esc_html__( 'Pagination', 'pikart-base' ), array(
					'default' => false,
					'tooltip' => esc_html__( 'Enable/Disable pagination', 'pikart-base' )
				) )
				->cssClass();
		}

		/**
		 * @inheritdoc
		 *
		 * @since 1.3.0
		 */
		protected function getItems( array $data ) {
			$this->helper = new ProductsShortcodeHelper( $data );
			$queryResult  = $this->helper->getProductQueryResult();

			return $queryResult->getItemIdList();
		}

		/**
		 * @inheritdoc
		 *
		 * @since 1.3.0
		 */
		protected function getOrderByOptions() {
			return array_merge( array(
				'price'      => esc_html__( 'Price', 'pikart-base' ),
				'popularity' => esc_html__( 'Popularity', 'pikart-base' ),
				'rating'     => esc_html__( 'Rating', 'pikart-base' ),
			), parent::getOrderByOptions() );
		}

		/**
		 * @inheritdoc
		 *
		 * @since 1.4.0
		 */
		protected function getItemPostTypeCategory() {
			return PostTypeSlug::PRODUCT_CATEGORY;
		}

		/**
		 * @inheritdoc
		 *
		 * @since 1.4.0
		 */
		protected function getItemPostTypeTag() {
			return PostTypeSlug::PRODUCT_TAG;
		}
	}
}