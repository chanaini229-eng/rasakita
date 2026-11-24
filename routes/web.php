<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RasaKita Routes - Khusus Role Pelanggan
|--------------------------------------------------------------------------
*/

// Beranda / Dashboard Pelanggan
Route::get('/', [HomeController::class, 'index'])->name('home');

// Daftar Menu (Hanya bisa melihat & memesan, tidak bisa kelola menu)
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// Informasi Toko
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');
Route::post('/kontak', [HomeController::class, 'sendContact'])->name('contact.send');

// Keranjang Pesanan (Shopping Cart)
Route::prefix('keranjang')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/tambah', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/hapus', [CartController::class, 'remove'])->name('remove');
    Route::post('/kosongkan', [CartController::class, 'clear'])->name('clear');
});

// Autentikasi Pelanggan
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/quick-login/{role}', [AuthController::class, 'quickLogin'])->name('quick.login');

// Fitur Pemesanan & Transaksi Pelanggan
Route::middleware('auth')->group(function () {
    // Checkout & Pemesanan Makanan (Aturan 4)
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('order.store');

    // Menampilkan Struk Pemesanan Diri Sendiri (Aturan 5 & 3)
    Route::get('/struk/{order}', [OrderController::class, 'receipt'])->name('order.receipt');

    // Melihat Laporan Transaksi Diri Sendiri (Aturan 2 & 3)
    Route::get('/riwayat-transaksi', [OrderController::class, 'history'])->name('order.history');

    // Aturan 1: Pembatasan Kelola Menu (Pelanggan otomatis ditolak 403 Forbidden)
    Route::prefix('kelola-menu')->name('menu.manage.')->group(function () {
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::put('/{menu}', [MenuController::class, 'update'])->name('update');
        Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
    });
});
