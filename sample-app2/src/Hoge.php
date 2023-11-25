<?php

class Hoge implements MyInterface
{
    public function __construct()
    {
        echo 'Hoge::__construct()' . PHP_EOL;
    }

    public function doSomething()
    {
        echo 'Hoge::doSomething()' . PHP_EOL;
    }
}