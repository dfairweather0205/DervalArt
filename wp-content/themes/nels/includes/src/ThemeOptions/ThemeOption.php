<?php

namespace Pikart\Nels\ThemeOptions;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeOption' ) ) {

	/**
	 * Class ThemeOption
	 * @package Pikart\Nels\ThemeOptions
	 */
	final class ThemeOption {
		const MAIN_NAVIGATION_TYPE = 'main_navigation_type';
		const SITE_WIDTH = 'site_width';
		const LAYOUT_SITE_ELEMENTS = 'layout_site_elements';

		const SITE_HEADINGS_FONT_FAMILY = 'site_headings_font_family';
		const H1_FONT_SIZE = 'h1_font_size';
		const H1_FONT_WEIGHT = 'h1_font_weight';
		const H2_FONT_SIZE = 'h2_font_size';
		const H2_FONT_WEIGHT = 'h2_font_weight';
		const H3_FONT_SIZE = 'h3_font_size';
		const H3_FONT_WEIGHT = 'h3_font_weight';
		const H4_FONT_SIZE = 'h4_font_size';
		const H4_FONT_WEIGHT = 'h4_font_weight';
		const H5_FONT_SIZE = 'h5_font_size';
		const H5_FONT_WEIGHT = 'h5_font_weight';
		const H6_FONT_SIZE = 'h6_font_size';
		const H6_FONT_WEIGHT = 'h6_font_weight';
		const SITE_TEXT_FONT_FAMILY = 'site_text_font_family';
		const SITE_TEXT_FONT_SIZE = 'site_text_font_size';
		const SITE_TEXT_FONT_LINE_HEIGHT = 'site_text_font_line_height';
		const SITE_HEADER_NAVIGATION_FONT = 'site_header_navigation_font';
		const SITE_HOVER_STYLE = 'site_hover_style';

		const SITE_LOADING_ANIMATION = 'site_loading_animation';
		const PARALLAX_SPEED = 'parallax_speed';
		const SCROLL_TOP_BUTTON = 'scroll_top_button';

		const HEADER_BACKGROUND_COLOR = 'header_background_color';
		const HEADER_BACKGROUND_TRANSPARENCY = 'header_background_transparency';
		const HEADER_COLOR_SKIN = 'header_color_skin';
		const HEADER_COLOR_SKIN_LIGHT = 'header_color_skin_light';
		const HEADER_COLOR_SKIN_DARK = 'header_color_skin_dark';
		const HEADER_SPACING_VERTICAL = 'header_spacing_vertical';
		const HEADER_SPACING_HORIZONTAL = 'header_spacing_horizontal';
		const HEADER_BORDER_BOTTOM_COLOR = 'header_border_bottom_color';
		const HEADER_BORDER_BOTTOM_WIDTH = 'header_border_bottom_width';
		const HEADER_SHADOW_ENABLED = 'header_shadow_enabled';
		const HEADER_BEHAVIOUR = 'header_behaviour';

		const SITE_HEADER_NAVIGATION_VERTICAL_SPACING = 'site_header_navigation_vertical_spacing';
		const HEADER_LOGO_SIDE_MENU_POSITION = 'header_logo_side_menu_position';
		const SITE_HEADER_NAVIGATION_FONT_SIZE = 'site_header_navigation_font_size';
		const SITE_HEADER_NAVIGATION_FONT_WEIGHT = 'site_header_navigation_font_weight';
		const SITE_HEADER_NAVIGATION_LETTER_SPACING = 'site_header_navigation_letter_spacing';
		const HEADER_SUBMENU_BACKGROUND_COLOR = 'header_submenu_background_color';
		const HEADER_SUBMENU_COLOR_SKIN = 'header_submenu_color_skin';
		const SITE_HEADER_NAVIGATION_SUBMENU_FONT_SIZE = 'site_header_navigation_submenu_font_size';
		const SITE_HEADER_NAVIGATION_SUBMENU_FONT_WEIGHT = 'site_header_navigation_submenu_font_weight';
		const SITE_HEADER_NAVIGATION_SUBMENU_LETTER_SPACING = 'site_header_navigation_submenu_letter_spacing';
		const SITE_HEADER_NAVIGATION_SOCIAL_FONT_SIZE = 'site_header_navigation_social_font_size';

		const HEADER_SEARCH_AREA_ENABLED = 'header_search_area_enabled';
		const HEADER_SEARCH_AREA_BACKGROUND_COLOR = 'header_search_area_background_color';
		const HEADER_SEARCH_AREA_COLOR_SKIN = 'header_search_area_color_skin';
		const HEADER_SEARCH_AREA_TYPE = 'header_search_area_type';
		const HEADER_SEARCH_AREA_TEXT = 'header_search_area_text';

		const HEADER_SIDEBAR_ENABLED = 'header_sidebar_enabled';
		const HEADER_SIDEBAR_BACKGROUND = 'header_sidebar_background';
		const HEADER_SIDEBAR_COLOR_SKIN = 'header_sidebar_color_skin';
		const HEADER_SIDEBAR_WIDTH = 'header_sidebar_width';
		const HEADER_SIDEBAR_SPACING_VERTICAL = 'header_sidebar_spacing_vertical';
		const HEADER_SIDEBAR_SPACING_HORIZONTAL = 'header_sidebar_spacing_horizontal';
		const HEADER_SIDEBAR_TITLE = 'header_sidebar_title';
		const HEADER_SIDEBAR_MENU_ICON = 'header_sidebar_menu_icon';

		const HEADER_ABOVE_AREA_ENABLED = 'header_above_area_enabled';
		const HEADER_ABOVE_BACKGROUND = 'header_above_background';
		const HEADER_ABOVE_COLOR_SKIN = 'header_above_color_skin';
		const HEADER_ABOVE_SPACING_VERTICAL = 'header_above_spacing_vertical';
		const HEADER_ABOVE_SPACING_HORIZONTAL = 'header_above_spacing_horizontal';
		const HEADER_ABOVE_BORDER_BOTTOM_COLOR = 'header_above_border_bottom_color';
		const HEADER_ABOVE_BORDER_TOP_WIDTH = 'header_above_border_top_width';
		const HEADER_ABOVE_SITE_NOTICE = 'header_above_site_notice';
		const HEADER_ABOVE_SITE_NOTICE_FONT_SIZE = 'header_above_site_notice_font_size';
		const HEADER_ABOVE_SITE_NOTICE_FONT_WEIGHT = 'header_above_site_notice_font_weight';
		const HEADER_ABOVE_NAVIGATION_FONT_SIZE = 'header_above_navigation_font_size';
		const HEADER_ABOVE_NAVIGATION_FONT_WEIGHT = 'header_above_navigation_font_weight';
		const HEADER_ABOVE_NAVIGATION_LETTER_SPACING = 'header_above_navigation_letter_spacing';
		const HEADER_ABOVE_NAVIGATION_SOCIAL_FONT_SIZE = 'header_above_navigation_social_font_size';

		const HEADER_MOBILE_MENU_BACKGROUND_COLOR = 'header_mobile_menu_background_color';
		const HEADER_MOBILE_MENU_COLOR_SKIN = 'header_mobile_menu_color_skin';

		const CONTENT_SITE_HEADER_TRANSPARENCY = 'content_site_header_transparency';
		const CONTENT_BREADCRUMBS = 'content_breadcrumbs';
		const ARCHIVE_DISPLAY = 'archive_display';
		const ARCHIVE_SKIN_TRANSPARENCY = 'archive_skin_transparency';
		const ARCHIVE_COLUMNS_NUMBER = 'archive_columns_number';
		const ARCHIVE_COLUMNS_SPACING = 'archive_columns_spacing';
		const ARCHIVE_SIDEBAR_ENABLED = 'archive_sidebar_enabled';
		const RELATED_ITEMS_BACKGROUND_COLOR = 'related_items_background_color';
		const CATEGORIES_FILTER_FONT_SIZE = 'categories_filter_font_size';
		const CATEGORIES_FILTER_FONT_WEIGHT = 'categories_filter_font_weight';
		const CATEGORIES_FILTER_LETTER_SPACING = 'categories_filter_letter_spacing';
		const CATEGORIES_FILTER_TEXT_TRANSFORM = 'categories_filter_text_transform';

		const SINGLE_POST_COMPRESS_POST_CONTENT_LEFT = 'single_post_compress_post_content_left';
		const SINGLE_POST_COMPRESS_POST_CONTENT_RIGHT = 'single_post_compress_post_content_right';
		const SINGLE_POST_ELEMENTS_VISIBILITY = 'single_post_elements_visibility';
		const RELATED_POSTS_DISPLAY = 'related_posts_display';
		const RELATED_POSTS_SKIN_TRANSPARENCY = 'related_posts_skin_transparency';
		const RELATED_POSTS_COLUMNS_NUMBER = 'related_posts_columns_number';
		const RELATED_POSTS_COLUMNS_SPACING = 'related_posts_columns_spacing';
		const SINGLE_POST_ALL_POSTS_LINK = 'single_post_all_posts_link';
		const BLOG_POST_EXCERPT_WORDS_NB = 'blog_post_excerpt_words_nb';

		const SINGLE_PROJECT_COMPRESS_PROJECT_CONTENT_LEFT = 'single_project_compress_project_content_left';
		const SINGLE_PROJECT_COMPRESS_PROJECT_CONTENT_RIGHT = 'single_project_compress_project_content_right';
		const SINGLE_PROJECT_ELEMENTS_VISIBILITY = 'single_project_elements_visibility';
		const RELATED_PROJECTS_DISPLAY = 'related_projects_display';
		const RELATED_PROJECTS_SKIN_TRANSPARENCY = 'related_projects_skin_transparency';
		const RELATED_PROJECTS_COLUMNS_NUMBER = 'related_projects_columns_number';
		const RELATED_PROJECTS_COLUMNS_SPACING = 'related_projects_columns_spacing';
		const SINGLE_PROJECT_ALL_PROJECTS_LINK = 'single_project_all_projects_link';

		const PAGE_COMPRESS_PAGE_CONTENT_LEFT = 'page_compress_page_content_left';
		const PAGE_COMPRESS_PAGE_CONTENT_RIGHT = 'page_compress_page_content_right';
		const PAGE_ELEMENTS_VISIBILITY = 'page_elements_visibility';

		const CONTENT_SIDEBAR_ENABLED = 'content_sidebar_enabled';
		const CONTENT_SIDEBAR_COLOR_SKIN = 'content_sidebar_color_skin';
		const CONTENT_SIDEBAR_WIDTH = 'content_sidebar_width';
		const CONTENT_SIDEBAR_POSITION = 'content_sidebar_position';

		const ERROR_PAGE_COLOR_SKIN = 'error_page_color_skin';
		const ERROR_PAGE_TITLE = 'error_page_title';
		const ERROR_PAGE_SUBTITLE = 'error_page_subtitle';
		const ERROR_PAGE_TEXT = 'error_page_text';
		const ERROR_PAGE_BUTTON_LABEL = 'error_page_button_label';
		const ERROR_PAGE_BUTTON_LINK = 'error_page_button_link';

		const FOOTER_SIDEBAR_ENABLED = 'footer_sidebar_enabled';
		const FOOTER_SIDEBAR_BACKGROUND = 'footer_sidebar_background';
		const FOOTER_SIDEBAR_BACKGROUND_TRANSPARENCY = 'footer_sidebar_background_transparency';
		const FOOTER_SIDEBAR_COLOR_SKIN = 'footer_sidebar_color_skin';
		const FOOTER_SIDEBAR_SPACING_VERTICAL = 'footer_sidebar_spacing_vertical';
		const FOOTER_SIDEBAR_SPACING_HORIZONTAL = 'footer_sidebar_spacing_horizontal';
		const FOOTER_SIDEBAR_BORDER_TOP_COLOR = 'footer_sidebar_border_top_color';
		const FOOTER_SIDEBAR_BORDER_TOP_WIDTH = 'footer_sidebar_border_top_width';
		const FOOTER_SIDEBAR_BACKGROUND_IMAGE = 'footer_sidebar_background_image';
		const FOOTER_SIDEBAR_NB_COLUMNS = 'footer_sidebar_nb_columns';

		const FOOTER_BELOW_AREA_ENABLED = 'footer_below_area_enabled';
		const FOOTER_BELOW_BACKGROUND = 'footer_below_background';
		const FOOTER_BELOW_COLOR_SKIN = 'footer_below_color_skin';
		const FOOTER_BELOW_SPACING_VERTICAL = 'footer_below_spacing_vertical';
		const FOOTER_BELOW_SPACING_HORIZONTAL = 'footer_below_spacing_horizontal';
		const FOOTER_BELOW_BORDER_TOP_COLOR = 'footer_below_border_top_color';
		const FOOTER_BELOW_BORDER_TOP_WIDTH = 'footer_below_border_top_width';
		const FOOTER_BELOW_COPYRIGHT = 'footer_below_copyright';
		const FOOTER_BELOW_COPYRIGHT_FONT_SIZE = 'footer_below_copyright_font_size';
		const FOOTER_BELOW_COPYRIGHT_FONT_WEIGHT = 'footer_below_copyright_font_weight';
		const FOOTER_BELOW_NAVIGATION_FONT_SIZE = 'footer_below_navigation_font_size';
		const FOOTER_BELOW_NAVIGATION_FONT_WEIGHT = 'footer_below_navigation_font_weight';
		const FOOTER_BELOW_NAVIGATION_LETTER_SPACING = 'footer_below_navigation_letter_spacing';
		const FOOTER_BELOW_NAVIGATION_SOCIAL_FONT_SIZE = 'footer_below_navigation_social_font_size';

		const SHOP_DISPLAY = 'shop_display';
		const SHOP_SKIN_TRANSPARENCY = 'shop_skin_transparency';
		const SHOP_COLUMNS_SPACING = 'shop_columns_spacing';
		const SHOP_FILTER_NB_COLUMNS = 'shop_filter_nb_columns';
		const SHOP_CROSS_SELLS_PRODUCTS_AUTOPLAY = 'shop_cross_sells_products_autoplay';
		const SHOP_CROSS_SELLS_PRODUCTS_NB_COLUMNS = 'shop_cross_sells_products_nb_columns';
		const SHOP_UPSELLS_PRODUCTS_AUTOPLAY = 'shop_upsells_products_autoplay';
		const SHOP_UPSELLS_PRODUCTS_NB_COLUMNS = 'shop_upsells_products_nb_columns';
		const SHOP_RELATED_PRODUCTS_AUTOPLAY = 'shop_related_products_autoplay';
		const SHOP_RELATED_PRODUCTS_NB_COLUMNS = 'shop_related_products_nb_columns';
		const SHOP_CATALOG_MODE_ENABLED = 'shop_catalog_mode_enabled';

		const PRODUCT_COMPRESS_PRODUCT_CONTENT_LEFT = 'product_compress_product_content_left';
		const PRODUCT_COMPRESS_PRODUCT_CONTENT_RIGHT = 'product_compress_product_content_right';
		const SHOP_ELEMENTS_VISIBILITY = 'shop_elements_visibility';

		const SHOP_HEADER_ICONS_VISIBILITY = 'shop_header_icons_visibility';
		const SHOP_HEADER_WISHLIST_ICON_ITEMS_BACKGROUND_COLOR = 'shop_header_wishlist_icon_items_background_color';
		const SHOP_HEADER_WISHLIST_ICON_ITEMS_TEXT_COLOR = 'shop_header_cart_icon_items_text_color';

		/** @since 1.0.3 */
		const SHOP_HEADER_PRODUCTS_COMPARE_ICON_ITEMS_BACKGROUND_COLOR = 'shop_header_products_compare_icon_items_background_color';
		/** @since 1.0.3 */
		const SHOP_HEADER_PRODUCTS_COMPARE_ICON_ITEMS_TEXT_COLOR = 'shop_header_products_compare_icon_items_text_color';

		const SHOP_HEADER_MY_ACCOUNT_POPUP = 'shop_header_my_account_popup';
		const SHOP_HEADER_CART_ICON_ITEMS_BACKGROUND_COLOR = 'shop_header_cart_icon_items_background_color';
		const SHOP_HEADER_CART_ICON_ITEMS_TEXT_COLOR = 'shop_header_wishlist_icon_items_text_color';
		const SHOP_CART_ICON_LINK = 'shop_cart_icon_link';
		const ADD_TO_CART_POPUP = 'add_to_cart_popup';

		/** @since 1.0.3 */
		const HEADER_PRODUCTS_SEARCH_MODE = 'header_products_search_mode';

		const SHOP_RIBBONS_HOT_ENABLED = 'shop_ribbons_hot_enabled';
		const SHOP_RIBBONS_HOT_BACKGROUND_COLOR = 'shop_ribbons_hot_background_color';
		const SHOP_RIBBONS_HOT_COLOR = 'shop_ribbons_hot_color';
		const SHOP_RIBBONS_SALE_ENABLED = 'shop_ribbons_sale_enabled';
		const SHOP_RIBBONS_SALE_BACKGROUND_COLOR = 'shop_ribbons_sale_background_color';
		const SHOP_RIBBONS_SALE_COLOR = 'shop_ribbons_sale_color';
		const SHOP_RIBBONS_NEW_ENABLED = 'shop_ribbons_new_enabled';
		const SHOP_RIBBONS_NEW_LAST_DAYS = 'shop_ribbons_new_last_days';
		const SHOP_RIBBONS_NEW_BACKGROUND_COLOR = 'shop_ribbons_new_background_color';
		const SHOP_RIBBONS_NEW_COLOR = 'shop_ribbons_new_color';
		const SHOP_RIBBONS_OUT_OF_STOCK_ENABLED = 'shop_ribbons_out_of_stock_enabled';
		const SHOP_RIBBONS_OUT_OF_STOCK_BACKGROUND_COLOR = 'shop_ribbons_out_of_stock_background_color';
		const SHOP_RIBBONS_OUT_OF_STOCK_COLOR = 'shop_ribbons_out_of_stock_color';

		const META_DESCRIPTION = 'meta_description';

		const FEATURE_COLOR = 'feature_color';
		const HEADINGS_COLOR = 'headings_color';
		const BODY_TEXT_COLOR = 'body_text_color';
		const CONTENT_SELECTION_COLOR = 'content_selection_color';
		const BUTTONS_TEXT_COLOR = 'buttons_text_color';
		const BUTTONS_TEXT_HOVER_COLOR = 'buttons_text_hover_color';
		const BUTTONS_BACKGROUND_COLOR = 'buttons_background_color';
		const BUTTONS_BACKGROUND_HOVER_COLOR = 'buttons_background_hover_color';

		const FEATURED_BRANDING_ENABLED = 'featured_branding_enabled';
		const FEATURED_BRANDING_HEIGHT = 'featured_branding_height';
		const FEATURED_BRANDING_OVERLAY_COLOR = 'featured_branding_overlay_color';
		const FEATURED_BRANDING_OVERLAY_TRANSPARENCY = 'featured_branding_overlay_transparency';
		const FEATURED_BRANDING_PARALLAX = 'featured_branding_parallax';
	}
}