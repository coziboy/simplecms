<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit086954bb6ec6049e5713828ad45bd270
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Golonka\\BBCode\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Golonka\\BBCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/golonka/bbcodeparser/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit086954bb6ec6049e5713828ad45bd270::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit086954bb6ec6049e5713828ad45bd270::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
