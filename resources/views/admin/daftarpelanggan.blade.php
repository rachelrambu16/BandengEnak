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

    <div class="overflow-x-auto rounded-xl border border-orange-100 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-orange-100 bg-orange-50">
                <tr>
                    <th class="p-3 border">No</th>
                    <th class="p-3 border">ID Pelanggan</th>
                    <th class="p-3 border">Nama</th>
                    <th class="p-3 border">Email</th>
                    <th class="p-3 border">Nomor Telepon</th>
                    <th class="p-3 border">Tanggal Daftar</th>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"
                            class="px-6 py-8 text-center text-gray-500">
                            Belum ada pelanggan terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
