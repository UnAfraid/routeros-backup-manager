<?php

namespace App\Filament\Resources\Device\RelationManagers;

use App\Filament\Resources\ScriptBackups\ScriptBackupResource;
use App\Filament\Resources\ScriptBackups\Tables\ScriptBackupsTable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ScriptBackupsRelationManager extends RelationManager
{
    protected static string $relationship = 'scriptBackups';

    protected static ?string $relatedResource = ScriptBackupResource::class;

    public function table(Table $table): Table
    {
        return ScriptBackupsTable::configure($table);
    }

    public function isReadOnly(): bool
    {
        return false;
    }

    protected function canEdit(Model $record): bool
    {
        return false;
    }
}
