
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#FFFCF8] to-orange-50/30 px-4 py-10 sm:px-6 lg:px-8"
     style="font-family: 'Poppins', sans-serif;">

    <div class="mx-auto max-w-6xl">

        {{-- Tombol Kembali ke Katalog --}}
        <a href="{{ route('katalog') }}"
           class="group mb-6 inline-flex items-center gap-2.5 text-sm font-semibold text-slate-500 transition-colors hover:text-orange-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-200 group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/>
            </svg>
            Kembali ke Katalog
        </a>

        {{-- Detail Kartu Produk --}}
        <div class="overflow-hidden rounded-3xl border border-orange-100 bg-white shadow-xl shadow-orange-500/5">
            <div class="grid grid-cols-1 md:grid-cols-2">

                {{-- Kolom Gambar Produk --}}
                <div class="flex items-center justify-center bg-slate-50/50 p-6 md:p-10 border-b md:border-b-0 md:border-r border-orange-100/60">
                    @if($product->gambar)
                        <img src="{{ asset('storage/' . $product->gambar) }}"
                             alt="{{ $product->nama_produk }}"
                             class="max-h-[450px] w-full object-contain rounded-2xl transition-transform duration-300 hover:scale-105">
                    @else
                        <div class="flex flex-col items-center justify-center py-20 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-3 h-16 w-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm font-medium">Gambar tidak tersedia</span>
                        </div>
                    @endif
                </div>

                {{-- Kolom Informasi Produk --}}
                <div class="flex flex-col justify-between p-8 sm:p-10 lg:p-12">

                    <div>
                        {{-- Nama Produk --}}
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl mb-3">
                            {{ $product->nama_produk }}
                        </h1>

                        {{-- Harga Produk --}}
                        <div class="mb-6">
                            <span class="text-2xl font-extrabold text-orange-600 sm:text-3xl">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Status Stok --}}
                        <div class="mb-6 flex items-center gap-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Stok:</span>
                            @if($product->stok > 0)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 border border-emerald-200">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                    Tersedia ({{ $product->stok }})
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 border border-red-200">
                                    <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                    Stok Habis
                                </span>
                            @endif
                        </div>

                        {{-- Deskripsi Produk --}}
                        <div class="mb-8 border-t border-slate-100 pt-6">
                            <h2 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400">
                                Deskripsi Produk
                            </h2>
                            <p class="text-sm leading-relaxed text-slate-600 whitespace-pre-line">
                                {{ $product->deskripsi ?: 'Belum ada deskripsi produk.' }}
                            </p>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="border-t border-slate-100 pt-6">
                        @auth
                            @if(auth()->user()->role === 'pelanggan')
                                @if($product->stok > 0)
                                    <form action="{{ route('keranjang.store', $product->id) }}" method="POST">
                                        @csrf

                                        {{-- Pilihan Jumlah Produk --}}
                                        <div class="mb-5">
                                            <label for="jumlah"
                                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                                Jumlah Produk
                                            </label>

                                            <div class="inline-flex items-center overflow-hidden rounded-xl border border-orange-200 bg-white">
                                                <button type="button"
                                                        onclick="ubahJumlah(-1)"
                                                        class="px-4 py-3 text-lg font-bold text-orange-600 transition hover:bg-orange-50">
                                                    −
                                                </button>

                                                <input type="number"
                                                       id="jumlah"
                                                       name="jumlah"
                                                       value="{{ old('jumlah', 1) }}"
                                                       min="1"
                                                       max="{{ $product->stok }}"
                                                       required
                                                       class="w-16 border-x border-orange-100 py-3 text-center text-sm font-semibold text-slate-800 focus:outline-none">

                                                <button type="button"
                                                        onclick="ubahJumlah(1)"
                                                        class="px-4 py-3 text-lg font-bold text-orange-600 transition hover:bg-orange-50">
                                                    +
                                                </button>
                                            </div>

                                            @error('jumlah')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Tombol Tambah ke Keranjang --}}
                                        <button type="submit"
                                                class="inline-flex w-full items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-orange-500 to-orange-600 px-8 py-4 text-sm font-bold text-white shadow-lg shadow-orange-500/25 transition-all duration-200 hover:-translate-y-0.5 hover:from-orange-600 hover:to-orange-700 hover:shadow-xl hover:shadow-orange-500/35 active:scale-[0.99]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M19 6h-2c0-2.76-2.24-5-5-5S7 3.24 7 6H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-7-3c1.66 0 3 1.34 3 3H9c0-1.66 1.34-3 3-3zm7 17H5V8h2v2c0 .55.45 1 1 1s1-.45 1-1V8h6v2c0 .55.45 1 1 1s1-.45 1-1V8h2v12z"/>
                                            </svg>
                                            Tambah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button type="button" disabled
                                            class="w-full cursor-not-allowed rounded-2xl bg-slate-200 px-8 py-4 text-sm font-bold text-slate-400">
                                        Stok Habis
                                    </button>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-flex w-full items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-orange-500 to-orange-600 px-8 py-4 text-sm font-bold text-white shadow-lg shadow-orange-500/25 transition-all duration-200 hover:-translate-y-0.5 hover:from-orange-600 hover:to-orange-700">
                                Login untuk Membeli
                            </a>
                        @endauth
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

{{-- Fungsi Tombol Tambah dan Kurang --}}
<script>
    function ubahJumlah(perubahan) {
        const input = document.getElementById('jumlah');

        if (!input) return;

        const minimum = parseInt(input.min) || 1;
        const maksimum = parseInt(input.max) || 1;
        let jumlah = parseInt(input.value) || minimum;

        jumlah += perubahan;

        if (jumlah < minimum) {
            jumlah = minimum;
        }

        if (jumlah > maksimum) {
            jumlah = maksimum;
        }

        input.value = jumlah;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('jumlah');

        if (!input) return;

        input.addEventListener('change', function () {
            const minimum = parseInt(this.min) || 1;
            const maksimum = parseInt(this.max) || 1;
            let jumlah = parseInt(this.value) || minimum;

            this.value = Math.min(
                Math.max(jumlah, minimum),
                maksimum
            );
        });
    });
</script>
@endsection
