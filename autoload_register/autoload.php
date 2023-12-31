<?php

spl_autoload_register(function ($class) {
    echo '1. ' . $class . 'クラスを読み込みます。' . PHP_EOL;
    require_once $class . '.php';
    echo '2. ' . $class . 'クラスを読み込みました。' . PHP_EOL;
});
