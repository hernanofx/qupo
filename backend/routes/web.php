<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Health check route for smoke tests
Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});
