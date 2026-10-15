@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center bg-orange-50/30 py-12">
    <div class="max-w-md w-full mx-auto bg-white p-8 border border-orange-100 rounded-2xl shadow-lg shadow-orange-500/5">
        <div class="text-center mb-8">
            <div class="w-14 h-14 mx-auto bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-lg shadow-orange-500/30 mb-4">S</div>
            <h2 class="text-2xl font-bold text-gray-900">Sistem Login</h2>
            <p class="text-gray-500 text-sm mt-1">Portal Akses Bandeng Presto Samudera</p>
        </div>

        <!-- Tampilkan Error Jika Login Gagal -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 p-4 mb-6 rounded-xl" role="alert">
                <p class="font-semibold text-sm mb-1">Error Otentikasi</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full border border-orange-200 rounded-xl p-3 bg-orange-50/30 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:bg-white focus:outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required class="w-full border border-orange-200 rounded-xl p-3 pr-12 bg-orange-50/30 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:bg-white focus:outline-none transition">
                    <button type="button" onclick="togglePassword()"class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-orange-600"aria-label="Tampilkan password" id="togglePasswordButton">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg"width="22" height="22" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2"stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
        </div>

            <button type="submit" 
                class="w-full bg-orange-500 text-white font-semibold py-3 px-4 rounded-xl hover:bg-orange-600 transition duration-200 shadow-lg shadow-orange-500/25 hover:shadow-xl hover:shadow-orange-500/30">
                MASUK KE SISTEM
            </button>
        </form>
        
        <div class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun? <a href="/register" class="text-orange-600 font-semibold hover:text-orange-500 hover:underline transition">Daftar di sini</a>
        </div>
    </div>
</div>
<script>
    function togglePassword() {
        var password = document.getElementById('password');
        var eyeIcon = document.getElementById('eyeIcon');
        var toggleButton = document.getElementById('togglePasswordButton');

        if (password.type === 'password') {
            password.type = 'text';

            eyeIcon.innerHTML = `
                <path d="M3 3l18 18"/>
                <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5
                c6.5 0 10 7 10 7a15.8 15.8 0 0 1-4 4.8"/>
                <path d="M6.6 6.6C3.7 8.5 2 12 2 12
                s3.5 7 10 7c1 0 1.9-.2 2.8-.5"/>
            `;

            toggleButton.setAttribute('aria-label', 'Sembunyikan password');
        } else {
            password.type = 'password';

            eyeIcon.innerHTML = `
                <path d="M2 12s3.5-7 10-7 10 7 10 7
                -3.5 7-10 7S2 12 2 12z"/>
                <circle cx="12" cy="12" r="3"/>
            `;

            toggleButton.setAttribute('aria-label', 'Tampilkan password');
        }
    }
</script>
@endsection