@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] bg-orange-50/30 pt-32 pb-20 flex items-center justify-center">
    <div class="bg-white p-10 rounded-2xl shadow-lg shadow-orange-500/5 border border-orange-100 max-w-lg w-full text-center">
        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Pesanan Berhasil Dibuat!</h2>
        <p class="text-gray-600 mb-4">
            Silakan selesaikan pembayaran melalui payment gateway sebelum batas waktu berakhir.
        </p>
        <p class="text-sm text-gray-500 mb-8">
            Batas pembayaran: {{ optional($transaction->payment_expires_at)->format('d M Y, H:i') }} WIB
        </p>
        <button id="pay-button" type="button" class="inline-block px-8 py-3 bg-orange-500 text-white rounded-xl font-semibold hover:bg-orange-600 transition-colors shadow-lg shadow-orange-500/20 w-full">
            Bayar Sekarang
        </button>
        <a href="/katalog" class="inline-block px-8 py-3 bg-orange-500 text-white rounded-xl font-semibold hover:bg-orange-600 transition-colors shadow-lg shadow-orange-500/20 w-full">
            Kembali Berbelanja
        </a>
    </div>
</div>
    <script src="https://app{{ config('services.midtrans.is_production') ? '' : '.sandbox' }}.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            window.snap.pay(@json($transaction->payment_token), {
                onSuccess: function () { window.location.reload(); },
                onPending: function () { window.location.reload(); },
                onError: function () { window.location.reload(); },
                onClose: function () {}
            });
        });
    </script>
    @endsection
