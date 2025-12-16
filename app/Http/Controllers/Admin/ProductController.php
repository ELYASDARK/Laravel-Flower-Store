<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Handles product management for admin users.
 */
final class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly ImageService $image_service
    ) {}

    /**
     * Display a listing of products.
     */
    public function index(Request $request): View
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name_en')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in the database.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image_path'] = $this->image_service->upload(
                file: $request->file('image'),
                directory: 'products',
                resize: true
            );
        }

        $data['is_active'] = $request->boolean('is_active', true);

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', __('messages.success_product_created'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name_en')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in the database.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            $this->image_service->delete($product->image_path);

            // Upload new image
            $data['image_path'] = $this->image_service->upload(
                file: $request->file('image'),
                directory: 'products',
                resize: true
            );
        }

        $data['is_active'] = $request->boolean('is_active', $product->is_active);

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', __('messages.success_product_updated'));
    }

    /**
     * Remove the specified product from the database.
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Delete product image
        $this->image_service->delete($product->image_path);

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', __('messages.success_product_deleted'));
    }
}

