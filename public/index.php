<?php

use Illuminate\Http\Request;

if (PHP_VERSION_ID < 80200) {
    http_response_code(500);
    die("<div style='font-family: sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background: #fff8f8; color: #333;'>
            <h2 style='color: #d9534f;'>Sistem Hatası: PHP Sürüm Uyuşmazlığı</h2>
            <p>Bu <b>Laravel 11</b> projesi, çalışabilmek için sunucuda en az <strong>PHP 8.2</strong> sürümünün kurulu olmasını gerektirir.</p>
            <p>Ancak mevcut sunucunuzda şu an <strong>PHP " . PHP_VERSION . "</strong> yüklü.</p>
            <p><i>Lütfen sitenin sorunsuz çalışması için hosting/sunucu kontrol panelinizden PHP sürümünü 8.2 veya daha üstü bir sürüme güncelleyiniz.</i></p>
         </div>");
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
