<?php

namespace App\Filament\Resources\ScriptBackups\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SebastianBergmann\Diff\Differ;
use SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;

class ScriptBackupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('size')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('version')
                    ->label('Router version')
                    ->searchable(),
                TextColumn::make('device.name')
                    ->label('Device')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
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
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('compare')
                        ->label('Compare')
                        ->icon('heroicon-o-arrow-path')
                        ->modalHeading('Backup Comparison')
                        ->modalSubmitAction(false) // disable confirm button
                        ->modalCancelActionLabel('Close')
                        ->modalContent(function ($records) {
                            if ($records->count() !== 2) {
                                return view('filament.backups.diff', [
                                    'diff' => "Please select exactly 2 backups.",
                                ]);
                            }

                            [$first, $second] = $records->all();

                            $differ = new Differ(new UnifiedDiffOutputBuilder("--- First\n+++ Second\n"));
                            $diff = $differ->diff($first->content, $second->content);

                            return view('filament.backups.diff', [
                                'diff' => $diff,
                            ]);
                        }),

                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
