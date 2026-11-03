<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    private const CART_EXPIRY_DAYS = 30;

    public function index()
    {
        $this->removeExpiredCarts();
        $carts = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        return view('keranjang', compact('carts'));
    }

    public function store(Request $request, $productId)
    {
        $this->removeExpiredCarts();
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($productId);
        $jumlah = (int) $request->jumlah;

        if ($product->stok < $jumlah) {
            return back()
                ->withErrors([
                    'jumlah' => 'Jumlah yang dipilih melebihi stok tersedia.',
                ])
                ->withInput();
        }

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        $jumlahBaru = $cart
            ? $cart->quantity + $jumlah
            : $jumlah;

        if ($jumlahBaru > $product->stok) {
            return back()
                ->withErrors([
                    'jumlah' => 'Total produk di keranjang melebihi stok tersedia.',
                ])
                ->withInput();
        }

        if ($cart) {
            $cart->quantity = $jumlahBaru;
            $cart->expires_at = now()->addDays(self::CART_EXPIRY_DAYS);
            $cart->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => $jumlah,
                'expires_at' => now()->addDays(self::CART_EXPIRY_DAYS),
            ]);
        }

        return redirect()
            ->route('keranjang')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, $cartId)
    {
        $this->removeExpiredCarts();
        $cart = Cart::where('user_id', auth()->id())
            ->where('id', $cartId)
            ->firstOrFail();

        if ($request->action === 'plus') {
            if ($cart->quantity < $cart->product->stok) {
                $cart->quantity += 1;
                $cart->expires_at = now()->addDays(self::CART_EXPIRY_DAYS);
                $cart->save();
            } else {
                return redirect()
                    ->route('keranjang')
                    ->withErrors([
                        'stok' => 'Maksimal stok tercapai untuk '
                            . $cart->product->nama_produk,
                    ]);
            }
        } elseif ($request->action === 'minus') {
            if ($cart->quantity > 1) {
                $cart->quantity -= 1;
                $cart->expires_at = now()->addDays(self::CART_EXPIRY_DAYS);
                $cart->save();
            } else {
                $cart->delete();

                return redirect()
                    ->route('keranjang')
                    ->with('success', 'Produk dihapus dari keranjang.');
            }
        }

        return redirect()->route('keranjang');
    }

    public function destroy($cartId)
    {
        $cart = Cart::where('user_id', auth()->id())
            ->where('id', $cartId)
            ->firstOrFail();

        $cart->delete();

        return redirect()
            ->route('keranjang')
            ->with('success', 'Produk dihapus dari keranjang.');
    }

    private function removeExpiredCarts(): void
    {
        Cart::where('user_id', auth()->id())
            ->whereNull('expires_at')
            ->update(['expires_at' => now()->addDays(self::CART_EXPIRY_DAYS)]);

        Cart::where('user_id', auth()->id())
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', Carbon::now())
            ->delete();
    }
}
