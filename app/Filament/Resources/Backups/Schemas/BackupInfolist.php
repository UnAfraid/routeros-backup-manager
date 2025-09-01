<?php

namespace App\Filament\Resources\Backups\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BackupInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('device.name'),
                IconEntry::make('success')
                    ->boolean(),
                IconEntry::make('connection_error')
                    ->boolean(),
                TextEntry::make('error_message'),
                TextEntry::make('started_at')
                    ->dateTime(),
                TextEntry::make('finished_at')
                    ->dateTime(),
                TextEntry::make('binaryBackup.name'),
                TextEntry::make('scriptBackup.name'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
