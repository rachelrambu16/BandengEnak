<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

/**
 * Controller ini menangani tampilan halaman umum (Landing Page & Katalog).
 */
class PageController extends Controller
{
    /**
     * Menampilkan halaman utama (Landing Page).
     */
    public function landing()
    {
        $featuredProducts = Product::take(4)->get();
        return view('welcome', compact('featuredProducts'));
    }

    /**
     * Menampilkan halaman katalog produk.
     * Mengambil semua data produk dari database untuk ditampilkan.
     */
    public function katalog()
    {
        // Mengambil seluruh data dari tabel products
        $products = Product::all();
        
    // Mengirim data produk ke view 'katalog'
        return view('katalog', compact('products'));
    }

      /**
     * Menampilkan detail produk berdasarkan ID.
     */
    public function detailProduk($id)
    {
        $product = Product::findOrFail($id);

        return view('detailProduk', compact('product'));
    }


    /**
     * Menampilkan riwayat pesanan pelanggan.
     */
    public function riwayat()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $transactions = \App\Models\Transaction::with('details.product')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('riwayat', compact('transactions'));
    }
}

