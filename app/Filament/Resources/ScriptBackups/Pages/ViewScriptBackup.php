<?php

namespace App\Filament\Resources\ScriptBackups\Pages;

use App\Filament\Resources\ScriptBackups\ScriptBackupResource;
use Filament\Resources\Pages\ViewRecord;

class ViewScriptBackup extends ViewRecord
{
    protected static string $resource = ScriptBackupResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
