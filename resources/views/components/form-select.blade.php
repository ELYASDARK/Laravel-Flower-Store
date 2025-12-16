@props([
    'name',
    'label',
    'value' => '',
    'required' => false,
    'helpText' => null,
    'options' => [],
])

<div class="mb-6">
    <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700 mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    <select id="{{ $name }}" 
            name="{{ $name }}" 
            {{ $attributes->merge(['class' => 'w-full px-4 py-3 border rounded-lg transition-all duration-150 focus:ring-2 focus:ring-pink-500 focus:border-transparent ' . ($errors->has($name) ? 'border-red-500 bg-red-50' : 'border-gray-300')]) }}
            @if($required) required @endif>
        {{ $slot }}
    </select>
    
    @error($name)
        <div class="mt-2 flex items-start {{ app()->getLocale() === 'ku' ? 'space-x-reverse' : '' }} space-x-2 text-red-600">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm font-medium">{{ $message }}</span>
        </div>
    @enderror
    
    @if($helpText && !$errors->has($name))
        <p class="mt-2 text-sm text-gray-500">{{ $helpText }}</p>
    @endif
</div>


