<?php

namespace Pikart\Nels\Shop;

use Pikart\Nels\Post\Options\PostOptionsLoader;
use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\Nels\ThemeOptions\ThemeOptionsUtil;
use Pikart\WpThemeCore\Common\AssetFilterName;
use Pikart\WpThemeCore\Common\Util;
use Pikart\WpThemeCore\Shop\ShopUtil;
use WC_Product;

if ( ! class_exists( __NAMESPACE__ . '\ShopSetup' ) ) {

	/**
	 * Class ShopSetup
	 * @package Pikart\Nels\Shop
	 */
	class ShopSetup {

		const DEFAULT_PRODUCTS_PER_ROW_NB = 3;

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * @var ThemeOptionsUtil
		 */
		private $themeOptionsUtil;

		/**
		 * @var PostOptionsLoader
		 */
		private $postOptionsLoader;
		/**
		 * @var ProductQuickViewInitializer
		 */
		private $productQuickViewInitializer;

		/**
		 * ShopSetup constructor.
		 *
		 * @param Util $util
		 * @param PostOptionsLoader $postOptionsLoader
		 * @param ThemeOptionsUtil $themeOptionsUtil
		 * @param ProductQuickViewInitializer $productQuickViewInitializer
		 */
		public function __construct(
			Util $util,
			PostOptionsLoader $postOptionsLoader,
			ThemeOptionsUtil $themeOptionsUtil,
			ProductQuickViewInitializer $productQuickViewInitializer
		) {
			$this->util                        = $util;
			$this->themeOptionsUtil            = $themeOptionsUtil;
			$this->postOptionsLoader           = $postOptionsLoader;
			$this->productQuickViewInitializer = $productQuickViewInitializer;
		}

		public function run() {
			if ( ! ShopUtil::isShopActivated() ) {
				return;
			}

			$this->productQuickViewInitializer->init();

			add_action( 'after_setup_theme', function () {
				add_theme_support( 'woocommerce' );
			} );

			add_filter( AssetFilterName::loadAddthisScript(), function ( $loadAddthisScript ) {
				return $loadAddthisScript || ShopUtil::isShop();
			} );

			add_action( 'wp_enqueue_scripts', function () {
				//need this script for quick view product variations
				wp_enqueue_script( 'wc-add-to-cart-variation' );
			}, 99 );

			$this->changeProductsPerRowDefaultValue();
			$this->setWcTemplatePath();
			$this->removeWooCommerceHooks();
			$this->changeLoopAddToCartArguments();
			$this->changeFunctionsPriorityForSingleProductSummary();
			$this->changeSaleFlash();
			$this->changeSingleProductReview();
			$this->changeLoopCategoryTitle();
			$this->addProductCategoryCssClass();
			$this->disableAdditionalInformationHeading();
			$this->disableProductDescriptionHeading();
			$this->wrapSingleProduct();
			$this->manageAddToCartFragments();
			$this->enableCatalogMode();
			$this->addProductAlternativeImage();
			$this->wrapLoginFormFooter();
			$this->setupProductsCarouselUsage();
			$this->setupProductTypesNbColumns();
		}

		private function setupProductTypesNbColumns() {
			$themeOptionsUtil = $this->themeOptionsUtil;

			add_filter( 'woocommerce_upsells_columns', function () use ( $themeOptionsUtil ) {
				return $themeOptionsUtil->getIntOption( ThemeOption::SHOP_UPSELLS_PRODUCTS_NB_COLUMNS );
			} );

			add_filter( 'woocommerce_cross_sells_columns', function () use ( $themeOptionsUtil ) {
				return $themeOptionsUtil->getIntOption( ThemeOption::SHOP_CROSS_SELLS_PRODUCTS_NB_COLUMNS );
			} );

			add_filter( 'woocommerce_related_products_columns', function () use ( $themeOptionsUtil ) {
				return $themeOptionsUtil->getIntOption( ThemeOption::SHOP_RELATED_PRODUCTS_NB_COLUMNS );
			} );
		}

		private function changeProductsPerRowDefaultValue() {
			add_filter( 'default_option_woocommerce_catalog_columns', function ( $default ) {
				return ShopSetup::DEFAULT_PRODUCTS_PER_ROW_NB;
			} );

			add_filter( 'customize_dynamic_setting_args', function ( $args, $settingId ) {
				if ( 'woocommerce_catalog_columns' === $settingId ) {
					$args['default'] = ShopSetup::DEFAULT_PRODUCTS_PER_ROW_NB;
				}

				return $args;
			}, 10, 2 );
		}

		private function setWcTemplatePath() {
			$templatePath = 'templates/woocommerce/';

			if ( version_compare( WC()->version, '3.3', '<' ) ) {
				$templatePath .= 'compatibility/3.2/';
			}

			add_filter( 'woocommerce_template_path', function () use ( $templatePath ) {
				return $templatePath;
			} );
		}

		private function manageAddToCartFragments() {
			$util = $this->util;

			add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) use ( $util ) {
				$fragments['total_count']               = WC()->cart->get_cart_contents_count();
				$fragments['pikart_cart_popup_details'] = $util->captureOutput( function () use ( $util ) {
					$util->partial( 'header/popups/shop-cart-popup-details' );
				} );

				return $fragments;
			} );
		}

		private function wrapSingleProduct() {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

			$util              = $this->util;
			$postOptionsLoader = $this->postOptionsLoader;

			$this->util->replaceHookFunction( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',
				function () use ( $postOptionsLoader, $util ) {
					if ( ShopUtil::isShop() || ! is_product() ) {
						return;
					}

					$productOptions = $postOptionsLoader->loadProductOptions( ShopUtil::getGlobalProduct()->get_id() );

					if ( $productOptions->isFeaturedBranding() ) {
						$util->partial( 'header-area' );
					}

					echo '<div id="content-area" class="content-area">';
					echo '<main class="site-main site-main--single site-main--product" role="main">';
				}
			);

			$this->util->replaceHookFunction(
				'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', function () {
				if ( ShopUtil::isShop() || ! is_product() ) {
					return;
				}

				echo '</main></div>';
			} );
		}

		private function disableProductDescriptionHeading() {
			add_filter( 'woocommerce_product_description_heading', function () {
				return '';
			} );
		}

		private function disableAdditionalInformationHeading() {
			add_filter( 'woocommerce_product_additional_information_heading', function () {
				return '';
			} );
		}

		private function changeLoopCategoryTitle() {
			$this->util->replaceHookFunction(
				'woocommerce_shop_loop_subcategory_title',
				'woocommerce_template_loop_category_title',
				function ( $category ) {
					echo esc_html( $category->name );
				}
			);
		}

		private function addProductCategoryCssClass() {
			$themeOptionsUtil = $this->themeOptionsUtil;

			add_filter( 'product_cat_class', function ( $classes ) use ( $themeOptionsUtil ) {
				$classes[] = sprintf( 'card card--masonry card--%s column',
					$themeOptionsUtil->getOption( ThemeOption::SHOP_DISPLAY ) );

				return $classes;
			} );
		}

		private function changeSingleProductReview() {
			$this->startWrap( 'woocommerce_review_before', 'comment__header' );
			$this->endWrap( 'woocommerce_review_before' );

			$this->startWrap( 'woocommerce_review_before', 'comment__header__avatar' );
			$this->endWrap( 'woocommerce_review_before' );

			add_filter( 'woocommerce_review_gravatar_size', function () {
				return 72;
			} );

			$this->startWrap( 'woocommerce_review_before_comment_meta', 'comment__meta' );
			$this->endWrap( 'woocommerce_review_before_comment_text' );

			$this->startWrap( 'woocommerce_review_comment_text', 'comment__input-area' );
			$this->endWrap( 'woocommerce_review_after_comment_text' );
		}

		private function changeSaleFlash() {
			add_filter( 'woocommerce_sale_flash', function () {
				return sprintf( '<span class="on-sale">%s</span>', esc_html__( 'Sale', 'nels' ) );
			} );
		}

		private function removeWooCommerceHooks() {
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
			remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
			remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );
		}

		private function changeLoopAddToCartArguments() {
			add_filter( 'woocommerce_loop_add_to_cart_args', function ( $args, WC_Product $product ) {

				$args['class'] = trim( implode( ' ', array(
					'button',
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
					$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
				) ) );

				return $args;
			}, 10, 2 );
		}

		/**
		 * changes the order of woocommerce_single_product_summary functions
		 *
		 * Product Summary Box.
		 *
		 * new order:
		 *
		 * @see woocommerce_template_single_price() - 10
		 * @see woocommerce_template_single_rating() - 15 (old 10)
		 * @see woocommerce_template_single_excerpt() - 20
		 * @see woocommerce_template_single_meta() - 40
		 * @see woocommerce_template_single_sharing() - 50
		 */
		private function changeFunctionsPriorityForSingleProductSummary() {
			$this->util->changeHookFunctionPriority(
				'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10, 15 );
		}

		private function enableCatalogMode() {
			$themeOptionsUtil = $this->themeOptionsUtil;

			add_action( 'wp_loaded', function () use ( $themeOptionsUtil ) {
				if ( $themeOptionsUtil->isShopCatalogModeEnabled() ) {
					remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
					remove_action(
						'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
				}
			} );
		}

		private function addProductAlternativeImage() {
			$postOptionsLoader = $this->postOptionsLoader;

			add_action( 'woocommerce_before_shop_loop_item_title', function () use ( $postOptionsLoader ) {
				$alternativeImageId = $postOptionsLoader->loadProductOptions( ShopUtil::getGlobalProduct()->get_id() )
				                                        ->getSecondFeaturedImage();
				if ( $alternativeImageId ) {
					echo wp_get_attachment_image( $alternativeImageId, 'woocommerce_thumbnail', false, array(
						'class' => 'attachment-woocommerce_thumbnail size-woocommerce_thumbnail hover-image'
					) );
				}
			} );
		}

		private function wrapLoginFormFooter() {
			$this->startWrap( 'woocommerce_login_form', 'woocommerce-form-login__footer' );
			$this->endWrap( 'woocommerce_login_form_end' );
		}

		/**
		 * @param string $hook
		 * @param string $cssClass
		 * @param int $priority
		 */
		private function startWrap( $hook, $cssClass, $priority = 1 ) {
			add_action( $hook, function () use ( $cssClass ) {
				printf( '<div class="%s">', esc_attr( $cssClass ) );
			}, $priority );
		}

		/**
		 * @param string $hook
		 * @param int $priority
		 */
		private function endWrap( $hook, $priority = 999 ) {
			add_action( $hook, function () {
				echo '</div>';
			}, $priority );
		}

		private function setupProductsCarouselUsage() {
			$manageProductsCarouselUse = function ( $templateArgs, $productsUseCarousel ) {
				$carouselProductTypes = array( 'upsells', 'cross_sells', 'related_products' );

				if ( count( array_intersect( array_keys( $templateArgs ), $carouselProductTypes ) ) ) {
					set_query_var( 'productsUseCarousel', $productsUseCarousel );
				}
			};

			add_action( 'woocommerce_before_template_part',
				function ( $templateName, $templatePath, $located, $args ) use ( $manageProductsCarouselUse ) {
					$manageProductsCarouselUse( $args, true );
				}, 10, 4 );

			add_action( 'woocommerce_after_template_part',
				function ( $templateName, $templatePath, $located, $args ) use ( $manageProductsCarouselUse ) {
					$manageProductsCarouselUse( $args, false );
				}, 10, 4 );
		}
	}
}
