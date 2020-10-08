<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6af6d0a87bd32c559f6113436df37109
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        'a2ef21d9cc1a7e429060bd19cd3d5b56' => __DIR__ . '/..' . '/pikart/wp-core/src/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Symfony\\Component\\Filesystem\\' => 29,
            'Symfony\\Component\\DependencyInjection\\' => 38,
            'Symfony\\Component\\Config\\' => 25,
        ),
        'P' => 
        array (
            'Pikart\\WpCore\\' => 14,
            'Pikart\\WpBase\\' => 14,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Symfony\\Component\\Filesystem\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/filesystem',
        ),
        'Symfony\\Component\\DependencyInjection\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/dependency-injection',
        ),
        'Symfony\\Component\\Config\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/config',
        ),
        'Pikart\\WpCore\\' => 
        array (
            0 => __DIR__ . '/..' . '/pikart/wp-core/src',
        ),
        'Pikart\\WpBase\\' => 
        array (
            0 => __DIR__ . '/../../..' . '/includes/src',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6af6d0a87bd32c559f6113436df37109::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6af6d0a87bd32c559f6113436df37109::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
