<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\CartItem;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function viewCart()
     {
        $user = auth()->user();
        $cartItems = $user->cartItems;

        return view('cart.cart', compact('cartItems'));
     }


    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $product = ProductModel::find($productId);
        // if (!$product || $product->quantities < $quantity) {

        // }

        $user = auth()->user();
        $existingCartItem = $user->cartItems()->where('product_id', $productId)->first();

        if ($existingCartItem) {
            $existingCartItem->update(['quantity' => $existingCartItem->quantity + $quantity]);
        } else {
            $user->cartItems()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        $product->decrement('quantities', $quantity);

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function updateCart(Request $request, CartItem $cartItem)
    {
        $total = $cartItem->product->quantities + $cartItem->quantity;
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $total,
        ]);

        $difference = $cartItem->quantity - $validatedData['quantity'];

        $cartItem->update(['quantity' => $validatedData['quantity']]);

        if ($difference > 0) {
            $cartItem->product->increment('quantities', $difference);
        }

        if ($difference < 0) {
            $cartItem->product->decrement('quantities', abs($difference));
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }



    public function removeFromCart(CartItem $cartItem)
    {
        $product = $cartItem->product;

        $product->increment('quantities', $cartItem->quantity);

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }


    public function checkout()
    {
        $user = auth()->user();
        $user->cartItems()->delete();

        return redirect()->route('cart.index')->with('success', 'Checkout successful.');
    }


}
