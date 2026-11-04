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

    public function index(Request $request)
    {
    $this->authorizeAdminOrKaryawan();

    $search = $request->input('search');

    $transactions = Transaction::with(['user', 'details.product'])
        ->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        })
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.transactions.index', compact('transactions', 'search'));
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
