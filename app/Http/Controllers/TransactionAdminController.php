<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionAdminController extends Controller
{
    private function authorizeAdminOrKaryawan()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'karyawan'])) {
            abort(403, "Anda tidak berhak mengakses halaman ini");
        }
    }

    public function index()
    {
        $this->authorizeAdminOrKaryawan();
        
        $transactions = Transaction::with(['user', 'details.product'])->orderBy('created_at', 'desc')->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function updateStatus(Request $request, $id)
    {
        $this->authorizeAdminOrKaryawan();

        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,dibatalkan'
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => $request->status]);

        return redirect()->route('admin.transactions.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
