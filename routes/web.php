<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MpesaGatewayController;

// Serves the interface view panel
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth']); 

// Payment routes inside the same web file
Route::post('/mpesa/stk-push', [MpesaGatewayController::class, 'initiateStkPush']);
Route::post('/mpesa/callback', [MpesaGatewayController::class, 'processCallback']);