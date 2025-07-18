<?php

use App\Http\Controllers\StravaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/strava/auth',
    [StravaController::class, 'redirectToStrava']
)->name('web.strava.redirectToStrava');

Route::get(
    '/strava/auth/handleCallback',
    [StravaController::class, 'handleCallback']
)->name('web.strava.handleCallback');
