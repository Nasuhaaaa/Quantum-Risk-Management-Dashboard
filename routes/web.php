<?php

use App\Http\Controllers\RiskRegisterController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/risk-register/create', [RiskRegisterController::class, 'create'])
    ->name('risk_register.create');

Route::post('/risk-register', [RiskRegisterController::class, 'store'])
    ->name('risk_register.store');
