<?php

namespace App\Filament\Resources\PasswordCredentials\Pages;

use App\Filament\Resources\PasswordCredentials\PasswordCredentialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPasswordCredentials extends ListRecords
{
    protected static string $resource = PasswordCredentialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
