<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionAdminController;


Route::get('/', [PageController::class, 'landing']);

Route::get('/katalog', [PageController::class, 'katalog'])
    ->name('katalog');

Route::get('/produk/{id}', [PageController::class, 'detailProduk'])
    ->name('produk.detail');


Route::get('/register', [AuthController::class, 'formRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'ProcessRegister']);

Route::get('/login', [AuthController::class, 'formLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'ProcessLogin']);


Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/keranjang', [CartController::class, 'index'])
        ->name('keranjang');

    Route::post('/keranjang/{productId}', [CartController::class, 'store'])
        ->name('keranjang.store');

    Route::patch('/keranjang/{cartId}', [CartController::class, 'update'])
        ->name('keranjang.update');

    Route::delete('/keranjang/{cartId}', [CartController::class, 'destroy'])
        ->name('keranjang.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout');

    Route::post('/checkout', [CheckoutController::class, 'process'])
        ->name('checkout.process');

    Route::get('/checkout/success', function () {
        return view('success');
    })->name('checkout.success');

    Route::get('/riwayat', [PageController::class, 'riwayat'])
        ->name('riwayat');

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/sales-report', [DashboardController::class, 'salesReport'])
        ->name('admin.sales_report');

    Route::get('/admin/daftarpelanggan', [AdminController::class, 'pelanggan'])
        ->name('admin.daftarpelanggan');

    Route::patch('/admin/pelanggan/{id}/blokir', [AdminController::class, 'blokirPelanggan'])
    ->name('admin.pelanggan.blokir');

    Route::patch('/admin/pelanggan/{id}/aktifkan', [AdminController::class, 'aktifkanPelanggan'])
    ->name('admin.pelanggan.aktifkan');


    Route::get('/admin/kelola_produk', [AdminController::class, 'index'])
        ->name('admin.kelola_produk');

    Route::get('/admin/tambah_produk', [AdminController::class, 'create'])
        ->name('admin.tambah_produk.create');

    Route::post('/admin/tambah_produk', [AdminController::class, 'store'])
        ->name('admin.tambah_produk.store');

    Route::get('/admin/edit_produk/{id}', [AdminController::class, 'edit'])
        ->name('admin.edit_produk');

    Route::put('/admin/update_produk/{id}', [AdminController::class, 'update'])
        ->name('admin.update_produk');

    Route::delete('/admin/hapus_produk/{id}', [AdminController::class, 'destroy'])
        ->name('admin.hapus_produk');

    Route::get('/admin/transactions', [TransactionAdminController::class, 'index'])
        ->name('admin.transactions.index');

    Route::patch('/admin/transactions/{id}/status', [TransactionAdminController::class, 'updateStatus'])
        ->name('admin.transactions.update_status');

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

    Route::get('/profil-karyawan', [AdminController::class, 'profilKaryawan'])
        ->name('karyawan.profil');

    Route::get('/profil-pelanggan', [AuthController::class, 'profilPelanggan'])
        ->name('pelanggan.profil');

    Route::put('/profil-pelanggan', [AuthController::class, 'updateProfilPelanggan'])
        ->name('pelanggan.profil.update');
});
