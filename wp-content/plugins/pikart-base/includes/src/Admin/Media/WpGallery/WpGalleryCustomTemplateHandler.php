<?php

namespace Pikart\WpBase\Admin\Media\WpGallery;

if ( ! class_exists( __NAMESPACE__ . '\WpGalleryCustomTemplateHandler' ) ) {

	/**
	 * Class WpGalleryCustomTemplateHandler
	 * @package Pikart\WpCore\Admin\Media\WpGallery
	 */
	class WpGalleryCustomTemplateHandler {

		const CUSTOM_TEMPLATE_NAME = 'pikart-custom-gallery-setting';
		const TEMPLATE_PATTERN = '<script type="text/html" id="tmpl-%s">%s</script>';
		const LABEL_PATTERN = '<label class="setting %s">%s</label>';

		public function handle() {
			$this->generateCustomTemplate();
			$this->renderCustomTemplateInJs();
		}

		private function generateCustomTemplate() {
			$columnsSpacingInput = $this->getColumnsSpacingInput();

			add_action( 'print_media_templates', function () use ( $columnsSpacingInput ) {
				$columnsSpacingText = sprintf( '<span>%s</span>', esc_html__( 'Columns spacing', 'pikart-base' ) );

				$templateContent = sprintf( WpGalleryCustomTemplateHandler::LABEL_PATTERN,
					'columns-spacing',
					$columnsSpacingText . $columnsSpacingInput
				);

				printf( WpGalleryCustomTemplateHandler::TEMPLATE_PATTERN,
					WpGalleryCustomTemplateHandler::CUSTOM_TEMPLATE_NAME,
					$templateContent
				);
			} );
		}

		/**
		 * @return string
		 */
		private function getColumnsSpacingInput() {
			$columnsSpacingConfig = WpGalleryConfig::getColumnsSpacingConfig();
			$inputPattern         = '<input type="number" value="%s" data-setting="%s" min="%s" max="%d" />';

			$inputWithExistingValue = sprintf(
				$inputPattern,
				'{{ data.model.columns_spacing }}',
				esc_attr( WpGalleryConfig::COLUMNS_SPACING_SETTING ),
				esc_attr( $columnsSpacingConfig['minimum'] ),
				esc_attr( $columnsSpacingConfig['maximum'] )
			);

			$inputWithDefaultValue = sprintf(
				$inputPattern,
				esc_attr( $columnsSpacingConfig['default'] ),
				esc_attr( WpGalleryConfig::COLUMNS_SPACING_SETTING ),
				esc_attr( $columnsSpacingConfig['minimum'] ),
				esc_attr( $columnsSpacingConfig['maximum'] )
			);

			return sprintf(
				'<# if ( _.isEmpty( data.model.columns_spacing ) ) { #> %s <# } else {#> %s <#} #>',
				$inputWithDefaultValue,
				$inputWithExistingValue
			);
		}

		private function renderCustomTemplateInJs() {
			$galleryDefaults = $this->getGalleryDefaults();

			add_action( 'print_media_templates', function () use ( $galleryDefaults ) {
				$templateName = WpGalleryCustomTemplateHandler::CUSTOM_TEMPLATE_NAME;
				?>
				<script>
                    jQuery(document).ready(function () {
                        _.extend(wp.media.gallery.defaults,
							{ <?php echo esc_js( implode( ', ', $galleryDefaults ) ) ?> });

                        wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
                            template: function (view) {
                                return wp.media.template('gallery-settings')(view)
                                    + wp.media.template('<?php echo esc_js( $templateName ) ?>')(view);
                            }
                        });
                    });

				</script>
				<?php
			} );
		}

		/**
		 * @return array
		 */
		private function getGalleryDefaults() {
			$customSettings  = WpGalleryConfig::getCustomSettings();
			$galleryDefaults = array();

			foreach ( $customSettings as $settingId => $setting ) {
				if ( isset( $setting['default'] ) ) {
					$galleryDefaults[] = sprintf( '%s: %s', $settingId, $setting['default'] );
				}
			}

			return $galleryDefaults;
		}
	}
}