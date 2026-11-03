@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">
        daftar pelanggan
    </h1>
    <p class="mt-2 text-gray-500">
        informasi pelanggan yang terdaftar di toko.
    </p>
</div>


@if (session('success'))
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50
                px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif


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
                <th class="p-3 border">no</th>
                <th class="p-3 border">id pelanggan</th>
                <th class="p-3 border">nama</th>
                <th class="p-3 border">email</th>
                <th class="p-3 border">nomor telepon</th>
                <th class="p-3 border">tanggal daftar</th>
                <th class="p-3 border">status akun</th>
                <th class="p-3 border text-center">aksi</th>
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
                        {{ $item->created_at?->format('d-m-y') ?? '-' }}
                    </td>

                    
                    <td class="p-3 border">
                        @if ($item->status_akun === 'aktif')
                            <span class="inline-block rounded-full
                                         bg-green-100 px-3 py-1
                                         text-xs font-semibold text-green-700">
                                aktif
                            </span>
                        @else
                            <span class="inline-block rounded-full
                                         bg-red-100 px-3 py-1
                                         text-xs font-semibold text-red-700">
                                nonaktif
                            </span>
                      @endif
                    </td>

                    
                    <td class="p-3 border text-center">
                        @if ($item->status_akun === 'aktif')
                            <form
                                action="{{ route('admin.pelanggan.blokir', $item->id) }}"
                                method="post"
                                onsubmit="return confirm('apakah kamu yakin ingin memblokir akun pelanggan ini?')">
                                @csrf
                                @method('patch')

                                <button
                                    type="submit"
                                    class="rounded-lg bg-red-500 px-3 py-2
                                           text-xs font-semibold text-white
                                           hover:bg-red-600">
                                    blokir
                                </button>
                            </form>
                        @else
                            <form
                                action="{{ route('admin.pelanggan.aktifkan', $item->id) }}"
                                method="post"
                                onsubmit="return confirm('apakah kamu yakin ingin mengaktifkan kembali akun ini?')">
                                @csrf
                                @method('patch')

                                <button
                                    type="submit"
                                    class="rounded-lg bg-green-600 px-3 py-2
                                           text-xs font-semibold text-white
                                           hover:bg-green-700">
                                    aktifkan
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8"
                        class="px-6 py-8 text-center text-gray-500">
                        belum ada pelanggan terdaftar.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
