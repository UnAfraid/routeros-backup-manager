<?php

namespace App\Jobs;

use App\Mikrotik\Client;
use App\Mikrotik\Config;
use App\Models\Device;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;

class CreateBackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     * @param Device $device
     */
    public function __construct(private readonly Model $device)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $device = $this->device->load('credential');
        $mikrotik = new Client(Config::fromDevice($device));
        if (!$mikrotik->connect()) {
            throw new \Exception('Failed to connect to device: ' . $device->name);
        }

        try {
            $resources = $mikrotik->getResources();
            $version = $resources['version'];
            $date = now()->format('Y-m-d');
            $name = 'backup_' . now()->format('Y-m-d_H-i-s');

            if ($this->device->script_backup_enabled) {
                $response = $mikrotik->export();

                if (!empty($response)) {
                    $this->device->scriptBackups()->create([
                        'name' => $name,
                        'content' => $response,
                        'hash' => hash('sha256', $response),
                        'size' => mb_strlen($response),
                        'version' => $version,
                    ]);
                }
            }


            if ($this->device->binary_backup_enabled) {
                $response = $mikrotik->createBackup($name);
                if (!str_contains($response, 'Configuration backup saved')) {
                    throw new \Exception('Failed to create backup');
                }
                $fileName = $name . '.backup';
                $fileContents = $mikrotik->getFile($fileName);

                $filePath = "backups/{$device->id}/{$date}/{$fileName}";
                $success = Storage::disk('local')->put($filePath, $fileContents);
                if (!$success) {
                    throw new \Exception('Failed to save backup to storage');
                }

                $this->device->binaryBackups()->create([
                    'name' => $name,
                    'path' => $filePath,
                    'hash' => hash('sha256', $response),
                    'size' => mb_strlen($response),
                    'version' => $version,
                ]);
            }

            info('Done');
        } finally {
            $mikrotik->disconnect();
        }
    }
}
