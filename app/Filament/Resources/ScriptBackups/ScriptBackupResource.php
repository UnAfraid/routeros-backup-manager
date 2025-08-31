<?php

namespace App\Filament\Resources\ScriptBackups;

use App\Filament\Resources\ScriptBackups\Pages\CreateScriptBackup;
use App\Filament\Resources\ScriptBackups\Pages\EditScriptBackup;
use App\Filament\Resources\ScriptBackups\Pages\ListScriptBackups;
use App\Filament\Resources\ScriptBackups\Pages\ViewScriptBackup;
use App\Filament\Resources\ScriptBackups\Schemas\ScriptBackupForm;
use App\Filament\Resources\ScriptBackups\Schemas\ScriptBackupInfolist;
use App\Filament\Resources\ScriptBackups\Tables\ScriptBackupsTable;
use App\Models\ScriptBackup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ScriptBackupResource extends Resource
{
    protected static ?string $model = ScriptBackup::class;
    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCodeBracket;

    public static function infolist(Schema $schema): Schema
    {
        return ScriptBackupInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ScriptBackupsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListScriptBackups::route('/'),
            'view' => ViewScriptBackup::route('/{record}'),
        ];
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
