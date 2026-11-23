<?php
require __DIR__ . '/vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeload();
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => __DIR__ . '/database.sqlite',
    'prefix' => "",
]);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    session_start();