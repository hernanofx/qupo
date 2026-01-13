<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MerchantController;
use App\Http\Controllers\Api\PaymentsController;

Route::prefix('api/v1')->group(function () {
    // Auth (throttled)
    Route::post('/merchant/register', [AuthController::class, 'registerMerchant'])->middleware('throttle:10,1');
    Route::post('/merchant/login', [AuthController::class, 'login'])->middleware('throttle:10,1');

    // Protected
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', function (Request $request) {
            return $request->user();
        });

        // Merchant CRUD (owner only)
        Route::apiResource('merchants', MerchantController::class);

        // Bookings
        Route::post('/bookings', [\App\Http\Controllers\Api\BookingController::class, 'store']);

        // Payments
        Route::post('/payments/checkout', [PaymentsController::class, 'checkout']);
    });

    // Webhook (no auth)
    Route::post('/payments/webhook', [\App\Http\Controllers\Api\PaymentsController::class, 'webhook']);
});
