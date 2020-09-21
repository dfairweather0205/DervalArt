<?php

namespace Pikart\WpBase\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InactiveScopeException;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 */
class ProjectServiceContainer extends Container
{
    private $parameters;
    private $targetDirs = array();

    public function __construct()
    {
        $this->services =
        $this->scopedServices =
        $this->scopeStacks = array();
        $this->scopes = array();
        $this->scopeChildren = array();
        $this->methodMap = array(
            'attachmentsutil' => 'getAttachmentsutilService',
            'autowired.pikart\\wpbase\\navigationmenus\\navigationmenusutil' => 'getAutowired_Pikart_Wpbase_Navigationmenus_NavigationmenusutilService',
            'autowired.pikart\\wpcore\\admin\\common\\forminputfieldgenerator' => 'getAutowired_Pikart_Wpcore_Admin_Common_ForminputfieldgeneratorService',
            'autowired.pikart\\wpcore\\admin\\media\\attachmentsmetafacade' => 'getAutowired_Pikart_Wpcore_Admin_Media_AttachmentsmetafacadeService',
            'autowired.pikart\\wpcore\\optionspages\\optionspagescoreutil' => 'getAutowired_Pikart_Wpcore_Optionspages_OptionspagescoreutilService',
            'autowired.pikart\\wpcore\\themeoptions\\googlefontshelper' => 'getAutowired_Pikart_Wpcore_Themeoptions_GooglefontshelperService',
            'autowired.pikart\\wpcore\\themeoptions\\themeoptionscssfilter' => 'getAutowired_Pikart_Wpcore_Themeoptions_ThemeoptionscssfilterService',
            'bootstrap' => 'getBootstrapService',
            'coreassetsregister' => 'getCoreassetsregisterService',
            'customgalleryimage' => 'getCustomgalleryimageService',
            'customwalkernavmenu' => 'getCustomwalkernavmenuService',
            'datasanitizer' => 'getDatasanitizerService',
            'metaboxconfigbuilder' => 'getMetaboxconfigbuilderService',
            'metaboxfacade' => 'getMetaboxfacadeService',
            'optionspagesutil' => 'getOptionspagesutilService',
            'postlikesfacade' => 'getPostlikesfacadeService',
            'postrepository' => 'getPostrepositoryService',
            'postutil' => 'getPostutilService',
            'productscomparehelper' => 'getProductscomparehelperService',
            'productscomparetemplateutil' => 'getProductscomparetemplateutilService',
            'projectrepository' => 'getProjectrepositoryService',
            'sidebarutil' => 'getSidebarutilService',
            'themeoptionsconfigbuilder' => 'getThemeoptionsconfigbuilderService',
            'themeoptionscoreutil' => 'getThemeoptionscoreutilService',
            'themeoptionsfacade' => 'getThemeoptionsfacadeService',
            'themeutil' => 'getThemeutilService',
            'util' => 'getUtilService',
            'wishlisthelper' => 'getWishlisthelperService',
        );

        $this->aliases = array();
    }

    /**
     * {@inheritdoc}
     */
    public function compile()
    {
        throw new LogicException('You cannot compile a dumped frozen container.');
    }

    /**
     * {@inheritdoc}
     */
    public function isFrozen()
    {
        return true;
    }

    /**
     * Gets the public 'attachmentsutil' shared autowired service.
     *
     * @return \Pikart\WpCore\Admin\Media\AttachmentsUtil
     */
    protected function getAttachmentsutilService()
    {
        return $this->services['attachmentsutil'] = new \Pikart\WpCore\Admin\Media\AttachmentsUtil();
    }

