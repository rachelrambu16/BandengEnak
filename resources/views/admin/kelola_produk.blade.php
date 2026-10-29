@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kelola Produk</h1>
        <p class="text-gray-500 text-sm mt-1">Daftar semua produk yang tersedia di katalog.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('katalog') }}" class="px-4 py-2 bg-white border border-orange-200 text-gray-700 rounded-xl text-sm font-medium hover:bg-orange-50 transition-colors shadow-sm">
            Lihat Katalog
        </a>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.tambah_produk.create') }}" class="px-4 py-2 bg-orange-500 text-white rounded-xl text-sm font-medium hover:bg-orange-600 transition-colors shadow-md shadow-orange-500/20 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Produk
            </a>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-start gap-3 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 flex-shrink-0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
@endif

<!-- FORM PENCARIAN PRODUK -->
<div class="mb-6 bg-white p-4 rounded-2xl shadow-sm border border-orange-100 flex flex-col sm:flex-row justify-between items-center gap-4">
    <form action="{{ route('admin.kelola_produk') }}" method="GET" class="flex w-full sm:w-auto flex-1 max-w-md gap-2">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </span>
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Cari nama produk atau deskripsi..." 
                class="w-full pl-10 pr-4 py-2 border border-orange-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500"
            >
        </div>
        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-xl text-sm font-medium hover:bg-orange-600 transition-colors shadow-sm">
            Cari
        </button>
        @if(request('search'))
            <a href="{{ route('admin.kelola_produk') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-200 transition-colors flex items-center justify-center">
                Reset
            </a>
        @endif
    </form>

    @if(request('search'))
        <div class="text-sm text-gray-500">
            Menampilkan hasil pencarian untuk: <span class="font-semibold text-gray-800">"{{ request('search') }}"</span>
        </div>
    @endif
</div>

<div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-orange-50/50 border-b border-orange-100 text-gray-500">
                <tr>
                    <th class="px-6 py-4 font-medium">Produk</th>
                    <th class="px-6 py-4 font-medium">Harga</th>
                    <th class="px-6 py-4 font-medium">Stok</th>
                    <th class="px-6 py-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-orange-50">
                @forelse($products as $product)
                <tr class="hover:bg-orange-50/30 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-orange-50 overflow-hidden flex-shrink-0 border border-orange-100">
                                @if($product->gambar)
                                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No img</div>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $product->nama_produk }}</p>
                                <p class="text-gray-500 text-xs truncate max-w-xs">{{ $product->deskripsi }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->stok > 10 ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-orange-50 text-orange-700 border border-orange-200' }}">
                            {{ $product->stok }} Tersedia
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.edit_produk', $product->id) }}" class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                            </a>
                            @if(auth()->user()->role === 'admin')
                                <form action="{{ route('admin.hapus_produk', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500">
                        @if(request('search'))
                            Produk dengan kata kunci <span class="font-semibold text-gray-700">"{{ request('search') }}"</span> tidak ditemukan. <a href="{{ route('admin.kelola_produk') }}" class="text-orange-600 font-medium hover:underline">Reset pencarian</a>
                        @else
                            Belum ada produk. @if(auth()->user()->role === 'admin') <a href="{{ route('admin.tambah_produk.create') }}" class="text-orange-600 font-medium hover:underline">Tambah sekarang</a> @endif
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- PAGINATION LINKS -->
    @if($products->hasPages())
        <div class="px-6 py-4 border-t border-orange-100 bg-orange-50/20">
            {{ $products->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection