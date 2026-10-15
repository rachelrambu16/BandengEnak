@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('admin.kelola_produk') }}" class="p-2 bg-white border border-orange-200 text-gray-500 rounded-xl hover:bg-orange-50 hover:text-orange-600 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Produk</h1>
        <p class="text-gray-500 text-sm mt-1">Ubah informasi detail produk: {{ $product->nama_produk }}</p>
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

    <form action="{{ route('admin.update_produk', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk</label>
            <input type="text" name="nama_produk" required value="{{ old('nama_produk', $product->nama_produk) }}" class="w-full px-4 py-2.5 bg-orange-50/30 border border-orange-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-colors">
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Produk</label>
            <textarea name="deskripsi" required rows="4" class="w-full px-4 py-2.5 bg-orange-50/30 border border-orange-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-colors">{{ old('deskripsi', $product->deskripsi) }}</textarea>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp)</label>
                <input type="text" name="harga" id="harga" required value="{{ old('harga', $product->harga) }}" class="w-full px-4 py-2.5 bg-orange-50/30 border border-orange-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-colors" oninput="formatRupiah(this)">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Stok</label>
                <input type="number" name="stok" required min="0" value="{{ old('stok', $product->stok) }}" class="w-full px-4 py-2.5 bg-orange-50/30 border border-orange-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-colors">
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk Saat Ini</label>
            @if($product->gambar)
                <img src="{{ asset('storage/' . $product->gambar) }}" alt="Gambar Produk" class="w-40 h-40 object-cover rounded-xl border border-orange-100 shadow-sm mb-4">
            @else
                <p class="text-sm text-gray-500 mb-4">Tidak ada gambar</p>
            @endif

            <label class="block text-sm font-semibold text-gray-700 mb-2">Ganti Gambar (Opsional)</label>
            <input type="file" name="gambar" accept="image/png,image/jpeg,image/jpg" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer border border-orange-200 rounded-xl">
        </div>

        <div class="pt-6 border-t border-orange-100 flex justify-end gap-3">
            <a href="{{ route('admin.kelola_produk') }}" class="px-6 py-2.5 rounded-xl border border-orange-200 text-gray-700 font-medium hover:bg-orange-50 transition-colors">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-orange-500 text-white font-medium hover:bg-orange-600 shadow-md shadow-orange-500/20 transition-colors">Update Produk</button>
        </div>
    </form>
</div>

<script>
    function formatRupiah(input) {
        let value = input.value.replace(/\D/g, '');
        if (value) {
            input.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            input.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        let hargaInput = document.getElementById('harga');
        if (hargaInput && hargaInput.value) {
            // Remove decimals if any (from DB float format)
            let val = hargaInput.value.split('.')[0]; 
            hargaInput.value = val;
            formatRupiah(hargaInput);
        }
    });
</script>
@endsection