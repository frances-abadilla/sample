<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StoreController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth.token')->group(function () {
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::post('auth/logout', [AuthController::class, 'logout']);

    Route::middleware('admin')->group(function () {
        Route::apiResource('stores', StoreController::class)->parameters(['stores' => 'id']);
        Route::apiResource('users', UserController::class)
            ->only(['index', 'store', 'destroy'])
            ->parameters(['users' => 'id']);
    });
});
