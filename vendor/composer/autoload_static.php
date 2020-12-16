<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9d98ff59af2e61e32477b3a09b885278
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit9d98ff59af2e61e32477b3a09b885278::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9d98ff59af2e61e32477b3a09b885278::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9d98ff59af2e61e32477b3a09b885278::$classMap;

        }, null, ClassLoader::class);
    }
}