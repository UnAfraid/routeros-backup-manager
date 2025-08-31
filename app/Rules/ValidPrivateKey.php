<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Exception\NoKeyLoadedException;
use phpseclib3\Exception\UnableToConnectException;

class ValidPrivateKey implements ValidationRule
{
    private ?string $passphrase;

    public function __construct(?string $passphrase)
    {
        $this->passphrase = $passphrase;
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return;
        }

        try {
            PublicKeyLoader::loadPrivateKey($value, $this->passphrase ?? false);
        } catch (NoKeyLoadedException|UnableToConnectException|\RuntimeException $e) {
            $fail($e->getMessage());
        }
    }
}
