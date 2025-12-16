<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index(Request $request): View
    {
        $cart_items = CartItem::with('product.category')
            ->where('user_id', $request->user()->id)
            ->get();

        $total = $cart_items->sum(fn ($item) => $item->subtotal);

        return view('public.cart', compact('cart_items', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(AddToCartRequest $request, Product $product): RedirectResponse
    {
        // Check if product is available
        if (!$product->inStock()) {
            return back()->with('error', __('messages.error_out_of_stock'));
        }

        $user_id = $request->user()->id;
        $quantity = $request->validated('quantity');

        // Check if item already in cart
        $cart_item = CartItem::where('user_id', $user_id)
            ->where('product_id', $product->id)
            ->first();

        if ($cart_item) {
            // Update quantity
            $new_quantity = $cart_item->quantity + $quantity;
            
            // Check stock
            if ($new_quantity > $product->stock) {
                return back()->with('error', __('messages.error_out_of_stock'));
            }

            $cart_item->update(['quantity' => $new_quantity]);
        } else {
            // Create new cart item
            CartItem::create([
                'user_id' => $user_id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('success', __('messages.success_product_added'));
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, CartItem $cart_item): RedirectResponse
    {
        // Authorization check
        if ($cart_item->user_id !== $request->user()->id) {
            abort(403);
        }

        $quantity = $request->input('quantity', 1);

        // Check stock
        if ($quantity > $cart_item->product->stock) {
            return back()->with('error', __('messages.error_out_of_stock'));
        }

        $cart_item->update(['quantity' => $quantity]);

        return back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request, CartItem $cart_item): RedirectResponse
    {
        // Authorization check
        if ($cart_item->user_id !== $request->user()->id) {
            abort(403);
        }

        $cart_item->delete();

        return back()->with('success', 'Item removed from cart!');
    }
}


