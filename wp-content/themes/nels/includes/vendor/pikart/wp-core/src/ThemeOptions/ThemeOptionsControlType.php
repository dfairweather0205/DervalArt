<?php

namespace Pikart\WpThemeCore\ThemeOptions;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeOptionsControlType' ) ) {

	final class ThemeOptionsControlType {
		const FONT_FAMILY = 'fontFamily';
		const SELECT = 'select';
		const NUMBER = 'number';
		const RADIO = 'radio';
		const CHECKBOX = 'checkbox';
		const CHECKBOX_MULTIPLE = 'checkboxMultiple';
		const COLOR = 'color';
		const NO_INPUT = 'noInput';
		const TEXT = 'text';
		const BUTTON = 'button';
		const IMAGE = 'image';
		const TEXT_AREA = 'textarea';
		const URL = 'url';
		const RANGE = 'range';

		/**
		 * @since 1.5.0
		 */
		const CROPPED_IMAGE="croppedImage";
	}
}