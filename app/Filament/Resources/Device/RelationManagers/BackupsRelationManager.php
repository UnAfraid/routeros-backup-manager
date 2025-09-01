<?php

namespace App\Filament\Resources\Device\RelationManagers;

use App\Filament\Resources\Backups\BackupResource;
use App\Filament\Resources\Backups\Tables\BackupsTable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BackupsRelationManager extends RelationManager
{
    protected static string $relationship = 'backups';

    protected static ?string $relatedResource = BackupResource::class;

    public function table(Table $table): Table
    {
        return BackupsTable::configure($table);
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
