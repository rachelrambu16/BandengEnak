<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();
        return view('keranjang', compact('carts'));
    }

    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        $cart = Cart::where('user_id', auth()->id())
                    ->where('product_id', $productId)
                    ->first();
                    
        if ($cart) {
            $cart->quantity += 1;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }
        
        return redirect()->route('keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }
    public function update(Request $request, $cartId)
    {
        $cart = Cart::where('user_id', auth()->id())->where('id', $cartId)->firstOrFail();
        
        if ($request->action === 'plus') {
            // Check stock? Assuming we can just increment.
            // Ideally we check product stock, but for now we just increment.
            if ($cart->quantity < $cart->product->stok) {
                $cart->quantity += 1;
                $cart->save();
            } else {
                return redirect()->route('keranjang')->withErrors(['Maksimal stok tercapai untuk ' . $cart->product->nama_produk]);
            }
        } elseif ($request->action === 'minus') {
            if ($cart->quantity > 1) {
                $cart->quantity -= 1;
                $cart->save();
            } else {
                // If it's 1 and they press minus, we could delete it or just keep at 1. Let's delete it.
                $cart->delete();
                return redirect()->route('keranjang')->with('success', 'Produk dihapus dari keranjang.');
            }
        }
        
        return redirect()->route('keranjang');
    }
    
    public function destroy($cartId)
    {
        $cart = Cart::where('user_id', auth()->id())->where('id', $cartId)->firstOrFail();
        $cart->delete();
        
        return redirect()->route('keranjang')->with('success', 'Produk dihapus dari keranjang.');
    }
}
