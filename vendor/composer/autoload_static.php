<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2244a1ec449280210bbb226c9a3779d9
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'OpenCF\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'OpenCF\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpjuice/opencf/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2244a1ec449280210bbb226c9a3779d9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2244a1ec449280210bbb226c9a3779d9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2244a1ec449280210bbb226c9a3779d9::$classMap;

        }, null, ClassLoader::class);
    }
}
