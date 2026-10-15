@extends('layouts.app')

@section('content')
<!-- Hero Section — Parallax Background -->
<section id="hero-parallax" class="relative isolate overflow-hidden" style="min-height: calc(100vh - 73px);">
    {{-- Parallax background image layer --}}
    <div id="parallax-bg" class="absolute inset-0 -top-[10%] -bottom-[10%] w-full" style="will-change: transform;">
        <img
            src="{{ asset('images/hero_bandeng.png') }}"
            alt=""
            aria-hidden="true"
            class="h-full w-full object-cover"
            loading="eager"
        >
    </div>

    {{-- Gradient overlay for text readability --}}
    <div class="absolute inset-0 bg-gradient-to-r from-gray-950/80 via-gray-900/60 to-gray-900/30"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-gray-950/70 via-transparent to-gray-950/20"></div>

    {{-- Decorative blurred orbs --}}
    <div class="absolute -left-20 top-1/4 h-72 w-72 rounded-full bg-orange-500/15 blur-[100px] pointer-events-none"></div>
    <div class="absolute right-0 bottom-0 h-96 w-96 rounded-full bg-orange-400/10 blur-[120px] pointer-events-none"></div>

    {{-- Content --}}
    <div class="relative z-10 mx-auto flex min-h-[calc(100vh-73px)] max-w-7xl items-center px-5 py-16 sm:px-6 lg:px-8 lg:py-24">
        <div class="max-w-2xl" id="hero-content">
            <span class="inline-flex items-center gap-2 py-2 px-5 rounded-full bg-white/10 text-orange-300 font-semibold tracking-wider text-xs mb-8 border border-white/15 uppercase backdrop-blur-md shadow-lg shadow-black/5">
                <span class="block h-1.5 w-1.5 rounded-full bg-orange-400 animate-pulse"></span>
                Samudera - Yogyakarta
            </span>

            <h1 class="text-5xl font-extrabold leading-[1.08] tracking-tight text-white sm:text-6xl lg:text-7xl drop-shadow-lg">
                Bandeng Presto<br class="hidden sm:block"/> Tanpa Duri,
                <span class="block mt-2 text-transparent bg-clip-text bg-gradient-to-r from-orange-300 via-orange-400 to-amber-300">
                    Tinggal Lahap.
                </span>
            </h1>

            <p class="mt-7 max-w-xl text-lg leading-8 text-gray-200/90 font-normal">
                Ikan segar dari tambak sendiri, dipresto sampai tulang lunak, dibumbui pas. Pesan hari ini, besok sudah sampai di meja makan.
            </p>

            <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                @auth
                    <a href="/katalog" class="group px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-full font-semibold text-lg hover:from-orange-600 hover:to-orange-700 transition-all shadow-lg shadow-orange-600/30 hover:shadow-xl hover:shadow-orange-600/40 hover:scale-105 flex items-center justify-center gap-2">
                        Lihat Menu
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-1"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                @else
                    <a href="/register" class="group px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-full font-semibold text-lg hover:from-orange-600 hover:to-orange-700 transition-all shadow-lg shadow-orange-600/30 hover:shadow-xl hover:shadow-orange-600/40 hover:scale-105 flex items-center justify-center gap-2">
                        Pesan Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-1"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                    <a href="/login" class="px-8 py-4 bg-white/10 backdrop-blur-md border-2 border-white/20 text-white rounded-full font-semibold text-lg hover:bg-white/20 hover:border-white/30 transition-all shadow-sm flex items-center justify-center gap-2">
                        Masuk
                    </a>
                @endauth
            </div>

            {{-- Presto badge --}}
            <div class="mt-12 inline-flex items-center gap-4 rounded-2xl bg-white/10 backdrop-blur-lg p-4 pr-6 border border-white/15 shadow-2xl shadow-black/10">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-orange-400 to-orange-600 shadow-md shadow-orange-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-orange-300">Presto Hari Ini</p>
                    <p class="text-sm font-semibold text-white/90">Baru matang, langsung bisa dikirim.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2 text-white/50">
        <span class="text-xs font-medium tracking-widest uppercase">Scroll</span>
        <div class="h-10 w-6 rounded-full border-2 border-white/30 flex justify-center pt-2">
            <div class="h-2 w-1 rounded-full bg-white/60 animate-bounce"></div>
        </div>
    </div>
</section>

