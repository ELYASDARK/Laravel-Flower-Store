@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
            <!-- Product Image -->
            <div>
                <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}" class="w-full rounded-lg">
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                <p class="text-sm text-gray-600 mb-4">
                    {{ __('messages.category') }}: 
                    <span class="font-semibold">{{ $product->category->name }}</span>
                </p>
                <p class="text-4xl font-bold text-pink-600 mb-6">${{ number_format($product->price, 2) }}</p>
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">{{ __('messages.description') }}</h3>
                    <p class="text-gray-700">{{ $product->description }}</p>
                </div>

                <div class="mb-6">
                    @if($product->inStock())
                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                            {{ __('messages.in_stock') }} ({{ $product->stock }})
                        </span>
                    @else
                        <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                            {{ __('messages.out_of_stock') }}
                        </span>
                    @endif
                </div>

                @if($product->inStock())
                    @auth
                        <form method="POST" action="{{ route('cart.add', $product) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('messages.quantity') }}
                                </label>
                                <input type="number" 
                                       id="quantity" 
                                       name="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->stock }}"
                                       class="w-24 px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                            <button type="submit" 
                                    class="w-full bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 font-semibold">
                                {{ __('messages.add_to_cart') }}
                            </button>
                        </form>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800">{{ __('messages.error_login_required') }}</p>
                            <a href="{{ route('login') }}" class="text-pink-600 hover:text-pink-700 font-semibold">
                                {{ __('messages.login') }}
                            </a>
                        </div>
                    @endauth
                @endif
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($related_products->count() > 0)
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('Related Products') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($related_products as $related)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                        <a href="{{ route('products.show', $related) }}">
                            <img src="{{ $related->getImageUrl() }}" alt="{{ $related->name }}" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                <a href="{{ route('products.show', $related) }}" class="hover:text-pink-600">
                                    {{ $related->name }}
                                </a>
                            </h3>
                            <span class="text-xl font-bold text-pink-600">${{ number_format($related->price, 2) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection


