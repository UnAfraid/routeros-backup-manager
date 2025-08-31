<?php

namespace App\Filament\Resources\ScriptBackups\Schemas;

use Filament\Infolists\Components\CodeEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Phiki\Grammar\Grammar;

class ScriptBackupInfolist
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
                    ])
                    ->collapsible(),
                Section::make('Device')
                    ->schema([
                        TextEntry::make('version'),
                        TextEntry::make('device.name'),
                    ])
                    ->collapsible(),
                Section::make('Content')
                    ->schema([
                        CodeEntry::make('content')
                            ->copyable()
                            ->grammar(Grammar::Txt),
                    ])
                    ->columnSpanFull()
                    ->collapsed(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
