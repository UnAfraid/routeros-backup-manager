<?php

namespace App\Filament\Resources\BinaryBackups\Pages;

use App\Filament\Resources\BinaryBackups\BinaryBackupResource;
use Filament\Resources\Pages\ViewRecord;

class ViewBinaryBackup extends ViewRecord
{
    protected static string $resource = BinaryBackupResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
