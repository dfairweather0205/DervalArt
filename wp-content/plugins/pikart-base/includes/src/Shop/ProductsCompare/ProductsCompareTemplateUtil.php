<?php

namespace Pikart\WpBase\Shop\ProductsCompare;

use Pikart\WpCore\Common\Util;
use WC_Product;

if ( ! class_exists( __NAMESPACE__ . '\\ProductsCompareTemplateUtil' ) ) {

	/**
	 * Class ProductsCompareTemplateUtil
	 * @package Pikart\WpBase\Shop\ProductsCompare
	 *
	 * @since 1.3.0
	 */
	class ProductsCompareTemplateUtil {

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * ProductsCompareTemplateUtil constructor.
		 *
		 * @param Util $util
		 */
		public function __construct( Util $util ) {
			$this->util = $util;
		}

		/**
		 * @return array
		 */
		public function getCompareFields() {
			$fields = array(
				'image'      => '',
				'title'      => esc_html__( 'Title', 'pikart-base' ),
				'price'      => esc_html__( 'Price', 'pikart-base' ),
				'addToCart'  => esc_html__( 'Add to Cart', 'pikart-base' ),
				'sku'        => esc_html__( 'Sku', 'pikart-base' ),
				'stock'      => esc_html__( 'Availability', 'pikart-base' ),
				'weight'     => esc_html__( 'Weight', 'pikart-base' ),
				'dimensions' => esc_html__( 'Dimensions', 'pikart-base' ),
			);

			$attributeTaxonomies = wc_get_attribute_taxonomies();

			if ( ! empty( $attributeTaxonomies ) ) {
				foreach ( $attributeTaxonomies as $attribute ) {
					$taxonomy = wc_attribute_taxonomy_name( $attribute->attribute_name );

					if ( taxonomy_exists( $taxonomy ) ) {
						$fields[ $taxonomy ] = wc_attribute_label( $taxonomy );
					}
				}
			}

			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
				$fields['rating'] = esc_html__( 'Rating', 'pikart-base' );
			}

			$fields['description'] = esc_html__( 'Description', 'pikart-base' );

			return $fields;
		}

		/**
		 * @param WC_Product $product
		 * @param string $field
		 *
		 * @return string
		 */
		public function getFieldValue( WC_Product $product, $field ) {
			if ( method_exists( $this, $field ) ) {
				return $this->$field( $product );
			}

			return $this->getCustomAttributeValues( $product, $field );
		}

		/**
		 * @param WC_Product $product
		 *
		 * @return string
		 */
		private function image( WC_Product $product ) {
			return $product->get_image();
		}

		/**
		 * @param WC_Product $product
		 *
		 * @return string
		 */
		private function title( WC_Product $product ) {
			return $product->get_title();
		}

		/**
		 * @param WC_Product $product
		 *
		 * @return string
		 */
		private function price( WC_Product $product ) {
			return $product->get_price_html();
		}

		/**
		 * @param WC_Product $product
		 *
		 * @return string
		 */
		private function addToCart( WC_Product $product ) {
			return $this->util->captureOutput( function () {
				woocommerce_template_loop_add_to_cart();
			} );
		}

		/**
		 * @param WC_Product $product
		 *
		 * @return string
		 */
		private function description( WC_Product $product ) {
			return apply_filters( 'woocommerce_short_description', $product->get_short_description() );
		}

		/**
		 * @param WC_Product $product
		 *
		 * @return string
		 */
		private function sku( WC_Product $product ) {
			return $product->get_sku();
		}

		/**
		 * @param WC_Product $product
		 *
		 * @return string
		 */
		private function stock( WC_Product $product ) {
			return $product->is_in_stock()
				? esc_html__( 'In Stock', 'pikart-base' ) : esc_html__( 'Out of Stock', 'pikart-base' );
		}

		/**
		 * @param WC_Product $product
		 *
		 * @return string
		 */
		private function weight( WC_Product $product ) {
			return $product->has_weight() ? wc_format_weight( $product->get_weight() ) : '';
		}

		/**
		 * @param WC_Product $product
		 *
		 * @return string
		 */
		private function dimensions( WC_Product $product ) {
			return $product->has_dimensions() ? wc_format_dimensions( $product->get_dimensions( false ) ) : '';
		}

		/**
		 * @param WC_Product $product
		 *
		 * @return string
		 */
		private function rating( WC_Product $product ) {
			return wc_get_rating_html( $product->get_average_rating(), $product->get_rating_count() );
		}

		/**
		 * @param WC_Product $product
		 * @param string $field
		 *
		 * @return string
		 */
		private function getCustomAttributeValues( WC_Product $product, $field ) {
			if ( ! taxonomy_exists( $field ) ) {
				return '';
			}

			$terms = get_the_terms( $product->get_id(), $field );

			if ( empty( $terms ) ) {
				return '';
			}

			$values = array();

			foreach ( $terms as $term ) {
				$values[] = sanitize_term_field( 'name', $term->name, $term->term_id, $field, 'display' );
			}

			return implode( ', ', $values );
		}
	}
}