<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ku' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Flower Store') }} - @yield('title', __('messages.home'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="gradient-hero antialiased" x-data="{ mobileMenuOpen: false }">
    <nav class="bg-white shadow-lg sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo and Desktop Navigation -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center group">
                        <h1 class="text-xl sm:text-2xl font-bold text-pink-600 group-hover:text-pink-700 transition-colors duration-150">
                            🌸 {{ config('app.name') }}
                        </h1>
                    </a>
                    <div class="hidden md:{{ app()->getLocale() === 'ku' ? 'mr' : 'ml' }}-10 md:flex md:space-x-4 {{ app()->getLocale() === 'ku' ? 'md:space-x-reverse' : '' }}">
                        <a href="{{ route('home') }}" 
                           class="text-gray-700 hover:text-pink-600 hover:bg-pink-50 px-3 py-2 rounded-md text-sm font-medium transition-all duration-150 {{ request()->routeIs('home') ? 'bg-pink-100 text-pink-600' : '' }}">
                            {{ __('messages.home') }}
                        </a>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="text-gray-700 hover:text-pink-600 hover:bg-pink-50 px-3 py-2 rounded-md text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-pink-100 text-pink-600' : '' }}">
                                    {{ __('messages.dashboard') }}
                                </a>
                                <a href="{{ route('admin.categories.index') }}" 
                                   class="text-gray-700 hover:text-pink-600 hover:bg-pink-50 px-3 py-2 rounded-md text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.categories.*') ? 'bg-pink-100 text-pink-600' : '' }}">
                                    {{ __('messages.categories') }}
                                </a>
                                <a href="{{ route('admin.products.index') }}" 
                                   class="text-gray-700 hover:text-pink-600 hover:bg-pink-50 px-3 py-2 rounded-md text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.products.*') ? 'bg-pink-100 text-pink-600' : '' }}">
                                    {{ __('messages.products') }}
                                </a>
                                <a href="{{ route('admin.orders.index') }}" 
                                   class="text-gray-700 hover:text-pink-600 hover:bg-pink-50 px-3 py-2 rounded-md text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.orders.*') ? 'bg-pink-100 text-pink-600' : '' }}">
                                    {{ __('messages.orders') }}
                                </a>
                            @else
                                <a href="{{ route('customer.orders') }}" 
                                   class="text-gray-700 hover:text-pink-600 hover:bg-pink-50 px-3 py-2 rounded-md text-sm font-medium transition-all duration-150 {{ request()->routeIs('customer.orders*') ? 'bg-pink-100 text-pink-600' : '' }}">
                                    {{ __('messages.my_orders') }}
                                </a>
                                <a href="{{ route('cart.index') }}" 
                                   class="text-gray-700 hover:text-pink-600 hover:bg-pink-50 px-3 py-2 rounded-md text-sm font-medium transition-all duration-150 relative {{ request()->routeIs('cart.*') ? 'bg-pink-100 text-pink-600' : '' }}">
                                    {{ __('messages.cart') }}
                                    @auth
                                        @php
                                            $cart_count = auth()->user()->cartItems()->count();
                                        @endphp
                                        @if($cart_count > 0)
                                            <span class="absolute -top-1 {{ app()->getLocale() === 'ku' ? '-left-1' : '-right-1' }} bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                                {{ $cart_count }}
                                            </span>
                                        @endif
                                    @endauth
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Right Side: Language, Auth, Mobile Menu -->
                <div class="flex items-center {{ app()->getLocale() === 'ku' ? 'space-x-reverse' : '' }} space-x-3">
                    <!-- Language Switcher -->
                    <div class="flex {{ app()->getLocale() === 'ku' ? 'space-x-reverse' : '' }} space-x-1">
                        <a href="{{ route('language.switch', 'en') }}" 
                           class="px-2 sm:px-3 py-1 rounded-md text-xs sm:text-sm font-medium transition-all duration-150 {{ app()->getLocale() === 'en' ? 'bg-pink-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            EN
                        </a>
                        <a href="{{ route('language.switch', 'ku') }}" 
                           class="px-2 sm:px-3 py-1 rounded-md text-xs sm:text-sm font-medium transition-all duration-150 {{ app()->getLocale() === 'ku' ? 'bg-pink-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            KU
                        </a>
                    </div>

                    <!-- Desktop Auth Buttons -->
                    <div class="hidden sm:flex {{ app()->getLocale() === 'ku' ? 'space-x-reverse' : '' }} space-x-3">
                        @guest
                            <a href="{{ route('login') }}" 
                               class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium transition-colors duration-150">
                                {{ __('messages.login') }}
                            </a>
                            <a href="{{ route('register') }}" 
                               class="bg-pink-600 text-white hover:bg-pink-700 px-4 py-2 rounded-lg text-sm font-medium shadow-md hover:shadow-lg transition-all duration-150 transform hover:scale-105">
                                {{ __('messages.register') }}
                            </a>
                        @else
                            <div class="flex items-center {{ app()->getLocale() === 'ku' ? 'space-x-reverse' : '' }} space-x-3">
                                <span class="text-sm text-gray-700">{{ auth()->user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="text-gray-700 hover:text-red-600 px-3 py-2 text-sm font-medium transition-colors duration-150">
                                        {{ __('messages.logout') }}
                                    </button>
                                </form>
                            </div>
                        @endguest
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            type="button" 
                            class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-pink-600 hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-pink-500 transition-all duration-150"
                            aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" :class="{'hidden': mobileMenuOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" :class="{'block': mobileMenuOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="md:hidden border-t border-gray-200"
             x-cloak>
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-pink-100 text-pink-600' : 'text-gray-700 hover:bg-pink-50 hover:text-pink-600' }} transition-all duration-150">
                    {{ __('messages.home') }}
                </a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-pink-100 text-pink-600' : 'text-gray-700 hover:bg-pink-50 hover:text-pink-600' }} transition-all duration-150">
                            {{ __('messages.dashboard') }}
                        </a>
                        <a href="{{ route('admin.categories.index') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-pink-100 text-pink-600' : 'text-gray-700 hover:bg-pink-50 hover:text-pink-600' }} transition-all duration-150">
                            {{ __('messages.categories') }}
                        </a>
                        <a href="{{ route('admin.products.index') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.products.*') ? 'bg-pink-100 text-pink-600' : 'text-gray-700 hover:bg-pink-50 hover:text-pink-600' }} transition-all duration-150">
                            {{ __('messages.products') }}
                        </a>
                        <a href="{{ route('admin.orders.index') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-pink-100 text-pink-600' : 'text-gray-700 hover:bg-pink-50 hover:text-pink-600' }} transition-all duration-150">
                            {{ __('messages.orders') }}
                        </a>
                    @else
                        <a href="{{ route('customer.orders') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('customer.orders*') ? 'bg-pink-100 text-pink-600' : 'text-gray-700 hover:bg-pink-50 hover:text-pink-600' }} transition-all duration-150">
                            {{ __('messages.my_orders') }}
                        </a>
                        <a href="{{ route('cart.index') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('cart.*') ? 'bg-pink-100 text-pink-600' : 'text-gray-700 hover:bg-pink-50 hover:text-pink-600' }} transition-all duration-150">
                            {{ __('messages.cart') }}
                            @php
                                $cart_count = auth()->user()->cartItems()->count();
                            @endphp
                            @if($cart_count > 0)
                                <span class="inline-block {{ app()->getLocale() === 'ku' ? 'mr-2' : 'ml-2' }} bg-red-500 text-white text-xs font-bold rounded-full px-2 py-0.5">
                                    {{ $cart_count }}
                                </span>
                            @endif
                        </a>
                    @endif
                @endauth
            </div>
            
            <!-- Mobile Auth Section -->
            <div class="pt-4 pb-3 border-t border-gray-200">
                @guest
                    <div class="px-2 space-y-1">
                        <a href="{{ route('login') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-all duration-150">
                            {{ __('messages.login') }}
                        </a>
                        <a href="{{ route('register') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium bg-pink-600 text-white hover:bg-pink-700 transition-all duration-150">
                            {{ __('messages.register') }}
                        </a>
                    </div>
                @else
                    <div class="px-5">
                        <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="mt-3 px-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-150">
                                {{ __('messages.logout') }}
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show"
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg shadow-md p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 {{ app()->getLocale() === 'ku' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-green-500 hover:text-green-700 transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" 
             x-show="show"
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-md p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-500 {{ app()->getLocale() === 'ku' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-red-500 hover:text-red-700 transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <main class="min-h-screen py-6 sm:py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-800 to-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- About -->
                <div>
                    <h3 class="text-lg font-bold mb-4">{{ config('app.name') }}</h3>
                    <p class="text-gray-300 text-sm">{{ __('Beautiful flowers for every occasion. Quality, freshness, and customer satisfaction guaranteed.') }}</p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4">{{ __('Quick Links') }}</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-pink-400 transition-colors duration-150">{{ __('messages.home') }}</a></li>
                        @auth
                            @if(!auth()->user()->isAdmin())
                                <li><a href="{{ route('cart.index') }}" class="text-gray-300 hover:text-pink-400 transition-colors duration-150">{{ __('messages.cart') }}</a></li>
                                <li><a href="{{ route('customer.orders') }}" class="text-gray-300 hover:text-pink-400 transition-colors duration-150">{{ __('messages.my_orders') }}</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-bold mb-4">{{ __('Contact Us') }}</h3>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex items-center {{ app()->getLocale() === 'ku' ? 'space-x-reverse' : '' }} space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>info@flowerstore.com</span>
                        </li>
                        <li class="flex items-center {{ app()->getLocale() === 'ku' ? 'space-x-reverse' : '' }} space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>+964 770 123 4567</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 pt-8 text-center">
                <p class="text-sm text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
                </p>
            </div>
        </div>
    </footer>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>

