<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../src-staging/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../src-staging/vendor/autoload.php';

(require_once __DIR__.'/../src-staging/bootstrap/app.php')
    ->handleRequest(Request::capture());
