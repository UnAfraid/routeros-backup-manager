<?php

namespace App\Filament\Resources\Device\Actions;

use App\Jobs\CreateBackupJob;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class CreateBackupAction
{
    public static function make(string $name = 'runBackup'): Action
    {
        return Action::make($name)
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
            });
    }
}
