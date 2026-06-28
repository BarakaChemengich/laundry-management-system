<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MpesaGatewayController;

Route::get('/', function () {
    return view('auth.signin');
});
