<?php

namespace App\Console\Commands;

use App\Models\Device;
use Illuminate\Console\Command;

class CreateBackupJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-backup-job
    {device : The ID of the device to create a backup for}
    {--sync= : Run the job synchronously}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Triggers a background job to create a backup for the given device';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $device = Device::findOrFail($this->argument('device'));
        if ($this->hasOption('sync')) {
            $this->info('Running job synchronously for device: ' . $device->name);
            (new \App\Jobs\CreateBackupJob($device))->handle();
        } else {
            $this->info('Running job asynchronously for device: ' . $device->name);
            \App\Jobs\CreateBackupJob::dispatch($device);
        }
    }
}
