<?php

namespace App\Mikrotik;

use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SFTP;

readonly class SftpClient
{
    private SFTP $sftp;

    public function __construct(private Config $config)
    {
        $this->sftp = new SFTP($this->config->address, $this->config->port);
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

        if (!$this->sftp->login($this->config->username, $credential)) {
            throw new MikrotikConnectionException("Failed to connect to the router.");
        }
    }

    public function disconnect(): void
    {
        $this->sftp->disconnect();
    }

    public function getFile(string $remoteFile): string
    {
        $fileContents = $this->sftp->get($remoteFile);
        if ($fileContents === false) {
            throw new \Exception("Failed to read file {$remoteFile} from router.");
        }
        return $fileContents;
    }
}
