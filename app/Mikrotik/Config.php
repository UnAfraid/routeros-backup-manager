<?php

namespace App\Mikrotik;

class Config
{
    public function __construct(
        public readonly string                        $address,
        public readonly int                           $port,
        public readonly string                        $username,
        #[\SensitiveParameter] public readonly string $password)
    {
    }
}
