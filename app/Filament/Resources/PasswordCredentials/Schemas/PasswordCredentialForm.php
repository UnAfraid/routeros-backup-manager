<?php

namespace App\Filament\Resources\PasswordCredentials\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PasswordCredentialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('username')
                    ->required(),
                TextInput::make('password')
                    ->required()
                    ->password()
                    ->revealable(),
            ]);
    }
}
