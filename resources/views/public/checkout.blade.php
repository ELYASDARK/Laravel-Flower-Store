@extends('layouts.app')

@section('title', __('messages.checkout'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('messages.checkout') }}</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('messages.shipping_information') }}</h2>
                
                <form method="POST" action="{{ route('checkout.process') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.shipping_address') }} *
                        </label>
                        <textarea id="shipping_address" 
                                  name="shipping_address" 
                                  rows="3" 
                                  required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.phone') }} *
                        </label>
                        <input type="text" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                        @error('phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.order_notes') }}
                        </label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 font-semibold">
                        {{ __('messages.place_order') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('messages.order_summary') }}</h2>
                
                <div class="space-y-3 mb-4">
                    @foreach($cart_items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ $item->product->name }} × {{ $item->quantity }}</span>
                            <span class="font-semibold">${{ number_format($item->subtotal, 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t pt-4">
                    <div class="flex justify-between text-lg font-bold">
                        <span>{{ __('messages.total') }}</span>
                        <span class="text-pink-600">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


