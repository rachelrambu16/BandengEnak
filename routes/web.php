<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::get('/', [PageController::class, 'landing']);

// Autentikasi
Route::get('/register', [AuthController::class, 'formRegister']);
Route::post('/register', [AuthController::class, 'ProcessRegister']);

Route::get('/login', [AuthController::class, 'formLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'ProcessLogin']);

// Login Middleware Group
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Keranjang
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/{productId}', [CartController::class, 'store'])->name('keranjang.store');
    Route::patch('/keranjang/{cartId}', [CartController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{cartId}', [CartController::class, 'destroy'])->name('keranjang.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', function () {
        return view('success');
    })->name('checkout.success');

    // Katalog
    Route::get('/katalog', [PageController::class, 'katalog'])
        ->name('katalog');

    // Riwayat Pesanan
    Route::get('/riwayat', [PageController::class, 'riwayat'])
        ->name('riwayat');

    // ADMIN & KARYAWAN DASHBOARD
    Route::get('/admin/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Laporan Penjualan
    Route::get('/admin/sales-report', [\App\Http\Controllers\DashboardController::class, 'salesReport'])
        ->name('admin.sales_report');

    // Daftar Pelanggan 
    Route::get('/admin/daftarpelanggan', [AdminController::class, 'pelanggan'])
        ->name('admin.daftarpelanggan');

    // ADMIN CRUD PRODUK
    // Menampilkan semua produk (Sudah mendukung fitur pencarian & pagination)
    Route::get('/admin/kelola_produk', [AdminController::class, 'index'])
        ->name('admin.kelola_produk');
        
    // Form tambah produk
    Route::get('/admin/tambah_produk', [AdminController::class, 'create'])
        ->name('admin.tambah_produk.create');
    
    // Simpan produk
    Route::post('/admin/tambah_produk', [AdminController::class, 'store'])
        ->name('admin.tambah_produk.store');
    
    // Form edit produk
    Route::get('/admin/edit_produk/{id}', [AdminController::class, 'edit'])
        ->name('admin.edit_produk');
    
    // Update produk
    Route::put('/admin/update_produk/{id}', [AdminController::class, 'update'])
        ->name('admin.update_produk');
    
    // Hapus produk
    Route::delete('/admin/hapus_produk/{id}', [AdminController::class, 'destroy'])
        ->name('admin.hapus_produk');

    // ADMIN MANAJEMEN TRANSAKSI
    Route::get('/admin/transactions', [\App\Http\Controllers\TransactionAdminController::class, 'index'])
        ->name('admin.transactions.index');
    Route::patch('/admin/transactions/{id}/status', [\App\Http\Controllers\TransactionAdminController::class, 'updateStatus'])
        ->name('admin.transactions.update_status');

    // KELOLA KARYAWAN
    Route::get('/admin/kelola_karyawan', [AdminController::class, 'karyawan'])
        ->name('admin.karyawan');

    Route::get('/admin/tambah_karyawan', [AdminController::class, 'createKaryawan'])
        ->name('admin.karyawan.create');

    Route::post('/admin/tambah_karyawan', [AdminController::class, 'storeKaryawan'])
        ->name('admin.karyawan.store');

    Route::get('/admin/karyawan/{id}', [AdminController::class, 'showKaryawan'])
        ->name('admin.karyawan.show');

    Route::get('/admin/karyawan/{id}/edit', [AdminController::class, 'editKaryawan'])
        ->name('admin.karyawan.edit');

    Route::put('/admin/karyawan/{id}', [AdminController::class, 'updateKaryawan'])
        ->name('admin.karyawan.update');

    Route::delete('/admin/karyawan/{id}', [AdminController::class, 'destroyKaryawan'])
        ->name('admin.karyawan.destroy');

    // Profil Karyawan & Pelanggan
    Route::get('/profil-karyawan', [AdminController::class, 'profilKaryawan'])
        ->name('karyawan.profil');

    Route::get('/profil-pelanggan', [AuthController::class, 'profilPelanggan'])
        ->name('pelanggan.profil');

    Route::put('/profil-pelanggan', [AuthController::class, 'updateProfilPelanggan'])
        ->name('pelanggan.profil.update');

    Route::get('/produk/{id}', [PageController::class, 'detailProduk'])
        ->name('produk.detail');
});