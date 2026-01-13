<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MerchantController;
use App\Http\Controllers\Api\PaymentsController;

Route::prefix('api/v1')->group(function () {
    // Auth
    Route::post('/merchant/register', [AuthController::class, 'registerMerchant']);
    Route::post('/merchant/login', [AuthController::class, 'login']);

    // Protected
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', function (Request $request) {
            return $request->user();
        });

        // Merchant CRUD (owner only)
        Route::apiResource('merchants', MerchantController::class);

        // Payments
        Route::post('/payments/checkout', [PaymentsController::class, 'checkout']);
    });
});
