<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index(Request $request): View
    {
        $total_orders = Order::count();
        $total_sales = Order::where('status', OrderStatus::COMPLETED)->sum('total_price');
        $pending_orders = Order::where('status', OrderStatus::PENDING)->count();
        $total_products = Product::count();

        $recent_orders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'total_orders',
            'total_sales',
            'pending_orders',
            'total_products',
            'recent_orders'
        ));
    }
}


