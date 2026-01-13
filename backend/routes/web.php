<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Health check route for smoke tests
Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

// Load api routes (some Laravel skeletons may not autoload routes/api.php)
$apiRoutes = __DIR__ . '/api.php';
if (file_exists($apiRoutes)) {
    require $apiRoutes;
}
