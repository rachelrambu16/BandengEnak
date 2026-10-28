@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FFFCF8] px-4 py-8 sm:px-6 lg:px-8"
     style="font-family: 'Poppins', sans-serif;">

    <div class="mx-auto max-w-4xl">

        {{-- Tombol kembali --}}
        <a href="{{ route('katalog') }}"
           class="mb-5 inline-flex items-center gap-3 text-sm font-semibold text-orange-600 transition hover:text-orange-700">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2.5">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M19 12H5m7 7-7-7 7-7"/>
            </svg>
            Kembali
        </a>

        {{-- Notifikasi berhasil --}}
        @if (session('success'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-5 py-3 text-sm font-medium text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Kartu profil --}}
        <div class="overflow-hidden rounded-2xl border border-orange-100 bg-white shadow-sm">

            <div class="p-6 sm:p-8 lg:p-10">

                {{-- Identitas pelanggan --}}
                <div class="flex items-center gap-5 border-b border-orange-100 pb-6">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full border border-orange-100 bg-orange-50">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-9 w-9 text-orange-600"
                             viewBox="0 0 24 24"
                             fill="currentColor">
                            <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-5 0-9 2.5-9 5.5V22h18v-2.5c0-3-4-5.5-9-5.5Z"/>
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                            {{ $pelanggan->name }}
                        </h1>
                        <p class="mt-1 text-sm text-slate-500 sm:text-base">
                            Akun pelanggan Samudera
                        </p>
                    </div>
                </div>

                {{-- Form profil (Diubah menjadi grid-cols-1 agar tersusun vertikal ke bawah) --}}
                <form action="{{ route('pelanggan.profil.update') }}"
                      method="POST"
                      class="mt-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-y-6">

                        {{-- E-mail --}}
                        <div>
                            <label for="email"
                                   class="mb-2 block text-sm font-semibold text-slate-600">
                                E-mail
                            </label>

                            <div class="relative">
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $pelanggan->email) }}"
                                       required
                                       class="w-full rounded-xl border border-slate-300 bg-white px-5 py-4 pr-12 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="pointer-events-none absolute right-4 top-1/2 h-5 w-5 -translate-y-1/2 text-orange-500"
                                     viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25ZM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83Z"/>
                                </svg>
                            </div>

                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nama lengkap --}}
                        <div>
                            <label for="name"
                                   class="mb-2 block text-sm font-semibold text-slate-600">
                                Nama Lengkap
                            </label>

                            <div class="relative">
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $pelanggan->name) }}"
                                       required
                                       class="w-full rounded-xl border border-slate-300 bg-white px-5 py-4 pr-12 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="pointer-events-none absolute right-4 top-1/2 h-5 w-5 -translate-y-1/2 text-orange-500"
                                     viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25ZM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83Z"/>
                                </svg>
                            </div>

                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password"
                                   class="mb-2 block text-sm font-semibold text-slate-600">
                                Password
                            </label>

                            <div class="relative">
                                <input type="password"
                                       id="password"
                                       name="password"
                                       minlength="8"
                                       autocomplete="new-password"
                                       placeholder="Kosongkan jika tidak diubah"
                                       class="w-full rounded-xl border border-slate-300 bg-white px-5 py-4 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-100">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="pointer-events-none absolute right-4 top-1/2 h-5 w-5 -translate-y-1/2 text-orange-500"
                                     viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25ZM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83Z"/>
                                </svg>
                            </div>

                            <p class="mt-2 text-xs text-slate-500">
                                Isi hanya jika ingin mengganti password.
                            </p>

                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label for="alamat"
                                   class="mb-2 block text-sm font-semibold text-slate-600">
                                Alamat
                            </label>

                            <div class="relative">
                                <textarea id="alamat"
                                          name="alamat"
                                          rows="3"
                                          class="w-full resize-y rounded-xl border border-slate-300 bg-white px-5 py-4 pr-12 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100">{{ old('alamat', $pelanggan->alamat ?? '') }}</textarea>

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="pointer-events-none absolute right-4 top-4 h-5 w-5 text-orange-500"
                                     viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25ZM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83Z"/>
                                </svg>
                            </div>

                            @error('alamat')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nomor telepon --}}
                        <div>
                            <label for="phone_number"
                                   class="mb-2 block text-sm font-semibold text-slate-600">
                                Nomor Telepon
                            </label>

                            <div class="relative">
                                <input type="tel"
                                       id="phone_number"
                                       name="phone_number"
                                       value="{{ old('phone_number', $pelanggan->phone_number ?? '') }}"
                                       maxlength="15"
                                       class="w-full rounded-xl border border-slate-300 bg-white px-5 py-4 pr-12 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="pointer-events-none absolute right-4 top-1/2 h-5 w-5 -translate-y-1/2 text-orange-500"
                                     viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25ZM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83Z"/>
                                </svg>
                            </div>

                            @error('phone_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Tombol simpan --}}
                    <div class="mt-10 border-t border-orange-100 pt-7">
                        <div class="flex justify-center">
                            <button type="submit"
                                    class="inline-flex w-full items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 px-8 py-4 text-sm font-bold text-white shadow-md shadow-orange-500/20 transition hover:-translate-y-0.5 hover:from-orange-600 hover:to-orange-700 hover:shadow-lg sm:w-80">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7l-4-4ZM12 19a3 3 0 1 1 0-6 3 3 0 0 1 0 6Zm3-10H5V5h10v4Z"/>
                                </svg>

                                Simpan Perubahan
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection