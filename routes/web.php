<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard & Sub-menus
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Menu Stubs (redirect or render dashboard with active context)
Route::get('/program-promo', [DashboardController::class, 'index'])->name('program.index');
Route::get('/buat-program', [DashboardController::class, 'index'])->name('program.create');
Route::get('/realisasi', [DashboardController::class, 'index'])->name('realisasi.index');
Route::get('/tagihan-ar', [DashboardController::class, 'index'])->name('tagihan.index');

Route::get('/metode-kesepakatan', [DashboardController::class, 'index'])->name('master.metode');
Route::get('/event-promosi', [DashboardController::class, 'index'])->name('master.event');
Route::get('/sarana-promosi', [DashboardController::class, 'index'])->name('master.sarana');
Route::get('/supplier-ar', [DashboardController::class, 'index'])->name('master.supplier');
