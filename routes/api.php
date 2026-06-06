<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\CustomerOrderController;

Route::prefix('v1')->group(function (): void {
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::get('/catalog/medicines', [CatalogController::class, 'medicines']);
    Route::get('/catalog/medicines/{medicine}', [CatalogController::class, 'medicine']);
    Route::get('/catalog/pharmacies', [CatalogController::class, 'pharmacies']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::get('/orders', [CustomerOrderController::class, 'index']);
        Route::post('/orders', [CustomerOrderController::class, 'store']);
        Route::get('/orders/{order}', [CustomerOrderController::class, 'show']);
    });
});
