@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#FFFCF8] to-orange-50/30 px-4 py-10 sm:px-6 lg:px-8"
     style="font-family: 'Poppins', sans-serif;">

    <div class="mx-auto max-w-3xl">

        {{-- Notifikasi Berhasil --}}
        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800 shadow-sm transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-emerald-600" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2a10 10 0 1 0 10 10 10 10 0 0 0-10-10Zm-1 14.59L6.41 12l1.41-1.41L11 13.17l5.59-5.58L18 9Z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Kartu Profil Utama --}}
        <div class="overflow-hidden rounded-3xl border border-orange-100 bg-white shadow-xl shadow-orange-500/5">

            <div class="p-8 sm:p-10 lg:p-12">

                {{-- Header Identitas Pelanggan --}}
                <div class="flex items-center gap-5 border-b border-orange-100/80 pb-8">

                    <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-orange-100 text-orange-600 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-orange-600" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-5 0-9 2.5-9 5.5V22h18v-2.5c0-3-4-5.5-9-5.5Z"/>
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            {{ $pelanggan->name }}
                        </h1>
                        <p class="mt-1 text-sm font-medium text-slate-400">
                            Akun Pelanggan Samudera
                        </p>
                    </div>
                </div>

                {{-- Form Profil --}}
                <form action="{{ route('pelanggan.profil.update') }}"
                      method="POST"
                      class="mt-8 space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- E-mail --}}
                    <div>
                        <label for="email" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                            E-mail
                        </label>

                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email', $pelanggan->email) }}"
                               required
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-5 py-4 text-sm font-medium text-slate-800 outline-none transition-all duration-200 focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">

                        @error('email')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                            Nama Lengkap
                        </label>

                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name', $pelanggan->name) }}"
                               required
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-5 py-4 text-sm font-medium text-slate-800 outline-none transition-all duration-200 focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">

                        @error('name')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                            Password
                        </label>

                        <input type="password"
                               id="password"
                               name="password"
                               minlength="8"
                               autocomplete="new-password"
                               placeholder="Kosongkan jika tidak diubah"
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-5 py-4 text-sm font-medium text-slate-800 outline-none transition-all duration-200 placeholder:text-slate-400 focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">

                        <p class="mt-2 text-xs text-slate-400">
                            * Isi hanya jika ingin mengganti password baru.
                        </p>

                        @error('password')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                            Alamat
                        </label>

                        <textarea id="alamat"
                                  name="alamat"
                                  rows="3"
                                  class="w-full resize-y rounded-2xl border border-slate-200 bg-slate-50/50 px-5 py-4 text-sm font-medium text-slate-800 outline-none transition-all duration-200 focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">{{ old('alamat', $pelanggan->alamat ?? '') }}</textarea>

                        @error('alamat')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor Telepon --}}
                    <div>
                        <label for="phone_number" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                            Nomor Telepon
                        </label>

                        <input type="tel"
                               id="phone_number"
                               name="phone_number"
                               value="{{ old('phone_number', $pelanggan->phone_number ?? '') }}"
                               maxlength="15"
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-5 py-4 text-sm font-medium text-slate-800 outline-none transition-all duration-200 focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-100">

                        @error('phone_number')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Navigasi Bawah (Kembali & Simpan) --}}
                    <div class="mt-10 flex flex-col-reverse items-center justify-between gap-4 border-t border-orange-100/80 pt-8 sm:flex-row">

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('katalog') }}"
                           class="group inline-flex items-center gap-2.5 text-sm font-semibold text-slate-500 transition-colors hover:text-orange-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-200 group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/>
                            </svg>
                            Kembali ke Katalog
                        </a>

                        {{-- Tombol Simpan Perubahan --}}
                        <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-orange-500 to-orange-600 px-8 py-4 text-sm font-bold text-white shadow-lg shadow-orange-500/25 transition-all duration-200 hover:-translate-y-0.5 hover:from-orange-600 hover:to-orange-700 hover:shadow-xl hover:shadow-orange-500/35 sm:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7l-4-4ZM12 19a3 3 0 1 1 0-6 3 3 0 0 1 0 6Zm3-10H5V5h10v4Z"/>
                            </svg>
                            Simpan Perubahan
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
