<?php

namespace App\Jobs;

use App\Mikrotik\Client;
use App\Mikrotik\Config;
use App\Models\Backup;
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
        $backup = Backup::create([
            'device_id' => $this->device->id,
            'started_at' => now(),
            'success' => false,
        ]);

        $device = $this->device->load('credential');
        $mikrotik = new Client(Config::fromDevice($device));

        try {
            if (!$mikrotik->connect()) {
                $backup->connection_error = true;
                throw new \Exception('Failed to connect to device: ' . $device->name);
            }

            $resources = $mikrotik->getResources();
            $version = $resources['version'];
            $date = now()->format('Y-m-d');
            $name = 'backup_' . now()->format('Y-m-d_H-i-s');

            if ($this->device->script_backup_enabled) {
                $response = $mikrotik->export();
                if (empty($response)) {
                    throw new \Exception('Failed to export configuration');
                }

                $scriptBackup = $this->device->scriptBackups()->create([
                    'name' => $name,
                    'content' => $response,
                    'hash' => hash('sha256', $response),
                    'size' => mb_strlen($response),
                    'version' => $version,
                ]);
                $backup->script_backup_id = $scriptBackup->id;
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

                $binaryBackup = $this->device->binaryBackups()->create([
                    'name' => $name,
                    'path' => $filePath,
                    'hash' => hash('sha256', $response),
                    'size' => mb_strlen($response),
                    'version' => $version,
                ]);
                $backup->binary_backup_id = $binaryBackup->id;
            }

            $backup->success = true;
        } catch (\Exception $e) {
            $backup->error_message = $e->getMessage();
            $backup->success = false;
        } finally {
            $backup->finished_at = now();
            $mikrotik->disconnect();
            $backup->save();
        }
    }
}
