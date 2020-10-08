<?php

namespace Pikart\Nels\Shop;

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\WpThemeCore\Shop\ShopUtil;
use WC_Product;
use WC_Product_Variable;
use WP_Post;

if ( ! class_exists( __NAMESPACE__ . '\ShopTemplateHelper' ) ) {

	/**
	 * Class ShopTemplateHelper
	 * @package Pikart\Nels\Shop
	 */
	class ShopTemplateHelper {

		/**
		 * @return array
		 */
		public static function getCommentFormArguments() {
			$commenter  = wp_get_current_commenter();
			$titleReply = have_comments()
				? esc_html__( 'Add a review', 'nels' )
				: sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'nels' ), get_the_title() );

			$commentForm = array(
				'title_reply'         => $titleReply,
				'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'nels' ),
				'title_reply_before'  => '<h3 id="reply-title" class="respond__title comment-reply-title">',
				'title_reply_after'   => '</h3>',
				'comment_notes_after' => '',
				'label_submit'        => esc_html__( 'Submit', 'nels' ),
				'id_submit'           => 'submit-woocommerce',
				'class_submit'        => 'comment-form__btn',
				'logged_in_as'        => '',
				'comment_field'       => '',
			);

			$name_email_required = (bool) get_option( 'require_name_email', 1 );
			$fields              = array(
				'author' => array(
					'label'    => __( 'Name', 'woocommerce' ),
					'type'     => 'text',
					'value'    => $commenter['comment_author'],
					'required' => $name_email_required,
				),
				'email'  => array(
					'label'    => __( 'Email', 'woocommerce' ),
					'type'     => 'email',
					'value'    => $commenter['comment_author_email'],
					'required' => $name_email_required,
				),
			);

			$comment_form['fields'] = array();

			foreach ( $fields as $key => $field ) {
				$field_html  = '<p class="comment-form__item comment-form__item--woocommerce comment-form__item--' . esc_attr( $key ) . '">';
				$field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

				if ( $field['required'] ) {
					$field_html .= '&nbsp;<span class="required">*</span>';
				}

				$field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

				$comment_form['fields'][ $key ] = $field_html;
			}

			$accountPageUrl = wc_get_page_permalink( 'myaccount' );

			if ( $accountPageUrl ) {
				$logInText = sprintf(
					esc_html__( 'You must be <a href="%s">logged in</a> to post a review.', 'nels' ),
					esc_url( $accountPageUrl ) );

				$commentForm['must_log_in'] = sprintf( '<p class="must-log-in">%s</p>', $logInText );
			}

			if ( self::wcReviewRatingsEnabled() ) {
				$ratingOptions = '<select name="rating" id="rating" required>
							<option value="">' . esc_html__( 'Rate&hellip;', 'nels' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'nels' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'nels' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'nels' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'nels' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'nels' ) . '</option>
						</select>';


				$commentForm['comment_field'] = sprintf(
					'<div class="comment-form-rating"><label for="rating">%s</label>%s</div>',
					esc_html__( 'Your rating', 'nels' ),
					$ratingOptions
				);
			}

			$commentForm['comment_field'] .= sprintf(
				'<textarea id="comment" name="comment" class="%s"
							cols="45" rows="8" placeholder="%s" required></textarea>',
				'comment-form__item comment-form__item--woocommerce comment-form__item--textarea',
				esc_html__( 'Your rating', 'nels' ) );

			return $commentForm;
		}

		/**
		 * @param bool $isMainImage
		 */
		public static function showProductImages( $isMainImage ) {
			$product = ShopUtil::getGlobalProduct();

			$postThumbnailId = $product->get_image_id();

			if ( has_post_thumbnail() ) {
				$html = self::wcGetGalleryImageHtml( $postThumbnailId, $isMainImage );
			} else {
				$imagePlaceholder = sprintf( '<img src="%s" alt="%s" class="wp-post-image" />',
					esc_url( wc_placeholder_img_src() ),
					esc_html__( 'Awaiting product image', 'nels' )
				);

				$html = sprintf(
					'<div class="woocommerce-product-gallery__image--placeholder"><a href="#">%s</a></div>',
					$imagePlaceholder
				);
			}

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $postThumbnailId );

			$attachmentIds = $product->get_gallery_image_ids();

			if ( $product->is_type( 'variable' ) ) {
				/* @var WC_Product_Variable $product */
				$variations = $product->get_available_variations();

				foreach ( $variations as $variation ) {
					if ( ! empty( $variation['image_id'] ) && $postThumbnailId !== $variation['image_id'] ) {
						$attachmentIds[] = $variation['image_id'];
					}
				}
			}

			if ( ! $attachmentIds ) {
				return;
			}

			$attachmentIds = array_unique( $attachmentIds );

			foreach ( $attachmentIds as $attachmentId ) {
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html',
					self::wcGetGalleryImageHtml( $attachmentId, $isMainImage ), $attachmentId );
			}
		}

		public static function backupAndClearWcNotices() {
			WC()->session->set( 'wc_notices_backup', WC()->session->get( 'wc_notices', array() ) );
			wc_clear_notices();
		}

		public static function restoreWcNoticesFromBackup() {
			WC()->session->set( 'wc_notices', WC()->session->get( 'wc_notices_backup', array() ) );
		}

		/**
		 * @return bool
		 */
		public static function isShopCartEnabled() {
			return ShopUtil::isShopActivated() && WC()->cart->get_cart_contents_count() > 0;
		}

		/**
		 * @return bool
		 */
		public static function woocommerceProductLoop() {
			/**
			 * @since woocommerce 3.4.0
			 */
			return function_exists( 'woocommerce_product_loop' ) ? woocommerce_product_loop() : have_posts();
		}

		/**
		 * @param string|array $class
		 * @param int|WP_Post|WC_Product $productId
		 *
		 * @return array
		 */
		public static function wcGetProductClass( $class = '', $productId = null ) {
			/**
			 * @since woocommerce 3.4.0
			 */
			return function_exists( 'wc_get_product_class' )
				? wc_get_product_class( $class, $productId ) : get_post_class( $class, $productId );
		}

		/**
		 * @param string|array $class
		 * @param int|WP_Post|WC_Product $productId
		 */
		public static function wcProductClass( $class = '', $productId = null ) {
			/**
			 * @since woocommerce 3.4.0
			 */
			function_exists( 'wc_product_class' )
				? wc_product_class( $class, $productId ) : post_class( $class, $productId );
		}

		/**
		 * @param int $attachmentId
		 * @param bool $mainImage
		 *
		 * @return string
		 */
		public static function wcGetGalleryImageHtml( $attachmentId, $mainImage = false ) {
			/**
			 * @since woocommerce 3.3.2
			 */
			if ( function_exists( 'wc_get_gallery_image_html' ) ) {
				return wc_get_gallery_image_html( $attachmentId, $mainImage );
			}

			$flexslider       = (bool) apply_filters(
				'woocommerce_single_product_flexslider_enabled', get_theme_support( 'wc-product-gallery-slider' ) );
			$galleryThumbnail = wc_get_image_size( 'gallery_thumbnail' );
			$thumbnailSize    = apply_filters( 'woocommerce_gallery_thumbnail_size', array(
				$galleryThumbnail['width'],
				$galleryThumbnail['height']
			) );

			$imageSize    = apply_filters( 'woocommerce_gallery_image_size',
				$flexslider || $mainImage ? 'woocommerce_single' : $thumbnailSize );
			$fullSize     = apply_filters( 'woocommerce_gallery_full_size',
				apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
			$thumbnailSrc = wp_get_attachment_image_src( $attachmentId, $thumbnailSize );
			$fullSrc      = wp_get_attachment_image_src( $attachmentId, $fullSize );

			$image = wp_get_attachment_image( $attachmentId, $imageSize, false, array(
				'title'                   => get_post_field( 'post_title', $attachmentId ),
				'data-caption'            => get_post_field( 'post_excerpt', $attachmentId ),
				'data-src'                => $fullSrc[0],
				'data-large_image'        => $fullSrc[0],
				'data-large_image_width'  => $fullSrc[1],
				'data-large_image_height' => $fullSrc[2],
				'class'                   => $mainImage ? 'wp-post-image' : '',
			) );

			return sprintf( '<div data-thumb="%s" class="woocommerce-product-gallery__image"><a href="%s">%s</a></div>',
				esc_url( $thumbnailSrc[0] ), esc_url( $fullSrc[0] ), $image
			);
		}

		/**
		 * @return int
		 */
		public static function wcGetTotalPages() {
			/**
			 * @since woocommerce 3.3.0
			 */
			if ( function_exists( 'wc_get_loop_prop' ) ) {
				return wc_get_loop_prop( 'total_pages' );
			}

			if ( isset( $GLOBALS['woocommerce_loop']['total_pages'] ) ) {
				return $GLOBALS['woocommerce_loop']['total_pages'];
			}

			return get_query_var( 'wc_query' ) ? $GLOBALS['wp_query']->max_num_pages : 0;
		}

		/**
		 * @return int
		 */
		public static function wcGetCurrentPage() {
			/**
			 * @since woocommerce 3.3.0
			 */
			if ( function_exists( 'wc_get_loop_prop' ) ) {
				return wc_get_loop_prop( 'current_page' );
			}

			if ( isset( $GLOBALS['woocommerce_loop']['current_page'] ) ) {
				return $GLOBALS['woocommerce_loop']['current_page'];
			}

			return get_query_var( 'wc_query' ) ? max( 1, get_query_var( 'paged' ) ) : 1;
		}

		/**
		 * @return int
		 */
		public static function wcGetColumns() {
			/**
			 * @since woocommerce 3.3.0
			 */
			if ( function_exists( 'wc_get_loop_prop' ) ) {
				return wc_get_loop_prop( 'columns' );
			}

			$defaultNbColumns = Service::themeOptionsUtil()->getIntOption( ThemeOption::ARCHIVE_COLUMNS_NUMBER );

			$nbColumns = ! empty( $GLOBALS['woocommerce_loop']['columns'] )
				? $GLOBALS['woocommerce_loop']['columns'] : apply_filters( 'loop_shop_columns', $defaultNbColumns );

			return max( 1, $nbColumns );
		}

		/**
		 * @return int
		 */
		public static function wcGetDefaultProductsPerRow() {
			/**
			 * @since woocommerce 3.3.0
			 */
			if ( function_exists( 'wc_get_default_products_per_row' ) ) {
				return wc_get_default_products_per_row();
			}

			$defaultNbColumns = Service::themeOptionsUtil()->getIntOption( ThemeOption::ARCHIVE_COLUMNS_NUMBER );

			return max( 1, apply_filters( 'loop_shop_columns', $defaultNbColumns ) );
		}

		/**
		 * @since 1.2.1
		 *
		 * @return int
		 */
		public static function wcReviewRatingsEnabled() {
			/**
			 * @since woocommerce 3.6.0
			 */
			if ( function_exists( 'wc_review_ratings_enabled' ) ) {
				return wc_review_ratings_enabled();
			}

			return self::wcReviewsEnabled() && 'yes' === get_option( 'woocommerce_enable_review_rating' );
		}

		public static function wcReviewsEnabled() {
			/**
			 * @since woocommerce 3.6.0
			 */
			if ( function_exists( 'wc_reviews_enabled' ) ) {
				return wc_reviews_enabled();
			}

			return 'yes' === get_option( 'woocommerce_enable_reviews' );
		}
	}
}
