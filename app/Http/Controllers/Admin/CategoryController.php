<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Handles category management for admin users.
 */
final class CategoryController extends Controller
{
    /**
     * Display a listing of all categories.
     */
    public function index(): View
    {
        $categories = Category::withCount('products')
            ->orderBy('name_en')
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in database.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Auto-generate slug if not provided or empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name_en']);
        }

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('messages.category_created_successfully'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in database.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();

        // Auto-generate slug if not provided or empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name_en']);
        }

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('messages.category_updated_successfully'));
    }

    /**
     * Remove the specified category from database.
     * Only allowed if category has no products.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', __('messages.category_has_products'));
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('messages.category_deleted_successfully'));
    }
}


