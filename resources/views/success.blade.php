@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] bg-orange-50/30 pt-32 pb-20 flex items-center justify-center">
    <div class="bg-white p-10 rounded-2xl shadow-lg shadow-orange-500/5 border border-orange-100 max-w-lg w-full text-center">
        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Pesanan Berhasil!</h2>
        <p class="text-gray-600 mb-8">
            Terima kasih telah berbelanja. Bukti pembayaran Anda sedang kami verifikasi. Kami akan segera memproses pesanan Anda.
        </p>
        <a href="/katalog" class="inline-block px-8 py-3 bg-orange-500 text-white rounded-xl font-semibold hover:bg-orange-600 transition-colors shadow-lg shadow-orange-500/20 w-full">
            Kembali Berbelanja
        </a>
    </div>
</div>
@endsection
