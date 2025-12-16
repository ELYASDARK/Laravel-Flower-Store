<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\Language;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', Language::ENGLISH->value);

        // Validate locale
        if (!in_array($locale, Language::values())) {
            $locale = Language::ENGLISH->value;
        }

        app()->setLocale($locale);

        return $next($request);
    }
}


