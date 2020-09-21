<?php

namespace Pikart\WpCore\OptionsPages;

if ( ! class_exists( __NAMESPACE__ . '\\OptionsPagesControlType' ) ) {

	/**
	 * Class OptionsPagesControlType
	 * @package Pikart\WpCore\OptionsPages
	 */
	final class OptionsPagesControlType {
		const TEXT = 'text';
		const GALLERY_IMAGE = 'galleryImage';
		const CHECKBOX = 'checkbox';
		const MULTI_CHECKBOX = 'multiCheckbox';
		const SELECT = 'select';
		const MULTI_SELECT = 'multiSelect';
	}
}