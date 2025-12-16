@props(['message' => 'Loading...'])

<div x-show="loading" 
     x-cloak
     class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center"
     style="display: none;">
    <div class="bg-white rounded-lg p-8 shadow-2xl flex flex-col items-center space-y-4">
        <x-spinner size="lg" />
        <p class="text-gray-700 font-medium">{{ $message }}</p>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>


