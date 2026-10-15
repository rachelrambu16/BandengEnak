<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bandeng Presto Samudera</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-orange-50/40 text-gray-900 flex font-sans" x-data="{ sidebarOpen: false }">
    
    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" style="display: none;" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm md:hidden"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed md:static inset-y-0 left-0 z-50 w-64 bg-white border-r border-orange-100 flex-shrink-0 min-h-screen flex flex-col transition-transform duration-300 ease-in-out md:translate-x-0 shadow-lg md:shadow-none">
        <div class="h-16 flex items-center justify-between px-6 border-b border-orange-100">
            <a href="/" class="flex items-center gap-2 font-bold text-lg tracking-tight text-gray-900">
                <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center text-sm text-white shadow-md shadow-orange-500/30">S</span>
                SAMUDERA
            </a>
            <button @click="sidebarOpen = false" class="md:hidden text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto py-4">
            <nav class="space-y-1 px-3">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white shadow-md shadow-orange-500/25' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    Dashboard
                </a>

                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.daftarpelanggan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.pelanggan') ? 'bg-orange-500 text-white shadow-md shadow-orange-500/25' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M20 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Daftar Pelanggan
                </a>
                @endif
                
                <a href="{{ route('admin.kelola_produk') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.kelola_produk') || request()->routeIs('admin.tambah_produk.create') || request()->routeIs('admin.edit_produk') ? 'bg-orange-500 text-white shadow-md shadow-orange-500/25' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>
                    Kelola Produk
                </a>
                
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.karyawan') : route('karyawan.profil') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.karyawan*') || request()->routeIs('karyawan.profil') ? 'bg-orange-500 text-white shadow-md' : 'text-gray-600 hover:bg-orange-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M20 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span>{{ auth()->user()->role === 'admin' ? 'Kelola Karyawan' : 'Profil Karyawan' }}</span>
                </a>

                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.transactions.*') ? 'bg-orange-500 text-white shadow-md shadow-orange-500/25' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    Verifikasi Pembayaran
                </a>

                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.sales_report') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.sales_report') ? 'bg-orange-500 text-white shadow-md shadow-orange-500/25' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                    Laporan Penjualan
                </a>
                @endif
            </nav>
        </div>
        <div class="p-4 border-t border-orange-100">
            <div class="flex items-center gap-3 mb-4 px-2">
                <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center uppercase font-bold text-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2 bg-orange-50 text-orange-600 border border-orange-200 rounded-lg text-sm font-medium hover:bg-orange-100 transition-colors flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen overflow-hidden w-full">
        <!-- Topbar mobile (Hidden on desktop) -->
        <header class="h-16 bg-white border-b border-orange-100 flex items-center justify-between px-4 md:hidden shrink-0 shadow-sm">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="p-2 -ml-2 text-gray-600 hover:bg-orange-50 rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                </button>
                <a href="/" class="flex items-center gap-2 font-bold text-lg tracking-tight">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center text-sm text-white shadow-md shadow-orange-500/30">S</span>
                </a>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm font-medium text-orange-600 hover:text-orange-700 bg-orange-50 px-3 py-1.5 rounded-md border border-orange-200">Logout</button>
            </form>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8 w-full max-w-full">
            @yield('content')
        </main>
    </div>
</body>
</html>
