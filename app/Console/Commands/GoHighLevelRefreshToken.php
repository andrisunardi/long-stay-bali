<?php

namespace App\Console\Commands;

use App\Libraries\GoHighLevel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GoHighLevelRefreshToken extends Command
{
    protected $signature = 'ghl:refresh-token';

    protected $description = 'Go High Level Refresh token';

    public function handle(): bool
    {
        (new GoHighLevel)->refresh();

        $this->info('Token is Refreshed.');
        Log::info('Token is Refreshed.');

        return Command::SUCCESS;
    }
}
