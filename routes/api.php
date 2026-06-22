<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\MpesaController;

Route::prefix('v1/mpesa')->group(function () {
    Route::post('/stk-push', [MpesaController::class, 'initiateStkPush']);
    Route::post('/callback', [MpesaController::class, 'handleCallback']);
});