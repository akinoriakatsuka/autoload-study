<?php

require __DIR__ . '/../vendor/autoload.php';

var_dump(spl_autoload_functions());

$someClass = new App\SomeClass();
$someClass = new App\Hoge();