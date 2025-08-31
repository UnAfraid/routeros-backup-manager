<?php

namespace App\Filament\Resources\PasswordCredentials;

use App\Filament\Resources\PasswordCredentials\Pages\CreatePasswordCredential;
use App\Filament\Resources\PasswordCredentials\Pages\EditPasswordCredential;
use App\Filament\Resources\PasswordCredentials\Pages\ListPasswordCredentials;
use App\Filament\Resources\PasswordCredentials\Schemas\PasswordCredentialForm;
use App\Filament\Resources\PasswordCredentials\Tables\PasswordCredentialsTable;
use App\Models\PasswordCredential;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PasswordCredentialResource extends Resource
{
    protected static ?string $model = PasswordCredential::class;

    protected static string | UnitEnum | null $navigationGroup = 'Credentials';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedKey;

    public static function form(Schema $schema): Schema
    {
        return PasswordCredentialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PasswordCredentialsTable::configure($table);
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
            'index' => ListPasswordCredentials::route('/'),
            'create' => CreatePasswordCredential::route('/create'),
            'edit' => EditPasswordCredential::route('/{record}/edit'),
        ];
    }
}
