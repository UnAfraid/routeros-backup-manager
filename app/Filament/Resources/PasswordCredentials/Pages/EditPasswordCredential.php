<?php

namespace App\Filament\Resources\PasswordCredentials\Pages;

use App\Filament\Resources\PasswordCredentials\PasswordCredentialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPasswordCredential extends EditRecord
{
    protected static string $resource = PasswordCredentialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
