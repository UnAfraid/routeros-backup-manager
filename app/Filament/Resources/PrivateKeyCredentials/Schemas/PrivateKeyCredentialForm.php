<?php

namespace App\Filament\Resources\PrivateKeyCredentials\Schemas;

use Filament\Forms\Components\PasswordInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                    ->required(),
                TextInput::make('passphrase')
                    ->password()
                    ->revealable()
                    ->nullable(),
            ]);
    }
}
