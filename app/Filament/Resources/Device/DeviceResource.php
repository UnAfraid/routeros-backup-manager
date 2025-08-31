<?php

namespace App\Filament\Resources\Device;

use App\Filament\Resources\Device\Pages\CreateDevice;
use App\Filament\Resources\Device\Pages\EditDevice;
use App\Filament\Resources\Device\Pages\ListDevice;
use App\Filament\Resources\Device\Pages\ViewDevice;
use App\Filament\Resources\Device\RelationManagers\BinaryBackupsRelationManager;
use App\Filament\Resources\Device\RelationManagers\ScriptBackupsRelationManager;
use App\Filament\Resources\Device\Schemas\DeviceForm;
use App\Filament\Resources\Device\Schemas\DeviceInfolist;
use App\Filament\Resources\Device\Tables\DeviceTable;
use App\Models\Device;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWifi;

    public static function form(Schema $schema): Schema
    {
        return DeviceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DeviceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeviceTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            BinaryBackupsRelationManager::class,
            ScriptBackupsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDevice::route('/'),
            'create' => CreateDevice::route('/create'),
            'view' => ViewDevice::route('/{record}'),
            'edit' => EditDevice::route('/{record}/edit'),
        ];
    }
}
