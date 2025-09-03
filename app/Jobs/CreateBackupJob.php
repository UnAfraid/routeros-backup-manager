<?php

namespace App\Jobs;

use App\Mikrotik\Config;
use App\Mikrotik\MikrotikConnectionException;
use App\Mikrotik\SftpClient;
use App\Mikrotik\SshClient;
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
        if (!$this->device->script_backup_enabled &&
            !$this->device->binary_backup_enabled) {
            return;
        }

        $device = $this->device->load('credential');
        $date = now()->format('Y-m-d');
        $name = 'backup_' . now()->format('Y-m-d_H-i-s');

        $backup = Backup::create([
            'device_id' => $this->device->id,
            'started_at' => now(),
            'success' => false,
        ]);
        try {
            // Create the backups
            $version = $this->createBackups($device, $name);

            // Download the backups
            $this->downloadBackups($device, $backup, $name, $version, $date);

            $backup->success = true;
        } catch (MikrotikConnectionException $e) {
            $backup->connection_error = true;
            $backup->error_message = $e->getMessage();
            $backup->success = false;
            throw $e;
        } catch (\Exception $e) {
            $backup->error_message = $e->getMessage();
            $backup->success = false;
            throw $e;
        } finally {
            $backup->finished_at = now();
            $backup->save();
        }
    }

    /**
     * @param Model|Device $device
     * @param string $name
     * @return string version
     * @throws \Exception
     */
    public function createBackups(Model|Device $device, string $name): string
    {
        $sshClient = new SshClient(Config::fromDevice($device));

        try {
            $sshClient->connect();

            $resources = $sshClient->getResources();
            $version = $resources['version'];

            if ($this->device->script_backup_enabled) {
                $sshClient->export($name);
            }

            if ($this->device->binary_backup_enabled) {
                $response = $sshClient->createBackup($name);
                if (!str_contains($response, 'Configuration backup saved')) {
                    throw new \Exception('Failed to create backup');
                }
            }
        } finally {
            $sshClient->disconnect();
        }
        return $version;
    }

    /**
     * @param Model|Device $device
     * @param Model $backup
     * @param string $name
     * @param string $version
     * @param string $date
     * @return void
     * @throws \Exception
     */
    public function downloadBackups(Model|Device $device, Model $backup, string $name, string $version, string $date): void
    {
        $sftpClient = new SftpClient(Config::fromDevice($device));
        try {
            $sftpClient->connect();

            if ($this->device->script_backup_enabled) {
                $fileName = $name . '.rsc';
                $response = $sftpClient->getFile($fileName);
                if (empty($response)) {
                    throw new \Exception('Failed to download script backup');
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
                $fileName = $name . '.backup';
                $fileContents = $sftpClient->getFile($fileName);
                if (empty($response)) {
                    throw new \Exception('Failed to download binary backup');
                }

                $filePath = "backups/{$device->id}/{$date}/{$fileName}";
                $success = Storage::disk('local')->put($filePath, $fileContents);
                if (!$success) {
                    throw new \Exception('Failed to save binary backup to storage');
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
        } finally {
            $sftpClient->disconnect();
        }
    }
}
