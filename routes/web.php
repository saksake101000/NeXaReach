<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard routes
Route::get('/dashboard', [KatalogController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Tentang Kami section on Dashboard
Route::get('/dashboard#tentangkami', [KatalogController::class, 'tentangKami'])->name('dashboard#tentangkami');

// Katalog routes
Route::get('/dashboard#katalog', [KatalogController::class, 'katalog'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard#katalog');

// Detail katalog dengan ID
Route::get('/katalog/{id}', [KatalogController::class, 'detail'])
    ->middleware(['auth', 'verified'])
    ->name('katalog.detail');

// Transaksi routes
Route::post('/transaksi/store', [TransaksiController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('transaksi.store');

Route::get('/transaksi', [TransaksiController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('transaksi.index');

// Route untuk pembayaran
Route::post('/payment/{transaksi}', [PaymentController::class, 'bayar'])->name('payment.bayar');


// Route untuk callback dari Midtrans
Route::post('/payment/callback', [PaymentController::class, 'callback'])
    ->name('payment.callback');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
