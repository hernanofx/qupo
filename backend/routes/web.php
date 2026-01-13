<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Health check route for smoke tests
Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

// `routes/api.php` is registered by the AppServiceProvider under the `api` middleware group to
// ensure API routes remain stateless and are not wrapped by the `web` middleware (which enforces CSRF).
// If you need to register extra web-only routes, add them here.

