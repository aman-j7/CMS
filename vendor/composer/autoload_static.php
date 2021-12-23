<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit06e3a371784b4c9bd64e92103d902968
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit06e3a371784b4c9bd64e92103d902968::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit06e3a371784b4c9bd64e92103d902968::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit06e3a371784b4c9bd64e92103d902968::$classMap;

        }, null, ClassLoader::class);
    }
}
