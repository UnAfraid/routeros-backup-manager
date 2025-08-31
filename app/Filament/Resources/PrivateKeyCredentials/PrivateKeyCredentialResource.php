<?php

namespace App\Filament\Resources\PrivateKeyCredentials;

use App\Filament\Resources\PrivateKeyCredentials\Pages\CreatePrivateKeyCredential;
use App\Filament\Resources\PrivateKeyCredentials\Pages\EditPrivateKeyCredential;
use App\Filament\Resources\PrivateKeyCredentials\Pages\ListPrivateKeyCredentials;
use App\Filament\Resources\PrivateKeyCredentials\Schemas\PrivateKeyCredentialForm;
use App\Filament\Resources\PrivateKeyCredentials\Tables\PrivateKeyCredentialsTable;
use App\Models\PrivateKeyCredential;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PrivateKeyCredentialResource extends Resource
{
    protected static ?string $model = PrivateKeyCredential::class;

    protected static string | UnitEnum | null $navigationGroup = 'Credentials';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedKey;

    public static function form(Schema $schema): Schema
    {
        return PrivateKeyCredentialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrivateKeyCredentialsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPrivateKeyCredentials::route('/'),
            'create' => CreatePrivateKeyCredential::route('/create'),
            'edit' => EditPrivateKeyCredential::route('/{record}/edit'),
        ];
    }
}
