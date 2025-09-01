<?php

namespace App\Filament\Resources\Backups\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BackupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('device_id')
                    ->relationship('device', 'name')
                    ->required(),
                Toggle::make('success')
                    ->required(),
                Toggle::make('connection_error')
                    ->required(),
                TextInput::make('error_message'),
                DateTimePicker::make('started_at')
                    ->required(),
                DateTimePicker::make('finished_at'),
                Select::make('binary_backup_id')
                    ->relationship('binaryBackup', 'name'),
                Select::make('script_backup_id')
                    ->relationship('scriptBackup', 'name'),
            ]);
    }
}
