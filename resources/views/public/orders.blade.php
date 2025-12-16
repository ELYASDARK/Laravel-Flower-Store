@extends('layouts.app')

@section('title', __('messages.order_history'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('messages.order_history') }}</h1>

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ __('messages.order_number') }}{{ $order->id }}
                            </h3>
                            <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $order->status->badgeColor() }}">
                            {{ $order->status->label() }}
                        </span>
                    </div>

                    <div class="border-t pt-4">
                        <p class="text-sm text-gray-600 mb-2">
                            {{ __('messages.total') }}: 
                            <span class="font-bold text-pink-600">${{ number_format($order->total_price, 2) }}</span>
                        </p>
                        <p class="text-sm text-gray-600 mb-4">
                            {{ __('Items') }}: {{ $order->total_items }}
                        </p>
                        <a href="{{ route('customer.orders.show', $order) }}" 
                           class="inline-block bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 text-sm">
                            {{ __('messages.order_details') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <p class="text-gray-600 text-lg mb-4">{{ __('messages.no_orders') }}</p>
            <a href="{{ route('home') }}" class="inline-block bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700">
                {{ __('Start Shopping') }}
            </a>
        </div>
    @endif
</div>
@endsection


