<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\ColorsConfig' ) ) {

	/**
	 * Class ColorsConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class ColorsConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			return $this->controlConfigBuilder
				->noInput( 'general_colors_title' )
				->label( esc_html__( 'General', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::FEATURE_COLOR )
				->defaultVal( '#fe6c61' )
				->description( esc_html__( '_feature color', 'nels' ) )
				->css( $this->getFeatureColorCssConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::HEADINGS_COLOR )
				->defaultVal( '#2a2a2a' )
				->description( esc_html__( '_headings', 'nels' ) )
				->css( array(
					'color' => array(
						'h1',
						'h2',
						'h3',
						'h4',
						'h5',
						'h6',
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::BODY_TEXT_COLOR )
				->defaultVal( '#4d4d4d' )
				->description( esc_html__( '_body text', 'nels' ) )
				->css( array(
					'color' => array(
						'body',
						'a'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::CONTENT_SELECTION_COLOR )
				->defaultVal( '#fe6c61' )
				->description( esc_html__( '_selection', 'nels' ) )
				->css( array(
					'background'       => array(
						'::selection'
					),
					'background-color' => array(
						'::-moz-selection'
					)
				) )
				->transportTypeRefresh()//pseudo-elements cannot be directly modified with js
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'buttons_colors_title' )
				->label( esc_html__( 'Buttons', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::BUTTONS_TEXT_COLOR )
				->defaultVal( '#ffffff' )
				->description( esc_html__( '_text', 'nels' ) )
				->css( $this->getButtonsTextColorCssConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::BUTTONS_TEXT_HOVER_COLOR )
				->defaultVal( '#ffffff' )
				->description( esc_html__( '_text hover', 'nels' ) )
				->css( $this->getButtonsTextHoverColorCssConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::BUTTONS_BACKGROUND_COLOR )
				->defaultVal( '#fe6c61' )
				->description( esc_html__( '_background', 'nels' ) )
				->css( $this->getButtonsBackgroundColorCssConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::BUTTONS_BACKGROUND_HOVER_COLOR )
				->defaultVal( '#ff9a9e' )
				->description( esc_html__( '_background hover', 'nels' ) )
				->css( $this->getButtonsBackgroundHoverColorCssConfig() )
				->build();
		}

		/**
		 * @return array
		 */
		private function getFeatureColorCssConfig() {
			return array(
				'background-color' => array(
					'.site-loader--bar > div',
					'.site-loader--bounce__item',
					'.site-loader--double-bounce--one',
					'.site-loader--double-bounce--two',
					'.site-loader--ocean > div',
					'.site-loader--ball-pulse > div',
					'.site-loader--ball-grid-pulse > div',
					'.site-loader--ball-scale-multiple > div',
					'blockquote p:before',
					'.quote__content:before',
					'.link__content:before',
					'.progressbar__progress',
					'.card--fade .color-overlay-inner',
					'.card--move .color-overlay-inner',
					'.card--pinned .color-overlay-inner',
					'ul.page-numbers .page-numbers.current',
					'ul.page-numbers .page-numbers:hover',
					'.nav--page-breaks li > span',
					'.error-404',
					'.widget_categories li.cat-item a:hover > span',
					'.widget_categories li.cat-item.current-cat > a span',
					'.widget_product_categories li.cat-item a:hover > span',
					'.widget_product_categories li.cat-item.current-cat > a span',
					'.woocommerce.widget_price_filter .price_slider.ui-widget-content .ui-slider-handle',
					'.woocommerce.widget_price_filter .price_slider.ui-widget-content .ui-slider-range',
					'.woocommerce-checkout .select2-container--default .select2-dropdown'
					. ' .select2-results__option--highlighted[aria-selected]',
					'.woocommerce-demo-store .woocommerce-store-notice.demo_store',
					'.quantity .input-button:hover',
					'.products-compare-popup h1',
					'.hover-style--ball .menu-item > a:after',
                    '.hover-style--ball .tool-icons a:after',
                    '.hover-style--ball .account-icon-popup .woocommerce-MyAccount-navigation ul li a:after',
                    '.hover-style--ball .widget_archive li a:after',
                    '.hover-style--ball .widget_categories li a:after',
                    '.hover-style--ball .widget_pages li a:after',
					'.hover-style--ball .widget_nav_menu li a:after',
				),
				'border-color'     => array(
					'.site-loader--ball-clip-rotate > div',
					'.tabs__title.is-active a',
					'.quantity .input-button:hover',
					'.mfp-quick-view .mfp-s-loading',
					'.woocommerce-checkout .woocommerce .showlogin',
					'.woocommerce-checkout .woocommerce .showcoupon',
				),
				'color'            => array(
					'.card .card-icons__item a:hover',
					'.card--default .branding__title:hover',
					'.card--default.sticky .branding__title',
					'.card--move .card-body:hover > .card-content:first-child .branding__title',
					'.card--move.sticky .card-body > *:first-child .branding__title',
					'.card--fade .card-body:hover > .card-content:first-child .branding__title',
					'.card--fade.sticky .card-body > *:first-child .branding__title',
					'.card--pinned .card-body:hover > .card-content:first-child .branding__title',
					'.card--pinned.sticky .card-body > *:first-child .branding__title',
					'.card--plain .branding__title:hover',
					'.card--plain.sticky .branding__title',
					'.author__link:hover',
					'.taxonomies-tags a:hover',
					'.comment__content__reply:hover a',
					'.error-404__button:hover',
					'.site-header__shop-search__button:hover',
					'.social-list__item .item__link:hover',
					'.tabs__title.is-active a',
					'.site-main--product .product .entry-details .price',
					'.site-main--product .star-rating span',
					'.site-main--product .star-rating:before',
					'.woocommerce.widget__item ul li.chosen a:before',
					'.woocommerce table.shop_table tbody .product-subtotal',
					'.woocommerce ul#shipping_method .amount',
					'.woocommerce .cart-collaterals .cart_totals .shop_table tr:not(:first-child) td',
					'#order_review tfoot .amount',
					'.woocommerce-checkout .woocommerce .showlogin',
					'.woocommerce-checkout .woocommerce .showcoupon',
					'.woocommerce-order-details .shop_table tfoot tr:first-child td',
					'.woocommerce-order-details .shop_table tfoot tr:last-child td',
					'.woocommerce-MyAccount-content a',
					'.woocommerce.widget_rating_filter .wc-layered-nav-rating:hover .star-rating span',
					'.woocommerce.widget_products span.amount',
					'.woocommerce.widget_products ins .amount',
					'.woocommerce.widget_top_rated_products span.amount',
					'.woocommerce.widget_top_rated_products ins .amount',
					'.woocommerce.widget_recently_viewed_products span.amount',
					'.woocommerce.widget_recently_viewed_products ins .amount',
					'.woocommerce.widget_shopping_cart .amount',
					'.woocommerce .card.card--default .price',
					'.woocommerce .card.card--plain .price',

					'.quick-view-popup-branding a:hover',
					'.products-compare__list tbody tr:nth-child(3) td:not(:first-child)',
					'.products-compare__list .star-rating span',
					'.products-compare__list .star-rating:before',
					'.account-icon-popup__create-link a',
					'.account-icon-popup .woocommerce-form-login .woocommerce-form-login__footer .woocommerce-LostPassword a',
				),
			);
		}

		/**
		 * @return array
		 */
		private function getButtonsTextColorCssConfig() {
			return array(
				'color' => array(
					'.card .card-info__item .button',
					'.comments__switch-button',
					'.comment-form__btn',
					'.site-main--product .entry-details .cart .button',
					'.woocommerce .woocommerce-message .button',
					'.woocommerce .woocommerce-Message .button',
					'.woocommerce table.shop_table tbody .actions .coupon .button',
					'.woocommerce .wc-proceed-to-checkout a.checkout-button',
					'.woocommerce .checkout_coupon .button',
					'.woocommerce #payment #place_order',
					'.woocommerce .woocommerce-form-login .button',
					'.woocommerce .register .button',
					'.woocommerce .checkout_coupon .button',
					'.woocommerce-lost-password .lost_reset_password .button',
					'.woocommerce .return-to-shop .button',
					'.woocommerce.widget_shopping_cart .button.checkout',
					'.woocommerce div.woocommerce-MyAccount-content .edit-account .button',
					'.woocommerce .woocommerce-message a.woocommerce-Button',
					'.woocommerce .woocommerce-Message a.woocommerce-Button',
					'.woocommerce button.button.alt.disabled',
					'.woocommerce .button.wc-backward',
					'.woocommerce-pagination .button.woocommerce-button',
					'.woocommerce .cart-collaterals .cart_totals .shipping .woocommerce-shipping-calculator .button',
					'.products-compare-popup .products-compare__list .button',
					'.products-compare-popup .products-compare__list .added_to_cart',
					'.widget_price_filter .price_slider_amount .button',
					'.quick-view-popup__view-details-button',

					'.wpforms-container .wpforms-submit',
				)
			);
		}

		/**
		 * @return array
		 */
		private function getButtonsTextHoverColorCssConfig() {
			return array(
				'color' => array(
					'.card .card-info__item .button:hover',
					'.comments__switch-button:hover',
					'.comment-form__btn:hover',
					'.site-main--product .entry-details .cart .button:hover',
					'.woocommerce .woocommerce-message .button:hover',
					'.woocommerce .woocommerce-Message .button:hover',
					'.woocommerce table.shop_table tbody .actions .coupon .button:hover',
					'.woocommerce .wc-proceed-to-checkout a.checkout-button:hover',
					'.woocommerce .checkout_coupon .button:hover',
					'.woocommerce #payment #place_order:hover',
					'.woocommerce .woocommerce-form-login .button:hover',
					'.woocommerce .register .button:hover',
					'.woocommerce .checkout_coupon .button:hover',
					'.woocommerce-lost-password .lost_reset_password .button:hover',
					'.woocommerce .return-to-shop .button:hover',
					'.woocommerce.widget_shopping_cart .button.checkout:hover',
					'.woocommerce div.woocommerce-MyAccount-content .edit-account .button:hover',
					'.woocommerce .woocommerce-message a.woocommerce-Button:hover',
					'.woocommerce .woocommerce-Message a.woocommerce-Button:hover',
					'.woocommerce button.button.alt.disabled:hover',
					'.woocommerce .button.wc-backward:hover',
					'.woocommerce-pagination .button.woocommerce-button:hover',
					'.woocommerce .cart-collaterals .cart_totals .shipping .woocommerce-shipping-calculator .button:hover',
					'.products-compare-popup .products-compare__list .button:hover',
					'.products-compare-popup .products-compare__list .added_to_cart:hover',
					'.widget_price_filter .price_slider_amount .button:hover',
					'.quick-view-popup__view-details-button:hover',

					'.wpforms-container .wpforms-submit:hover',
				)
			);
		}

		/**
		 * @return array
		 */
		private function getButtonsBackgroundColorCssConfig() {
			return array(
				'background-color' => array(
					'.card .card-info__item .button',
					'.comments__switch-button',
					'.comment-form__btn',
					'.site-main--product .entry-details .cart .button',
					'.woocommerce .woocommerce-message .button',
					'.woocommerce .woocommerce-Message .button',
					'.woocommerce table.shop_table tbody .actions .coupon .button',
					'.woocommerce .wc-proceed-to-checkout a.checkout-button',
					'.woocommerce .checkout_coupon .button',
					'.woocommerce #payment #place_order',
					'.woocommerce .woocommerce-form-login .button',
					'.woocommerce .register .button',
					'.woocommerce .checkout_coupon .button',
					'.woocommerce-lost-password .lost_reset_password .button',
					'.woocommerce .return-to-shop .button',
					'.woocommerce.widget_shopping_cart .button.checkout',
					'.woocommerce div.woocommerce-MyAccount-content .edit-account .button',
					'.woocommerce .woocommerce-message a.woocommerce-Button',
					'.woocommerce .woocommerce-Message a.woocommerce-Button',
					'.woocommerce button.button.alt.disabled',
					'.woocommerce .button.wc-backward',
					'.woocommerce-pagination .button.woocommerce-button',
					'.woocommerce .cart-collaterals .cart_totals .shipping .woocommerce-shipping-calculator .button',
					'.woocommerce .card--default .card-body:hover .card-info__item .button',
					'.products-compare-popup .products-compare__list .button',
					'.products-compare-popup .products-compare__list .added_to_cart',
					'.widget_price_filter .price_slider_amount .button',
					'.quick-view-popup__view-details-button',

					'.wpforms-container .wpforms-submit',
				),
				'color' => array(
					'.card .card-info__item .button i',
				)
			);
		}

		/**
		 * @return array
		 */
		private function getButtonsBackgroundHoverColorCssConfig() {
			return array(
				'background-color' => array(
					'.card .card-info__item .button:hover',
					'.comments__switch-button:hover',
					'.comment-form__btn:hover',
					'.site-main--product .entry-details .cart .button:hover',
					'.woocommerce .woocommerce-message .button:hover',
					'.woocommerce .woocommerce-Message .button:hover',
					'.woocommerce table.shop_table tbody .actions .coupon .button:hover',
					'.woocommerce .wc-proceed-to-checkout a.checkout-button:hover',
					'.woocommerce .checkout_coupon .button:hover',
					'.woocommerce #payment #place_order:hover',
					'.woocommerce .woocommerce-form-login .button:hover',
					'.woocommerce .register .button:hover',
					'.woocommerce .checkout_coupon .button:hover',
					'.woocommerce-lost-password .lost_reset_password .button:hover',
					'.woocommerce .return-to-shop .button:hover',
					'.woocommerce.widget_shopping_cart .button.checkout:hover',
					'.woocommerce div.woocommerce-MyAccount-content .edit-account .button:hover',
					'.woocommerce .woocommerce-message a.woocommerce-Button:hover',
					'.woocommerce .woocommerce-Message a.woocommerce-Button:hover',
					'.woocommerce button.button.alt.disabled:hover',
					'.woocommerce .button.wc-backward:hover',
					'.woocommerce-pagination .button.woocommerce-button:hover',
					'.woocommerce .cart-collaterals .cart_totals .shipping .woocommerce-shipping-calculator .button:hover',
					'.woocommerce .card--default .card-body .card-info__item .button:hover',
					'.products-compare-popup .products-compare__list .button:hover',
					'.products-compare-popup .products-compare__list .added_to_cart:hover',
					'.widget_price_filter .price_slider_amount .button:hover',
					'.quick-view-popup__view-details-button:hover',

					'.wpforms-container .wpforms-submit:hover',
				),
				'color' => array(
					'.woocommerce .card .card-info__item .button:hover i',
				)
			);
		}
	}
}