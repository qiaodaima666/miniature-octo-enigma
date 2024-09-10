<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit089ad3125dc0150f208d63f46a74e4c6
{
    public static $files = array (
        '9b552a3cc426e3287cc811caefa3cf53' => __DIR__ . '/..' . '/topthink/think-helper/src/helper.php',
        '488987c28e9b5e95a1ce6b6bcb94606c' => __DIR__ . '/..' . '/karsonzhang/fastadmin-addons/src/common.php',
        '1cfd2761b63b0a29ed23657ea394cb2d' => __DIR__ . '/..' . '/topthink/think-captcha/src/helper.php',
        'cc56288302d9df745d97c934d6a6e5f0' => __DIR__ . '/..' . '/topthink/think-queue/src/common.php',
    );

    public static $prefixLengthsPsr4 = array (
        't' => 
        array (
            'think\\helper\\' => 13,
            'think\\composer\\' => 15,
            'think\\captcha\\' => 14,
            'think\\' => 6,
        ),
        'P' => 
        array (
            'Probe\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'think\\helper\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-helper/src',
        ),
        'think\\composer\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-installer/src',
        ),
        'think\\captcha\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-captcha/src',
        ),
        'think\\' => 
        array (
            0 => __DIR__ . '/..' . '/karsonzhang/fastadmin-addons/src',
            1 => __DIR__ . '/..' . '/topthink/think-image/src',
            2 => __DIR__ . '/..' . '/topthink/think-queue/src',
        ),
        'Probe\\' => 
        array (
            0 => __DIR__ . '/..' . '/trntv/probe/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit089ad3125dc0150f208d63f46a74e4c6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit089ad3125dc0150f208d63f46a74e4c6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit089ad3125dc0150f208d63f46a74e4c6::$classMap;

        }, null, ClassLoader::class);
    }
}
