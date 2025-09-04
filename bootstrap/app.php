<?php

use App\Jobs\CreateBackupJob;
use App\Models\Device;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule): void {
        if (app()->runningInConsole()) {
            return;
        }

        Device::all()->each(function (Device $device) use ($schedule) {
            $schedule
                ->job(new CreateBackupJob($device))
                ->cron($device->backup_cron_schedule)
                ->name("backup-{$device->id}");
        });
    })
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
