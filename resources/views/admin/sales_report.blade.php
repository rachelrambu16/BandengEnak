@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Laporan Penjualan</h1>
        <p class="text-gray-500 text-sm mt-1">Daftar transaksi yang telah selesai dan total pendapatan.</p>
    </div>
    
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full lg:w-auto">
        <form action="{{ route('admin.sales_report') }}" method="GET" class="flex flex-wrap items-center gap-2">
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="text-sm px-3 py-2 bg-white border border-orange-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors">
            <span class="text-gray-500 text-sm">sampai</span>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="text-sm px-3 py-2 bg-white border border-orange-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors">
            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-orange-600 transition-colors shadow-md shadow-orange-500/20">Filter</button>
            @if(request('start_date') || request('end_date'))
                <a href="{{ route('admin.sales_report') }}" class="bg-orange-50 text-orange-600 border border-orange-200 px-4 py-2 rounded-xl text-sm font-medium hover:bg-orange-100 transition-colors">Reset</a>
            @endif
        </form>

        <div class="bg-white px-5 py-3 rounded-2xl border border-orange-100 shadow-sm flex items-center gap-4 shrink-0">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pendapatan</p>
                <p class="text-xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-orange-50/50 border-b border-orange-100 text-gray-500">
                <tr>
                    <th class="px-6 py-4 font-medium">Waktu Transaksi</th>
                    <th class="px-6 py-4 font-medium">Pelanggan</th>
                    <th class="px-6 py-4 font-medium">Produk Terjual</th>
                    <th class="px-6 py-4 font-medium text-right">Total Transaksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-orange-50">
                @forelse($completedTransactions as $tx)
                <tr class="hover:bg-orange-50/30 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $tx->created_at->format('d M Y') }}<br>
                        <span class="text-xs text-gray-400 font-normal">{{ $tx->created_at->format('H:i') }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-gray-900 font-medium">{{ $tx->user->name }}</div>
                        <div class="text-gray-500 text-xs">{{ $tx->phone }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <ul class="text-gray-600 text-xs space-y-1">
                            @foreach($tx->details as $detail)
                                <li>- {{ $detail->product->nama_produk ?? 'Produk dihapus' }} ({{ $detail->quantity }}x)</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900 text-right">
                        Rp {{ number_format($tx->total_amount, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada transaksi selesai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
