<?php

namespace App\Filament\Resources\Device\RelationManagers;

use App\Filament\Resources\BinaryBackups\BinaryBackupResource;
use App\Filament\Resources\BinaryBackups\Tables\BinaryBackupsTable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class BinaryBackupsRelationManager extends RelationManager
{
    protected static string $relationship = 'binaryBackups';

    protected static ?string $relatedResource = BinaryBackupResource::class;

    public function table(Table $table): Table
    {
        return BinaryBackupsTable::configure($table);
    }
}
