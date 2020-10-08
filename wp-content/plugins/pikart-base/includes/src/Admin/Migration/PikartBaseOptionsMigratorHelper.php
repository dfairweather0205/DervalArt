<?php

namespace Pikart\WpBase\Admin\Migration;

use OCDI\Helpers;
use Pikart\WpBase\OptionsPages\OptionsPage;
use Pikart\WpBase\OptionsPages\PageOption;
use Pikart\WpCore\Admin\Migration\MigrationConfig;
use Pikart\WpCore\Admin\Sidebars\CustomSidebarConfig;
use Pikart\WpCore\Admin\Sidebars\SidebarUtil;
use Pikart\WpCore\OptionsPages\OptionsPagesCoreUtil;

if ( ! class_exists( __NAMESPACE__ . '\\PikartBaseOptionsMigratorHelper' ) ) {

	/**
	 * Class PikartBaseOptionsMigratorHelper
	 * @package Pikart\WpBase\Admin\Migration
	 *
	 * @since 1.5.3
	 */
	class PikartBaseOptionsMigratorHelper {

		const DOWNLOAD_PB_OPTIONS_ACTION = 'download_pikart_base_options';
		const DOWNLOADED_FILE_NAME = 'pikart-base-options.dat';

		/**
		 * @var OptionsPagesCoreUtil
		 */
		private $optionsPagesCoreUtil;

		/**
		 * @var SidebarUtil
		 */
		private $sidebarUtil;

		/**
		 * PluginOptionsUtil constructor.
		 *
		 * @param OptionsPagesCoreUtil $optionsPagesUtil
		 * @param SidebarUtil $sidebarUtil
		 */
		public function __construct( OptionsPagesCoreUtil $optionsPagesUtil, SidebarUtil $sidebarUtil ) {
			$this->optionsPagesCoreUtil = $optionsPagesUtil;
			$this->sidebarUtil          = $sidebarUtil;
		}

		/**
		 * @param array $selectedImportFiles
		 * @param array $importFiles
		 * @param int $selectedIndex
		 */
		public function importOptions( $selectedImportFiles, $importFiles, $selectedIndex ) {
			$importFileKey = MigrationConfig::PIKART_BASE_OPTIONS_IMPORT_FILE;

			if ( empty( $importFiles[ $selectedIndex ][ $importFileKey ] ) ) {
				return;
			}

			$importFile = $importFiles[ $selectedIndex ][ $importFileKey ];

			if ( ! file_exists( $importFile ) ) {
				return;
			}

			$options = unserialize( Helpers::data_from_file( $importFile ) );

			if ( ! $options ) {
				return;
			}

			if ( ! empty( $options['export_data']['custom_sidebars'] ) ) {
				update_option(
					CustomSidebarConfig::getSidebarsOptionKey(), $options['export_data']['custom_sidebars'] );
			}

			if ( isset( $options['export_data']['posts'] ) && is_array( $options['export_data']['posts'] ) ) {

				foreach ( $options['export_data']['posts'] as $pageOption => $postData ) {
					$post                   = get_page_by_path( $postData['slug'], OBJECT, $postData['post_type'] );
					$options[ $pageOption ] = $post ? $post->ID : '';
				}
			}

			if ( isset( $options['export_data'] ) ) {
				unset( $options['export_data'] );
			}

			$this->optionsPagesCoreUtil->updateOptions( OptionsPage::PIKART_BASE, $options );
		}

		public function downloadExportFile() {
			if ( ! filter_input( INPUT_GET, self::DOWNLOAD_PB_OPTIONS_ACTION ) ) {
				return;
			}

			$options = $this->optionsPagesCoreUtil->getOptions( OptionsPage::PIKART_BASE );

			$options['export_data']                    = array();
			$options['export_data']['posts']           = $this->generatePostList( $options );
			$options['export_data']['custom_sidebars'] = $this->sidebarUtil->getCustomSidebars();

			header( 'Content-Description: File Transfer' );
			header( 'Content-disposition: attachment; filename=' . self::DOWNLOADED_FILE_NAME );
			header( 'Content-Type: application/octet-stream; charset=' . get_option( 'blog_charset' ) );

			echo serialize( $options );
			die;
		}

		public function generateDownloadExportFileArea() {
			$screen = get_current_screen();

			if ( ! $screen || $screen->id !== 'export' || ! current_user_can( 'export' ) ) {
				return;
			}

			printf( '<form method="get"><input type="hidden" name="download" value="true" />%s:<br /> %s</form>',
				esc_html__( 'Pikart Base Options', 'pikart-base' ),
				get_submit_button( esc_html__( 'Download Export File', 'pikart-base' ),
					'primary', self::DOWNLOAD_PB_OPTIONS_ACTION, false )
			);
		}

		/**
		 * @param array $options
		 *
		 * @return array
		 */
		private function generatePostList( $options ) {
			$posts              = array();
			$pageOptionsToCheck = array( PageOption::GOOGLE_MAPS_PIN_IMAGE, PageOption::WISHLIST_PAGE );

			foreach ( $pageOptionsToCheck as $pageOption ) {
				if ( empty( $options[ $pageOption ] ) ) {
					continue;
				}

				$post = get_post( $options[ $pageOption ] );

				if ( $post ) {
					$posts[ $pageOption ] = array(
						'id'        => $post->ID,
						'slug'      => $post->post_name,
						'post_type' => $post->post_type
					);
				}

			}

			return $posts;
		}
	}
}