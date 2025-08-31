<?php

namespace App\Filament\Resources\BinaryBackups\Pages;

use App\Filament\Resources\BinaryBackups\BinaryBackupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBinaryBackups extends ListRecords
{
    protected static string $resource = BinaryBackupResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
