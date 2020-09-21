<?php

namespace Pikart\Nels\DependencyInjection;

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
            'autowired.pikart\\nels\\post\\options\\processor\\blogpageoptionsprocessor' => 'getAutowired_Pikart_Nels_Post_Options_Processor_BlogpageoptionsprocessorService',
            'autowired.pikart\\wpthemecore\\admin\\media\\attachmentsmetafacade' => 'getAutowired_Pikart_Wpthemecore_Admin_Media_AttachmentsmetafacadeService',
            'autowired.pikart\\wpthemecore\\themeoptions\\googlefontshelper' => 'getAutowired_Pikart_Wpthemecore_Themeoptions_GooglefontshelperService',
            'autowired.pikart\\wpthemecore\\themeoptions\\themeoptionscssfilter' => 'getAutowired_Pikart_Wpthemecore_Themeoptions_ThemeoptionscssfilterService',
            'blogoptionsloader' => 'getBlogoptionsloaderService',
            'bootstrap' => 'getBootstrapService',
            'coreassetsregister' => 'getCoreassetsregisterService',
            'customgalleryimage' => 'getCustomgalleryimageService',
            'customwalkercomment' => 'getCustomwalkercommentService',
            'datasanitizer' => 'getDatasanitizerService',
            'metaboxconfigbuilder' => 'getMetaboxconfigbuilderService',
            'metaboxfacade' => 'getMetaboxfacadeService',
            'postoptionsloader' => 'getPostoptionsloaderService',
            'postrepository' => 'getPostrepositoryService',
            'postutil' => 'getPostutilService',
            'projectrepository' => 'getProjectrepositoryService',
            'sidebarutil' => 'getSidebarutilService',
            'templatesutil' => 'getTemplatesutilService',
            'themeoptionsconfigbuilder' => 'getThemeoptionsconfigbuilderService',
            'themeoptionscoreutil' => 'getThemeoptionscoreutilService',
            'themeoptionsfacade' => 'getThemeoptionsfacadeService',
            'themeoptionsutil' => 'getThemeoptionsutilService',
            'themeutil' => 'getThemeutilService',
            'util' => 'getUtilService',
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
     * @return \Pikart\WpThemeCore\Admin\Media\AttachmentsUtil
     */
    protected function getAttachmentsutilService()
    {
        return $this->services['attachmentsutil'] = new \Pikart\WpThemeCore\Admin\Media\AttachmentsUtil();
    }

    /**
     * Gets the public 'blogoptionsloader' shared autowired service.
     *
     * @return \Pikart\Nels\Blog\Options\BlogOptionsLoader
     */
    protected function getBlogoptionsloaderService()
    {
        return $this->services['blogoptionsloader'] = new \Pikart\Nels\Blog\Options\BlogOptionsLoader($this->get('themeoptionsutil'), $this->get('postutil'), $this->get('postrepository'), $this->get('autowired.pikart\\nels\\post\\options\\processor\\blogpageoptionsprocessor'));
    }

    /**
     * Gets the public 'bootstrap' shared autowired service.
     *
     * @return \Pikart\Nels\Setup\Bootstrap
     */
    protected function getBootstrapService()
    {
        $a = $this->get('themeoptionsutil');
        $b = $this->get('util');
        $c = $this->get('templatesutil');
        $d = $this->get('themeutil');
        $e = $this->get('metaboxconfigbuilder');
        $f = $this->get('sidebarutil');

        $g = new \Pikart\WpThemeCore\ThemeOptions\ConfigBuilder\ControlConfigBuilder();

        $h = new \Pikart\WpThemeCore\ThemeOptions\ConfigBuilder\SectionConfigBuilder($g);

        $i = new \Pikart\WpThemeCore\ThemeOptions\ThemeOptionsConfigHelper();

        $j = new \Pikart\Nels\ThemeOptions\ThemeOptionsJsHelper($a);

        return $this->services['bootstrap'] = new \Pikart\Nels\Setup\Bootstrap(new \Pikart\Nels\Setup\ThemeSetup($a, $b, $this->get('autowired.pikart\\wpthemecore\\themeoptions\\googlefontshelper')), new \Pikart\Nels\Common\AssetsRegister(), new \Pikart\Nels\Shortcode\ThemeShortcodesInitilizer($a, $this->get('postutil'), new \Pikart\Nels\Shortcode\Config\ShortcodesAttributesConfig($a)), new \Pikart\Nels\ThemeOptions\ThemeOptionsGenerator($this->get('themeoptionsfacade'), new \Pikart\Nels\ThemeOptions\CustomThemeOptionsProvider(new \Pikart\Nels\ThemeOptions\Config\ThemeOptionsConfigBase(new \Pikart\WpThemeCore\ThemeOptions\ConfigBuilder\ThemeOptionsConfigBuilder(new \Pikart\WpThemeCore\ThemeOptions\ConfigBuilder\PanelConfigBuilder($h), $h, $g), $i, new \Pikart\Nels\ThemeOptions\Config\ThemeOptionsConfigProvider(new \Pikart\Nels\ThemeOptions\Config\LayoutConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\ColorsConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\TypographyConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\MiscConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\ContentGeneralConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\SinglePostConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\SingleProjectConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\SinglePageConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\FeaturedBrandingConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\SidebarConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\ErrorPageConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\ShopHeaderConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\ShopProductConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\ShopRibbonsConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\HeaderLayoutConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\HeaderMenuConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\HeaderSearchAreaConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\HeaderSidebarConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\HeaderAboveAreaConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\HeaderMobileMenuConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\FooterSidebarConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\FooterBelowAreaConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\SiteIdentityConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\ShopProductCatalogConfig($g, $a, $i, $c, $d, $b), new \Pikart\Nels\ThemeOptions\Config\WpOptionsConfig($g, $a, $i, $c, $d, $b))), $j), $j, $a), new \Pikart\Nels\Widgets\WidgetsInitializer(new \Pikart\Nels\Widgets\RecentPostsCustomWidget($b), new \Pikart\Nels\Widgets\RecentCommentsCustomWidget($b)), new \Pikart\Nels\Site\SiteCustomizer($b, $c, new \Pikart\Nels\Site\SqlCustomizer(), $a), new \Pikart\Nels\Site\SidebarCustomizer($a), new \Pikart\Nels\Misc\PluginsRegister($b), new \Pikart\Nels\Shop\ShopSetup($b, $this->get('postoptionsloader'), $a, new \Pikart\Nels\Shop\ProductQuickViewInitializer($b)), new \Pikart\Nels\Post\Options\PostOptionsConfigInitializer(new \Pikart\WpThemeCore\Post\Options\PostOptionsConfigRegister($this->get('metaboxfacade')), new \Pikart\Nels\Post\Options\PostOptionsConfigProvider(new \Pikart\Nels\Post\Options\Config\ProjectOptionsConfig($e, $f), new \Pikart\Nels\Post\Options\Config\ProductOptionsConfig($e, $f), new \Pikart\Nels\Post\Options\Config\AlbumOptionsConfig($e, $f), new \Pikart\Nels\Post\Options\Config\PostOptionsConfig($e, $f, new \Pikart\Nels\Post\Options\PostFormatOptionsConfigProvider(new \Pikart\Nels\Post\Options\Config\Format\GalleryFormatOptionsConfig(), new \Pikart\Nels\Post\Options\Config\Format\LinkFormatOptionsConfig(), new \Pikart\Nels\Post\Options\Config\Format\QuoteFormatOptionsConfig(), new \Pikart\Nels\Post\Options\Config\Format\AudioFormatOptionsConfig(), new \Pikart\Nels\Post\Options\Config\Format\VideoFormatOptionsConfig(), new \Pikart\Nels\Post\Options\Config\Format\StandardFormatOptionsConfig(), new \Pikart\Nels\Post\Options\Config\Format\ImageFormatOptionsConfig(), new \Pikart\Nels\Post\Options\Config\Format\AsideFormatOptionsConfig())), new \Pikart\Nels\Post\Options\Config\PageOptionsConfig($e, $f, new \Pikart\Nels\Post\Options\Config\Template\BlogTemplateOptionsConfig($this->get('postrepository')))), $a), new \Pikart\Nels\Setup\PikartBaseOptionsPageConfigSetup(), new \Pikart\Nels\Site\NavigationMenusCustomizer($a), new \Pikart\Nels\Site\PostLikesCustomizer(), new \Pikart\Nels\Setup\WpBakerySetup(), new \Pikart\Nels\Admin\Migration\MigrationSetup(new \Pikart\Nels\Admin\Migration\OneClickDemoImportSetup(), new \Pikart\Nels\Admin\Migration\WpImporterSetup()));
    }

    /**
     * Gets the public 'coreassetsregister' shared autowired service.
     *
     * @return \Pikart\WpThemeCore\Common\CoreAssetsRegister
     */
    protected function getCoreassetsregisterService()
    {
        return $this->services['coreassetsregister'] = new \Pikart\WpThemeCore\Common\CoreAssetsRegister();
    }

    /**
     * Gets the public 'customgalleryimage' shared autowired service.
     *
     * @return \Pikart\WpThemeCore\Admin\Media\CustomGalleryImage
     */
    protected function getCustomgalleryimageService()
    {
        return $this->services['customgalleryimage'] = new \Pikart\WpThemeCore\Admin\Media\CustomGalleryImage($this->get('autowired.pikart\\wpthemecore\\admin\\media\\attachmentsmetafacade'));
    }

    /**
     * Gets the public 'customwalkercomment' shared autowired service.
     *
     * @return \Pikart\Nels\Blog\CustomWalkerComment
     */
    protected function getCustomwalkercommentService()
    {
        return $this->services['customwalkercomment'] = new \Pikart\Nels\Blog\CustomWalkerComment($this->get('util'));
    }

    /**
     * Gets the public 'datasanitizer' shared autowired service.
     *
     * @return \Pikart\WpThemeCore\Common\DataSanitizer
     */
    protected function getDatasanitizerService()
    {
        return $this->services['datasanitizer'] = new \Pikart\WpThemeCore\Common\DataSanitizer();
    }

    /**
     * Gets the public 'metaboxconfigbuilder' shared autowired service.
     *
     * @return \Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder
     */
    protected function getMetaboxconfigbuilderService()
    {
        return $this->services['metaboxconfigbuilder'] = new \Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder();
    }

    /**
     * Gets the public 'metaboxfacade' shared autowired service.
     *
     * @return \Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxFacade
     */
    protected function getMetaboxfacadeService()
    {
        $a = $this->get('util');
        $b = $this->get('datasanitizer');

        $c = new \Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxDal($b, $a);

        return $this->services['metaboxfacade'] = new \Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxFacade($a, $c, new \Pikart\WpThemeCore\Admin\MetaBoxes\Generator\MetaBoxGenerator(new \Pikart\WpThemeCore\Admin\MetaBoxes\Generator\MetaBoxGeneratorHelper(new \Pikart\WpThemeCore\Admin\MetaBoxes\Generator\LineGenerator(new \Pikart\WpThemeCore\Admin\Common\FormInputFieldGenerator(new \Pikart\WpThemeCore\Admin\Media\CustomGallery($this->get('autowired.pikart\\wpthemecore\\admin\\media\\attachmentsmetafacade'), new \Pikart\WpThemeCore\Admin\Media\AttachmentsMetaConfigBuilder()), $this->get('customgalleryimage'))), $c)), new \Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxCustomizedCssGenerator($this->get('postutil'), $this->get('autowired.pikart\\wpthemecore\\themeoptions\\themeoptionscssfilter')));
    }

    /**
     * Gets the public 'postoptionsloader' shared autowired service.
     *
     * @return \Pikart\Nels\Post\Options\PostOptionsLoader
     */
    protected function getPostoptionsloaderService()
    {
        return $this->services['postoptionsloader'] = new \Pikart\Nels\Post\Options\PostOptionsLoader($this->get('postutil'), $this->get('autowired.pikart\\nels\\post\\options\\processor\\blogpageoptionsprocessor'));
    }

    /**
     * Gets the public 'postrepository' shared autowired service.
     *
     * @return \Pikart\WpThemeCore\Post\Dal\PostRepository
     */
    protected function getPostrepositoryService()
    {
        return $this->services['postrepository'] = new \Pikart\WpThemeCore\Post\Dal\PostRepository();
    }

    /**
     * Gets the public 'postutil' shared autowired service.
     *
     * @return \Pikart\WpThemeCore\Post\PostUtil
     */
    protected function getPostutilService()
    {
        return $this->services['postutil'] = new \Pikart\WpThemeCore\Post\PostUtil();
    }

    /**
     * Gets the public 'projectrepository' shared autowired service.
     *
     * @return \Pikart\WpThemeCore\Post\Dal\ProjectRepository
     */
    protected function getProjectrepositoryService()
    {
        return $this->services['projectrepository'] = new \Pikart\WpThemeCore\Post\Dal\ProjectRepository();
    }

    /**
     * Gets the public 'sidebarutil' shared autowired service.
     *
     * @return \Pikart\WpThemeCore\Admin\Sidebars\SidebarUtil
     */
    protected function getSidebarutilService()
    {
        return $this->services['sidebarutil'] = new \Pikart\WpThemeCore\Admin\Sidebars\SidebarUtil();
    }

    /**
     * Gets the public 'templatesutil' shared autowired service.
     *
     * @return \Pikart\Nels\Misc\TemplatesUtil
     */
    protected function getTemplatesutilService()
    {
        return $this->services['templatesutil'] = new \Pikart\Nels\Misc\TemplatesUtil($this->get('themeoptionsutil'), $this->get('blogoptionsloader'), $this->get('util'), new \Pikart\Nels\Misc\BreadcrumbsGenerator($this->get('postutil'), new \Pikart\WpThemeCore\Post\Dal\CategoryRepository(), new \Pikart\WpThemeCore\Post\Dal\ProjectCategoryRepository()), $this->get('postoptionsloader'));
    }

    /**
     * Gets the public 'themeoptionsconfigbuilder' autowired service.
     *
     * @return \Pikart\WpThemeCore\ThemeOptions\ThemeOptionsConfigBuilder
     */
    protected function getThemeoptionsconfigbuilderService()
    {
        return new \Pikart\WpThemeCore\ThemeOptions\ThemeOptionsConfigBuilder();
    }

    /**
     * Gets the public 'themeoptionscoreutil' shared autowired service.
     *
     * @return \Pikart\WpThemeCore\ThemeOptions\ThemeOptionsCoreUtil
     */
    protected function getThemeoptionscoreutilService()
    {
        return $this->services['themeoptionscoreutil'] = new \Pikart\WpThemeCore\ThemeOptions\ThemeOptionsCoreUtil($this->get('autowired.pikart\\wpthemecore\\themeoptions\\themeoptionscssfilter'));
    }

    /**
     * Gets the public 'themeoptionsfacade' shared autowired service.
     *
     * @return \Pikart\WpThemeCore\ThemeOptions\ThemeOptionsFacade
     */
    protected function getThemeoptionsfacadeService()
    {
        $a = $this->get('themeoptionscoreutil');

        return $this->services['themeoptionsfacade'] = new \Pikart\WpThemeCore\ThemeOptions\ThemeOptionsFacade($a, new \Pikart\WpThemeCore\ThemeOptions\ThemeOptionsBuilder(new \Pikart\WpThemeCore\ThemeOptions\ThemeOptionsWrapper($this->get('datasanitizer'), $a, new \Pikart\WpThemeCore\ThemeOptions\ThemeOptionsControlWrapper($this->get('autowired.pikart\\wpthemecore\\themeoptions\\googlefontshelper')), $this->get('util'))));
    }

    /**
     * Gets the public 'themeoptionsutil' shared autowired service.
     *
     * @return \Pikart\Nels\ThemeOptions\ThemeOptionsUtil
     */
    protected function getThemeoptionsutilService()
    {
        return $this->services['themeoptionsutil'] = new \Pikart\Nels\ThemeOptions\ThemeOptionsUtil($this->get('themeoptionscoreutil'), $this->get('util'));
    }

    /**
     * Gets the public 'themeutil' shared autowired service.
     *
     * @return \Pikart\WpThemeCore\Common\ThemeUtil
     */
    protected function getThemeutilService()
    {
        return $this->services['themeutil'] = new \Pikart\WpThemeCore\Common\ThemeUtil();
    }

    /**
     * Gets the public 'util' shared autowired service.
     *
     * @return \Pikart\WpThemeCore\Common\Util
     */
    protected function getUtilService()
    {
        return $this->services['util'] = new \Pikart\WpThemeCore\Common\Util();
    }

    /**
     * Gets the private 'autowired.pikart\nels\post\options\processor\blogpageoptionsprocessor' shared service.
     *
     * @return \Pikart\Nels\Post\Options\Processor\BlogPageOptionsProcessor
     */
    protected function getAutowired_Pikart_Nels_Post_Options_Processor_BlogpageoptionsprocessorService()
    {
        return $this->services['autowired.pikart\\nels\\post\\options\\processor\\blogpageoptionsprocessor'] = new \Pikart\Nels\Post\Options\Processor\BlogPageOptionsProcessor($this->get('postrepository'));
    }

    /**
     * Gets the private 'autowired.pikart\wpthemecore\admin\media\attachmentsmetafacade' shared service.
     *
     * @return \Pikart\WpThemeCore\Admin\Media\AttachmentsMetaFacade
     */
    protected function getAutowired_Pikart_Wpthemecore_Admin_Media_AttachmentsmetafacadeService()
    {
        return $this->services['autowired.pikart\\wpthemecore\\admin\\media\\attachmentsmetafacade'] = new \Pikart\WpThemeCore\Admin\Media\AttachmentsMetaFacade();
    }

    /**
     * Gets the private 'autowired.pikart\wpthemecore\themeoptions\googlefontshelper' shared service.
     *
     * @return \Pikart\WpThemeCore\ThemeOptions\GoogleFontsHelper
     */
    protected function getAutowired_Pikart_Wpthemecore_Themeoptions_GooglefontshelperService()
    {
        return $this->services['autowired.pikart\\wpthemecore\\themeoptions\\googlefontshelper'] = new \Pikart\WpThemeCore\ThemeOptions\GoogleFontsHelper();
    }

    /**
     * Gets the private 'autowired.pikart\wpthemecore\themeoptions\themeoptionscssfilter' shared service.
     *
     * @return \Pikart\WpThemeCore\ThemeOptions\ThemeOptionsCssFilter
     */
    protected function getAutowired_Pikart_Wpthemecore_Themeoptions_ThemeoptionscssfilterService()
    {
        return $this->services['autowired.pikart\\wpthemecore\\themeoptions\\themeoptionscssfilter'] = new \Pikart\WpThemeCore\ThemeOptions\ThemeOptionsCssFilter();
    }
}
