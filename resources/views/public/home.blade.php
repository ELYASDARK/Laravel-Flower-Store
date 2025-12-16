@extends('layouts.app')

@section('title', __('messages.home'))

@section('content')
<!-- Beautiful gradient background for the entire page -->
<div class="gradient-hero min-h-screen">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Hero Section with beautiful gradient -->
    <div class="gradient-primary rounded-2xl shadow-2xl p-8 sm:p-12 lg:p-20 mb-8 text-white text-center transform hover:scale-[1.01] transition-transform duration-300 relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-white opacity-5 rounded-full -ml-48 -mb-48"></div>
        
        <div class="relative z-10">
            <div class="inline-block mb-4">
                <span class="text-6xl">🌸</span>
            </div>
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 drop-shadow-lg">{{ __('messages.welcome') }}</h2>
            <p class="text-xl sm:text-2xl mb-8 text-white drop-shadow-md max-w-3xl mx-auto">{{ __('Beautiful flowers for every occasion') }}</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#products" 
                   class="inline-flex items-center justify-center bg-white text-primary-600 hover:bg-primary-50 px-10 py-4 rounded-xl font-bold shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200 text-lg">
                    <svg class="w-6 h-6 {{ app()->getLocale() === 'ku' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    {{ __('Shop Now') }}
                </a>
                <a href="#products" 
                   class="inline-flex items-center justify-center bg-accent-600 hover:bg-accent-700 text-white px-10 py-4 rounded-xl font-bold shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200 text-lg">
                    <svg class="w-6 h-6 {{ app()->getLocale() === 'ku' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    {{ __('Browse Catalog') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter with gradient border -->
    <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 p-6 sm:p-8 mb-8 border-4 border-primary-100" x-data="{ loading: false }">
        <form method="GET" action="{{ route('home') }}" class="space-y-4" @submit="loading = true">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline {{ app()->getLocale() === 'ku' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        {{ __('messages.search') }}
                    </label>
                    <input type="text" 
                           id="search"
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="{{ __('messages.search_flowers') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-150 {{ app()->getLocale() === 'ku' ? 'text-right' : '' }}">
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.category') }}
                    </label>
                    <select id="category" 
                            name="category" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-150">
                        <option value="">{{ __('All Categories') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.sort_by') }}
                    </label>
                    <select id="sort" 
                            name="sort" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-150">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>{{ __('Latest') }}</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>{{ __('messages.price_low_high') }}</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>{{ __('messages.price_high_low') }}</option>
                        <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>{{ __('messages.name_a_z') }}</option>
                        <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>{{ __('messages.name_z_a') }}</option>
                    </select>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" 
                        class="flex-1 sm:flex-initial btn-primary inline-flex items-center justify-center"
                        :disabled="loading">
                    <svg class="w-5 h-5 {{ app()->getLocale() === 'ku' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span x-text="loading ? '{{ __('Loading...') }}' : '{{ __('messages.search') }}'"></span>
                </button>
                @if(request()->hasAny(['search', 'category', 'sort']))
                    <a href="{{ route('home') }}" 
                       class="flex-1 sm:flex-initial inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-150 font-semibold">
                        <svg class="w-5 h-5 {{ app()->getLocale() === 'ku' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        {{ __('Clear Filters') }}
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    <div id="products">
        @if($products->count() > 0)
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ __('Showing') }} {{ $products->firstItem() }} - {{ $products->lastItem() }} {{ __('of') }} {{ $products->total() }} {{ __('messages.products') }}
                </h3>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8 mb-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 group border-2 border-primary-100 hover:border-primary-300">
                        <a href="{{ route('products.show', $product) }}" class="block relative overflow-hidden">
                            <img src="{{ $product->getImageUrl() }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-48 sm:h-56 object-cover group-hover:scale-110 transition-transform duration-500"
                                 loading="lazy">
                            @if(!$product->inStock())
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                    <span class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold">
                                        {{ __('messages.out_of_stock') }}
                                    </span>
                                </div>
                            @endif
                        </a>
                        <div class="p-4 sm:p-5">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2 line-clamp-2 min-h-[3rem]">
                                <a href="{{ route('products.show', $product) }}" 
                                   class="hover:text-pink-600 transition-colors duration-150">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-600 mb-3 flex items-center">
                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ku' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                {{ $product->category->name }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-xl sm:text-2xl font-bold text-primary-600">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                                <a href="{{ route('products.show', $product) }}" 
                                   class="inline-flex items-center bg-primary-600 text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-primary-700 text-xs sm:text-sm font-semibold shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-150">
                                    {{ __('messages.view_details') }}
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ku' ? 'mr-1 rotate-180' : 'ml-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <x-empty-state 
                icon="search"
                :title="__('No products found')"
                :description="request()->hasAny(['search', 'category', 'sort']) ? __('Try adjusting your search or filters to find what you\'re looking for.') : __('No products are currently available.')"
                :actionUrl="request()->hasAny(['search', 'category', 'sort']) ? route('home') : null"
                :actionText="request()->hasAny(['search', 'category', 'sort']) ? __('Clear Filters') : null" />
        @endif
    </div>
</div>
</div>
@endsection

