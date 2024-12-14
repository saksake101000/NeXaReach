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
Route::get('/dashboard#katalog', [KatalogController::class, 'katalog'])->name('dashboard#katalog');
Route::get('/katalog/{id}', [KatalogController::class, 'detail'])
    ->middleware(['auth', 'verified'])
    ->name('katalog.detail');

// Transaksi routes
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');

// Route untuk menampilkan form checkout dan proses pembayaran
Route::get('/transaksi/{id}/checkout', [TransaksiController::class, 'checkout'])->name('transaksi.checkout');

// Route untuk menyimpan transaksi baru dan menghasilkan Snap Token
Route::post('/transaksi.store', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::post('transaksi/callback', [TransaksiController::class, 'handleMidtransCallback'])->name('transaksi.callback');


// Profile routes with authentication middleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';