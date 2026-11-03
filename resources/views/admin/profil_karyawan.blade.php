@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">profil karyawan</h1>
        <p class="text-sm text-gray-500 mt-1">
            informasi lengkap akun karyawan.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-6">
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-orange-100">
            <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="32" height="32" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor"
                     stroke-width="1.8" stroke-linecap="round"
                     stroke-linejoin="round" class="text-orange-600">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>

            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    {{ $karyawan->name }}
                </h2>
                <p class="text-sm text-gray-500">karyawan</p>
            </div>
        </div>

        <div class="space-y-5">
            <div>
                <p class="text-sm text-gray-500 mb-1">id karyawan</p>
                <p class="font-medium text-gray-900">{{ $karyawan->id }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-1">nama lengkap</p>
                <p class="font-medium text-gray-900">{{ $karyawan->name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-1">email</p>
                <p class="font-medium text-gray-900">{{ $karyawan->email }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-1">nomor telepon</p>
                <p class="font-medium text-gray-900">
                    {{ $karyawan->phone_number ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-1">alamat</p>
                <p class="font-medium text-gray-900">
                    {{ $karyawan->alamat ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-1">tanggal daftar</p>
                <p class="font-medium text-gray-900">
                    {{ $karyawan->created_at?->format('d-m-y') ?? '-' }}
                </p>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 mt-8 pt-6 border-t border-orange-100">
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.karyawan') }}"
            class="px-4 py-2 bg-white border border-orange-200 text-gray-700 rounded-xl text-sm font-medium hover:bg-orange-50 transition-colors">
            kembali
        </a>
        @endif

            <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}"
               class="px-4 py-2 bg-orange-500 text-white rounded-xl text-sm font-medium hover:bg-orange-600 transition-colors">
                edit profil
            </a>
        </div>
    </div>
</div>
@endsection