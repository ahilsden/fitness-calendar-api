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
