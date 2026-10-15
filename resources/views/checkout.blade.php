@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-8">
        <a href="/katalog" class="hover:text-orange-600 transition">Katalog</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        <a href="/keranjang" class="hover:text-orange-600 transition">Keranjang</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        <span class="text-gray-900 font-medium">Checkout</span>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="flex-1 space-y-8">
            <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <!-- Alamat Pengiriman -->
                <section class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-orange-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange-500"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Informasi Pengiriman</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">No. Telepon / WhatsApp</label>
                            <input type="tel" name="phone" required class="w-full px-4 py-2.5 rounded-xl border border-orange-200 bg-orange-50/30 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition" placeholder="081234567890">
                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                            <textarea name="shipping_address" required rows="3" class="w-full px-4 py-2.5 rounded-xl border border-orange-200 bg-orange-50/30 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition" placeholder="Jl. Sudirman No. 123..."></textarea>
                            @error('shipping_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </section>

                <!-- Pembayaran -->
                <section class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-orange-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange-500"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Pembayaran</h2>
                    </div>

                    <div class="bg-orange-50 p-4 rounded-xl border border-orange-200 mb-6">
                        <p class="text-sm text-gray-600 mb-2">Silakan transfer sesuai total tagihan ke rekening berikut:</p>
                        <p class="font-bold text-gray-900 text-lg">BCA 1234567890</p>
                        <p class="text-sm text-gray-600">a.n. PT Bandeng Presto Samudera</p>
                    </div>

                    <div class="space-y-4">
                        <label class="text-sm font-semibold text-gray-700">Unggah Bukti Transfer</label>
                        <input type="file" name="payment_proof" accept="image/*" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                        @error('payment_proof') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </section>
            </form>
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="lg:w-96 flex-shrink-0">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-orange-100 sticky top-24">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h2>
                
                <div class="space-y-4 mb-6 max-h-64 overflow-y-auto pr-2">
                    @php $subtotal = 0; @endphp
                    @foreach($carts as $item)
                        @php $subtotal += $item->product->harga * $item->quantity; @endphp
                        <div class="flex gap-4">
                            <div class="w-16 h-16 rounded-lg bg-orange-50 relative overflow-hidden flex-shrink-0 border border-orange-100">
                                @if($item->product->gambar)
                                    <img src="{{ asset('storage/' . $item->product->gambar) }}" alt="{{ $item->product->nama_produk }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900 text-sm line-clamp-2">{{ $item->product->nama_produk }}</h3>
                                <p class="text-gray-500 text-xs mt-1">{{ $item->quantity }} x Rp {{ number_format($item->product->harga, 0, ',', '.') }}</p>
                            </div>
                            <div class="font-semibold text-gray-900 text-sm">
                                Rp {{ number_format($item->product->harga * $item->quantity, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                @php 
                    $shipping = 15000;
                    $total = $subtotal + $shipping; 
                @endphp

                <div class="space-y-3 pt-6 border-t border-orange-100 mb-6 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Biaya Pengiriman</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-900 pt-3 border-t border-orange-100">
                        <span class="font-bold text-lg">Total</span>
                        <span class="font-bold text-xl text-orange-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button form="checkout-form" type="submit" class="w-full py-4 bg-orange-500 text-white rounded-xl font-semibold text-lg hover:bg-orange-600 transition-colors shadow-lg shadow-orange-500/20">
                    Buat Pesanan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