    /**
     * Gets the public 'bootstrap' shared autowired service.
     *
     * @return \Pikart\WpBase\Setup\Bootstrap
     */
    protected function getBootstrapService()
    {
        $a = $this->get('autowired.pikart\\wpcore\\themeoptions\\googlefontshelper');
        $b = $this->get('util');
        $c = $this->get('postutil');
        $d = $this->get('projectrepository');
        $e = $this->get('wishlisthelper');
        $f = $this->get('optionspagesutil');
        $g = $this->get('datasanitizer');
        $h = $this->get('autowired.pikart\\wpcore\\optionspages\\optionspagescoreutil');
        $i = $this->get('sidebarutil');
        $j = $this->get('productscomparehelper');

        $k = new \Pikart\WpBase\Admin\Media\WpGallery\WpGalleryShortcodeContentFilter($b);

        $l = new \Pikart\WpCore\OptionsPages\ConfigBuilder\ControlConfigBuilder();

        $m = new \Pikart\WpCore\OptionsPages\ConfigBuilder\SectionConfigBuilder($l);

        $n = new \Pikart\WpBase\Widget\WidgetFormHelper();

        return $this->services['bootstrap'] = new \Pikart\WpBase\Setup\Bootstrap(new \Pikart\WpBase\Shortcode\ShortcodesInitializer(new \Pikart\WpBase\Shortcode\ShortcodeRegister(new \Pikart\WpBase\Shortcode\ShortcodeRenderer($b, $this->get('autowired.pikart\\wpcore\\themeoptions\\themeoptionscssfilter'))), new \Pikart\WpBase\Shortcode\ShortcodesProvider(new \Pikart\WpBase\Shortcode\Type\ButtonShortcode(), new \Pikart\WpBase\Shortcode\Type\ColumnsShortcode(new \Pikart\WpBase\Shortcode\Type\ColumnShortcode()), new \Pikart\WpBase\Shortcode\Type\HeadingShortcode(), new \Pikart\WpBase\Shortcode\Type\IconShortcode(), new \Pikart\WpBase\Shortcode\Type\ProgressBarShortcode(), new \Pikart\WpBase\Shortcode\Type\QuoteShortcode(), new \Pikart\WpBase\Shortcode\Type\SeparatorShortcode(), new \Pikart\WpBase\Shortcode\Type\SliderShortcode(new \Pikart\WpBase\Shortcode\Type\SlideShortcode()), new \Pikart\WpBase\Shortcode\Type\TeamMemberShortcode(), new \Pikart\WpBase\Shortcode\Type\DropcapShortcode(), new \Pikart\WpBase\Shortcode\Type\HighlightShortcode(), new \Pikart\WpBase\Shortcode\Type\CustomContentShortcode($a, $c), new \Pikart\WpBase\Shortcode\Type\TabsShortcode(new \Pikart\WpBase\Shortcode\Type\TabShortcode()), new \Pikart\WpBase\Shortcode\Type\AccordionShortcode(new \Pikart\WpBase\Shortcode\Type\AccordionItemShortcode()), new \Pikart\WpBase\Shortcode\Type\TestimonialsShortcode(new \Pikart\WpBase\Shortcode\Type\TestimonialShortcode()), new \Pikart\WpBase\Shortcode\Type\MapShortcode(new \Pikart\WpBase\Shortcode\Type\GeolocationShortcode()), new \Pikart\WpBase\Shortcode\Type\ProjectsShortcode($d, $c), new \Pikart\WpBase\Shortcode\Type\RowShortcode($b), new \Pikart\WpBase\Shortcode\Type\AlbumShortcode(new \Pikart\WpCore\Post\Dal\AlbumRepository(), $c), new \Pikart\WpBase\Shortcode\Type\ProductsShortcode(new \Pikart\WpCore\Post\Dal\ProductRepository(), $c), new \Pikart\WpBase\Shortcode\Type\WishlistShortcode($e, $f)), $f), new \Pikart\WpBase\Setup\PluginSetup($b), new \Pikart\WpBase\Common\AssetsRegister($f), new \Pikart\WpBase\Post\PostTypeFacade(new \Pikart\WpBase\Post\PostTypeRegister(), new \Pikart\WpBase\Post\Type\Project(), new \Pikart\WpBase\Post\Type\Post(), new \Pikart\WpBase\Post\Type\Page(), new \Pikart\WpBase\Post\Type\Album(), new \Pikart\WpBase\Post\Type\Product()), new \Pikart\WpBase\Admin\Migration\MigrationSetup(new \Pikart\WpBase\Admin\Migration\WpImporterExtension($g), new \Pikart\WpBase\Admin\Migration\PikartBaseOptionsMigrator(new \Pikart\WpBase\Admin\Migration\PikartBaseOptionsMigratorHelper($h, $i))), $this->get('postlikesfacade'), new \Pikart\WpBase\Admin\Sidebars\CustomSidebarFacade($b, $i), new \Pikart\WpBase\Admin\Media\WpGallery\WpGalleryCustomizer(new \Pikart\WpBase\Admin\Media\WpGallery\WpGalleryCustomTemplateHandler(), $k, new \Pikart\WpBase\Admin\Media\WpGallery\WpGalleryBlockCustomizer($k)), $a, new \Pikart\WpBase\OptionsPages\OptionsPagesGenerator(new \Pikart\WpBase\OptionsPages\OptionsPagesConfigProvider(new \Pikart\WpCore\OptionsPages\ConfigBuilder\OptionsPagesConfigBuilder($m, $l, new \Pikart\WpCore\OptionsPages\ConfigBuilder\PageConfigBuilder($m)), $e, $j), new \Pikart\WpCore\OptionsPages\OptionsPagesFacade(new \Pikart\WpCore\OptionsPages\OptionsPageSettingsRegister($g, $this->get('autowired.pikart\\wpcore\\admin\\common\\forminputfieldgenerator'), $h), $h), new \Pikart\WpBase\OptionsPages\OptionsMenuPageRegister($b)), new \Pikart\WpBase\NavigationMenus\NavigationMenusFacade(new \Pikart\WpBase\NavigationMenus\NavigationMenusHelper($g, $this->get('autowired.pikart\\wpbase\\navigationmenus\\navigationmenusutil'))), new \Pikart\WpBase\Widget\WidgetsRegister(new \Pikart\WpBase\Widget\WidgetsProvider(new \Pikart\WpBase\Widget\Type\RecentProjectsWidget($n, $g, $d), new \Pikart\WpBase\Widget\Type\SocialLinksWidget($n, $g, $b), new \Pikart\WpBase\Widget\Type\FlickrWidget($n, $g), new \Pikart\WpBase\Widget\Type\TwitterWidget($n, $g), new \Pikart\WpBase\Widget\Type\InstagramWidget($n, $g))), new \Pikart\WpBase\Shop\Wishlist\WishlistFacade($e), new \Pikart\WpBase\Shop\ProductsCompare\ProductsCompareFacade($j), new \Pikart\WpBase\Elementor\ElementorInitializer(new \Pikart\WpBase\Elementor\WidgetsRegister(new \Pikart\WpBase\Elementor\WidgetsProvider())));
    }

