@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-orange-50/50 via-white to-white">

    <section class="relative isolate overflow-hidden bg-stone-950 pt-14 pb-24 sm:pt-20 sm:pb-32">
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none" aria-hidden="true">
            <img src="{{ asset('storage/produk/Bandeng2.png') }}" alt="" class="h-full w-full object-contain object-center opacity-60">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-stone-950/40 via-stone-950/20 to-stone-950/40 pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-stone-950/35 via-transparent to-stone-950/10 pointer-events-none"></div>
        <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-orange-500/20 blur-[60px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-1/4 w-48 h-48 rounded-full bg-amber-400/20 blur-[60px] pointer-events-none"></div>
        <div class="absolute top-10 right-1/3 w-32 h-32 rounded-full bg-amber-300/15 blur-[40px] pointer-events-none"></div>

        <div class="relative z-10 container mx-auto px-5 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 text-orange-100 text-xs font-bold uppercase tracking-widest mb-6 backdrop-blur-sm border border-white/10">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                    <line x1="3" x2="21" y1="6" y2="6"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
                Katalog Produk
            </span>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight drop-shadow-lg">
                Pilih Bandeng<br class="hidden sm:block"/> Kesukaan Kamu
            </h1>

            <p class="mt-5 text-lg text-orange-100/90 max-w-lg mx-auto">
                Semua varian presto kami ada di sini. Tinggal pilih, masukkan keranjang, selesai.
            </p>
        </div>

        {{-- Wave divider --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full" preserveAspectRatio="none">
                <path d="M0 80V30C240 70 480 0 720 30C960 60 1200 10 1440 40V80H0Z" fill="white" fill-opacity="0.07"/>
                <path d="M0 80V50C360 80 720 20 1080 50C1260 65 1380 45 1440 55V80H0Z" class="fill-orange-50/50"/>
                <path d="M0 80V60C300 85 600 45 900 65C1100 75 1300 55 1440 65V80H0Z" class="fill-white"/>
            </svg>
        </div>
    </section>

    {{-- Main Content --}}
    <div class="container mx-auto px-5 -mt-8 sm:-mt-12 relative z-10 pb-16">

        @if (session('success'))
            <div class="mb-8 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl shadow-sm max-w-2xl mx-auto animate-fade-in" role="alert">
                <div class="flex-shrink-0 w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 6 9 17l-5-5"/>
                    </svg>
                </div>
                <p class="font-medium text-sm">{{ session('success') }}</p>
            </div>
        @endif

        @if($products->count() > 0)

            {{-- Product count --}}
            <div class="flex items-center justify-between mb-8">
                <p class="text-sm text-gray-400 font-medium">
                    Menampilkan <span class="text-gray-700 font-bold">{{ $products->count() }}</span> produk
                </p>
            </div>

            {{-- Product grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">

                @foreach($products as $product)

                    <div class="group bg-white rounded-3xl border border-orange-100/80 overflow-hidden hover:shadow-2xl hover:shadow-orange-500/8 hover:-translate-y-1 transition-all duration-300 flex flex-col h-full katalog-card">

                        {{-- Image --}}
                        <div class="relative h-56 overflow-hidden bg-gradient-to-br from-orange-50 to-amber-50">

                            {{-- Foto dapat diklik menuju detail produk --}}
                            <a href="{{ route('produk.detail', $product->id) }}"
                               class="block w-full h-full"
                               aria-label="Lihat detail {{ $product->nama_produk }}">

                                @if($product->gambar)
                                    <img src="{{ asset('storage/' . $product->gambar) }}"
                                         alt="{{ $product->nama_produk }}"
                                         class="w-full h-full object-contain p-3 transition-transform duration-300 group-hover:scale-[1.02]"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-orange-200">
                                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                                            <circle cx="9" cy="9" r="2"/>
                                            <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                                        </svg>
                                        <span class="text-xs text-orange-300 font-medium">Belum ada foto</span>
                                    </div>
                                @endif

                            </a>

                            {{-- Image gradient overlay --}}
                            <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>

                            {{-- Stock badge --}}
                            <div class="absolute top-4 left-4">
                                @if($product->stok > 10)
                                    <span class="bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm border border-orange-100">
                                        Stok: {{ $product->stok }}
                                    </span>
                                @elseif($product->stok > 0)
                                    <span class="bg-amber-50/90 backdrop-blur-sm text-amber-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm border border-amber-200">
                                        Sisa {{ $product->stok }}
                                    </span>
                                @else
                                    <span class="bg-red-50/90 backdrop-blur-sm text-red-600 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm border border-red-200">
                                        Habis
                                    </span>
                                @endif
                            </div>

                        </div>

                        {{-- Content --}}
                        <div class="p-6 flex flex-col flex-grow">

                            {{-- Nama produk dapat diklik menuju detail produk --}}
                            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-orange-600 transition-colors line-clamp-1">
                                <a href="{{ route('produk.detail', $product->id) }}"
                                   class="hover:text-orange-600 transition-colors">
                                    {{ $product->nama_produk }}
                                </a>
                            </h3>

                            <p class="text-gray-400 text-sm mb-5 line-clamp-2 flex-grow leading-relaxed">
                                {{ Str::limit($product->deskripsi, 100) }}
                            </p>

                            <div class="flex items-end justify-between gap-4 pt-4 border-t border-orange-50">

                                {{-- Harga --}}
                                <div>
                                    <p class="text-xs text-gray-400 font-medium">Harga</p>
                                    <span class="text-2xl font-extrabold text-orange-600 leading-tight">
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </span>
                                </div>

                                {{-- Tombol keranjang --}}
                                @if($product->stok > 0)
                                    @auth
                                        @if(auth()->user()->role === 'pelanggan')
                                            <form action="{{ route('keranjang.store', $product->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="jumlah" value="1">
                                            <button type="submit"
                                            class="flex items-center gap-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold px-5 py-3 rounded-xl"
                                            @if($product->stok <= 0) disabled title="Stok habis" @endif>
                                            Keranjang
                                        </button>
                                    </form>       
                                     @endif
                                    @else
                                        <a href="{{ route('login') }}"
                                           class="flex items-center gap-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold px-5 py-3 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all shadow-md shadow-orange-500/20 hover:shadow-lg hover:shadow-orange-500/30 hover:scale-105 active:scale-95">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="8" cy="21" r="1"/>
                                                <circle cx="19" cy="21" r="1"/>
                                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                                            </svg>
                                            <span class="hidden sm:inline">Keranjang</span>
                                        </a>
                                    @endauth
                                @else
                                    <button type="button"
                                            disabled
                                            title="Stok habis"
                                            class="flex items-center gap-2 bg-gray-300 text-white font-semibold px-5 py-3 rounded-xl cursor-not-allowed">
                                        <span>Stok Habis</span>
                                    </button>
                                @endif

                            </div>
                        </div>
                    </div>

                @endforeach

            </div>

        @else

            {{-- Empty state --}}
            <div class="flex flex-col items-center justify-center py-24 text-center">
                <div class="w-24 h-24 rounded-full bg-orange-50 flex items-center justify-center mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-orange-300">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                        <line x1="3" x2="21" y1="6" y2="6"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Produk</h3>
                <p class="text-gray-400 text-lg max-w-sm">Produk sedang disiapkan, cek lagi nanti ya.</p>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="/admin/tambah_produk"
                           class="mt-8 inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-orange-600 hover:to-orange-700 transition-all shadow-lg shadow-orange-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 5v14"/>
                                <path d="M5 12h14"/>
                            </svg>
                            Tambah Produk Pertama
                        </a>
                    @endif
                @endauth
            </div>

        @endif
    </div>

    {{-- Admin/Karyawan back button --}}
    @auth
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'karyawan')
            <div class="flex justify-center pb-12">
                <a href="{{ route('admin.kelola_produk') }}"
                   class="inline-flex items-center gap-2 bg-white hover:bg-orange-50 text-orange-600 border border-orange-200 px-6 py-3 rounded-xl shadow-sm font-semibold transition-all hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                    Kelola Produk
                </a>
            </div>
        @endif
    @endauth

</div>

{{-- Card entrance animation --}}
<style>
    .katalog-card {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s cubic-bezier(0.16, 1, 0.3, 1), transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease, border-color 0.3s ease;
    }

    .katalog-card.visible {
        opacity: 1;
        transform: translateY(0);
    }

    @media (prefers-reduced-motion: reduce) {
        .katalog-card {
            opacity: 1;
            transform: none;
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    button:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.querySelectorAll('.katalog-card').forEach(function (c) {
            c.classList.add('visible');
        });
        return;
    }

    var cards = document.querySelectorAll('.katalog-card');

    if (!cards.length) return;

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.05,
        rootMargin: '0px 0px -20px 0px'
    });

    cards.forEach(function (card, i) {
        card.style.transitionDelay = (i % 3) * 100 + 'ms';
        observer.observe(card);
    });
});
</script>
@endsection
