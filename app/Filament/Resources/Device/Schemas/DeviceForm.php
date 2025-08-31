<?php

namespace App\Filament\Resources\Device\Schemas;

use App\Models\PasswordCredential;
use App\Models\PrivateKeyCredential;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class DeviceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Login')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->default('Mikrotik Router'),
                        TextInput::make('address')
                            ->required()
                            ->default('192.168.89.1'),
                        TextInput::make('port')
                            ->required()
                            ->numeric()
                            ->default(22),
                        MorphToSelect::make('credential')
                            ->types([
                                MorphToSelect\Type::make(PasswordCredential::class)->titleAttribute('name'),
                                MorphToSelect\Type::make(PrivateKeyCredential::class)->titleAttribute('name'),
                            ])
                            ->required()
                            ->preload()
                            ->searchable(),
                    ]),
                Section::make('Backup')->schema([
                    TextInput::make('backup_cron_schedule')
                        ->required()
                        ->default('0 0 * * *'),
                    Toggle::make('binary_backup_enabled')
                        ->required(),
                    Toggle::make('script_backup_enabled')
                        ->required(),
                ]),
                Select::make('created_by_user_id')
                    ->relationship('createdByUser', 'name')
                    ->disabled()
                    ->default(Auth::id())
                    ->label('Updated By')
                    ->required(),
                Select::make('updated_by_user_id')
                    ->relationship('updatedByUser', 'name')
                    ->disabled()
                    ->default(Auth::id())
                    ->label('Updated By')
                    ->required(),
            ]);
    }
}
