<?php

namespace Pikart\WpBase\Widget\Type;

use Pikart\WpBase\Common\PluginPathsUtil;
use Pikart\WpBase\Widget\WidgetFormHelper;
use Pikart\WpCore\Common\DataSanitizer;
use Pikart\WpCore\Post\Dal\ProjectRepository;

if ( ! class_exists( __NAMESPACE__ . '\\RecentProjectsWidget' ) ) {

	/**
	 * Class RecentProjectsWidget
	 * @package Pikart\WpBase\Widget\Type
	 *
	 * @since 1.1.0
	 */
	class RecentProjectsWidget extends GenericWidget {

		/**
		 * @var ProjectRepository
		 */
		protected $projectRepository;

		/**
		 * RecentProjectsWidget constructor.
		 *
		 * @param WidgetFormHelper $widgetFormHelper
		 * @param DataSanitizer $dataSanitizer
		 * @param ProjectRepository $projectRepository
		 */
		public function __construct(
			WidgetFormHelper $widgetFormHelper, DataSanitizer $dataSanitizer, ProjectRepository $projectRepository
		) {
			parent::__construct( $widgetFormHelper, $dataSanitizer );
			$this->projectRepository = $projectRepository;
		}

		/**
		 * @inheritdoc
		 */
		public function widget( $args, $data ) {
			$data['projects'] = $this->projectRepository->getItems(
				absint( $this->getOptionValue( 'number', $data ) ), 'date', 'desc' );

			if ( empty( $data['projects'] ) ) {
				return;
			}

			$this->beforeWidgetAndTitle( $args, $data );

			$this->includeWidgetTemplate( $data );

			$this->afterWidget( $args );
		}

		/**
		 * @inheritdoc
		 */
		protected function getOptionsConfig() {
			return array(
				'title'  => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Title:', 'pikart-base' ),
					'default' => esc_html__( 'Recent Projects', 'pikart-base' ),
					'class'   => 'widefat',
				),
				'number' => array(
					'type'       => 'number',
					'label'      => esc_html__( 'Number of projects to show:', 'pikart-base' ),
					'default'    => 5,
					'class'      => 'tiny-text',
					'attributes' => array(
						'step' => 1,
						'min'  => 1,
						'size' => 3
					)
				)
			);
		}

		/**
		 * @inheritdoc
		 */
		protected function getShortId() {
			return 'recent-projects';
		}

		/**
		 * @inheritdoc
		 */
		protected function getName() {
			return esc_html__( 'Pikart Recent Projects', 'pikart-base' );
		}

		/**
		 * @inheritdoc
		 */
		protected function getDescription() {
			return esc_html__( 'Your site&#8217;s most recent Projects.', 'pikart-base' );
		}
	}
}