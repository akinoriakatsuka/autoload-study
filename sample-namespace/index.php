<?php

use SampleVendor\SampleModule\SampleClass;
use HogeVendor\HogeModule\HogeClass;
use HogeVendor\App as HogeApp;

require_once __DIR__ . '/vendor/autoload.php';

$some_class = new SampleClass(); // SampleVendor/SampleModule/SomeClass.php
$hoge_class = new HogeClass(); // HogeVendor/HogeModule/Hoge.php
$app = new HogeApp(); // app/App.php

hello(); // app/Helper.php (filesのautoload)
