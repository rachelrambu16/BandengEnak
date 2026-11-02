@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">
        Daftar Pelanggan
    </h1>
    <p class="mt-2 text-gray-500">
        Informasi pelanggan yang terdaftar di toko.
    </p>
</div>

{{-- Notifikasi berhasil --}}
@if (session('success'))
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50
                px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

{{-- Notifikasi error --}}
@if (session('error'))
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50
                px-4 py-3 text-sm text-red-700">
        {{ session('error') }}
    </div>
@endif

<div class="overflow-x-auto rounded-xl border border-orange-100
            bg-white shadow-sm">

    <table class="w-full text-left text-sm">
        <thead class="border-b border-orange-100 bg-orange-50">
            <tr>
                <th class="p-3 border">No</th>
                <th class="p-3 border">ID Pelanggan</th>
                <th class="p-3 border">Nama</th>
                <th class="p-3 border">Email</th>
                <th class="p-3 border">Nomor Telepon</th>
                <th class="p-3 border">Tanggal Daftar</th>
                <th class="p-3 border">Status Akun</th>
                <th class="p-3 border text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($pelanggan as $item)
                <tr class="hover:bg-orange-50">
                    <td class="p-3 border">
                        {{ $loop->iteration }}
                    </td>

                    <td class="p-3 border">
                        {{ $item->id }}
                    </td>

                    <td class="p-3 border">
                        {{ $item->name }}
                    </td>

                    <td class="p-3 border">
                        {{ $item->email }}
                    </td>

                    <td class="p-3 border">
                        {{ $item->phone_number ?? '-' }}
                    </td>

                    <td class="p-3 border">
                        {{ $item->created_at?->format('d-m-Y') ?? '-' }}
                    </td>

                    {{-- Status akun --}}
                    <td class="p-3 border">
                        @if ($item->status_akun === 'aktif')
                            <span class="inline-block rounded-full
                                         bg-green-100 px-3 py-1
                                         text-xs font-semibold text-green-700">
                                Aktif
                            </span>
                        @else
                            <span class="inline-block rounded-full
                                         bg-red-100 px-3 py-1
                                         text-xs font-semibold text-red-700">
                                Nonaktif
                            </span>
                        @endif
                    </td>

                    {{-- Aksi blokir / aktifkan --}}
                    <td class="p-3 border text-center">
                        @if ($item->status_akun === 'aktif')
                            <form
                                action="{{ route('admin.pelanggan.blokir', $item->id) }}"
                                method="POST"
                                onsubmit="return confirm('Apakah kamu yakin ingin memblokir akun pelanggan ini?')">
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="rounded-lg bg-red-500 px-3 py-2
                                           text-xs font-semibold text-white
                                           hover:bg-red-600">
                                    Blokir
                                </button>
                            </form>
                        @else
                            <form
                                action="{{ route('admin.pelanggan.aktifkan', $item->id) }}"
                                method="POST"
                                onsubmit="return confirm('Apakah kamu yakin ingin mengaktifkan kembali akun ini?')">
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="rounded-lg bg-green-600 px-3 py-2
                                           text-xs font-semibold text-white
                                           hover:bg-green-700">
                                    Aktifkan
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8"
                        class="px-6 py-8 text-center text-gray-500">
                        Belum ada pelanggan terdaftar.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