{{-- Parallax scroll script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) return;

    const hero = document.getElementById('hero-parallax');
    const bg = document.getElementById('parallax-bg');
    const content = document.getElementById('hero-content');

    if (!hero || !bg) return;

    let ticking = false;
    function onScroll() {
        if (!ticking) {
            window.requestAnimationFrame(function () {
                const rect = hero.getBoundingClientRect();
                if (rect.bottom > 0 && rect.top < window.innerHeight) {
                    const scrolled = -rect.top;
                    const fraction = scrolled / hero.offsetHeight;
                    bg.style.transform = 'translateY(' + (fraction * 12) + '%)';
                    if (content) {
                        const opacity = Math.max(0, 1 - fraction * 0.8);
                        const yShift = fraction * -30;
                        content.style.transform = 'translateY(' + yShift + 'px)';
                        content.style.opacity = opacity;
                    }
                }
                ticking = false;
            });
            ticking = true;
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
});
</script>

<!-- Stats Strip -->
<section class="relative z-20 -mt-1">
    <div class="mx-auto max-w-5xl px-5 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-0 rounded-2xl bg-white shadow-xl shadow-orange-900/5 border border-orange-100 overflow-hidden reveal-on-scroll">
            <div class="p-6 sm:p-8 text-center border-r border-b md:border-b-0 border-orange-100">
                <p class="text-3xl sm:text-4xl font-extrabold text-orange-600">14+</p>
                <p class="mt-1 text-sm text-gray-500 font-medium">Tahun Pengalaman</p>
            </div>
            <div class="p-6 sm:p-8 text-center border-b md:border-b-0 md:border-r border-orange-100">
                <p class="text-3xl sm:text-4xl font-extrabold text-orange-600">5rb+</p>
                <p class="mt-1 text-sm text-gray-500 font-medium">Pesanan Terkirim</p>
            </div>
            <div class="p-6 sm:p-8 text-center border-r border-orange-100">
                <p class="text-3xl sm:text-4xl font-extrabold text-orange-600">100%</p>
                <p class="mt-1 text-sm text-gray-500 font-medium">Ikan Segar</p>
            </div>
            <div class="p-6 sm:p-8 text-center">
                <p class="text-3xl sm:text-4xl font-extrabold text-orange-600">⭐ 4.9</p>
                <p class="mt-1 text-sm text-gray-500 font-medium">Rating Pelanggan</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-24 bg-gradient-to-b from-white via-orange-50/40 to-white relative overflow-hidden">
    {{-- Decorative bg --}}
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-orange-100/40 blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full bg-amber-100/30 blur-[100px] pointer-events-none"></div>

    <div class="container mx-auto px-5 relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-16 reveal-on-scroll">
            <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 text-orange-700 text-xs font-bold uppercase tracking-widest mb-4">Kenapa Samudera?</span>
            <h2 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight">Beda dari bandeng biasa</h2>
            <p class="mt-4 text-lg text-gray-500">Bukan cuma presto. Dari tambak sampai packing, semua kami pegang sendiri.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            {{-- Card 1 --}}
            <div class="group relative bg-white p-8 rounded-3xl border border-orange-100 hover:border-orange-200 hover:shadow-2xl hover:shadow-orange-500/10 transition-all duration-300 reveal-on-scroll">
                <div class="absolute top-6 right-6 text-6xl font-black text-orange-50 group-hover:text-orange-100/80 transition-colors select-none leading-none">01</div>
                <div class="relative">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-orange-500/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Ikan Pilihan</h3>
                    <p class="text-gray-500 leading-relaxed">Bandeng dari tambak langsung, bukan stok freezer berminggu-minggu. Dipilih satu-satu sebelum masuk presto.</p>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="group relative bg-white p-8 rounded-3xl border border-orange-100 hover:border-orange-200 hover:shadow-2xl hover:shadow-orange-500/10 transition-all duration-300 reveal-on-scroll">
                <div class="absolute top-6 right-6 text-6xl font-black text-orange-50 group-hover:text-orange-100/80 transition-colors select-none leading-none">02</div>
                <div class="relative">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-orange-500/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Sampai Cepat</h3>
                    <p class="text-gray-500 leading-relaxed">Pesan sebelum jam 2 siang, sore sudah dijemput kurir. Area Semarang dan sekitarnya bisa same day.</p>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="group relative bg-white p-8 rounded-3xl border border-orange-100 hover:border-orange-200 hover:shadow-2xl hover:shadow-orange-500/10 transition-all duration-300 reveal-on-scroll">
                <div class="absolute top-6 right-6 text-6xl font-black text-orange-50 group-hover:text-orange-100/80 transition-colors select-none leading-none">03</div>
                <div class="relative">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-orange-500/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Bayar Gampang</h3>
                    <p class="text-gray-500 leading-relaxed">Transfer biasa, konfirmasi, selesai. Nggak ribet, nggak perlu aplikasi tambahan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-24 bg-white relative">
    <div class="container mx-auto px-5 max-w-7xl">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-14 gap-4 reveal-on-scroll">
            <div>
                <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 text-orange-700 text-xs font-bold uppercase tracking-widest mb-4">Best Seller</span>
                <h2 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight">Yang Paling Laris</h2>
                <p class="mt-3 text-lg text-gray-500">Ini yang paling sering dipesan ulang sama pelanggan.</p>
            </div>
            <a href="/katalog" class="hidden sm:inline-flex items-center gap-2 px-6 py-3 rounded-full bg-orange-50 text-orange-600 font-semibold hover:bg-orange-100 transition-colors border border-orange-200">
                Lihat Semua
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-7">
            @if(isset($featuredProducts) && $featuredProducts->count() > 0)
                @foreach($featuredProducts as $product)
                    <div class="group relative rounded-3xl bg-white border border-orange-100 shadow-sm hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full reveal-on-scroll">
                        <div class="relative h-64 overflow-hidden bg-gradient-to-br from-orange-50 to-amber-50">
                            @if($product->gambar)
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-orange-200"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                </div>
                            @endif
                            {{-- Gradient fade at bottom of image --}}
                            <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm border border-orange-100">
                                    Stok: {{ $product->stok }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                                <a href="/katalog" class="hover:text-orange-600 transition-colors">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ $product->nama_produk }}
                                </a>
                            </h3>
                            <p class="text-gray-500 text-sm mb-4 line-clamp-2 flex-grow">{{ $product->deskripsi }}</p>
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-orange-50">
                                <span class="text-xl font-extrabold text-orange-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                <span class="text-xs font-semibold text-orange-400 bg-orange-50 px-3 py-1.5 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300">Pesan →</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                    <div class="w-20 h-20 rounded-full bg-orange-50 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-orange-300"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    </div>
                    <p class="text-lg text-gray-500 font-medium">Produk sedang disiapkan</p>
                    <p class="text-sm text-gray-400 mt-1">Cek lagi nanti ya.</p>
                </div>
            @endif
        </div>

        <div class="mt-10 sm:hidden text-center">
            <a href="/katalog" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-orange-50 text-orange-600 font-semibold hover:bg-orange-100 transition-colors border border-orange-200">
                Lihat Semua Produk
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- CTA Banner -->
<section class="relative overflow-hidden">
    <div class="mx-auto max-w-7xl px-5 py-20 sm:px-6 lg:px-8">
        <div class="relative rounded-[2rem] bg-gradient-to-br from-orange-500 via-orange-600 to-amber-600 px-8 py-16 sm:px-16 sm:py-20 overflow-hidden reveal-on-scroll">
            {{-- Decorative circles --}}
            <div class="absolute -top-10 -right-10 w-48 h-48 rounded-full bg-white/10 pointer-events-none"></div>
            <div class="absolute -bottom-12 -left-12 w-64 h-64 rounded-full bg-white/5 pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full bg-orange-400/20 blur-[100px] pointer-events-none"></div>

            <div class="relative z-10 text-center max-w-2xl mx-auto">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
                    Mau coba langsung?
                </h2>
                <p class="mt-5 text-lg text-orange-100 max-w-lg mx-auto">
                    Tinggal pilih varian, checkout, dan tunggu di rumah. Nggak perlu ke pasar.
                </p>
                <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                    @auth
                        <a href="/katalog" class="group px-8 py-4 bg-white text-orange-600 rounded-full font-bold text-lg hover:bg-orange-50 transition-all shadow-xl shadow-orange-900/20 flex items-center justify-center gap-2">
                            Lihat Katalog
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-1"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    @else
                        <a href="/register" class="group px-8 py-4 bg-white text-orange-600 rounded-full font-bold text-lg hover:bg-orange-50 transition-all shadow-xl shadow-orange-900/20 flex items-center justify-center gap-2">
                            Daftar & Pesan
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-1"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="border-t border-orange-100 bg-gray-50">
    <div class="mx-auto max-w-7xl px-5 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <span class="grid size-10 place-items-center rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 text-sm font-black text-white shadow-md shadow-orange-500/30">S</span>
                <div>
                    <p class="font-bold text-gray-900">Bandeng Presto Samudera</p>
                    <p class="text-sm text-gray-400">Semarang, Jawa Tengah</p>
                </div>
            </div>
            <p class="text-sm text-gray-400">&copy; {{ date('Y') }} Samudera. Hak cipta dilindungi.</p>
        </div>
    </div>
</footer>

{{-- Scroll-reveal animation (IntersectionObserver — no library) --}}
<style>
    .reveal-on-scroll {
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .reveal-on-scroll.revealed {
        opacity: 1;
        transform: translateY(0);
    }
    @media (prefers-reduced-motion: reduce) {
        .reveal-on-scroll {
            opacity: 1;
            transform: none;
            transition: none;
        }
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    var els = document.querySelectorAll('.reveal-on-scroll');
    if (!els.length) return;
    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    els.forEach(function (el, i) {
        el.style.transitionDelay = (i % 4) * 80 + 'ms';
        observer.observe(el);
    });
});
</script>
@endsection
