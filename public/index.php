<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Waktu Mulai Aplikasi
|--------------------------------------------------------------------------
|
| Baris ini digunakan untuk menandai waktu mulai eksekusi aplikasi
| agar kita bisa menghitung total waktu yang dibutuhkan.
|
*/
define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Cek Mode Pemeliharaan (Maintenance Mode)
|--------------------------------------------------------------------------
|
| Jika aplikasi sedang dalam mode pemeliharaan, file ini akan dimuat
| sehingga pengguna mendapatkan tampilan pemberitahuan pemeliharaan.
|
*/
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Registrasi Autoloader Composer
|--------------------------------------------------------------------------
|
| Composer menyediakan autoloader yang dihasilkan secara otomatis untuk
| aplikasi kita. Kita hanya perlu memuatnya ke dalam script ini.
|
*/
require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Bootstrap Laravel dan Tangani Permintaan
|--------------------------------------------------------------------------
|
| Kita akan memuat framework Laravel dan menangani permintaan HTTP yang
| masuk menggunakan objek Request yang menangkap data dari server.
|
*/
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());

