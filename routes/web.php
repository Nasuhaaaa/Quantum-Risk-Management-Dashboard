<?php

use App\Http\Controllers\KategoriRisikoController;
use App\Http\Controllers\RisikoController;
use App\Http\Controllers\RiskRegisterController;
use App\Http\Controllers\SubkategoriRisikoController;
use App\Http\Controllers\KategoriPuncaRisikoController;
use App\Http\Controllers\PuncaRisikoController;
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

Route::get('/risiko/create', [RisikoController::class, 'create'])
    ->name('risiko.create');

Route::post('/risiko', [RisikoController::class, 'store'])
    ->name('risiko.store');

Route::get('/kategori-punca-risiko/create', [KategoriPuncaRisikoController::class, 'create'])
    ->name('kategori_punca_risiko.create');

Route::post('/kategori-punca-risiko', [KategoriPuncaRisikoController::class, 'store'])
    ->name('kategori_punca_risiko.store');

Route::get('/punca-risiko/create', [PuncaRisikoController::class, 'create'])
    ->name('punca_risiko.create');

Route::post('/punca-risiko', [PuncaRisikoController::class, 'store'])
    ->name('punca_risiko.store');


