<?php

// routes/api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\{
  StoreController, ProductController, PriceEntryController, AlertController, AuthController, HealthController
};

Route::prefix('v1')->group(function () {
  Route::get('/health', HealthController::class);
  Route::post('/auth/login', [AuthController::class, 'login']);

  Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/me', fn (\Illuminate\Http\Request $r) => $r->user());

    Route::get('/stores', [StoreController::class, 'index']);
    Route::post('/stores', [StoreController::class, 'store']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);

    Route::get('/price-entries', [PriceEntryController::class, 'index']);
    Route::post('/price-entries', [PriceEntryController::class, 'store']);

    Route::get('/alerts', [AlertController::class, 'index']);
  });
});

