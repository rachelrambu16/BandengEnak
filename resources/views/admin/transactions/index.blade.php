@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Daftar Pesanan</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola dan perbarui status pesanan pelanggan.</p>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-start gap-3 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 flex-shrink-0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-orange-50/50 border-b border-orange-100 text-gray-500">
                <tr>
                    <th class="px-6 py-4 font-medium">ID Pesanan</th>
                    <th class="px-6 py-4 font-medium">Pelanggan</th>
                    <th class="px-6 py-4 font-medium">Produk</th>
                    <th class="px-6 py-4 font-medium">Kontak & Pengiriman</th>
                    <th class="px-6 py-4 font-medium">Bukti Bayar</th>
                    <th class="px-6 py-4 font-medium">Total Harga</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-orange-50">
                @forelse($transactions as $tx)
                <tr class="hover:bg-orange-50/30 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900">#{{ str_pad($tx->id, 5, '0', STR_PAD_LEFT) }}<br><span class="text-xs text-gray-400 font-normal">{{ $tx->created_at->format('d M Y H:i') }}</span></td>
                    <td class="px-6 py-4">{{ $tx->user->name }}</td>
                    <td class="px-6 py-4">
                        <ul class="text-gray-600 text-xs space-y-1">
                            @foreach($tx->details as $detail)
                                <li>- {{ $detail->product->nama_produk ?? 'Produk dihapus' }} ({{ $detail->quantity }}x)</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-gray-900">{{ $tx->phone }}</div>
                        <div class="text-gray-500 text-xs truncate max-w-[200px]" title="{{ $tx->shipping_address }}">{{ $tx->shipping_address }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($tx->payment_proof)
                            <a href="{{ asset('storage/' . $tx->payment_proof) }}" target="_blank" class="text-orange-600 hover:text-orange-500 hover:underline text-xs flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><circle cx="10" cy="13" r="2"/><path d="m16 17-2-2"/></svg>
                                Lihat Bukti
                            </a>
                        @else
                            <span class="text-gray-400 text-xs">Belum ada</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">
                        Rp {{ number_format($tx->total_amount, 0, ',', '.') }}
                    </td>
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
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('admin.transactions.update_status', $tx->id) }}" method="POST" class="flex items-center justify-end gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="text-xs border-orange-200 rounded-xl py-1.5 pl-2 pr-6 focus:ring-orange-500 focus:border-orange-500 bg-orange-50/30">
                                <option value="pending" {{ $tx->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="diproses" {{ $tx->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $tx->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $tx->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            <button type="submit" class="px-3 py-1.5 bg-orange-500 text-white rounded-xl text-xs font-medium hover:bg-orange-600 transition-colors shadow-sm">Update</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada pesanan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
