<?php

namespace Pikart\WpBase\Shortcode;

use Pikart\WpBase\Common\PluginPathsUtil;
use Pikart\WpCore\Common\Util;
use Pikart\WpCore\Shortcode\ShortcodeConfig;
use Pikart\WpCore\Shortcode\Type\Shortcode;
use Pikart\WpCore\ThemeOptions\ThemeOptionsCssFilter;

if ( ! class_exists( __NAMESPACE__ . '\\ShortcodeRenderer' ) ) {

	/**
	 * Class ShortcodeRenderer
	 * @package Pikart\WpBase\Shortcode
	 */
	class ShortcodeRenderer {

		const DEFAULT_TEMPLATE_PATTERN = '%s/shortcodes/pikart/%s.php';
		const CUSTOM_TEMPLATE_PATTERN = 'templates/shortcodes/pikart/%s.php';
		const SELF_CLOSING_SHORTCODE_PATTERN = '[%s %s /]';
		const ENCLOSED_SHORTCODE_PATTERN = '[%s %s]%s[/%s]';
		const ATTRIBUTE_PATTERN = '%s="%s"';

		/**
		 * @var array
		 */
		private static $dto = array();

		/**
		 * @var int
		 */
		private static $index = 0;

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * @var ThemeOptionsCssFilter
		 */
		private $themeOptionsCssFilter;

		/**
		 * ShortcodeRenderer constructor.
		 *
		 * @param Util $util
		 * @param ThemeOptionsCssFilter $themeOptionsCssFilter
		 */
		public function __construct( Util $util, ThemeOptionsCssFilter $themeOptionsCssFilter ) {
			$this->util                  = $util;
			$this->themeOptionsCssFilter = $themeOptionsCssFilter;
		}


		/**
		 * @param Shortcode $shortcode
		 * @param array $userAttributes
		 * @param string $content
		 *
		 * @return string
		 */
		public function renderTemplate( Shortcode $shortcode, $userAttributes = array(), $content = '' ) {
			$data          = $this->getAttributes( $shortcode, $userAttributes );
			$data['index'] = ++ self::$index;

			$template = locate_template( $this->buildCustomTemplate( $shortcode->getName() ), false );

			if ( ! $template ) {
				$template = $this->buildDefaultTemplate( $shortcode->getName() );
			}

			$content = $this->filterContent( $content );

			if ( ! file_exists( $template ) ) {
				$this->addShortcodeData( $shortcode->getName(), $data, $content );

				return '';
			}

			$shortcode->enqueueAssets();
			$shortcode->processTemplateData( $data );

			ob_start();

			include $template;

			return ob_get_clean();
		}

		/**
		 * @param Shortcode $shortcode
		 * @param array $userAttributes
		 * @param string $content
		 *
		 * @return string
		 */
		public function render( Shortcode $shortcode, $userAttributes = array(), $content = '' ) {
			$shortcodeName = $shortcode->getName();

			$attributes = $this->getAttributes( $shortcode, $userAttributes );

			$attributePattern = static::ATTRIBUTE_PATTERN;

			$attrText = implode( ' ', array_map( function ( $value, $attribute ) use ( $attributePattern ) {
				return sprintf( $attributePattern, $attribute, $value );
			}, $attributes, array_keys( $attributes ) ) );

			$shortcodeText = $shortcode->isSelfClosing()
				? sprintf( self::SELF_CLOSING_SHORTCODE_PATTERN, $shortcodeName, $attrText )
				: sprintf( self::ENCLOSED_SHORTCODE_PATTERN, $shortcodeName, $attrText, $content, $shortcodeName );

			return do_shortcode( $shortcodeText );
		}

		/**
		 * @param $content
		 *
		 * @return string
		 */
		private function filterContent( $content ) {
			$patterns = array(
				'/^<\/p>/i',
				'/<p>$/i',
			);

			$content = preg_replace( $patterns, '', trim( $content ) );

			return do_shortcode( trim( shortcode_unautop( $content ) ) );
		}

		/**
		 * @return int
		 */
		private function getIndex() {
			return self::$index;
		}

		/**
		 * @param Shortcode $shortcode
		 * @param array $userAttributes
		 *
		 * @return array
		 */
		private function getAttributes( Shortcode $shortcode, $userAttributes = array() ) {
			$attributes = array();

			foreach ( $shortcode->getAttributesConfig() as $attribute => $config ) {
				$attributes[ $attribute ] = isset( $config['default'] ) ? $config['default'] : '';
			}

			return shortcode_atts(
				$attributes,
				$userAttributes,
				$shortcode->getName()
			);
		}

		/**
		 * @param string $shortcodeName
		 *
		 * @return string
		 */
		private function buildCustomTemplate( $shortcodeName ) {
			return sprintf( static::CUSTOM_TEMPLATE_PATTERN, $this->buildTemplateFile( $shortcodeName ) );
		}

		/**
		 * @param string $shortcodeName
		 *
		 * @return string
		 */
		private function buildDefaultTemplate( $shortcodeName ) {
			return sprintf(
				static::DEFAULT_TEMPLATE_PATTERN,
				PluginPathsUtil::getTemplatesDir(),
				$this->buildTemplateFile( $shortcodeName )
			);
		}

		/**
		 * @param string $shortcodeName
		 *
		 * @return string
		 */
		private function buildTemplateFile( $shortcodeName ) {
			return str_replace( array( ShortcodeConfig::NAME_PREFIX, '_' ), array( '', '-' ), $shortcodeName );
		}

		/**
		 * @param string $partialName
		 * @param array $data
		 * @param string $defaultPartial
		 */
		private function partial( $partialName, $data = array(), $defaultPartial = '' ) {
			$partial = locate_template( sprintf( static::CUSTOM_TEMPLATE_PATTERN, $partialName ), false );

			if ( ! $partial ) {
				$partial = sprintf(
					static::DEFAULT_TEMPLATE_PATTERN,
					PluginPathsUtil::getTemplatesDir(),
					$partialName
				);
			}

			if ( file_exists( $partial ) ) {
				include $partial;
			} elseif ( ! empty( $defaultPartial ) ) {
				$this->partial( $defaultPartial, $data );
			}
		}

		/**
		 * @param array $styleItems
		 *
		 * @return string
		 */
		private function style( array $styleItems ) {
			$styleItemsString = $this->styleItems( $styleItems );

			if ( empty( $styleItemsString ) ) {
				return '';
			}

			return sprintf( 'style="%s"', esc_attr( $this->styleItems( $styleItems ) ) );
		}

		/**
		 * @param string $property
		 * @param string $value
		 * @param string $default
		 * @param bool $emptyCheck
		 *
		 * @return string
		 */
		private function styleItem( $property, $value, $default = '', $emptyCheck = true ) {
			$value = $emptyCheck && empty( $value ) ? $default : $value;

			return $emptyCheck && empty( $value ) ? '' : sprintf( '%s: %s;', $property, $value );
		}

		/**
		 * @param array $styleItems
		 *
		 * @since 1.5.0
		 *
		 * @return string
		 */
		private function styleItems( array $styleItems ) {
			$styleItems = array_filter( $styleItems, function ( $item ) {
				return ! empty( $item );
			} );

			if ( empty( $styleItems ) ) {
				return '';
			}

			return trim( implode( ' ', $styleItems ) );
		}

		/**
		 * @param string $property
		 * @param string $value
		 * @param string $default
		 * @param bool $emptyCheck
		 *
		 * @return string
		 */
		private function attribute( $property, $value, $default = '', $emptyCheck = true ) {
			$value = $emptyCheck && empty( $value ) ? $default : $value;

			return $emptyCheck && empty( $value )
				? '' : sprintf( '%s="%s"', esc_attr( $property ), esc_attr( $value ) );
		}

		/**
		 * @param array $attributes
		 *
		 * @return string
		 */
		private function attributes( array $attributes ) {
			return trim( implode( ' ', $attributes ) );
		}

		/**
		 * @param        $pattern
		 * @param        $value
		 * @param string $default
		 *
		 * @return string
		 */
		private function format( $pattern, $value, $default = '' ) {
			return empty( $value ) ? $default : sprintf( $pattern, $value );
		}

		/**
		 * @param mixed $value
		 * @param mixed $default
		 *
		 * @return mixed
		 */
		private function defaultVal( $value, $default = '' ) {
			return empty( $value ) ? $default : $value;
		}

		/**
		 * @param string $text
		 * @param string $value
		 * @param string $default
		 *
		 * @return string
		 */
		private function textIfValTrue( $text, $value, $default = '' ) {
			return $this->getBoolean( $value ) ? $text : $default;
		}

		/**
		 * @param mixed $value
		 *
		 * @return bool
		 */
		private function getBoolean( $value ) {
			return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
		}

		/**
		 * @param string $text
		 * @param string $value
		 * @param string $default
		 *
		 * @return string
		 */
		private function textIfValNotEmpty( $text, $value, $default = '' ) {
			return empty( $value ) ? $default : $text;
		}

		/**
		 * @param string $shortcodeName
		 * @param array $attributes
		 * @param string $content
		 */
		private function addShortcodeData( $shortcodeName, array $attributes, $content = '' ) {
			if ( ! isset( static::$dto[ $shortcodeName ] ) ) {
				static::$dto[ $shortcodeName ] = array();
			}

			static::$dto[ $shortcodeName ][] = array( 'attributes' => $attributes, 'content' => $content );
		}

		/**
		 * @param string $shortcodeName
		 *
		 * @return array
		 */
		private function getShortcodeData( $shortcodeName ) {
			$shortcodeName = ShortcodeConfig::NAME_PREFIX . $shortcodeName;
			$data          = isset( static::$dto[ $shortcodeName ] ) ? static::$dto[ $shortcodeName ] : array();

			static::$dto[ $shortcodeName ] = array();

			return $data;
		}

		/**
		 * @param string $fontFamily
		 *
		 * @return string
		 */
		private function extractFontFamilyName( $fontFamily ) {
			return $this->themeOptionsCssFilter->fontFamily( $fontFamily );
		}

		/**
		 * @param $content
		 *
		 * @since 1.5.0
		 */
		private function printContent( $content ) {
			if ( $content ) {
				print ( $content );
			}
		}
	}
}