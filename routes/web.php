<?php

use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\AdminPosController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Kasir\KasirDashboardController;
use App\Http\Controllers\Kasir\KasirMenuController;
use App\Http\Controllers\Kasir\KasirOrderController;
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

// Fitur Pemesanan & Transaksi Pelanggan + Profil Diri Sendiri
Route::middleware('auth')->group(function () {
    // Edit Profil Diri Sendiri (Berlaku untuk Pelanggan & Kasir)
    Route::get('/profil', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

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

/*
|--------------------------------------------------------------------------
| RasaKita Routes - Khusus Role Kasir
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:kasir,admin'])->prefix('kasir')->name('kasir.')->group(function () {
    // Dashboard Kasir
    Route::get('/dashboard', [KasirDashboardController::class, 'index'])->name('dashboard');

    // Daftar Menu (Kelola Menu: Tambah, Edit, Hapus)
    Route::resource('menu', KasirMenuController::class)->except(['show']);

    // Mode Kasir / Pemesanan Langsung (POS)
    Route::get('/pos', [AdminPosController::class, 'index'])->name('pos.index');
    Route::post('/pos/pesan', [AdminPosController::class, 'store'])->name('pos.store');

    // Konfirmasi Pesanan Mandiri dari Pelanggan
    Route::get('/pesanan', [KasirOrderController::class, 'konfirmasiIndex'])->name('pesanan.index');
    Route::patch('/pesanan/{order}/status', [KasirOrderController::class, 'updateStatus'])->name('pesanan.status');

    // Laporan Transaksi & Struk Semua Pengguna
    Route::get('/laporan', [KasirOrderController::class, 'laporan'])->name('laporan.index');
    Route::get('/struk/{order}', [KasirOrderController::class, 'struk'])->name('struk');

    // Aturan Kasir 1: Pembatasan ubah identitas pengguna (403 Forbidden)
    Route::match(['get', 'put', 'patch', 'delete'], '/pengguna/{id?}', [KasirOrderController::class, 'blokirKelolaPengguna'])->name('pengguna.blocked');
});

/*
|--------------------------------------------------------------------------
| RasaKita Routes - Khusus Role Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Kelola Menu (Tambah, Edit, Hapus)
    Route::resource('menus', AdminMenuController::class)->except(['show']);

    // Mode Kasir Admin
    Route::get('/kasir', [AdminPosController::class, 'index'])->name('pos.index');
    Route::post('/kasir/pesan', [AdminPosController::class, 'store'])->name('pos.store');

    // Laporan Transaksi Tiap Pelanggan
    Route::get('/laporan-transaksi', [AdminReportController::class, 'index'])->name('reports.index');

    // Kelola Pengguna & Role
    Route::get('/pengguna', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/pengguna/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.role');
    Route::post('/pengguna', [AdminUserController::class, 'store'])->name('users.store');
});