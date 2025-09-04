<?php

use App\Jobs\CreateBackupJob;
use App\Models\Device;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule): void {
        try {
            Device::all()->each(function (Device $device) use ($schedule) {
                $schedule
                    ->job(new CreateBackupJob($device))
                    ->cron($device->backup_cron_schedule)
                    ->name("backup-{$device->id}");
            });
        } catch (\Exception $e) {
            // During composer install, the database is not yet ready.
            Log::warning("Failed to register device schedule", ["error" => $e->getMessage()]);
        }
    })
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
