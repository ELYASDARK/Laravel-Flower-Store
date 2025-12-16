<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\CheckoutRequest;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page
     */
    public function index(Request $request): View
    {
        $cart_items = CartItem::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        if ($cart_items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = $cart_items->sum(fn ($item) => $item->subtotal);

        return view('public.checkout', compact('cart_items', 'total'));
    }

    /**
     * Process the checkout
     */
    public function process(CheckoutRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Get cart items
        $cart_items = CartItem::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($cart_items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Calculate total
        $total = $cart_items->sum(fn ($item) => $item->subtotal);

        // Create order in transaction
        DB::transaction(function () use ($request, $user, $cart_items, $total) {
            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'status' => OrderStatus::PENDING,
                'shipping_address' => $request->validated('shipping_address'),
                'phone' => $request->validated('phone'),
                'notes' => $request->validated('notes'),
            ]);

            // Create order items
            foreach ($cart_items as $cart_item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart_item->product_id,
                    'quantity' => $cart_item->quantity,
                    'price' => $cart_item->product->price,
                ]);

                // Reduce stock
                $cart_item->product->decrement('stock', $cart_item->quantity);
            }

            // Clear cart
            CartItem::where('user_id', $user->id)->delete();
        });

        return redirect()
            ->route('customer.orders')
            ->with('success', __('messages.success_order_placed'));
    }
}


