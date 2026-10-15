@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-500 text-sm mt-1">Ringkasan aktivitas dan performa toko Anda.</p>
</div>

<!-- Statistik Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-orange-100 flex flex-col justify-center hover:shadow-md hover:shadow-orange-500/5 transition-shadow">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Total Produk</p>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $totalProducts }}</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-orange-100 flex flex-col justify-center hover:shadow-md hover:shadow-orange-500/5 transition-shadow">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Total Transaksi</p>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $totalTransactions }}</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-orange-100 flex flex-col justify-center hover:shadow-md hover:shadow-orange-500/5 transition-shadow">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 rounded-xl bg-green-50 text-green-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Pendapatan</p>
        </div>
        <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-orange-100 flex flex-col justify-center hover:shadow-md hover:shadow-orange-500/5 transition-shadow">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 rounded-xl bg-yellow-50 text-yellow-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Pesanan Pending</p>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $pendingTransactions }}</p>
    </div>
</div>

<!-- Pesanan Terbaru -->
<div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
    <div class="p-6 border-b border-orange-100 flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-900">Pesanan Terbaru</h2>
        <a href="{{ route('admin.transactions.index') }}" class="text-sm font-semibold text-orange-600 hover:text-orange-500 transition">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-orange-50/50 border-b border-orange-100 text-gray-500">
                <tr>
                    <th class="px-6 py-4 font-medium">ID Pesanan</th>
                    <th class="px-6 py-4 font-medium">Pelanggan</th>
                    <th class="px-6 py-4 font-medium">Produk</th>
                    <th class="px-6 py-4 font-medium">Total Harga</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-orange-50">
                @forelse($recentTransactions as $tx)
                <tr class="hover:bg-orange-50/30 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900">#{{ str_pad($tx->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4">{{ $tx->user->name }}</td>
                    <td class="px-6 py-4">
                        <ul class="text-gray-600 text-xs space-y-1">
                            @foreach($tx->details as $detail)
                                <li>- {{ $detail->product->nama_produk ?? 'Produk dihapus' }} ({{ $detail->quantity }}x)</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @if($tx->status === 'pending')
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-200">Pending</span>
                        @elseif($tx->status === 'diproses')
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">Diproses</span>
                        @elseif($tx->status === 'selesai')
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">Selesai</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">{{ $tx->status }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $tx->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada pesanan terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
