<?php

namespace App\Mikrotik;

use phpseclib3\Net\SFTP;
use phpseclib3\Net\SSH2;

class Client
{
    private readonly SSH2 $ssh;

    public function __construct(private readonly Config $config)
    {
        $this->ssh = new SSH2($config->address, $config->port);
        if (!$this->ssh->login($config->username, $config->password)) {
            throw new \Exception('Login failed');
        }
    }

    public function getResources(): array
    {
        $resources = $this->ssh->exec('/system/resource/print');
        return self::parseResourcesResponse($resources);
    }


    public function export(): string
    {
        return $this->ssh->exec('/export');
    }

    public function createBackup(string $name, ?bool $dontEncrypt = false, ?string $password = null): string
    {
        $params = 'name="' . $name . '"';
        $params .= !is_null($password) ? ' password="' . $password . '"' : '';
        $params .= !is_null($dontEncrypt) ? ' dont-encrypt=' . ($dontEncrypt ? 'yes' : 'no') : '';
        $cmd = '/system/backup/save ' . $params;
        return $this->ssh->exec($cmd);
    }

    public function getFile(string $remoteFile): string
    {
        $sftp = new SFTP($this->config->address, $this->config->port);
        if (!$sftp->login($this->config->username, $this->config->password)) {
            throw new \Exception('Login failed');
        }

        $fileContents = $sftp->get($remoteFile);
        if ($fileContents === false) {
            $sftp->disconnect();
            dd($fileContents);
            throw new \Exception("Failed to read file {$remoteFile} from router.");
        }
        $sftp->disconnect();
        return $fileContents;
    }

    private static function parseResourcesResponse(string $response): array
    {
        $result = [];

        // Normalize line endings and split into lines
        $lines = preg_split('/\r\n|\r|\n/', trim($response));

        foreach ($lines as $line) {
            // skip empty lines
            if (!trim($line)) {
                continue;
            }

            // split on the first colon only
            [$key, $value] = array_map('trim', explode(':', $line, 2));

            $result[$key] = $value;
        }

        return $result;
    }
}
