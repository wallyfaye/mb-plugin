<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit691382caa848b70d0d9a84cab9644e77
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'ModelBuilder\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ModelBuilder\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit691382caa848b70d0d9a84cab9644e77::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit691382caa848b70d0d9a84cab9644e77::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}