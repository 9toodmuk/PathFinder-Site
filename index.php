<?php
require_once 'vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

session_start();

require_once 'social/core/app.php';
require_once 'social/core/controller.php';

$app = new App();
