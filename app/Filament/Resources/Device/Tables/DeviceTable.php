<?php

namespace App\Filament\Resources\Device\Tables;

use App\Jobs\CreateBackupJob;
use App\Jobs\RouterOSBackup;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeviceTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('address')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('port')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('username')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('backup_cron_schedule')
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('binary_backup_enabled')
                    ->boolean()
                    ->toggleable(),
                IconColumn::make('script_backup_enabled')
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('createdByUser.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updatedByUser.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Action::make('runBackup')
                    ->label('Run Backup')
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $recipient = auth()->user();

                        try {
                            $job = new CreateBackupJob($record);
                            $job->handle();

                            Notification::make()
                                ->title('Created backup successfully')
                                ->sendToDatabase($recipient);
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Failed to create backup')
                                ->body($e->getMessage())
                                ->danger();
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
