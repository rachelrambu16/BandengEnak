<?php

namespace App\Services;

use App\Models\Transaction;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class MidtransPaymentService
{
    public function __construct()
    {
        if (! function_exists('curl_init')) {
            throw new \RuntimeException('PHP cURL extension is required for Midtrans payments.');
        }

        if (! config('services.midtrans.server_key') || ! config('services.midtrans.client_key')) {
            throw new \RuntimeException('Midtrans server and client keys are not configured.');
        }

        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createSnapToken(Transaction $transaction): string
    {
        $items = $transaction->details()->with('product')->get()->map(function ($detail) {
            return [
                'id' => (string) $detail->product_id,
                'price' => (int) $detail->price,
                'quantity' => $detail->quantity,
                'name' => $detail->product?->nama_produk ?? 'Produk',
            ];
        })->values()->all();

        $items[] = [
            'id' => 'shipping',
            'price' => 15000,
            'quantity' => 1,
            'name' => 'Biaya Pengiriman',
        ];

        return Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $transaction->payment_order_id,
                'gross_amount' => (int) $transaction->total_amount,
            ],
            'item_details' => $items,
            'enabled_payments' => [
                'bca_va',
                'bni_va',
                'bri_va',
                'mandiri_va',
                'permata_va',
                'other_va',
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
                'phone' => $transaction->phone,
                'billing_address' => [
                    'address' => $transaction->shipping_address,
                ],
                'shipping_address' => [
                    'address' => $transaction->shipping_address,
                ],
            ],
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit' => 'day',
                'duration' => 1,
            ],
        ]);
    }

    public function syncNotification(): Transaction
    {
        $notification = new Notification();
        $transaction = Transaction::where('payment_order_id', $notification->order_id)->firstOrFail();
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        $paymentStatus = match ($transactionStatus) {
            'capture' => $fraudStatus === 'accept' ? 'paid' : 'pending',
            'settlement' => 'paid',
            'expire' => 'expired',
            'cancel', 'deny' => 'failed',
            default => 'pending',
        };

        $transaction->update([
            'payment_status' => $paymentStatus,
            'payment_type' => $notification->payment_type,
            'payment_expires_at' => $notification->expiry_time
                ? \Carbon\Carbon::parse($notification->expiry_time)
                : $transaction->payment_expires_at,
            'status' => $paymentStatus === 'paid' ? 'diproses' : $transaction->status,
        ]);

        return $transaction;
    }
}
