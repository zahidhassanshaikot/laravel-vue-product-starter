<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:database-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Database backup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".gz";

        $dbHost = env('DB_HOST');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');

        // Ensure backup directory exists
        if (!file_exists(storage_path("app/backup"))) {
            mkdir(storage_path("app/backup"), 0755, true);
        }

        $this->info('Backing up database...');
        $backupPath = storage_path("app/backup/{$filename}");

        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s | gzip > %s',
            escapeshellarg($dbUser),
            escapeshellarg($dbPass),
            escapeshellarg($dbHost),
            escapeshellarg($dbName),
            escapeshellarg($backupPath)
        );

        $returnVar = null;
        $output = [];
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            $this->error('Database backup failed.');
            $this->error('Output: ' . implode("\n", $output));
        } else {
            $this->info('Database backup successful!');
        }
    }
}