    /**
     * Gets the public 'coreassetsregister' shared autowired service.
     *
     * @return \Pikart\WpCore\Common\CoreAssetsRegister
     */
    protected function getCoreassetsregisterService()
    {
        return $this->services['coreassetsregister'] = new \Pikart\WpCore\Common\CoreAssetsRegister();
    }

    /**
     * Gets the public 'customgalleryimage' shared autowired service.
     *
     * @return \Pikart\WpCore\Admin\Media\CustomGalleryImage
     */
    protected function getCustomgalleryimageService()
    {
        return $this->services['customgalleryimage'] = new \Pikart\WpCore\Admin\Media\CustomGalleryImage($this->get('autowired.pikart\\wpcore\\admin\\media\\attachmentsmetafacade'));
    }

    /**
     * Gets the public 'customwalkernavmenu' shared autowired service.
     *
     * @return \Pikart\WpBase\NavigationMenus\CustomWalkerNavMenu
     */
    protected function getCustomwalkernavmenuService()
    {
        return $this->services['customwalkernavmenu'] = new \Pikart\WpBase\NavigationMenus\CustomWalkerNavMenu($this->get('autowired.pikart\\wpbase\\navigationmenus\\navigationmenusutil'));
    }

    /**
     * Gets the public 'datasanitizer' shared autowired service.
     *
     * @return \Pikart\WpCore\Common\DataSanitizer
     */
    protected function getDatasanitizerService()
    {
        return $this->services['datasanitizer'] = new \Pikart\WpCore\Common\DataSanitizer();
    }

    /**
     * Gets the public 'metaboxconfigbuilder' shared autowired service.
     *
     * @return \Pikart\WpCore\Admin\MetaBoxes\MetaBoxConfigBuilder
     */
    protected function getMetaboxconfigbuilderService()
    {
        return $this->services['metaboxconfigbuilder'] = new \Pikart\WpCore\Admin\MetaBoxes\MetaBoxConfigBuilder();
    }

    /**
     * Gets the public 'metaboxfacade' shared autowired service.
     *
     * @return \Pikart\WpCore\Admin\MetaBoxes\MetaBoxFacade
     */
    protected function getMetaboxfacadeService()
    {
        $a = $this->get('util');
        $b = $this->get('datasanitizer');

        $c = new \Pikart\WpCore\Admin\MetaBoxes\MetaBoxDal($b, $a);

        return $this->services['metaboxfacade'] = new \Pikart\WpCore\Admin\MetaBoxes\MetaBoxFacade($a, $c, new \Pikart\WpCore\Admin\MetaBoxes\Generator\MetaBoxGenerator(new \Pikart\WpCore\Admin\MetaBoxes\Generator\MetaBoxGeneratorHelper(new \Pikart\WpCore\Admin\MetaBoxes\Generator\LineGenerator($this->get('autowired.pikart\\wpcore\\admin\\common\\forminputfieldgenerator')), $c)), new \Pikart\WpCore\Admin\MetaBoxes\MetaBoxCustomizedCssGenerator($this->get('postutil'), $this->get('autowired.pikart\\wpcore\\themeoptions\\themeoptionscssfilter')));
    }

