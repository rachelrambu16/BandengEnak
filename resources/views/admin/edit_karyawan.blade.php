@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ auth()->user()->role === 'admin' ? route('admin.karyawan') : route('karyawan.profil') }}"
       class="p-2 bg-white border border-orange-200 text-gray-500 rounded-xl hover:bg-orange-50 hover:text-orange-600 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
        </svg>
    </a>

    <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Profil Karyawan</h1>
        <p class="text-gray-500 text-sm mt-1">
            Ubah informasi profil: {{ $karyawan->name }}
        </p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-6 sm:p-8 max-w-3xl">

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.karyawan.update', $karyawan->id) }}"
          method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Nama Karyawan
            </label>
            <input type="text" name="name" required
                   value="{{ old('name', $karyawan->name) }}"
                   class="w-full px-4 py-2.5 bg-orange-50/30 border border-orange-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-colors">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Email
            </label>
            <input type="email" name="email" required
                   value="{{ old('email', $karyawan->email) }}"
                   class="w-full px-4 py-2.5 bg-orange-50/30 border border-orange-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-colors">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Nomor Telepon
            </label>
            <input type="text" name="phone_number" maxlength="15"
                   value="{{ old('phone_number', $karyawan->phone_number) }}"
                   class="w-full px-4 py-2.5 bg-orange-50/30 border border-orange-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-colors">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Alamat
            </label>
            <textarea name="alamat" rows="3"
                      class="w-full px-4 py-2.5 bg-orange-50/30 border border-orange-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-colors">{{ old('alamat', $karyawan->alamat) }}</textarea>
        </div>

        <div class="pt-6 border-t border-orange-100 flex justify-end gap-3">
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.karyawan') : route('karyawan.profil') }}"
               class="px-6 py-2.5 rounded-xl border border-orange-200 text-gray-700 font-medium hover:bg-orange-50 transition-colors">
                Batal
            </a>

            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-orange-500 text-white font-medium hover:bg-orange-600 shadow-md shadow-orange-500/20 transition-colors">
                Update Profil
            </button>
        </div>
    </form>
</div>
@endsection
