<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;

Route::post(
    '/auth/login',
    [AuthController::class, 'login']
)->name('api.login');

Route::post(
    'logout',
    [AuthController::class, 'logout']
)->name('api.logout');

Route::post(
    '/auth/register',
    [AuthController::class, 'register']
)->name('api.register');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get(
        'activities',
        [ActivityController::class, 'index']
    )->name('api.activities.index');
});

Route::post(
    '/activities/store',
    [ActivityController::class, 'store']
)->name('api.activities.store');
