@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kelola Karyawan</h1>
        <p class="text-gray-500 text-sm mt-1">
            Daftar akun karyawan yang terdaftar di toko.
        </p>
    </div>

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.karyawan.create') }}"
           class="px-4 py-2 bg-orange-500 text-white rounded-xl text-sm font-medium hover:bg-orange-600 transition-colors shadow-md">
            + Tambah Karyawan
        </a>
    @endif
</div>

@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[1000px] text-left text-sm">
            <thead class="bg-orange-50/50 border-b border-orange-100 text-gray-500">
                <tr>
                    <th class="px-5 py-4 font-medium text-center w-20">ID Karyawan</th>
                    <th class="px-5 py-4 font-medium">Nama</th>
                    <th class="px-5 py-4 font-medium">Email</th>
                    <th class="px-5 py-4 font-medium">Nomor Telepon</th>
                    <th class="px-5 py-4 font-medium">Alamat</th>
                    <th class="px-5 py-4 font-medium text-center w-32">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-orange-50">
                @forelse($karyawan as $item)
                    <tr class="hover:bg-orange-50/30 transition-colors">
                        <td class="px-5 py-4 text-center text-gray-600">
                            {{ $item->id }}
                        </td>

                        <td class="px-5 py-4 font-semibold text-gray-900">
                            {{ $item->name }}
                        </td>

                        <td class="px-5 py-4 text-gray-600">
                            {{ $item->email }}
                        </td>

                        <td class="px-5 py-4 text-gray-600">
                            {{ $item->phone_number ?? '-' }}
                        </td>

                        <td class="px-5 py-4 text-gray-600 whitespace-normal min-w-[180px] max-w-[240px]">
                            {{ $item->alamat ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.karyawan.show', $item->id) }}"class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors"title="Lihat Profil">
                                    <svg xmlns="http://www.w3.org/2000/svg"width="18" height="18"viewBox="0 0 24 24"fill="none" stroke="currentColor"stroke-width="2" stroke-linecap="round"stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>

                                <a href="{{ route('admin.karyawan.edit', $item->id) }}" class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/>
                                </svg>
                            </a>

                                @if(auth()->user()->role === 'admin')
                                <form action="{{ route('admin.karyawan.destroy', $item->id) }}"method="POST"class="inline-block"onsubmit="return confirm('Yakin ingin menghapus akun karyawan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus karyawan">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        Belum ada karyawan terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
