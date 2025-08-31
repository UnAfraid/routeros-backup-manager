<?php

namespace App\Filament\Resources\Device\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DeviceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Login')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('address'),
                        TextEntry::make('port')
                            ->numeric(),
                        TextEntry::make('username'),
                    ]),
                Section::make('Backup')
                    ->schema([
                        TextEntry::make('backup_cron_schedule')
                            ->badge(),
                        IconEntry::make('binary_backup_enabled')
                            ->boolean(),
                        IconEntry::make('script_backup_enabled')
                            ->boolean(),
                    ]),
                TextEntry::make('createdByUser.name')
                    ->label('Created By'),
                TextEntry::make('updatedByUser.name')
                    ->label('Updated By'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
