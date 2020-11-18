<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit21469b47038d62795b5b459dc07f79cb
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SiteManagement\\' => 15,
        ),
        'F' => 
        array (
            'Framework\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SiteManagement\\' => 
        array (
            0 => __DIR__ . '/../..' . '/functions/api',
        ),
        'Framework\\' => 
        array (
            0 => __DIR__ . '/..' . '/gbiorczyk/wordpress-framework/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit21469b47038d62795b5b459dc07f79cb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit21469b47038d62795b5b459dc07f79cb::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
