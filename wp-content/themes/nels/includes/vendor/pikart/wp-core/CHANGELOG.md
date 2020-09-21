# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/)
and this project adheres to [Semantic Versioning](https://semver.org/).


# [1.8.4] - 2020-02-26
### Fixed
- Fix theme options config builder


# [1.8.3] - 2019-11-02
### Added
- ShortcodeFilterName::shortcodesEnabled

# [1.8.2] - 2019-10-21
### Fixed
- GenericPostTypeRepository - check for taxonomy/cpt existence before getting the terms  


# [1.8.1] - 2019-09-01
### Added
- AttachmentsUtil - allow additional attributes for image/audio/video media types  


# [1.8.0] - 2019-03-19
### Added
- ElementorFilterName::widgetAttributes method
- GenericPostOptions::multiValueOptionHasValue method
- MediaFilter::customGalleryVideoUrlEnabled method
- MediaFilter::wpBaseGalleryCustomizerEnabled method
- OptionsPagesFilterName::sectionEnabled and OptionsPagesFilterName::settingEnabled methods
- Custom css for Metabox options


# [1.7.0] - 2018-11-29
### Added
- MetaBoxes tabs
- NoInput field for metaboxes

# [1.6.5] - 2019-02-17
### Added
- ElementorUtil class
- ElementorFilterName class

### Fixed
- ShopUtil::isProductNew - make it work with Elementor 

# [1.6.4] - 2018-12-13
### Added
- WidgetFilterName class: widgetList

###Changed
- Update symfony packages to v2.8.49

# [1.6.3] - 2018-11-15
### Added
- Slick Carousel asset handle


## [1.6.2] - 2018-10-23
### Added
 - OptionsPagesCoreUtil: updateOptions method
 - MigrationConfig: PIKART_BASE_OPTIONS_IMPORT_FILE constant


## [1.6.1] - 2018-10-02
### Added
 - OptionsPagesCoreUtil: updateOption method


## [1.6.0] - 2018-09-19
### Added
- New theme customizer option: copy parent theme options to child theme customizer options
- Cache post options when loading meta data multiple times for the same item

###Changed
- Do not assign any version when loading external assets
- Do not append version query parameter when loading google fonts


## [1.5.0] - 2018-09-08
### Added
- ThemeOptions: cropped image control type, cropped inverted logo, additional_config_attributes to controls
- ControlConfigBuilder in ThemeOptions: builtInControl method
- ThemeOptionsCssFilter: color filter
- Few more third party handles in CoreAssetHandle
- ThemePathsUtil: getJsVendorUrl and getCssVendorUrl methods
- WpOption class: define main wp built-in options for customizer
- GoogleFontsHelper: add few new fonts
- CoreAssetHandle: add simpleLineIcons handle
- ThemeOptionsCoreUtil: add default argument for the following methods: getOption, getBoolOption, getIntOption
- CoreAssetsRegister: enqueueAllScriptsInFooter and enqueueAllScriptsInFooterAllowed

### Changed
- DataSanitizer: allow iframe while sanitizing wpEditor data
- ThemeOptionsCoreUtil: treat wpOptions same as custom controls and check the built-in option where required 
- ControlConfigBuilder in ThemeOptions: enable builtIn option for controls, use color css filter for color control types
- ThemeOptions: filter values before getting the option
- Env: check for PIKART_THEME_ACTIVE constant when detecting a pikart theme is active
- GoogleFontsHelper: check is google fonts is enqueued before enqueueing again

## [1.4.0] - 2018-06-12
### Added
- MetaBoxConfig
- Util: strReplaceLast method

### Changed
- add `$excludeKeys` parameter in getCustomFields method from PostUtil
- Do not enqueue the custom minified assets when SCRIPT_DEBUG enabled, but rather the original files
- add getPluginsDir method to ThemePathsUtil
- WpDefaultSection: BACKGROUND_IMAGE->WP_HEADER_IMAGE, BACKGROUND_IMAGE->WP_BACKGROUND_IMAGE
- MetaBoxFacade, MetaBoxGenerator: use MetaBoxConfig
- Validate IP before using it

# Removed
- NavigationMenus: CustomWalkerNavMenu, NavigationMenusOption, NavigationMenusUtil; moved to pikart base
- CoreAssetsRegister: addScriptsAttributes, addScriptAttribute, addScriptAttributes, addScriptsAttribute


## [1.3.0] - 2018-04-27
### Added
- filterContent method and contentFilterName filter for templates
- twitterWidgets asset handle
- wishlistAllowed filter
- getMyAccountPageId method in ShopUtil
- joinTermNames method in TemplatesCoreUtil
- MetaBoxContext, MetaBoxPriority, context parameter when creating a MetaBox
- post_tag/product_tag in PostTypeSlug
- getItemTagSlug in PostRepository
- isProductNew/getProductSaleReductionInPercentage methods in ShopUtil
- getPikartBasePartialContent/getPluginPartialContent/getCorePartialContent in Util

### Changed
- getCategories method in PostRepository has 2 more parameters: $categoryIndexField and $categoryFiled
- getTags method in PostRepository has 2 more parameters: tagIndexField and tagField
- use `fields` from parameters in getItemsForCustomPostType method from GenericPostTypeRepository


## [1.2.0] - 2018-03-12
### Added
- PostLikes: Add filter postLikesNumberText


## [1.1.0] - 2018-03-09
### Added
- Navigation Menus: filters, options, Util, CustomWalkerNavMenu
- DAL: ProductRepository
- ShopUtil
- Email sanitization in DataSanitizer 

### Fixed
* Google fonts loading issue for multiple words font names


## [1.0.0] - 2018-02-10
### Added
- Initial release of the project