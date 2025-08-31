<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Storage;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Storage::disk('local')->buildTemporaryUrlsUsing(function ($path, $expiration, $options) {
            return URL::temporarySignedRoute(
                'backup.download',
                $expiration,
                array_merge($options, ['path' => $path])
            );
        });
    }
}
