@props(['items' => []])

@if(count($items) > 0)
<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3 {{ app()->getLocale() === 'ku' ? 'flex-row-reverse space-x-reverse' : '' }}">
        <li class="inline-flex items-center">
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-pink-600 transition-colors duration-150">
                <svg class="w-4 h-4 {{ app()->getLocale() === 'ku' ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                {{ __('messages.home') }}
            </a>
        </li>
        
        @foreach($items as $index => $item)
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400 {{ app()->getLocale() === 'ku' ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    
                    @if($index === count($items) - 1)
                        <span class="text-sm font-medium text-gray-500 {{ app()->getLocale() === 'ku' ? 'mr-1 md:mr-2' : 'ml-1 md:ml-2' }}">
                            {{ $item['label'] }}
                        </span>
                    @else
                        <a href="{{ $item['url'] }}" class="text-sm font-medium text-gray-700 hover:text-pink-600 transition-colors duration-150 {{ app()->getLocale() === 'ku' ? 'mr-1 md:mr-2' : 'ml-1 md:ml-2' }}">
                            {{ $item['label'] }}
                        </a>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
@endif


