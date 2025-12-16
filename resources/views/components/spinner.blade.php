@props(['size' => 'md', 'color' => 'pink'])

@php
    $sizeClasses = [
        'sm' => 'w-4 h-4',
        'md' => 'w-8 h-8',
        'lg' => 'w-12 h-12',
        'xl' => 'w-16 h-16',
    ];
    
    $colorClasses = [
        'pink' => 'border-pink-600',
        'white' => 'border-white',
        'indigo' => 'border-indigo-600',
        'gray' => 'border-gray-600',
    ];
    
    $size_class = $sizeClasses[$size] ?? $sizeClasses['md'];
    $color_class = $colorClasses[$color] ?? $colorClasses['pink'];
@endphp

<div {{ $attributes->merge(['class' => 'inline-block']) }}>
    <div class="{{ $size_class }} border-4 {{ $color_class }} border-t-transparent rounded-full animate-spin"></div>
</div>


