<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DatabaseBackupCommand extends Command
{
    protected $signature = 'database:backup';

    protected $description = 'Database Backup';

    public function handle(): bool
    {
        $username = config('database.mysql.username');
        $password = config('database.mysql.password');
        $database = config('database.mysql.database');

        $date = today()->toDateString();
        $path = storage_path("app/private/database/{$date}.sql");

        exec("mysqldump -u {$username} -p{$password} {$database} > {$path}");

        $this->info('Database Backup is Completed.');
        Log::info('Database Backup is Completed.');

        return Command::SUCCESS;
    }
}
