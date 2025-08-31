<?php

namespace App\Filament\Resources\PrivateKeyCredentials\Pages;

use App\Filament\Resources\PrivateKeyCredentials\PrivateKeyCredentialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPrivateKeyCredentials extends ListRecords
{
    protected static string $resource = PrivateKeyCredentialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
