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
        if (!$product || $product->quantities < $quantity) {
            // Handle validation error or insufficient quantity
        }

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

        // Update the cart item's quantity
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
        // Get the product associated with the cart item
        $product = $cartItem->product;

        // Increment the product's quantity by the quantity in the cart item
        $product->increment('quantities', $cartItem->quantity);

        // Delete the cart item
        $cartItem->delete();

        // Redirect back to the cart view
        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }


    public function checkout()
    {
        $user = auth()->user();
        $user->cartItems()->delete();

        return redirect()->route('cart.index')->with('success', 'Checkout successful.');
    }


}
