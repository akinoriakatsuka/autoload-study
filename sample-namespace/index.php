<?php

use SampleVendor\SampleModule\SampleClass;
use HogeVendor\HogeModule\HogeClass;
use HogeVendor\App as HogeApp;

require_once __DIR__ . '/vendor/autoload.php';

$some_class = new SampleClass(); // SampleVendor/SampleModule/SomeClass.php
$hoge_class = new HogeClass(); // HogeVendor/HogeModule/Hoge.php
$app = new HogeApp(); // app/App.php

$fuga = new \FugaVendor\Fuga(); // lib/fuga/Fuga.php (psr-0のautoload)

$foo = new \Foo\Foo(); // src/Foo.php (classmapのautoload)
$foo2 = new \Foo\Foo2(); // src/foo/Foo2.php (classmapのautoload)

hello(); // app/Helper.php (filesのautoload)
