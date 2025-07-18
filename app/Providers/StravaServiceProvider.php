<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Strava;

class StravaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('Strava', function () {
            return new Strava(
                env('STRAVA_CLIENT_ID'),
                env('STRAVA_SECRET_ID'),
                env('STRAVA_REDIRECT_URI'),
            );
        });
    }

    public function boot(): void {}
}
