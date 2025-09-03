<?php

namespace App\Mikrotik;

use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SSH2;

readonly class SshClient
{
    private SSH2 $ssh;

    public function __construct(private Config $config)
    {
        $this->ssh = new SSH2($config->address, $config->port);
    }

    /**
     * @throws MikrotikConnectionException
     */
    public function connect(): void
    {
        $credential = $this->config->password;
        if (!empty($this->config->privateKey)) {
            $credential = PublicKeyLoader::loadPrivateKey($this->config->privateKey, $this->config->passphrase ?? false);
        }

        if (!$this->ssh->login($this->config->username, $credential)) {
            throw new MikrotikConnectionException("Failed to connect to the router.");
        }
    }

    public function disconnect(): void
    {
        $this->ssh->disconnect();
    }

    public function getResources(): array
    {
        $resources = $this->ssh->exec('/system/resource/print');
        return self::parseResourcesResponse($resources);
    }

    public function export(?string $name = null): string
    {
        $params = '';
        if (filled($name)) {
            $params .= ' file="' . $name . '"';
        }
        return $this->ssh->exec('/export' . $params);
    }

    public function createBackup(string $name, ?bool $dontEncrypt = false, ?string $password = null): string
    {
        $params = ' name="' . $name . '"';
        $params .= filled($password) ? ' password="' . $password . '"' : '';
        $params .= filled($dontEncrypt) ? ' dont-encrypt=' . ($dontEncrypt ? 'yes' : 'no') : '';
        $cmd = '/system/backup/save' . $params;
        return $this->ssh->exec($cmd);
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
