@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Riwayat Pesanan</h1>
            <p class="mt-2 text-gray-600">Pantau status pesanan dan riwayat belanja Anda di Bandeng Presto Samudera.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl border border-green-200 bg-green-50 text-green-700 flex gap-3 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if($transactions->isEmpty())
            <div class="bg-white rounded-2xl border border-orange-100 p-12 text-center shadow-sm">
                <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6 text-orange-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada pesanan</h3>
                <p class="text-gray-500 mb-8">Anda belum pernah melakukan pemesanan. Yuk, mulai belanja!</p>
                <a href="{{ route('katalog') }}" class="inline-flex justify-center rounded-full bg-orange-500 px-8 py-3 text-sm font-semibold text-white shadow-md shadow-orange-500/25 hover:bg-orange-600 transition-colors">
                    Lihat Katalog Produk
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($transactions as $tx)
                <div class="bg-white rounded-2xl border border-orange-100 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    
                    <!-- Header -->
                    <div class="bg-orange-50/50 border-b border-orange-100 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Tanggal Transaksi</p>
                            <p class="text-gray-900 font-bold">{{ $tx->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            @if($tx->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs font-bold uppercase tracking-wider border border-yellow-200 shadow-sm">Menunggu Konfirmasi</span>
                            @elseif($tx->status === 'diproses')
                                <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold uppercase tracking-wider border border-blue-200 shadow-sm">Sedang Diproses</span>
                            @elseif($tx->status === 'selesai')
                                <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold uppercase tracking-wider border border-green-200 shadow-sm">Selesai</span>
                            @else
                                <span class="px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-bold uppercase tracking-wider border border-red-200 shadow-sm">Dibatalkan</span>
                            @endif
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row gap-8">
                            
                            <!-- Items list -->
                            <div class="flex-1 space-y-4">
                                <h4 class="font-bold text-gray-900 mb-3 border-b border-orange-100 pb-2">Daftar Produk</h4>
                                @foreach($tx->details as $detail)
                                <div class="flex gap-4 items-center">
                                    <div class="w-16 h-16 rounded-lg bg-orange-50 border border-orange-100 overflow-hidden flex-shrink-0">
                                        @if($detail->product && $detail->product->gambar)
                                            <img src="{{ asset('storage/' . $detail->product->gambar) }}" alt="{{ $detail->product->nama_produk }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-gray-900 text-sm md:text-base">{{ $detail->product->nama_produk ?? 'Produk Tidak Tersedia' }}</h5>
                                        <p class="text-sm text-gray-500">{{ $detail->quantity }} x Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="font-bold text-gray-900">
                                        Rp {{ number_format($detail->quantity * $detail->price, 0, ',', '.') }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <!-- Summary & Payment details -->
                            <div class="w-full md:w-64 flex flex-col justify-between bg-orange-50/50 p-4 rounded-xl border border-orange-100">
                                <div>
                                    <h4 class="font-bold text-sm uppercase tracking-wider text-gray-500 mb-2">Total Belanja</h4>
                                    <p class="text-2xl font-bold text-orange-600 mb-6">Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</p>
                                    
                                    <div class="space-y-3 mb-6">
                                        <div>
                                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Bukti Pembayaran</p>
                                            @if($tx->payment_proof)
                                                <a href="{{ asset('storage/' . $tx->payment_proof) }}" target="_blank" class="text-sm font-medium text-orange-600 hover:text-orange-700 underline flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                                    Lihat Bukti
                                                </a>
                                            @else
                                                <span class="text-sm text-red-500 italic">Belum diunggah</span>
                                            @endif
                                        </div>
                                        
                                        <div>
                                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Catatan</p>
                                            <p class="text-sm text-gray-700 italic">{{ $tx->notes ?: '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($tx->status === 'selesai')
                                    <a href="{{ route('katalog') }}" class="w-full text-center rounded-xl bg-orange-500 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-orange-500/20 hover:bg-orange-600 transition-colors">
                                        Pesan Lagi
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
