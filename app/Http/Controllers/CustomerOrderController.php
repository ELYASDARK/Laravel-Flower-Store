<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerOrderController extends Controller
{
    /**
     * Display customer's orders
     */
    public function index(Request $request): View
    {
        $orders = Order::with('items.product')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('public.orders', compact('orders'));
    }

    /**
     * Display order details
     */
    public function show(Request $request, Order $order): View
    {
        // Authorization check
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        $order->load('items.product');

        return view('public.order-details', compact('order'));
    }
}


