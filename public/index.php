<?php
die("Sunucudaki PHP Sürümü: " . PHP_VERSION . " (Gerekli: 8.2+)");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Illuminate\Http\Request;

if (PHP_VERSION_ID < 80200) {
    die("HATA: Sunucuda PHP " . PHP_VERSION . " yüklü. Laravel 11 için en az 8.2.0 gereklidir.");
}

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
