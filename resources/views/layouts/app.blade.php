<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandeng Presto Samudera</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-white text-gray-900 antialiased font-sans">
    <nav class="sticky top-0 z-50 border-b border-orange-100 bg-white/90 backdrop-blur-md shadow-sm" x-data="{ open: false }">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 sm:px-6 lg:px-8">
            <a href="/" class="flex items-center gap-3 text-lg font-extrabold tracking-tight text-gray-900">
                <span class="grid size-10 place-items-center rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 text-sm font-black text-white shadow-md shadow-orange-500/30">S</span>
                <span>SAMUDERA</span>
            </a>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-2 text-sm font-semibold">
                @auth
                    <a href="/katalog" class="rounded-full px-4 py-2 text-gray-600 transition hover:bg-orange-50 hover:text-orange-600">Katalog</a>
                    <a href="/keranjang" class="rounded-full px-4 py-2 text-gray-600 transition hover:bg-orange-50 hover:text-orange-600">Keranjang</a>
                    <a href="/riwayat" class="rounded-full px-4 py-2 text-gray-600 transition hover:bg-orange-50 hover:text-orange-600">Riwayat</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="rounded-full bg-orange-500 px-5 py-2.5 text-white shadow-md shadow-orange-500/25 transition hover:bg-orange-600 hover:shadow-lg hover:shadow-orange-500/30">Logout</button>
                    </form>
                @else
                    <a href="/katalog" class="rounded-full px-4 py-2 text-gray-600 transition hover:bg-orange-50 hover:text-orange-600">Katalog</a>
                    <a href="/login" class="rounded-full px-4 py-2 text-gray-600 transition hover:bg-orange-50 hover:text-orange-600">Login</a>
                    <a href="/register" class="rounded-full bg-orange-500 px-5 py-2.5 text-white shadow-md shadow-orange-500/25 transition hover:bg-orange-600 hover:shadow-lg hover:shadow-orange-500/30">Daftar</a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button @click="open = !open" class="md:hidden p-2 text-gray-600 hover:bg-orange-50 rounded-lg transition">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                <svg x-show="open" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="open" style="display: none;" class="md:hidden border-t border-orange-100 bg-white px-5 py-4 space-y-3 font-semibold text-sm">
            @auth
                <a href="/katalog" class="block py-2 text-gray-600 hover:text-orange-600 transition">Katalog</a>
                <a href="/keranjang" class="block py-2 text-gray-600 hover:text-orange-600 transition">Keranjang</a>
                <a href="/riwayat" class="block py-2 text-gray-600 hover:text-orange-600 transition">Riwayat</a>
                <form action="{{ route('logout') }}" method="POST" class="block mt-2">
                    @csrf
                    <button type="submit" class="w-full rounded-lg bg-orange-500 px-5 py-3 text-white text-center shadow-md shadow-orange-500/25 hover:bg-orange-600 transition">Logout</button>
                </form>
            @else
                <a href="/katalog" class="block py-2 text-gray-600 hover:text-orange-600 transition">Katalog</a>
                <a href="/login" class="block py-2 text-gray-600 hover:text-orange-600 transition">Login</a>
                <a href="/register" class="block w-full rounded-lg bg-orange-500 px-5 py-3 text-white text-center shadow-md shadow-orange-500/25 hover:bg-orange-600 transition mt-2">Daftar</a>
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
