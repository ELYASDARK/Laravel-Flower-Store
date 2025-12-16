<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request): View
    {
        $query = Order::with('user', 'items.product');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order
     */
    public function show(Order $order): View
    {
        $order->load('user', 'items.product');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the order status
     */
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $order->update([
            'status' => $request->validated('status'),
        ]);

        return back()->with('success', __('messages.success_order_updated'));
    }
}


