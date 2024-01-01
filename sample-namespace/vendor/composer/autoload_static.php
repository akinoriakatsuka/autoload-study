<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite96b7a333007529ebae6c88ad1b640e3
{
    public static $files = array (
        '106f83ad4196f7fa785c075422ee1b54' => __DIR__ . '/../..' . '/app/Helper.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SampleVendor\\' => 13,
        ),
        'H' => 
        array (
            'HogeVendor\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SampleVendor\\' => 
        array (
            0 => __DIR__ . '/../..' . '/SampleVendor',
        ),
        'HogeVendor\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
            1 => __DIR__ . '/../..' . '/HogeVendor',
        ),
    );

    public static $prefixesPsr0 = array (
        'F' => 
        array (
            'FugaVendor\\' => 
            array (
                0 => __DIR__ . '/../..' . '/lib',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Foo\\Foo' => __DIR__ . '/../..' . '/src/Foo.php',
        'Foo\\Foo2' => __DIR__ . '/../..' . '/src/Foo/Foo2.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite96b7a333007529ebae6c88ad1b640e3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite96b7a333007529ebae6c88ad1b640e3::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite96b7a333007529ebae6c88ad1b640e3::$prefixesPsr0;
            $loader->classMap = ComposerStaticInite96b7a333007529ebae6c88ad1b640e3::$classMap;

        }, null, ClassLoader::class);
    }
}
