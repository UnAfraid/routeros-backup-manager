<?php

namespace App\Filament\Resources\Users\Filters;


use Filament\Forms\Components\Toggle;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class VerifiedFilter
{
    public static function make(): Filter
    {
        return Filter::make('verified')
            ->schema([
                Toggle::make('verified')
                    ->label('Verified'),
            ])
            ->label('Verified')
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['verified'],
                        fn(Builder $q, $verified) => $verified ? $q->whereNotNull('email_verified_at') : $q->whereNull('email_verified_at')
                    );
            });
    }
}
