<?php

namespace Pikart\Nels\Post\Options\Type;

if ( ! class_exists( __NAMESPACE__ . '\\ProjectOptions' ) ) {

	/**
	 * Class ProjectOptions
	 * @package Pikart\Nels\Post\Options
	 */
	class ProjectOptions extends CommonPostOptions {

		// common options
		const TYPE = 'project_type';
		const PROJECT_HEADER_FULL_WIDTH = 'project_header_full_width';
		const IMAGES = 'project_images';
		const HERO_HEADER = 'project_hero_header';
		////////////////////////////////////////////////////////////////////

		// project details options
		const PROJECT_DETAILS_POSITION = 'project_details_position';
		const PROJECT_DETAILS_STICKY = 'project_details_sticky';
		const PROJECT_DATE = 'project_date';
		const PROJECT_DESCRIPTION = 'project_description';
		////////////////////////////////////////////////////////////////////

		// masonry specific options
		const NB_COLUMNS = 'project_masonry_nb_columns';
		const COLUMNS_SPACING = 'project_masonry_columns_spacing';
		////////////////////////////////////////////////////////////////////

		// carousel specific options
		const CAROUSEL_NB_SLIDES = 'project_carousel_nb_slides';
		const CAROUSEL_SLIDES_SPACING = 'project_carousel_slides_spacing';
		////////////////////////////////////////////////////////////////////


		/**
		 * @return array
		 */
		public function getImages() {
			return $this->getArrayOption( self::IMAGES );
		}

		/**
		 * @return string
		 */
		public function getType() {
			return $this->getOption( self::TYPE );
		}

		/**
		 * @return bool
		 */
		public function getProjectHeaderFullWidth() {
			return $this->getBoolOption( self::PROJECT_HEADER_FULL_WIDTH );
		}

		/**
		 * @return string
		 */
		public function getProjectDetailsPosition() {
			return $this->getOption( self::PROJECT_DETAILS_POSITION );
		}

		/**
		 * @return bool
		 */
		public function getProjectDetailsSticky() {
			return $this->getBoolOption( self::PROJECT_DETAILS_STICKY );
		}

		/**
		 * @return int
		 */
		public function getNbColumns() {
			return $this->getIntOption( self::NB_COLUMNS );
		}

		/**
		 * @return int
		 */
		public function getColumnsSpacing() {
			return $this->getIntOption( self::COLUMNS_SPACING );
		}

		/**
		 * @return string
		 */
		public function getProjectDate() {
			return $this->formatDate( $this->getOption( self::PROJECT_DATE ) );
		}

		/**
		 * @return string
		 */
		public function getProjectDescription() {
			return $this->getOption( self::PROJECT_DESCRIPTION );
		}

		/**
		 * @return string
		 */
		public function getHeroHeader() {
			return $this->getOption( self::HERO_HEADER );
		}

		/**
		 * @return int
		 */
		public function getCarouselNbSlides() {
			return $this->getIntOption( self::CAROUSEL_NB_SLIDES );
		}

		/**
		 * @return int
		 */
		public function getCarouselSlidesSpacing() {
			return $this->getIntOption( self::CAROUSEL_SLIDES_SPACING );
		}
	}
}