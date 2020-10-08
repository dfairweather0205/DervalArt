<?php

namespace Pikart\WpThemeCore\Post\Type\Format;

if ( ! class_exists( __NAMESPACE__ . '\\PostFormatSlug' ) ) {

	/**
	 * Class PostFormatSlug
	 * @package Pikart\WpThemeCore\Post\Type\Format
	 */
	class PostFormatSlug {
		const ASIDE = 'aside';
		const AUDIO = 'audio';
		const GALLERY = 'gallery';
		const IMAGE = 'image';
		const LINK = 'link';
		const QUOTE = 'quote';
		const STANDARD = 'standard';
		const VIDEO = 'video';
	}
}