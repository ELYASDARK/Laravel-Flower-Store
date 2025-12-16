@extends('layouts.app')

@section('title', __('messages.login'))

@section('content')
<div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ __('messages.login') }}</h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('messages.email') }}
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('messages.password') }}
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="remember" 
                           name="remember"
                           class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        {{ __('messages.remember_me') }}
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-pink-600 hover:text-pink-700">
                        {{ __('messages.forgot_password') }}
                    </a>
                @endif
            </div>

            <button type="submit" 
                    class="w-full bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-lg font-semibold">
                {{ __('messages.login') }}
            </button>

            <p class="text-center text-sm text-gray-600">
                {{ __('messages.not_registered') }}
                <a href="{{ route('register') }}" class="text-pink-600 hover:text-pink-700 font-semibold">
                    {{ __('messages.register') }}
                </a>
            </p>
        </form>
    </div>
</div>
@endsection


