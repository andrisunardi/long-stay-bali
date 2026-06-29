<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('logs:clear', function () {
    $files = File::glob(storage_path('logs/*.log'));

    foreach ($files as $file) {
        File::delete($file);
        $this->line(basename($file));
    }

    $this->info('All Laravel logs have been deleted.');
})->purpose('Delete all Laravel log files');

Schedule::command('ghl:refresh-token')->daily();
Schedule::command('exchange-rate:refresh-currency')->daily();
