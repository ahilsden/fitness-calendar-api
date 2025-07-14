<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Strava;
use GuzzleHttp\Client;

class StravaServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton('Strava', function () {
            $client = new Client();

            return new Strava(
                $client,
                env('STRAVA_CLIENT_ID'),
                env('STRAVA_SECRET_ID'),
                env('STRAVA_REDIRECT_URI'),
            );
        });
    }

    public function boot(): void {}
}
