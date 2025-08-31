<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rules\Password;

class UserForm
{

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->required()
                            ->unique(ignoreRecord: true),
                        'password' => TextInput::make('password')
                            ->label('New Password')
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->rule(Password::default())
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                        TextInput::make('new_password_confirmation')
                            ->label('Confirm New Password')
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->rule('required', fn($get) => !!$get('new_password'))
                            ->same('password')
                            ->dehydrated(false),
                    ])->columnSpan(8),
                Grid::make()
                    ->schema([
                        TextEntry::make('created_at')
                            ->state(fn($record) => $record?->created_at?->diffForHumans() ?? new HtmlString('&mdash;')),
                        TextEntry::make('updated_at')
                            ->state(fn($record) => $record?->updated_at?->diffForHumans() ?? new HtmlString('&mdash;')),
                    ])
                    ->columnSpanFull()
                    ->hiddenOn('create'),
            ]);
    }
}
