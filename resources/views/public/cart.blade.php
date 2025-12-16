@extends('layouts.app')

@section('title', __('messages.shopping_cart'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('messages.shopping_cart') }}</h1>

    @if($cart_items->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart_items as $item)
                    <div class="bg-white rounded-lg shadow-md p-6 flex items-center gap-4">
                        <img src="{{ $item->product->getImageUrl() }}" 
                             alt="{{ $item->product->name }}" 
                             class="w-24 h-24 object-cover rounded">
                        
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $item->product->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $item->product->category->name }}</p>
                            <p class="text-lg font-bold text-pink-600 mt-2">${{ number_format($item->product->price, 2) }}</p>
                        </div>

                        <div class="flex items-center gap-4">
                            <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" 
                                       name="quantity" 
                                       value="{{ $item->quantity }}" 
                                       min="1" 
                                       max="{{ $item->product->stock }}"
                                       class="w-20 px-2 py-1 border border-gray-300 rounded">
                                <button type="submit" class="text-sm text-pink-600 hover:text-pink-700">
                                    {{ __('messages.update_cart') }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('cart.remove', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('messages.order_summary') }}</h2>
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ __('messages.subtotal') }}</span>
                            <span class="font-semibold">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="border-t pt-2 flex justify-between">
                            <span class="text-lg font-bold">{{ __('messages.total') }}</span>
                            <span class="text-lg font-bold text-pink-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('checkout.index') }}" 
                       class="block w-full bg-pink-600 text-white text-center px-6 py-3 rounded-lg hover:bg-pink-700 font-semibold">
                        {{ __('messages.proceed_to_checkout') }}
                    </a>
                    <a href="{{ route('home') }}" 
                       class="block w-full text-center text-pink-600 hover:text-pink-700 mt-4">
                        {{ __('messages.continue_shopping') }}
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('messages.cart_empty') }}</h3>
            <a href="{{ route('home') }}" class="inline-block mt-4 bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700">
                {{ __('messages.continue_shopping') }}
            </a>
        </div>
    @endif
</div>
@endsection


