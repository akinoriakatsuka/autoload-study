<?php
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/../src/' .$class_name . '.php';
    print 'spl_autoload_register: ' . $class_name . PHP_EOL;
});