<?php

namespace Pikart\WpCore\ThemeOptions;

if ( ! class_exists( __NAMESPACE__ . '\\WpOption' ) ) {

	/**
	 * Class WpOption
	 * @package Pikart\WpCore\ThemeOptions
	 *
	 * @since 1.5.0
	 */
	final class WpOption {
		const BLOG_NAME = 'blogname';
		const BLOG_DESCRIPTION = 'blogdescription';

		const HEADER_TEXT = 'header_text';
		const HEADER_TEXT_COLOR = 'header_textcolor';
		const WP_HEADER_IMAGE = 'header_image';
		const HEADER_IMAGE_DATA = 'header_image_data';
		const HEADER_VIDEO = 'header_video';
		const EXTERNAL_HEADER_VIDEO = 'external_header_video';

		const WP_BACKGROUND_IMAGE = 'background_image';
		const WP_BACKGROUND_COLOR = 'background_color';
		const BACKGROUND_IMAGE_THUMB = 'background_image_thumb';
		const BACKGROUND_PRESET = 'background_preset';
		const BACKGROUND_POSITION_X = 'background_position_x';
		const BACKGROUND_POSITION_Y = 'background_position_y';
		const BACKGROUND_SIZE='background_size';
		const BACKGROUND_REPEAT='background_repeat';
		const BACKGROUND_ATTACHMENT='background_attachment';

		const CUSTOM_LOGO = 'custom_logo';
		const SITE_ICON = 'site_icon';
	}
}