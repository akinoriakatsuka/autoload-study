<?php

require __DIR__ . '/../app/Hoge.php';
require __DIR__ . '/../app/Fuga.php';

if(true) {
    $hoge = new App\Hoge();
} else {
    $fuga = new App\Fuga();
}
