# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).


## [1.7.1] - 2020-02-26
### Changed
* Update symfony dependencies

### Fixed
* Update pikart core - Fix theme options config builder


## [1.7.0] - 2019-11-02
### Added
* Posibility to disable pikart shortcodes and wide menu from Navigation Menus
* Custom social profiles


## [1.6.3] - 2019-10-21
### Fixed
* GenericPostTypeRepository in wp core - check for taxonomy/cpt existence before getting the terms

## [1.6.2] - 2019-09-15
### Changed
* Enable elementor by default for pikart projects
* Extract the widget html content in separate template files, so they could be overwritten in the themes

### Fixed
* 'Add social' button click issue in elementor


## [1.6.1] - 2019-03-08
### Added
* ThemesUtil class
* Widget attributes filter in Elementor pikart projects widget 
* Make Album post type configurable for activation/deactivation
* Items filtering based on request categoryId for the shortcodes: Album, Projects, Products

### Changed
* Register multiple-select css


## [1.6.0] - 2019-02-17
### Added
* Integrate following shortcodes on Elementor:
    - pikart projects


## [1.5.7] - 2019-01-03
### Added
* WpGalleryBlockCustomizer class


## [1.5.6] - 2018-12-21
### Changed
* Trigger refresh events for wishlist and compareList once the page is loaded


## [1.5.5] - 2018-11-15
### Changed
* Update symfony dependencies to v2.8.47


## [1.5.4] - 2018-10-29
### Fixed
* Update the minified version of pikart-base js file in order to have the latest js modifications


## [1.5.3] - 2018-10-16
### Added
* CompareListItemsNumber in compare list partials
* Pikart base options import/export functionality
* Custom widgets import/export functionality

### Changed
* Change default value for social services option
* Save custom sidebars during demo import


## [1.5.2] - 2018-10-02
### Added
* OptionsPagesUtil: updatePikartBasePageOption method

### Changed
* Change default value for social services option


## [1.5.1] - 2018-09-20
### Fixed
* Parse shortcodes when displaying product description in the compare product list
* Fix Addthis infinite loading issue


## [1.5.0] - 2018-09-12
### Added
* ShortcodeRenderer: printContent and styleItems methods
* Social share addthis: support dynamically loaded share buttons
* Use local copy file for loading addthis js library
* Minify plugin specific js files
* Combine plugin specific js files in one js file and use it for production environment

### Changed
* Migrate all url to https

### Fixed
* Do not display unexpected end tag span in the menu items


## [1.4.0] - 2018-05-23
### Added
* Alternative labels for Navigation Menu Items
* Init MetaBoxes config

### Changed
* Remove async attribute when loading twitter widget script


## [1.3.1] - 2018-05-23
### Fixed
* Tinymce bug: custom ui type creation for shortcodes


## [1.3.0] - 2018-04-27
### Added
* Custom post types registration compatible with visual composer frontend editor
* Flickr Widget
* Twitter Widget
* Instagram Widget
* Product Wishlist
* Product compare
* Alternative labels for Navigation Menu Items

### Changed
* Products Shortcode: add the following attributes: products_type, visibility, categories filtering usage, skus, pagination
* Products Shortcode: add the following sorting options: price, popularity, rating, relevance, menu_order, comment_count, random
* Projects/Album shortcodes: add the following sorting options: relevance, menu_order, comment_count, random
* Add spinner icon when liking an item


## [1.2.0] - 2018-03-20
### Added
* Post Likes Area: Apply postLikesNumberText filter for displaying number of likes

### Fixed
* WpImport: replace old term ids with new ones while importing content which contain product shortcode


## [1.1.0] - 2018-03-09
### Added
* Products shortcode
* Wide menu option for Navigation Menus
* Recent Projects Widget
* Social Links Widget
* Likes area for Page and Product

### Fixed
* Addthis initialization issue


## [1.0.0] - 2018-02-11
### Added initial release
*  WordPress 4.7+
*  Shortcodes
    - Accordion
    - Album
    - Button
    - Columns
    - Custom Content
    - Dropcap
    - Highlight
    - Icon
    - Map
    - Progress Bar
    - Projects
    - Quote
    - Row
    - Separator
    - Tabs
    - Team Member
*  Social Integration
    - Social Icon Area in Team Member shortcode
    - Social Share based on compatibility with AddThis Plugin
    - Likes Area
*  Sidebars
    - Unlimited Custom Sidebars
*  Translation Ready (.mo & .po files)
*  Developer friendly, modular and reusable code
*  Clean Code
*  HTML5 Valid
*  Technical requirements: PHP 5.3.9+