    /**
     * Gets the public 'optionspagesutil' shared autowired service.
     *
     * @return \Pikart\WpBase\OptionsPages\OptionsPagesUtil
     */
    protected function getOptionspagesutilService()
    {
        return $this->services['optionspagesutil'] = new \Pikart\WpBase\OptionsPages\OptionsPagesUtil($this->get('autowired.pikart\\wpcore\\optionspages\\optionspagescoreutil'));
    }

    /**
     * Gets the public 'postlikesfacade' shared autowired service.
     *
     * @return \Pikart\WpBase\Post\PostLikesFacade
     */
    protected function getPostlikesfacadeService()
    {
        return $this->services['postlikesfacade'] = new \Pikart\WpBase\Post\PostLikesFacade($this->get('util'), $this->get('postutil'), $this->get('optionspagesutil'));
    }

    /**
     * Gets the public 'postrepository' shared autowired service.
     *
     * @return \Pikart\WpCore\Post\Dal\PostRepository
     */
    protected function getPostrepositoryService()
    {
        return $this->services['postrepository'] = new \Pikart\WpCore\Post\Dal\PostRepository();
    }

    /**
     * Gets the public 'postutil' shared autowired service.
     *
     * @return \Pikart\WpCore\Post\PostUtil
     */
    protected function getPostutilService()
    {
        return $this->services['postutil'] = new \Pikart\WpCore\Post\PostUtil();
    }

    /**
     * Gets the public 'productscomparehelper' shared autowired service.
     *
     * @return \Pikart\WpBase\Shop\ProductsCompare\ProductsCompareHelper
     */
    protected function getProductscomparehelperService()
    {
        return $this->services['productscomparehelper'] = new \Pikart\WpBase\Shop\ProductsCompare\ProductsCompareHelper(new \Pikart\WpBase\Shop\ProductsCompare\ProductsCompareDal(), $this->get('optionspagesutil'), $this->get('util'));
    }

    /**
     * Gets the public 'productscomparetemplateutil' shared autowired service.
     *
     * @return \Pikart\WpBase\Shop\ProductsCompare\ProductsCompareTemplateUtil
     */
    protected function getProductscomparetemplateutilService()
    {
        return $this->services['productscomparetemplateutil'] = new \Pikart\WpBase\Shop\ProductsCompare\ProductsCompareTemplateUtil($this->get('util'));
    }

    /**
     * Gets the public 'projectrepository' shared autowired service.
     *
     * @return \Pikart\WpCore\Post\Dal\ProjectRepository
     */
    protected function getProjectrepositoryService()
    {
        return $this->services['projectrepository'] = new \Pikart\WpCore\Post\Dal\ProjectRepository();
    }

    /**
     * Gets the public 'sidebarutil' shared autowired service.
     *
     * @return \Pikart\WpCore\Admin\Sidebars\SidebarUtil
     */
    protected function getSidebarutilService()
    {
        return $this->services['sidebarutil'] = new \Pikart\WpCore\Admin\Sidebars\SidebarUtil();
    }

    /**
     * Gets the public 'themeoptionsconfigbuilder' autowired service.
     *
     * @return \Pikart\WpCore\ThemeOptions\ThemeOptionsConfigBuilder
     */
    protected function getThemeoptionsconfigbuilderService()
    {
        return new \Pikart\WpCore\ThemeOptions\ThemeOptionsConfigBuilder();
    }

    /**
     * Gets the public 'themeoptionscoreutil' shared autowired service.
     *
     * @return \Pikart\WpCore\ThemeOptions\ThemeOptionsCoreUtil
     */
    protected function getThemeoptionscoreutilService()
    {
        return $this->services['themeoptionscoreutil'] = new \Pikart\WpCore\ThemeOptions\ThemeOptionsCoreUtil($this->get('autowired.pikart\\wpcore\\themeoptions\\themeoptionscssfilter'));
    }

    /**
     * Gets the public 'themeoptionsfacade' shared autowired service.
     *
     * @return \Pikart\WpCore\ThemeOptions\ThemeOptionsFacade
     */
    protected function getThemeoptionsfacadeService()
    {
        $a = $this->get('themeoptionscoreutil');

        return $this->services['themeoptionsfacade'] = new \Pikart\WpCore\ThemeOptions\ThemeOptionsFacade($a, new \Pikart\WpCore\ThemeOptions\ThemeOptionsBuilder(new \Pikart\WpCore\ThemeOptions\ThemeOptionsWrapper($this->get('datasanitizer'), $a, new \Pikart\WpCore\ThemeOptions\ThemeOptionsControlWrapper($this->get('autowired.pikart\\wpcore\\themeoptions\\googlefontshelper')), $this->get('util'))));
    }

