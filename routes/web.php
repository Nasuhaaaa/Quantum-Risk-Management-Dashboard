<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriRisikoController;
use App\Http\Controllers\RisikoController;
use App\Http\Controllers\RiskRegisterController;
use App\Http\Controllers\SubkategoriRisikoController;
use App\Http\Controllers\KategoriPuncaRisikoController;
use App\Http\Controllers\PuncaRisikoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Entiti\PengurusanRisikoController as EntitRisikoController;
use App\Http\Controllers\Entiti\PengurusanInventoriController as EntitInventoriController;
use App\Http\Controllers\Entiti\PengurusanDataController as EntitDataController;
use App\Http\Controllers\KethuaSektor\PengurusanAgensiController as SektorAgensiController;
use App\Http\Controllers\KethuaSektor\PengurusanRisikoController as SektorRisikoController;
use App\Http\Controllers\Pengurusan\PengurusanRisikoController as PengurusanRisikoController;
use App\Http\Controllers\Admin\PengurusanPenggunaController;
use App\Http\Controllers\Admin\PengurusanEntitController;
use App\Http\Controllers\Admin\PengurusanSektorController;
use App\Http\Controllers\Admin\RujakanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Entiti\SBOM\SBOMController;
use App\Http\Controllers\Entiti\CBOM\CBOMController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

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

    // ==================== ENTITI ROUTES ====================
    Route::prefix('entiti')->name('entiti.')->group(function () {
        // Pengurusan Risiko
        Route::prefix('pengurusan-risiko')->name('pengurusan_risiko.')->group(function () {
            Route::get('/', [RiskRegisterController::class, 'index'])->name('index');
            Route::get('create', [RiskRegisterController::class, 'create'])->name('create');
            Route::post('/', [RiskRegisterController::class, 'store'])->name('store');
            Route::get('{id}', [EntitRisikoController::class, 'show'])->name('show');
            Route::get('{id}/edit', [EntitRisikoController::class, 'edit'])->name('edit');
            Route::put('{id}', [EntitRisikoController::class, 'update'])->name('update');
            Route::delete('{id}', [EntitRisikoController::class, 'destroy'])->name('destroy');
            Route::get('laporan/penilaian', [EntitRisikoController::class, 'laporanPenilaian'])->name('laporan_penilaian');
        });

        // Pengurusan Inventori
        Route::prefix('pengurusan-inventori')->name('pengurusan_inventori.')->group(function () {
            Route::get('/', [EntitInventoriController::class, 'index'])->name('index');
            Route::get('create', [EntitInventoriController::class, 'create'])->name('create');
            Route::post('/', [EntitInventoriController::class, 'store'])->name('store');
            Route::get('{id}', [EntitInventoriController::class, 'show'])->name('show');
            Route::get('{id}/edit', [EntitInventoriController::class, 'edit'])->name('edit');
            Route::put('{id}', [EntitInventoriController::class, 'update'])->name('update');
            Route::delete('{id}', [EntitInventoriController::class, 'destroy'])->name('destroy');
        });

        // SBOM Routes - Separated from pengurusan_inventori to avoid route conflicts
        Route::prefix('pengurusan-inventori/sbom')->name('pengurusan_inventori.sbom.')->group(function () {
            // ✅ ALWAYS put static routes first
            Route::get('create/{inventori_id}', [SBOMController::class, 'create'])->name('create');

            // POST route BEFORE dynamic GET route
            Route::post('{inventori_id}', [SBOMController::class, 'store'])->name('store');

            // dynamic LAST
            Route::get('{sbom_id}', [SBOMController::class, 'show'])->name('show');
        });

        // CBOM Routes - Separated from pengurusan_inventori to avoid route conflicts
        Route::prefix('pengurusan-inventori/cbom')->name('pengurusan_inventori.cbom.')->group(function () {
            // ✅ ALWAYS put static routes first
            Route::get('create/{sbom_id}', [CBOMController::class, 'create'])->name('create');

            // POST route BEFORE dynamic GET route
            Route::post('{sbom_id}', [CBOMController::class, 'store'])->name('store');

            // dynamic LAST
            Route::get('{cbom_id}', [CBOMController::class, 'show'])->name('show');
        });

        // Pengurusan Data
        Route::prefix('pengurusan-data')->name('pengurusan_data.')->group(function () {
            Route::get('/', [EntitDataController::class, 'index'])->name('index');
            Route::get('import', [EntitDataController::class, 'importForm'])->name('import_form');
            Route::post('import', [EntitDataController::class, 'import'])->name('import');
            Route::get('export', [EntitDataController::class, 'exportForm'])->name('export_form');
            Route::post('export', [EntitDataController::class, 'export'])->name('export');
        });
    });

    // ==================== KETUA SEKTOR ROUTES ====================
    Route::prefix('sektor')->name('sektor.')->group(function () {
        // Pengurusan Risiko
        Route::prefix('pengurusan-risiko')->name('pengurusan_risiko.')->group(function () {
            Route::get('/', [SektorRisikoController::class, 'index'])->name('index');
            Route::get('{id}', [SektorRisikoController::class, 'show'])->name('show');
            Route::get('laporan/penilaian', [SektorRisikoController::class, 'laporanPenilaian'])->name('laporan_penilaian');
        });

        // Pengurusan Agensi
        Route::prefix('pengurusan-agensi')->name('pengurusan_agensi.')->group(function () {
            Route::get('/', [SektorAgensiController::class, 'index'])->name('index');
            Route::get('create', [SektorAgensiController::class, 'create'])->name('create');
            Route::post('/', [SektorAgensiController::class, 'store'])->name('store');
            Route::get('{id}', [SektorAgensiController::class, 'show'])->name('show');
            Route::get('{id}/edit', [SektorAgensiController::class, 'edit'])->name('edit');
            Route::put('{id}', [SektorAgensiController::class, 'update'])->name('update');
            Route::delete('{id}', [SektorAgensiController::class, 'destroy'])->name('destroy');
        });
    });

    // ==================== PENGURUSAN ROUTES ====================
    Route::prefix('pengurusan')->name('pengurusan.')->group(function () {
        // Pengurusan Risiko
        Route::prefix('pengurusan-risiko')->name('pengurusan_risiko.')->group(function () {
            Route::get('/', [PengurusanRisikoController::class, 'index'])->name('index');
            Route::get('{id}', [PengurusanRisikoController::class, 'show'])->name('show');
            Route::get('{id}/approval', [PengurusanRisikoController::class, 'approval'])->name('approval_form');
            Route::put('{id}/approve', [PengurusanRisikoController::class, 'approve'])->name('approve');
            Route::get('laporan/penilaian', [PengurusanRisikoController::class, 'laporanPenilaian'])->name('laporan_penilaian');
        });
    });

    // ==================== ADMIN ROUTES ====================
    Route::prefix('admin')->name('admin.')->group(function () {
        // Pengurusan Pengguna
        Route::prefix('pengurusan-pengguna')->name('pengurusan_pengguna.')->group(function () {
            Route::get('/', [PengurusanPenggunaController::class, 'index'])->name('index');
            Route::get('create', [PengurusanPenggunaController::class, 'create'])->name('create');
            Route::post('/', [PengurusanPenggunaController::class, 'store'])->name('store');
            Route::get('{id}', [PengurusanPenggunaController::class, 'show'])->name('show');
            Route::get('{id}/edit', [PengurusanPenggunaController::class, 'edit'])->name('edit');
            Route::put('{id}', [PengurusanPenggunaController::class, 'update'])->name('update');
            Route::delete('{id}', [PengurusanPenggunaController::class, 'destroy'])->name('destroy');
        });

        // Pengurusan Entiti
        Route::prefix('pengurusan-entiti')->name('pengurusan_entiti.')->group(function () {
            Route::get('/', [PengurusanEntitController::class, 'index'])->name('index');
            Route::get('create', [PengurusanEntitController::class, 'create'])->name('create');
            Route::post('/', [PengurusanEntitController::class, 'store'])->name('store');
            Route::get('{id}', [PengurusanEntitController::class, 'show'])->name('show');
            Route::get('{id}/edit', [PengurusanEntitController::class, 'edit'])->name('edit');
            Route::put('{id}', [PengurusanEntitController::class, 'update'])->name('update');
            Route::delete('{id}', [PengurusanEntitController::class, 'destroy'])->name('destroy');
        });

        // Pengurusan Sektor
        Route::prefix('pengurusan-sektor')->name('pengurusan_sektor.')->group(function () {
            Route::get('/', [PengurusanSektorController::class, 'index'])->name('index');
            Route::get('create', [PengurusanSektorController::class, 'create'])->name('create');
            Route::post('/', [PengurusanSektorController::class, 'store'])->name('store');
            Route::get('{id}', [PengurusanSektorController::class, 'show'])->name('show');
            Route::get('{id}/edit', [PengurusanSektorController::class, 'edit'])->name('edit');
            Route::put('{id}', [PengurusanSektorController::class, 'update'])->name('update');
            Route::delete('{id}', [PengurusanSektorController::class, 'destroy'])->name('destroy');
        });

        // Rujukan & Sumber Sokongan
        Route::prefix('rujukan')->name('rujukan.')->group(function () {
            Route::get('/', [RujakanController::class, 'index'])->name('index');
            Route::get('bantuan', [RujakanController::class, 'bantuan'])->name('bantuan');
            Route::get('pengaturan-sistem', [RujakanController::class, 'pengaturanSistem'])->name('pengaturan_sistem');
            Route::get('log', [RujakanController::class, 'log'])->name('log');
        });
    });
});



