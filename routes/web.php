<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramPromoController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\TagihanArController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// TRANSAKSI
Route::prefix('program-promo')->group(function () {
    Route::get('/', [ProgramPromoController::class, 'index'])->name('program.index');
    Route::post('/', [ProgramPromoController::class, 'store'])->name('program.store');
    Route::get('/{programPromo}', [ProgramPromoController::class, 'show'])->name('program.show');
    Route::patch('/{programPromo}/status', [ProgramPromoController::class, 'updateStatus'])->name('program.status');
});
Route::get('/buat-program', [ProgramPromoController::class, 'create'])->name('program.create');

Route::prefix('realisasi')->group(function () {
    Route::get('/', [RealisasiController::class, 'index'])->name('realisasi.index');
    Route::patch('/{realisasi}', [RealisasiController::class, 'update'])->name('realisasi.update');
    Route::post('/{realisasi}/verify', [RealisasiController::class, 'verify'])->name('realisasi.verify');
});

Route::prefix('tagihan-ar')->group(function () {
    Route::get('/', [TagihanArController::class, 'index'])->name('tagihan.index');
    Route::post('/generate', [TagihanArController::class, 'generateInvoice'])->name('tagihan.generate');
    Route::post('/{tagihan}/bayar', [TagihanArController::class, 'recordPayment'])->name('tagihan.bayar');
    Route::post('/{tagihan}/sync-oracle', [TagihanArController::class, 'syncOracle'])->name('tagihan.sync');
});

use App\Http\Controllers\MasterDataController;

// MASTER DATA
Route::prefix('metode-kesepakatan')->group(function () {
    Route::get('/', [MasterDataController::class, 'metodeIndex'])->name('master.metode');
    Route::post('/', [MasterDataController::class, 'metodeStore'])->name('master.metode.store');
    Route::put('/{metode}', [MasterDataController::class, 'metodeUpdate'])->name('master.metode.update');
    Route::delete('/{metode}', [MasterDataController::class, 'metodeDestroy'])->name('master.metode.destroy');
});

Route::prefix('event-promosi')->group(function () {
    Route::get('/', [MasterDataController::class, 'eventIndex'])->name('master.event');
    Route::post('/', [MasterDataController::class, 'eventStore'])->name('master.event.store');
    Route::put('/{event}', [MasterDataController::class, 'eventUpdate'])->name('master.event.update');
    Route::delete('/{event}', [MasterDataController::class, 'eventDestroy'])->name('master.event.destroy');
});

Route::prefix('sarana-promosi')->group(function () {
    Route::get('/', [MasterDataController::class, 'saranaIndex'])->name('master.sarana');
    Route::post('/', [MasterDataController::class, 'saranaStore'])->name('master.sarana.store');
    Route::put('/{sarana}', [MasterDataController::class, 'saranaUpdate'])->name('master.sarana.update');
    Route::delete('/{sarana}', [MasterDataController::class, 'saranaDestroy'])->name('master.sarana.destroy');
});

Route::prefix('supplier-ar')->group(function () {
    Route::get('/', [MasterDataController::class, 'supplierIndex'])->name('master.supplier');
    Route::post('/', [MasterDataController::class, 'supplierStore'])->name('master.supplier.store');
    Route::put('/{supplier}', [MasterDataController::class, 'supplierUpdate'])->name('master.supplier.update');
    Route::post('/{supplier}/toggle', [MasterDataController::class, 'supplierToggleAr'])->name('master.supplier.toggle');
});
