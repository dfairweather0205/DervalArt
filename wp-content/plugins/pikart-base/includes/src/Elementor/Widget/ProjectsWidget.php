<?php

namespace Pikart\WpBase\Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Pikart\WpBase\DependencyInjection\Service;
use Pikart\WpCore\Elementor\ElementorFilterName;
use Pikart\WpCore\Post\Dal\GenericPostTypeRepository;

if ( ! class_exists( __NAMESPACE__ . '\\ProjectsWidget' ) ) {

	/**
	 * Class Projects
	 * @package Pikart\WpBase\Elementor\Widget
	 *
	 * @since 1.6.0
	 */
	class ProjectsWidget extends Widget_Base {

		const SHORT_NAME = 'projects';

		/**
		 * @inheritdoc
		 */
		public function get_name() {
			return PIKART_SLUG . '-' . self::SHORT_NAME;
		}

		/**
		 * @inheritdoc
		 */
		public function get_title() {
			return esc_html__( 'Pikart Projects', 'pikart-base' );
		}

		/**
		 * @inheritdoc
		 */
		public function get_icon() {
			return 'fa fa-folder-open';
		}

		/**
		 * @inheritdoc
		 */
		public function get_categories() {
			return array( 'general' );
		}

		/**
		 * @inheritdoc
		 */
		public function get_keywords() {
			return array( 'project', 'projects' );
		}

		/**
		 * @inheritdoc
		 */
		public function is_reload_preview_required() {
			return true;
		}

		/**
		 * @inheritdoc
		 */
		public function render_plain_content() {
			echo $this->getShortcodeString();
		}

		/**
		 * @inheritdoc
		 */
		protected function _register_controls() {
			do_action( ElementorFilterName::widgetsControlsRegisterConfigBefore( self::SHORT_NAME ), $this );

			$this->start_controls_section(
				$this->get_name() . '-section',
				array(
					'label' => esc_html__( 'Pikart projects', 'pikart-base' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				)
			);

			do_action( ElementorFilterName::widgetsControlsRegisterConfigAfterSectionStart( self::SHORT_NAME, self::SHORT_NAME ), $this );

			$this->add_control(
				'categories',
				array(
					'label'       => esc_html__( 'Projects categories', 'pikart-base' ),
					'description' => esc_html__( 'Filter projects by categories. Leave empty to select all projects', 'pikart-base' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'options'     => $this->getCategories()
				)
			);

			$this->add_control(
				'tags',
				array(
					'label'       => esc_html__( 'Projects tags', 'pikart-base' ),
					'description' => esc_html__( 'Filter projects by tags. Leave empty to select all projects', 'pikart-base' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'options'     => $this->getTags()
				)
			);

			$this->add_control(
				'items',
				array(
					'label'       => esc_html__( 'Projects', 'pikart-base' ),
					'description' => esc_html__( 'Choose projects you want to display (comma separated Projects IDs)', 'pikart-base' ),
					'type'        => Controls_Manager::TEXTAREA,
					'rows'        => 2,
				)
			);

			$this->add_control(
				'categories_display',
				array(
					'label'       => esc_html__( 'Categories filter', 'pikart-base' ),
					'description' => esc_html__( 'Decide if you want to display categories filter or not', 'pikart-base' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'main',
					'options'     => $this->getCategoriesDisplayOptions()
				)
			);

			$this->add_control(
				'order_by',
				array(
					'label'       => esc_html__( 'Order by', 'pikart-base' ),
					'description' => esc_html__( 'Select the field by which to order the projects', 'pikart-base' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'date',
					'options'     => $this->getOrderByOptions()
				)
			);

			$this->add_control(
				'order',
				array(
					'label'       => esc_html__( 'Order', 'pikart-base' ),
					'description' => esc_html__( 'Select the display order', 'pikart-base' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'desc',
					'options'     => $this->getOrderOptions()
				)
			);

			$this->add_control(
				'nb_items',
				array(
					'label'       => esc_html__( 'Number of projects', 'pikart-base' ),
					'description' => esc_html__( 'Select number of projects', 'pikart-base' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 20,
					'min'         => 1,
					'max'         => GenericPostTypeRepository::MAX_NB_ITEMS_QUERY_LIMIT,
				)
			);

			do_action( ElementorFilterName::widgetsControlsRegisterConfigBeforeSectionEnd( self::SHORT_NAME, self::SHORT_NAME ), $this );

			$this->end_controls_section();

			do_action( ElementorFilterName::widgetsControlsRegisterConfigAfter( self::SHORT_NAME ), $this );
		}

		/**
		 * @inheritdoc
		 */
		protected function render() {
			echo do_shortcode( $this->getShortcodeString() );
		}

		/**
		 * @return string
		 */
		private function getShortcodeString() {
			$settings = $this->get_settings_for_display();

			foreach ( $this->getAttributes() as $id ) {
				if ( ! isset( $settings[ $id ] ) ) {
					continue;
				}

				$control = $this->get_controls( $id );
				$value   = $settings[ $id ];
				$value   = is_array( $value ) ? implode( ',', $value ) : $value;

				if ( $control['type'] === Controls_Manager::SWITCHER ) {
					// compatibility with tinyMce checkbox
					$value = $value === 'yes' ? 'true' : 'false';
				} elseif ( is_string( $value ) && $value === '' ) {
					continue;
				}

				$this->add_render_attribute( $this->get_name(), $id, $value );
			}

			return sprintf( '[%s %s /]',
				$this->getShortcodeName(), $this->get_render_attribute_string( $this->get_name() ) );
		}

		/**
		 * @return string
		 */
		private function getShortcodeName() {
			return 'pkrt_projects';
		}

		/**
		 * @return array
		 */
		private function getAttributes() {
			return apply_filters( ElementorFilterName::widgetAttributes( self::SHORT_NAME ), array(
				'categories',
				'tags',
				'items',
				'categories_display',
				'order_by',
				'order',
				'nb_items',
			) );
		}

		/**
		 * @return array
		 */
		private function getOrderOptions() {
			return array(
				'asc'  => esc_html__( 'Ascending', 'pikart-base' ),
				'desc' => esc_html__( 'Descending', 'pikart-base' ),
			);
		}

		/**
		 * @return array
		 */
		private function getOrderByOptions() {
			return array(
				'relevance'     => esc_html__( 'Relevance', 'pikart-base' ),
				'date'          => esc_html__( 'Date', 'pikart-base' ),
				'title'         => esc_html__( 'Title', 'pikart-base' ),
				'author'        => esc_html__( 'Author', 'pikart-base' ),
				'ID'            => esc_html__( 'Id', 'pikart-base' ),
				'modified'      => esc_html__( 'Last modified date', 'pikart-base' ),
				'menu_order'    => esc_html__( 'Menu order', 'pikart-base' ),
				'parent'        => esc_html__( 'Parent id', 'pikart-base' ),
				'comment_count' => esc_html__( 'Number of comments', 'pikart-base' ),
				'rand'          => esc_html__( 'Random', 'pikart-base' ),
			);
		}

		/**
		 * @return array
		 */
		private function getCategoriesDisplayOptions() {
			return array(
				'none' => esc_html__( 'None', 'pikart-base' ),
				'all'  => esc_html__( 'All categories', 'pikart-base' ),
				'main' => esc_html__( 'Main categories', 'pikart-base' ),
			);
		}

		/**
		 * @return array
		 */
		private function getTags() {
			return Service::projectRepository()->getTags( 'slug' );
		}

		/**
		 * @return array
		 */
		private function getCategories() {
			return Service::projectRepository()->getCategories( '', array(), 'slug' );
		}
	}
}