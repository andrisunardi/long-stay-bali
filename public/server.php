<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../src-long-stay-bali/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../src-long-stay-bali/vendor/autoload.php';

(require_once __DIR__.'/../src-long-stay-bali/bootstrap/app.php')
    ->handleRequest(Request::capture());
