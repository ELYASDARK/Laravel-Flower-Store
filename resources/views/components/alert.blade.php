@props(['type' => 'info', 'message', 'dismissible' => true])

@php
    $styles = [
        'success' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-500',
            'text' => 'text-green-800',
            'icon_color' => 'text-green-500',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-500',
            'text' => 'text-red-800',
            'icon_color' => 'text-red-500',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'border' => 'border-yellow-500',
            'text' => 'text-yellow-800',
            'icon_color' => 'text-yellow-500',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>',
        ],
        'info' => [
            'bg' => 'bg-blue-50',
            'border' => 'border-blue-500',
            'text' => 'text-blue-800',
            'icon_color' => 'text-blue-500',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
        ],
    ];
    
    $style = $styles[$type] ?? $styles['info'];
@endphp

<div x-data="{ show: true }" 
     x-show="show"
     x-init="@if($dismissible) setTimeout(() => show = false, 5000) @endif"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     {{ $attributes->merge(['class' => "{$style['bg']} border-l-4 {$style['border']} rounded-lg shadow-md p-4 flex items-center justify-between"]) }}>
    <div class="flex items-center">
        <svg class="w-6 h-6 {{ $style['icon_color'] }} {{ app()->getLocale() === 'ku' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {!! $style['icon'] !!}
        </svg>
        <p class="{{ $style['text'] }} font-medium">{{ $message }}</p>
    </div>
    @if($dismissible)
        <button @click="show = false" class="{{ $style['icon_color'] }} hover:opacity-70 transition-opacity duration-150">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    @endif
</div>


