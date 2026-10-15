@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-8">
        <a href="/katalog" class="hover:text-orange-600 transition">Katalog</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        <span class="text-gray-900 font-medium">Keranjang</span>
    </div>

    <h1 class="text-3xl font-bold text-gray-900 mb-8">Keranjang Belanja</h1>
    
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 shadow-sm">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if($carts->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
            <ul class="divide-y divide-orange-50">
                @php $subtotal = 0; @endphp
                @foreach($carts as $cart)
                    @php $subtotal += $cart->product->harga * $cart->quantity; @endphp
                    <li class="p-6 flex flex-col sm:flex-row gap-6 items-center">
                        <div class="w-24 h-24 flex-shrink-0 bg-orange-50 rounded-xl overflow-hidden relative border border-orange-100">
                            @if($cart->product->gambar)
                                <img src="{{ asset('storage/' . $cart->product->gambar) }}" alt="{{ $cart->product->nama_produk }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                            @endif
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $cart->product->nama_produk }}</h3>
                            <p class="text-orange-600 font-semibold mb-2">Rp {{ number_format($cart->product->harga, 0, ',', '.') }}</p>
                            <div class="inline-flex items-center rounded-xl border border-orange-200 bg-orange-50/50 overflow-hidden mt-1">
                                <form action="{{ route('keranjang.update', $cart->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="minus" class="px-3 py-1 text-gray-600 hover:bg-orange-100 transition-colors font-bold border-r border-orange-200">
                                        &minus;
                                    </button>
                                </form>
                                <span class="px-4 py-1 text-sm font-medium text-gray-900 bg-white">
                                    {{ $cart->quantity }}
                                </span>
                                <form action="{{ route('keranjang.update', $cart->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="plus" class="px-3 py-1 text-gray-600 hover:bg-orange-100 transition-colors font-bold border-l border-orange-200">
                                        &plus;
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 mt-4 sm:mt-0">
                            <span class="text-lg font-bold text-gray-900">Rp {{ number_format($cart->product->harga * $cart->quantity, 0, ',', '.') }}</span>
                            <form action="{{ route('keranjang.destroy', $cart->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="bg-orange-50/50 p-6 border-t border-orange-100">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-lg font-medium text-gray-600">Subtotal</span>
                    <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="/katalog" class="px-6 py-3 rounded-xl border border-orange-200 font-semibold text-gray-700 hover:bg-orange-50 transition-colors text-center">Lanjut Belanja</a>
                    <a href="{{ route('checkout') }}" class="px-8 py-3 rounded-xl bg-orange-500 text-white font-semibold hover:bg-orange-600 transition-colors shadow-lg shadow-orange-500/20 text-center">Checkout Sekarang</a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-12 text-center">
            <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6 text-orange-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Kosong</h2>
            <p class="text-gray-500 mb-8">Anda belum menambahkan produk apapun ke keranjang.</p>
            <a href="/katalog" class="inline-block bg-orange-500 text-white px-8 py-3 rounded-xl font-semibold hover:bg-orange-600 transition-colors shadow-lg shadow-orange-500/20">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection
