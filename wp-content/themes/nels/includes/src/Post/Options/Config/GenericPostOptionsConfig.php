<?php

namespace Pikart\Nels\Post\Options\Config;

use Pikart\Nels\Post\Options\PostOptionsMetaBoxId;
use Pikart\Nels\Post\Options\Type\CommonPostOptions;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Admin\Sidebars\SidebarUtil;
use Pikart\WpThemeCore\Post\Options\Config\PostTypeOptionsConfig;
use Pikart\WpThemeCore\Post\PostActionName;
use Pikart\WpThemeCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\GenericPostOptionsConfig' ) ) {

	/**
	 * Class GenericPostOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config
	 */
	abstract class GenericPostOptionsConfig implements PostTypeOptionsConfig {

		/**
		 * @var SidebarUtil
		 */
		private $sidebarUtil;

		/**
		 * @var MetaBoxConfigBuilder
		 */
		protected $metaBoxConfigBuilder;

		/**
		 * Project constructor.
		 *
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 * @param SidebarUtil $sidebarUtil
		 */
		public function __construct( MetaBoxConfigBuilder $metaBoxConfigBuilder, SidebarUtil $sidebarUtil ) {
			$this->metaBoxConfigBuilder = $metaBoxConfigBuilder;
			$this->sidebarUtil          = $sidebarUtil;
		}

		/**
		 * @return array configuration for custom fields
		 */
		public function getMetaBoxesConfig() {
			$this->buildCommonConfig();

			do_action(
				PostActionName::postTypeMetaBoxesConfig( $this->getSlug(), PostOptionsMetaBoxId::COMMON_OPTIONS ),
				$this->metaBoxConfigBuilder
			);

			$this->buildPostTypeSpecificConfig( $this->metaBoxConfigBuilder );

			do_action( PostActionName::postTypeMetaBoxesConfig( $this->getSlug() ), $this->metaBoxConfigBuilder );

			return $this->metaBoxConfigBuilder->build();
		}

		/**
		 * @inheritdoc
		 */
		public function getAdminJsAssetHandles() {
			return array();
		}

		/**
		 * @inheritdoc
		 */
		public function getAdminCssAssetHandles() {
			return array();
		}

		protected function buildCommonConfig() {
			$this->metaBoxConfigBuilder
				->metaBox( PostOptionsMetaBoxId::COMMON_OPTIONS, esc_html__( 'General Options', 'nels' ) )
				->number( CommonPostOptions::SITE_WIDTH, esc_html__( 'Site width', 'nels' ),
					esc_html__( 'It overwrites Site Width, set up in Theme Options (pixels)', 'nels' ), array(
						'default'    => 1050,
						'attributes' => array(
							'min' => 0,
						)
					) )
				->checkbox( CommonPostOptions::FULL_WIDTH, esc_html__( 'Full width', 'nels' ),
					esc_html__(
						'If enabled, it overwrites Site Width and the content gets browser window width',
						'nels' ),
					array(
						'default' => 0
					) )
				->checkbox( CommonPostOptions::SITE_HEADER_TRANSPARENCY,
					esc_html__( 'Site Header transparency', 'nels' ),
					esc_html__(
						'If enabled, the Site Header is transparent and the content is displayed from the very top of browser window',
						'nels' ),
					array(
						'default' => 0
					) )
				->checkbox( CommonPostOptions::SITE_HEADER_ABOVE_AREA, esc_html__( 'Site Header Above Area', 'nels' ),
					esc_html__( 'It includes Site Notice, Above Area menu and Above Area Social menu', 'nels' ),
					array(
						'default' => 1
					) )
				->checkbox( CommonPostOptions::FEATURED_BRANDING, esc_html__( 'Header Image / Featured Branding', 'nels' ),
					esc_html__(
						'Enable it, if you already set up Featured Image and want the Branding to be above content. If Featured Image is not set up, it takes Header Image from Theme Options',
						'nels' ),
					array(
						'default' => 0
					) )
				->checkbox( CommonPostOptions::BRANDING_ENABLED, esc_html__( 'Display Branding', 'nels' ),
					esc_html__( 'Branding includes Title, Metadata and Breadcrumbs (if Breadcrumbs are enabled)',
						'nels'
					),
					array(
						'default' => 1
					) )
				->checkbox( CommonPostOptions::BREADCRUMBS, esc_html__( 'Breadcrumbs', 'nels' ),
					esc_html__( 'Breadcrumbs act as secondary site navigation',
						'nels'
					),
					array(
						'default' => 1
					) )
				->wpEditor( CommonPostOptions::TITLE_AREA, esc_html__( 'Title Area', 'nels' ),
					esc_html__( 'Enter the title here, if you want it formatted. It will overwrite the default title',
						'nels'
					),
					array(
						'editor_settings' => $this->getTinyWpEditorSettings()
					) )
				->checkbox( CommonPostOptions::SITE_CONTENT_SIDEBAR, esc_html__( 'Inner Content Sidebar', 'nels' ),
					esc_html__( 'Display widgets sidebar inside Site Content', 'nels' ),
					array(
						'default' => 0
					) );

			$this->displayCustomSidebarsList();

			$this->metaBoxConfigBuilder
				->wpColorPicker( CommonPostOptions::SITE_CONTENT_BACKGROUND,
					esc_html__( 'Site Content Background', 'nels' ),
					esc_html__( 'It overwrites Site Content background color, set up in Theme Options', 'nels' ),
					array(
						'editor_settings' => $this->getTinyWpEditorSettings()
					) )
				->checkbox( CommonPostOptions::SITE_FOOTER_SIDEBAR, esc_html__( 'Site Footer Sidebar', 'nels' ),
					esc_html__( 'Display widgets sidebar inside Site Footer. It can comprise one or more columns of widgets', 'nels' ),
					array(
						'default' => 1
					) )
				->checkbox( CommonPostOptions::SITE_FOOTER_BELOW_AREA, esc_html__( 'Site Footer Below Area', 'nels' ),
					esc_html__( 'It includes Copyright text, Footer menu and Footer Social menu', 'nels' ),
					array(
						'default' => 1
					) )
				->textArea( CommonPostOptions::META_DESCRIPTION, esc_html__( 'Meta description', 'nels' ),
					esc_html__( 'Enter meta description', 'nels' ) );
		}

		/**
		 * @return array
		 */
		protected function getTinyWpEditorSettings() {
			return array(
				'teeny'         => true,
				'media_buttons' => false,
				'textarea_rows' => 3,
				'tinymce'       => array( 'toolbar1' => 'bold,italic' ),
				'quicktags'     => array( 'buttons' => 'em,strong' ),
			);
		}

		/**
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 *
		 * @return $this
		 */
		protected function buildMasonryArchiveConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$isAdminProduct = filter_input( INPUT_GET, 'post_type', FILTER_SANITIZE_STRING ) === PostTypeSlug::PRODUCT;

			$metaBoxConfigBuilder
				->metaBox(
					PostOptionsMetaBoxId::MASONRY_ARCHIVE_OPTIONS, esc_html__( 'Masonry Archive Options', 'nels' ) )
				->checkbox( CommonPostOptions::MASONRY_LARGE_SIZE, esc_html__( 'Large size', 'nels' ),
					esc_html__( 'When possible, the item width is twice than masonry column width', 'nels' ),
					array(
						'default' => 0
					)
				)
				->select( CommonPostOptions::MASONRY_SPACING, esc_html__( 'Spacing Around', 'nels' ),
					esc_html__( 'Add extra spacing around item on masonry layout', 'nels' ), array(
						'default' => 'none',
						'options' => array(
							'none'   => esc_html__( 'None', 'nels' ),
							'small'  => esc_html__( 'Small', 'nels' ),
							'medium' => esc_html__( 'Medium', 'nels' ),
							'large'  => esc_html__( 'Large', 'nels' ),
						)
					)
				)
				->number( CommonPostOptions::MASONRY_TITLE_FONT_SIZE, esc_html__( 'Title font-size', 'nels' ),
					esc_html__( 'Enter font-size of the title on masonry layout (pixels)', 'nels' ), array(
						'default'    => $isAdminProduct ? 14 : 18,
						'attributes' => array(
							'min' => 1,
							'max' => 72,
						)
					) );

			return $this;
		}

		/**
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 */
		abstract protected function buildPostTypeSpecificConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder );

		private function displayCustomSidebarsList() {
			$sidebars = array(
				'none' => esc_html__( 'None', 'nels' ),
			);

			$customSidebars = $this->sidebarUtil->getCustomSidebars();

			if ( ! $customSidebars ) {
				return;
			}

			$sidebars = array_merge( $sidebars, $customSidebars );

			$this->metaBoxConfigBuilder
				->select( CommonPostOptions::CUSTOM_SIDEBAR, esc_html__( 'Custom sidebar', 'nels' ),
					esc_html__( 'Choose a custom sidebar', 'nels' ), array(
						'default' => 'none',
						'options' => $sidebars
					)
				);
		}
	}
}