<?php

namespace App\Filament\Resources\BinaryBackups\Schemas;

use Carbon\Carbon;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Storage;

class BinaryBackupInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Metadata')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('hash'),
                        TextEntry::make('size')
                            ->numeric(),
                    ]),
                Section::make('Device')
                    ->schema([
                        TextEntry::make('version'),
                        TextEntry::make('device.name'),
                    ]),
                Section::make('Content')
                    ->schema([
                        TextEntry::make('path')
                            ->url(fn($record) => $record->path
                                ? secure_url(Storage::disk('local')->temporaryUrl($record->path, Carbon::now()->addSeconds(30)))
                                : null)
                            ->icon('heroicon-o-arrow-down-tray')
                            ->openUrlInNewTab(),
                    ])
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
