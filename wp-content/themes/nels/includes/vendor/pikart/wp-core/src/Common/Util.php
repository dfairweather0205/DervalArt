<?php

namespace Pikart\WpThemeCore\Common;

if ( ! class_exists( __NAMESPACE__ . '\\Util' ) ) {
	/**
	 * Class Util
	 * @package Pikart\WpThemeCore\Common
	 */
	class Util {

		/**
		 * @param string $url
		 * @param bool $withExtension
		 *
		 * @return string
		 */
		public function getUrlDomain( $url, $withExtension = true ) {
			$pieces = parse_url( $url );

			if ( ! isset( $pieces['host'] ) ) {
				return '';
			}

			$domain = $pieces['host'];

			if ( preg_match( '/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $matches ) ) {
				$domain = $matches['domain'];
			}

			if ( $withExtension ) {
				return $domain;
			}

			$domainParts = explode( '.', $domain );

			return $domainParts[0];
		}

		/**
		 * @param string $slug
		 * @param string $name
		 */
		public function partial( $slug, $name = null ) {
			get_template_part( 'templates/partials/' . $slug, $name );
		}

		/**
		 * @param string $slug
		 * @param string $name
		 */
		public function corePartial( $slug, $name = null ) {
			get_template_part(
				sprintf( 'includes/%s/resources/templates/partials/%s', CorePathsUtil::PIKART_CORE_VENDOR_PATH, $slug ),
				$name
			);
		}

		/**
		 * @param string $pluginBaseDir
		 * @param string $slug
		 * @param string $name
		 */
		public function pluginPartial( $pluginBaseDir, $slug, $name = null ) {
			$nameSuffix   = $name ? '-' . $name : '';
			$relativePath = sprintf( 'templates/partials/%s%s.php', $slug, $nameSuffix );
			$templatePath = locate_template( $relativePath );

			if ( $templatePath ) {
				load_template( $templatePath, false );

				return;
			}

			load_template( GenericPluginPathsUtil::getPluginResourcesDir( $pluginBaseDir, $relativePath ), false );
		}

		/**
		 * @param string $slug
		 * @param string $name
		 */
		public function pikartBasePartial( $slug, $name = null ) {
			if ( defined( 'PIKART_BASE_PATH' ) ) {
				$this->pluginPartial( PIKART_BASE_PATH, $slug, $name );
			}
		}

		/**
		 * @param string $slug
		 * @param string $name
		 *
		 * @return string
		 */
		public function getPartialContent( $slug, $name = null ) {
			$self = $this;

			return $this->captureOutput( function () use ( $self, $slug, $name ) {
				$self->partial( $slug, $name );
			} );
		}

		/**
		 * @param string $slug
		 * @param string $name
		 *
		 * @since 1.3.0
		 *
		 * @return string
		 */
		public function getPikartBasePartialContent( $slug, $name = null ) {
			$self = $this;

			return $this->captureOutput( function () use ( $self, $slug, $name ) {
				$self->pikartBasePartial( $slug, $name );
			} );
		}

		/**
		 * @param string $pluginBaseDir
		 * @param string $slug
		 * @param string $name
		 *
		 * @since 1.3.0
		 *
		 * @return string
		 */
		public function getPluginPartialContent( $pluginBaseDir, $slug, $name = null ) {
			$self = $this;

			return $this->captureOutput( function () use ( $pluginBaseDir, $self, $slug, $name ) {
				$self->pluginPartial( $pluginBaseDir, $slug, $name );
			} );
		}

		/**
		 * @param string $slug
		 * @param string $name
		 *
		 * @since 1.3.0
		 *
		 * @return string
		 */
		public function getCorePartialContent( $slug, $name = null ) {
			$self = $this;

			return $this->captureOutput( function () use ( $self, $slug, $name ) {
				$self->corePartial( $slug, $name );
			} );
		}

		/**
		 * @param \Closure $closure
		 *
		 * @return string
		 */
		public function captureOutput( $closure ) {
			ob_start();

			$closure();

			return ob_get_clean();
		}

		/**
		 * converts a fraction string to number
		 * Ex: 1/2 -> 0.5
		 *     1/3 -> 0.333333..
		 *
		 * @param string $fractionString
		 *
		 * @return float|int
		 */
		public function fractionToNumber( $fractionString ) {
			$parts = explode( '/', $fractionString );

			return isset( $parts[1] ) ? $parts[0] / $parts[1] : 0 + $fractionString;
		}

		/**
		 * @param string $url
		 *
		 * @return bool
		 */
		public static function isUrl( $url ) {
			return filter_var( $url, FILTER_VALIDATE_URL ) !== false;
		}

		/**
		 * @param int $transparency
		 *
		 * @return float
		 */
		public function transparencyToOpacity( $transparency ) {
			return 1 - min( abs( (int) $transparency ), 100 ) / 100;
		}

		/**
		 * @param float $opacity
		 *
		 * @return int
		 */
		public function opacityToTransparency( $opacity ) {
			return round( 100 * ( 1 - min( abs( (float) $opacity ), 1 ) ) );
		}

		/**
		 * @param $hexColor
		 *
		 * @return mixed
		 */
		public function hexToRgbColor( $hexColor ) {
			$hexColor = ltrim( $hexColor, '#' );

			if ( strlen( $hexColor ) === 3 ) {
				$hexColor = implode( '', array_map( 'str_repeat', str_split( $hexColor ), array( 2, 2, 2 ) ) );
			}

			$rgb = sscanf( $hexColor, '%02x%02x%02x' );

			return array(
				'r' => $rgb[0],
				'g' => $rgb[1],
				'b' => $rgb[2],
			);
		}

		/**
		 * @param mixed $value
		 * @param mixed $min
		 * @param mixed $max
		 *
		 * @return mixed
		 */
		public function getValidNumberInRange( $value, $min, $max ) {
			return min( $max, max( $min, $value ) );
		}

		/**
		 * @param string $hook
		 * @param string $oldFunction
		 * @param string|callable $newFunction
		 * @param int $oldPriority
		 * @param int $newPriority
		 * @param int $acceptedArgs
		 */
		public function replaceHookFunction(
			$hook, $oldFunction, $newFunction, $oldPriority = 10, $newPriority = 10, $acceptedArgs = 1
		) {
			remove_action( $hook, $oldFunction, $oldPriority );
			add_action( $hook, $newFunction, $newPriority, $acceptedArgs );
		}

		/**
		 * @param string $oldHook
		 * @param string $newHook
		 * @param callback $functionToChange
		 * @param int $oldPriority
		 * @param int $newPriority
		 * @param int $acceptedArgs
		 */
		public function replaceFunctionHook(
			$oldHook, $newHook, $functionToChange, $oldPriority = 10, $newPriority = 10, $acceptedArgs = 1
		) {
			remove_action( $oldHook, $functionToChange, $oldPriority );
			add_action( $newHook, $functionToChange, $newPriority, $acceptedArgs );
		}

		/**
		 * @param string $hook
		 * @param callback $functionToChange
		 * @param int $oldPriority
		 * @param int $newPriority
		 * @param int $acceptedArgs
		 */
		public function changeHookFunctionPriority(
			$hook, $functionToChange, $oldPriority = 10, $newPriority = 10, $acceptedArgs = 1
		) {
			$this->replaceFunctionHook(
				$hook, $hook, $functionToChange, $oldPriority, $newPriority, $acceptedArgs );
		}

		/**
		 * @return bool
		 */
		public function isNewPostPage() {
			return $GLOBALS['pagenow'] === 'post-new.php';
		}

		/**
		 * @return string
		 */
		public function getClientIp() {
			$clientIp = filter_input( INPUT_SERVER, 'HTTP_CLIENT_IP', FILTER_VALIDATE_IP );

			if ( $clientIp ) {
				return $clientIp;
			}

			$clientIp = filter_input( INPUT_SERVER, 'HTTP_X_FORWARDED_FOR' );

			if ( $clientIp ) {
				$ipList = explode( ',', $clientIp );

				if ( filter_var( $ipList[0], FILTER_VALIDATE_IP ) ) {
					return $ipList[0];
				}
			}

			return filter_input( INPUT_SERVER, 'REMOTE_ADDR' );
		}

		/**
		 * @param string $slug
		 * @param string $version
		 *
		 * @return string
		 */
		public function generateArtifactDownloadToken( $slug, $version ) {
			$salt = PIKART_CORE_SLUG . $slug . $version;

			return hash_hmac( 'md5', intval( time() / 100 ), $salt );
		}

		/**
		 * @param string $slug
		 * @param string $version
		 *
		 * @return string
		 */
		public function generateArtifactDownloadUrl( $slug, $version ) {
			return sprintf( PIKARTHOUSE_URL . 'api/download-item?slug=%s&version=%s&token=%s',
				$slug, $version, $this->generateArtifactDownloadToken( $slug, $version ) );
		}

		/**
		 * @param string $search
		 * @param string $replace
		 * @param string $subject
		 *
		 * @since 1.4.0
		 *
		 * @return string
		 */
		public function strReplaceLast( $search, $replace, $subject ) {
			$pos = strrpos( $subject, $search );

			if ( $pos !== false ) {
				$subject = substr_replace( $subject, $replace, $pos, strlen( $search ) );
			}

			return $subject;
		}

		/**
		 * @since 1.8.0
		 *
		 * @return string
		 */
		public static function getThemeStyleHandle() {
			$rtlHandle = CoreAssetHandle::themeRtlStyle();

			return is_rtl() && wp_style_is( $rtlHandle, 'registered' )
				? $rtlHandle : CoreAssetHandle::themeStyle();
		}
	}
}