    /**
     * Gets the public 'themeutil' shared autowired service.
     *
     * @return \Pikart\WpCore\Common\ThemeUtil
     */
    protected function getThemeutilService()
    {
        return $this->services['themeutil'] = new \Pikart\WpCore\Common\ThemeUtil();
    }

    /**
     * Gets the public 'util' shared autowired service.
     *
     * @return \Pikart\WpCore\Common\Util
     */
    protected function getUtilService()
    {
        return $this->services['util'] = new \Pikart\WpCore\Common\Util();
    }

    /**
     * Gets the public 'wishlisthelper' shared autowired service.
     *
     * @return \Pikart\WpBase\Shop\Wishlist\WishlistHelper
     */
    protected function getWishlisthelperService()
    {
        return $this->services['wishlisthelper'] = new \Pikart\WpBase\Shop\Wishlist\WishlistHelper(new \Pikart\WpBase\Shop\Wishlist\WishlistDal(), $this->get('optionspagesutil'), $this->get('util'));
    }

    /**
     * Gets the private 'autowired.pikart\wpbase\navigationmenus\navigationmenusutil' shared service.
     *
     * @return \Pikart\WpBase\NavigationMenus\NavigationMenusUtil
     */
    protected function getAutowired_Pikart_Wpbase_Navigationmenus_NavigationmenusutilService()
    {
        return $this->services['autowired.pikart\\wpbase\\navigationmenus\\navigationmenusutil'] = new \Pikart\WpBase\NavigationMenus\NavigationMenusUtil();
    }

    /**
     * Gets the private 'autowired.pikart\wpcore\admin\common\forminputfieldgenerator' shared service.
     *
     * @return \Pikart\WpCore\Admin\Common\FormInputFieldGenerator
     */
    protected function getAutowired_Pikart_Wpcore_Admin_Common_ForminputfieldgeneratorService()
    {
        return $this->services['autowired.pikart\\wpcore\\admin\\common\\forminputfieldgenerator'] = new \Pikart\WpCore\Admin\Common\FormInputFieldGenerator(new \Pikart\WpCore\Admin\Media\CustomGallery($this->get('autowired.pikart\\wpcore\\admin\\media\\attachmentsmetafacade'), new \Pikart\WpCore\Admin\Media\AttachmentsMetaConfigBuilder()), $this->get('customgalleryimage'));
    }

    /**
     * Gets the private 'autowired.pikart\wpcore\admin\media\attachmentsmetafacade' shared service.
     *
     * @return \Pikart\WpCore\Admin\Media\AttachmentsMetaFacade
     */
    protected function getAutowired_Pikart_Wpcore_Admin_Media_AttachmentsmetafacadeService()
    {
        return $this->services['autowired.pikart\\wpcore\\admin\\media\\attachmentsmetafacade'] = new \Pikart\WpCore\Admin\Media\AttachmentsMetaFacade();
    }

    /**
     * Gets the private 'autowired.pikart\wpcore\optionspages\optionspagescoreutil' shared service.
     *
     * @return \Pikart\WpCore\OptionsPages\OptionsPagesCoreUtil
     */
    protected function getAutowired_Pikart_Wpcore_Optionspages_OptionspagescoreutilService()
    {
        return $this->services['autowired.pikart\\wpcore\\optionspages\\optionspagescoreutil'] = new \Pikart\WpCore\OptionsPages\OptionsPagesCoreUtil();
    }

    /**
     * Gets the private 'autowired.pikart\wpcore\themeoptions\googlefontshelper' shared service.
     *
     * @return \Pikart\WpCore\ThemeOptions\GoogleFontsHelper
     */
    protected function getAutowired_Pikart_Wpcore_Themeoptions_GooglefontshelperService()
    {
        return $this->services['autowired.pikart\\wpcore\\themeoptions\\googlefontshelper'] = new \Pikart\WpCore\ThemeOptions\GoogleFontsHelper();
    }

    /**
     * Gets the private 'autowired.pikart\wpcore\themeoptions\themeoptionscssfilter' shared service.
     *
     * @return \Pikart\WpCore\ThemeOptions\ThemeOptionsCssFilter
     */
    protected function getAutowired_Pikart_Wpcore_Themeoptions_ThemeoptionscssfilterService()
    {
        return $this->services['autowired.pikart\\wpcore\\themeoptions\\themeoptionscssfilter'] = new \Pikart\WpCore\ThemeOptions\ThemeOptionsCssFilter();
    }
}
