<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\MidtransPaymentService;

class CheckoutController extends Controller
{
    public function index()
    {
        $this->removeExpiredCarts();
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();
        if ($carts->isEmpty()) {
            return redirect()->route('katalog');
        }
        return view('checkout', compact('carts'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $this->removeExpiredCarts();
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();
        if ($carts->isEmpty()) {
            return redirect()->route('katalog');
        }

        $subtotal = $carts->sum(function($cart) {
            return $cart->product->harga * $cart->quantity;
        });
        $shipping = 15000;
        $total = $subtotal + $shipping;

        $transaction = DB::transaction(function () use ($carts, $request, $total) {
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'payment_order_id' => 'BE-' . Str::upper(Str::random(20)),
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            foreach ($carts as $cart) {
                $product = $cart->product;
                if ($product->stok < $cart->quantity) {
                     throw new \Exception(
                        "Stok {$product->nama_produk} tidak mencukupi"
                        );
                    }
                        TransactionDetail::create([
                            'transaction_id' => $transaction->id,
                            'product_id' => $cart->product_id,
                            'quantity' => $cart->quantity,
                            'price' => $product->harga
                            ]);
                            $product->decrement('stok', $cart->quantity);
                        }

            Cart::where('user_id', auth()->id())->delete();
            return $transaction->load(['details.product', 'user']);
        });

        try {
            $paymentToken = app(MidtransPaymentService::class)->createSnapToken($transaction);
        } catch (\Throwable $exception) {
            foreach ($transaction->details()->with('product')->get() as $detail) {
                $detail->product?->increment('stok', $detail->quantity);
            }

            $transaction->update([
                'payment_status' => 'failed',
                'status' => 'dibatalkan',
            ]);

            report($exception);

            return back()
                ->withErrors(['payment' => 'Pembayaran tidak dapat dibuat. Silakan coba lagi.'])
                ->withInput();
        }

        $transaction->update([
            'payment_token' => $paymentToken,
            'payment_expires_at' => now()->addDay(),
        ]);

        return redirect()->route('checkout.success', $transaction);
    }

    public function success(Transaction $transaction)
    {
        abort_unless($transaction->user_id === auth()->id(), 403);

        return view('success', compact('transaction'));
    }

    public function notification(MidtransPaymentService $paymentService)
    {
        try {
            $paymentService->syncNotification();
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['message' => 'notifikasi pembayaran tidak valid.'], 422);
        }

        return response()->json(['message' => 'notifikasi pembayaran diproses.']);
    }

    private function removeExpiredCarts(): void
    {
        Cart::where('user_id', auth()->id())
            ->whereNull('expires_at')
            ->update(['expires_at' => now()->addDays(30)]);

        Cart::where('user_id', auth()->id())
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->delete();
    }
}
