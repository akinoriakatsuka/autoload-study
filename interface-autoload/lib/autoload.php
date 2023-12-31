<?php
spl_autoload_register(function ($class_name) {
    print 'spl_autoload_register: ' . $class_name  . 'をインクルードしてきます' . PHP_EOL;
    include __DIR__ . '/../src/' .$class_name . '.php';
    print 'spl_autoload_register: ' . $class_name  . 'をインクルードしてきました' . PHP_EOL;
});