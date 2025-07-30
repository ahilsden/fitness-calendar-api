<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get(
    '/activities',
    [ActivityController::class, 'index']
)->name('api.activities.index');

Route::post(
    '/activities/store',
    [ActivityController::class, 'store']
)->name('api.activities.store');
