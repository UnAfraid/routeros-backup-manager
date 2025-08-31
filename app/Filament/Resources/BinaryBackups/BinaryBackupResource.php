<?php

namespace App\Filament\Resources\BinaryBackups;

use App\Filament\Resources\BinaryBackups\Pages\CreateBinaryBackup;
use App\Filament\Resources\BinaryBackups\Pages\EditBinaryBackup;
use App\Filament\Resources\BinaryBackups\Pages\ListBinaryBackups;
use App\Filament\Resources\BinaryBackups\Pages\ViewBinaryBackup;
use App\Filament\Resources\BinaryBackups\Schemas\BinaryBackupForm;
use App\Filament\Resources\BinaryBackups\Schemas\BinaryBackupInfolist;
use App\Filament\Resources\BinaryBackups\Tables\BinaryBackupsTable;
use App\Models\BinaryBackup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BinaryBackupResource extends Resource
{
    protected static ?string $model = BinaryBackup::class;
    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocument;

    public static function infolist(Schema $schema): Schema
    {
        return BinaryBackupInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BinaryBackupsTable::configure($table);
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
            'index' => ListBinaryBackups::route('/'),
            'view' => ViewBinaryBackup::route('/{record}'),
        ];
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
