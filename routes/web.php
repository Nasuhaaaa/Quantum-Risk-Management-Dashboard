<?php

use App\Http\Controllers\KategoriRisikoController;
use App\Http\Controllers\RiskRegisterController;
use App\Http\Controllers\SubkategoriRisikoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/risk-register/create', [RiskRegisterController::class, 'create'])
    ->name('risk_register.create');

Route::post('/risk-register', [RiskRegisterController::class, 'store'])
    ->name('risk_register.store');

Route::get('/kategori-risiko/create', [KategoriRisikoController::class, 'create'])
    ->name('kategori_risiko.create');

Route::post('/kategori-risiko', [KategoriRisikoController::class, 'store'])
    ->name('kategori_risiko.store');

Route::get('/subkategori-risiko/create', [SubkategoriRisikoController::class, 'create'])
    ->name('subkategori_risiko.create');

Route::post('/subkategori-risiko', [SubkategoriRisikoController::class, 'store'])
    ->name('subkategori_risiko.store');

