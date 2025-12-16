<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page with products
     */
    public function index(Request $request): View
    {
        $query = Product::with('category')->active();

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Sort
        $sort_by = $request->input('sort', 'latest');
        match ($sort_by) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('name_en', 'asc'),
            'name_desc' => $query->orderBy('name_en', 'desc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12);
        $categories = Category::with('activeProducts')->get();

        return view('public.home', compact('products', 'categories'));
    }

    /**
     * Display product details
     */
    public function show(Product $product): View
    {
        $product->load('category');

        // Get related products from same category
        $related_products = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('public.product-details', compact('product', 'related_products'));
    }
}

