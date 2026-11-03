<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
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
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $carts = Cart::with('product')->where('user_id', auth()->id())->get();
        if ($carts->isEmpty()) {
            return redirect()->route('katalog');
        }

        $subtotal = $carts->sum(function($cart) {
            return $cart->product->harga * $cart->quantity;
        });
        $shipping = 15000;
        $total = $subtotal + $shipping;

        $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        DB::transaction(function() use ($carts, $request, $total, $proofPath) {
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'payment_proof' => $proofPath,
                'status' => 'pending'
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
        });

        return redirect()->route('checkout.success');
    }
}
