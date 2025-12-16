@extends('layouts.app')

@section('title', __('messages.edit_product'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-pink-600 hover:text-pink-700">
            ← {{ __('Back to Products') }}
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.edit_product') }}</h1>

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('messages.category') }} *
                </label>
                <select id="category_id" name="category_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name_en }} / {{ $category->name_ku }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.product_name_en') }} *
                    </label>
                    <input type="text" id="name_en" name="name_en" value="{{ old('name_en', $product->name_en) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                    @error('name_en')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name_ku" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.product_name_ku') }} *
                    </label>
                    <input type="text" id="name_ku" name="name_ku" value="{{ old('name_ku', $product->name_ku) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500" dir="rtl">
                    @error('name_ku')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.product_desc_en') }} *
                    </label>
                    <textarea id="description_en" name="description_en" rows="4" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">{{ old('description_en', $product->description_en) }}</textarea>
                    @error('description_en')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description_ku" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.product_desc_ku') }} *
                    </label>
                    <textarea id="description_ku" name="description_ku" rows="4" required dir="rtl"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">{{ old('description_ku', $product->description_ku) }}</textarea>
                    @error('description_ku')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.price') }} ($) *
                    </label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                    @error('price')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.stock') }} *
                    </label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                    @error('stock')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('messages.product_image') }}
                </label>
                @if($product->image_path)
                    <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded mb-2">
                @endif
                <input type="file" id="image" name="image" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                @error('image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                       class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                    {{ __('messages.is_active') }}
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit" 
                        class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-lg font-semibold">
                    {{ __('messages.save') }}
                </button>
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-semibold">
                    {{ __('messages.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


