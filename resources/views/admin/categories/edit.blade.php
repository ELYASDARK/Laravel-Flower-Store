@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" 
           class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-150">
            <svg class="w-5 h-5 {{ app()->getLocale() === 'ku' ? 'ml-2 rotate-180' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            {{ __('messages.back_to_categories') }}
        </a>
    </div>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ __('messages.edit_category') }}</h1>
        <p class="text-gray-600 mt-2">{{ __('messages.edit_category_description') }}</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-3xl">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <!-- English Name -->
            <div class="mb-6">
                <label for="name_en" class="block text-sm font-semibold text-gray-700 mb-2">
                    {{ __('messages.name') }} ({{ __('messages.english') }})
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name_en" 
                       id="name_en" 
                       value="{{ old('name_en', $category->name_en) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-150 @error('name_en') border-red-500 @enderror"
                       placeholder="{{ __('messages.enter_category_name_en') }}"
                       required
                       onkeyup="generateSlug()">
                @error('name_en')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kurdish Name -->
            <div class="mb-6">
                <label for="name_ku" class="block text-sm font-semibold text-gray-700 mb-2">
                    {{ __('messages.name') }} ({{ __('messages.kurdish') }})
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name_ku" 
                       id="name_ku" 
                       value="{{ old('name_ku', $category->name_ku) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-150 @error('name_ku') border-red-500 @enderror"
                       placeholder="{{ __('messages.enter_category_name_ku') }}"
                       required
                       dir="rtl">
                @error('name_ku')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div class="mb-6">
                <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">
                    {{ __('messages.slug') }}
                    <span class="text-red-500">*</span>
                    <span class="text-xs font-normal text-gray-500">({{ __('messages.auto_generated') }})</span>
                </label>
                <input type="text" 
                       name="slug" 
                       id="slug" 
                       value="{{ old('slug', $category->slug) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-150 @error('slug') border-red-500 @enderror"
                       placeholder="{{ __('messages.enter_slug') }}"
                       required
                       pattern="[a-z0-9]+(?:-[a-z0-9]+)*">
                <p class="mt-2 text-xs text-gray-500">{{ __('messages.slug_help_text') }}</p>
                @error('slug')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category Info -->
            <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 {{ app()->getLocale() === 'ku' ? 'ml-3' : 'mr-3' }} mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-blue-900">{{ __('messages.category_info') }}</p>
                        <p class="text-sm text-blue-700 mt-1">
                            {{ __('messages.this_category_has') }} <strong>{{ $category->products->count() }}</strong> {{ __('messages.products') }}
                        </p>
                        @if ($category->products->count() > 0)
                            <p class="text-xs text-blue-600 mt-2">
                                {{ __('messages.category_delete_warning') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <div>
                    @if ($category->products->count() === 0)
                        <button type="button" 
                                onclick="if(confirm('{{ __('messages.confirm_delete_category') }}')) { document.getElementById('delete-form').submit(); }"
                                class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md transition-all duration-150">
                            {{ __('messages.delete_category') }}
                        </button>
                    @else
                        <button type="button" 
                                disabled
                                class="px-6 py-3 bg-gray-300 text-gray-500 font-semibold rounded-lg cursor-not-allowed"
                                title="{{ __('messages.cannot_delete_category_with_products') }}">
                            {{ __('messages.delete_category') }}
                        </button>
                    @endif
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors duration-150">
                        {{ __('messages.cancel') }}
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition-all duration-150 transform hover:scale-105">
                        <span class="inline-flex items-center">
                            <svg class="w-5 h-5 {{ app()->getLocale() === 'ku' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ __('messages.update_category') }}
                        </span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Delete Form (Hidden) -->
        <form id="delete-form" 
              action="{{ route('admin.categories.destroy', $category) }}" 
              method="POST" 
              class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

<!-- JavaScript for Auto-generating Slug -->
<script>
function generateSlug() {
    const nameInput = document.getElementById('name_en');
    const slugInput = document.getElementById('slug');
    
    if (nameInput && slugInput) {
        let slug = nameInput.value
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
        
        slugInput.value = slug;
    }
}
</script>
@endsection


