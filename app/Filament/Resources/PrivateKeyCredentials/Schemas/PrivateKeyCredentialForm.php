<?php

namespace App\Filament\Resources\PrivateKeyCredentials\Schemas;

use App\Rules\ValidPrivateKey;
use Filament\Forms\Components\PasswordInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PrivateKeyCredentialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('username')
                    ->required(),
                Textarea::make('private_key')
                    ->required()
                    ->rules(fn(Get $get) => new ValidPrivateKey($get('passphrase'))),
                TextInput::make('passphrase')
                    ->password()
                    ->revealable()
                    ->nullable()
                    ->live(),
            ]);
    }
}
