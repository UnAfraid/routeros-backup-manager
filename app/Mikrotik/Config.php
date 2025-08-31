<?php

namespace App\Mikrotik;

use App\Models\Device;
use App\Models\PasswordCredential;
use App\Models\PrivateKeyCredential;
use SensitiveParameter;

class Config
{
    public function __construct(
        public string                        $address,
        public int                           $port,
        public string                        $username,
        #[SensitiveParameter] public ?string $password = null,
        #[SensitiveParameter] public ?string $privateKey = null,
        #[SensitiveParameter] public ?string $passphrase = null,
    )
    {
    }

    public static function fromDevice(Device $device): self
    {
        $credential = $device->credential;
        $config = new self(
            address: $device->address,
            port: $device->port,
            username: $credential->username,
        );

        if ($credential instanceof PasswordCredential) {
            $config->password = $credential->password;
        } elseif ($credential instanceof PrivateKeyCredential) {
            $config->privateKey = $credential->private_key;
            $config->passphrase = $credential->passphrase;
        }

        return $config;
    }
}
