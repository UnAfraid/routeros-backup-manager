<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Device\DeviceResource;
use App\Filament\Resources\Users\UserResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class CreatedDevicesRelationManager extends RelationManager
{
    protected static string $relationship = 'createdDevices';

    protected static ?string $relatedResource = UserResource::class;

    public function table(Table $table): Table
    {
        return DeviceResource::table($table);
    }
}
