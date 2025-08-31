<?php

namespace App\Filament\Resources\Device\RelationManagers;

use App\Filament\Resources\BinaryBackups\BinaryBackupResource;
use App\Filament\Resources\BinaryBackups\Tables\BinaryBackupsTable;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BinaryBackupsRelationManager extends RelationManager
{
    protected static string $relationship = 'binaryBackups';

    protected static ?string $relatedResource = BinaryBackupResource::class;

    public function table(Table $table): Table
    {
        return BinaryBackupsTable::configure($table);
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
