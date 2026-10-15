<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Pastikan hanya admin atau karyawan yang bisa akses
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'karyawan'])) {
            abort(403, "Anda tidak berhak mengakses halaman ini");
        }

        // Ambil statistik sederhana
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::where('status', 'selesai')->sum('total_amount');
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        
        // Transaksi terbaru
        $recentTransactions = Transaction::with(['user', 'details.product'])->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalTransactions', 
            'totalRevenue', 
            'pendingTransactions',
            'recentTransactions'
        ));
    }

    public function salesReport(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'karyawan'])) {
            abort(403, "Anda tidak berhak mengakses halaman ini");
        }

        $query = Transaction::with(['user', 'details.product'])
            ->where('status', 'selesai');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $completedTransactions = $query->orderBy('created_at', 'desc')->get();
            
        $totalRevenue = $completedTransactions->sum('total_amount');

        return view('admin.sales_report', compact('completedTransactions', 'totalRevenue'));
    }
}
