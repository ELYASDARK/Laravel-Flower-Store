@extends('layouts.app')

@section('title', __('messages.order_details'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('customer.orders') }}" class="text-pink-600 hover:text-pink-700">
            ← {{ __('Back to Orders') }}
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    {{ __('messages.order_number') }}{{ $order->id }}
                </h1>
                <p class="text-gray-600">{{ __('messages.order_date') }}: {{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $order->status->badgeColor() }}">
                {{ $order->status->label() }}
            </span>
        </div>

        <!-- Shipping Info -->
        <div class="mb-6 pb-6 border-b">
            <h2 class="text-lg font-semibold mb-3">{{ __('messages.shipping_information') }}</h2>
            <p class="text-gray-700 mb-2"><strong>{{ __('messages.shipping_address') }}:</strong> {{ $order->shipping_address }}</p>
            <p class="text-gray-700 mb-2"><strong>{{ __('messages.phone') }}:</strong> {{ $order->phone }}</p>
            @if($order->notes)
                <p class="text-gray-700"><strong>{{ __('messages.order_notes') }}:</strong> {{ $order->notes }}</p>
            @endif
        </div>

        <!-- Order Items -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-4">{{ __('Order Items') }}</h2>
            <div class="space-y-3">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                        <img src="{{ $item->product->getImageUrl() }}" 
                             alt="{{ $item->product->name }}" 
                             class="w-16 h-16 object-cover rounded">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $item->product->name }}</h3>
                            <p class="text-sm text-gray-600">{{ __('messages.quantity') }}: {{ $item->quantity }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-pink-600">${{ number_format($item->subtotal, 2) }}</p>
                            <p class="text-sm text-gray-600">${{ number_format($item->price, 2) }} each</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Total -->
        <div class="border-t pt-6">
            <div class="flex justify-end">
                <div class="w-64">
                    <div class="flex justify-between text-lg font-bold">
                        <span>{{ __('messages.total') }}</span>
                        <span class="text-pink-600">${{ number_format($order->total_price, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


