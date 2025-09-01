<?php

namespace App\Filament\Resources\Backups\Tables;

use App\Filament\Resources\BinaryBackups\BinaryBackupResource;
use App\Filament\Resources\Device\DeviceResource;
use App\Filament\Resources\ScriptBackups\ScriptBackupResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;

class BackupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->numeric(),
                TextColumn::make('device.name')
                    ->label('Device')
                    ->searchable()
                    ->toggleable()
                    ->url(fn($record) => DeviceResource::getUrl('view', ['record' => $record->device]))
                    ->color('warning'),
                IconColumn::make('success')
                    ->boolean()
                    ->toggleable(),
                IconColumn::make('connection_error')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('error_message')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('duration')
                    ->label('Duration')
                    ->getStateUsing(function ($record) {
                        if (!$record->started_at || !$record->finished_at) {
                            return new HtmlString('&mdash;');
                        }

                        $start = Carbon::parse($record->started_at);
                        $end = Carbon::parse($record->finished_at);

                        return $start->diffForHumans($end, true);
                    }),
                TextColumn::make('started_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('finished_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('binaryBackup.name')
                    ->label('Binary backup')
                    ->searchable()
                    ->toggleable()
                    ->url(fn($record) => BinaryBackupResource::getUrl('view', ['record' => $record->binaryBackup]))
                    ->color('warning'),
                TextColumn::make('scriptBackup.name')
                    ->label('Script backup')
                    ->searchable()
                    ->toggleable()
                    ->url(fn($record) => ScriptBackupResource::getUrl('view', ['record' => $record->scriptBackup]))
                    ->color('warning'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
