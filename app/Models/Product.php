<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Model Product merepresentasikan tabel 'products' di database.
 */
class Product extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment).
     * Ini melindungi database dari input yang tidak diinginkan.
     */
    protected $fillable = [
        'nama_produk', // Nama barang yang dijual
        'deskripsi',   // Penjelasan detail produk
        'harga',       // Harga barang (numeric)
        'stok',        // Jumlah ketersediaan barang
        'gambar'       // Path/lokasi file gambar produk
    ];
}

