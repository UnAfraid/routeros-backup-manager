<?php

namespace App\Filament\Resources\PrivateKeyCredentials\Pages;

use App\Filament\Resources\PrivateKeyCredentials\PrivateKeyCredentialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPrivateKeyCredential extends EditRecord
{
    protected static string $resource = PrivateKeyCredentialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
