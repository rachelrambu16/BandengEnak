<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;

class PageController extends Controller
{
    /**
     * Menampilkan halaman utama.
     */
    public function landing()
    {
        $featuredProducts = Product::take(4)->get();

        return view('welcome', compact('featuredProducts'));
    }

    /**
     * Menampilkan katalog dan mencari produk berdasarkan nama.
     * Bisa diakses tanpa login.
     */
    public function katalog(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $kataKunci = trim($request->input('search'));

            $query->where(
                'nama_produk',
                'LIKE',
                '%' . $kataKunci . '%'
            );
        }

        $products = $query->get();

        return view('katalog', compact('products'));
    }

    /**
     * Menampilkan detail produk.
     * Bisa diakses tanpa login.
     */
    public function detailProduk($id)
    {
        $product = Product::findOrFail($id);

        return view('detailProduk', compact('product'));
    }

    /**
     * Menampilkan riwayat pesanan pelanggan yang login.
     */
    public function riwayat()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $transactions = Transaction::with('details.product')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat', compact('transactions'));
    }
}
