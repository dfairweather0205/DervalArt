<?php

namespace Pikart\WpBase\OptionsPages;

if ( ! class_exists( __NAMESPACE__ . '\\PageOption' ) ) {

	/**
	 * Class
	 * @package Pikart\WpBase\OptionsPages
	 */
	final class PageOption {

		/*--------------------------PIKART BASE OPTIONS--------------------------*/
		const GOOGLE_MAPS_API_KEY = 'google_maps_api_key';
		const GOOGLE_MAPS_PIN_IMAGE = 'google_maps_pin_image';
		const GOOGLE_ANALYTICS_TRACKING_ID = 'google_analytics_tracking_id';
		const SOCIAL_SHARE = 'social_share';
		const SOCIAL_SHARE_VISIBILITY = 'social_share_visibility';
		const LIKES_AREA_VISIBILITY = 'likes_area_visibility';

		/**
		 * @since 1.3.0
		 */
		const WISHLIST_ENABLED = 'wishlist_enabled';
		const WISHLIST_PAGE = 'wishlist_page';
		const PRODUCTS_COMPARE_ENABLED = 'products_compare_enabled';

		/**
		 * @since 1.7.0
		 */
		const CUSTOM_SOCIAL_PROFILES = 'custom_social_profiles';


		/*-----------------------------------------------------------------------*/
	}
}